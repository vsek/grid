<?php

namespace App\Grid;

/**
 * Description of GridTree
 *
 * @author Vsek
 */
class GridTree extends Grid{
    
    protected $related;
    
    /**
     * Nastavi pocet polozek na stranku
     * @param int $itemsToPage
     */
    public function setItemsToPage($itemsToPage){
        throw new \Exception($this->getPresenter()->translator->translate('admin.grid.paggindDisableForTree'));
    }
    
    public function __construct($related, \Nette\ComponentModel\IContainer $parent = NULL, $name = NULL) {
        parent::__construct($parent, $name);

        $this->templateFile = 'gridTree.latte';
        $this->templateDir = __DIR__;
        $this->related = $related;
    }
    
    public function setModel(\Nette\Database\Table\Selection $model) {
        parent::setModel($model->where('parent_id ?', null));
    }
    
    public function render(){
        $template = $this->getTemplate();
        $template->setFile($this->templateDir . '/' . $this->templateFile);
        $template->setTranslator($this->getPresenter()->translator);

        //upravim model
        if(!is_null($this->order)){
            $this->model->order($this->order . ' ' . $this->orderDir);
            $template->order = $this->order;
            $template->orderDir = $this->orderDir;
        }elseif(!is_null($this->orderDefault)){
            $this->model->order($this->orderDefault . ' ' . $this->orderDirDefault);
            $template->order = $this->orderDefault;
            $template->orderDir = $this->orderDirDefault;
        }else{
            $template->order = null;
            $template->orderDir = null;
        }

        $template->columns = $this->columns;
        $template->model = $this->model;
        $template->menu = $this->menu;
        $template->uniquete = $this->uniquete;
        $template->emptyText = is_null($this->emptyText) ? $this->getPresenter()->translator->translate('admin.grid.noItemFound') : $this->emptyText;
        $template->visualPaginator = $this->visualPaginator;
        $template->ordering = $this->ordering;
        $template->related = $this->related;
        
        $template->render();
    }
}

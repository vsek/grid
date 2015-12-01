<?php

namespace App\Grid;

/**
 * Description of Grid
 *
 * @author Vsek
 * prvni verze
 */
class Grid extends \Nette\Application\UI\Control{
    
    /**
     * Nazev souboru sablony
     * @var String
     */
    protected $templateFile;
    
    /**
     * Adresar s sablonou
     * @var string
     */
    protected $templateDir;
    
    /**
     * Pouzivany model
     * @var Nette\Database\Table\Selection
     */
    protected $model = null;
    
    /**
     * Pole sloupecku
     * @var array of App\Grid\Column
     */
    protected $columns = array();
    
    /**
     * Zpusob razeni
     * @var string
     * @persistent
     */
    public $order = null;
    
    /**
     * Smer razeni
     * @var ASC|DESC
     * @persistent
     */
    public $orderDir = 'ASC';
    
    /**
     *
     * @var \App\VisualPaginator
     */
    protected $visualPaginator = null;
    
    /**
     * Pocet polozek na stranku
     * @var int
     */
    public $itemsToPage = 20;
    
    /**
     * Pole menu
     * @var array of Menu\Menu
     */
    protected $menu = array();
    
    /**
     * Nazev sloupecku, ktery je unikatni
     * @var string
     */
    protected $uniquete = 'id';
    
    /**
     * Text zobrazovany pokud neni nalezena zadna polozka
     * @var string
     */
    protected $emptyText = null;
    
    /**
     * Odkaz do nadrazene komponenty/presenteru pro posun nahoru/dolu
     * @var String
     */
    protected $ordering = null;
    
    public function __construct(\Nette\ComponentModel\IContainer $parent = NULL, $name = NULL) {
        parent::__construct($parent, $name);

        $this->templateFile = 'grid.latte';
        $this->templateDir = __DIR__;
        
        $this->visualPaginator = new \App\VisualPaginator($this, 'vp');
    }
    
    /**
     * Zmeni visual paginator
     * @param \App\VisualPaginator $visualPaginator
     */
    public function setVisualPaginator(\App\VisualPaginator $visualPaginator){
        $this->visualPaginator = $visualPaginator;
    }
    
    /**
     * Nastaveni razeni
     * @param string $orderingLink Odkaz pro posun nahoru/dolu
     */
    public function setOrdering($orderingLink){
        $this->ordering = $orderingLink;
    }
    
    /**
     * Nastavi text, zobrazovany pokud neni nalezena zadna polozka
     * @param string $emptyText
     */
    public function setEmptyText($emptyText){
        $this->emptyText = $emptyText;
    }
    
    /**
     * Nastavi nazev sloupeceku, ktery je unikatni
     * @param string $uniquete
     */
    public function setUniquete($uniquete){
        $this->uniquete = $uniquete;
    }
    
    /**
     *  Vrati nazev sloupecku, ktery je unikatni
     * @return string
     */
    public function getUniquete(){
        return $this->uniquete;
    }
    
    /**
     * Prida polozku menu
     * @param \App\Grid\Menu\Menu $menu
     */
    public function addMenu(Menu\Menu $menu){
        $this->menu[] = $menu;
        $this->addComponent($menu, $menu->getSystemName());
    }
    
    /**
     * Nastavi pocet polozek na stranku
     * @param int $itemsToPage
     */
    public function setItemsToPage($itemsToPage){
        $this->itemsToPage = (int)$itemsToPage;
    }
    
    public function handleSetOrder($newOrder){
        if($this->order == $newOrder){
            if($this->orderDir == 'ASC'){
                $this->orderDir = 'DESC';
            }else{
                $this->orderDir = 'ASC';
            }
        }else{
            $this->setOrder($newOrder);
            $this->orderDir = 'ASC';
        }
        $this->visualPaginator->getPaginator()->setPage(1);
    }
    
    /**
     * Nastavi zpusob razeni
     * @param string $order
     */
    public function setOrder($order){
        $this->order = $order;
    }
    
    /**
     * Nastavi smer razeni
     * @param string $orderDir
     */
    public function setOrderDir($orderDir){
        $this->orderDir = $orderDir;
    }
    
    /**
     * Prida sloupecek k  vykresleni
     * @param \App\Grid\Column\Column $column
     */
    public function addColumn(Column\Column $column){
        $this->columns[] = $column;
    }
    
    /**
     * Nastavi model
     * @param Nette\Database\Table\Selection
     */
    public function setModel(\Nette\Database\Table\Selection $model){
        $this->model = $model;
    }
    
    /**
     * Nastavi nazev souboru s sablonou
     * @param string $templateFile
     */
    public function setTemplateFile($templateFile){
        $this->templateFile = $templateFile;
    }
    
    /**
     * Nastavi adresar s sablonou
     * @param string $templateDir
     */
    public function setTemplateDir($templateDir){
        $this->templateDir = $templateDir;
    }
    
    public function render(){
        $template = $this->getTemplate();
        $template->setFile($this->templateDir . '/' . $this->templateFile);
        $template->setTranslator($this->getPresenter()->translator);

        //upravim model
        if(!is_null($this->order)){
            $this->model->order($this->order . ' ' . $this->orderDir);
        }
        //strankovani
        $this->visualPaginator->getPaginator()->setItemsPerPage($this->itemsToPage);
        $this->visualPaginator->getPaginator()->setItemCount($this->model->count());
        $this->model->limit($this->visualPaginator->getPaginator()->getLength(), $this->visualPaginator->getPaginator()->getOffset());
        $template->columns = $this->columns;
        $template->model = $this->model;
        $template->menu = $this->menu;
        $template->uniquete = $this->uniquete;
        $template->emptyText = is_null($this->emptyText) ? $this->getPresenter()->translator->translate('admin.grid.noItemFound') : $this->emptyText;
        $template->visualPaginator = $this->visualPaginator;
        $template->order = $this->order;
        $template->orderDir = $this->orderDir;
        $template->ordering = $this->ordering;
        
        $template->render();
    }
}

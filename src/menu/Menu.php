<?php

namespace App\Grid\Menu;

/**
 * Description of Menu
 *
 * @author Vsek
 */
class Menu extends \Nette\Application\UI\Control{
    /**
     * Nazev odkazu
     * @var string
     */
    protected $name;
    
    /**
     * Akce do presenteru
     * @var string
     */
    protected $action;
    
    /**
     * Systemovy nazev komponenty, pouziva se pri duplikaci akci
     * @var type string
     */
    protected $systemName = null;
    
    /**
     * Attribut title u odkazu
     * @var string
     */
    protected $title = null;
    
    /**
     * Nastavi attribut title u odkazu
     * @param string $title
     * @return Menu
     */
    public function setTitle($title){
        $this->title = $title;
        return $this;
    }
    
    /**
     * Vraci systemovy nazev komponenty, pouziva se pri duplikaci akci
     * @return string
     */
    public function getSystemName(){
        if(is_null($this->systemName)){
            return $this->action;
        }else{
            return $this->systemName;
        }
    }
    
    /**
     * Nastavi systemovy nazev komponenty, pouziva se pri duplikaci akci
     * @param string $name
     */
    public function setSystemName($name){
        $this->systemName = $name;
    }
    
    public function __construct($action, $name) {
        $this->name = $name;
        $this->action = $action;
    }
    
    /**
     * Nastavi sloupecek, ktery se predava jako parametr
     * @param string $column
     */
    public function setColumn($column){
        $this->column = $column;
    }
    
    /**
     * Vrati odkaz
     * @return string
     */
    public function getName(){
        return $this->name;
    }
    
    /**
     * Vrati akci do presenteru
     * @return string
     */
    public function getAction(){
        return $this->action;
    }
    
    /**
     * Vykresli
     */
    public function render($row){
        $template = $this->template;
        $template->setFile(__DIR__ . '/menu.latte');
        
        $template->action = $this->getAction();
        $template->uniquete = $this->getParent()->getUniquete();
        $template->name = $this->getName();
        $template->row = $row;
        $template->title = $this->title;
        
        if($this->getPresenter()->getUser()->isAllowed($this->getPresenter()->getNameSimple(), $this->getAction())){
            $template->render();
        }
    }
}

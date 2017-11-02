<?php

namespace App\Grid\Column;
use App\Presenters\BasePresenter;
use Nette\Database\Table\ActiveRow;
use Nette\Object;

/**
 * Zakladni sloupecek
 *
 * @author Vsek
 */
class Column extends Object{
    /**
     * Nazev sloupecku
     * @var string
     */
    protected $name;
    
    /**
     * Nazev sloupecku v DB
     * @var string
     */
    protected $column;
    
    /**
     * Urcuje jestli se da podle tohoto sloupecku radit
     * @var boolean
     */
    private $ordering = true;
    
    /**
     *
     * @var BasePresenter
     */
    protected $presenter;

    /**
     * Class co se zobrazuje v sabloně
     * @var null|string
     */
    protected $class = null;

    /**
     * Vrátí třídu co se zobrazuje v šabloně
     * @return null|string
     */
    public function getClass(){
        return $this->class;
    }

    /**
     * Nastaví třídu co se zobrazuje v šabloně
     * @param string $class
     * @return self
     */
    public function setClass(string $class){
        $this->class = $class;
        return $this;
    }
    
    public function setPresenter(BasePresenter $presenter){
        $this->presenter = $presenter;
    }
    
    public function __construct($column, $name) {
        $this->column = $column;
        $this->name = $name;
    }
    
    /**
     * Vrati jestli se da podle tohoto sloupecku radit
     * @return boolean
     */
    public function getOrdering(){
        return $this->ordering;
    }
    
    /**
     * Nastavi jestli se da podle tohoto sloupecku radit
     * @param boolean $ordering
     */
    public function setOrdering($ordering){
        $this->ordering = $ordering;
    }
    
    /**
     * vrati nazev sloupeceku ktery je v DB
     * @return string
     */
    public function getColumn(){
        return $this->column;
    }
    
    /**
     * Vrati nazev sloupecku
     * @return string
     */
    public function getName(){
        return $this->name;
    }
    
    /**
     * Nastavi sloupecek
     * @param string $column
     */
    public function setColumn($column){
        $this->column = $column;
    }
    
    /**
     * Nastavi nazev sloupecku
     * @param string $name
     */
    public function setName($name){
        $this->name = $name;
    }
    
    /**
     * Vrati hodnotu z tabulky
     * @param ActiveRow $query
     * @return string
     */
    public function output(ActiveRow $query){
        $column = $this->column;
        return $query->$column;
    }
}

<?php

namespace App\Grid\Column;

/**
 * Zakladni sloupecek
 *
 * @author Vsek
 */
class Column extends \Nette\Object{
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
     * @param Nette\Database\Table\ActiveRow $query
     * @return string
     */
    public function output(\Nette\Database\Table\ActiveRow $query){
        $column = $this->column;
        return $query->$column;
    }
}

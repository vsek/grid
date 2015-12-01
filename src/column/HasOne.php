<?php

namespace App\Grid\Column;

/**
 * Description of HasOne
 *
 * @author Vsek
 */
class HasOne extends Column{
    protected $table;
    
    public function __construct($column, $name, $table) {
        parent::__construct($column, $name);
        $this->table = $table;
        $this->setOrdering(false);
    }
    
    /**
     * Vrati hodnotu z tabulky
     * @param Nette\Database\Table\ActiveRow $query
     * @return string
     */
    public function output(\Nette\Database\Table\ActiveRow $query){
        $column = $this->column;
        $table = $this->table;
        if($query->$table){
            return $query->$table->$column;
        }else{
            return '';
        }
    }
}

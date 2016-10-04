<?php

namespace App\Grid\Column;

/**
 * Description of HasOne
 *
 * @author Vsek
 */
class HasOne extends Column{
    protected $table;
    
    /**
     * 
     * @param string $column nazev sloupecku
     * @param string $name popis slopecku
     * @param string|array $table tabulka relace, pokud je pole prochazi se postupne
     */
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
        if(!is_array($table)){
            if($query->$table){
                return $query->$table->$column;
            }else{
                return '';
            }
        }else{
            foreach($table as $tab){
                $query = $query->ref($tab);
                if(!$query){
                    return '';
                }
            }
            return $query->$column;
        }
    }
}

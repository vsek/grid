<?php

namespace App\Grid\Column;

/**
 * Description of HasMany
 *
 * @author Vsek
 */
class HasMany extends Column{
    
    private $related;
    private $separator;
    private $table;
    
    public function __construct($column, $name, $related, $table = null, $separator = ', ') {
        parent::__construct($column, $name);
        $this->related = $related;
        $this->separator = $separator;
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
        
        $output = array();
        foreach($query->related($this->related) as $row){
            if(!is_null($this->table)){
                $table = $this->table;
                $output[] = $row->$table->$column;
            }else{
                $output[] = $row->$column;
            }
        }
        
        return implode($this->separator, $output);
    }
}

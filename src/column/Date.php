<?php

namespace App\Grid\Column;

/**
 * Description of Date
 *
 * @author Vsek
 */
class Date extends Column{
    
    protected $format;
    
    public function __construct($column, $name, $format = 'j.n.Y') {
        parent::__construct($column, $name);
        
        $this->format = $format;
    }
    
    /**
     * Vrati hodnotu z tabulky
     * @param Nette\Database\Table\ActiveRow $query
     * @return string
     */
    public function output(\Nette\Database\Table\ActiveRow $query){
        $value = parent::output($query);

        if(!is_null($value)){
            $date = new \Nette\Utils\DateTime($value);
            return date($date->format($this->format));
        }else{
            return '';
        }
    }
}

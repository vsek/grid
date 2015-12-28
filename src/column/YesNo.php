<?php

namespace App\Grid\Column;

/**
 * Description of YesNo
 *
 * @author Vsek
 */
class YesNo extends Column{
    /**
     * Vrati hodnotu z tabulky
     * @param Nette\Database\Table\ActiveRow $query
     * @return string
     */
    public function output(\Nette\Database\Table\ActiveRow $query){
        $column = $this->column;
        if($query->$column === 'yes' || $query->$column === 1){
            return 'Ano';
        }else{
            return 'Ne';
        }
    }
}

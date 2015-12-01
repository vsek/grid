<?php

namespace App\Grid\Column;

/**
 * Description of HasManyPermission
 *
 * @author vsek
 */
class HasManyPermission extends Column{
    private $roleId;
    
    public function __construct($column, $name, $roleId) {
        parent::__construct($column, $name);
        $this->roleId = $roleId;
        $this->setOrdering(false);
    }
    
    public function output(\Nette\Database\Table\ActiveRow $query) {
        $output = array();
        foreach($query->related('permission')->where('role_id', $this->roleId) as $permission){
            $output[] = $permission->privilege['name'];
        }
        return implode(', ', $output);
    }
}

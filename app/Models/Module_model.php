<?php namespace App\Models;

use CodeIgniter\Model;

class Module_model extends Model{
    public function getCode($module){
        return $this->db->table('module_references')
                    ->where([
                        'context' => $module['context'],
                        'routine' => $module['routine'],
                        'field' => $module['field'] 
                    ])
                    ->get()->getRowArray();
    }
}
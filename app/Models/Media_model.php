<?php namespace App\Models;

use CodeIgniter\Model;

class Media_model extends Model{
    
    public function addReference($data,$module,$referrer){
        $table = $module['context'].'_'.$module['routine'];
        
        $this->db->transStart();
        
        $this->db->table('media_references')->insert($data);
        $lastId = $this->db->insertId();
        $ref = [
            $module['field'] => $lastId
        ];
        $this->db->table($table)->update($ref,$referrer);

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    public function getReference($id){
        return $this->db->table('media_references')
                            ->where('id',$id)
                            ->get()
                            ->getRowArray();

    }
}

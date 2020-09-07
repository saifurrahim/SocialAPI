<?php namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model{

    public function addAccount($data){
        $insert = $this->db->table('user_accounts')->insert($data);

        return $insert ? true : false;
    }

    public function getAccount($username = false){

        if($username){
                
            $account = $this->db->table('user_accounts')
            ->where('username',$username)
            ->get()->getRowArray();

        }else{

            $account = $this->db->table('user_accounts')
            ->get()->getResultArray();
        }

        return $account;
    }

    public function addProfile($data){
        $insert = $this->db->table('user_profiles')->insert($data);

        return $insert ? true : false;
    }

    public function getProfile($account_id = false){

        if($account_id){

            $profile = $this->db->table('user_profiles')
            ->where('account_id',$account_id)
            ->get()->getRowArray();
        }else{

            $profile = $this->db->table('user_profiles')
            ->get()->getResultArray();
        }
        
        return $profile;
    }

}
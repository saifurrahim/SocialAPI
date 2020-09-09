<?php namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model{

    public function addAccount($data){

        $this->db->transStart();
        $this->db->table('user_accounts')->insert($data);
        $account = $this->getAccount($data['username']);
        $profile = array(
            'account_id' => $account['id'],
            'media_folder' => $account['username']
        );
        $this->db->table('user_profiles')->insert($profile);
        $this->db->transComplete();

        return $this->db->transStatus();
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

    public function updateAccount($data,$id){
        return $this->db->table('user_accounts')->update($data,['id' => $id]);
    }

    public function deleteAccount($id){
        return $this->db->table('user_accounts')->delete(['id' => $id]);
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

    public function updateProfile($data,$account_id){
        return $this->db->table('user_profiles')->update($data,['account_id' => $account_id]);
    }

    public function deleteProfile($account_id){
        return $this->db->table('user_profiles')->delete(['account_id' => $account_id]);
    }

}
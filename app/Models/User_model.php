<?php namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model{

// ACCOUNT
    public function addAccount($data){

        $this->db->transStart();
        $this->db->table('user_accounts')->insert($data);
        $account = $this->getAccount($data['username']);
        $profile = array(
            'account_id' => $account['id'],
            'media_folder' => $account['username'].'/'.$account['id'].'/'
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

    public function blockAccount($id){
        return $this->db->table('user_accounts')->update(['is_blocked' => 1],['id' => $id]);
    }

    public function unblockAccount($id){
        return $this->db->table('user_accounts')->update(['is_blocked' => 0],['id' => $id]);
    }

// PROFILE
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

}
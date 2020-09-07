<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder{
    public function run(){
        $data = [
            [
                'username' => 'saifurrahim',
                'password' => password_hash('C0b4d1b4c4',PASSWORD_BCRYPT)
            ],
            //[...]
        ];

        $this->db->table('user_accounts')->insertBatch($data);
    }
}
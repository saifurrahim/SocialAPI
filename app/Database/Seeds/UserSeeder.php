<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder{
    public function run(){
        $data = [
            [
                'username' => 'saifurrahim',
                'password' => '$2y$10$zFz4cB7wZLpT9dqR10/2QOIoQAi76vvahPNnmwIbmNucPZ7gjH7Ea'
            ],
            [
                'username' => 'admin',
                'password' => password_hash('admin',PASSWORD_BCRYPT)
            ]
            //[...]
        ];

        $this->db->table('user_accounts')->insertBatch($data);
    }
}
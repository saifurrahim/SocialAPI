<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ModuleSeeder extends Seeder{
    public function run(){
        $data = [
            [
                'context' => 'USER',
                'routine' => 'PROFILES',
                'field' => 'media_picture',
                'code' => 'user_profiles_picture',
                'description' => 'User profile picture image references'
            ],
            [
                'context' => 'USER',
                'routine' => 'PROFILES',
                'field' => 'media_banner',
                'code' => 'user_profiles_banner',
                'description' => 'User profile banner image references'
            ]
            //[...]
        ];

        $this->db->table('module_references')->insertBatch($data);
    }
}
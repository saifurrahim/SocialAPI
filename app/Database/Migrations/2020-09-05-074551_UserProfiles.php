<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserProfiles extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'account_id' => [
				'type' => 'BIGINT',
				'constraint' => '20',
				'unsigned' => TRUE,
				'null' => FALSE
			],
			'full_name' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE
			],
			'birth_date' => [
				'type' => 'DATE',
				'null' => TRUE
			],
			'gender' => [
				'type' => 'ENUM',
				'constraint' => "'m','f'",
				'null' => TRUE
			],
			'religion' => [
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			],
			'job' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE
			],
			'address' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => TRUE
			],
			'province' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => TRUE
			],
			'district' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => TRUE
			],
			'sub_district' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => TRUE
			],
			'village' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => TRUE
			],
			'media_folder' => [
				'type' => 'VARCHAR',
				'constraint' => '30'
			],
			'media_profile_picture' => [
				'type' => 'BIGINT',
				'constraint' => '20',
				'unsigned' => TRUE,
				'null' => TRUE
			],
			'media_profile_banner' => [
				'type' => 'BIGINT',
				'constraint' => '20',
				'unsigned' => TRUE,
				'null' => TRUE
			],
			'follower_count'	=> [
				'type'				=> 'INT',
				'constraint'		=> '11',
				'unsigned'			=> TRUE,
				'default'			=> '0'
			],
			'following_count'	=> [
				'type'				=> 'INT',
				'constraint'		=> '11',
				'unsigned'			=> TRUE,
				'default'			=> '0'
			]
		]);

		$this->forge->addKey('account_id',TRUE);
		$this->forge->addForeignKey('account_id','user_accounts','id','CASCADE','CASCADE');
		$this->forge->createTable('user_profiles');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('user_profiles');
	}
}

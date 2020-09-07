<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserAccounts extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'BIGINT',
				'constraint' => '20',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			],
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => '30'
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => '60'
			],
			'is_blocked' => [
				'type' => 'BOOLEAN',
				'default' => FALSE
			],
			'register_date datetime default current_timestamp'
		]);

		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('user_accounts');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('user_accounts');
	}
}

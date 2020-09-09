<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserFollowers extends Migration
{
	public function up()
	{

		$this->db->disableForeignKeyChecks();

		$this->forge->addField([
			'account_id' => [
				'type' => 'BIGINT',
				'constraint' => '20',
				'unsigned' => TRUE,
				'null' => FALSE
			],
			'follower_id' => [
				'type' => 'BIGINT',
				'constraint' => '20',
				'unsigned' => TRUE,
				'null' => FALSE
			],
			'register_date datetime default current_timestamp'
		]);

		$this->forge->addKey(array('account_id','follower_id'),TRUE);
		$this->forge->addForeignKey('account_id','user_accounts','id','CASCADE','CASCADE');
		$this->forge->addForeignKey('follower_id','user_accounts','id','CASCADE','CASCADE');
		$this->forge->createTable('user_followers');

		$this->db->enableForeignKeyChecks();
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('user_followers');
	}
}

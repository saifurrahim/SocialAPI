<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModuleReferences extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'context' => [
				'type' => 'VARCHAR',
				'constraint' => '50'
			],
			'routine' => [
				'type' => 'VARCHAR',
				'constraint' => '50'
			],
			'field' => [
				'type' => 'VARCHAR',
				'constraint' => '50'
			],
			'code' => [
				'type' => 'VARCHAR',
				'constraint' => '50'
			],
			'description' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'register_date datetime default current_timestamp'
		]);

		$this->forge->addKey('code',TRUE);
		$this->forge->createTable('module_references');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('module_references');
	}
}

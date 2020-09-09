<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MediaReferences extends Migration
{
	public function up()
	{

		$this->db->disableForeignKeyChecks();

		$this->forge->addField([
			'id'			=>[
				'type'				=> 'BIGINT',
				'constraint'		=> '20',
				'unsigned'			=> TRUE,
				'auto_increment'	=> TRUE
			],
			'module_code' =>[
				'type' => 'VARCHAR',
				'constraint' => "50",
			],
			'name'		=>[
				'type'				=> 'VARCHAR',
				'constraint'		=> '100'
			],
			'extension'	=>[
				'type'				=> 'VARCHAR',
				'constraint'		=> '10'
			],
			'location'	=>[
				'type'				=> 'TEXT'
			],
			'size'		=>[
				'type'				=> 'INT',
				'constraint'		=> '10',
				'unsigned'			=> TRUE
			],
			'is_blocked'		=>[
				'type'				=> 'BOOLEAN',
				'default'			=> FALSE
			],
			'register_date datetime default current_timestamp'
		]);

		$this->forge->addKey('id',TRUE);
		$this->forge->addForeignKey('module_code','module_references','code');
		$this->forge->createTable('media_references');

		$this->db->enableForeignKeyChecks();
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('media_references');
	}
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExplotaciones extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'auto_increment' => true],
            'parcela_id'        => ['type' => 'INT'],
            'tipo_actividad'    => ['type' => 'ENUM', 'constraint' => ['agricola', 'ganadera', 'mixta']],
            'cultivo_principal' => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'tipo_ganado'       => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'cantidad_animales' => ['type' => 'INT', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('parcela_id', 'parcelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('explotaciones');
    }

    public function down()
    {
        $this->forge->dropTable('explotaciones');
    }
}

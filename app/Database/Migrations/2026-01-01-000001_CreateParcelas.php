<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateParcelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'auto_increment' => true],
            'nro_catastro'      => ['type' => 'VARCHAR', 'constraint' => 30],
            'latitud'           => ['type' => 'DECIMAL', 'constraint' => '10,7'],
            'longitud'          => ['type' => 'DECIMAL', 'constraint' => '10,7'],
            'superficie_ha'     => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'propietario'       => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'cuartel'           => ['type' => 'VARCHAR', 'constraint' => 10],
            'anio_relevamiento' => ['type' => 'INT', 'constraint' => 4],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('anio_relevamiento');
        $this->forge->createTable('parcelas');
    }

    public function down()
    {
        $this->forge->dropTable('parcelas');
    }
}

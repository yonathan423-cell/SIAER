<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermisosInspecciones extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'auto_increment' => true],
            'parcela_id'    => ['type' => 'INT'],
            'tipo'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'estado'        => ['type' => 'ENUM', 'constraint' => ['pendiente', 'aprobado', 'rechazado', 'vencido']],
            'fecha'         => ['type' => 'DATE'],
            'observaciones' => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('parcela_id', 'parcelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('permisos_inspecciones');
    }

    public function down()
    {
        $this->forge->dropTable('permisos_inspecciones');
    }
}

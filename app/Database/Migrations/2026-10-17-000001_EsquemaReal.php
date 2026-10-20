<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

/**
 * Esquema real de siaer_db. Usa "IF NOT EXISTS": si las tablas ya existen
 * (por ejemplo, al importar el .sql), no modifica nada.
 */
class EsquemaReal extends Migration
{
    public function up()
    {
        $id = ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true];

        // usuarios
        $this->forge->addField([
            'id'         => $id,
            'nombre'     => ['type' => 'VARCHAR', 'constraint' => 150],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'contrasena' => ['type' => 'VARCHAR', 'constraint' => 255],
            'rol'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('usuarios', true);

        // parcelas
        $this->forge->addField([
            'id'                => $id,
            'n_catastro'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'longitud'          => ['type' => 'DECIMAL', 'constraint' => '10,6', 'null' => true],
            'latitud'           => ['type' => 'DECIMAL', 'constraint' => '10,6', 'null' => true],
            'superficie'        => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'cuartel'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'propietario'       => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'anio_relevamiento' => ['type' => 'INT', 'constraint' => 4, 'null' => true],
            'actividad'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('parcelas', true);

        // explotaciones (una por parcela)
        $this->forge->addField([
            'id'                 => $id,
            'id_parcelas'        => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'tipo_de_actividad'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'cultivo'            => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'otro_tipo_ganadero' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'cant_de_animales'   => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('id_parcelas');
        $this->forge->addForeignKey('id_parcelas', 'parcelas', 'id', 'CASCADE', 'CASCADE', 'fk_explotaciones_parcela');
        $this->forge->createTable('explotaciones', true);

        // permisos
        $this->forge->addField([
            'id'            => $id,
            'id_parcelas'   => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'tipo'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'estado'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'fecha'         => ['type' => 'DATE', 'null' => true],
            'observaciones' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('id_parcelas');
        $this->forge->createTable('permisos', true);

        // tambos
        $this->forge->addField([
            'id'        => $id,
            'productor' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'latitud'   => ['type' => 'DECIMAL', 'constraint' => '10,6', 'null' => true],
            'longitud'  => ['type' => 'DECIMAL', 'constraint' => '10,6', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tambos', true);

        // audit_logs
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'usuario_id'    => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'tabla'         => ['type' => 'VARCHAR', 'constraint' => 50],
            'registro_id'   => ['type' => 'INT', 'constraint' => 11],
            'accion'        => ['type' => 'VARCHAR', 'constraint' => 20],
            'datos_previos' => ['type' => 'LONGTEXT', 'null' => true],
            'datos_nuevos'  => ['type' => 'LONGTEXT', 'null' => true],
            'ip_address'    => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('audit_logs', true);
    }

    public function down()
    {
        foreach (['audit_logs', 'tambos', 'permisos', 'explotaciones', 'parcelas', 'usuarios'] as $t) {
            $this->forge->dropTable($t, true);
        }
    }
}

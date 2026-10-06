<?php

namespace App\Libraries;

use Config\Database;
use Config\Services;

class AuditLogger
{
    /**
     * Registra un cambio en la tabla audit_logs de la base de datos.
     */
    public static function log(string $tabla, int $registroId, string $accion, ?array $datosPrevios = null, ?array $datosNuevos = null, ?int $usuarioId = null)
    {
        $db = Database::connect();
        $request = Services::request();
        $session = session();

        // Obtiene el ID del usuario en sesión
        $idUsuario = $usuarioId ?? $session->get('usuario_id') ?? $session->get('user_id');

        $db->table('audit_logs')->insert([
            'usuario_id'    => $idUsuario,
            'tabla'         => $tabla,
            'registro_id'   => $registroId,
            'accion'        => strtoupper($accion),
            'datos_previos' => $datosPrevios ? json_encode($datosPrevios, JSON_UNESCAPED_UNICODE) : null,
            'datos_nuevos'  => $datosNuevos ? json_encode($datosNuevos, JSON_UNESCAPED_UNICODE) : null,
            'ip_address'    => $request->getIPAddress(),
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}
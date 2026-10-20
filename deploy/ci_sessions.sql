-- Tabla de sesiones de CodeIgniter 4 (necesaria cuando SESSION_DRIVER=database).
-- Ejecutar una vez en la base de datos de Aiven (defaultdb), después de importar siaer_db.sql.
CREATE TABLE IF NOT EXISTS `ci_sessions` (
    `id` varchar(128) NOT NULL,
    `ip_address` varchar(45) NOT NULL,
    `timestamp` timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `data` blob NOT NULL,
    PRIMARY KEY (`id`),
    KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

<?php

namespace App\Models;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
        private static ?PDO $instance = null;

        public static function getConnection(): PDO
        {
                if (self::$instance === null) {
                        $host = 'localhost';
                        $port = 3307;
                        $db = 'db_estacionamento';
                        $user = 'root';
                        $pass = '';
                        $charset = 'utf8mb4';


                        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
                        $options = [
                                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                                PDO::ATTR_EMULATE_PREPARES   => false,
                        ];

                        try {
                                self::$instance = new PDO($dsn, $user, $pass, $options);
                        } catch (PDOException $e) {
                                error_log(sprintf(
                                        "[Database Error] Falha de conexão: %s em %s na linha %d",
                                        $e->getMessage(),
                                        $e->getFile(),
                                        $e->getLine()
                                ));
                                throw new RuntimeException("Erro de conexão com o banco de dados.");
                        }
                }
                return self::$instance;
        }
}

<?php 

namespace App\Models;

use PDO;
use PDOException;

class database
{
        private static ?PDO $instance = null;

        public static function getConnection(): PDO
        {
                if (self::$instance === null) {
                        $host = 'localhost';
                        $db = 'estacionamento';
                        $user = 'root';
                        $pass = '';
                        $charset = 'utf8mb4';

                        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
                        $options = [
                                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                                PDO::ATTR_EMULATE_PREPARES   => false,
                                ];

                                try {
                                        echo "Sucesso";
                                        self::$instance = new PDO ($dsn, $user, $pass, $options);
                                }
                                catch (PDOException $e) {
                                        exit('Erro dfe conexão:'. $e->getMessage());
                                }
                }
                return self::$instance;
        }
}

?>
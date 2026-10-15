<?php

// 1. Inclua o arquivo database.php (ajuste o caminho se necessário)
require_once 'app/Models/database.php';

// 2. Use o namespace correto da sua classe
use App\Models\database;

try {
        echo "Tentando conectar... <br>";

        // 3. Chama o método estático que você criou
        $conexao = database::getConnection();

        if ($conexao instanceof \PDO) {
                echo "<br>Conexão com o banco de dados 'estacionamento' foi testada e aprovada!";
        }
} catch (\Exception $e) {
        echo "<br>Erro inesperado no teste: " . $e->getMessage();
}

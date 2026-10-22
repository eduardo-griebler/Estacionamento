<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

// Somente permitir requisições POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido.');
}

// Receber o ID da movimentação
$id_movimentacao = filter_input(
    INPUT_POST,
    'id_movimentacao',
    FILTER_VALIDATE_INT
);

if (!$id_movimentacao || $id_movimentacao <= 0) {
    exit('Movimentação inválida.');
}

// Valor por hora (exemplo)
$valorHora = 4.50;

// Instanciar o Model
$movimentacao = new \App\Models\MovimentacaoModel();

// Registrar a saída
$resultado = $movimentacao->registrarSaida(
    $id_movimentacao,
    $valorHora
);

if ($resultado) {
    header('Location: ../../../public/index.php?saida=sucesso');
    exit;
}

header('Location: ../../../public/index.php?saida=erro');
exit;

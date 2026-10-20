<?php

namespace App\Views\Patio; // Ajustado o namespace para refletir que é uma View

use App\Models\VeiculoModel;

// SÓ EXECUTA SE O FORMULÁRIO FOR ENVIADO (O botão "acao" foi clicado)
if (isset($_POST['acao'])) {

        // Captura os dados usando o operador ?? para evitar qualquer "Undefined array key"
        $placa  = $_POST['placa'] ?? '';
        $modelo = $_POST['modelo'] ?? '';
        $tipo   = $_POST['tipo'] ?? '';

        // Valida se nenhum campo está vazio
        if (!empty($placa) && !empty($modelo) && !empty($tipo)) {

                // Instancia o Model corretamente
                $novo_veiculo = new VeiculoModel();

                // Executa o cadastro enviando as strings validadas
                $novo_veiculo->cadastrarVeiculo($placa, $modelo, $tipo);

        }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastrar Veículo</title>
</head>

<body>
        <br>
        <h1>Cadastrar veículo</h1>
        <br>
        <form action="" method="post">
                <label for="placa">Placa: </label>
                <input type="text" name="placa" id="placa" required>
                <br><br>
                <label for="modelo">Modelo: </label>
                <input type="text" name="modelo" id="modelo" required>
                <br><br>
                <label for="tipo">Tipo: </label>
                <select name="tipo" id="tipo" required>
                        <option value="Carro">Carro</option>
                        <option value="Moto">Moto</option>
                </select>
                <br><br>

                <button type="submit" name="acao">Cadastrar veículo</button>
                <br><br>
        </form>
</body>

</html>
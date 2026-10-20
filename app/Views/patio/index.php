<?php

/** @var array $veiculosEstacionados */
/** @var array $veiculosCadastrados */

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Estacionamento</title>
</head>

<body>

        <h1>Estacionamento</h1>
        <?php if (isset($mensagemErro)): ?>
                <p style="color: red;">
                        <?= htmlspecialchars($mensagemErro) ?>
                </p>
        <?php endif; ?>

        <?php if (($_GET['entrada'] ?? '') === 'sucesso'): ?>
                <p style="color: green;">
                        Entrada do veículo registrada com sucesso!
                </p>
        <?php endif; ?>

        <!-- VEÍCULOS NO PÁTIO -->

        <h2>Veículos no pátio: <?= count($veiculosEstacionados) ?></h2>

        <?php if (empty($veiculosEstacionados)): ?>

                <p>Nenhum veículo estacionado no momento.</p>

        <?php else: ?>

                <table border="1" cellpadding="8">
                        <thead>
                                <tr>
                                        <th>ID</th>
                                        <th>Placa</th>
                                        <th>Modelo</th>
                                        <th>Tipo</th>
                                        <th>Entrada</th>
                                        <th>Horas decorridas</th>
                                </tr>
                        </thead>

                        <tbody>
                                <?php foreach ($veiculosEstacionados as $veiculo): ?>
                                        <tr>
                                                <td><?= (int) $veiculo['movimentacao_id'] ?></td>
                                                <td><?= htmlspecialchars($veiculo['placa']) ?></td>
                                                <td><?= htmlspecialchars($veiculo['modelo']) ?></td>
                                                <td><?= htmlspecialchars($veiculo['tipo']) ?></td>
                                                <td><?= htmlspecialchars($veiculo['data_entrada_formatada']) ?></td>
                                                <td><?= htmlspecialchars((string) $veiculo['hora_decorridas']) ?></td>
                                        </tr>
                                <?php endforeach; ?>
                        </tbody>
                </table>

        <?php endif; ?>


        <!-- VEÍCULOS CADASTRADOS -->

        <h2>Veículos cadastrados</h2>

        <?php if (empty($veiculosCadastrados)): ?>

                <p>Nenhum veículo cadastrado.</p>

        <?php else: ?>

                <table border="1" cellpadding="10">
                        <thead>
                                <tr>
                                        <th>ID</th>
                                        <th>Placa</th>
                                        <th>Modelo</th>
                                        <th>Tipo</th>
                                        <th>Ação</th>
                                </tr>
                        </thead>

                        <tbody>
                                <?php foreach ($veiculosCadastrados as $veiculo): ?>
                                        <tr>
                                                <td><?= (int) $veiculo['id'] ?></td>
                                                <td><?= htmlspecialchars($veiculo['placa']) ?></td>
                                                <td><?= htmlspecialchars($veiculo['modelo']) ?></td>
                                                <td><?= htmlspecialchars($veiculo['tipo']) ?></td>
                                                <td>
                                                        <form method="post">
                                                                <input type="hidden" name="veiculo_id" value="<?= (int) $veiculo['id'] ?>">
                                                                <button type="submit" name="acao" value="registrar_entrada">
                                                                        Registrar entrada
                                                                </button>
                                                        </form>
                                                </td>
                                        </tr>
                                <?php endforeach; ?>
                        </tbody>
                </table>

        <?php endif; ?>

</body>

</html>
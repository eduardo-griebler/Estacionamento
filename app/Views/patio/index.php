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
        <link rel="stylesheet" href="../app/Views/style.css">
</head>

<body>
        <h1>Estacionamento</h1>

        <!-- As duas colunas incluem o formulário e as tabelas -->
        <div class="grid-container">
                <div class="esquerda">
                        <?php require __DIR__ . '/entrada.php'; ?>

                        <?php if (isset($mensagemErro)): ?>
                                <p style="color: red;">
                                        <?= htmlspecialchars($mensagemErro) ?>
                                </p>
                        <?php endif; ?>

                        <?php if (($_GET['cadastro'] ?? '') === 'sucesso'): ?>
                                <p style="color: green;">
                                        Veículo cadastrado com sucesso!
                                </p>
                        <?php endif; ?>

                        <?php if (($_GET['cadastro'] ?? '') === 'duplicado'): ?>
                                <p style="color: red;">
                                        Esta placa já está cadastrada no sistema.
                                </p>
                        <?php endif; ?>

                        <?php if (($_GET['cadastro'] ?? '') === 'erro'): ?>
                                <p style="color: red;">
                                        Não foi possível cadastrar o veículo.
                                </p>
                        <?php endif; ?>

                        <?php if (
                                $_SERVER['REQUEST_METHOD'] !== 'POST' &&
                                ($_GET['entrada'] ?? '') === 'sucesso'
                        ): ?>
                                <p style="color: green;">
                                        Entrada do veículo registrada com sucesso!
                                </p>
                        <?php endif; ?>

                        <?php if (($_GET['saida'] ?? '') === 'sucesso'): ?>
                                <p style="color: green;">
                                        Saída do veículo registrada com sucesso!
                                </p>
                        <?php endif; ?>

                        <!-- VEÍCULOS NO PÁTIO -->
                        <h2>Veículos no pátio: <?= count($veiculosEstacionados) ?></h2>

                        <?php if (empty($veiculosEstacionados)): ?>
                                <p>Nenhum veículo estacionado no momento.</p>
                        <?php else: ?>
                                <table border="1" cellpadding="8" class="tabela">
                                        <thead>
                                                <tr>
                                                        <th>ID</th>
                                                        <th>Placa</th>
                                                        <th>Modelo</th>
                                                        <th>Tipo</th>
                                                        <th>Entrada</th>
                                                        <th>Horas decorridas</th>
                                                        <th>Valor atual (R$)</th>
                                                        <th>Ação</th>
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

                                                                <td>
                                                                        <?php
                                                                        $totalMinutos = (int) round((float) $veiculo['hora_decorridas'] * 60);

                                                                        $horas = intdiv($totalMinutos, 60);
                                                                        $minutos = $totalMinutos % 60;

                                                                        echo sprintf('%02d:%02d', $horas, $minutos);
                                                                        ?>
                                                                </td>


                                                                <td
                                                                        class="valor-atual"
                                                                        data-entrada="<?= htmlspecialchars((string) ($veiculo['data_entrada'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                                                                        R$ <?= number_format(
                                                                                        max(1, ceil((float) $veiculo['hora_decorridas'])) * 4.5,
                                                                                        2,
                                                                                        ',',
                                                                                        '.'
                                                                                ) ?>
                                                                </td>



                                                                <td>
                                                                        <form method="post">
                                                                                <input type="hidden" name="id_movimentacao" value="<?= (int) $veiculo['movimentacao_id'] ?>">
                                                                                <button type="submit" name="acao" value="registrar_saida" class="button">
                                                                                        Registrar saída
                                                                                </button>
                                                                        </form>
                                                                </td>
                                                        </tr>
                                                <?php endforeach; ?>
                                        </tbody>
                                </table>
                        <?php endif; ?>
                </div>

                <div class="direita">
                        <!-- VEÍCULOS CADASTRADOS -->
                        <h2>Veículos cadastrados</h2>

                        <?php if (empty($veiculosCadastrados)): ?>
                                <p>Nenhum veículo cadastrado.</p>
                        <?php else: ?>
                                <table border="1" cellpadding="10" class="tabela">
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
                                                                                <button type="submit" name="acao" value="registrar_entrada" class="button">
                                                                                        Registrar entrada
                                                                                </button>
                                                                        </form>
                                                                </td>
                                                        </tr>
                                                <?php endforeach; ?>
                                        </tbody>
                                </table>
                        <?php endif; ?>
                </div>
        </div>
        <script src="js/estacionamento.js"></script>
</body>

</html>
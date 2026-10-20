<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Estacionamento</title>
</head>

<body>
        <h1>Estacionamento</h1>
        <p>Veículos no pátio: <?= count($veiculosEstacionados) ?></p>
        <?php if (empty($veiculosEstacionados)): ?>
                <p>Nenhum veículo estacionado no momento.</p>
        <?php else: ?>
                <table>
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
                                                <td><?= htmlspecialchars($veiculo['hora_decorridas']) ?></td>
                                        </tr>
                                <?php endforeach; ?>
                        </tbody>
                </table>
        <?php endif; ?>
</body>

</html>
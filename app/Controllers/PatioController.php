<?php

namespace App\Controllers;

use App\Models\MovimentacaoModel;
use App\Models\VeiculoModel;


class PatioController
{
        public function index(): void
        {
                if (
                        $_SERVER['REQUEST_METHOD'] === 'POST' &&
                        ($_POST['acao'] ?? '') === 'registrar_entrada'
                ) {

                        $veiculoId = filter_input(
                                INPUT_POST,
                                'veiculo_id',
                                FILTER_VALIDATE_INT
                        );


                        if ($veiculoId === false || $veiculoId === null || $veiculoId <= 0) {
                                exit("ID do veículo inválido.");
                        }

                        try {
                                $movimentacaoModel = new MovimentacaoModel();

                                $registrou = $movimentacaoModel->registrarEntrada($veiculoId);

                                if (!$registrou) {
                                        throw new \RuntimeException("Falha ao registrar entrada.");
                                }

                                header("Location: index.php?entrada=sucesso");
                                exit;
                        } catch (\Exception $e) {
                                error_log($e->getMessage());
                                $mensagemErro = $e->getMessage();
                        }
                }

                // Busca os veículos cadastrados
                $veiculoModel = new VeiculoModel();
                $veiculosCadastrados = $veiculoModel->listarCadastrados();
                $movimentacaoModel = new MovimentacaoModel();
                $veiculosEstacionados = $movimentacaoModel->listarEstacionados();

                require __DIR__ . '/../Views/patio/index.php';
        }

        public function entrada(): void
        {
                $veiculo = new VeiculoModel();
                require __DIR__ . '/../Views/patio/entrada.php';
        }
}

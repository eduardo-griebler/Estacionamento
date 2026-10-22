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

                if (
                        $_SERVER['REQUEST_METHOD'] === 'POST' &&
                        ($_POST['acao'] ?? '') === 'registrar_saida'
                ) {

                        $id_movimentacao = filter_input(
                                INPUT_POST,
                                'id_movimentacao',
                                FILTER_VALIDATE_INT
                        );

                        if (
                                $id_movimentacao === false || $id_movimentacao === null || $id_movimentacao <= 0
                        ) {
                                exit("ID da movimentação inválido.");
                        }

                        try {
                                $movimentacaoModel = new MovimentacaoModel();

                                $valorHora = 10;

                                $registrou = $movimentacaoModel->registrarSaida(
                                        $id_movimentacao,
                                        $valorHora
                                );

                                if (!$registrou) {
                                        throw new \RuntimeException(
                                                "Falha ao registrar saída."
                                        );
                                }

                                header("Location: index.php?saida=sucesso");
                                exit;
                        } catch (\Exception $e) {
                                error_log($e->getMessage());
                                $mensagemErro = "Não foi possível registrar a saída.";
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


                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $placa = $_POST['placa'] ?? '';
                        $modelo = $_POST['modelo'] ?? '';
                        $tipo = $_POST['tipo'] ?? '';

                        if (!empty($placa) && !empty($modelo) && !empty($tipo)) {

                                // Executa o cadastro enviando as strings validadas

                                $resultado = $veiculo->cadastrarVeiculo($placa, $modelo, $tipo);

                                if ($resultado === true) {
                                        header('Location: index.php?cadastro=sucesso');
                                        exit;
                                } else {
                                        header('Location: index.php?cadastro=erro');
                                        exit;
                                }
                        }
                }
        }
}

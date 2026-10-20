<?php

namespace App\Models;


use PDO;
use PDOException;

class MovimentacaoModel
{

    private PDO $db;

    public function __construct()
    {
        // Obtém a conexão PDO tratada
        $this->db = Database::getConnection();
    }

    public function registrarEntrada(int $veiculoId): bool
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO movimentacoes (veiculo_id, data_entrada, status) VALUES (:veiculo_id, NOW(), 'No Pátio')");
            return $stmt->execute(['veiculo_id' => $veiculoId]);
            echo "Veículo cadastrado com sucesso.";
        } catch (PDOException $e) {
            if (isset($e->errorInfo[0]) && $e->errorInfo[0] === '45000') {
                throw new \Exception('Bloqueado: Este veículo já se encontra estacionado no pátio!');
            }

            throw $e;

        }
    }

    public function registrarSaida(int $id_movimentacao, int $valorHora): bool
    {
        $stmt = $this->db->prepare("call sp_registrar_saida(:id_movimentacao, :valor_hora)");
        return $stmt->execute([
            'id_movimentacao' => $id_movimentacao,
            'valor_hora' => $valorHora
        ]);
    }

    public function listarEstacionados(): array
    {
        $stmt = $this->db->query('SELECT * FROM vw_veiculos_no_patio');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}

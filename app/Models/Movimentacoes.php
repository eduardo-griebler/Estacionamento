<?php

namespace app\Models;

enum Status: string {
    case NoPatio = 'No Pátio';
    case Finalizado = 'Finalizado';
}

    class Movimentacoes {
        
        public function __construct(

        public ?int $id = null,
        public ?int $veiculo_id = null,
        public string $data_entrada = '',
        public ?string $data_saida = null,
        public ?float $valor_pago = null,
        public Status $status = Status::NoPatio

        ) {
            $this->id = $id;
            $this->veiculo_id = $veiculo_id;
            $this->data_entrada = $data_entrada;
            $this->data_saida = $data_saida;
            $this->valor_pago = $valor_pago;
            $this->status = $status;
        }

        public function getId() {
            return $this->id;
        }

        public function getVeiculoId() {
            return $this->veiculo_id;
        }

        public function getDataEntrada() {
            return $this->data_entrada;
        }

        public function getDataSaida() {
            return $this->data_saida;
        }

        public function getValorPago() {
            return $this->valor_pago;
        }
        public function getStatus() {
            return $this->status;
        }
    }

?>
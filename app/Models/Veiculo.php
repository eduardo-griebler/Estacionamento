<?php

namespace app\Models;

enum TipoVeiculo: string {
    case Carro = 'Carro';
    case Moto = 'Moto';
}

    class Veiculo {
        
        public function __construct(

        public ?int $id = null,
        public string $titulo = '',
        public string $modelo = '',
        public TipoVeiculo $tipo = TipoVeiculo::Carro

        ) {
            $this->id = $id;
            $this->titulo = $titulo;
            $this->modelo = $modelo;
            $this->tipo = $tipo;
        }

        public function getId() {
            return $this->id;
        }

        public function getTitulo() {
            return $this->titulo;
        }

        public function getModelo() {
            return $this->modelo;
        }
        public function getTipo() {
            return $this->tipo;
        }
    }
?>
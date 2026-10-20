<?php

namespace App\Controllers;

use App\Models\MovimentacaoModel;

class PatioController
{
        public function index(): void
        {
                $movimentacaoModel = new MovimentacaoModel();
                $veiculosEstacionados = $movimentacaoModel->listarEstacionados();

                require __DIR__ . '/../Views/patio/index.php';
        }

        public function entrada(): void
        {
                require __DIR__ . '/../Views/patio/entrada.php';
        }
}

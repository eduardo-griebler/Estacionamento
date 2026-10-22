<?php
//Organiza as classes e permite que o autoload encontre os arquivos corretamente
namespace App\Models;

//para usar a classe PDO sem precisar escrevre o nome completo
use PDO;

// PDOException do php que apresenta execeções do PDO
// Permite tratar erros no BD usando try/catch 
use PDOException;


//cria a classe veiculoModel
class VeiculoModel
{
        //declaram os atributos
        private PDO $db;
        private string $placa;
        private string $modelo;
        private string $tipo;

        //construtor da classe é executado automaticamente quando objeto é criado
        public function __construct()
        {
                //Conexão com o BD pela classe Database
                $this->db = Database::getConnection();
        }

        //Cria o método cadastrarVeiculo e recebe os parametros placa, modelo, tipo e retorna True ou False se o cadastro foi realizado
        public function cadastrarVeiculo(string $placa, string $modelo, string $tipo): bool
        {
                try {
                        //armazena o comando sql para inserir as informações do veiculo no BD
                        $sql = "INSERT INTO veiculos(placa, modelo, tipo) VALUES (:placa, :modelo, :tipo)";

                        //apenas prepara o comando do $sql utilizando a conexão PDO com BD
                        $stmt = $this->db->prepare($sql);

                        //executa o comando do prepare usando informações e retorna true ou false
                        return $stmt->execute([

                                //associa os parametros aos valores das variaveis
                                ':placa' => $placa,
                                ':modelo' => $modelo,
                                ':tipo' => $tipo
                        ]);
                        //pega uma exceção PDO permitindo tratar o erro
                } catch (PDOException $e) {

                        // Recupera o código do erro do MySQL
                        $errorCode = $e->errorInfo[1] ?? null;

                        if ($errorCode === 1062) {

                                // Identifica uma tentativa de cadastro duplicado
                                throw new \DomainException("Esta placa já está cadastrada no sistema.");
                        } else {

                                // Registra outros erros no log do servidor
                                error_log("Erro ao cadastrar veículo: " . $e->getMessage());
                        }

                        return false;
                }
        }

        // Busca todos os veículos cadastrados no banco
        public function listarCadastrados(): array
        {
                $sql = "SELECT id, placa, modelo, tipo FROM veiculos ORDER BY id ";

                $stmt = $this->db->prepare($sql);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
}

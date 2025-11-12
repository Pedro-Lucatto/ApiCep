<?php

namespace App\DAO;

use Exception;
use \PDO;
use PDOException;

abstract class DAO extends PDO
{
    /**
     * Atributo (ou Propriedade) da classe destinado a armazenar o link (vínculo aberto)
     * de conexão com o banco de dados.
     */
    protected $conexao;


    /**
     * Neste caso, assim que é instânciado, abre uma conexão com o MySQL (Banco de dados)
     * A conexão é aberta via PDO (PHP Data Object) que é um recurso da linguagem para
     * acesso a diversos SGBDs.
     */
    public function __construct()
    {
        try 
        {
            /**
             * Configurações do drive do PDO para MySQL trabalhar com exceções
             * e resolver problema de acentos com utf-8
             */
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ];


            // Pegando as variáveis de ambiente que o Docker-Compose/Kubernetes enviou
            $host = getenv('DB_HOST');
            $db_name = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');

            // CORREÇÃO FINAL: Inclui a porta (3306) diretamente no host para forçar a conexão TCP/IP,
            // resolvendo o erro de socket no Kubernetes/Docker.
            $dsn = "mysql:host=" . $host . ":3306;dbname=" . $db_name;
            
            // Criando a conexão
            $this->conexao = new PDO($dsn, $user, $pass, $options);

        } catch (PDOException $e) {

            throw new Exception("Ocorreu um erro ao tentar conectar ao MySQL", 0, $e);
        }
    }
}
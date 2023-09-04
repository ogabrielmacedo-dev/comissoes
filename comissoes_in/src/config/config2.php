<?php

class Database {
    private $host = "localhost";
    private $dbname = "C:\Users\CONVERSÃO\Desktop\Gabriel\comissoes_in_bd\CPlus.FDB"; // Caminho completo para o arquivo do banco de dados Firebird
    private $username = "SYSDBA";
    private $password = "masterkey";
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // String de conexão PDO para o Firebird
            $dsn = "firebird:dbname=" . $this->dbname . ";host=" . $this->host;
            
            // Conexão com o banco de dados usando PDO
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Erro na conexão com o banco de dados: " . $e->getMessage();
        }

        return $this->conn;
    }
}

?>

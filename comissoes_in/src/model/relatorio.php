<?php
require_once '../config/config.php';

class ComissoesFiltro
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getComissoesFiltro($dataInicio, $dataFim)
    {
        $query = "SELECT c.data_pagamento, c.valor_da_comissao, (SELECT NOMEVENDED FROM VENDEDOR WHERE CODVENDED = v.VENDED_INDICACAO) AS NOME_VENDED_INDICACAO
        FROM COMISSOESIN c
        JOIN VENDEDOR v ON c.CODVENDED = v.CODVENDED
        WHERE c.FLAG_PAGAMENTO = 'S' and c.data_pagamento between '$dataInicio' and '$dataFim';";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $comissoesFiltro = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comissaoFiltro = array(
                'DATA_PAGAMENTO' => isset($row['DATA_PAGAMENTO']) ? $row['DATA_PAGAMENTO'] : null,
                'VALOR_DA_COMISSAO' => isset($row['VALOR_DA_COMISSAO']) ? $row['VALOR_DA_COMISSAO'] : null,
                'NOME_VENDED_INDICACAO' => isset($row['NOME_VENDED_INDICACAO']) ? $row['NOME_VENDED_INDICACAO'] : null,
            );
            $comissoesFiltro[] = $comissaoFiltro;
        }

        return $comissoesFiltro;
    }
}

$dataInicio = $_POST['dataInicio'];
$dataFim = $_POST['dataFim'];

$comissoesFiltro = new ComissoesFiltro();
$response = $comissoesFiltro->getComissoesFiltro($dataInicio, $dataFim);

echo json_encode($response);

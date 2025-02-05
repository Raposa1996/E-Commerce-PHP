<?php
// Exibir erros para depuração (remova em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Lê os dados JSON da requisição
    $inputData = json_decode(file_get_contents('php://input'), true);
    
    // Verifica se os dados foram recebidos corretamente
    if (!$inputData || !isset($inputData['totalAmount']) || empty($inputData['totalAmount'])) {
        echo json_encode(["status" => "error", "mensagem" => "Valor total não informado."]);
        exit;
    }

    $total = $inputData['totalAmount'];

    // Chave da API de pagamento
    $api_key = '8429795a-798f-4b58-abeb-9830ba5fe328';
    
    // Dados da transação
    $dados_pagamento = [
        'totalAmount' => $total,
        'description' => 'Compra de Produtos',  // Descrição da compra
        'paymentMethod' => 'CREDIT_CARD',       // Método de pagamento (ajuste conforme a API)
        'currency' => 'BRL',
    ];
    
    // URL da API de pagamento (substitua pelo endpoint correto da API Asaas)
    $url_api = 'https://sandbox.asaas.com/api/v3/payments';

    // Inicializa cURL
    $ch = curl_init($url_api);
    
    // Configurações de cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'access_token: ' . $api_key
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados_pagamento));
    
    // Envia a solicitação
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Verifica se houve erro na comunicação com a API
    if ($response === false) {
        echo json_encode(["status" => "error", "mensagem" => "Erro ao se conectar à API de pagamento."]);
        exit;
    }

    // Decodifica a resposta JSON
    $response_data = json_decode($response, true);

    // Verifica se a resposta é válida
    if (!isset($response_data['status'])) {
        echo json_encode(["status" => "error", "mensagem" => "Resposta inválida da API."]);
        exit;
    }

    // Retorna o status do pagamento
    if ($response_data['status'] == 'PENDING') { // Ajuste conforme a API Asaas
        echo json_encode(["status" => "success", "paymentLink" => $response_data['invoiceUrl'] ?? ""]);
    } else {
        echo json_encode(["status" => "error", "mensagem" => $response_data['errorMessage'] ?? "Erro desconhecido."]);
    }

} else {
    // Se a requisição não for POST, retorna erro
    echo json_encode(["status" => "error", "mensagem" => "Método inválido. Use POST."]);
}
?>

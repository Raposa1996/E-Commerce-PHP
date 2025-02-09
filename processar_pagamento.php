<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$chavePagamento = $_ENV['ASAAS_API_KEY'];

function chamarAsaasAPI($endpoint, $method = 'GET', $data = [], $chavePagamento) {
    $apiUrl = 'https://sandbox.asaas.com/api/v3' . $endpoint;
    $client = new \GuzzleHttp\Client();

    try {
        $options = [
            'headers' => [
                'accept' => 'application/json',
                'access_token' => $chavePagamento,
            ]
        ];

        if ($method == 'POST' || $method == 'PUT') {
            $options['json'] = $data;
        }

        $response = $client->request($method, $apiUrl, $options);
        return json_decode($response->getBody(), true);

    } catch (\GuzzleHttp\Exception\ClientException $e) {
        $responseBody = json_decode($e->getResponse()->getBody(), true);
        return ['status' => 'error', 'message' => $responseBody['errors'][0]['description'] ?? 'Erro na requisição.'];

    } catch (\GuzzleHttp\Exception\ServerException $e) {
        return ['status' => 'error', 'message' => 'Erro no servidor Asaas. Tente novamente mais tarde.'];

    } catch (\Exception $e) {
        return ['status' => 'error', 'message' => $e->getMessage()];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados da requisição
    $inputData = json_decode(file_get_contents('php://input'), true);

    // Dados do cliente
    $nomeCliente = $inputData['nome'] ?? '';
    $emailCliente = $inputData['email'] ?? '';
    $cpfCnpj = $inputData['cpfCnpj'] ?? '';  // Esse campo pode ser vazio
    $billingType = $inputData['billingType'] ?? 'BOLETO';  // Tipo de cobrança padrão: Boleto

    // Dados do cliente (sem verificação)
    $dadosCliente = [
        'name' => $nomeCliente,
        'email' => $emailCliente,
        'cpfCnpj' => $cpfCnpj,
        'phone' => '',
        'mobilePhone' => '',
        'postalCode' => '',
        'address' => '',
        'addressNumber' => '',
        'complement' => '',
        'province' => '',
        'externalReference' => '',
        'notificationDisabled' => false,
        'additionalEmails' => '',
        'municipalInscription' => '',
        'stateInscription' => '',
        'observations' => ''
    ];

    // Criação do cliente na API do Asaas
    $resultadoCriacaoCliente = chamarAsaasAPI('/customers', 'POST', $dadosCliente, $chavePagamento);

    // Recupera o ID do cliente criado
    $idClienteAsaas = $resultadoCriacaoCliente['id'] ?? '';

    // Dados do pagamento
    $dadosPagamento = [
        'customer' => $idClienteAsaas,
        'billingType' => $billingType,  // Use o tipo de cobrança fornecido ou 'BOLETO' por padrão
        'dueDate' => date('Y-m-d', strtotime('+3 days')),
        'value' => $inputData['totalAmount'],
        'description' => 'Compra de produtos na loja',
    ];

    // Criação do pagamento
    $resultadoCriacaoPagamento = chamarAsaasAPI('/payments', 'POST', $dadosPagamento, $chavePagamento);

    // Retorne o link do pagamento
    echo json_encode([
        "status" => "success",
        "paymentLink" => $resultadoCriacaoPagamento['invoiceUrl'] ?? "Link de pagamento indisponível."
    ]);
    exit;
} else {
    // Se o método não for POST
    echo json_encode(["status" => "error", "mensagem" => "Método inválido. Use POST."]);
    exit;
}
?>

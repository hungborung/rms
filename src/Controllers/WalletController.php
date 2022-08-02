<?php
namespace Src\Controllers;

use Src\Models\Wallet;

class WalletController {

    private $db;
    private $requestMethod;

    private $wallet;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;

        $this->wallet = new Wallet($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getAllWallets();
                break;
            case 'POST':
                $response = $this->createWallet();
                break;
            case 'DELETE':
                $response = $this->deleteWallet();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllWallets()
    {
        $result = $this->wallet->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createWallet()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateWallet($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->wallet->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 200 Created';
        $response['body'] = json_encode(
            ["message" => "Created successful"]
        );

        return $response;
    }

    private function deleteWallet()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $result = $this->wallet->find($input['name'], $input['hash_key']);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $this->wallet->delete($input['name'], $input['hash_key']);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['message' => 'Deleted successful']);

        return $response;
    }

    private function validateWallet($input)
    {
        if (!isset($input['name']) || !preg_match("/^[A-Za-z0-9 ]{3,32}\S+$/", $input['name'])) {
            return false;
        }

        if (!isset($input['hash_key']) && !preg_match("/^{3,32}$/", $input['hash_key'])) {
            return false;
        }

        $wallet = $this->wallet->find($input['name'], $input['hash_key']);
        if ($wallet) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 403 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);

        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 403 Not Found';
        $response['body'] = null;

        return $response;
    }
}

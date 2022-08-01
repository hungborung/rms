<?php
namespace Src\Controllers;

use Src\Models\Transaction;
use Src\Models\Wallet;

class TransactionController {

    private $db;
    private $requestMethod;
    private $userId;

    private $transaction;
    private $wallet;
    public function __construct($db, $requestMethod, $userId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;

        $this->transaction = new Transaction($db);
        $this->wallet = new Wallet($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getAllTransaction();
                break;
            case 'POST':
                $response = $this->createTransaction();
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

    private function getAllTransaction()
    {
        $result = $this->transaction->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createTransaction()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateTransaction($input)) {
            return $this->unprocessableEntityResponse();
        }
        $wallet = $this->wallet->findByName($input['name']);
        if (!$wallet) {
            $response['status_code_header'] = 'HTTP/1.1 500';
        } else {
            $hashCheck = md5($input['name'] . $input['type'] . $input['amount'] . $input['reference']);
            $input['wallet_id'] = $wallet['id'];
            if ($hashCheck != md5($input['hash_check'])) {
                $response['status_code_header'] = 'HTTP/1.1 404';
            } else {
                $this->transaction->insert($input);
                $response['status_code_header'] = 'HTTP/1.1 200';
                $response['body'] = json_encode(
                    ["message" => "Created successful"]
                );
            }
            
        }

        return $response;
    }

    private function validateTransaction($input)
    {
        if (!isset($input['name']) || !preg_match("/^[A-Za-z0-9]{3,255}\S+$/", $input['name']))
            return false;
        else if (!is_int($input['amount']) && (($input['type'] == "BET" && intval($input['amount']) > 0) || ($input['type'] == "WIN" && intval($input['amount']) < 0)))
            return false;
        else if (!strpos($input['reference'], 'TR-') == 0  || strlen($input['reference']) < 3 || strlen($input['reference']) > 255)
            return false;

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
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}

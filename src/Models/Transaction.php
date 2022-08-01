<?php
namespace Src\Models;

class Transaction {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
            SELECT 
                *
            FROM
                transactions;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    
    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO transactions 
                (wallet_id, type, amount, reference, timestamp)
            VALUES
            (:wallet_id, :type, :amount, :reference, :timestamp);
        ";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'wallet_id' => $input['wallet_id'],
                'type'  => $input['type'],
                'amount'  => $input['amount'],
                'reference'  => $input['reference'],
                'timestamp' => date('Y/m/d h:i:s', time())
            ));

            return $statement->rowCount();
        } catch (\PDOException $e) {
            return array("statusCode" => 403, "data" => null);
        }    
    }

}

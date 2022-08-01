<?php
namespace Src\Models;

class Wallet {

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
                wallets;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return array("statusCode" => 403, "data" => null);
        }
    }

    public function find($name, $hashKey = '')
    {
        $statement = "
            SELECT 
                *
            FROM
                wallets
            WHERE name=:name AND hash_key=:hash_key;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'name' => $name,
                'hash_key' => md5($hashKey)
            ));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return array("statusCode" => 403, "data" => null);
        }    
    }

    public function findByName($name, $hashKey = '')
    {
        $statement = "
            SELECT 
                *
            FROM
                wallets
            WHERE name=:name;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'name' => $name
            ));
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return array("statusCode" => 403, "data" => null);
        }    
    }

    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO wallets 
                (name, hash_key)
            VALUES
                (:name, :hash_key);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $hashKey = md5($input['hash_key']);
            $statement->execute(array(
                'name' => $input['name'],
                'hash_key'  => $hashKey,
            ));

            return $statement->rowCount();
        } catch (\PDOException $e) {
            return array("statusCode" => 403, "data" => null);
        }    
    }

    public function delete($name, $hashKey)
    {
        $statement = "
            DELETE FROM wallets
            WHERE name=:name AND hash_key=:hash_key;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'name' => $name,
                'hash_key' => md5($hashKey),
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return array("statusCode" => 403, "data" => null);
        }    
    }
}

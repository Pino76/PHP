<?php
/**
 * Created by PhpStorm.
 * User: pinof
 * Date: 07/10/2018
 * Time: 21:21
 */

namespace App\Models;


class ConnectionDB{
    private static $instance = null;
    private $connection;

    private $dsn = "mysql:host=localhost;dbname=php7";
    private $username = "root";
    private $password = "";


    private function __construct(){
        try{
            $this->connection = new \PDO($this->dsn,$this->username,$this->password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function getInstance(){
        if(static::$instance === null){
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function getConnection(){
        return $this->connection;
    }

    private function __clone(){
        return false;
    }

    private function __wakeup(){
        return false;
    }

}



//TEST
try {
    $instance = ConnectionDB::getInstance();
    $xxx = $instance->getConnection();
    $sql = "SELECT * FROM utente LIMIT 10";
    $rs = $xxx->prepare($sql);
    $rs->execute();
    $result = $rs->fetchAll();
    var_dump($result);

}catch (PDOException $e){
    $e->getMessage();
}
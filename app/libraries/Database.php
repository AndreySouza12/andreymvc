<?php
/*
*PDO DATABASE CLASS
*CRIAR PREPARED STATEMENTS
*VINCULAR VALORES
*Retornar Linhas

*/


class Database{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    
    private $dbh;
    private $stmt;
    private $error;

    public function __construct(){
        $dsn = 'mysql:host='.$this->host.";dbname=".$this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT=> true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        );

        //Criar instância

        try{

        $this->dbh = new PDO($dsn,$this->user,$this->pass,$options);

        }catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }


    // public function query($rawQuery){
    //     $this->stmt = $this->dbh->prepare($rawQuery);
    // }

    // public function insert($params){
    //     foreach($params as $key => $value){
    //         $this->bind($key,$value);
    //     }

    //     $this->stmt->execute();
    //     echo "inserido com sucesso";
    // }

 
    // public function  bind($params,$values){
    //     $this->stmt->bindParam($params,$values);
    // }


    //preparar declaração

    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql);
    }   

    public function bind($param,$value,$type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                $type = PDO::PARAM_INT;
                break;
                case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
                case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
                default:
                $type = PDO::PARAM_STR;
                break;
            }
        }
        $this->stmt = bindValue($param,$value,$type);
    }

    public function execute(){
        return $this->stmt->execute();
    }

    public function resultSet(){
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function singleResult(){
        $this->stmt->execute();
        return $this->stmt->fetch();
    }

    public function rowCount(){
        $this->stmt->execute();
        return $this->stmt->rowCount();
    }
   

}




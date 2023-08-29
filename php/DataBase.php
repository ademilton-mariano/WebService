<?php

require_once "../config.php";

class Database {
    private $host = HOST;
    private $db = DB;
    private $user = USER;
    private $pass = PASS;
    private $conexao;

    public function conexao(){
            $dsn = "mysql:host=".$this->host.";dbname=".$this->db;
           $this->conexao = new PDO($dsn, $this->user, $this->pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            
           return $this->conexao;
        } 
}
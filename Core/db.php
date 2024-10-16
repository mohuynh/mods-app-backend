<?php

class DB {

    protected $pdo;

public function __construct() 
{

    try {

        $this->pdo = new PDO('sqlite:./database.db');

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {

                 die("Could not connect to the database: " . $e->getMessage());

                }
    }

    public function lastInsertId() {

       return $this->pdo->lastInsertId();
    
    }

}


?>

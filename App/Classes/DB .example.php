<?php
namespace App\Classes;

use PDO;
use PDOException;

class DB {
    private $servername ='servername';
    private $dbname='dbname';
    private $username='username';
    private $password='password';

    public function connect(){


        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }

    }
}

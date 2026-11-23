<?php

class Connection
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'presensi_uuk';

    public function getConnection()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->database}";
        $pdo = new PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}

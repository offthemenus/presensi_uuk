<?php

abstract class BaseModel
{
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    // Mengakses koneksi database
    protected function getConnection()
    {
        return $this->connection;
    }

    abstract public function getAll();
}

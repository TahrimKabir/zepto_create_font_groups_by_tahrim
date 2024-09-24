<?php
class DbConnection
{
    protected $connection;

    public function __construct()
    {
        $this->connection = new mysqli('localhost', 'root', '', 'test'); // Adjust parameters as necessary

        // Check connection
        if ($this->connection->connect_error) {
            die('Database connection failed: ' . $this->connection->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

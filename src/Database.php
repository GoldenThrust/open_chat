<?php

namespace Gem;

class Database
{
    public function __construct(private string $host, private $dbname, private string $username, private string $password, private int $port = 3306)
    {
    }

    public function getConnection(): \PDO
    {
        return new \PDO("mysql:host=$this->host;port=$this->port;dbname=$this->dbname", $this->username, $this->password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }
}

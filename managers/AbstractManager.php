<?php
    abstract class AbstractManager
    {
        protected PDO $db;
        private string $dbName;
        private string $port;
        private string $host;
        private string $username;
        private string $password;

        public function __construct(string $dbName, string $port, string $host, string $username, string $password)
        {
            $this->dbName = $dbName;
            $this->port = $port;
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
            $this->db = new PDO(
                $connexionString = "mysql:host=$host;port=$port;dbname=$dbName",
                $username,
                $password
            );
        }
    }
?>
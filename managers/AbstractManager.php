<?php
    abstract class AbstractManager
    {
        protected PDO $db;
        private string $dbName;
        private string $port;
        private string $host;
        private string $username;
        private string $password;

        public function __construct()
        {
            $host = 'db.3wa.io';
            $port = '3306';
            $dbName = 'blanchepeltier_projet-mairie';
            $username = 'blanchepeltier';
            $password = '6df6213ed1bccc46589270829cdb7338';

            $this->db = new PDO(
                $connexionString = "mysql:host=$host;port=$port;dbname=$dbName",
                $username,
                $password
            );
        }
    }
?>
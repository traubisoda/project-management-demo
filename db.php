<?php

class DB {
    protected $host = 'localhost';
    protected $db   = 'project_manager';
    protected $user = 'root';
    protected $pass = 'root';
    protected $charset = 'utf8mb4';
    protected $dsn;
    protected $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    public function __construct()
    {
        $this->dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
    }

    public function getPDO()
    {
        return new PDO($this->dsn, $this->user, $this->pass, $this->options);
    }

    public function getProjects()
    {
        $stmt = $this->getPDO()->query('SELECT * from projects where 1');

        return $stmt->fetchAll();
    }
}

<?php
namespace Library;

trait ConnectedToDb
{
    protected $db;
    protected static $instance = null;

    protected function __construct()
    {
        $this->db = $this->connectToDb();
    }

    public static function getInstance(){
        if(!(self::$instance instanceof self)){
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function connectToDb()
    {
        $server = getenv('SERVER');
        $database = getenv('DATABASE');
        $user = getenv('USER');
        $password = getenv('PASSWORD');

        return new \PDO("mysql:host=$server;dbname=$database;charset=utf8mb4", $user, $password);
    }

    public function executeQuery(string $query, array $params = null)
    {
        $this->connectToDb();
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function lastInsertId(){
        return $this->db->lastInsertId();
    }
}
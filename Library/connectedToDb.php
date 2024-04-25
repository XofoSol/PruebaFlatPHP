<?php
namespace Library;

use PDO;

/**
 * Controla el comportamiento de cualquier clase que necesite conectarse a la base de datos
 */
trait ConnectedToDb
{
    protected $db;
    protected static $instance = null;

    /**
     * Método constructor.
     */
    protected function __construct()
    {
        $this->db = $this->connectToDb();
    }

    /**
     * Obtiene la instancia del objeto, y si no existe, la crea
     * @return object
     */
    public static function getInstance():object
    {
        if(!(self::$instance instanceof self)){
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Realiza la conexión a la base de datos
     * @return PDO
     */
    public function connectToDb():PDO
    {
        $server = getenv('SERVER');
        $database = getenv('DATABASE');
        $user = getenv('USER');
        $password = getenv('PASSWORD');

        return new PDO("mysql:host=$server;dbname=$database;charset=utf8mb4", $user, $password);
    }

    /**
     * Ejecuta un query en la base de datos
     * @param string $query El query a ejecutar
     * @param ?array $params Los parámetros del query, si existieran
     * @return array
     */
    public function executeQuery(string $query, array $params = null):array
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Retorna el último id insertado en la base de datos
     * @return string
     */
    public function lastInsertId():string
    {
        return $this->db->lastInsertId();
    }
}
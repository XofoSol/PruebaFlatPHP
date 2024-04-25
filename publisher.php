<?php
require 'vendor/autoload.php';

/**
 * Publicador masivo de tareas
 */
class Publisher
{
    use Library\ConnectedToDb;

    /**
     * Cuenta los tipos de tarea registrados en la base de datos
     * @return int
     */
    public function countTypes():int
    {
        $publisher = self::getInstance();
        $count = $publisher->executeQuery("SELECT COUNT(*) AS num FROM task_types");
        return $count[0]->num;
    }
    
    /**
     * Registra 100 tareas al azar en la cola de trabajo.
     * @return void
     */
    public static function publish():void
    {
        $publisher = self::getInstance();
        $countTypes = $publisher->countTypes();

        for($i = 0; $i < 100; $i++){
            $type = rand(1,$countTypes);
            $priority = rand(1, 5);
            $publisher->executeQuery("INSERT INTO tasks(task_type_id, priority) VALUES(:task_type, :priority)", 
            [':task_type' => $type, ':priority'=> $priority]);
            $insertId = $publisher->lastInsertId();
            if($type == 1){
                $publisher->executeQuery("INSERT INTO task_metas(task_id, `key`, `value`) VALUES(:task_id, 'url','https://php.net') ",[':task_id' => $insertId]);
            }
        }
    }
}

Publisher::publish();
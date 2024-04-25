<?php

namespace Library;

use Exception;

/**
 * Controlador del API de tareas
 */
class ApiController
{
    use ConnectedToDb;

    /**
     * Lista todas las tareas de la cola de trabajo
     * @return string
     */
    public static function listTasks():string
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if($method !== 'GET'){
            throw new Exception('Method error');
        }
        $db = self::getInstance();
        $list = $db->executeQuery("SELECT a.id, b.type, a.start_at, a.executed, a.failed FROM tasks a JOIN task_types b ON a.task_type_id = b.id");
        return json_encode($list);
    }

    /**
     * Obtiene una tarea de la cola de trabajo por su id
     * @param int $task_id El id de la tarea a obtener
     * @return string
     */
    public static function getTask(int $task_id):string
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if($method !== 'GET'){
            throw new Exception('Method error');
        }
        $db = self::getInstance();
        $task = $db->executeQuery("SELECT a.*, b.type FROM tasks a JOIN task_types b ON a.task_type_id = b.id WHERE a.id = :task_id LIMIT 1", [':task_id'=>$task_id]);
        return json_encode($task[0]);
    }

    /**
     * Crea una nueva tarea según la petición efectuada
     * @return string
     */
    public static function createTask():string
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'POST'){
            throw new Exception('Method error: '.$method);
        }
        $db = self::getInstance();
        $request = json_decode(file_get_contents('php://input'));
        $db->executeQuery("INSERT INTO tasks(task_type_id, priority) VALUES(:type_id, :priority)", 
        [':type_id'=>$request->task_type_id, ':priority'=>$request->priority]);
        $insertId = $db->lastInsertId();
        $params = get_object_vars($request);
        foreach($params as $key => $value){
            if($key != 'task_type_id' && $key != 'priority'){
                $db->executeQuery("INSERT INTO task_metas(task_id, `key`, `value`) VALUES(:insert_id, :key, :value)",
                [':insert_id' => $insertId, ':key' => $key, ':value' => $value]);
            }
        }
        $task = $db->executeQuery("SELECT a.*, b.type FROM tasks a JOIN task_types b ON a.task_type_id = b.id WHERE a.id = :task_id LIMIT 1", [':task_id'=>$insertId]);
        return json_encode($task[0]);
    }
}
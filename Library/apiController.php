<?php

namespace Library;

use Exception;

class ApiController
{
    use ConnectedToDb;

    public static function listTasks(){
        $method = $_SERVER['REQUEST_METHOD'];
        if($method !== 'GET'){
            throw new Exception('Method error');
        }
        $db = self::getInstance();
        $list = $db->executeQuery("SELECT a.*, b.type FROM tasks a JOIN task_types b ON a.task_type_id = b.id");
        return json_encode($list);
    }

    public static function getTask(int $task_id){
        $method = $_SERVER['REQUEST_METHOD'];
        if($method !== 'GET'){
            throw new Exception('Method error');
        }
        $db = self::getInstance();
        $task = $db->executeQuery("SELECT a.*, b.type FROM tasks a JOIN task_types b ON a.task_type_id = b.id WHERE a.id = :task_id LIMIT 1", [':task_id'=>$task_id]);
        return json_encode($task[0]);
    }

    public static function createTask(){
        $method = $_SERVER['REQUEST_METHOD'];
        if($method !== 'POST'){
            throw new Exception('Method error');
        }
        $db = self::getInstance();
        $request = json_decode(file_get_contents('php://input'));
        $db->executeQuery("INSERT INTO tasks(task_type_id, priority) VALUES(:type_id, :priority)", 
        [':type_id'=>$request->task_type_id, ':priority'=>$request->priority]);
        return self::getTask($db->lastInsertId());
    }
}
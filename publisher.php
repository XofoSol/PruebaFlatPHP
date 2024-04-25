<?php
require 'vendor/autoload.php';
class Publisher
{
    use Library\ConnectedToDb;

    public function countTypes()
    {
        $publisher = self::getInstance();
        $count = $publisher->executeQuery("SELECT COUNT(*) AS num FROM task_types");
        return $count->num;
    }
    
    public static function publish()
    {
        $publisher = self::getInstance();
        $countTypes = $publisher->countTypes();

        for($i = 0; $i < 100; $i++){
            $type = rand(1,$countTypes);
            $priority = rand(1, 5);
            $publisher->executeQuery("INSERT INTO tasks(task_type_id, priority) VALUES(:task_type, :priority)", 
            [':task_type' => $type, ':priority'=> $priority]);
        }
    }
}

Publisher::publish();
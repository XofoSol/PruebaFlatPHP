<?php

interface Task
{
    public function connectToDb();
    public function executeQuery();
    public function handle();
}

abstract class ConnectedToDb
{
    protected $db;
    
    public function connectToDb()
    {
        $server = getenv('server');
        $database = getenv('database');
    }

    public function executeQuery(string $query)
    {
        
    }
}

class TaskType1 extends ConnectedToDb implements Task
{
    public function handle()
    {
        
    }
}

class TaskType2 extends ConnectedToDb implements Task
{
    public function handle()
    {
        
    }
}

class TaskType3 extends ConnectedToDb implements Task
{
    public function handle()
    {
        
    }
}

class Suscriber extends ConnectedToDb
{
    public static function working()
    {
        
    }
}
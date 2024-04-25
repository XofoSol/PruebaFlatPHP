<?php

namespace Library;

use Exception;

class TaskType3 implements Task
{
    public function handle()
    {
        sleep(5);
        $luck = rand(1,4);
        if($luck == 1){
            throw new Exception('Bad luck');
        }
        return date('c');
    }
}
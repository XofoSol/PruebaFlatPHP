<?php
namespace Library;

use Exception;

class TaskType2 implements Task
{
    public function handle()
    {
        try{
            $request = file_get_contents('https://v2.jokeapi.dev/joke/Any?lang=en&blacklistFlags=religious,racist,sexist,explicit&type=single');
            $response = json_decode($request);
            return $response->joke;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}
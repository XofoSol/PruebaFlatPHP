<?php
namespace Library;

use Exception;

/**
 * Tipo de tarea 2: Obtiene un chiste de un API de chistes
 */
class TaskType2 implements Task
{
    /**
     * Ejecución de la tarea
     * @return string
     */
    public function handle():string
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
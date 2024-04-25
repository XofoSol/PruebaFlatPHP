<?php

namespace Library;

use Exception;

/**
 * Tipo de tarea 3: Espera 5 segundos y devuelve la fecha.  Tiene un 25% de probabilidad de devolver error.
 */
class TaskType3 implements Task
{
    /**
     * Ejecución de la tarea
     * @return string
     */
    public function handle():string
    {
        sleep(5);
        $luck = rand(1,4);
        if($luck == 1){
            throw new Exception('Bad luck');
        }
        return date('c');
    }
}
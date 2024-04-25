<?php

namespace Library;

/**
 * Establece la estructura que deben llevar los objetos tarea
 */
interface Task
{
    /**
     * Ejecuta la tarea programada
     * @return string
     */
    public function handle():string;
}
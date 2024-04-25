<?php

namespace Library;

use Exception;
use Library\ApiController;

class Router
{
    public static function manage($url)
    {
        $url = ltrim($url, '/');
        $segments = explode('/', $url);

        // Construcción de la ruta:  Primer segmento: api.  Segundo segmento: método.  Tercer segmento: parámetro.
        // Ejemplo: api/getTask/1
        try{
            if(!isset($segments[2]))
                echo call_user_func([ApiController::class, $segments[1]]);
            else
                echo call_user_func([ApiController::class, $segments[1]], $segments[2]);
        }catch(Exception $e){
            http_response_code(400);
            echo "Bad Request";
        }
        

    }
}
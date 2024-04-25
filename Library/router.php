<?php

namespace Library;

use Error;
use Exception;
use Library\ApiController;

class Router
{
    public static function manage($url)
    {
        $url = ltrim($url, '/');
        $url = rtrim($url, '/');
        $segments = explode('/', $url);

        // Construcción de la ruta:  Primer segmento: api.  Segundo segmento: método.  Tercer segmento: parámetro.
        // Ejemplo: api/getTask/1
        try{
            if(empty($segments[0])){
                echo "Index";
                return;
            }
            if(!isset($segments[1])){
                throw new Error();
            }
            if(!isset($segments[2])){
                echo call_user_func([ApiController::class, $segments[1]]);
                return;
            }
            
            echo call_user_func([ApiController::class, $segments[1]], $segments[2]);
            return;
        }catch(Exception $e){
            http_response_code(400);
            echo "Bad Request: ".$e->getMessage();
        }catch(Error $e){
            http_response_code(404);
            echo "Page Not Found";
        }
        

    }
}
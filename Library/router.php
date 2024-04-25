<?php

namespace Library;

use Error;
use Exception;
use Library\ApiController;

/**
 * Controla las rutas del API
 */
class Router
{
    /**
     * Ejecuta el método adecuado según la ruta que se le provee.
     * @param string $url
     * @return void
     */
    public static function manage(string $url):void
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
<?php

namespace Library;

use Exception;

/**
 * Tipo de tarea 1: Retorna el título de la página cuya url se provee.
 */
class TaskType1 implements Task
{
    private array $params;
    
    /**
     * Método constructor.  
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Ejecución de la tarea
     * @return string
     */
    public function handle():string
    {
        try{
            $title = '';
            $dom = new \DOMDocument();
            if($dom->loadHTMLFile($this->params['url'])) {
                $list = $dom->getElementsByTagName('title');
                if($list->length > 0){
                    $title = $list->item(0)->textContent;
                }
            }
            return $title;
            
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
        
    }
}
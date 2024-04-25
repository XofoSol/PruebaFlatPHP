<?php

namespace Library;

use Exception;

class TaskType1 implements Task
{
    private array $params;
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function handle()
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
<?php
require 'vendor/autoload.php';
/**
 * Objeto que controla y ejecuta la cola de trabajo.
 */
class Suscriber
{
    use Library\ConnectedToDb;

    /**
     * Obtiene la siguiente tarea a ejecutar
     * @return ?object
     */
    public function getTask(): ?object
    {
        $suscriber = Suscriber::getInstance();
        $tasks = $suscriber->executeQuery("SELECT * FROM tasks WHERE executing = 0 AND executed = 0 AND intent < 3 AND start_at <= NOW() ORDER BY priority ASC, created_at ASC LIMIT 1");
        if(empty($tasks)){
            return null;
        }
        $suscriber->registerInit($tasks[0]->id);
        return $tasks[0];
    }

    /**
     * Marca una tarea con la bandera de inicio de ejecución, para que ningún otro suscriber pueda iniciarla
     * @param int $task_id El Id de la tarea a marcar
     * @return void
     */
    public function registerInit(int $task_id) : void
    {
        $suscriber = Suscriber::getInstance();
        $suscriber->executeQuery("UPDATE tasks SET executing = 1 WHERE id = :task_id", [':task_id' => $task_id]);
    }
    
    /**
     * Registra el éxito en la ejecución de una tarea
     * @param int $task_id El id de la tarea a registrar
     * @param string $result El resultado de la ejecución de la tarea
     * @return void
     */
    public function registerSuccess(int $task_id, string $result):void
    {
        $suscriber = Suscriber::getInstance();
        $suscriber->executeQuery("UPDATE tasks SET executing = 0, executed = 1, failed = 0, succeded_at = NOW(), result = :result WHERE id = :task_id", [':task_id'=>$task_id, ':result' => $result]);
    }
    
    /**
     * Registra el fallo en la ejecución de una tarea.  Si no ha sido intentada su ejecución 3 veces, la pone en cola con 30 segundos de espera.
     * @param int $task_id El id de la tarea a registrar
     * @param int $intent El número de intento de ejecución
     * @param string $error El error por el cual ha fallado su ejecución
     * @return void
     */
    public function registerFail(int $task_id, int $intent, string $error):void
    {
        $suscriber = Suscriber::getInstance();
        $intent++;
        $executed = $intent < 3? 0 : 1;
        $suscriber->executeQuery("UPDATE tasks SET executing = 0, intent = :intent, executed = :executed, failed = 1, failed_at = NOW(), start_at = TIMESTAMPADD(SECOND, 30, NOW()), result = :error WHERE id = :task_id", 
        [':task_id'=>$task_id, ':executed' => $executed, ':intent' => $intent, ':error' => $error]);
    }
    
    /**
     * Iniciamos el suscriber para que empiece a recoger tareas y ejecutarlas
     * @return void
     */
    public static function working():void
    {
        $suscriber = Suscriber::getInstance();
        $task = $suscriber->getTask();

        // Si no hay tareas, simplemente reiniciamos el bucle.
        if(is_null($task)){
            usleep(5000);
            unset($suscriber);
            unset($task);
            gc_collect_cycles();
            self::working();
            return;
        }
        
        $task_metas = $suscriber->executeQuery("SELECT * FROM task_metas WHERE task_id = :task_id", [':task_id' => $task->id]);
        $executionName = "Library\TaskType".$task->task_type_id;
        if(!empty($task_metas)){
            $params = [];
            foreach($task_metas as $task_meta){
                $params[$task_meta->key] = $task_meta->value;
            }
            $execution = new $executionName($params);
        }else{
            $execution = new $executionName();
        }
        try{
            $result = $execution->handle();
            $suscriber->registerSuccess($task->id, $result);

        }catch(Exception $e){
            $suscriber->registerFail($task->id, $task->intent, $e->getMessage());
        }finally{
            usleep(100);
            unset($suscriber);
            unset($task);
            unset($task_metas);
            unset($executionName);
            unset($params);
            unset($execution);
            unset($result);
            unset($e);
            gc_collect_cycles();
            self::working();
            return;
        }
    }
}

// Autoejecutamos el primer ciclo de suscriber
Suscriber::working();
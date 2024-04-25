# Prueba Técnica PHP
Desarrolla un pequeño sistema de publicación y ejecución de tareas en PHP. El objetivo es
tener una lista de tareas y que múltiples ficheros PHP puedan ir cogiendo tareas de esa lista
y las vayan ejecutando, de esta forma podríamos tener 10 máquinas ejecutando tareas de
un stack.

## Uso:
Para hacer más fácil su ejecución, tiene configurado un entorno completo de pruebas con Docker.
Únicamente hay que iniciar el entorno con el comando
```
docker-compose up -d
```
Hay que dar un poco de tiempo para que se inicie el servicio de MySQL y ejecute la migración de base de datos.  A partir de allí, se puede iniciar el servicio de tareas con el comando 
```
sh execSuscriber.sh
```
Éste comando iniciará, a través de Supervisor, 10 suscribers simultáneos, que ejecutarán las tareas registradas en base de datos.
Para ponerlo a prueba masivamente, puede ejecutarse el comando 
```
sh execPublisher.sh
```
Éste comando registrará 100 tareas al azar en la cola de trabajo, que inmediatamente los suscribers empezarán a despachar.

Si desean detenerse los suscribers, puede hacerse con el comando
```
sh stopSuscriber.sh
```

El proyecto además incluye un PhpMyAdmin para que pueda supervisarse la base de datos, el cual está alojado en el puerto 8080 del servidor, de tal forma: http://localhost:8080.

Además, como parte del requerimiento del proyecto, se ha realizado un API con tres tareas específicas:
- Listar todas las tareas de la cola: http://localhost:8000/api/listTasks (Método GET)
- Obtener información de una tarea específica por su id: http://localhost:8000/api/getTask/{id}/  (Método GET) Ejemplo: http://localhost:8000/api/getTask/28/
- Insertar una nueva tarea: http://localhost:8000/api/createTask (Método POST)
El cuerpo de la petición deberá ser en formato JSON con la siguiente estructura:
```
{
    "task_type_id":2,
    "priority":2
}
```
Sin embargo, para el tipo de tarea 1, "Get the title from an url", debe agregarse un parámetro más, con etiqueta "url" para especificar la url a la cual se le obtendrá el título.  Quedando la petición de esta forma:
```
{
    "task_type_id":1,
    "priority":2,
    "url":"https://prensalibre.com"
}
```

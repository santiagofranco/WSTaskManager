# TaskManager

Web service para guardar y recuperar tareas en forma de xml o json. Mediante un id de usuario.

## Tareas

El archivo que recibe las query string es **/task.php**

### Operaciones GET

#### op = all_tasks

  Parametros que necesita:
  1. El `id` del usuario del que se piden las tareas.
  2. El `formato` en que se desea la información. Es opcional. Por defecto devuelve las tareas en xml
  
  Si algo falla devuelve un xml con el mensaje del error a menos que se indique la operación y el formato.

### Operaciones POST

#### op = add_task

  Parámetros necesarios:
  1. El `idUser` que guarda la tarea.
  2. La `task` que se va a guardar.
  
  Si todo va bien devuelve un json en el formato: {"mensaje":"contenido","cod":"codigo"}
  Si algo falla el json devuelto tiene el formato: {"error":"contenido"}

## Usuarios

El archivo que recibe las query string es **/resgisro.php**

### Operaciones POST

#### op = registro

  Parámetros necesarios: 
  1. El `email` del usuario.
  2. El `nombre` del usuario.
  3. La `pass` del usuario.
  
  Tanto si la operación ha ido bien como mal se devuelve un json en el siguiente formato: {"mensaje":"contenido","cod":"codigo"}

#### op = login
  
  Parámetros necesarios:
  1. El `email` del usuario.
  2. La `pass` del usuario.
  
  Si la operación va bien se devuelve un json con los datos el usuario que se logueo en el formato: {"id":"","name":"","email":"","password_hash":"","api_key":"","status":"","created_at":""}

  Si la operación falla se devuelve un json: {"mensaje":"contenido","cod":"codigo"}
  
## Códigos

| Código   | Mensaje                       |
| -------: |:-----------------------------:|
| 0        | Usuario creado correctamente  |
| 1        | Fallo creando usuario         |
| 2        | Usuario ya existe             |
| 3        | Tarea insertada correctamente |
| 4        | Fallo insertando la tarea     |
| 5        | Falta algun parámetro         |
| 6        | Falta la operación            |
| 7        | El usuario no existe          |

## Test Mode

Este web service disponde de una pagina de prueba **/test.php** donde, mediante formularios, se pueden probar las operaciones post.

---

## Infraestructura

Este web service esta alojado en heroku.com, un PaaS que permite desplegar aplicaciones php de forma gratuita. Para MySQL, también de forma gratuita, en la página www.db4free.com, simplemente indicando un email, permite tener una base de datos. 

<?php
class DAOTasks{
	
	private $conn;
	
	public function __construct(){
		require_once 'db/DBConnect.php';
		$db = new DBConnect();
		$this->conn = $db->conectar();
		
	}
	
	/**
	 * Insertar una tarea en la BD
	 * @param userId Id del usuario que ha creado la tarea
	 * @param task String con la tarea que se ha creado
	 * */
	public function addTask($userId, $task) {
		require 'Config.php';
		
		$insert = $this->insertTask ($task); //Insertamos la tarea en su tabla
		
		if($insert){ //Si se ha insertado correctamente guardamos la relacion del usuario con su tarea
			
			$ultimoTaskId = $this->getUltimoTaskId ();
			$insertTask = $this->insertRelacionUsuarioTarea ($userId, $ultimoTaskId);

			
			if (!$insertTask) return TASK_CREATE_FAILED;
			
			return TASK_CREATED_SUCCESSFULLY;

			
			
		}else return TASK_CREATE_FAILED;

		
	}
	/**
	 * 
	 * Insertamos una relacion de usuario - tarea
	 * @param userId que se desea relacionar
	 * @param taskId que se desea relacionar 
	 * 
	 */
	 private function insertRelacionUsuarioTarea($userId,$taskId) {
		$query = "INSERT INTO user_task (user_id, task_id) VALUES (:user_id,:task_id)";
		$statement = $this->conn->prepare($query);
		$statement->bindParam(':user_id', $userId);
		$statement->bindParam(':task_id', $taskId);
		$insertTask = $statement->execute();
		return $insertTask;
	}

	/**
	 * Obtiene el id de la ultima tarea que haya el la BD
	 * 
	 */
	 private function getUltimoTaskId() {
		$query = "SELECT max(id) id FROM tasks";
		$statement = $this->conn->prepare($query);
		$statement->execute();
		$task = $statement->fetch(PDO::FETCH_ASSOC);
		var_dump($task);
		return $task['id'];
	}

	
	
	/**
	 * Insertar una tarea en la tabla tasks
	 */
	 private function insertTask($task) {
		$query = 'INSERT INTO tasks (task,status) VALUES (:task,1)';
		$statement = $this->conn->prepare($query);
		$statement->bindParam(':task', $task);
		return $statement->execute();
	}
	
	/** Obtener todas las tareas*/
	public function getTasks() {
		$query = "SELECT * FROM tasks";
		$statement = $this->conn->prepare($query);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	
	
	
}
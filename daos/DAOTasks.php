<?php
class DAOTasks {
	private $conn;
	public function __construct() {
		require_once 'db/DBConnect.php';
		$db = new DBConnect ();
		$this->conn = $db->conectar ();
	}
	
	/**
	 * Insertar una tarea en la BD
	 *
	 * @param
	 *        	userId Id del usuario que ha creado la tarea
	 * @param
	 *        	task String con la tarea que se ha creado
	 *        	
	 */
	public function addTask($userId, $task) {
		$insert = $this->insertTask ( $task ); // Insertamos la tarea en su tabla
		
		if ($insert) { // Si se ha insertado correctamente guardamos la relacion del usuario con su tarea
			
			$ultimoTaskId = $this->getUltimoTaskId ();
			$insertTask = $this->insertRelacionUsuarioTarea ( $userId, $ultimoTaskId );
			
			if ($insertTask)
				return TASK_CREATED_SUCCESSFULLY;
			
			return TASK_CREATE_FAILED;
		} else
			return TASK_CREATE_FAILED;
	}
	/**
	 *
	 * Insertamos una relacion de usuario - tarea
	 *
	 * @param
	 *        	userId que se desea relacionar
	 * @param
	 *        	taskId que se desea relacionar
	 *        	
	 */
	private function insertRelacionUsuarioTarea($userId, $taskId) {
		$query = "INSERT INTO user_tasks (user_id, task_id) VALUES (:user_id, :task_id )";
		$statement = $this->conn->prepare($query);
		$statement->bindParam(":user_id", $userId);
		$statement->bindParam(":task_id", $taskId);
		return $statement->execute();
	}
	
	/**
	 * Obtiene el id de la ultima tarea que haya el la BD
	 */
	private function getUltimoTaskId() {
		$query = "SELECT max(id) id FROM tasks";
		$statement = $this->conn->prepare ( $query );
		$statement->execute ();
		$task = $statement->fetch ( PDO::FETCH_ASSOC );
		return $task ['id'];
	}
	
	/**
	 * Insertar una tarea en la tabla tasks
	 */
	private function insertTask($task) {
		$query = 'INSERT INTO tasks (task,status) VALUES (:task,1)';
		$statement = $this->conn->prepare ( $query );
		$statement->bindParam ( ':task', $task );
		return $statement->execute ();
	}
	
	/**
	 * Obtener todas las tareas
	 */
	public function getTasks() {
		$query = "SELECT * FROM tasks";
		$statement = $this->conn->prepare ( $query );
		$res = $statement->execute ();
		if (! $res)
			return false;
		return $statement->fetchAll ( PDO::FETCH_ASSOC );
	}
	/**
	 * Obtener todas las tareas por un id
	 */
	public function getTaskById($id) {
		$query = "SELECT * FROM tasks where id = " . $id;
		$statement = $this->conn->prepare ( $query );
		$res = $statement->execute ();
		if (! $res)
			return false;
		return $statement->fetchAll ( PDO::FETCH_ASSOC );
	}
	/**
	 * Obtener todas las tareas por una cadena
	 */
	public function getTaskBySearchString($cadena = "") {
		$query = "SELECT * FROM tasks where task like '%" . $cadena . "%'";
		$statement = $this->conn->prepare ( $query );
		$res = $statement->execute ();
		if (! $res)
			return false;
		return $statement->fetchAll ( PDO::FETCH_ASSOC );
	}
	/**
	 * Obtener todas las tareas por un id de usuario
	 */
	public function getTaskByUsuarioId($id) {
		$query = "SELECT tasks.id, tasks.task, tasks.status, tasks.created_at FROM tasks, user_tasks ut where ut.user_id = " . $id . " and tasks.id = ut.task_id";
		$statement = $this->conn->prepare ( $query );
		$res = $statement->execute ();
		if (! $res)
			return false;
		return $statement->fetchAll ( PDO::FETCH_ASSOC );
	}
}
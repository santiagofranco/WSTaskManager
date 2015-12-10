<?php

class DAOUsuarios{
	
	private $conn;
	private $db;
	private $utils;
	
	public function __construct(){

		//Obtener el objeto PDO que me conecta con la base de datos y que me servira para hacer comprobaciones atacando la BD
		require_once '../db/DBConnect.php'; //Importamos la clase
		$this->db = new DBConnect();
		$this->conn = $this->db->conectar();	
		
		require_once 'utils/Utils.php';
		$this->utils = new Utils();
	}

	public function addUsuario($nombre, $email, $contrasena){

		require '../Config.php'; //Importamos los parametros de configuracion
		
		
		if(!$this->db->isEmailExiste($email)){ //Si no existe el email
			
			$contrasenaEncriptada = sha1($contrasena); //Generamos una contraseña encriptada
		
			$apikey =  $this->utils->generateApiKey(); //Generamos un api key
			
			$query = "INSERT INTO users (name, email, password_hash, api_key, status) values (:nombre,:email,:contrasena,:api_key,1)"; //Query a ejecutar
			$statement = $this->conn->prepare($query); //Con el obj PDO preparamos un objeto al que le pasamos parametros por seguridad
			// Pasamos los parametros
			$statement->bindParam(':nombre', $nombre);
			$statement->bindParam(':email', $email);
			$statement->bindParam(':contrasena', $contrasenaEncriptada);
			$statement->bindParam(':api_key', $apikey);
			$resultado = $statement->execute(); // Ejecutamos la query, con el commit implicito, devuelve booleano segun haya tenido exito o no la operacion
			
			if($resultado) return USER_CREATED_SUCCESSFULLY; //Si ha tenido exito crear el usuario devolvemos el codigo
			
			return USER_CREATE_FAILED;	//Si no ha tenido exito otro codigo
			
		}else return USER_ALREADY_EXISTED; //Si el usuario ya existe otro codigo
		
	}
	
	/**
	 * Comprobar si el email existe con la contraseña pasado por parametros
	 * */
	public function checkUsuario($email, $contrasena){
		
		$query = "SELECT password_hash FROM users WHERE email = :email";
		$statement = $this->conn->prepare($query);
		$statement->bindParam(':email',$email);
		$statement->execute();
		
		if ($statement->rowCount() > 0){ // Si las filas devueltas por la query son mas de 0 es que existe el email y pasamos a comprobar la pass 
			
			$user = $statement->fetch(PDO::FETCH_ASSOC); //Guardamos la primera fila devuelta, se supone que solo hay una fila
			
			//Si la contraseña encriptada devuelta por la query coincide con la contraseña encriptada que nos han pasado
			//devolvemos true si no coincide false
			if($user['password_hash'] == sha1($contrasena)) return true;
			return false;
			
		}
		
		return false; //Si el email no existe devolvemos false
	}
	
	
	
}

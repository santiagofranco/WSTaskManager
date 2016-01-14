<?php

/**
 * Instancia un objeto PDO encargado de atacar la BD
 * Ademas hace comprobaciones varias que requiren acceder la la BD
 * */
class DBConnect{
	
	private $conn;
	
	/**
	 * Constructor donde instanciamos un objeto que accede a la BD
	 * */
	public function __construct(){
		//Traemos los parametros de Config.php
		include 'Config.php';
		
		//Cadena de conexion con la base de datos, requerida por el objeto PDO
		$dsn = 'mysql:dbname='.DB_NAME.';host=' . DB_HOST . '';
		$usuario = DB_USERNAME;
		$contrasena = DB_PASSWORD;
		
		try {
			$this->conn = new \PDO ( $dsn, $usuario, $contrasena );
		} catch ( PDOException $e ) {
			throw new \Exception ( 'Fallo de la conexion a mysql. Error: ' . $e->getMessage () );
		}
	}
	
	/**
	 * Devolvemos el objeto PDO que usaran otros objetos para atacar ls BD
	 * */
	public function conectar(){
		return $this->conn;
	}
	
	/**
	 * Comprabar si existe una api key
	 * */
	public function checkApiKey($apiKey){
		$query = "SELECT api_key FROM users WHERE api_key = :api";
		$statement = $this->conn->prepare($query);
		$statement->bindParam(':api',$apiKey);
		$statement->execute();
		return $statement->rowCount()>0; //Devuelve si hay mas de un resultado o no
	}
	
	/**
	 * Comprobar si el el email ya existe en la BD
	 * @param String $email email
	 * @return boolean true -> email existe, false -> email no existe
	 */
	public function isEmailExiste($email) {
		$stmt = $this->conn->prepare("SELECT id from users WHERE email = :email");
		$stmt->bindParam(":email", $email);
		$stmt->execute();
		return $stmt->rowCount() > 0;
	}
	
	
}
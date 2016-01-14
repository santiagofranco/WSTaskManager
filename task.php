<?php

require_once 'daos/DAOTasks.php';
require_once 'parser/Parser.php';

$method = $_SERVER['REQUEST_METHOD'];
$parser = new Parser();
$dao = new DAOTasks();

if( $method === 'GET'){
	
	if(isset($_REQUEST['op'])){
		
		$op = $_REQUEST['op'];
		
		if($op === 'all_tasks'){
		
			if(isset($_REQUEST['id'])){
			
				$id = $_REQUEST['id'];
				
				$tasks = $dao->getTaskByUsuarioId($id);
				if(isset($_REQUEST['formato']) && $_REQUEST['formato'] == 'json')
					echo json_encode($tasks);
				else
					$parser->parsearArray($tasks,'tareas','tarea');
				
			}else{
				$parser->xmlError("Falta algun parametro", 'error');
			}
			
			
		}
		
	}else{
		$parser->xmlError("No se ha indicado la operacion", "error");		
	}
	
	
}else if ( $method === 'POST'){
	
}else if ( $method === 'PUT'){
	
}else if ( $method === 'DELETE'){
	
}

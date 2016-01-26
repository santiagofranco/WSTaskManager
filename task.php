<?php
require_once 'daos/DAOTasks.php';
require_once 'parser/Parser.php';

$method = $_SERVER ['REQUEST_METHOD'];
$parser = new Parser ();
$dao = new DAOTasks ();


if ($method === 'GET') {
	
	if (isset ( $_REQUEST ['op'] )) {
		
		$op = $_REQUEST ['op'];
		
		if ($op === 'all_tasks') {
			
			if (isset ( $_REQUEST ['id'] )) {
				
				$id = $_REQUEST ['id'];
				
				$tasks = $dao->getTaskByUsuarioId ( $id );
				if (isset ( $_REQUEST ['formato'] ) && $_REQUEST ['formato'] == 'json')
					echo json_encode ( $tasks );
				else
					$parser->parsearArray ( $tasks, 'tareas', 'tarea' );
			} else {
				if (isset ( $_REQUEST ['formato'] ) && $_REQUEST ['formato'] == 'json')
					echo '{"error":"Falta algun parametro"}';
					
				else
					$parser->xmlError ( "Falta algun parametro", 'error' );
			}
		}
	} else {
		$parser->xmlError ( "No se ha indicado la operacion", "error" );
	}
} else if ($method === 'POST') {
	
	if( isset($_REQUEST['op'])){
		
		$op = $_REQUEST['op'];
		
		if ($op === 'add_task'){
			
			if(isset($_REQUEST['idUser']) && isset($_REQUEST['task'])){
				
				
				$res = $dao->addTask($_REQUEST['idUser'], $_REQUEST['task']);
				if($res === TASK_CREATED_SUCCESSFULLY)
					echo '{"mensaje":"Se ha insertado la tarea","cod":"' . TASK_CREATED_SUCCESSFULLY . '"}';
				else if ($res === TASK_CREATE_FAILED)
					echo '{"mensaje":"Ha habido un error al insertar la tarea","cod":"' . TASK_CREATE_FAILED . '"}';
				
				
			}else{
				echo '{"error":"Falta algun parametro"}';
			}
		}
		
		
	}else 
		echo '{"error":"No se ha indicado la operacion"}';
	
	
} else if ($method === 'PUT') {
} else if ($method === 'DELETE') {
}

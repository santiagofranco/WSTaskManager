<?php
require 'daos/DAOUsuarios.php';

$method = $_SERVER ['REQUEST_METHOD'];
$dao = new DAOUsuarios ();

if ($method === 'GET') {
	
	echo 'Enviado por get, envialo por post tontorron, que son datos sensibles';
} else if ($method === 'POST') {
	
	if (isset ( $_REQUEST ['op'] )) {
		
		$op = $_REQUEST ['op'];
		
		if ($op === 'registro') {
			
			if (isset ( $_REQUEST ['email'] ) && isset ( $_REQUEST ['nombre'] ) && isset ( $_REQUEST ['pass'] )) {
				$res = $dao->addUsuario ( $_REQUEST ['nombre'], $_REQUEST ['email'], $_REQUEST ['pass'] );
				
				if ($res === USER_CREATED_SUCCESSFULLY)
					echo '{"mensaje":"Se ha insertado correctamente el usuario","cod":"' . USER_CREATED_SUCCESSFULLY . '"}';
				else if ($res == USER_ALREADY_EXISTED) {
					echo '{"mensaje":"El usuario ya existe","cod":"' . USER_ALREADY_EXISTED . '"}';
				} else if ($res == USER_CREATE_FAILED) {
					echo '{"mensaje":"Ha habido un error al crear eñ usuario","cod":"' . USER_CREATE_FAILED . '"}';
				}
			} else {
				echo '{"mensaje":"Falta algun parametro","cod":"5"}';
			}
		}else if($op === 'login'){
			
			if (isset ( $_REQUEST ['email'] ) && isset ( $_REQUEST ['pass'] )) {
				$user = $dao->checkUsuario($_REQUEST['email'], $_REQUEST['pass']);
				if($user === false){
					echo '{"mensaje":"el usuario no existe","cod":"7"}';
				}else{
					echo json_encode($user);
				}
			}else{
				echo '{"mensaje":"Falta algun parametro","cod":"5"}';
			}
			
		}
	} else {
		echo '{"mensaje":"Falta la operacion","cod":"6"}';
	}
} else if ($method === 'PUT') {
} else if ($method === 'DELETE') {
} 

<?php
require 'daos/DAOTasks.php';
require 'Config.php';
require 'db/DBConnect.php';
require 'parser/Parser.php';

$dao = new DAOTasks ();
$parser = new Parser();

if(isset($_REQUEST['op'])){
	
	$op = $_REQUEST['op'];

	if($op === 'user'){
		if(!isset($_REQUEST['id'])) $parser->xmlError("Falta el parametro id");
		else{
			$tasks = $dao->getTaskByUsuarioId($_REQUEST['id']);
			$parser->parsearArray($tasks,"tasks","task");
		}
	}else if ($op === 'search'){
		if(!isset($_REQUEST['string'])) $parser->xmlError("Falta el parametro string");
		else{
			$tasks = $dao->getTaskBySearchString($_REQUEST['string']);
			$parser->parsearArray($tasks,"tasks","task");
		}
	}
	
}else $parser->parsearArray($dao->getTasks(),"tasks","task");



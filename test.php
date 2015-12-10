<?php
require 'daos/DAOTasks.php';
require 'Config.php';
require 'db/DBConnect.php';
require 'parser/Parser.php';

$dao = new DAOTasks ();
$tasks = $dao->getTaskByUsuarioId(2);
$parser = new Parser();
if($tasks === false) $parser->xmlError("Puede que no exista ese registro");
else $parser->parsearArray($tasks,"tasks","task");

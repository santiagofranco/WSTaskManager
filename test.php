<?php
require 'daos/DAOTasks.php';
require 'db/DBConnect.php';
require 'parser/Parser.php';

$dao = new DAOTasks ();
$parser = new Parser();

$tasks = $dao->getTasks();
echo json_encode($tasks);



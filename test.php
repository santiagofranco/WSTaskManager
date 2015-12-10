<?php
require 'daos/DAOTasks.php';
require 'Config.php';
require 'db/DBConnect.php';


$dao = new DAOTasks();
$tasks = $dao->getTasks();

var_dump($tasks);

<?php
require 'daos/DAOTasks.php';
require 'db/DBConnect.php';
require 'parser/Parser.php';

$dao = new DAOTasks ();
$parser = new Parser();

$tasks = $dao->getTasks();

?>
<h1>Registro de usuario</h1>
<form action="registro.php" method="post">
<input type="hidden" name="op" value="registro" />
<p>Nombre:<input type="text" name="nombre"/></p>
<p>Email:<input type="text" name="email" /></p>
<p>Contraseņa:<input type="password" name="pass" /></p>
<input type="submit"/>
</form>

<h1>Login de usuario</h1>
<form action="registro.php" method="post">
<input type="hidden" name="op" value="login" />
<p>Email:<input type="text" name="email" /></p>
<p>Contraseņa:<input type="password" name="pass" /></p>
<input type="submit"/>
</form>

<h1>Prueba tarea</h1>
<form action="task.php" method="post">
<input type="hidden" name="op" value="add_task" />
<p>Id:<input type="text" name="idUser" /></p>
<p>Tarea:<input type="text" name="task" /></p>
<input type="submit"/>
</form>



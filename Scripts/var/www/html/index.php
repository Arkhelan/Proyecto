<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #04AA6D;
  color: white;
}
.nav2 {
  overflow: hidden;
  background-color: black;
}

.nav2 a {
  float: left;
  color: white;
  text-align: center;
  padding: 10px 16px;
  text-decoration: none;
  font-size: 17px;
}

.nav2 a:hover {
  background-color: #ddd;
  color: black;
}

.nav2 a.active {
  background-color: black;
  color: white;
}
</style>
</head>
<body>
<h1>
  Introducir nombre de empresa
</h1>
<div class="topnav">
  <a class="active" href="index.php">Inicio</a>
  <a href="index2.php">Archivos</a>
  <a href="inicio.php">Iniciar sesión</a>
  <a href="registro.php">Registrarse</a>
</div>
<div class='nav2'>
  <?php
  if ($_SESSION['user'] == 2){
    echo "<a href='grupos.php'>Grupos</a>"; 
    echo "<a href='assignacion.php'>Assignación USB</a> ";
    echo "<a href='administración.php'>Administración</a> ";
  }
  ?>
  </div>
<div style="padding-left:16px">
  <h2>Que hacemos?</h2>
  <p>Nosotros proporcionamos un software de detección de amenazas para prevenir la infección de los sistemas de una empresa a traves de ficheros que los empleados traigan en una memoria portatil.</p>
</div>
<div style="padding-left:16px">
  <h2>Como funciona?</h2>
  <p>Para poder analizar una memoria portatil, deberas dirijirte al servidor introducir el pendrive en la maquina, y este copiara todos los archivos para analizarlos utilizando la API de Virus Total, en cuando acabe el registro de los ficheros, los ficheros que no sean considerados una amenaza estaran disponibles en nuestro servidor web.</p>
</div>
</body>
</html>

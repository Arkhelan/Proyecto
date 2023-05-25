<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: inicio.php');
    exit;
}
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
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

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 17px;
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  margin: 0;
}

.topnav a:hover, .dropdown:hover .dropbtn {
  background-color: #ddd;
  color: black;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}
</style>
</head>
<body>
<h1>
  Introducir nombre de empresa
</h1>
<div class="topnav">
  <a class="active" href="index.php">Inicio</a>
  <div class="dropdown">
    <button class="dropbtn">Archivos
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="archivosv.php">Personal</a>
      <a href="archgrupo.php">Grupo</a>
      <a href="compartido.php">Compartido</a> <!-- Nuevo enlace -->
    </div>
  </div>
  <?php
  if (!isset($_SESSION['user'])) {
      echo '<a href="inicio.php">Iniciar sesión</a>';
      echo '<a href="registro.php">Registrarse</a>';
  } else {
      echo '<a href="logout.php">Cerrar sesión</a>';
  }
  ?>
</div>
<div class='nav2'>
  <?php
  if ($_SESSION['user'] == 2) {
    echo "<a href='grupos.php'>Grupos</a>"; 
    echo "<a href='assignacion.php'>Assignación USB</a> ";
    echo "<a href='administración.php'>Administración</a> ";
    echo "<a href='adminfichero.php'> Archivos dudosos</a>";
  }
  ?>
</div>   
<div> 
    <?php
    $servername = "localhost";
    $username = "usu";
    $password = "2003__Albert";
    $dbname = "usbdb";
    
    $usuario = $_SESSION['user'];
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT DISTINCT ID, nombre, direccion, MD5 FROM archivos WHERE ID IN (SELECT idarch FROM comp WHERE idusu = '$usuario') AND estado NOT IN (3) AND estado NOT IN (5)";
    
    $result = $conn->query($sql);
    

    if ($result->num_rows > 0) {
//	$link = $row["direccion"];
    //	$link = str_replace(" ", "%20", $link_db);
        echo "<table><tr><th>Nombre</th><th>Link Descarga</th></tr>";
        // output data of each row
      //  foreach($result as $row) {
     //     echo "<tr><td>".$row['nombre']."</td><td><a href="$link" download>Descargar</td></tr>";
      	foreach($result as $row) {
        $link = $row["direccion"];
        $link = str_replace(" ", "%20", $link);
        echo "<tr><td>".$row['nombre']."</td><td><a href='".$link."'>Descargar</a></td></tr>";
    }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
    </div>
</body>
</html>

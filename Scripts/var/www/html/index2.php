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
<div> 
    <?php
    $servername = "localhost";
    $username = "usu";
    $password = "2003__Albert";
    $dbname = "usbdb";
    
    $usuario = $_SESSION['user'];
    echo $usuario;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT ID, nombre, direccion, MD5 FROM archivos WHERE usb IN (SELECT id_usb FROM usb WHERE propietario = (SELECT id_usu FROM usuarios WHERE id_usu = '$usuario')) OR usb IN (SELECT id_usb FROM usb WHERE grupo = (SELECT id_gr FROM ubic WHERE id_usu = '$usuario'))";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table><tr><th>Nombre</th><th>Link Descarga</th></tr>";
        // output data of each row
        foreach($result as $row) {
          echo "<tr><td>".$row['nombre']."</td><td><a href=".$row['direccion']." download>Descargar</td></tr>";
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

<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: inicio.php');
    exit;
}
if ($_SESSION['user'] != 2) {
  header('Location: index.php');
  exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $archivoId = $_POST['archivo_id'];
    $nuevoEstado = $_POST['nuevo_estado'];

    $servername = "localhost";
    $username = "usu";
    $password = "2003__Albert";
    $dbname = "usbdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE archivos SET estado = '$nuevoEstado' WHERE ID = '$archivoId'";

    if ($conn->query($sql) === TRUE) {
        echo "El estado se actualizó correctamente.";
    } else {
        echo "Error al actualizar el estado: " . $conn->error;
    }

    $conn->close();
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
<?php
    $servername = "localhost";
    $username = "usu";
    $password = "2003__Albert";
    $dbname = "usbdb";

    $usuario = $_SESSION['user'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT archivos.ID, archivos.nombre AS name, archivos.estado, usb.id_usb, usuarios.nombre FROM archivos JOIN usb ON usb.id_usb = archivos.usb JOIN usuarios ON usuarios.id_usu = usb.propietario WHERE archivos.estado NOT IN (1,2,5)";

    $result = $conn->query($sql);
    ?>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Estado</th>
            <th>USB</th>
            <th>Usuario</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $archivoId = $row['ID'];
                $nombre = $row['name'];
                $estado = $row['estado'];
                $idUsb = $row['id_usb'];
                $nombreUsuario = $row['nombre'];

                echo "<tr>";
                echo "<td>$nombre</td>";
                echo "<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='archivo_id' value='$archivoId'>";
                echo "<select name='nuevo_estado'>";
                echo "<option value='3'" . ($estado == 3 ? " selected" : "") . ">3</option>";
                echo "<option value='4'" . ($estado == 4 ? " selected" : "") . ">4</option>";
                echo "<option value='5'" . ($estado == 5 ? " selected" : "") . ">5</option>";
                echo "</select>";
                echo "<button type='submit'>Actualizar</button>";
                echo "</form>";
                echo "</td>";
                echo "<td>$idUsb</td>";
                echo "<td>$nombreUsuario</td>";
                echo "<td></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No se encontraron resultados.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
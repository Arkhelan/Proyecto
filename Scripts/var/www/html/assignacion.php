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
if ($_POST) {
    $usb = $_POST['usb'];
    $grupo = $_POST['grupo'];
    $username = $_POST['usuario'];


    $servername = "localhost";
    $usuname = "usu";
    $pass = "2003__Albert";
    $dbname = "usbdb";
    
    // Create connection
    $conn = new mysqli($servername, $usuname, $pass, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    if ($username == 'NULL'){
        $update = "UPDATE usb SET grupo='$grupo' WHERE id_usb='$usb'";
    }
    else if ($grupo == 'NULL'){
        $update = "UPDATE usb SET propietario='$username' wHERE id_usb='$usb'";
    }
    else if ($usb == 'NULL'){
        
    }
    else{
        $update = "UPDATE usb SET propietario='$username', grupo='$grupo' WHERE id_usb='$usb'";
    }
    
    if (mysqli_query($conn, $update)){ 
            header('Location: assignacion.php');
            exit;
            echo "Alta registre";
    }
    /*if (mysqli_query($conn, $update)){
            
    }
    */
}
?>

<!DOCTYPE html>

<html>
<head>
    <title>Login Page</title>
    <style>
        table {
        margin: 0 auto;
    }
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
        }
        #container {
            width: 350px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        .form-group {
            margin-bottom: 10px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .btn {
            background-color: #337ab7;
            color: #fff;
            padding: 10px;
            border: 0;
            cursor: pointer;
            font-size: 16px;
        }
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
<br>
    <br>
    <br>
    <div id="container">
        <h1>Assignación USB</h1>
        <form method="post">
            <div class="form-group">
                <label for="username">USB</label>
                <select name="usb" id="usb" >
				<?php
    				$servername = "localhost";
    				$username = "usu";
    				$password = "2003__Albert";
    				$dbname = "usbdb";
				    
    				// Create connection
    				$conn = new mysqli($servername, $username, $password, $dbname);
    				// Check connection
    				if ($conn->connect_error) {
        				die("Connection failed: " . $conn->connect_error);
    				} 
				    
    				$sql = "SELECT id_usb, nombre FROM usb WHERE propietario IS NULL OR grupo IS NULL";
    				$result = $conn->query($sql);
				    echo "<option value= 'NULL'>-------</option>";
    				if ($result->num_rows > 0) {
        				while($row = $result->fetch_assoc()) {
							echo "<option value=".$row["id_usb"].">".$row["nombre"]."</option>";
        				}
    				}
    				$conn->close();
    			?>
				</select>
            </div>
            <div class="form-group">
                <label for="username">Usuario</label>
                <select name="usuario" id="usuario" >
				<?php
    				$servername = "localhost";
    				$username = "usu";
    				$password = "2003__Albert";
    				$dbname = "usbdb";
				    
    				// Create connection
    				$conn = new mysqli($servername, $username, $password, $dbname);
    				// Check connection
    				if ($conn->connect_error) {
        				die("Connection failed: " . $conn->connect_error);
    				} 
				    
    				$sql = "SELECT id_usu, nombre FROM usuarios";
    				$result = $conn->query($sql);
				    echo "<option value= 'NULL'>-------</option>";
    				if ($result->num_rows > 0) {
        				while($row = $result->fetch_assoc()) {
							echo "<option value=".$row["id_usu"].">".$row["nombre"]."</option>";
        				}
    				} else {
        				echo "<option value= 'NULL'>-------</option>";
    				}
    				$conn->close();
    			?>
                </select>
                <div class="form-group">
                <label for="username">Grupo</label>
                <select name="grupo" id="grupo" >
				<?php
    				$servername = "localhost";
    				$username = "usu";
    				$password = "2003__Albert";
    				$dbname = "usbdb";
				    
    				// Create connection
    				$conn = new mysqli($servername, $username, $password, $dbname);
    				// Check connection
    				if ($conn->connect_error) {
        				die("Connection failed: " . $conn->connect_error);
    				} 
				    
    				$sql = "SELECT id_gr, nombre FROM grupo";
    				$result = $conn->query($sql);
				    echo "<option value= 'NULL'>-------</option>";
    				if ($result->num_rows > 0) {
        				while($row = $result->fetch_assoc()) {
							echo "<option value=".$row["id_gr"].">".$row["nombre"]."</option>";
        				}
    				} else {
        				echo "<option value= 'NULL'>-------</option>";
    				}
    				$conn->close();
    			?>
				</select>
            </div>
            <div class="form-group">
                <input type="submit" value="Assignar" class="btn" />
            </div>
        </form>
    </div>                    
    <br>
    <br>
    <br>
    <?php
    $servername = "localhost";
    $username = "usu";
    $password = "2003__Albert";
    $dbname = "usbdb";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT id_usb, nombre, propietario, grupo FROM usb WHERE propietario = '1'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table style='margin: 0 auto; border: 2px solid; border-collapse:collapse; cellpadding: 15px;'><tr><th>ID</th><th>Nombre</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["id_usb"]."</td><td>".$row["nombre"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>

</body>
</html>

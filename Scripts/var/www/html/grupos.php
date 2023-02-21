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

if(isset($_POST['form1'])) {
  echo "<script> alert('Usuario o contraseña incorrectos'); </script>";
}

if(isset($_POST['form2'])) {
  // Aquí va el código para el formulario 2
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
        }
        /* #formulario1 {
            width: 350px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        } */
		#formulario2 {
            width: 350px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
		#formulario1 {
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
  font-family: Arial, sans-serif;
}
/*
h1 {
  text-align: center;
}
*/
#botones {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}

button {
  padding: 10px 20px;
  font-size: 18px;
  border-radius: 5px;
  border: none;
  background-color: blue;
  color: white;
  cursor: pointer;
  margin: 0 90px;
}


</style>
</head>
<body>
<h1>
  Introducir nombre de empresa
</h1>
<div class="topnav">
  <a class="active" <href="index.php">Inicio</a>
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
<br>
<br>
    <div id="botones">
      <button id="boton1">Crear grupo</button>
      <button id="boton2">Añadir usario a grupos</button>
    </div>
    <div id="formulario1" style="display: none;">
	<form action="crear.php" method="post" name="form1" id="form1">
            <div class="form-group">
                <label for="username">Nombre del grupo</label>
                <input type="text" name="grupo" id="grupo" />
            </div>
            <div class="form-group">
                <label for="username">Propietario</label>
                <select name="username" id="username" >
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
				    
    				if ($result->num_rows > 0) {
        				while($row = $result->fetch_assoc()) {
							echo "<option value=".$row["id_usu"].">".$row["nombre"]."</option>";
        				}
    				} else {
        				echo "<option value='NULL'>-------</option>";
    				}
    				$conn->close();
    			?>
          </select>
                
            </div>
            <div class="form-group">
                <input type="submit" value="Crear Grupo" class="btn" />
            </div>
        </form>
    </div>
    <div id="formulario2" style="display: none;">
	<form action="añadirg.php" method="post" name="form2" id="form2">
            <div class="form-group">
                <label for="username">Nombre del grupo</label>
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
				    
    				if ($result->num_rows > 0) {
        				while($row = $result->fetch_assoc()) {
							echo "<option value=".$row["id_gr"].">".$row["nombre"]."</option>";
        				}
    				} else {
        				echo "<option value='NULL'>-------</option>";
    				}
    				$conn->close();
    			?>
				</select>
            </div>
            <div class="form-group">
                <label for="usuario">Usuario</label>
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
				    
    				if ($result->num_rows > 0) {
        				while($row = $result->fetch_assoc()) {
							echo "<option value=".$row["id_usu"].">".$row["nombre"]."</option>";
        				}
    				} else {
        				echo "<option value='NULL'>-------</option>";
    				}
    				$conn->close();
    			?>
          </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Insertar" class="btn" />
            </div>
        </form>
    </div>
    <script type="text/javascript">
      var boton1 = document.getElementById("boton1");
      var boton2 = document.getElementById("boton2");
      var formulario1 = document.getElementById("formulario1");
      var formulario2 = document.getElementById("formulario2");

      boton1.addEventListener("click", function() {
        formulario1.style.display = "block";
        formulario2.style.display = "none";
      });

      boton2.addEventListener("click", function() {
        formulario1.style.display = "none";
        formulario2.style.display = "block";
      });
    </script>
</body>
</html>

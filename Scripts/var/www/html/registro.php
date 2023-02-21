<!DOCTYPE html>

<?php
session_start();

$username = '';
$error = '';

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];

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
    $query = "SELECT id_usu FROM usuarios WHERE nombre = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
	echo "<script> alert('Este nombre de usuario ya esta en uso, inserta uno diferente'); </script>";
    } else {
        $insert = "INSERT INTO usuarios (nombre, pass) VALUES ('$username', '$password')";
	if (mysqli_query($conn, $insert)) 

            echo "Alta registre";
    }

    mysqli_close($conn);
}
?>

<html>
<head>
    <title>Login Page</title>
    <style>
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
  <a href="registrar.php">Registrarse</a>
</div>
<div class='nav2'>
<?php
if ($_SESSION['user'] == 2){
	echo "<a href='grupos.php'>Inicio</a>"; 
	echo "<a href='assignacion.php'>Assignación USB</a> ";
	echo "<a href='administración.php'>Administración</a> ";
}
?>
</div>
    <br>
    <br>
    <br>
    <div id="container">
        <h1>Registrarse</h1>
        <form method="post">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" name="username" id="username" />
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" />
            </div>
            <div class="form-group">
                <input type="submit" value="Iniciar Sesión" class="btn" />
            </div>
        </form>
    </div>
</body>
</html>

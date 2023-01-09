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
</style>
</head>
<body>
<h1>
  Introducir nombre de empresa
</h1>
<div class="topnav">
  <a class="active" href="index.html">Inicio</a>
  <a href="index2.php">Archivos</a>
  <!--<a href="#contact">Contact</a>
  <a href="#about">About</a> -->
</div>
    
    <?php
    $servername = "localhost";
    $username = "usu";
    $password = "pswd";
    $dbname = "usbdb";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT ID, nombre, direccion, MD5 FROM archivos";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Nombre</th><th>Link Descarga</th><th>MD5</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["ID"]."</td><td>".$row["nombre"]."</td><td><a href=".$row["direccion"]." download>Descargar</td><td>".$row["MD5"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
</body>
</html>

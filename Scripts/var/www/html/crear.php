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
$error = '';

if ($_POST) {
    $username = $_POST['username'];
    $grupo = $_POST['grupo'];

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
    $query = "SELECT nombre FROM grupo WHERE nombre = '$grupo'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
	echo "<script> alert('Este nombre de grupo ya esta en uso, escoje uno distinto'); </script>";
    } else {
            $insert = "INSERT INTO grupo (nombre, propietario) VALUES ('$grupo', '$username')";
	        if (mysqli_query($conn, $insert)){
                $query = "SELECT id_gr FROM grupo WHERE nombre = '$grupo' AND propietario = '$username'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $fin = $row['id_gr'];
                $insert = "INSERT INTO ubic (id_gr, id_usu) VALUES ('$fin', '$username')";
                if (mysqli_query($conn, $insert)){
                    header('Location: grupos.php');
                    exit;
                    echo "Alta registre";
                }
            }
    }

    mysqli_close($conn);
}
?>
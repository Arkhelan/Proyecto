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
    $username = $_POST['usuario'];
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
    $query = "SELECT id_gr, id_usu FROM ubic WHERE id_gr = '$grupo' AND id_usu = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
	echo "<script> alert('Este usuario ya esta en este grupo'); </script>";
    } else {
        $insert = "INSERT INTO ubic (id_gr, id_usu) VALUES ('$grupo', '$username')";
	if (mysqli_query($conn, $insert)){ 
            header('Location: grupos.php');
            exit;
            echo "Alta registre";
    }
}

    mysqli_close($conn);
}
?>
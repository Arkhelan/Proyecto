<?php
$id = $_POST['id'];
$estado = $_POST['estado'];

$servername = "localhost";
$username = "usu";
$password = "2003__Albert";
$dbname = "usbdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE archivos SET estado = '$estado' WHERE ID = '$id'";

if ($conn->query($sql) === TRUE) {
    echo "El estado se actualizó correctamente.";
} else {
    echo "Error al actualizar el estado: " . $conn->error;
}

$conn->close();
?>
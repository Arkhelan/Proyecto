<?php
require_once '../app/Models/USB.php';

$usbs = USB::all();

foreach ($usbs as $usb) {
    echo "ID: " . $usb->id . "<br>";
    echo "Nombre del USB: " . $usb->name . "<br>";
    echo "Software peligroso: " . ($usb->is_dangerous ? "Sí" : "No") . "<br>";
    echo "Archivos seguros:<br>";

    foreach ($usb->files as $file) {
        echo "&emsp;Nombre del archivo: " . $file->name . "<br>";
        echo "&emsp;URL de descarga: " . $file->download_url . "<br>";
        echo "<br>";
    }

    echo "<hr>";
}

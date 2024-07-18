<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $centroMusical = isset($_POST['centroMusical']) ? trim($_POST['centroMusical']) : '';
    $semestre = isset($_POST['semestre']) ? intval($_POST['semestre']) : 0;
    $ano = isset($_POST['ano']) ? intval($_POST['ano']) : 0;
    $fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : '';
    $acepto_terminos = isset($_POST['acepto_terminos']) ? 1 : 0;

    if (!empty($centroMusical) && !empty($semestre) && !empty($ano) && !empty($fecha) && $acepto_terminos) {
        $consulta = "INSERT INTO beneficiario (centroMusical, semestre, ano, fecha, acepto_terminos) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($consulta);
        
        if ($stmt === false) {
            echo "<script>alert('Error al preparar la consulta: " . $conn->error . "');</script>";
        } else {
            $stmt->bind_param("siisi", $centroMusical, $semestre, $ano, $fecha, $acepto_terminos);
            if ($stmt->execute()) {
                echo "<script>alert('Los datos se han insertado correctamente en la base de datos.');</script>";
            } else {
                echo "<script>alert('Error al insertar los datos en la base de datos: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }
    } else {
        echo "<script>alert('Por favor, complete todos los campos correctamente.');</script>";
    }

    header("Location: bienvenida.html");
    exit();
}

$conn->close();






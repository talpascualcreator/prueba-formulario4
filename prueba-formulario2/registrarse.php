<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener y validar los datos del formulario
    $centroMusical = isset($_POST['centroMusical']) ? trim($_POST['centroMusical']) : '';
    $semestre = isset($_POST['semestre']) ? intval($_POST['semestre']) : 0;
    $ano = isset($_POST['ano']) ? intval($_POST['ano']) : 0;
    $fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : '';
    $primerNombre = isset($_POST['primerNombre']) ? trim($_POST['primerNombre']) : '';
    $segundoNombre = isset($_POST['segundoNombre']) ? trim($_POST['segundoNombre']) : '';
    $primerApellido = isset($_POST['primerApellido']) ? trim($_POST['primerApellido']) : '';
    $segundoApellido = isset($_POST['segundoApellido']) ? trim($_POST['segundoApellido']) : '';
    $acepto_terminos = isset($_POST['acepto_terminos']) ? 1 : 0;

    // Verificar que todos los campos requeridos estén completos
    if (!empty($centroMusical) && !empty($semestre) && !empty($ano) && !empty($fecha) && !empty($primerNombre) && !empty($primerApellido) && $acepto_terminos && isset($_FILES['fotoBeneficiario']) && $_FILES['fotoBeneficiario']['error'] == 0) {
        // Obtener el contenido del archivo de imagen
        $fotoBeneficiario = file_get_contents($_FILES['fotoBeneficiario']['tmp_name']);

        // Preparar la consulta de inserción
        $consulta = "INSERT INTO beneficiario (centroMusical, semestre, ano, fecha, fotoBeneficiario, primerNombre, segundoNombre, primerApellido, segundoApellido, acepto_terminos) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($consulta);

        if ($stmt === false) {
            echo "<script>alert('Error al preparar la consulta: " . $conn->error . "');</script>";
        } else {
            // Enlazar los parámetros y ejecutar la consulta
            $stmt->bind_param("siissssssi", $centroMusical, $semestre, $ano, $fecha, $fotoBeneficiario, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $acepto_terminos);
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

    // Redirigir a la página de bienvenida
    header("Location: bienvenida.html");
    exit();
}

// Cerrar la conexión
$conn->close();










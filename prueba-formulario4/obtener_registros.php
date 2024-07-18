<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Crear conexión usando la variable $conn del archivo de conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL para obtener los registros
$sql = "SELECT primerNombre, segundoNombre, primerApellido, segundoApellido, tipoDocumento, numeroDocumento, fechaNacimiento, edad, lugarNacimiento, genero, tipoSanguineo, direccion, estrato, correoElectronico, telefono, centroMusical, instrumentoMusical, semestre, ano, fecha FROM beneficiario";
$result = $conn->query($sql);

$registros = array();

if ($result->num_rows > 0) {
    // Salida de datos de cada fila
    while ($row = $result->fetch_assoc()) {
        $registros[] = $row;
    }
} else {
    echo json_encode(array("mensaje" => "No se encontraron registros"));
    exit;
}

$conn->close();

// Devolver datos en formato JSON
echo json_encode($registros);



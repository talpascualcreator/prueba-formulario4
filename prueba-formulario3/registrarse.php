<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener y validar los datos del formulario
    $primerNombre = isset($_POST['primerNombre']) ? trim($_POST['primerNombre']) : '';
    $segundoNombre = isset($_POST['segundoNombre']) ? trim($_POST['segundoNombre']) : '';
    $primerApellido = isset($_POST['primerApellido']) ? trim($_POST['primerApellido']) : '';
    $segundoApellido = isset($_POST['segundoApellido']) ? trim($_POST['segundoApellido']) : '';
    $tipoDocumento = isset($_POST['tipoDocumento']) ? trim($_POST['tipoDocumento']) : '';
    $numeroDocumento = isset($_POST['numeroDocumento']) ? trim($_POST['numeroDocumento']) : '';
    $fechaNacimiento = isset($_POST['fechaNacimiento']) ? trim($_POST['fechaNacimiento']) : '';
    $edad = isset($_POST['edad']) ? intval($_POST['edad']) : 0;
    $lugarNacimiento = isset($_POST['lugarNacimiento']) ? trim($_POST['lugarNacimiento']) : '';
    $genero = isset($_POST['genero']) ? trim($_POST['genero']) : '';
    $tipoSanguineo = isset($_POST['tipoSanguineo']) ? trim($_POST['tipoSanguineo']) : '';
    $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
    $estrato = isset($_POST['estrato']) ? intval($_POST['estrato']) : 0;
    $correoElectronico = isset($_POST['correoElectronico']) ? trim($_POST['correoElectronico']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $centroMusical = isset($_POST['centroMusical']) ? trim($_POST['centroMusical']) : '';
   
    $semestre = isset($_POST['semestre']) ? intval($_POST['semestre']) : 0;
    $semestre = isset($_POST['semestre']) ? intval($_POST['semestre']) : 0;
    $ano = isset($_POST['ano']) ? intval($_POST['ano']) : 0;
    $fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : '';
    $acepto_terminos = isset($_POST['acepto_terminos']) ? 1 : 0;

    // Verificar que todos los campos requeridos estén completos
    if (!empty($primerNombre) && !empty($primerApellido) && !empty($tipoDocumento) && !empty($numeroDocumento) && !empty($fechaNacimiento) && !empty($edad) && !empty($lugarNacimiento) && !empty($genero) && !empty($tipoSanguineo) && !empty($direccion) && !empty($estrato) && !empty($correoElectronico) && !empty($telefono) && !empty($centroMusical) && !empty($semestre) && !empty($ano) && !empty($fecha) && $acepto_terminos) {
        // Preparar la consulta de inserción para la tabla Beneficiario
        $consultaBeneficiario = "INSERT INTO beneficiario (primerNombre, segundoNombre, primerApellido, segundoApellido, tipoDocumento, numeroDocumento, fechaNacimiento, edad, lugarNacimiento, genero, tipoSanguineo, direccion, estrato, correoElectronico, telefono, centroMusical, semestre, ano, fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtBeneficiario = $conn->prepare($consultaBeneficiario);

        if ($stmtBeneficiario === false) {
            echo "<script>alert('Error al preparar la consulta: " . $conn->error . "');</script>";
        } else {
            // Enlazar los parámetros y ejecutar la consulta
            $stmtBeneficiario->bind_param("sssssssisssisssssss", $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $tipoDocumento, $numeroDocumento, $fechaNacimiento, $edad, $lugarNacimiento, $genero, $tipoSanguineo, $direccion, $estrato, $correoElectronico, $telefono, $centroMusical, $instrumentoMusical, $semestre, $ano, $fecha);
            if ($stmtBeneficiario->execute()) {
                $beneficiarioId = $stmtBeneficiario->insert_id;

                // Datos del Representante
                $nombresRepresentante = isset($_POST['nombresRepresentante']) ? trim($_POST['nombresRepresentante']) : '';
                $apellidosRepresentante = isset($_POST['apellidosRepresentante']) ? trim($_POST['apellidosRepresentante']) : '';
                $tipoDocumentoRepresentante = isset($_POST['tipoDocumentoRepresentante']) ? trim($_POST['tipoDocumentoRepresentante']) : '';
                $numeroDocumentoRepresentante = isset($_POST['numeroDocumentoRepresentante']) ? trim($_POST['numeroDocumentoRepresentante']) : '';
                $direccionRepresentante = isset($_POST['direccionRepresentante']) ? trim($_POST['direccionRepresentante']) : '';
                $barrioRepresentante = isset($_POST['barrioRepresentante']) ? trim($_POST['barrioRepresentante']) : '';
                $telefonoRepresentante = isset($_POST['telefonoRepresentante']) ? trim($_POST['telefonoRepresentante']) : '';
                $correoRepresentante = isset($_POST['correoRepresentante']) ? trim($_POST['correoRepresentante']) : '';
                $ocupacionRepresentante = isset($_POST['ocupacionRepresentante']) ? trim($_POST['ocupacionRepresentante']) : '';

                if (!empty($nombresRepresentante) && !empty($apellidosRepresentante) && !empty($tipoDocumentoRepresentante) && !empty($numeroDocumentoRepresentante) && !empty($direccionRepresentante) && !empty($barrioRepresentante) && !empty($telefonoRepresentante) && !empty($correoRepresentante) && !empty($ocupacionRepresentante)) {
                    $consultaRepresentante = "INSERT INTO representante (beneficiarioId, nombres, apellidos, tipoDocumento, numeroDocumento, direccion, barrio, telefono, correoElectronico, ocupacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmtRepresentante = $conn->prepare($consultaRepresentante);
                    if ($stmtRepresentante === false) {
                        echo "<script>alert('Error al preparar la consulta de representante: " . $conn->error . "');</script>";
                    } else {
                        $stmtRepresentante->bind_param("isssssssss", $beneficiarioId, $nombresRepresentante, $apellidosRepresentante, $tipoDocumentoRepresentante, $numeroDocumentoRepresentante, $direccionRepresentante, $barrioRepresentante, $telefonoRepresentante, $correoRepresentante, $ocupacionRepresentante);
                        if (!$stmtRepresentante->execute()) {
                            echo "<script>alert('Error al insertar los datos del representante: " . $stmtRepresentante->error . "');</script>";
                        }
                        $stmtRepresentante->close();
                    }
                }

                // Datos de la Madre
                $nombresMadre = isset($_POST['nombresMadre']) ? trim($_POST['nombresMadre']) : '';
                $apellidosMadre = isset($_POST['apellidosMadre']) ? trim($_POST['apellidosMadre']) : '';
                $tipoDocumentoMadre = isset($_POST['tipoDocumentoMadre']) ? trim($_POST['tipoDocumentoMadre']) : '';
                $numeroDocumentoMadre = isset($_POST['numeroDocumentoMadre']) ? trim($_POST['numeroDocumentoMadre']) : '';
                $direccionMadre = isset($_POST['direccionMadre']) ? trim($_POST['direccionMadre']) : '';
                $barrioMadre = isset($_POST['barrioMadre']) ? trim($_POST['barrioMadre']) : '';
                $telefonoMadre = isset($_POST['telefonoMadre']) ? trim($_POST['telefonoMadre']) : '';
                $correoMadre = isset($_POST['correoMadre']) ? trim($_POST['correoMadre']) : '';
                $ocupacionMadre = isset($_POST['ocupacionMadre']) ? trim($_POST['ocupacionMadre']) : '';

                if (!empty($nombresMadre) && !empty($apellidosMadre) && !empty($tipoDocumentoMadre) && !empty($numeroDocumentoMadre) && !empty($direccionMadre) && !empty($barrioMadre) && !empty($telefonoMadre) && !empty($correoMadre) && !empty($ocupacionMadre)) {
                    $consultaMadre = "INSERT INTO madre (beneficiarioId, nombres, apellidos, tipoDocumento, numeroDocumento, direccion, barrio, telefono, correoElectronico, ocupacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmtMadre = $conn->prepare($consultaMadre);
                    if ($stmtMadre === false) {
                        echo "<script>alert('Error al preparar la consulta de madre: " . $conn->error . "');</script>";
                    } else {
                        $stmtMadre->bind_param("isssssssss", $beneficiarioId, $nombresMadre, $apellidosMadre, $tipoDocumentoMadre, $numeroDocumentoMadre, $direccionMadre, $barrioMadre, $telefonoMadre, $correoMadre, $ocupacionMadre);
                        if (!$stmtMadre->execute()) {
                            echo "<script>alert('Error al insertar los datos de la madre: " . $stmtMadre->error . "');</script>";
                        }
                        $stmtMadre->close();
                    }
                }

                // Datos del Padre
                $nombresPadre = isset($_POST['nombresPadre']) ? trim($_POST['nombresPadre']) : '';
                $apellidosPadre = isset($_POST['apellidosPadre']) ? trim($_POST['apellidosPadre']) : '';
                $tipoDocumentoPadre = isset($_POST['tipoDocumentoPadre']) ? trim($_POST['tipoDocumentoPadre']) : '';
                $numeroDocumentoPadre = isset($_POST['numeroDocumentoPadre']) ? trim($_POST['numeroDocumentoPadre']) : '';
                $direccionPadre = isset($_POST['direccionPadre']) ? trim($_POST['direccionPadre']) : '';
                $barrioPadre = isset($_POST['barrioPadre']) ? trim($_POST['barrioPadre']) : '';
                $telefonoPadre = isset($_POST['telefonoPadre']) ? trim($_POST['telefonoPadre']) : '';
                $correoPadre = isset($_POST['correoPadre']) ? trim($_POST['correoPadre']) : '';
                $ocupacionPadre = isset($_POST['ocupacionPadre']) ? trim($_POST['ocupacionPadre']) : '';

                if (!empty($nombresPadre) && !empty($apellidosPadre) && !empty($tipoDocumentoPadre) && !empty($numeroDocumentoPadre) && !empty($direccionPadre) && !empty($barrioPadre) && !empty($telefonoPadre) && !empty($correoPadre) && !empty($ocupacionPadre)) {
                    $consultaPadre = "INSERT INTO padre (beneficiarioId, nombres, apellidos, tipoDocumento, numeroDocumento, direccion, barrio, telefono, correoElectronico, ocupacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmtPadre = $conn->prepare($consultaPadre);
                    if ($stmtPadre === false) {
                        echo "<script>alert('Error al preparar la consulta de padre: " . $conn->error . "');</script>";
                    } else {
                        $stmtPadre->bind_param("isssssssss", $beneficiarioId, $nombresPadre, $apellidosPadre, $tipoDocumentoPadre, $numeroDocumentoPadre, $direccionPadre, $barrioPadre, $telefonoPadre, $correoPadre, $ocupacionPadre);
                        if (!$stmtPadre->execute()) {
                            echo "<script>alert('Error al insertar los datos del padre: " . $stmtPadre->error . "');</script>";
                        }
                        $stmtPadre->close();
                    }
                }

                echo "<script>alert('Los datos se han insertado correctamente en la base de datos.');</script>";
            } else {
                echo "<script>alert('Error al insertar los datos en la base de datos: " . $stmtBeneficiario->error . "');</script>";
            }
            $stmtBeneficiario->close();
        }
    } else {
        echo "<script>alert('Por favor, complete todos los campos correctamente y acepte los términos y condiciones.');</script>";
    }

    // Redirigir a la página de bienvenida
    header("Location: bienvenida.html");
    exit();
}

// Cerrar la conexión
$conn->close();












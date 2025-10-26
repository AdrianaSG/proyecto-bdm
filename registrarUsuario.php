<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $genero = $_POST["genero"];
    $otro_genero = $_POST["otro_genero"] ?? null;
    $pais_nacimiento = $_POST["pais_nacimiento"];
    $nacionalidad = $_POST["nacionalidad"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Calcular edad
    $edad = (int)((time() - strtotime($fecha_nacimiento)) / (365.25 * 24 * 60 * 60));

    // Validar edad mínima antes de continuar
   if ($edad < 12) {
    header("Location: Registro.php?error=edad");
    exit;
}

    // Archivo (foto o video)
    $tipo = null;
    $contenido = null;
    if (isset($_FILES["foto"]) && $_FILES["foto"]["size"] > 0) {
        $mime = $_FILES["foto"]["type"];
        $tipo = (strpos($mime, 'video') !== false) ? 'video' : 'imagen';
        $contenido = file_get_contents($_FILES["foto"]["tmp_name"]);
    }

    // Si el género es "otro", reemplazamos el valor
    if ($genero === "otro" && !empty($otro_genero)) {
        $genero = $otro_genero;
    }

    try {
        $stmt = $pdo->prepare("CALL sp_registrar_usuario(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $nombre);
        $stmt->bindParam(2, $fecha_nacimiento);
        $stmt->bindParam(3, $genero);
        $stmt->bindParam(4, $pais_nacimiento);
        $stmt->bindParam(5, $nacionalidad);
        $stmt->bindParam(6, $correo);
        $stmt->bindParam(7, $contrasena);
        $stmt->bindParam(8, $tipo);
        $stmt->bindParam(9, $contenido, PDO::PARAM_LOB);
        $stmt->execute();

       header("Location: Mundiales.php?registro=exito");
       exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
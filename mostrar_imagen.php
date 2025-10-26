<?php
include 'conexion.php'; // Asegúrate de que crea $pdo, no $conn

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        // Llamamos al procedimiento almacenado
        $stmt = $pdo->prepare("CALL sp_mostrar_imagen(:id)");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Determinar el tipo MIME según la columna 'tipo'
            $mime = ($row['tipo'] === 'imagen') ? 'image/jpeg' : 'video/mp4';
            header("Content-Type: $mime");
            echo $row['contenido'];
        } else {
            // Si no se encontró imagen
            header("Content-Type: image/jpeg");
            readfile("https://i.pinimg.com/736x/6f/33/c6/6f33c6716320b1f0a9514703319e3165.jpg");
        }

    } catch (PDOException $e) {
        echo "Error al obtener la imagen: " . $e->getMessage();
    }

} else {
    echo "ID no especificado";
}
?>
<?php
session_start();
include("conexion.php"); // Conexión PDO a tu BD

// 1. ANUNCIA que su respuesta será JSON
header('Content-Type: application/json');

// 2. PREPARA la respuesta por defecto
$response = ['success' => false, 'message' => 'Usuario o contraseña incorrectos.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    try {
        // Llamamos al SP de tu amiga (el inseguro)
        $stmt = $pdo->prepare("CALL sp_login_usuario(:correo, :password)");
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // ¡ÉXITO! Guardamos datos en la sesión
            $_SESSION['ID_Usuario'] = $user['ID_Usuario'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['pais'] = $user['pais_nacimiento'];
            $_SESSION['nacionalidad'] = $user['nacionalidad'];
            $_SESSION['rol'] = $user['rol'];
            $_SESSION['foto'] = $user['ID_Multimedia'];

            // Preparamos la respuesta de ÉXITO en JSON
            $response['success'] = true;
            $response['message'] = 'Inicio de sesión exitoso.';
        
        }
        // Si $user está vacío, no hacemos nada,
        // simplemente se enviará la respuesta de error por defecto.

    } catch (PDOException $e) {
        $response['message'] = 'Error en la base de datos.';
    }
} else {
    $response['message'] = 'Método no permitido.';
}

// 3. DEVUELVE la respuesta en formato JSON
// (Sea de éxito o de error)
echo json_encode($response);
?>

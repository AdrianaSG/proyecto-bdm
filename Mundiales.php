

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MUNDIALES</title>
  <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/544/544338.png">
  <link rel="stylesheet" href="css/bootstrap.css"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <script src="js/bootstrap.bundle.js"></script>  
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="js/script.js"></script>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<?php
session_start();

// Mensajes de alerta
if (isset($_GET['registro']) && $_GET['registro'] === 'exito') {
    echo "<div class='alert alert-success alert-dismissible fade show text-center' role='alert' style='margin-top:80px;'>
            ✅ ¡Registro exitoso! Bienvenido a Mundiales.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
}

if (isset($_GET['login']) && $_GET['login'] === 'exito') {
    echo "<div class='alert alert-success alert-dismissible fade show text-center' role='alert' style='margin-top:80px;'>
            👋 ¡Bienvenido {$_SESSION['nombre']}!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
}

if (isset($_GET['error']) && $_GET['error'] === 'login') {
    echo "<div class='alert alert-danger alert-dismissible fade show text-center' role='alert' style='margin-top:80px;'>
            ❌ Usuario o contraseña incorrectos.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
}
?>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold animate__animated animate__bounceInLeft" href="#">⚽ Mundiales</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Pais</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Mas Likes</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Mas Comentarios</a></li>
      </ul>

      <div class="ms-3 d-flex align-items-center">
        <?php if (isset($_SESSION['nombre'])): ?>
          <!-- Usuario logueado -->
          <a href="Logout.php" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
        <?php else: ?>
          <!-- Usuario no logueado -->
          <button type="button" class="btn btn-outline-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
            Iniciar Sesión
          </button>
          <a href="Registro.php" class="btn btn-success btn-sm">Registrarse</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<!-- MODAL LOGIN -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-light border border-success">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="loginModalLabel">Iniciar Sesión</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="loginForm">
          <div class="mb-3">
            <label for="correo" class="form-label">Correo Electronico</label>
            <input type="text" class="form-control" id="correo" name="correo" placeholder="Ingresa tu usuario" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
        </div>
        
        <button type="submit" class="btn btn-success w-100">Iniciar Sesión</button>
        
        <div id="login-error" class="alert alert-danger mt-3 d-none"></div>
        
        </form>
      </div>
      <div class="modal-footer">
        <small class="text-muted">¿No tienes cuenta? <a href="Registro.php" class="text-success">Regístrate aquí</a></small>
      </div>
    </div>
  </div>
</div>

<!-- PERFIL-BAR (SECCIÓN REACOMODADA) -->
<section class="perfil-bar py-3 bg-dark">
  <div class="container">
    <div class="row align-items-center">

      <!-- Foto de perfil + nombre -->
      <div class="col-md-4 d-flex align-items-center mb-2 mb-md-0">
        <?php if (isset($_SESSION['nombre'])): ?>
            <img src="mostrar_imagen.php?id=<?php echo htmlspecialchars($_SESSION['foto']); ?>" 
            alt="Foto perfil" class="rounded-circle me-3" width="55" height="55">
          <div>
            <h6 class="mb-0 text-white"><?php echo htmlspecialchars($_SESSION['nombre']); ?></h6>
            <small class="text-muted"><?php echo htmlspecialchars($_SESSION['pais']); ?></small>
          </div>
        <?php else: ?>
          <img src="https://i.pinimg.com/736x/27/5d/e3/275de32eba38a6a78e9dc6836dbe763e.jpg" 
               alt="Foto perfil" class="rounded-circle me-3" width="55" height="55">
          <div>
            <h6 class="mb-0 text-white">Invitado</h6> 
            <small class="text-muted">🌍 Pais</small>
          </div>
        <?php endif; ?>
      </div>

      <!-- Buscador -->
      <div class="col-md-4 mb-2 mb-md-0">
        <form class="d-flex">
          <input class="form-control form-control-sm me-2" type="search" placeholder="Buscar mundial..." aria-label="Search" style="max-width: 200px;">
          <button class="btn btn-outline-success btn-sm" type="submit">Buscar</button>
        </form>
      </div>

      <!-- Botones -->
      <div class="col-md-4 text-md-end">
        <div class="mb-2">
          <a href="perfil.php" class="btn btn-outline-success btn-sm">Perfil</a>
          <a href="crearCatego.php" class="btn btn-outline-warning btn-sm me-2">➕ Categoría</a>
          <a href="crearMundial.php" class="btn btn-outline-info btn-sm me-2">🏆 Mundial</a>
          <a href="aprobarPubli.php" class="btn btn-outline-success btn-sm">✅ Publicación</a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- CARRUSEL -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://a.espncdn.com/combiner/i?img=/photo/2025/0907/r1542038_1296x729_16-9.jpg" class="d-block w-100" alt="Brasil 2014">
      <div class="carousel-caption">
        <h5>Brasil 2014</h5>
        <p>El mundial del histórico 7-1 a Brasil.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://concepto.de/wp-content/uploads/2015/02/futbol-1-e1550783399724-800x400.jpg" class="d-block w-100" alt="Rusia 2018">
      <div class="carousel-caption">
        <h5>Rusia 2018</h5>
        <p>Francia campeón con Mbappé como figura.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://assets.goal.com/images/v3/blt839aed3346a6eb90/GettyImages-1450108664.jpg?auto=webp&format=pjpg&width=3840&quality=60" class="d-block w-100" alt="Qatar 2022">
      <div class="carousel-caption">
        <h5>Qatar 2022</h5>
        <p>Argentina y Messi levantaron la Copa.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>


<div class="container py-5">
  <h2 class="text-center mb-4">Mundiales</h2>
  <div class="row g-4">

<div class="col-md-4">
  <div class="card shadow-lg animate__animated animate__bounceInUp">
    <img src="https://png.pngtree.com/thumb_back/fh260/background/20231229/pngtree-dynamic-world-championship-football-cup-background-national-team-emblem-with-soccer-image_13876819.png" class="card-img-top" alt="Brasil 2014">
    <div class="card-body">
      <h5 class="card-title">Brasil 2014</h5>
      <div class="extra-info">
        <p class="card-text">
          Alemania se consagró campeón tras vencer a Argentina. 
          El mundial es recordado por el histórico 7-1 a Brasil en semifinales.
        </p>
        <a href="Publicaciones.html" class="btn btn-success btn-sm">Ver Publicaciones</a>
      </div>
    </div>
  </div>
</div>


<div class="col-md-4">
  <div class="card shadow-lg animate__animated animate__bounceInUp">
    <img src="https://png.pngtree.com/thumb_back/fh260/background/20231229/pngtree-dynamic-world-championship-football-cup-background-national-team-emblem-with-soccer-image_13876819.png" class="card-img-top" alt="Brasil 2014">
   <div class="card-body">
      <h5 class="card-title">Rusia 2018</h5>
      <div class="extra-info">
        <p class="card-text">
          Francia obtuvo su segunda Copa del Mundo tras vencer a Croacia 4-2 
          en una final llena de goles.
        </p>
        <a href="Publicaciones.html" class="btn btn-success btn-sm">Ver Publicaciones</a>
      </div>
    </div>
  </div>
</div>


<div class="col-md-4">
  <div class="card shadow-lg animate__animated animate__bounceInUp">
    <img src="https://png.pngtree.com/thumb_back/fh260/background/20231229/pngtree-dynamic-world-championship-football-cup-background-national-team-emblem-with-soccer-image_13876819.png" class="card-img-top" alt="Brasil 2014">
    <div class="card-body">
      <h5 class="card-title">Qatar 2022</h5>
      <div class="extra-info">
        <p class="card-text">
          Alemania se consagró campeón tras vencer a Argentina.
        </p>
        <a href="Publicaciones.html" class="btn btn-success btn-sm">Ver Publicaciones</a>
      </div>
    </div>
  </div>
</div>

  </div>
</div>


  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-5">
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>


 <footer class="text-center py-3 mt-5">
    <div class="container">
      <div class="row">
    
        <div class="col-md-4">
          <h5>Enlaces</h5>
          <a href="Mundiales.php" class="text-light d-block">Pagina Principal</a> 
          <a href="Nosotros.html" class="text-light d-block">Sobre Nosotros</a>
          <a href="politicas.html" class="text-light d-block">Políticas de Privacidad</a>
        </div>
  
 
        <div class="col-md-4">
          <h5>Contacto</h5>
          <p>Email:contacto@mundiales.com</p>
        </div>
 
        <div class="col-md-4">
          <h5>Redes de las autoras</h5>
          <a href="https://www.instagram.com/lin_orchid.clip" class="text-light me-2"><i class="fab fa-facebook"></i>Instagram</a> 
          <a href="https://www.instagram.com/adry_sg05" class="text-light"><i class="fab fa-instagram"></i> Instagram</a>
        </div>
      </div>
  
      <hr class="my-3">
      <p class="mb-0">© 2024 Mundiales. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script>
  setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }
  }, 4000); // 4 segundos
</script>

<script>
$(document).ready(function() {
    // 1. Se detecta el envío del formulario con id "loginForm"
    $('#loginForm').on('submit', function(e) {
        e.preventDefault(); //<-- 2.Evita que la página se recargue

        var formData = $(this).serialize(); // Recolecta los datos del formulario
        // 4. Se crea una petición AJAX (la llamada a tu "API")
        $.ajax({
            type: 'POST',
            url: 'Login.php', // <-- 5. Se especifica que el destino es Login.php
            data: formData, // 6. Se envían los datos del formulario
            dataType: 'json', // 7. Se espera una respuesta en formato JSON
            success: function(response) { // 8. Función que se ejecuta si la petición es exitosa
                if (response.success) {
                    // Si el login es exitoso, redirigimos con un parámetro de éxito.
                    // Esto permite mostrar un mensaje de bienvenida más específico.
                    window.location.href = 'Mundiales.php?login=exito';
                } else {
                    // Si el login falla, recargamos la página con un parámetro de error
                    // para mostrar la alerta de Bootstrap en la parte superior.
                    window.location.href = 'Mundiales.php?error=login';
                }
            }
        });
    });
});
</script>


</body>
</html>
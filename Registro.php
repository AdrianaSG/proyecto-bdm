<!DOCTYPE html>
<html lang="es">
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
if (isset($_GET['error']) && $_GET['error'] === 'edad') {
    echo "
    <div class='alert alert-danger alert-dismissible fade show text-center' role='alert' style='margin-top:80px;'>
        ⚠️ No puedes registrarte: debes tener al menos 12 años.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>
    ";
}
?>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">⚽ Mundiales</a>
  </div>
</nav>

<div class="container py-5 mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

  
      <div class="position-relative m-4">
        <div class="progress" style="height: 3px;">
          <div class="progress-bar bg-success" id="progressBar" style="width: 33%"></div>
        </div>
        <button type="button" class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-success rounded-pill">1</button>
        <button type="button" class="position-absolute top-0 start-50 translate-middle btn btn-sm btn-secondary rounded-pill">2</button>
        <button type="button" class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-secondary rounded-pill">3</button>
      </div>


      <div class="card shadow-lg animate__animated animate__fadeIn">
        <div class="card-body">
          <form id="registroForm" method="POST" action="registrarUsuario.php" enctype="multipart/form-data">
            
            <div class="step" id="step1">
              <h4 class="mb-3 text-center">Datos Personales</h4>
              <div class="mb-3">
                <label class="form-label">Nombre completo</label>
                <input type="text" name="nombre" class="form-control" placeholder="Ej. Juan Pérez">
              </div>
              <div class="mb-3">
                <label class="form-label">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label">Género</label>
                <select name="genero" class="form-control" id="generoSelect">
                  <option>Masculino</option>
                  <option>Femenino</option>
                  <option>Otro</option>
                </select>
              </div>

              <div class="mb-3 d-none" id="otroGeneroDiv">
                <label class="form-label">Especifica tu género</label>
                <input type="text" name="genero_otro" class="form-control" placeholder="Ej. No binario">
              </div>

              <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-success next-step">Siguiente</button>
              </div>
            </div>

        
            <div class="step d-none" id="step2">
              <h4 class="mb-3 text-center">Información de Origen</h4>
              <div class="mb-3">
                <label class="form-label">País de nacimiento</label>
                <input type="text" name="pais_nacimiento" class="form-control" placeholder="Ej. México">
              </div>
              <div class="mb-3">
                <label class="form-label">Nacionalidad</label>
                <input type="text" name="nacionalidad" class="form-control" placeholder="Ej. Mexicana">
              </div>
              <div class="mb-3">
                <label class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control">
              </div>
              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-outline-success prev-step">Anterior</button>
                <button type="button" class="btn btn-success next-step">Siguiente</button>
              </div>
            </div>

           
            <div class="step d-none" id="step3">
              <h4 class="mb-3 text-center">Datos de Cuenta</h4>
              <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="correo" class="form-control" placeholder="ejemplo@correo.com">
              </div>
              <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="contrasena" class="form-control" placeholder="********">
              </div>
              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-outline-success prev-step">Anterior</button>
                <button type="submit" class="btn btn-success">Finalizar</button>
              </div>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</div>


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
document.getElementById("generoSelect").addEventListener("change", function() {
  const otroDiv = document.getElementById("otroGeneroDiv");
  if (this.value === "Otro") {
    otroDiv.classList.remove("d-none");
  } else {
    otroDiv.classList.add("d-none");
  }
});
</script>


<script>
  const steps = document.querySelectorAll(".step");
  const nextBtns = document.querySelectorAll(".next-step");
  const prevBtns = document.querySelectorAll(".prev-step");
  const progressBar = document.getElementById("progressBar");
  const stepBtns = document.querySelectorAll(".position-absolute");

  let currentStep = 0;

  function showStep(step) {
    steps.forEach((s, i) => {
      s.classList.toggle("d-none", i !== step);
      stepBtns[i].classList.toggle("btn-success", i <= step);
      stepBtns[i].classList.toggle("btn-secondary", i > step);
    });
    progressBar.style.width = ((step + 1) / steps.length) * 100 + "%";
  }

  nextBtns.forEach(btn => btn.addEventListener("click", () => {
    if (currentStep < steps.length - 1) {
      currentStep++;
      showStep(currentStep);
    }
  }));

  prevBtns.forEach(btn => btn.addEventListener("click", () => {
    if (currentStep > 0) {
      currentStep--;
      showStep(currentStep);
    }
  }));

  showStep(currentStep);
</script>

</body>
</html>
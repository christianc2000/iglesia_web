<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="../views/css/app.css">


  <link rel="stylesheet" href="../views/vendor/fontawesome-free/css/all.min.css">

  <title>Iglesia Web</title>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid">
        <div class="container">
          <a class="navbar-brand" href="/">
            <img src="../views/imagenes/logo-iglesia.png" alt="" width="50" height="50">
          </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href='/'>Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="personas" href='?controller=personas&action=index'>Personas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?controller=actividads&action=index">Actividades</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?controller=ministerios&action=index">Ministerios</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <div class="px-4 py-4">
    <?php require_once('routes.php'); ?>
  </div>


  <footer class="bg-light text-center p-2">
    Copyright - devChristian
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="../views/js/app.js"></script>
</body>

</html>
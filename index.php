<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recherche d'adresses</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
  <header>
    <a href="/">Accueil</a>
    <a href="/recherche">Recherche</a>
  </header>
  <main>
    <?php
      $request = $_SERVER['REQUEST_URI'];

      if($request!=="/") {
        switch ($request) {
          case "/recherche":
            include "./views/formulaire.php";
            break;
          case "/res":
            include "./views/res.php";
            break;
          default: include "./views/404.php";
        };
      } ?>
  </main>
</body>
</html>
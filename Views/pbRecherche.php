<?php

session_start();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Lend it - Objets disponibles</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Source jquery -->
    <script src="../Scripts/jquery_library.js"></script>
    <!-- Source JavaScript Bootstrap -->
    <script src="../Scripts/bootstrap.js"></script>

    <!-- Source CSS Bootstrap -->
    <link rel="stylesheet" href="../Styles/bootstrap.css">

    <!-- Source css pour le design du site -->
    <link rel="stylesheet" href="../Styles/base.css">
</head>
<body>
<?php include("header.php"); ?>

<div class="container content">
<h3> Une erreur est survenue lors de la recherche </h3>
<p> Merci de relancer la recherche </p>
</div>

<?php include("footer.php"); ?>
</body>

<script type="text/javascript" src="../Scripts/config.js"></script>
<script type="text/javascript" src="../Scripts/popupObjet.js"></script>

</html>

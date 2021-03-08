<!DOCTYPE html>
<html lang="sk">
<?php
/** @var string $contentHTML */
/** @var \App\Controllers\AuthController $authController */
?>
<head>
    <meta charset="UTF-8">
    <title>Databáza filmov</title>
    <link rel="stylesheet" href="VAII_SEMESTRALNA_PRACA/public/style.css">
    <!-- CSS -->
    <link rel="shortcut icon" href="VAII_SEMESTRALNA_PRACA/public/favicon.ico">
    <link rel="stylesheet" href
    ="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>
<div id="loading" style="background-color:white">
    <img id="loading-image" src="VAII_SEMESTRALNA_PRACA/public/giphy.gif" alt="Loading..." />
</div>
<?php
if(!$authController->isLog()) {
    include "navbar.php";
} else {
    include "navbar_log.php";
}
?>

<div id="msg"></div>
<div class="web-content">
    <?= $contentHTML ?>
</div>

<script>
    document.getElementById("loading").style.display = "none"
</script>
</body>
</html>
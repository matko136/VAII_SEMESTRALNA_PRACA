<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Dráma</title>
    <link rel="stylesheet" href="style.css">
    <!-- CSS -->
    <link rel="stylesheet" href
            ="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>
<?php include "./navbar.php" ?>

<div class="dramas">
    <div class="row">
        <?php
            $dbDram = new PDO('mysql:dbname=films;host=localhost', 'root', 'dtb456');
            $dbDramas = $dbDram->query('SELECT * from dramas');
            foreach ($dbDramas as $drama) {
                echo '<div class="dr"><p class="nadpis_film">' . $drama['title'] . '</p><div class="info"><img class="film_obr" src=' . $drama['img'] . ' alt="obrazok filmu"><div class="info_text"><h5><br><br><br>' . $drama['about_film'] . '</h5></div></div></div>';
            }
        ?>
    </div>

</div>

</body>
</html>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Obľúbené filmy</title>
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
    <h1 class="nadpis">Drámy</h1><br>
    <div class="row">
        <?php
        $dbFilms = new PDO('mysql:dbname=films;host=localhost', 'root', 'dtb456');
        $sql = "SELECT * from dramas d join favorite_dramas f on d.title = f.title WHERE user='".$_SESSION['user']."'";
        $dbDramas = $dbFilms->query($sql);
        foreach ($dbDramas as $drama) {
            echo '<div class="dr"><p class="nadpis_film">' . $drama['title'] . '</p><div class="info"><img class="film_obr" src=' . $drama['img'] . ' alt="obrazok filmu"><div class="info_text"><h5><br><br><br>' . $drama['about_film'] . '</h5></div></div></div>';
        }
        ?>
    </div>
    <br><h1 class="nadpis">Akčné filmy</h1><br>
    <div class="row">
        <?php
        $dbFilms = new PDO('mysql:dbname=films;host=localhost', 'root', 'dtb456');
        $sql = "SELECT * from dramas d join favorite_actions f on d.title = f.title WHERE user='".$_SESSION['user']."'";
        $dbDramas = $dbFilms->query($sql);
        foreach ($dbDramas as $drama) {
            echo '<div class="dr"><p class="nadpis_film">' . $drama['title'] . '</p><div class="info"><img class="film_obr" src=' . $drama['img'] . ' alt="obrazok filmu"><div class="info_text"><h5><br><br><br>' . $drama['about_film'] . '</h5></div></div></div>';
        }
        ?>
    </div>
    <br><h1 class="nadpis">Romantické filmy</h1><br>
    <div class="row">
        <?php
        $dbFilms = new PDO('mysql:dbname=films;host=localhost', 'root', 'dtb456');
        $sql = "SELECT * from dramas d join favorite_romantics f on d.title = f.title WHERE user='".$_SESSION['user']."'";
        $dbDramas = $dbFilms->query($sql);
        foreach ($dbDramas as $drama) {
            echo '<div class="dr"><p class="nadpis_film">' . $drama['title'] . '</p><div class="info"><img class="film_obr" src=' . $drama['img'] . ' alt="obrazok filmu"><div class="info_text"><h5><br><br><br>' . $drama['about_film'] . '</h5></div></div></div>';
        }
        ?>
    </div>

</div>

</body>
</html>
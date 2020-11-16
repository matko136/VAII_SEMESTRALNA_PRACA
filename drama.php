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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="html1.html">
        <img src="https://library.kissclipart.com/20181207/zxe/kissclipart-movie-clipart-film-clapperboard-clip-art-e347e3ac0f7eaf95.jpg" width="50" class="d-inline-block align-top" alt="" loading="lazy">

    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="o_nas.html">O nás <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filmy
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Akčné</a>
                    <a class="dropdown-item" href="drama.php">Dráma</a>
                    <a class="dropdown-item" href="#">Romantické</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Prihlásenie
                </a>
                <div class="dropdown-menu prihlasenie" aria-labelledby="navbarDropdown">
                    <nav class="navbar navbar-light bg-light">
                        <form class="form-inline">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Prihl. meno" aria-label="Username">
                            </div>
                        </form>
                    </nav>
                    <nav class="navbar navbar-light bg-light">
                        <form class="form-inline">
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Heslo" aria-label="Username">
                            </div>
                        </form>
                    </nav>
                    <nav class="navbar navbar-light bg-light">
                        <a class="nav-link reg_log_button" href="#">prihlásiť</a>
                    </nav>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Registrácia
                </a>
                <div class="dropdown-menu registracia" aria-labelledby="navbarDropdown">
                    <nav class="navbar navbar-light bg-light">
                        <form class="form-inline">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Meno" aria-label="Name">
                            </div>
                        </form>
                    </nav>
                    <nav class="navbar navbar-light bg-light">
                        <form class="form-inline">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Priezvisko" aria-label="Surename">
                            </div>
                        </form>
                    </nav>
                    <nav class="navbar navbar-light bg-light">
                        <form class="form-inline">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Prihl. meno" aria-label="Username">
                            </div>
                        </form>
                    </nav>
                    <nav class="navbar navbar-light bg-light">
                        <form class="form-inline">
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Heslo" aria-label="Username">
                            </div>
                        </form>
                    </nav>
                    <nav class="navbar navbar-light bg-light">
                        <a class="nav-link reg_log_button" href="#">registrovať</a>
                    </nav>
                </div>
            </li>
        </ul>
    </div>
</nav>

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
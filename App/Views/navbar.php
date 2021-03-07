<?php

if(!isset($_SESSION['user'])) {
   $_SESSION['user'] = "";
}

if($_SESSION['user'] == "") {
?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="?c=home">
            <img src="https://library.kissclipart.com/20181207/zxe/kissclipart-movie-clipart-film-clapperboard-clip-art-e347e3ac0f7eaf95.jpg" width="50" class="d-inline-block align-top" alt="" loading="lazy">

        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="?c=about_us">O nás <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filmy
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="?c=film&a=index">Všetky</a>
                        <a class="dropdown-item" href="?c=film&a=action">Akčné</a>
                        <a class="dropdown-item" href="?c=film&a=drama">Dráma</a>
                        <a class="dropdown-item" href="?c=film&a=romantic">Romantické</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Prihlásenie
                    </a>
                    <div class="dropdown-menu prihlasenie" aria-labelledby="navbarDropdown">
                        <form action="/VAII_SEMESTRALNA_PRACA?c=auth&a=login" method="post" name="form">
                            <input type="text" placeholder="Prihl. meno" name="log" required>
                            <input type="password" placeholder="Heslo" name="passwd" required>
                            <input type="submit" value="Prihlasenie" name="submit">
                        </form>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Registrácia
                    </a>
                    <div class="dropdown-menu registracia" aria-labelledby="navbarDropdown">
                        <form action="/VAII_SEMESTRALNA_PRACA?c=auth&a=reg" method="post" name="form">
                            <input type="text" placeholder="Meno" name="name" required>
                            <input type="text" placeholder="Priezvisko" name="surename" required>
                            <input type="text" placeholder="Prihl. meno" name="log" required>
                            <input type="password" placeholder="Heslo" name="passwd" minlength="8" required>
                            <input type="email" placeholder="e-mail" name="email" required>
                            <input type="submit" value="Registracia" name="submit">
                        </form>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="?c=game">Zahraj si <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
<?php } else {
    include "navbar_log.php";
}

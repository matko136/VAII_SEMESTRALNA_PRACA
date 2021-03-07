<?php
/** @var \App\Controllers\AuthController $authController */
$user = $authController->getUser();
/*if (isset($_POST['log_out'])) {
    $_SESSION['user']="";
    header("Location:index.php");
    exit();
}
if ($_SESSION['user'] != "") {*/
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
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filmy
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="?c=film&a=index">Všetky</a>
                    <a class="dropdown-item" href="?c=film&a=action">Akčné</a>
                    <a class="dropdown-item" href="?c=film&a=drama">Dráma</a>
                    <a class="dropdown-item" href="?c=film&a=romantic">Romantické</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a id="ddName" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                   echo $user->getName() . ' ' . $user->getSurename() . '</a>';
                   ?>
                <div class="dropdown-menu">
                    <?php
                    echo '<a id="navlog" class="dropdown-item" href="#">' . $user->getLog() . '</a>';
                        echo '<a id="navemail" class="dropdown-item" href="#">' . $user->getEmail() . '</a>';
                        echo '<a class="dropdown-item" href="?c=setting">Nastevenia účtu</a>';
                    ?>
                    <a class="dropdown-item" href="?c=FavFilm">Obľúbené filmy</a>
                    <form action="/VAII_SEMESTRALNA_PRACA?c=auth&a=logOut" method="post" name="form">
                        <input class="dropdown-item" type="submit" value="Odhlásiť" name="log_out">
                    </form>
                </div>
            </li>
            <?php if($_SESSION['user'] != "") {
                    if($authController->getUser()->getUserType() == 2 || $authController->getUser()->getUserType() == 3) {?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Admin časť
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="?c=admin">Spravuj filmy</a>
                    <a class="dropdown-item" href="?c=admin&a=users">Spravuj užívateľov</a>
                </div>
            </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="?c=game">Zahraj si <span class="sr-only">(current)</span></a>
                        </li>
            <?php } } ?>
        </ul>
    </div>
</nav>
<?php

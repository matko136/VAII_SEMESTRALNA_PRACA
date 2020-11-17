<?php
if (isset($_POST['log_out'])) {
    $_SESSION['user']="";
    header("Location:index.php");
    exit();
}
if ($_SESSION['user'] != "") {
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">
        <img src="https://library.kissclipart.com/20181207/zxe/kissclipart-movie-clipart-film-clapperboard-clip-art-e347e3ac0f7eaf95.jpg" width="50" class="d-inline-block align-top" alt="" loading="lazy">

    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="o_nas.php">O nás <span class="sr-only">(current)</span></a>
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
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                $db = new PDO('mysql:dbname=cinema;host=localhost', 'root', 'dtb456');
                $dbUsers = $db->query('SELECT * from user');
                $name = "";
                $surename = "";
                $email = "";
                foreach ($dbUsers as $user) {
                    if($user['log'] == $_SESSION['user']) {
                        $name = $user['name'];
                        $surename = $user['surename'];
                        $email = $user['email'];
                        break;
                    }
                }
                   echo $name . ' ' . $surename . '</a>';
                   ?>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    echo '<a class="dropdown-item" href="#">' . $_SESSION['user'] . '</a>';
                        echo '<a class="dropdown-item" href="#">' . $email . '</a>';
                        echo '<a class="dropdown-item" href="nastavenia.php">Nastavenia účtu</a>';
                    ?>
                    <form method="post" name="form">
                        <input class="dropdown-item" type="submit" value="Odhlásiť" name="log_out">
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
<?php
} else {
    include "./navbar.php";
}

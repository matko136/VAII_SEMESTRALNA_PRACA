
<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_POST['prihl'])) {
        $db = new PDO('mysql:dbname=cinema;host=localhost', 'root', 'dtb456');
        $dbUsers = $db->query('SELECT * from user');
        $log = $_POST['log'];
        $success = 0;
        foreach ($dbUsers as $user) {
            if($user['log'] == $_POST['log'] && $user['passwd'] == $_POST['passwd']) {
                $_SESSION['user'] = $_POST['log'];
                $success = 1;
                break;
            }
        }
        if($success == 0) {
            echo '<p style="background-color: red"> Zlé prihlasovacie údaje </p>';
        } else {
            echo '<p style="background-color: red">' . 'Boli ste úspešne prihlásený/á <b>' . $_POST['log'] . '</b></p>';
        }
    } elseif (isset($_POST['reg'])) {
        try {
            $db = new PDO('mysql:dbname=cinema;host=localhost', 'root', 'dtb456');
            $sql = 'INSERT INTO user(log, name, surename, passwd, email) VALUES (?, ?, ?, ?, ?)';
            $db->prepare($sql)->execute([$_POST['log'], $_POST['name'], $_POST['surename'], $_POST['passwd'], $_POST['email']]);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
    $session = $_SESSION['user'];
    if ($session == null || $session == "") {
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
                        <a class="dropdown-item" href="action.php">Akčné</a>
                        <a class="dropdown-item" href="drama.php">Dráma</a>
                        <a class="dropdown-item" href="romantic.php">Romantické</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Prihlásenie
                    </a>
                    <div class="dropdown-menu prihlasenie" aria-labelledby="navbarDropdown">
                        <form method="post" name="form">
                            <input type="text" placeholder="Prihl. meno" name="log" required>
                            <input type="password" placeholder="Heslo" name="passwd" required>
                            <input type="submit" value="Prihlasenie" name="prihl">
                        </form>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Registrácia
                    </a>
                    <div class="dropdown-menu registracia" aria-labelledby="navbarDropdown">
                        <form method="post" name="form">
                            <input type="text" placeholder="Meno" name="name" required>
                            <input type="text" placeholder="Priezvisko" name="surename" required>
                            <input type="text" placeholder="Prihl. meno" name="log" required>
                            <input type="password" placeholder="Heslo" name="passwd" required>
                            <input type="text" placeholder="e-mail" name="email" required>
                            <input type="submit" value="Registracia" name="reg">
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
<?php
} else {
    include "./navbar_log.php";
}


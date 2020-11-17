<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Nastavenia účtu</title>
    <link rel="stylesheet" href="style.css">
    <!-- CSS -->
    <link rel="stylesheet" href
    ="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['edit_data'])) {
    $db = new PDO('mysql:dbname=cinema;host=localhost', 'root', 'dtb456');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE user SET name=?, surename=?, email=? WHERE log=?";
    $db->prepare($sql)->execute([$_POST['name'], $_POST['surename'], $_POST['email'], $_SESSION['user']]);
} elseif (isset($_POST['passwd_chng'])) {
    $db = new PDO('mysql:dbname=cinema;host=localhost', 'root', 'dtb456');
    $dbUsers = $db->query('SELECT * from user');
    $success = 0;
    foreach ($dbUsers as $user) {
        if($_POST['passwd_old'] == $user['passwd']) {
            $sql = "UPDATE user SET passwd=? WHERE log=?";
            $db->prepare($sql)->execute([$_POST['passwd_new'], $_SESSION['user']]);
            $success = 1;
        }
    }
    if($success == 1) {
        echo '<p style="background-color: red"> Heslo úspešne zmenené </p>';
    } else {
        echo '<p style="background-color: red"> Zle zadané staré heslo </p>';
    }
}
?>
<body>
    <?php include "./navbar.php" ?>
    <div class="nastavenia">
        <div class="udaje">
            <h3>Údaje používateľa</h3><br>
            <form method="post" name="form">
                <?php
                $db = new PDO('mysql:dbname=cinema;host=localhost', 'root', 'dtb456');
                $dbUsers = $db->query('SELECT * from user');
                $name = "";
                $surename = "";
                $email = "";
                $passwd = "";
                foreach ($dbUsers as $user) {
                    if($user['log'] == $_SESSION['user']) {
                        $name = $user['name'];
                        $surename = $user['surename'];
                        $email = $user['email'];
                        $passwd = $user['passwd'];
                        break;
                    }
                }
                echo '<label for="name">Meno</label>';
                echo '<input type="text" value="' . $name .  '" name="name" required><br><br>';
                echo '<label for="surename">Priezvisko</label>';
                echo '<input type="text" value="' . $surename .  '" name="surename" required><br><br>';
                echo '<label for="email">E-mail</label>';
                echo '<input type="text" value="' . $email .  '" name="email" required><br><br>';
                ?>
                <input type="submit" value="Editovať údaje" name="edit_data">
            </form>
            <br><h3>Zmena hesla</h3><br>
            <form method="post" name="form">
                <label for="name">Zadajte staré heslo:</label>
                <input type="password" name="passwd_old" required><br><br>
                <label for="name">Zadajte nové heslo:</label>
                <input type="password" name="passwd_new" required><br><br>
                <input type="submit" value="Zmeniť heslo" name="passwd_chng">
            </form>
        </div>
    </div>
</body>
</html>
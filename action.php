<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Akčné</title>
    <link rel="stylesheet" href="style.css">
    <!-- CSS -->
    <link rel="stylesheet" href
    ="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>
<?php include "./navbar.php";

if (isset($_POST['addFavAction'])) {
    try {
        $db = new PDO('mysql:dbname=films;host=localhost', 'root', 'dtb456');
        $sql = 'INSERT INTO favorite_actions(user, title) VALUES (?, ?)';
        $db->prepare($sql)->execute([$_SESSION['user'], $_POST['title']]);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}

if (isset($_POST['remFavAction'])) {
    try {
        $db = new PDO('mysql:dbname=films;host=localhost', 'root', 'dtb456');
        $sql = "DELETE FROM favorite_actions WHERE user='".$_SESSION['user']. "'" . " and title='".$_POST['title']."'";
        $db->prepare($sql)->execute();
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}

?>


<div class="films">
    <div class="row">
        <?php
        $dbAct = new PDO('mysql:dbname=films;host=localhost', 'root', 'dtb456');
        $dbActs = $dbAct->query('SELECT * from actions');
        foreach ($dbActs as $action) {
            $sql = "SELECT * from actions d join favorite_actions f on d.title = f.title WHERE user='".$_SESSION['user']."'";
            $dbFavActions = $dbAct->query($sql);
            $isFavorite = 0;
            foreach ($dbFavActions as $favAction) {
                if($favAction['title'] == $action['title']) {
                    $isFavorite = 1;
                    break;
                }
            }
            echo '<div class="dr"><p class="nadpis_film">' . $action['title'] . '</p><div class="info"><img class="film_obr" src=' . $action['img'] . ' alt="obrazok filmu"><div class="info_text"><h5><br><br><br>' . $action['about_film'] . '</h5><form method="post" name="form">';
            if ($isFavorite == 0) {
                echo '  <input type="hidden" name="title" value="' . $action['title'] . '"/>';
                echo '<input type="submit" value="Pridať do obľúbených" name="addFavAction"></form></div></div></div>';
            } else {
                echo '  <input type="hidden" name="title" value="' . $action['title'] . '"/>';
                echo '<input type="submit" value="Odobrať z obľúbených" name="remFavAction"></form></div></div></div>';
            }
        }
        ?>
    </div>

</div>

</body>
</html>
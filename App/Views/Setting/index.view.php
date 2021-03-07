<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="VAII_SEMESTRALNA_PRACA/public/js/setting.js"></script>
<?php /** @var \App\Controllers\AuthController $authController */?>
<?php if($authController->getUser() != NULL) {?>
    <div class="nastavenia_page">
    <div class="nastavenia">
        <div class="udaje">
            <h3>Údaje používateľa</h3><br>
            <form id="userData" method="post" name="form">
                <?php
                $user = $authController->getUser();
                echo '<label id="labName" for="name">Meno</label>';
                echo '<input id="name" type="text" value="' . $user->getName() .  '" name="name" required><br><br>';
                echo '<label id="labsureName" for="surename">Priezvisko</label>';
                echo '<input id="surename" type="text" value="' . $user->getSurename() .  '" name="surename" required><br><br>';
                echo '<label id="labEmail" for="email">E-mail</label>';
                echo '<input id="email" type="text" value="' . $user->getEmail() .  '" name="email" required><br><br>';
                ?>
                <p id="edit_data_info"></p>
                <input type="button" onclick="editData()" value="Editovať údaje" name="edit_data">
            </form>
            <br><h3>Zmena hesla</h3><br>
            <form id="passwData" method="post" name="form">
                <label for="name">Zadajte staré heslo:</label>
                <input id="oldpasswd" type="password" name="passwd_old" required><br><br>
                <label id="labNewPass" for="name">Zadajte nové heslo:</label>
                <input id="newpasswd" type="password" name="passwd_new" required><br><br>
                <p id="edit_pass_info"></p>
                <input type="button" onclick="editPasswd()" value="Zmeniť heslo" name="passwd_chng"><br><br>
                <label id="labDelAcc" for="name">Pre zmazanie účtu stlačte tlačidlo: </label>
                <input type="button" onclick="delAcc()" value="Zmazať účet" name="accDel">
            </form>
        </div>
    </div>
    </div>
<?php } else {
    echo '<h3>Prístup zamietnuty, neprihlaseny pouzivatel</h3>';
}
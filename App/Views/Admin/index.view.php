<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src = "VAII_SEMESTRALNA_PRACA/public/js/admin.js" ></script>
<?php /** @var \App\Controllers\AuthController $authController */ ?>
<?php if ($authController->getUser() != NULL) {
    if($authController->getUser()->getUserType() == 2 || $authController->getUser()->getUserType() == 3) {?>
    <div id="films" class="films">
        <div class="row" id="row">
        </div>
    </div>

<?php } else {echo '<h3>Prístup zamietnuty, neautorizovany pouzivatel</h3>';} } else {
    echo '<h3>Prístup zamietnuty, neprihlaseny pouzivatel</h3>';
}

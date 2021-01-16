<?php /** @var \App\Controllers\AuthController $authController */?>
<div class="container">
    <div class="row">
        <div class="col">
            Ahoj <?php if($authController->getUser()!= null) {
                echo $authController->getUser()->getName();
            } else {
                echo "používateľ.";
            }?>
        </div>
        <img class="vitajte" src="VAII_SEMESTRALNA_PRACA_mvc/public/text.gif" alt="Vitajte">
    </div>
</div>

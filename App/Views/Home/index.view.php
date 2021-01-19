<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js""></script>
<script src="VAII_SEMESTRALNA_PRACA/public/js/rand.js"></script>
<?php /** @var \App\Controllers\AuthController $authController */?>
<div class="container">
    <div class="home">
        <div class="col"><h1 id="ahoj">
            Vitajte <?php if($authController->getUser()!= null) {
                echo $authController->getUser()->getName();
            } else {
                echo "používateľ";
            }?>
            </h1>
        </div>
        <h1 class="nadpis">Možno vás zaujme</h1>
        <img class="vitajte" src="VAII_SEMESTRALNA_PRACA/public/text.gif" alt="Vitajte">
    </div>
</div>
<div class="films">
    <div class="row" id="row">
    </div>
</div>
<script src="VAII_SEMESTRALNA_PRACA/public/js/skript.js"></script>
<div class="films">
    <div class="row" id="row">
    <?php /** @var \App\Models\Film[] $data */
    /*foreach ($data as $film) {
        echo '<div class="dr"><p class="nadpis_film">' . $film->getTitle() . '</p><div class="info"><img class="film_obr" src=' . $film->getImg() . ' alt="obrazok filmu"><div class="info_text"><h5><br><br><br>' . $film->getAboutFilm() . '</h5><form action = "/VAII_SEMESTRALNA_PRACA?c=FavFilm&a=add" method="post" name="form">';
        echo '  <input type="hidden" name="id_film" value="' . $film->getIdFilm(). '"/>';
        echo '  <input type="hidden" name="id_user" value="' . $_SESSION['user'] . '"/>';
        echo '<input type="submit" value="Pridať do obľúbených" name="addFavDrama" style="background-color: green"></form></div></div></div>';
    }*/ ?>
    </div>

</div>

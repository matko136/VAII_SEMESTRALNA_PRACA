<div class="films">
    <div class="row">
    <?php /** @var \App\Models\Film[] $data */
    foreach ($data as $film) {
        echo '<div class="dr"><p class="nadpis_film">' . $film->getTitle() . '</p><div class="info"><img class="film_obr" src=' . $film->getImg() . ' alt="obrazok filmu"><div class="info_text"><h5><br><br><br>' . $film->getAboutFilm() . '</h5></div></div></div>';
    } ?>
    </div>

</div>
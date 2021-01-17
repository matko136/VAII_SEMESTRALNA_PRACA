class Film {
    constructor() {

        this.getFilms();
        setInterval(() => this.getFilms(), 2000);
    }

    async getFilms() {
        try{
            let response = await fetch('?c=film&a=drama');
            let data = await response.json();
            var list = document.getElementById('row');
            list.innerHTML = "";
            data.forEach((film) => {
                //var html = `<div class="dr"><p class="nadpis_film">` + film.title + `</p><div class="info"><img class="film_obr" src=' + film.img + ' alt="obrazok filmu"><div class="info_text"><h5><br><br><br>' + film.about_film + '</h5></div></div></div>`;
                var html = `<div class="dr"><p class="nadpis_film">  ${film.title} </p><div class="info"><img class="film_obr" src=  ${film.img}  alt="obrazok filmu"><div class="info_text"><h5><br><br><br>  ${film.about_film}  </h5></div></div></div>`;
                //list.append(html);
                list.innerHTML += html;
            });
            //echo '<div class="dr"><p class="nadpis_film">' . $film.title . '</p><div class="info"><img class="film_obr" src=' . $film->getImg() . ' alt="obrazok filmu"><div class="info_text"><h5><br><br><br>' . $film->getAboutFilm() . '</h5></div></div></div>';
            
        } catch (e) {
            console.error('Chyba' + e.message);
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
   var film = new Film();
});
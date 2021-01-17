class Film {
    lastData = null;
    constructor() {

        this.getFilms();
        setInterval(() => this.getFilms(), 2000);
    }

    async getFilms() {
        try{
            //var to = "<?= $_GET['to']; ?>";
            //var $_GET = <?php  echo json_encode($_GET['a']); ?>;
            //var action = <?= echo $_GET['a'] . '_get';?>;
            //
            //var $_GET = window.$_GET = location.search.substr(1).split("&").reduce((o,i)=>(u=decodeURIComponent,[k,v]=i.split("="),o[u(k)]=v&&u(v),o),{});
            //var $_GET = <?= echo $_GET['a'];?>;
            //var action = $_GET['a'];
            var parts = window.location.search.substr(1).split("&");
            var $_GET = {};
            for (var i = 0; i < parts.length; i++) {
                var temp = parts[i].split("=");
                $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
            }
            let response = await fetch('?c=film&a=' + $_GET.a + "_get");
            let data = await response.json();
            var change = true;

            /*if(this.lastData != null) {
                data.forEach((film) => {
                    var foundNew = true;
                    this.lastData.forEach((lastFilm) => {
                        if(film.id_film === lastFilm.id_film) {
                            foundNew = false;
                        }
                    });
                    if(foundNew == false) {
                        change = false;
                    } else {
                        change = true;
                        break;
                    }
                });
            }*/
            if(this.lastData != null) {
                for (var i = 0; i < data.length; i++) {
                    var foundNew = true;
                    var deleted = true;
                    for (var j = 0; j < this.lastData.length; j++) {
                        if (data[i].id_film === this.lastData[j].id_film) {
                            deleted = false;
                            foundNew = false;
                            break;
                        }
                    }
                    if (foundNew == false) {
                        change = false;
                    } else {
                        change = true;
                        break;
                    }
                }
            }

            if(change) {
                let responsefav = await fetch('?c=FavFilm&a=' + $_GET.a);
                let favdata = await responsefav.json();
                var list = document.getElementById('row');
                list.innerHTML = "";
                data.forEach((film) => {
                    //var html = `<div class="dr"><p class="nadpis_film">` + film.title + `</p><div class="info"><img class="film_obr" src=' + film.img + ' alt="obrazok filmu"><div class="info_text"><h5><br><br><br>' + film.about_film + '</h5></div></div></div>`;
                    var favorite = false;
                    for(var i = 0; i < favdata.length; i++) {
                        if(favdata[i].id_film === film.id_film) {
                            favorite = true;
                            break;
                        }
                    }
                    var html = `<div class="dr"><p class="nadpis_film">  ${film.title} </p><div class="info"><img class="film_obr" src=  ${film.img}  alt="obrazok filmu"><div class="info_text"><h5><br><br><br>  ${film.about_film}  </h5></div></div></div>`;
                    //list.append(html);
                    list.innerHTML += html;
                });
                this.lastData = data;
            }
            //echo '<div class="dr"><p class="nadpis_film">' . $film.title . '</p><div class="info"><img class="film_obr" src=' . $film->getImg() . ' alt="obrazok filmu"><div class="info_text"><h5><br><br><br>' . $film->getAboutFilm() . '</h5></div></div></div>';
        } catch (e) {
            console.error('Chyba' + e.message);
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
   var film = new Film();
});
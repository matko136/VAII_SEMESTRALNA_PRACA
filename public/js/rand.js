Math.floor((Math.random() * 10) + 1); //1 - 10
class RandFilm {
    constructor() {
        this.first();
        this.getFilms();
        setInterval(() => this.getFilms(), 2000);
    }

    async first(){
        let response = await fetch('?c=Film&a=index_get');
        let data = await response.json();
        if(data.length > 0) {
            var list = document.getElementById('row');
            list.innerHTML = "";
            var count = 0;
            var arr = [];
            for(var i = 0; i < data.length; i++) {
                var rand = Math.floor(Math.random() * data.length);
                var alreadyWas = false;
                for(var j = 0; j < arr.length; j++) {
                    if(rand == arr[j]) {
                        alreadyWas = true;
                        break;
                    }
                }
                while(alreadyWas) {
                    rand = Math.floor(Math.random() * data.length);
                    alreadyWas = false;
                    for(var j = 0; j < arr.length; j++) {
                        if(rand == arr[j]) {
                            alreadyWas = true;
                            break;
                        }
                    }
                }
                arr[arr.length] = rand;
                var film = data[rand];
                var html = `<div class = "dr" id="dr${count}"><p class="nadpis_film">  ${film.title} </p><div class="info"><img class="film_obr" src=  ${film.img}  alt="obrazok filmu"><div class="info_text"><h5><br><br><br>  ${film.about_film}  </h5></div></div></div>`;
                list.innerHTML += html;
                count++;
                if(count == 3) {
                    break;
                }
            }
        }
    }

    async getFilms(){
        let response = await fetch('?c=film&a=index_get');
        let data = await response.json();
        if(data.length > 0) {
            //var list = document.getElementById('row');
            //list.innerHTML = "";
            var count = 0;
            var arr = [];
            for(var i = 0; i < data.length; i++) {
                var rand = Math.floor(Math.random() * data.length);
                var alreadyWas = false;
                for(var j = 0; j < arr.length; j++) {
                    if(rand == arr[j]) {
                        alreadyWas = true;
                        break;
                    }
                }
                while(alreadyWas) {
                    rand = Math.floor(Math.random() * data.length);
                    alreadyWas = false;
                    for(var j = 0; j < arr.length; j++) {
                        if(rand == arr[j]) {
                            alreadyWas = true;
                            break;
                        }
                    }
                }
                arr[arr.length] = rand;
                var film = data[rand];
                document.getElementById('dr' + count).innerHTML = `<p class="nadpis_film">  ${film.title} </p><div class="info"><img class="film_obr" src=  ${film.img}  alt="obrazok filmu"><div class="info_text"><h5><br><br><br>  ${film.about_film}  </h5></div></div>`;
                //list.innerHTML = "";
                //var html = `<div class="dr"><p class="nadpis_film">  ${film.title} </p><div class="info"><img class="film_obr" src=  ${film.img}  alt="obrazok filmu"><div class="info_text"><h5><br><br><br>  ${film.about_film}  </h5></div></div></div>`;
                //list.innerHTML += html;
                count++;
                if(count == 3) {
                    break;
                }
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    var film = new RandFilm();
});
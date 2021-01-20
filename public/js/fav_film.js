class Film {
    lastfavData = null;

    constructor() {

        this.getFilms();
        //setInterval(() => this.getFilms(), 2000);
    }

    async getFilms() {
        try {
            var parts = window.location.search.substr(1).split("&");
            var $_GET = {};
            for (var i = 0; i < parts.length; i++) {
                var temp = parts[i].split("=");
                $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
            }
            let response = await fetch('?c=film&a=index_get');
            let data = await response.json();

            var changeFavFilms = true;
            let responsefav = await fetch('?c=FavFilm&a=index_get');
            let favdata = await responsefav.json();
            if (favdata[0] !== "NotLogged") {
                if (this.lastfavData !== null) {
                    var deleted = new Array(this.lastfavData.length);
                    for (var j = 0; j < this.lastfavData.length; j++) {
                        deleted[j] = true;
                    }
                    for (var i = 0; i < favdata.length; i++) {
                        var foundNew = true;
                        for (var j = 0; j < this.lastfavData.length; j++) {
                            if (favdata[i].id_film === this.lastfavData[j].id_film) {
                                deleted[j] = false;
                                foundNew = false;
                                break;
                            }
                        }
                        if (foundNew == false) {
                            changeFavFilms = false;
                        } else {
                            changeFavFilms = true;
                            break;
                        }
                    }
                    for (var j = 0; j < this.lastfavData.length; j++) {
                        if (deleted[j] === true) {
                            changeFavFilms = true;
                        }
                    }
                }
            } else {
                changeFavFilms = false;
            }

            if (changeFavFilms) {
                this.lastfavData = favdata;
                let responsefavDrama = await fetch('?c=FavFilm&a=drama_get');
                let favdramadata = await responsefavDrama.json();



                var list = document.getElementById('drama');
                list.innerHTML = "";
                favdramadata.forEach((favfilm) => {
                    for(var i = 0; i < data.length; i++) {
                        if(data[i].id_film === favfilm.id_film) {
                            var film = data[i];
                            if (favdata[0] === "NotLogged") {
                                var html = `<div class="dr"><p class="nadpis_film">  ${film.title} </p><div class="info"><img class="film_obr" src=  ${film.img}  alt="obrazok filmu"><div class="info_text"><h5><br><br><br>  ${film.about_film}  </h5></div></div></div>`;
                                list.innerHTML += html;
                            } else {
                                var html = `<div id="rem${favfilm.id_film}" class="dr"><p class="nadpis_film"> ${film.title} </p><div class="info"><img class="film_obr" src=${film.img} alt="obrazok filmu"><div class="info_text"><h5><br><br><br> ${film.about_film} </h5>`;
                                html += `<form action="/VAII_SEMESTRALNA_PRACA?c=FavFilm&a=remove" method="post" name="form"><input type="hidden" name="id_user" value= ${favfilm.id_user} /><input type="hidden" name="id_film" value= ${favfilm.id_film} /><input type="button" onclick="removeFavFilm(${favfilm.id_user}, ${favfilm.id_film})" value="Odobrať z obľúbených" name="remFav" style="background-color: #ff0000"></form></div></div></div>`;
                                list.innerHTML += html;
                            }
                            break;
                        }
                    }
                });

                let responsefavAction = await fetch('?c=FavFilm&a=action_get');
                let favactiondata = await responsefavAction.json();

                list = document.getElementById('action');
                list.innerHTML = "";
                favactiondata.forEach((favfilm) => {
                    for(var i = 0; i < data.length; i++) {
                        if(data[i].id_film === favfilm.id_film) {
                            var film = data[i];
                            if (favdata[0] === "NotLogged") {
                                var html = `<div class="dr"><p class="nadpis_film">  ${film.title} </p><div class="info"><img class="film_obr" src=  ${film.img}  alt="obrazok filmu"><div class="info_text"><h5><br><br><br>  ${film.about_film}  </h5></div></div></div>`;
                                list.innerHTML += html;
                            } else {
                                var html = `<div id="rem${favfilm.id_film}" class="dr"><p class="nadpis_film"> ${film.title} </p><div class="info"><img class="film_obr" src=${film.img} alt="obrazok filmu"><div class="info_text"><h5><br><br><br> ${film.about_film} </h5>`;
                                html += `<form action="/VAII_SEMESTRALNA_PRACA?c=FavFilm&a=remove" method="post" name="form"><input type="hidden" name="id_user" value= ${favfilm.id_user} /><input type="hidden" name="id_film" value= ${favfilm.id_film} /><input type="button" onclick="removeFavFilm(${favfilm.id_user}, ${favfilm.id_film})" value="Odobrať z obľúbených" name="remFav" style="background-color: #ff0000"></form></div></div></div>`;
                                list.innerHTML += html;
                            }
                            break;
                        }
                    }
                });
                let responsefavRomantic = await fetch('?c=FavFilm&a=romantic_get');
                let favromanticdata = await responsefavRomantic.json();
                list = document.getElementById('romantic');
                list.innerHTML = "";
                favromanticdata.forEach((favfilm) => {
                    for(var i = 0; i < data.length; i++) {
                        if(data[i].id_film === favfilm.id_film) {
                            var film = data[i];
                            if (favdata[0] === "NotLogged") {
                                var html = `<div class="dr"><p class="nadpis_film">  ${film.title} </p><div class="info"><img class="film_obr" src=  ${film.img}  alt="obrazok filmu"><div class="info_text"><h5><br><br><br>  ${film.about_film}  </h5></div></div></div>`;
                                list.innerHTML += html;
                            } else {
                                var html = `<div id="rem${favfilm.id_film}" class="dr"><p class="nadpis_film"> ${film.title} </p><div class="info"><img class="film_obr" src=${film.img} alt="obrazok filmu"><div class="info_text"><h5><br><br><br> ${film.about_film} </h5>`;
                                html += `<form action="/VAII_SEMESTRALNA_PRACA?c=FavFilm&a=remove" method="post" name="form"><input type="hidden" name="id_user" value= ${favfilm.id_user} /><input type="hidden" name="id_film" value= ${favfilm.id_film} /><input type="button" onclick="removeFavFilm(${favfilm.id_user}, ${favfilm.id_film})" value="Odobrať z obľúbených" name="remFav" style="background-color: #ff0000"></form></div></div></div>`;
                                list.innerHTML += html;
                            }
                            break;
                        }
                    }
                });
            }
        } catch (e) {
            console.error('Chyba' + e.message);
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    var film = new Film();
});

function removeFavFilm(id_user, id_film) {
    $.ajax({
        type: "post",
        url: "?c=FavFilm&a=remove",
        data:
            {
                'id_user': id_user,
                'id_film': id_film
            },
        cache: false,
    });
    var rem = document.getElementById('rem' + id_film);
    return rem.parentNode.removeChild(rem);
    //this.getFilms();
    return false;
}



class Film {
    lastData = null;
    lastfavData = null;
    constructor() {

        this.getFilms();
        //setInterval(() => this.getFilms(), 100);
    }

    async getFilms() {
        try{
            var parts = window.location.search.substr(1).split("&");
            var $_GET = {};
            for (var i = 0; i < parts.length; i++) {
                var temp = parts[i].split("=");
                $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
            }
            let response = await fetch('?c=film&a=' + $_GET.a + "_get");
            let data = await response.json();
            var changeFilms = true;
            if(this.lastData !== null) {
                var deleted = new Array(this.lastData.length);
                for (var j = 0; j < this.lastData.length; j++) {
                    deleted[j] = true;
                }
                for (var i = 0; i < data.length; i++) {
                    var foundNew = true;
                    for (var j = 0; j < this.lastData.length; j++) {
                        if (data[i].id_film === this.lastData[j].id_film) {
                            deleted[j] = false;
                            foundNew = false;
                            break;
                        }
                    }
                    if (foundNew == false) {
                        changeFilms = false;
                    } else {
                        changeFilms = true;
                        break;
                    }
                }
                for (var j = 0; j < this.lastData.length; j++) {
                    if(deleted[j] === true) {
                        changeFilms = true;
                    }
                }
            }

            var changeFavFilms = false;
            let responsefav = await fetch('?c=FavFilm&a=' + $_GET.a + "_get");
            let favdata = await responsefav.json();
            if(favdata[0] !== "NotLogged") {
                if(this.lastfavData !== null) {
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
                        if(deleted[j] === true) {
                            changeFavFilms = true;
                        }
                    }
                }
            }

            if(changeFilms || changeFavFilms) {
                var list = document.getElementById('row');
                list.innerHTML = "";
                data.forEach((film) => {
                if(favdata[0] === "NotLogged") {
                    var html = `<div class="dr"><p class="nadpis_film">  ${film.title} </p><div class="info"><img class="film_obr" src=  ${film.img}  alt="obrazok filmu"><div class="info_text"><h5><br><br><br>  ${film.about_film}  </h5></div></div></div>`;
                    list.innerHTML += html;
                } else {
                        //var html = `<div class="dr"><p class="nadpis_film">` + film.title + `</p><div class="info"><img class="film_obr" src=' + film.img + ' alt="obrazok filmu"><div class="info_text"><h5><br><br><br>' + film.about_film + '</h5></div></div></div>`;
                        var favorite = false;
                        var favoritefilm;
                        var user = favdata[favdata.length-1];
                        for (var i = 0; i < favdata.length-1; i++) {
                            if (favdata[i].id_film === film.id_film) {
                                favorite = true;
                                favoritefilm = favdata[i];
                                break;
                            }
                        }
                        var html = `<div class="dr"><p class="nadpis_film"> ${film.title} </p><div class="info"><img class="film_obr" src=${film.img} alt="obrazok filmu"><div class="info_text"><h5><br><br><br> ${film.about_film} </h5>`;
                        if(favorite) {
                            html += `<form action="/VAII_SEMESTRALNA_PRACA?c=FavFilm&a=remove" method="post" name="form"><input type="hidden" name="id_user" value= ${favoritefilm.id_user} /><input type="hidden" name="id_film" value= ${favoritefilm.id_film} /><input id="rem${favoritefilm.id_film}" type="button" onclick="removeFavFilm(${favoritefilm.id_user}, ${favoritefilm.id_film})" value="Odobrať z obľúbených" name="remFav" style="background-color: #ff0000"></form></div></div></div>`;
                        } else {
                            html += `<form action="/VAII_SEMESTRALNA_PRACA?c=FavFilm&a=add" method="post" name="form"><input type="hidden" name="id_user" value= ${user} /><input type="hidden" name="id_film" value= ${film.id_film} /><input id="add${film.id_film}" type="button" onclick="addFavFilm(${user}, ${film.id_film})" value="Pridať do obľúbených" name="addFav" style="background-color: green"></form></div></div></div>`;
                        }
                        list.innerHTML += html;
                        this.lastfavData = favdata;
                    }
                });
                this.lastData = data;
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
        type:"post",
        url:"?c=FavFilm&a=remove",
        data:
            {
                'id_user' :id_user,
                'id_film' :id_film
            },
        cache:false,
    });
    var rem = document.getElementById('rem' + id_film);
    rem.setAttribute('onclick', "addFavFilm(" + id_user + ", " + id_film + ")");
    rem.value = "Pridať do obľúbených";
    rem.name = "addFav"
    rem.id = "add" + id_film;
    rem.style = "background-color: green";
    return false;
}

function addFavFilm(id_user, id_film) {
    $.ajax({
        type:"post",
        url:"?c=FavFilm&a=add",
        data:
            {
                'id_user' :id_user,
                'id_film' :id_film
            },
        cache:false
    });
    var add = document.getElementById('add' + id_film);
    add.setAttribute('onclick', "removeFavFilm(" + id_user + ", " + id_film + ")");
    add.value = "Odobrať z obľúbených";
    add.name = "remFav"
    add.id = "rem" + id_film;
    add.style = "background-color: #ff0000";
    return false;
}


class Film {
    lastData = null;

    constructor() {

        this.getFilms();
        //setInterval(() => this.getFilms(), 100);
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
            var changeFilms = true;
            if (this.lastData !== null) {
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
                    if (deleted[j] === true) {
                        changeFilms = true;
                    }
                }
            }

            if (changeFilms) {
                var list = document.getElementById('row');
                list.innerHTML = "";
                data.forEach((film) => {
                    var html = `<div id="rem${film.id_film}" class="dr"><p id="title${film.id_film}" class="nadpis_film"> ${film.title} </p><div class="info"><img id="img${film.id_film}" class="film_obr" src=${film.img} alt="obrazok filmu"><div id="about${film.id_film}" class="info_text"><h5><br><br><br> ${film.about_film} </h5>`;
                    html += `<form action="/VAII_SEMESTRALNA_PRACA?c=FavFilm&a=remove" method="post" name="form"><input type="hidden" name="id_film" value= ${film.id_film} /><input id="edit${film.id_film}" type="button" onclick="overlay(false,${film.id_film})" value="Editovať film" name="editFilm" style="background-color: #ff0000"><input type="button" onclick="removeFilm(${film.id_film})" value="Vymazať film" name="remFilm" style="background-color: #ff0000"></form></div></div></div>`;
                    list.innerHTML += html;
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

function removeFilm(id_film) {
    $.ajax({
        type: "post",
        url: "?c=Admin&a=delete",
        data:
            {
                'id_film': id_film
            },
        cache: false,
    });
    var rem = document.getElementById('rem' + id_film);
    return rem.parentNode.removeChild(rem);
    return false;
}

function overlay(edit, id) {
    var over = document.createElement("div");
    //over.setAttribute("id", "edit" + id);
    var first = document.getElementById('films').firstChild;//$('#row').children().first();
    //var input = document.createElement("input");
    //input.type = "text";
    var input = document.createElement('div');
    input.setAttribute('id', 'indiv');
    var html = `<div id="film_data_div"><form method="post" name="form">
        <label class="film_data" for="title">Zadajte titulok filmu:</label><br>
        <textarea cols="30" rows="2" input class="film_data" id="title" type="text" name="title" required maxlength="100"></textarea><br><br>
        <label class="film_data" for="about_film">Zadajte popis</label><br>
        <textarea cols="30" rows="10" class="film_data" id="about_film" name="about_film" required maxlength="1000"></textarea><br><br>
        <label class="film_data" for="img">Zadajte url k obrazku filmu:</label><br>
        <textarea cols="30" rows="2" class="film_data" id="img" type="text" name="img" required maxlength="1000"></textarea><br><br>
        <input class="film_data" type="button" onclick="editFilm(${id})" value="Uložiť údaje" name="film_save">
        <input class="film_data" type="button" onclick="cancelOverlay()" value="Zrušiť" name="overLay_cancel">
    </form></div>`;
    input.innerHTML += html;//`<h3> Ahoj svet aaaaaaaaaaaaaaaaaaaaaaaaaaa </h3>`;
    over.setAttribute('class', 'overlay');
    over.appendChild(input);
    //over.innerHTML = `<input type="text"/>`;
    //$("#films").prepend("<div id=edit" +id + " class='overlay'>" + "<input type='text'/></div>");
    document.getElementById('films').insertBefore(over, first);
    var inp2 = document.createElement('div');
    inp2.setAttribute('id', "overlayback");
    over.insertBefore(inp2, input);


}

function cancelOverlay() {

}

function editFilm(id_film) {
    $.ajax({
        type: "post",
        url: "?c=Admin&a=edit",
        data:
            {
                'id_film': id_film
            },
        cache: false
    });
    var wind = document.createElement("div");
    var add = document.getElementById('rem' + id_film);
    add.setAttribute('onclick', "removeFavFilm(" + id_user + ", " + id_film + ")");
    add.value = "Odobrať z obľúbených";
    add.name = "remFav"
    add.id = "rem" + id_film;
    add.style = "background-color: #ff0000";
    return false;
}


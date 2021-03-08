
class Film {
    lastData = null;

    constructor() {
        document.getElementById("loading").style.display = "block";
        this.getFilms();
        setInterval(() => this.getFilms(), 1000);
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
                    if (foundNew === false) {
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
                list.innerHTML = `<div id="addFilmDiv" onclick="overlay(false,0)" class="dr"><div class="info"><img src="VAII_SEMESTRALNA_PRACA/public/plus.png" alt="obrazok pridania filmu">`;
                data.forEach((film) => {
                    var html = `<div id="rem${film.id_film}" class="dr"><p id="title${film.id_film}" class="nadpis_film">${film.title}</p><div class="info"><img id="img${film.id_film}" class="film_obr" src=${film.img} alt="obrazok filmu"><div class="info_text"><br><br><br><h5 id="about${film.id_film}">${film.about_film}</h5>`;
                    html += `<form action="/VAII_SEMESTRALNA_PRACA?c=FavFilm&a=remove" method="post" name="form"><input type="hidden" name="id_film" value=${film.id_film} /><input id="film_type${film.id_film}"  type="hidden" name="film_type" value=${film.film_type} /><input id="edit${film.id_film}" type="button" onclick="overlay(true,${film.id_film})" value="Editovať film" name="editFilm" style="background-color: #ff0000"><input type="button" onclick="removeFilm(${film.id_film})" value="Vymazať film" name="remFilm" style="background-color: #ff0000"></form></div></div></div>`;
                    list.innerHTML += html;
                });
                this.lastData = data;
                document.getElementById("loading").style.display = "none";
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
    if(confirm("Are you sure to delete this film?")) {
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
        rem.parentNode.removeChild(rem);
        return false;

    }
}

function overlay(edit, id) {
    var over = document.createElement("div");
    var first = document.getElementById('films').firstChild;//$('#row').children().first();
    var input = document.createElement('div');
    input.setAttribute('id', 'indiv');
    var title = "";
    var about = "";
    var img = "";
    var type_film = "0";
    if(edit) {
        title = document.getElementById('title' + id).innerHTML;
        about = document.getElementById('about' + id).innerHTML;
        img = document.getElementById('img' + id).src;
        type_film = document.getElementById('film_type' + id).value;
    }
    var html = `<div id="film_data_div"><form id="formData" method="post" name="form">
        <label class="film_data" for="title">Zadajte titulok filmu:</label><br>
        <textarea cols="40" rows="2" input class="film_data" id="title" type="text" name="title" required maxlength="100">${title}</textarea><br><br>
        <label class="film_data" for="about_film">Zadajte popis</label><br>
        <textarea cols="40" rows="10" class="film_data" id="about_film" name="about_film" required maxlength="1000">${about}</textarea><br><br>
        <label class="film_data" for="img">Zadajte url k obrazku filmu:</label><br>
        <textarea cols="40" rows="2" class="film_data" id="img" type="text" name="img" required maxlength="1000">${img}</textarea><br><br>
        <label class="film_data" for="film_type">Vyberte typ filmu:</label><br>
        <select id="selected_type" name="types">`
        if(type_film === "1")
            html += `<option selected value="1">Drama</option>`;
        else
            html += `<option value="1">Drama</option>`;
        if(type_film === "2")
            html += `<option selected value="2">Action</option>`;
        else
            html += `<option value="2">Action</option>`;
        if(type_film === "3")
            html += `<option selected value="3">Romantic</option>`;
        else
            html += `<option value="3">Romantic</option>`;
        if(edit) {
            html += `</select><br><br>
            <input class="film_data" type="button" onclick="editFilm(${id})" value="Uložiť údaje" name="film_save">
            <input class="film_data" type="button" onclick="cancelOverlay()" value="Zrušiť" name="overLay_cancel">
            </form></div>`;
        } else {
            html += `</select><br><br>
            <input class="film_data" type="button" onclick="addFilm()" value="Pridať film" name="film_save">
            <input class="film_data" type="button" onclick="cancelOverlay()" value="Zrušiť" name="overLay_cancel">
            </form></div>`;
        }
    input.innerHTML += html;
    over.setAttribute('class', 'overlay');
    over.setAttribute('id', "overlay");
    over.appendChild(input);
    document.getElementById('films').insertBefore(over, first);
    var inp2 = document.createElement('div');
    inp2.setAttribute('id', "overlayback");
    over.insertBefore(inp2, input);
}

function cancelOverlay() {
    var rem = document.getElementById('overlay');
    if(rem !== null)
        rem.parentNode.removeChild(rem);
}

function addFilm() {
    var title = document.getElementById('title');
    var about_film = document.getElementById('about_film');
    var img = document.getElementById('img');
    var type = document.getElementById('selected_type');
    if(validInput(title, about_film, img, type)) {
        $.ajax({
            type: "post",
            url: "?c=Admin&a=add",
            data:
                {
                    'img': img.value,
                    'title': title.value,
                    'about_film': about_film.value,
                    'film_type': type.value
                },
            cache: false,
            success: function (msg, status, jqXHR) {
            }
        });
        cancelOverlay();
    }
}

function editFilm(id_film) {
    if(confirm("Are you sure to edit this film?")) {
        var title = document.getElementById('title');
        var about_film = document.getElementById('about_film');
        var img = document.getElementById('img');
        var type = document.getElementById('selected_type');
        if (validInput(title, about_film, img, type)) {
            $.ajax({
                type: "post",
                url: "?c=Admin&a=edit",
                data:
                    {
                        'id_film': id_film,
                        'img': img.value,
                        'title': title.value,
                        'about_film': about_film.value,
                        'film_type': type.value
                    },
                cache: false,
                success: function (msg, status, jqXHR) {
                }
            });
            document.getElementById('title' + id_film).innerHTML = title.value;
            document.getElementById('about' + id_film).innerHTML = about_film.value;
            document.getElementById('img' + id_film).src = img.value;
            document.getElementById('film_type' + id_film).value = type.value;
            cancelOverlay();
        }
        return false;
    }
}

function isValidHttpUrl(string) {
    let url;
    try {
        url = new URL(string);
    } catch (_) {
        return false;
    }
    return url.protocol === "http:" || url.protocol === "https:";
}

function validInput(title, about_film, img, type) {
    var dataDiv = document.getElementById('formData');
    var valid = true;
    if(title.value === "") {
        valid = false;
        var msg = document.getElementById('titleVal');
        if(msg == null) {
            msg = document.createElement('p');
            msg.setAttribute('class', 'validationMsg');
            msg.setAttribute('id', 'titleVal');
            msg.innerHTML = "Vyplňte titulok";
            dataDiv.insertBefore(msg, title);
        }
    } else {
        var msg = document.getElementById('titleVal');
        if(msg !== null) {
            msg.parentNode.removeChild(msg);
        }
    }
    if(about_film.value === "") {
        valid = false;
        var msg = document.getElementById('about_filmVal');
        if(msg == null) {
            msg = document.createElement('p');
            msg.setAttribute('class', 'validationMsg');
            msg.setAttribute('id', 'about_filmVal');
            msg.innerHTML = "Vyplňte popis filmu";
            dataDiv.insertBefore(msg, about_film);
        }
    } else {
        var msg = document.getElementById('about_filmVal');
        if(msg !== null) {
            msg.parentNode.removeChild(msg);
        }
    }
    if(!isValidHttpUrl(img.value)) {
        valid = false;
        var msg = document.getElementById('imgVal');
        if(msg == null) {
            msg = document.createElement('p');
            msg.setAttribute('class', 'validationMsg');
            msg.setAttribute('id', 'imgVal');
            msg.innerHTML = "Neplatná url obrázku";
            dataDiv.insertBefore(msg, img);
        }
    } else {
        var msg = document.getElementById('imgVal');
        if(msg !== null) {
            msg.parentNode.removeChild(msg);
        }
    }
    if(type.value !== "1" && type.value !== "2" && type.value !== "3") {
        valid = false;
        var msg = document.getElementById('typeVal');
        if(msg == null) {
            msg = document.createElement('p');
            msg.setAttribute('class', 'validationMsg');
            msg.setAttribute('id', 'typeVal');
            msg.innerHTML = "Vyberte typ filmu";
            dataDiv.insertBefore(msg, type);
        }
    } else {
        var msg = document.getElementById('typeVal');
        if(msg !== null) {
            msg.parentNode.removeChild(msg);
        }
    }
    return valid;
}

document.addEventListener('keydown', (e) => {
    if (e.code === "Escape")
        cancelOverlay();
});


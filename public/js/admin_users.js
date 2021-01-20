class User {
    lastData = null;

    constructor() {
        this.getUsers();
        //setInterval(() => this.getFilms(), 100);
    }

    async getUsers() {
        try {
            let response = await fetch('?c=user&a=index');
            let data = await response.json();
            var changeUsers = true;
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
                        changeUsers = false;
                    } else {
                        changeUsers = true;
                        break;
                    }
                }
                for (var j = 0; j < this.lastData.length; j++) {
                    if (deleted[j] === true) {
                        changeUsers = true;
                    }
                }
            }

            if (changeUsers) {
                var list = document.getElementById('usersDiv');
                data.forEach((user) => {
                    var type = user.user_type;

                    var firstSelectable = "";
                    if(type == 1)
                        firstSelectable = "selected";

                    var secondSelectable = "";
                    if(type == 2)
                        secondSelectable = "selected";

                    var html = `<div id="rem${user.id_user}" class="userDiv">
                                    <div class="userDivCont">
                                        <h1 id="info">Meno: ${user.name} ${user.surename}, Login: ${user.log} </h1>
                                        <label for "selected_type${user.id_user}">Zvoľte typ používateľa:</label>
                                        <select id="selected_type${user.id_user}" name="types">
                                            <option ${firstSelectable} value="1">Bežný užívateľ</option>
                                            <option ${secondSelectable} value="2">Administrátor</option></select><br>
                                        <input onclick="editUserType(${user.id_user})" type="button" value="Uložiť údaje">
                                        <input onclick="remUser(${user.id_user})" type="button" value="Vymazať užívateľa">
                                    </div>
                                </div>`;
                    list.innerHTML += html;
                });
                this.lastData = data;
            }
        } catch (e) {
            console.error('Chyba' + e.message);
        }
    }
}

function editUserType(id) {
    var type = document.getElementById('selected_type' + id).value;
    $.ajax({
        type: "post",
        url: "?c=Admin&a=editUserType",
        data:
            {
                'id_user': id,
                'user_type': type
            },
        cache: false,
        success: function (msg, status, jqXHR) {
        }
    });
}

function remUser(id) {
    $.ajax({
        type: "post",
        url: "?c=Admin&a=deleteUser",
        data:
            {
                'id_user': id
            },
        cache: false,
        success: function (msg, status, jqXHR) {
        }
    });
    var rem = document.getElementById('rem' + id);
    return rem.parentNode.removeChild(rem);
}

document.addEventListener('DOMContentLoaded', () => {
    var user = new User();
});
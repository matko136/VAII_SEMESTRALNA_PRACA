class User {
    lastData = null;
    lastStates = null;
    constructor() {
        this.getUsers();
        setInterval(() => this.getUsers(), 1000);
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
                    var changeState = false;
                    for (var j = 0; j < this.lastData.length; j++) {
                        if (data[i].id_user === this.lastData[j].id_user) {
                            if(this.lastStates[j] !== data[i].user_type) {
                                changeState = true;
                            }
                            deleted[j] = false;
                            foundNew = false;
                            break;
                        }
                    }
                    if(changeState) {
                        changeUsers = true;
                        break;
                    }
                    if (foundNew === false) {
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
                this.lastStates = new Array(data.length);
                var list = document.getElementById('usersDiv');
                list.innerHTML = "";
                var count = 0;
                data.forEach((user) => {
                    var type = user.user_type;

                    var firstSelectable = "";
                    if(type === "1") {
                        firstSelectable = "selected";
                        this.lastStates[count] = "1";
                    }
                    var secondSelectable = "";
                    if(type === "2") {
                        secondSelectable = "selected";
                        this.lastStates[count] = "2";
                    }
                    var thirdSelectable = "";
                    if(type === "3") {
                        thirdSelectable = "selected";
                        this.lastStates[count] = "3";
                    }

                    count++;
                    var html = `<div id="rem${user.id_user}" class="userDiv">
                                    <div class="userDivCont">
                                        <h1>Meno: ${user.name} ${user.surename}, Login: ${user.log} </h1>
                                        <label for "selected_type${user.id_user}">Zvoľte typ používateľa:</label>
                                        <select id="selected_type${user.id_user}" name="types">
                                            <option ${firstSelectable} value="1">Bežný užívateľ</option>
                                            <option ${secondSelectable} value="2">Administrátor</option>
                                            <option ${thirdSelectable} value="3">Super administrátor</option></select><br>
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
    if(confirm("Are you sure to edit this user's data?"))
    {
        var type = document.getElementById('selected_type' + id).value;
        var data = {
            'id_user': id,
            'user_type': type
        }
        fetch("?c=Admin&a=editUserType", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        })
            .then(function (data) {
                document.getElementById('msg').innerHTML = `<h1>${data['msg']}</h1>`;
            });
        /*$.ajax({
            type: "post",
            url: "?c=Admin&a=editUserType",
            data:
                {
                    'id_user': id,
                    'user_type': type
                },
            cache: false,
            success: function (msg, status, jqXHR) {
                document.write(msg);
            }
        });*/
    }
}

function remUser(id) {

    /*$.ajax({
        type: "post",
        url: "?c=Admin&a=deleteUser",
        data:
            {
                'id_user': id
            },
        cache: false,
        success: function (msg, status, jqXHR) {
        }
    });*/
    if(confirm("Are you sure to delete this user?")) {
        var data = {
            'id_user': id
        }
        fetch("??c=Admin&a=deleteUser", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        })
            .then(function (data) {
                document.getElementById('msg').innerHTML = `<h1>${data['msg']}</h1>`;
            });

        var rem = document.getElementById('rem' + id);
        return rem.parentNode.removeChild(rem);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    var user = new User();
});
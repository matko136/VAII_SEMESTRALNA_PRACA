function editData() {
    var name = document.getElementById('name');
    var surename = document.getElementById('surename');
    var email = document.getElementById('email');
    if(validateInput(name, surename, email)) {
        $.ajax({
            type: "post",
            url: "?c=auth&a=editData",
            data:
                {
                    'name': name.value,
                    'surename': surename.value,
                    'email': email.value
                },
            cache: false,
            success: function (msg, status, jqXHR) {
                document.getElementById('edit_data_info').innerHTML = msg;
                document.getElementById('ddName').innerHTML = name.value + " " + surename.value;
                document.getElementById('navemail').innerHTML = email.value;
            }
        });
    }
}

function editPasswd() {
    var oldpasswd = document.getElementById('oldpasswd').value;
    var newpasswd = document.getElementById('newpasswd');

    if(newpasswd.value.length > 7) {
        var msg = document.getElementById('passVal');
        if(msg !== null) {
            msg.parentNode.removeChild(msg);
        }
        $.ajax({
            type: "post",
            url: "?c=auth&a=editPasswd",
            data:
                {
                    'old': oldpasswd,
                    'new': newpasswd.value
                },
            cache: false,
            success: function (msg, status, jqXHR) {
                document.getElementById('edit_pass_info').innerHTML = msg;
            }
        });
        document.getElementById('oldpasswd').value = "";
        document.getElementById('newpasswd').value = "";
    } else {
        var msg = document.getElementById('passVal');
        if(msg === null) {
            msg = document.createElement('p');
            msg.setAttribute('class', 'validationMsg');
            msg.setAttribute('id', 'passVal');
            msg.innerHTML = "Zadajte heslo s aspoň 8 znakmi";
            document.getElementById('passwData').insertBefore(msg, document.getElementById('labNewPass'));
        }
    }
}

function validateInput(name, surename, email) {
    var dataDiv = document.getElementById('userData');
    var valid = true;
    if(name.value === "") {
        valid = false;
        var msg = document.getElementById('nameVal');
        if(msg == null) {
            msg = document.createElement('p');
            msg.setAttribute('class', 'validationMsg');
            msg.setAttribute('id', 'nameVal');
            msg.innerHTML = "Vyplňte meno";
            dataDiv.insertBefore(msg, document.getElementById('labName'));
        }
    } else {
        var msg = document.getElementById('nameVal');
        if(msg !== null) {
            msg.parentNode.removeChild(msg);
        }
    }
    if(surename.value === "") {
        valid = false;
        var msg = document.getElementById('surenameVal');
        if(msg === null) {
            msg = document.createElement('p');
            msg.setAttribute('class', 'validationMsg');
            msg.setAttribute('id', 'surenameVal');
            msg.innerHTML = "Vyplňte priezvisko";
            dataDiv.insertBefore(msg, document.getElementById('labsureName'));
        }
    } else {
        var msg = document.getElementById('surenameVal');
        if(msg !== null) {
            msg.parentNode.removeChild(msg);
        }
    }
    if(!validateEmail(email.value)) {
        valid = false;
        var msg = document.getElementById('emailVal');
        if(msg == null) {
            msg = document.createElement('p');
            msg.setAttribute('class', 'validationMsg');
            msg.setAttribute('id', 'emailVal');
            msg.innerHTML = "Vyplňte platný email";
            dataDiv.insertBefore(msg, document.getElementById('labEmail'));
        }
    } else {
        var msg = document.getElementById('emailVal');
        if(msg !== null) {
            msg.parentNode.removeChild(msg);
        }
    }
    return valid;
}

function validateEmail(email)
{
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function delAcc() {
    if(confirm("Are you sure to delete your account?"))
        window.location = "?c=Setting&a=delete";
}
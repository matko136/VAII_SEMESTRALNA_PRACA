function editData() {
    var name = document.getElementById('name').value;
    var surename = document.getElementById('surename').value;
    var email = document.getElementById('email').value;
    $.ajax({
        type:"post",
        url:"?c=auth&a=editData",
        data:
            {
                'name' :name,
                'surename' :surename,
                'email' :email
            },
        cache:false,
        success: function (msg, status, jqXHR) {
            document.getElementById('edit_data_info').innerHTML = msg;
        }
        /*success: function (html)
        {
            alert('Data Send');
            $('#msg').html(html);
        }*/
    });

}

function editPasswd() {
    var oldpasswd = document.getElementById('oldpasswd').value;
    var newpasswd = document.getElementById('newpasswd').value;
    $.ajax({
        type:"post",
        url:"?c=auth&a=editPasswd",
        data:
            {
                'old' :oldpasswd,
                'new' :newpasswd
            },
        cache:false,
        success: function (msg, status, jqXHR) {
            document.getElementById('edit_pass_info').innerHTML = msg;
        }

        /*success: function (html)
        {
            alert('Data Send');
            $('#msg').html(html);
        }*/
    });
    document.getElementById('oldpasswd').value = "";
    document.getElementById('newpasswd').value = "";
}
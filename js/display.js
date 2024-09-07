
/*
function openLoginForm() {
    var loginBox = document.querySelector('.add-box');

    if (loginBox.style.display === 'none') {
        loginBox.style.display = 'block';
    }
}
function closeLoginForm() {
    var loginBox = document.querySelector('.add-box');
    loginBox.style.display = 'none';
        var form = loginBox.querySelector('form');
        if (form) {
            form.reset();
        }
}
*/


function openLoginForm() {
    document.querySelector('.add-box').style.display = "block";
}

function closeLoginForm() 
{
    $('.add-box').hide();
    var form = document.querySelector('.add-box form');
    if (form) {
        form.reset();
    }
}



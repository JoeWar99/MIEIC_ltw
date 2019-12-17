"use strict";

function encodeForAjax(data) {
    return Object.keys(data).map(function(k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}


//popup vars
let popup = document.getElementById("popup");

let button = document.getElementById("edit_pro");

let x = document.getElementById("close");

//username vars
let change_user = document.getElementById("change_username");

let new_user = document.getElementById("new_username");

let error = document.getElementById("error_change_username");

let error_size = document.getElementById("error_username_size");

//password vars
let change_pass = document.getElementById("change_password");

let new_pass = document.getElementById("new_password");
let new_pass2 = document.getElementById("new_password2");

let error_pass = document.getElementById("error_pass");
let error_pass2 = document.getElementById("error_pass2");

//description vars
let change_description = document.getElementById("edit_des");

let description = document.getElementById("description");

//popup functions
button.onclick = function() {
    popup.style.display = "block";
}

x.onclick = function() {
    popup.style.display = "none";
    error.style.display = "none";
    error_size.style.display = "none";
    error_pass.style.display = "none";
    error_pass2.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == popup) {
        popup.style.display = "none";
        error.style.display = "none";
        error_size.style.display = "none";
        error_pass.style.display = "none";
        error_pass2.style.display = "none";
    }
}

//change username functions
new_user.addEventListener("keydown", function(event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        change_user.click();
    }
});

change_user.onclick = function() {
    error.style.display = "none";
    error_size.style.display = "none";

    if (/^[0-9a-zA-Z]{6,}$/.test(new_user.value)) {
        let requestChangeUsername = new XMLHttpRequest();
        requestChangeUsername.open("POST", "../actions/api_change_username.php", true);
        requestChangeUsername.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        requestChangeUsername.send(encodeForAjax({ new_username: new_user.value }));
        requestChangeUsername.onload = receiveResponse;
    } else {
        error_size.style.display = "inline";
        error.style.display = "none";
    }
}

function receiveResponse() {
    if (this.responseText == 0) {
        popup.style.display = "none";
        error.style.display = "none";
        error_size.style.display = "none";
        location.reload();
    } else {
        error.style.display = "inline";
        error_size.style.display = "none";
    }
}

//change password functions
new_pass.addEventListener("keydown", function(event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        change_pass.click();
    }
});

new_pass2.addEventListener("keydown", function(event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        change_pass.click();
    }
});

change_pass.onclick = function() {
    error_pass.style.display = "none";
    error_pass2.style.display = "none";

    if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/.test(new_pass.value) && new_pass.value == new_pass2.value) {
        let requestChangePassword = new XMLHttpRequest();
        requestChangePassword.open("POST", "../actions/api_change_password.php", true);
        requestChangePassword.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        requestChangePassword.send(encodeForAjax({ new_password: new_pass.value }));
        requestChangePassword.onload = receiveResponsePass;
    } else if (new_pass.value != new_pass2.value) {
        error_pass2.style.display = "inline";
    } else {
        error_pass.style.display = "inline";
    }
}

function receiveResponsePass() {
    if (this.responseText == 0) {
        popup.style.display = "none";
        error_pass.style.display = "none";
        error_pass2.style.display = "none";
    } else {
        error_pass.style.display = "inline";
        error_pass2.style.display = "none";
    }
}

//change description functions
description.addEventListener("keydown", function(event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        change_description.click();
    }
});

change_description.onclick = function() {
    let requestChangeDescription = new XMLHttpRequest();
    requestChangeDescription.open("POST", "../actions/api_change_description.php", true);
    requestChangeDescription.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    requestChangeDescription.send(encodeForAjax({ new_description: description.value }));
    requestChangeDescription.onload = receiveResponse3;

}

function receiveResponse3() {
    if (this.responseText == 0) {
        location.reload();
    } else {
        console.log(this.responseText);
    }
}

console.log('lolool');
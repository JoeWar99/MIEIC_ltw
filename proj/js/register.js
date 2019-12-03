"use strict";

// GETTING ALL INPUT TEXT OBJECTS
let name = document.forms["registerForm"]["name"];
let dateOfBirth = document.forms["registerForm"]["dateOfBirth"];
let email = document.forms["registerForm"]["email"];
let username = document.forms["registerForm"]["username"];
let password = document.forms["registerForm"]["password"];
let passwordConfirm = document.forms["registerForm"]["passwordConfirmation"];

// GETTING ALL ERROR DISPLAY OBJECTS
let nameError = document.getElementById("nameError");
let dateOfBirthError = document.getElementById("dateOfBirthError");
let emailError = document.getElementById("emailError");
let usernameError = document.getElementById("usernameError");
let passwordError = document.getElementById("passwordError");

// SETTING ALL EVENT LISTENERS
name.addEventListener("input", nameVerify, true);
username.addEventListener("input", usernameVerify, true);
email.addEventListener("input", emailVerify, true);
password.addEventListener("input", passwordVerify, true);
passwordConfirm.addEventListener("input", passwordConfirmVerify, true);
dateOfBirth.addEventListener("input", dateOfBirthVerify, true);

function Validate() {
    let returnValue = true;
    let passwordConfirmOrnot = true;

    if (!nameVerify()) {
        returnValue = false;
    }

    if (!dateOfBirthVerify()) {
        returnValue = false;
    }

    if (!usernameVerify()) {
        returnValue = false;
    }

    if (!emailVerify()) {
        returnValue = false;
    }

    if (!passwordVerify()) {
        passwordConfirmOrnot = false;
        returnValue = false;
    }

    if (passwordConfirmOrnot) {
        if (!passwordConfirmVerify())
            returnValue = false;
    }

    return returnValue;

}

function dateOfBirthVerify() {

    if (dateOfBirth.value == "") {
        dateOfBirth.style.border = "1px solid red";
        dateOfBirthError.style.fontSize = "small";
        dateOfBirthError.style.textAlign = "center";
        dateOfBirthError.textContent = "D.O.B. is required";
        return false;
    } else {
        dateOfBirth.style.border = "none";
        dateOfBirthError.innerHTML = "";
        return true;
    }

}

function nameVerify() {

    if (!/^[a-zA-Z ]{1,}$/.test(name.value)) {
        name.style.border = "1px solid red";
        nameError.style.fontSize = "small";
        nameError.style.textAlign = "center";
        nameError.textContent = "Name is required and must not contain any numbers or special characters";
        return false;
    } else {
        name.style.border = "none";
        nameError.innerHTML = "";
        return true;
    }

}

function emailVerify() {

    if (email.value == "") {
        email.style.border = "1px solid red";
        emailError.style.fontSize = "small";
        emailError.style.textAlign = "center";
        emailError.textContent = "Email is required ";
        return false;
    } else {
        email.style.border = "none";
        emailError.innerHTML = ""
        return true;
    }

}



function usernameVerify() {

    if (!/^[0-9a-zA-Z]{6,}$/.test(username.value)) {
        username.style.border = "1px solid red";
        usernameError.style.fontSize = "small";
        usernameError.style.textAlign = "center";
        usernameError.textContent = "Username must have a minimum of eight characters and not contain any special characters";
        return false;
    } else {
        username.style.border = "none";
        usernameError.innerHTML = "";
        return true;
    }
}

function passwordVerify() {

    if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/.test(password.value)) {
        password.style.border = "1px solid red";
        passwordError.style.fontSize = "small";
        passwordError.style.textAlign = "center";
        passwordError.textContent = "Password must have a minimum of six characters and contain at least one uppercase letter, one lowercase letter and one number:";
        return false;
    } else if (password.value != passwordConfirm.value) {
        password.style.border = "1px solid red";
        passwordConfirm.style.border = "1px solid red";
        passwordError.style.fontSize = "small";
        passwordError.style.textAlign = "center";
        passwordError.textContent = "Passwords must match";
        return false;
    } else {
        password.style.border = "none";
        passwordError.innerHTML = "";
        return true;
    }

}

function passwordConfirmVerify() {
    if (passwordConfirm.value == "") {
        passwordConfirm.style.border = "1px solid red";
        passwordError.style.fontSize = "small";
        passwordError.style.textAlign = "center";
        passwordError.textContent = "Confirm Password";
        return false;
    } else if (password.value != passwordConfirm.value) {
        password.style.border = "1px solid red";
        passwordConfirm.style.border = "1px solid red";
        passwordError.style.fontSize = "small";
        passwordError.style.textAlign = "center";
        passwordError.textContent = "Passwords must match";
        return false;
    } else {
        password.style.border = "none";
        passwordConfirm.style.border = "none";
        passwordError.innerHTML = "";
        return true;
    }

}
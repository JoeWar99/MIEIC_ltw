'use strict'

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
name.addEventListener("blur", nameVerify, true);
username.addEventListener("blur", usernameVerify, true);
email.addEventListener("blur", emailVerify, true);
dateOfBirth.addEventListener("blur", dateOfBirthVerify, true);
password.addEventListener("blur", passwordVerify, true);
passwordConfirm.addEventListener("blur", passwordConfirmVerify, true);

function Validate() {

    let returnValue = true;
    let returnPassword = true;

    if (name.value == "") {
        name.style.border = "1px solid red";
        nameError.textContent = "Name is required";
        name.focus();
        returnValue = false;
    }

    // dateofBirth validation
    if (dateOfBirth.value == "") {
        dateOfBirth.style.border = "1px solid red";
        dateOfBirthError.textContent = "Date of Birth is required";
        dateOfBirth.focus();
        returnValue = false;
    }

    // username validation
    if (username.value == "") {
        username.style.border = "1px solid red";
        usernameError.textContent = "Username is required";
        username.focus();
        returnValue = false;

    }

    // email validation
    if (email.value == "") {
        email.style.border = "1px solid red";
        emailError.textContent = "Email is required";
        email.focus();
        returnValue = false;
    }



    if (password.value == "") {
        password.style.border = "1px solid red";
        passwordError.textContent = "Password is required";
        password.focus();
        returnValue = false;
    }

    if (passwordConfirm.value == "") {
        passwordConfirm.style.border = "1px solid red";
        passwordError.textContent = "Please Confirm Password";
        passwordConfirm.focus();
        returnValue = false;
        returnPassword = false;
    }

    if (!returnPassword)
        return returnValue;

    if (passwordConfirm.value != password.value) {
        password.style.border = "1px solid red";
        passwordConfirm.style.border = "1px solid red";
        passwordError.textContent = "The two passwords do not match";
        passwordConfirm.focus();
        returnValue = false;
    }

    return returnValue;
}

function nameVerify() {
    if (name.value != "") {
        name.style.border = "none";
        nameError.innerHTML = "";
        return true;
    }
}

function emailVerify() {
    if (email.value != "") {
        email.style.border = "none";
        emailError.innerHTML = "";
        return true;
    }
}

function usernameVerify() {
    if (username.value != "") {
        username.style.border = "none";
        usernameError.innerHTML = "";
        return true;
    }
}

function dateOfBirthVerify() {
    if (dateOfBirth.value != "") {
        dateOfBirth.style.border = "none";
        dateOfBirthError.innerHTML = "";
        return true;
    }
}

function passwordVerify() {
    if (password.value != "") {
        password.style.border = "none";
        passwordError.innerHTML = "";
        return true;
    }
}

function passwordConfirmVerify() {
    if (passwordConfirmVerify.value != "") {
        passwordConfirm.style.border = "none";
        passwordError.innerHTML = "";
        return true;
    }
}
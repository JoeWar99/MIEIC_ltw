"use strict";

let blured = false;

function blur(){
    var body = document.getElementsByTagName("body");
    if (blured) {
        body[0].setAttribute('class', null);
        blured = false;
    }

    else{
        body[0].setAttribute('class', 'blur');
        blured = true;
    }
}

function rent_popup(){
    console.log("wieubqfnpwt");
}

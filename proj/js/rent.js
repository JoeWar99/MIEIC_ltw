"use strict";

let rent_button = document.getElementById("rent_button");

rent_button.addEventListener("click", rent_popup);

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
    blur();
}

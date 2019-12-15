"use strict";

let btns = document.getElementsByTagName("button");

for (let i = 0; i < btns.length; i++){
    if(btns[i].id != "loginButtonR") btns[i].addEventListener("click", function() {
            alert("You must be logged in to access this feature");
    });
}
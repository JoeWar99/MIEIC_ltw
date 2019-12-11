"use strict";


let btn = document.getElementById("rent_button");
let btn2 = document.getElementById("message_button");
let div = document.createElement("DIV");
let overlay = document.getElementById("overlay");

btn.onclick = rent_popup;
overlay.onclick = rent_popdown;


function blurin(){
    overlay.setAttribute('class', 'blur');
}

function blurout(){
    overlay.setAttribute('class', null);
}

function rent_popdown(){
        blurout();
        btn.disabled = false;
        btn2.disabled = false;
        div.innerHTML = "";
}

function rent_popup(){
    event.stopImmediatePropagation();
    blurin();
    btn.disabled = true;
    btn2.disabled = true;
    div.innerHTML += "<form>";
    div.innerHTML += "<label for =\"start_date\"> Check-in </label>"
    div.innerHTML += "<br>";
    div.innerHTML += "<input type=\"date\" name=\"start_date\"> ";
    div.innerHTML += "<br>";
    div.innerHTML += "<label for =\"start_date\"> Check-out </label>"
    div.innerHTML += "<br>";
    div.innerHTML += "<input type=\"date\" name=\"end_date\"> ";
    div.innerHTML += "<br>";
    div.innerHTML += "</form>";
    div.style.position = "absolute";
    overlay.insertAdjacentElement("afterend", div);
    
}

"use strict";


let btn = document.getElementById("rent_button");
let btn2 = document.getElementById("message_button");
let div = document.createElement("DIV");
div.id = "rent_popup";
let overlay = document.getElementById("overlay");

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

function rent_popup(capacity){
    let opt_str = "";
    event.stopImmediatePropagation();
    blurin();
    btn.disabled = true;
    btn2.disabled = true;
    div.innerHTML += "<form>";
    div.innerHTML += "<label for =\"start_date\"> Check-in </label>"
    div.innerHTML += "<br>";
    div.innerHTML += "<input type=\"date\" name=\"start_date\"> ";
    div.innerHTML += "<br>";
    div.innerHTML += "<label for =\"end_date\"> Check-out </label>"
    div.innerHTML += "<br>";
    div.innerHTML += "<input type=\"date\" name=\"end_date\"> ";
    div.innerHTML += "<br>";
    div.innerHTML += "<label for =\"guest_no\"> No. of Guests </label>";
    div.innerHTML += "<br>";
    for(let i = 1; i <= capacity; i++) {
        opt_str+= "<option value=\"" + i + "\">" + i + " guests</option>";
    }
    div.innerHTML += "<select id=\"guest_no\" name= \"guest_no\">" + opt_str + "</select>";
    div.innerHTML += "<br>";
    div.innerHTML += "<input type=\"submit\" value=\"Rent\">";
    div.innerHTML += "</form>";
    console.log(capacity);
    div.style.position = "absolute";
    overlay.insertAdjacentElement("afterend", div);
    
}

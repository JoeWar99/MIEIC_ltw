"use strict";


let btn = document.getElementById("rent_button");
let btn2 = document.getElementById("message_button");

let sub_btn;

let div = document.createElement("DIV");
div.id = "rent_popup";

let overlay = document.getElementById("overlay");

let checkin, checkout;

let firstdate = false;
let seconddate = false;

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

function create_popup_form(capacity){
    let opt_str = "";
    for(let i = 1; i <= capacity; i++) opt_str+= "<option value=\"" + i + "\">" + i + " guests</option>";
    let htmlstr = "<form id=\"rent_form\">" +  
    "<label for =\"start_date\"> Check-in </label><br>" +
    "<input type=\"date\" name=\"start_date\" id=\"start_date\"><br>" +
    "<label for =\"end_date\"> Check-out </label><br>" +
    "<input type=\"date\" name=\"end_date\" id=\"end_date\"><br>" +
    "<label for =\"guest_no\"> No. of Guests </label><br>" +
    "<select id=\"guest_no\" name= \"guest_no\">" + opt_str + "</select>" + "<br>" +
    "<input type=\"submit\" value=\"Rent\" id=\"sub_btn\">" + "</form>";
    div.innerHTML = htmlstr;
}

function on_date_input(){
    if(!firstdate && event.target == checkin) firstdate = true;

    if(!seconddate && event.target == checkout) seconddate = true;

    if(firstdate && seconddate) {
        console.log(checkout.value);
    }
}

function rent_popup(hid, tid, ppd, capacity){

    event.stopImmediatePropagation();

    blurin();

    btn.disabled = true;
    btn2.disabled = true;

    create_popup_form(capacity);

    div.style.position = "absolute";
    div.style.left = "45%";
    div.style.top = "45%";
    div.innerHTML += "<p>" + "var: " +  hid  + " type: " + typeof hid + "</p>";
    div.innerHTML += "<p>" + "var: " +  tid  + " type: " + typeof tid + "</p>";
    div.innerHTML += "<p>" + "var: " +  ppd  + " type: " + typeof ppd + "</p>";
    overlay.insertAdjacentElement("afterend", div);
    
    sub_btn = document.getElementById('sub_btn');

    checkin = document.getElementById('start_date');
    checkout = document.getElementById('end_date');

    checkin.oninput = on_date_input;
    checkout.oninput = on_date_input;
    
}

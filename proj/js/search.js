"use strict";

let form = "search_form";

// GETTING ALL INPUT TEXT OBJECTS
let location_text = document.forms[form]["location"];
let start_date_text = document.forms[form]["start"];
let end_date_text = document.forms[form]["end"];


// GETTING ALL ERROR DISPLAY OBJECTS
let location_error = document.getElementById("location_error");
let start_date_error = document.getElementById("start_error");
let end_date_error = document.getElementById("end_error");

// SETTING ALL EVENT LISTENERS
location_text.addEventListener("input", location_verify, true);
start_date_text.addEventListener("input", start_date_verify, true);
end_date_text.addEventListener("input", end_date_verify, true);

function Validate() {
    let returnValue = true;

    if(!location_verify()) returnValue = false;
    
    else if(!start_date_verify()) returnValue = false;
    
    else if (!end_date_verify()) returnValue = false;

    return returnValue;
}

function location_verify(){
    if (!/[[A-Z]{1}[a-z]*,\s*[[A-Z]{1}[a-z]*\s* /.test(location_text.value)){
        location_text.style.border = "1px solid red";
        location_error.style.fontSize = "small";
        location_error.style.textAlign = "center";
        location_error.textContent = "Location should be in format <City>, <Country>";
        return false;
    }
    else {
        location_text.style.border = "none";
        location_error.innerHTML = "";
        return true;
    }
}

function start_date_verify(){
    if (start_date_text == ""){
        start_date_text.style.border = "1px solid red";
        start_date_error.style.fontSize = "small";
        start_date_error.style.textAlign = "center";
        start_date_error.textContent = "Check-in date is required";
        return false;
    }
    else {
        start_date_text.style.border = "none";
        start_date_error.innerHTML = "";
        return true;
    }
}


function end_date_verify(){
    if (end_date_text == ""){
        end_date_text.style.border = "1px solid red";
        end_date_error.style.fontSize = "small";
        end_date_error.style.textAlign = "center";
        end_date_error.textContent = "Check-out date is required";
        return false;
    }
    else {
        end_date_text.style.border = "none";
        end_date_error.innerHTML = "";
        return true;
    }
}
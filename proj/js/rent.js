"use strict";

let overlay = document.getElementById("overlay");

function blurin() {
    overlay.setAttribute('class', 'blur');
}

function blurout() {
    overlay.setAttribute('class', null);
}

function encodeForAjax(data) {
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
    }).join('&');
}

let rent_button = document.getElementById("rent_button");
let rent_form = document.getElementById("rent_form");

let start_date_f = document.getElementById("start_date");
let end_date_f = document.getElementById("end_date");

let i1 = false, i2 = false;

let ppd = parseInt(document.getElementById("ppd").value);
let hid = parseInt(document.getElementById("hid").value);

rent_button.addEventListener("click", function(){
    blurin();
    event.stopImmediatePropagation();
    rent_form.style.visibility = "visible";

});
overlay.addEventListener("click", function(){
    blurout();
    rent_form.style.visibility = "hidden";
});

let price = 0;

function on_date_input(){
    if(event.target == start_date_f){
        if(!i1) i1 = true;
        let req = new XMLHttpRequest();
        req.open("GET", "../actions/action_check_date.php?" + encodeForAjax({date:start_date_f.value, id:hid}), true);
        req.onload = function(){
            if(req.status >= 200 && req.status < 400){ // Se o SRV retornar bem
                let error = document.getElementById("checkin_error");
                if(this.responseText == "NAY") error.innerHTML = "date unavailable";
                else error.innerHTML = "";
            }
            else {
                console.log("Server Error");
            }
        };
        
        req.onerror = function (){ //SE não ligar ao srv
            console.log("Connection Error");
        };
        req.send();
    }
    
    if(event.target == end_date_f){
        if(!i2) i2 = true;
        let req = new XMLHttpRequest();
        req.open("GET", "../actions/action_check_date.php?" + encodeForAjax({date:end_date_f.value, id:hid}), true);
        req.onload = function(){
            if(req.status >= 200 && req.status < 400){ // Se o SRV retornar bem
                let error = document.getElementById("checkout_error");
                if(this.responseText == "NAY") error.innerHTML = "date unavailable";
                else error.innerHTML = "";
            }
            else {
                console.log("Server Error");
            }
        };
        
        req.onerror = function (){ //SE não ligar ao srv
            console.log("Connection Error");
        };
        req.send();
    }

    if(i1 && i2) {
        let date1 = new Date(start_date_f.value); 
        let date2 = new Date(end_date_f.value); 
        let now = new Date();
        // To calculate the time difference of two dates 
        let Difference_In_Time = date2.getTime() - date1.getTime(); 
  
        // To calculate the no. of days between two dates 
        let Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 

        if(Difference_In_Days > 0 && date1 > now) {
            price = Difference_In_Days * ppd;
            let tp = document.getElementById("total_price");
            if(tp) rent_form.removeChild(tp);
            rent_form.insertAdjacentHTML("beforeend", "<p id=\"total_price\"> Total Price: " + price + "€ </p>" );
            let req = new XMLHttpRequest();
            req.open("GET", "../actions/action_check_availibility.php?" + encodeForAjax({end_date:end_date_f.value, start_date:start_date_f.value ,id:hid}), true);
            req.onload = function(){
                if(req.status >= 200 && req.status < 400){ // Se o SRV retornar bem
                    let error = document.getElementById("checkout_error");
                    if(this.responseText == "NAY") error.innerHTML = "date span unavailable";
                    else {
                        error.innerHTML = "";
                        rent_form.removeEventListener("submit", cancel_sub);
                    }
                }
                else {
                    console.log("Server Error");
                }
            };
        
            req.onerror = function (){ //SE não ligar ao srv
                console.log("Connection Error");
            };
            req.send();
        }
    }
}

let cancel_sub = function(evt){evt.preventDefault();};

start_date_f.addEventListener("input", on_date_input);
end_date_f.addEventListener("input", on_date_input);
rent_form.addEventListener("submit", cancel_sub);

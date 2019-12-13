"use strict";

let overlay = document.getElementById("overlay");

function blurin() {
    overlay.setAttribute('class', 'blur');
}

function blurout() {
    overlay.setAttribute('class', null);
}

let rent_button = document.getElementById("rent_button");
let rent_form = document.getElementById("rent_form");

let start_date_f = document.getElementById("start_date");
let end_date_f = document.getElementById("end_date");

let i1 = false, i2 = false;

let ppd = parseInt(document.getElementById("ppd").value);

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
    if(!i1 && event.target == start_date_f) i1 = true;
    
    if(!i2 && event.target == end_date_f) i2 = true;

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
        }
    }
}

start_date_f.addEventListener("input", on_date_input);
end_date_f.addEventListener("input", on_date_input);

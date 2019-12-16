"use strict";

let select_user = document.getElementById("select_user");
let their_id = document.getElementById("their_id");
let my_id = document.getElementById("my_id");

function encodeForAjax(data) {
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
    }).join('&');
}

select_user.onchange = function(){
    //console.log(select_user.value);
    let tmp_their_id = document.getElementById(select_user.value);
    their_id.value = tmp_their_id.value;
    //console.log(their_id.value);
    let req = new XMLHttpRequest();
    req.open("GET", "../actions/action_fetch_messages.php?" + encodeForAjax({mid:my_id.value, tid:their_id.value}), true);

    req.onload = function(){
        if(req.status >= 200 && req.status < 400){ // Se o SRV retornar bem
            let msg_area = document.getElementById("messages_area");
            msg_area.innerHTML = this.responseText;
        }
    };
    
    req.onerror = function (){ //SE não ligar ao srv
        console.log("Connection Error");
    };
    req.send();
};

select_user.onchange();
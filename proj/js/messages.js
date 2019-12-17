"use strict";

let select_user = document.getElementById("select_user");
let their_id = document.getElementById("their_id");
let my_id = document.getElementById("my_id");
let form = document.getElementById("message_form");
let last_msgs = document.getElementById("last_messages");

form.addEventListener('submit', sendMessage);

window.setInterval(fetch, 2000);

window.setInterval(reload_func, 10000);

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '\'');
}

function sendMessage(event) {
    event.preventDefault();
    let my_id = document.querySelector('input[name=my_id]').value;
    let their_id = document.querySelector('input[name=their_id]').value;
    let message = document.getElementById("foobar");
    
  
    // Send message
    let request = new XMLHttpRequest();
    request.open('get', '../actions/action_send_message.php?' + encodeForAjax({mid: my_id, tid: their_id, content: htmlEntities(message.value)}), true);
    message.value='';
    request.onload = function (){
        if(request.status >= 200 && request.status < 400){ // Se o SRV retornar bem
            fetch();
        }
    };
    request.send();
}

function encodeForAjax(data) {
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
    }).join('&');
}


function reload_last_msgs(){
    let req = new XMLHttpRequest();
    req.open("GET", "../actions/action_refresh_last_msgs.php", true);
    req.onload = function(){
        if(req.status >= 200 && req.status < 400){ // Se o SRV retornar bem
            last_msgs.innerHTML = this.responseText;
            console.log(this.responseText);
        }
    };
    
    req.onerror = function (){ //SE não ligar ao srv
        console.log("Connection Error");
    };
    req.send();

}


function fetch(){
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
    reload_last_msgs();
};

function reload_func(){
    location.reload();
}

select_user.onchange = fetch;

select_user.onchange();
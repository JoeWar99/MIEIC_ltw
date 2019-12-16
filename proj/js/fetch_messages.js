"use strict";

let select_user = document.getElementById("select_user");
let their_id = document.getElementById("their_id");

select_user.onchange = function(){
    console.log(select_user.value);
    let tmp_their_id = document.getElementById(select_user.value);
    their_id.value = tmp_their_id.value;
    console.log(their_id.value);
};

select_user.onchange();
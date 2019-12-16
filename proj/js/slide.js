"use strict";

let index = 1;

mudarPhoto(index);

function mudar(n) {
    mudarPhoto(index += n);
}

function mudarPhoto(n) {
    let i;
    let slide = document.getElementsByClassName("slide");
    if (n > slide.length) {index = 1}
    if (n < 1) {index = slide.length}
    for (i = 0; i < slide.length; i++) {
        slide[i].style.display = "none";  
    }
    slide[index-1].style.display = "block";  
}


/*document.querySelector('.buttonsReservations_2').addEventListener('click',
    function() {
        document.querySelector('.bg-modal').style.display = 'flex';
        document.querySelector
    });*/

let messages = document.getElementById("modal-content");

document.querySelector('.close').addEventListener('click',
    function() {
        document.querySelector('.bg-modal').style.display = 'none';
    });



function pressed_Message_Button(house_id) {
    document.querySelector('.bg-modal').style.display = 'flex';

}
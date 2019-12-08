// POP UPS

document.getElementById('addProperty').addEventListener('click',
    function() {
        document.querySelector('.bg-modal').style.display = 'flex';
    });

document.querySelector('.close').addEventListener('click',
    function() {
        document.querySelector('.bg-modal').style.display = 'none';
    });


document.getElementById('addPicture').addEventListener('click',
    function() {
        document.querySelector('.bg-modal-1').style.display = 'flex';
    });

document.querySelector('.close1').addEventListener('click',
    function() {
        document.querySelector('.bg-modal-1').style.display = 'none';
    });
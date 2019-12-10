//Exemplo JSON
var thePets = [
    {   
        /*name é uma prop e "Meowsalot" é o nome*/
        "name":"Meowsalot",
        "species": "cat",
        "favFood": "tuna"
    },
    {
        "name": "Barky",
        "species": "dog",
        "favFood": "carrots"
    }
];

//  JSON é basicamente, escrever arrays de objetos neste formato
//  Se quisermos aceder ao nome do 1º obj fazemos, thePets[0].name;

//Exemplo AJAX

var pageCounter = 1;
var btn = document.getElementById("btn");
var animalContainer = document.getElementById("animal-info");

btn.addEventListener("click", function() {
    var ourRequest = new XMLHttpRequest();
    ourRequest.open('GET', 'https://learnwebcode.github.io/json-example/animals-' + pageCounter + '.json');
    ourRequest.onload = function(){
        if(ourRequest.status >= 200 && ourRequest.status < 400){ // Se o SRV retornar bem
            var ourData = JSON.parse(ourRequest.responseText);
            renderHTML(ourData);
        }
        else {
            console.log("Server Error");
        }
    };
    
    ourRequest.onerror = function (){ //SE não ligar ao srv
        console.log("Connection Error");
    }

    ourRequest.send();
    pageCounter++;
    if(pageCounter > 3) btn.classList.add("hide-me");
});

function renderHTML(data){
    var htmlString = "";

    for(i = 0; i < data.length; i++){
        htmlString += "<p>" + data[i].name + " is a " + data[i].species + " that likes ";

        for(ii = 0; ii < data[i].foods.likes.length; ii++){
            if (ii == 0) htmlString += data[i].foods.likes[ii];
            else htmlString += " and "  + data[i].foods.likes[ii];
        }

        htmlString += " and dislikes ";

        for(ii = 0; ii < data[i].foods.dislikes.length; ii++){
            if (ii == 0) htmlString += data[i].foods.dislikes[ii];
            else htmlString +=  " and " + data[i].foods.dislikes[ii];
        }
        
        htmlString += ".</p>";
    }
    
    animalContainer.insertAdjacentHTML('beforeend', htmlString);
}


//Minhas experiencias
var testbtn = document.getElementById("postbtn");
testbtn.addEventListener("click", function(){
    var postTest = new XMLHttpRequest();
    postTest.open('POST', "action.php", true);
    postTest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    postTest.onreadystatechange = function (){
        if (this.readyState == 4 && this.status == 200){
            animalContainer.insertAdjacentHTML('afterend', this.responseText);
            animalContainer.insertAdjacentHTML('afterend', '<br>');
        }
    }
    postTest.send("test=Banana");
});
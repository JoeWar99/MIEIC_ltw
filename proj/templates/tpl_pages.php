<?php include_once('../database/db_functions.php'); ?>

<?php

function draw_searchbox(){
    echo "<div id=\"searchbox\">";
        echo "<header>";
            echo "<h2>Find me a cozy place...</h2>";
        echo "</header>";
            echo "<form>";
                echo "<input name=\"Location\" type=\"text\" placeholder=\"Location\" required=\"required\"> <br>";
                
                echo "<input name=\"Start\" type=\"date\" required=\"required\">";

                echo "<input name=\"End\" type=\"date\" required=\"required\"> <br>";

                echo "<select id=\"howmany\" name=\"people\">";
                    echo "<option value=\"1\">1 guest</option>";
                    echo "<option value=\"2\">2 guests</option>";
                    echo "<option value=\"3\">3 guests</option>";
                    echo "<option value=\"4\">4 guests</option>";
                    echo "<option value=\"5\">5 guests</option>";
                    echo "<option value=\"6\">6 guests</option>";
                echo "</select> <br>";
                echo "<button formaction=\"\" formmethod=\"post\">Search</button>";
            echo "</form>";
        echo "</div>";
}

function draw_trending_houses(){
  
    $result = get_top_rated_houses();
    for($i = 0; $i < count($result); $i++){ 
        echo "<div class=\"sample_house\">";
            $pic = get_house_top_pic($result[$i]['Id']);
            echo "<img src=$pic width=\"330\" height=\"230\" />";
            echo "<section name=\"information\">";
            $name = $result[$i]["Name"];
            $id = $result[$i]['Id'];
            echo "<p><a href=\"housepage.php?house_id=$id\"> $name </a></p>";
            $addr = $result[$i]["Address"];
            echo "<p> $addr </p>";
            $price = $result[$i]["PricePerDay"];
            echo "<p> Price: $price /night </p>";
            $rating = $result[$i]["Rating"];
            echo "<p> $rating </p>";
            $cnt = count_comments($result[$i]['Id']);
            echo "<p> $cnt comments</p>";
            echo "</section>";
        echo "</div>";  
    }
}

?>


<?php function draw_homepage()
{   ?>

    <div id="homePage">
        <?php draw_searchbox();?>

        <p> Trending </p>
        
        <?php draw_trending_houses();?> 
    </div>
<?php } ?>
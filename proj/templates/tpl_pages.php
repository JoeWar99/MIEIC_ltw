<?php include_once('../database/db_functions.php'); ?>


<?php function draw_homepage()
{   ?>

    <div id="homePage">

        <div id="searchbox">
            <header>
                <h2>Find me a cozy place...</h2>
            </header>

            <form>
                <input name="Location" type="text" placeholder="Location" required="required"> <br>

                <input name="Start" type="date" required="required">

                <input name="End" type="date" required="required"> <br>

                <select id="howmany" name="people">
                    <option value="1">1 guest</option>
                    <option value="2">2 guests</option>
                    <option value="3">3 guests</option>
                    <option value="4">4 guests</option>
                    <option value="5">5 guests</option>
                    <option value="6">6 guests</option>
                </select> <br>
                <button formaction="" formmethod="post">Search</button>
            </form>
        </div>

        <p> Trending </p>
        
        <?php 
            
            $result = getHousesBestRatings();
            for($i = 0; $i < count($result); $i++){ ?>
            
            <div class="sample_house">
            <img src=" <?php echo(pathPrincipalImageHouse($result[$i]['Id']));  ?>" width="330" height="230" />
            <section name="information">
                <p> <?php echo ($result[$i]["Name"]); ?> </p>
                <p> <?php echo ($result[$i]["Address"]); ?> </p>
                <p> Price: <?php echo ($result[$i]["PricePerDay"]); ?> /night </p>
                <p> <?php echo ($result[$i]["Rating"]); ?> </p>
                <?php $numberOfComments = numberOfCommentsPerHouse($result[$i]['Id']); ?>
                <p> <?php echo ($numberOfComments); ?> comments</p>
            </section>
        </div>
         <?php   
         }
        ?>


       
    </div>
<?php } ?>
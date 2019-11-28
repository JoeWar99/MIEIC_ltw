<?php function draw_homepage()
{   ?>
    <div id="homePage">
        <?php draw_searchPage();
            ?>
    </div>
<?php } ?>



<?php function draw_page()
{

    ?>

<?php } ?>


<?php function draw_searchPage()
{

    ?>

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

<?php } ?>
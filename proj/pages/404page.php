<?php

include('../templates/tpl_common.php');
include('../includes/session.php');

draw_header($_SESSION['username'], "404"); 
?>  
    <div id="error404page">
        <h1> Oops 404: The resource you were trying to access wasn't found on our database.</h1>
        <br> 
        <h2>You: </h2>
     <div>
<?php
draw_footer();
?>
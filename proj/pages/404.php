<?php

    include('../templates/tpl_common.php');
    include('../includes/session.php');

    global $main_stylesheet, $fonts;
    open_html();
    draw_head(get_title("404"), [$main_stylesheet,$fonts[0], $fonts[1], $fonts[2]]);
    open_body();
    draw_header($_SESSION['username'], "404"); 
?>  
    <div id="error404page">
        <h1> Oops 404: The resource you were trying to access wasn't found on our database.</h1>
        <br> 
        <h2>You: </h2>
     <div>
<?php
    footer();
    close_body();
    close_html();
?>
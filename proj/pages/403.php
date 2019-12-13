<?php

    include('../templates/tpl_common.php');
    include('../includes/session.php');

    global $main_stylesheet, $fonts;
    open_html();
    draw_head(get_title("403"), [$main_stylesheet,$fonts[0], $fonts[1], $fonts[2]]);
    open_body();
    open_overlay();
    draw_header($_SESSION['username'], "404");
?>  
    <div id="error403page">
        <h1> Oops 403: You don't have the permission to access this content</h1>
        <br> 
        <h2>You: </h2>
     <div>
<?php
    footer();
    close_overlay();
    close_body();
    close_html();
?>
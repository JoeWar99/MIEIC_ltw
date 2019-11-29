<?php function open_head(){
      echo "<head>";
}
?>

<?php function close_head(){
    echo "</head>";
}
?>

<?php function set_title($title){
    echo "<title>$title</title>";
}
?>

<?php function set_charset($charset){
    echo "<meta charset=\"$charset\">";
}
?>

<?php function link_stylesheets($stylesheet_list){
    foreach($stylesheet_list as $stylesheet) {
      echo "<link rel=\"stylesheet\" href=$stylesheet crossorigin=\"anonymous\">";
    }
}
?>

<?php function link_scripts($script_list){
    foreach($script_list as $script){
      echo "<script src=$script[0]";
      if($script[1]) echo " defer";
      echo "></script>";
    }
}

?>

<?php function draw_header($username)
{
  /**
   * Draws the header for all pages. Receives an username
   * if the user is logged in in order to draw the logout
   * link.
   */ ?>
  <!DOCTYPE html>
  <html>
    
    <?php open_head();
        set_title("AirestivoBnB");
        set_charset("utf-8");
        link_stylesheets(["../css/style.css",
                          "https://use.fontawesome.com/releases/v5.3.1/css/all.css",
                          "https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300",
                          "https://fonts.googleapis.com/css?family=Poppins&display=swap"]);
        link_scripts([["../js/register.js", true]]);
        close_head();
    ?>
    <body>
      
      <header>
        <?php if ($username != NULL) { ?>
          <nav id="registernav">
            <table>
              <tr>
                <td>
                  <div id="logoText">
                    <a href="homepage.php"><img src="../assets/logo2.png" alt="Logo for the airestivo BnB"> </a>
                  </div>
                </td>
                <td>
                  <div id="profileMenu">
                    <button id="dropdown"><?= $username ?></button>
                    <div id="dropdownList">
                      <a href="#">Edit</a>
                      <a href="../actions/action_logout.php">Logout</a>
                    </div>
                  </div>
                  <div id="propertiesMenu">
                    <button id="properties">My Properties</button>
                  </div>
                  <div id="reservationsMenu">
                    <button id="reservations">My Reservations</button>
                  </div>
                </td>
              </tr>
            </table>
            <div id="barra_verde">
              </div>
            </nav>
          <?php } ?>
        </header>
        <?php } ?>


  <?php function draw_footer()
  {
    /**
     * Draws the footer for all pages.
     */ ?>
  </body>

  </html>
<?php } ?>
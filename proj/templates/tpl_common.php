<?php function draw_header($username)
{
  /**
   * Draws the header for all pages. Receives an username
   * if the user is logged in in order to draw the logout
   * link.
   */ ?>
  <!DOCTYPE html>
  <html>
    
    <head>
      <title></title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="../css/style.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
      <script src="../js/register.js" defer></script>
    </head>
    
    <body>
      
      <header>
        <?php if ($username != NULL) { ?>
          <nav id="registernav">
            <table>
              <tr>
                <td>
                  <div id="logoText">
                    <img src="../assets/logo2.png" alt="Logo for the airestivo BnB">
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
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
        <nav>
          <ul>
            <li><?= $username ?></li>
            <li><a href="../actions/action_logout.php">Logout</a></li>
          </ul>
        </nav>
      <?php } ?>
    </header>
  <?php } ?>



try {
    createUser($name, $dateOfBirth, $email, $username, $password);
    $_SESSION['username'] = $username;
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Signed up and logged in!');
    header('Location: ../pages/homepage.php');
} 
catch (PDOException $e){
    $_SESSION['messages'][] = array('type' => 'error', 'content' => $e->getMessage());
    header('Location: ../pages/register.php');
}

  </html>
<?php } ?>
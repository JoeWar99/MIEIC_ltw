<?php 
  include('database/db_functions.php');
  include('templates/common/basic.php');

  $users = getAllUsers();
  var_dump($users);

  draw_header('loginPage');
?>
  
  <div id = "loginBox">
      <header>
          <!--The header should have a 
          title (h1), a subtitle (h2) and a logo (img). -->
          <img id ="logo" src="assets/logo.png"
              alt="Logo for the airestivo BnB">
          <h1>airestivo BnB</h1>
      </header>
      <form id= "loginForm">
            <input id="username" name="username or email" class="w3-input w3-border" type="text" placeholder="Username or Email" required="required"> <br>
            <input id="password" name="password" class="w3-input w3-border" type="password" placeholder="Password" required="required"> <br>
            <button id="loginButton" formaction="action_login.php" formmethod="post">Login</button>
      </form>
  </div>
  
  <div>
      <form>
          <button id = "registerButton" formaction="actions/register_page.php" formmethod="post">Register</button>
      </form>
  </div>
  
<?php
  draw_footer();
?>










</body>



</html>
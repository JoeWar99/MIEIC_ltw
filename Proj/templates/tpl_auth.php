<?php function draw_login()
{
    /**
     * Draws the login section.
     */ ?>
    <section id="login">
        <!--     
    <header><h2>Welcome Back</h2></header>

    <form method="post" action="../actions/action_login.php">
      <input type="text" name="username" placeholder="username" required>
      <input type="password" name="password" placeholder="password" required>
      <input type="submit" value="Login">
    </form>

    <footer>
      <p>Don't have an account? <a href="signup.php">Signup!</a></p>
    </footer> -->

        <div id="body1">
            <div id="loginBox">
                <header>
                    <img id="logo" src="../assets/logo.png" alt="Logo for the airestivo BnB">
                    <img id="name" src="../assets/name.png" alt="Airestivo BnB">
                </header>
                <form id="loginForm">
                    <input id="username" name="username or email" class="w3-input w3-border" type="text" placeholder="Username or Email" required="required"> <br>
                    <input id="password" name="password" class="w3-input w3-border" type="password" placeholder="Password" required="required"> <br>
                    <button id="loginButton" formaction="../actions/action_login.php" formmethod="post">Login</button>
                </form>
            </div>

            <div>
                <form>
                    <button id="registerButton" formaction="./register.php" formmethod="post">Register</button>
                </form>
            </div>
        </div>
    </section>
<?php } ?>

<?php function draw_register()
{

    /**
     * Draws the signup section.
     */ ?>
    <nav id="registernav">
        <table>
            <tr>
                <td>
                    <div id="logoText">
                        <img src="../assets/logo2.png" alt="Logo for the airestivo BnB">
                    </div>
                </td>
                <td>
                    <form>
                        <button id="loginButtonR" formaction="./login.php" formmethod="post">Login</button>
                    </form>
                </td>
            </tr>
        </table>
        <div id="barra_verde">
        </div>
    </nav>


    <div id="registerbox">
        <header>
            <h2>Register</h2>
        </header>

        <form>
            <input name="name" class="w3-input w3-border" type="text" placeholder="First and last name" required="required"> <br>
            <input name="dateofbirth" type="date" required="required"> <br>
            <input name="username" class="w3-input w3-border" type="text" placeholder="Username" required="required"> <br>
            <input name="email" class="w3-input w3-border" type="text" placeholder="Email" required="required"> <br>
            <input name="password" class="w3-input w3-border" type="password" placeholder="Password" required="required"> <br>
            <input name="confirmpassword" class="w3-input w3-border" type="password" placeholder="Confirm Password" required="required"> <br>
            <button formaction="../actions/action_register.php" formmethod="post">Submit</button>
        </form>
    </div>



<?php } ?>

<?php function draw_nav_bar()
{ }

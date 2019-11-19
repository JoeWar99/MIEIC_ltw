<?php 
  include('templates/common/basic.php');
  draw_header('loginPage');
?>

<header>
        <!--The header should have a 
        title (h1), a subtitle (h2) and a logo (img). -->
        <img src=""
            alt="Logo for the airestivo BnB">
        <h1>airestivo BnB</h1>
</header>

    <div id = "registerBox">
        <form id= form> 
            <input name="name" class="w3-input w3-border" type="text" placeholder="First and last name" required="required"> <br>
            <input name="dateofbirth" type="date" required="required"> <br>
            <input name="username" class="w3-input w3-border" type="text" placeholder="Username" required="required"> <br>
            <input name="email" class="w3-input w3-border" type="text" placeholder="Email" required="required"> <br>
            <input name="password" class="w3-input w3-border" type="password" placeholder="Password" required="required"> <br>
            <input name="confirmpassword" class="w3-input w3-border" type="password" placeholder="Confirm Password" required="required"> <br>
            <button formaction="action_register.php" formmethod="post">Submit</button>
        </form>
    </div>

    

    
  
<?php
  draw_footer();
?>










   
    
  
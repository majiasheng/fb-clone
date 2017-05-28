<!-- author: Jia Sheng Ma -->
<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==True) {
    header("Location: main.php");
}

?>
<html>
    <head>
        <title>Log in</title>
    </head>
    <body>
        <p>PLEASE LOG IN</br></p>
        <form method="POST" action="login.php">
        	<input type="text" name="email" placeholder="email"><br/>
        	<input type="password" name="password" placeholder="password"><br/>
        	<input type="submit" name="submit" value="Log In">
        </form>
        <br/>
        <p>
            <a href="registration.php">Register</a>
            &nbsp;
            <!-- TODO -->
            <a href="forget_password.php">Forget password?</a>
        </p>
    </body>
</html>

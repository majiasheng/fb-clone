<!-- author: Jia Sheng Ma -->
<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==True) {
    header("Location: main.php");
}
if(isset($_SESSION['registration'])) {
    echo "Registration sucessful!<br/>";
    echo "Now you can log in as ". $_SESSION['registration'];
    unset($_SESSION['registration']);
}
if(isset($_SESSION['error'])) {
    echo $_SESSION['error'] . "<br/>";
    unset($_SESSION['error']);
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
        <p>
            <a href="registration.php">Register</a>
            &nbsp;
            <!-- TODO -->
            <a href="forget_password.php">Forgot password?</a>
        </p>
    </body>
</html>

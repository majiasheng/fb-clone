
<p>Sign Me Up</p>
<?php

require("../include/functions.php");
// session_start();
$connection = connect();

// define error message variables to indicate errors
$fn_err = $ln_err = $email_err = $reemail_err = $pw_err = $bd_err = $gender_err = "";

// if form hasnt been submitted, stay
if($_SERVER["REQUEST_METHOD"] == "POST") {
	// check if there's any empty field
	if(empty($_POST["first_name"])) {
		$fn_err	= " *First name cannot be empty";
	}
	if(empty($_POST["last_name"])) {
		$ln_err	= " *Last name cannot be empty";
	}
	if(empty($_POST["email"])) {
		$email_err = " *Email cannot be empty";
	}
	if(empty($_POST["reemail"])) {
		$reemail_err = " *Email cannot be empty";
	}
	if(empty($_POST["password"])) {
		$pw_err	= " *Password cannot be empty";
	}
	if(!isset($_POST["gender"])) {
		$gender_err = " *Please indicate your gender";
	}
	if($_POST["month"] == "month" || $_POST["day"] == "day" || $_POST["year"] == "year") {
		$bd_err = " *Please select a complete birthday";
	}

	// validate registration
	if(validate_registration()) {
		// create a user 
		$new_user = new User;
		$new_user->set_first_name($_POST["first_name"]);
		$new_user->set_last_name($_POST["last_name"]);
		$new_user->set_email($_POST["email"]);
		$new_user->set_password($_POST["password"]);
		$new_user->set_birth_day($_POST["day"]);
		$new_user->set_birth_month($_POST["month"]);
		$new_user->set_birth_year($_POST["year"]);
		$new_user->set_gender($_POST["gender"]);

		// save user to db
		if (save_user_to_db($new_user, $connection)) {
			//TODO: redirect to index.php with user info
			echo "<p> Redirecting to main page... </p>";
			sleep(1);
			header("Location: index.php");
		} else {
			echo "<p>Failed to save user to database</p>";
		}
	} else {
		// error in submission
		echo "<p>error in submission</p>";
	}
} else {

}

?>


<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<input type="text" name="first_name" placeholder="First Name"> <?php echo $fn_err; ?> <br/>
	<input type="text" name="last_name" placeholder="Last Name"> <?php echo $ln_err; ?> <br/>
	<input type="text" name="email" placeholder="email"> <?php echo $email_err; ?> <br/>
	<input type="text" name="reemail" placeholder="Re-enter email"> <?php echo $reemail_err; ?> <br/>
	<input type="password" name="password" placeholder="password"> <?php echo $pw_err; ?> <br/>
	Birthday: <?php echo $bd_err; ?> <br/>
	<select name="month">
		<option value="month">Month</option>
		<option value="Jan">Jan</option>
		<option value="Feb">Feb</option>
		<option value="Mar">March</option>
		<option value="Apr">April</option>
		<option value="May">May</option>
		<option value="June">June</option>
		<option value="July">July</option>
		<option value="Aug">August</option>
		<option value="Sept">September</option>
		<option value="Oct">Octobor</option>
		<option value="Nov">November</option>
		<option value="Dec">December</option>
	</select>
	<select name="day">
		<option value="day">Day</option>
		<?php
			for($i = 1; $i <= 31; $i++) {
				echo "<option value=". $i . ">" . $i . "</option>";
			}
		?>
	</select>

	<select name="year">
		<option value="year">Year</option>
		<?php
			for($i = 1900; $i <= 2017; $i++) {
				echo "<option value=". $i . ">" . $i . "</option>";
			}
		?>
	</select>
	<br/>
	Gender: 
	<input type="radio" name="gender" value="F">Female 
	<input type="radio" name="gender" value="M">Male 
	<?php echo $gender_err; ?>
	<br>
	<input type="submit" name="submit" value="Sign Me Up">
</form>

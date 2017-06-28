<?php 

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
		// $new_user->set_password($_POST["password"]);
		$new_user->set_password( password_hash( $_POST["password"], PASSWORD_DEFAULT) );
		$new_user->set_birth_day($_POST["day"]);
		$new_user->set_birth_month($_POST["month"]);
		$new_user->set_birth_year($_POST["year"]);
		$new_user->set_gender($_POST["gender"]);
		$new_user->set_num_cover(0);
		$new_user->set_num_profile(0);

		// save user to db
		if (save_user_to_db($new_user, $connection)) {
			sleep(1);
			$_SESSION['registration'] = $new_user->get_email();

			// create a user folder upon registration
			$path = PATH_TO_USERS.$new_user->get_email();
			if (!is_dir($path)) {
	            // umash to get the actual permission 0777; default umask is 022
	            $oldmask = umask(0);
	            mkdir($path, 0777, true);
	            mkdir($path."/cover", 0777, true);
	            mkdir($path."/profile", 0777, true);
	            umask($oldmask);
	        }   

			// redirect to index.php 
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
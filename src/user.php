<!-- author: Jia Sheng Ma -->
<?php
class User {

	// basic info
    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $birth_month;
    private $birth_day;
    private $birth_year;
    private $gender;
    // cover 
    private $cover_photo;
    private $profile_picture;
    // post 
    private $posts = array();
    // about 
    private $education = array();
    private $workspace = array();
    private $current_city;
    private $relationship;
    private $hometown;

	// setters
	function set_first_name($arg) {
		$this->first_name = $arg;
	}
	function set_last_name($arg) {
		$this->last_name = $arg;
	}
	function set_email($arg) {
		$this->email = $arg;
	}
	function set_password($arg) {
		$this->password = $arg;
	}
	function set_birth_month($arg) {
		$this->birth_month = $arg;
	}
	function set_birth_day($arg) {
		$this->birth_day = $arg;
	}
	function set_birth_year($arg) {
		$this->birth_year = $arg;
	}
	function set_gender($arg) {
		$this->gender = $arg;
	}
    function addPost($arg) {
        $posts[] = $arg;
    }
    function setCoverPhoto($arg) {
        $this->cover_photo = $arg;
    }
    function setProfilePicture($arg) {
        $this->profile_picture = $arg;
    }
    function setEducation($arg) {
    	$education[] = $arg;
    }
    function setWorkspace($arg) {
    	$workspace[] = $arg;
    }
    function setCurrentCity($arg) {
    	$this->current_city = $arg;
    }
    function setRelationship($arg) {
    	$this->relationship = $arg;
    }
    function setHometown($arg) {
    	$this->hometown = $arg;
    }

	// getters
	function get_first_name() {
		return $this->first_name;
	}
	function get_last_name() {
		return $this->last_name;
	}
	function get_email() {
		return $this->email;
	}
	function get_password() {
		return $this->password;
	}
	function get_birth_month() {
		return $this->birth_month;
	}
	function get_birth_day() {
		return $this->birth_day;
	}
	function get_birth_year() {
		return $this->birth_year;
	}
	function get_gender() {
		return $this->gender;
	}
    function getPosts() {
        return $this->$posts;
    }
    function getCoverPhoto() {
        return $this->cover_photo;
    }
    function getProfilePicture() {
        return $this->profile_picture;
    }
    function getEducation() {
    	return $this->education;
    }
    function getWorkspace() {
    	return $this->workspace;
    }
    function getCurrentCity() {
    	return $this->current_city;
    }
    function getRelationship() {
    	return $this->relationship;
    }
    function getHometown() {
    	return $this->hometown;
    }


}

?>
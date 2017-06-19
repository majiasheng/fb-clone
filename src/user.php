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
    private $date_joined;

    // cover 
    private $num_cover;
    private $num_profile;
    // post 
    private $posts = array();

    private $info;

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
    function set_num_cover($arg) {
        $this->num_cover = $arg;
    }
    function set_num_profile($arg) {
        $this->num_profile = $arg;
    }
    function set_date_joined($arg) {
    	$this->time_joined = $arg;
    }
    function set_info($info) {
        $this->info = $info;
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
    function get_num_cover() {
        return $this->num_cover;
    }
    function get_num_profile() {
        return $this->num_profile;
    }
 	function get_date_joined() {
        return $this->date_joined;
    }
    function get_info() {
        return $this->info;
    }
 	

}

?>
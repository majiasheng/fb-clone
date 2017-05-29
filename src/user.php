<!-- author: Jia Sheng Ma -->
<?php
class User {

	private $first_name;
	private $last_name;
	private $email;
	private $password;
	private $birth_month;
	private $birth_day;
	private $birth_year;
	private $gender;
    private $posts = array();
	
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
        return $posts;
    }

}

?>
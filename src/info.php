<!-- author_email: Melanie Lin-->
<?php
class Info {
    private $email;
    private $education;
    private $workspace;
    private $current_city;
    private $relationship;
    private $hometown;


    function set_email($arg) {
        $this->email = $arg;
    }
    function set_education($arg) {
        $this->education = $arg;
    }
    function set_workspace($arg) {
        $this->workspace = $arg;
    }
    function set_current_city($arg) {
        $this->current_city = $arg;
    }
    function set_relationship($arg) {
        $this->relationship = $arg;
    }
    function set_hometown($arg) {
        $this->hometown = $arg;
    }

    function get_email() {
        return $this->email;
    }
    function get_education() {
        return $this->education;
    }
    function get_workspace() {
        return $this->workspace;
    }
    function get_current_city() {
        return $this->current_city;
    }
    function get_relationship() {
        return $this->relationship;
    }
    function get_hometown() {
        return $this->hometown;
    }

}
?>

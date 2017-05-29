<!-- author: Jia Sheng Ma -->
<?php
class Post {
    private $type;
    private $content;
    private $date;
    private $is_edited;
    private $comments;
    private $likes;
    private $shares;

    function setType($arg) {
        $this->type = $arg;
    }
    function setContent($arg) {
        $this->content = $arg;
    }
    function setDate($arg) {
        $this->date = $arg;
    }
    function setIsEdited($arg) {
        $this->is_edited = $arg;
    }
    function setComments($arg) {
        $this->comments = $arg;
    }
    function setLikes($arg) {
        $this->likes = $arg;
    }
    function setShares($arg) {
        $this->shares = $arg;
    }

    function getType() {
        return $type;
    }
    function getContent() {
        return $content;
    }
    function getDate() {
        return $date;
    }
    function getIsEdited() {
        return $is_edited;
    }
    function getComments() {
        return $comments;
    }
    function getLikes() {
        return $likes;
    }
    function getShares() {
        return $shares;
    }

}
?>

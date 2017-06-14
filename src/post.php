<!-- author_email: Jia Sheng Ma -->
<?php
class Post {
    private $author_email;
    private $owner_email;
    private $type;
    private $content;
    private $post_time;
    private $is_edited;
    private $comments;
    private $likes;
    private $shares;
    private $post_id;
    private $like_count;

    // function __construct($content, $post_time, $is_edited) {
    //     $this->content = $content;
    //     $this->post_time = $post_time;
    //     $this->is_edited = $is_edited;
    //     //TODO:
    // }

    function setPostId($arg){
        $this->post_id = $arg;
    }
    function setAuthorEmail($arg) {
        $this->author_email = $arg;
    }
    function setOwnerEmail($arg) {
        $this->onwer_email = $arg;
    }
    function setType($arg) {
        $this->type = $arg;
    }
    function setContent($arg) {
        $this->content = $arg;
    }
    function setPostTime($arg) {
        $this->post_time = $arg;
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

    function setLikeCount($arg){
        $this->like_count = $arg;
    }

    function getLikeCount(){
        return $this->like_count;
    }

    function getPostId(){
        return $this->post_id;
    }
    
    function getAuthorEmail() {
        return $this->author_email;
    }
    function getOnwerEmail() {
        return $this->onwer_email;
    }
    function getType() {
        return $this->type;
    }
    function getContent() {
        return $this->content;
    }
    function getPostTime() {
        return $this->post_time;
    }
    function getIsEdited() {
        return $this->is_edited;
    }
    function getComments() {
        return $this->comments;
    }
    function getLikes() {
        return $this->likes;
    }
    function getShares() {
        return $this->shares;
    }

}
?>

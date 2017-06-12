<!-- author: Jia Sheng Ma -->
<?php

require_once("../src/constants.php");
require_once("../src/user.php");
require_once("../src/Post.php");
require_once("../src/info.php");
require_once("../src/comments.php");
// TODO: use prepare statement to insert into db

/**
 * Establishes connection with db
 */
function connect() {
	$dsn = "mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=".CHARSET;
	$opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
       $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $opt);
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

    return $pdo;
}

function validate_name($name) {
	// name cannot have number of characters
	if(preg_match('/[A-Za-z ]/', $name)) {
		return True;
	} else {
		return False;
	}
}

//TODO: return a User object?
function validate_registration() {
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$email = $_POST["email"];
	$password = $_POST["password"];

	// TODO: first and last name should not have special characters
	// if(!empty($first_name)) {
	// 	return False;
	// }

	// email is in the form of *@*

	/* available pw characters are the combination of alpha-numerical chars and 
  [`~!@#$%^&*()-_=+;:'",<.>/?] */

	// month day and year has to be selected
  if(isset($_POST["month"]) && $_POST["month"] != "month"
   && isset($_POST["day"]) && $_POST["day"] != "day"
   && isset($_POST["year"]) && $_POST["year"] != "year"
	// Gender field is required
   && isset($_POST["gender"])

   ) {
      return True;
} else {
  return False;
}
}

function save_user_to_db($user, $pdo) {
	$query = "";
	$query .= "INSERT INTO " . USERS_TABLE . " (";
	// fields of user class
	$query .= "first_name, last_name, email, password, ";
	$query .= "birth_month, birth_day, birth_year, gender";
	$query .= ") VALUES (";

	$query .= ( 
        "'" . $user->get_first_name() 	. "'," .
        "'" . $user->get_last_name() 	. "'," .
        "'" . $user->get_email() 		. "'," .
        "'" . $user->get_password() 	. "'," .
        "'" . $user->get_birth_month()	. "'," .
        "'" . $user->get_birth_day() 	. "'," .
        "'" . $user->get_birth_year()	. "'," .
        "'" . $user->get_gender()       . "'" );

	$query .= ");";

	return $pdo->query($query);

}

function save_info_to_db($user_email, $info, $pdo) {
	$query = "";
	$query .= "INSERT INTO " . INFO_TABLE . " (";
	// fields of user class
	$query .= "email, workplace, education, current_city, ";
	$query .= "hometown, relationship, description";
	$query .= ") VALUES (";

	$query .= ( 
				"'" . $info->get_email() 			. "'," .
				"'" . $info->get_workplace() 		. "'," .
				"'" . $info->get_education() 		. "'," .
				"'" . $info->get_current_city() 	. "'," .
				"'" . $info->get_hometown()			. "'," .
                "'" . $info->get_relationship()         . "'," .
				"'" . $info->get_description() 	. "'" );
	$query .= ") ";
	$query .= (
                "ON DUPLICATE KEY UPDATE " . 
                "workplace = '" . $info->get_workplace() . "', " .
                "education = '" . $info->get_education() . "', " .
                "current_city = '" . $info->get_current_city() . "', " .
                "hometown = '" . $info->get_hometown() . "', " .
                "relationship = '" . $info->get_relationship() . "', " .
                "description = '" . $info->get_description() . "';" );

	return $pdo->query($query);
}

/**
 * Verifies account and passowrd and retrieves
 * user info from database whose email is $user_email
 */
function loadUser($user_email, $password, $pdo) {

    $query = "SELECT * FROM " . USERS_TABLE .
    " WHERE email = :email";
    $stmt = $pdo->prepare($query);

    $stmt->execute(['email' => $user_email]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if( password_verify($password, $user_data['password']) ){
    	$user = new User;
        $user->set_first_name($user_data['first_name']);
        $user->set_last_name($user_data['last_name']);
        $user->set_email($user_data['email']);
        $user->set_password($user_data['password']);
        $user->set_birth_month($user_data['birth_month']);
        $user->set_birth_day($user_data['birth_day']);
        $user->set_birth_year($user_data['birth_year']);
        $user->set_gender($user_data['gender']);
        return $user;
    } else {
    	return NULL;
    }
}

/**
 * Load user profile/info
 * returns a user object
 */
function loadUserProfile($user_email, $pdo) {
    $query = "SELECT * FROM " . USERS_TABLE .
    " WHERE email = :email";
    $stmt = $pdo->prepare($query);

    $stmt->execute(['email' => $user_email]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if(!$user_data) {
        return False;
    }

    $user = new User;
    $user->set_first_name($user_data['first_name']);
    $user->set_last_name($user_data['last_name']);
    $user->set_email($user_data['email']);
    $user->set_password($user_data['password']);
    $user->set_birth_month($user_data['birth_month']);
    $user->set_birth_day($user_data['birth_day']);
    $user->set_birth_year($user_data['birth_year']);
    $user->set_gender($user_data['gender']);

    $info = load_user_info($user->get_email(), $pdo);
    $user->set_info($info);

    return $user;
}

function saveCommentToDB($author_email, $post_id, $pdo, $comment){

    $query = "INSERT INTO " . COMMENTS_TABLE 
    . "(post_id, author_email, comment_content) "
    . "VALUES (:post__id, :author_email, :comment_content)";
    $stmt = $pdo->prepare($query);
    return $stmt->execute(['post__id' => $post_id, 'author_email' => $author_email, 'comment_content' => $comment]);

}

function load_user_info($user_email, $pdo) {
	$query = "SELECT * FROM " . INFO_TABLE .
				" WHERE email = :email;";
	$stmt = $pdo->prepare($query);
	$stmt->execute(['email' => $user_email]);

	$info = new Info;
	if(!($user_info = $stmt->fetch(PDO::FETCH_ASSOC))) {
        $info = new Info;
        $info->set_email($user_email);
        $info->set_education("");
        $info->set_workplace("");
        $info->set_current_city("");
        $info->set_relationship("");
        $info->set_hometown("");
        $info->set_description("");
        return $info;
    } else {
        $info = new Info;
        $info->set_email($user_email);
        $info->set_education($user_info['education']);
        $info->set_workplace($user_info['workplace']);
        $info->set_current_city($user_info['current_city']);
        $info->set_relationship($user_info['relationship']);
        $info->set_hometown($user_info['hometown']);
        $info->set_description($user_info['description']);
        return $info;
    }

}

function savePostToDB($user_email, $pdo, $post) {
    //TODO: insert post to db
    $query = "INSERT INTO " . POSTS_TABLE 
    . "(author_email, content) "
    . "VALUES (:email,:content)";


    // INSET INTO likes (post_id) VALUES ( INTEGER );
    $init_likes_person = "INSERT INTO " . LIKE_TABLE
    . "(post_id, author_email)"
    . "VALUES (:post_id, :author_email)";

    $stmt = $pdo->prepare($query);
    $rtval =  $stmt->execute(['email' => $user_email, 'content' => $post]);

    // SELECT * FROM `posts` ORDER BY `id` DESC LIMIT 1  -> get the lastest post
    $latest_post = "SELECT * FROM " . POSTS_TABLE . " ORDER BY id DESC LIMIT 1";
    $stmt_two = $pdo->prepare($latest_post);
    $stmt_two ->execute();

    $newest_post = $stmt_two->fetchAll(PDO::FETCH_ASSOC);
    $latest_post_id = $newest_post[0]['id'];

    $stmt_three = $pdo->prepare($init_likes_person);
    $stmt_three->execute(['post_id' => $latest_post_id , 'author_email' => $user_email]);

    return $rtval;
}

function loadPosts($user_email, $pdo) {
    //TODO: need to join comments with posts later

    $query = "SELECT id, content, post_time, edit_time,like_count from " . POSTS_TABLE 
    . " WHERE author_email = :email order by post_time DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['email' => $user_email]);

    //TODO: wrap contents in post object and return list of posts
    $post_objs = array();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($posts as $c) {
        $p = new Post;
        $p->setAuthorEmail($user_email);
        $p->setContent($c['content']);
        $p->setPostTime($c['post_time']);
        $p->setPostId($c['id']);
        $p->setLikeCount($c['like_count']);
        if($c['post_time']==$c['edit_time']) {
            $p->setIsEdited(False);
        } else {
            $p->setIsEdited(True);
        }

        array_push($post_objs, $p);
    }
    return $post_objs;
}

function load_one_post($post_id, $pdo){
    // $query = "SELECT author_email, id from" . POSTS_TABLE
    // . " WHERE id = :id";

    $query = "SELECT author_email, id, like_count from " . POSTS_TABLE
    . " WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $post_id]);
    $post = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $post;
}

function load_comments($post_id, $pdo){
    
    $query = "SELECT author_email, comment_time, comment_content from " . COMMENTS_TABLE 
    . " WHERE post_id = :post_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['post_id' => $post_id]);

    $comment_array = array();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($comments as $c){
        $comment = new Comment;
        $comment->setPostId($post_id);
        $comment->setAuthor($c['author_email']);
        $comment->setCommentContent($c['comment_content']);
        $comment->setCommentTime($c['comment_time']);

        array_push($comment_array, $comment);
    }

    return $comment_array;
}

function getUserNameByEmail($email, $pdo) {
    $query = "SELECT first_name, last_name FROM " 
        . USERS_TABLE 
        . " WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['email' => $email]);
    $rtval = $stmt->fetch(PDO::FETCH_ASSOC);
    return $rtval['first_name'] . " " . $rtval['last_name'];
}

function getAllUsers($pdo) {
    $query = "SELECT first_name, last_name FROM " . USERS_TABLE;
    return $pdo->query($query);
}

/**
* Check if user has liked a post or not.
* Return: true/false.
*/
function checkLikeStat($post_id, $author_email, $pdo){
    // get the current like state
    // SELECT liked FROM like_person WHERE id = 2 (example)
    $query = "SELECT liked FROM " . LIKE_TABLE . " WHERE post_id = :id AND author_email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $post_id , 'email' => $author_email]);
    $rtval = $stmt->fetch(PDO::FETCH_ASSOC);

    return $rtval;
}

/**
*   Update the like_status, if the user clicked on a post that he has already
*   liked, then the like count will decrease, else increase.
*   If statement to check state in submit_like.php.
*/
function updateLikeStat($post_id, $author_email, $state, $pdo){
    // UPDATE like_person SET liked = 1 WHERE post_id = 6
    $query = "UPDATE " . LIKE_TABLE . " SET liked = :liked WHERE post_id = :post_id AND author_email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['liked' => $state,'post_id' => $post_id, 'email' => $author_email]);
}


/**
* Decrease the like count based on post_id;
*/
function incLikesDB($post_id, $pdo){
    $query = 'UPDATE ' . POSTS_TABLE . ' SET like_count = like_count + 1 WHERE id = :post_id';
    $stmt = $pdo->prepare($query);
    $stmt->execute(['post_id' => $post_id]);
}

/**
* Decrease the like count based on post_id;
*/
function decLikesDB($post_id, $pdo){
    $query = 'UPDATE ' . POSTS_TABLE . ' SET like_count = like_count - 1 WHERE like_count > 0 AND id = :post_id';
    $stmt = $pdo->prepare($query);
    $stmt->execute(['post_id' => $post_id]);
}


/**
*   Return the post content based on post_id
*/
function getShareContent($post_id, $pdo){
    $query = "SELECT content FROM " .POSTS_TABLE. " WHERE id = :post_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['post_id' => $post_id]);
    $rtval = $stmt->fetch(PDO::FETCH_ASSOC);
    return $rtval;
}

/**
*   Check if the post content belongs to the current user or belong to friend
*   Return NULL if belong to friend
*   Return post content if beloing to user.
*/
function checkBelongToUser($post_id, $email, $pdo){
    $query = "SELECT ( SELECT content FROM " .POSTS_TABLE. " WHERE id = :post_id AND author_email = :email) AS content";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['post_id' => $post_id, 'email' => $email]);
    $rtval = $stmt->fetch(PDO::FETCH_ASSOC);

    return $rtval;
}



/**
*   Get the number of likes based on the post id, return the liked count.
*/
function getLikeCount($post_id, $pdo){
    // select like_count from posts where id = 3
    $query = "SELECT like_count from " . POSTS_TABLE . " WHERE id = :id"; 
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $post_id]);
    $rtval = $stmt->fetch(PDO::FETCH_ASSOC);

    return $rtval;
}

/**
*   Check if user has been input into the like_person post yet.
*/
function checkNullLikeState($post_id, $author_email, $pdo){
    $query = "SELECT ( SELECT liked FROM " .LIKE_TABLE. " WHERE post_id = :post_id AND author_email = :email) AS id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['post_id'=> $post_id, 'email' => $author_email]);
    $rtval = $stmt->fetch(PDO::FETCH_ASSOC);
    return $rtval;
}

/**
*   Create a new entry for the user who doesn't have linkage with the post like yet.
**/
function linkPost($post_id, $author_email, $pdo){
    $query = "INSERT INTO " .LIKE_TABLE. "(post_id, author_email)" .
    " VALUES(:post_id, :author_email); ";
    $stmt = $pdo->prepare($query);
    return $stmt->execute(['post_id' => $post_id, 'author_email' => $author_email]);   
}


/**
 * For performing search (by $user)
 */
function getUserIfMatch($user, $keyword, $pdo) {

    $query = "SELECT first_name, last_name, email FROM "
        . USERS_TABLE
        // . " WHERE first_name LIKE ?"
        // . " OR last_name LIKE ?";
        . " WHERE concat(first_name, concat(' ', last_name)) like ? AND email <> ?;";
        // . " OR last_name LIKE ?";
    $stmt = $pdo->prepare($query);
    // $stmt->execute(array("%$keyword%", "%$keyword%"));
        $stmt->execute(array("%$keyword%", "$user"));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
// $query = "SELECT first_name, last_name, email FROM "
//     . USERS_TABLE
//     . " WHERE first_name LIKE '%". $keyword . "%'"
//     . " OR last_name LIKE '%". $keyword . "%'";
//     return $pdo->query($query)->fetch();
}

/**
 * Adds friend to table, A sent request to B,
 * return True on sucess, False otherwise
 */
function addFriend($friendA, $friendB, $pdo) {
    $query = "INSERT INTO " . FRIENDS_TABLE . " (friendA, friendB) "
        . "VALUES(:A, :B);";
    $stmt = $pdo->prepare($query);
    return $stmt->execute(['A' => $friendA, 'B' => $friendB]);
}

/**
 * Removes friend from table, A sent request to B,
 * return True on sucess, False otherwise
 */
function removeFriend($friendA, $friendB, $pdo) {
    $query = "DELETE FROM " . FRIENDS_TABLE . " WHERE friendA = ? AND friendB = ?;";
    $stmt = $pdo->prepare($query);
    return $stmt->execute([$friendA, $friendB]);
}

function loadFriends($user_email, $pdo) {
    $query = "SELECT friendA FROM " . FRIENDS_TABLE . " WHERE friendB = ?"
        . " UNION "
        . "SELECT friendB FROM " . FRIENDS_TABLE . " WHERE friendA = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_email, $user_email]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

/**
 * Returns 1 if A and B are friends (undirected)
 * 0 otherwise
 */
function isFriend($A, $B, $pdo) {
    $query = "SELECT * FROM " . FRIENDS_TABLE . " WHERE friendA = ? "
        . "AND friendB = ? OR friendA = ? AND friendB = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$A, $B, $B, $A]);
    $rtval = $stmt->fetchAll(PDO::FETCH_COLUMN);
    return count($rtval);
}


/**
 * Check if A has sent request to B
 */
function isRequestSent($A, $B, $pdo) {
    $query = "SELECT * FROM " . FRIEND_REQUEST_TABLE
        . " WHERE sender = ? AND receiver = ? LIMIT 1;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$A, $B]);

    return $stmt->fetch();
}

/**
 * A sends request to B, and B receives notification
 */
function sendFriendRequest($A, $B, $pdo) {
    $query = "INSERT INTO " . FRIEND_REQUEST_TABLE
        . " (sender, receiver) VALUES (?, ?);";
    $stmt = $pdo->prepare($query);
    return $stmt->execute([$A, $B]);
}

/**
 * Remove friend request. A sent request to B, and B receives notification
 */
function removeFriendRequest($A, $B, $pdo) {
    $query = "DELETE FROM " . FRIEND_REQUEST_TABLE
        . " WHERE sender = ? AND receiver = ?;";
    $stmt = $pdo->prepare($query);
    return $stmt->execute([$A, $B]);
}

function loadFriendRequests($user_email, $pdo) {
    $query = "SELECT sender FROM " . FRIEND_REQUEST_TABLE 
        . " WHERE receiver = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_email]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

/**
 * A sent request to B
 */
function acceptFriendRequest($A, $B, $pdo) {
    /*TODO: 
        - add friend to friend_with table
        - remove friend request from friend_request table
    */
    addFriend($A, $B, $pdo) ;
    removeFriendRequest($A, $B, $pdo);
}


/**
 * Save images
 */
// function saveCoverPhoto($pdo, $email) {
//     $image_name = $_FILES["cover_upload"]["name"];
//     $image_tmp = addslashes(file_get_contents($_FILES["cover_upload"]["tmp_name"]));

//     $query = "INSERT INTO " . IMAGE_TABLE . " (";
//     $query .= "email, cover";
//     $query .= ") VALUES (";
//     $query .= "'" . $email . "', '" . $image_name . "');";

//     $pdo->query($query);
// }


?>

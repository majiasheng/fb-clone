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

    $post_id = (int)$post_id;

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
    $stmt = $pdo->prepare($query);
    return $stmt->execute(['email' => $user_email, 'content' => $post]);
}



function loadPosts($user_email, $pdo) {
    //TODO: need to join comments with posts later

    $query = "SELECT id, content, post_time, edit_time from " . POSTS_TABLE 
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
        if($c['post_time']==$c['edit_time']) {
            $p->setIsEdited(False);
        } else {
            $p->setIsEdited(True);
        }

        array_push($post_objs, $p);
    }
    return $post_objs;
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
 * For performing search
 */
function getUserIfMatch($keyword, $pdo) {

    $query = "SELECT first_name, last_name, email FROM "
        . USERS_TABLE
        . " WHERE first_name LIKE ?"
        . " OR last_name LIKE ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array("%$keyword%", "%$keyword%"));
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

function rejectFriendRequest($A, $B, $pdo) {
    //TODO:
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

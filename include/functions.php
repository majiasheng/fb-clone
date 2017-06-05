<!-- author: Jia Sheng Ma -->
<?php

require_once("../src/constants.php");
require_once("../src/user.php");
require_once("../src/Post.php");
require_once("../src/info.php");
require_once("../src/comments.php");

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
        "'" . $user->get_gender() . "'" );
	$query .= ");";

	return $pdo->query($query);

}

function save_info_to_db($user_email, $info, $pdo) {
	$query = "";
	$query .= "INSERT INTO " . INFO_TABLE . " (";
	// fields of user class
	$query .= "email, workspace, education, current_city, ";
	$query .= "hometown, relationship";
	$query .= ") VALUES (";

	$query .= ( 
				"'" . $info->get_email() 			. "'," .
				"'" . $info->get_workspace() 		. "'," .
				"'" . $info->get_education() 		. "'," .
				"'" . $info->get_current_city() 	. "'," .
				"'" . $info->get_hometown()			. "'," .
				"'" . $info->get_relationship() 	. "'" );
	$query .= ") ";
	$query .= (
                "ON DUPLICATE KEY UPDATE " . 
                "workspace = '" . $info->get_workspace() . "', " .
                "education = '" . $info->get_education() . "', " .
                "current_city = '" . $info->get_current_city() . "', " .
                "hometown = '" . $info->get_hometown() . "', " .
                "relationship = '" . $info->get_relationship() . "';" );
    
	return $pdo->query($query);
}

/**
 * Retrieves user info from database whose email is $user_email
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

function saveCommentToDB($author, $post_id, $pdo, $comment){

    $post_id = (int)$post_id;

    $query = "INSERT INTO " . COMMENTS_TABLE 
    . "(post_id, author, comment_content) "
    . "VALUES (:post__id, :author, :comment_content)";
    $stmt = $pdo->prepare($query);
    return $stmt->execute(['post__id' => $post_id, 'author' => $author, 'comment_content' => $comment]);

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
        $info->set_workspace("");
        $info->set_current_city("");
        $info->set_relationship("");
        $info->set_hometown("");
        return $info;
    } else {
        $info = new Info;
        $info->set_email($user_email);
        $info->set_education($user_info['education']);
        $info->set_workspace($user_info['workspace']);
        $info->set_current_city($user_info['current_city']);
        $info->set_relationship($user_info['relationship']);
        $info->set_hometown($user_info['hometown']);
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
    
    $query = "SELECT author, comment_time, comment_content from " . COMMENTS_TABLE 
    . " WHERE post_id = :post_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['post_id' => $post_id]);

    $comment_array = array();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($comments as $c){
        $comment = new Comment;
        $comment->setPostId($post_id);
        $comment->setAuthor($c['author']);
        $comment->setCommentContent($c['comment_content']);
        $comment->setCommentTime($c['comment_time']);

        array_push($comment_array, $comment);
    }

    return $comment_array;
}

//TODO: function that adds friend to record
//TODO: function that removes friend from record


?>

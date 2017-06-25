
<?php
/**
 * NPC: non player character
 *      This file is name this way because I couldn't find a better name for:
 *      not the logged in user
 *
 *      This file redirects to a specified user
 */

require_once("../include/functions.php");
require_once("../include/loads/load_images.php");

session_start();

if(!isset($_GET['user'])) {
    header("Location: main.php");
}
// $_GET['user'] = user email
$pdo = connect();
$user = loadUserProfile($_GET['user'], $pdo);

// if user doesn't exist in db, then redirect back to main
if(!$user) {
    header("Location: main.php");
}
$info = $user->get_info();

$full_user_name = $user->get_first_name() . " " . $user->get_last_name();

// if the user to redirect to is the user, then go to the main page instead
if(strcmp($_GET['user'], $_SESSION['user']->get_email()) == 0) {
    header("Location: main.php");
}

// check whether there's a sending of friend request
if(isset($_POST['friend_request'])) {
    /*  add notification to the to-be friend, 
        and the to-be friend would need to refresh page 
        to get notified (for now)
    */
    // "you" send friend request to "NPC"
    sendFriendRequest($_SESSION['user']->get_email(), $_GET['user'], $pdo);
    
    // set "is_request_sent" to true
    // $_SESSION['is_request_sent'] = True;

    unset($_POST['friend_request']);
    // redirect to self to prevent resubmission by refreshing
    $self = $_SERVER['REQUEST_URI'];
    header("Location: $self");
}

// check whether there's a cancelling of friend request
if(isset($_POST['cancel_friend_request'])) {

    removeFriendRequest($_SESSION['user']->get_email(), $_GET['user'], $pdo);
    unset($_POST['cancel_friend_request']);
    
    // unset($_SESSION['is_request_sent']);
}

// check if there's a post to friend
// if(isset($_POST['post_to_friend'])) {
//     if(isFriend($_SESSION['user']->get_email(), $user->get_email(), $pdo)) {        
//         savePostToDB($_SESSION['user']->get_email(), 
//             $user->get_email(), 
//             $pdo, 
//             $_POST['post_to_friend']
//         );
//         unset($_POST['post_to_friend']);
//         // redirect to self to prevent resubmission by refreshing
//         $self = $_SERVER['REQUEST_URI'];
//         header("Location: $self");
//     } else {
//         //TODO: make popup window
//         $msg = "Be " . $full_user_name . "'s friend first :)";
//         echo $msg;
//         unset($_POST['post_to_friend']);
//     }
// }


// default profile picture
// $profile_pic = "../rsrc/img/photos/default-profile.png";

$profile_pic = load_profile($user);
$cover_pic = load_cover($user);


?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>
  <?php 
  echo $full_user_name;
  ?>
  </title>

  <link rel="stylesheet" href="../include/styles/css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container-fluid">
    <nav class="navbar" role="navigation">
        <div class="navbar__container">
            <ul class="row">
                <!-- brand icon -->
                <div class="col-md-2 col-sm-12">
                    <li class="header__brand"><a href="main.php"><i class="fa fa-facebook"></i></a></li>
                    </div>
                <!-- username and home button -->
                <div class="col-md-3 col-sm-12 navbar__header">
                    <li class="header__username">
                        <a href="#">
                        <?php 
                        echo $full_user_name;
                        ?>
                        </a>
                    </li>

                    <li class="header__home"><a href="#">Home</a></li>
                </div>
                <!-- friends, messages, and alerts -->
                <div class="col-md-2 col-sm-12 navbar__header">
                    <li class="header__friends header--icon-setting"><a href="#"><i class="fa fa-user"></i></a></li>
                    <li class="header__message header--icon-setting"><a href="#"><i class="fa fa-comments"></i></a></li>
                    <li class="header__alert header--icon-setting"><a href="#"><i class="fa fa-globe"></i></a></li>
                </div>
                <!-- privacy and settings (with a dropdown menu)-->
                <div class="col-md-1 col-sm-12">
                    <li class="header__privacy header--icon-setting"><a href="#"><i class="fa fa-lock"></i></a></li>
                    <li class="header__setting header--icon-setting"><a href="#"><i class="fa fa-caret-down" onclick="show_setting_menu()"></i></a>

                </div>
                <!-- search bar -->
                <div class="col-md-4 col-sm-12">
                    <li class="navbar__form">
                        <form class="navbar__search-form form-inline" role="search" action="search.php" method="GET">
                            <!-- <div class="navbar__search-container form-group"> -->
                                <input type="text" name="search" class="navbar__search-input form-control" placeholder="Search">
                                <!--TODO: send a GET request to search.php -->
                                  <!-- <a href=# class="linka"><i class="fa fa-search"></i></a> -->
                                <input type="submit" value="Search" class="fa fa-search form__search-btn">
                            <!-- </div> -->
                        </form>
                    </li>
                </div>

            </ul> 
        </div>
    </nav>
    <!-- cover image section -->
    <!-- cover image section -->
    <div class="cover">
        <div class="cover__container">
             <div class="cover--fill">
                <?php 
                    echo '<img id="cover_photo" src="'.$cover_pic.'" />';
                ?>              
             </div>
            <div class="cover__profile-container">
                <div class="img_wrapper">
                <?php
                    // load user profile picture
                    echo '<img src="'. $profile_pic . '" alt="profile photo" />';
                ?>
                </div>
            <div class="cover__username">
                <?php 
                echo $user->get_first_name() . " " . $user->get_last_name();
                ?>
            </div>

            </div> 

    </div>

    

    
    <?php

    //if it is not friend, then add a "Add Friend" button to send a friend request
    if(!isFriend($_GET['user'], $_SESSION['user']->get_email(), $pdo)) {
        //TODO: on press, disable button, change text to "request sent"
        echo '<form action="" method="POST">';
        //TODO: onclick: change from "Add Friend" to "Cancel Request"
        if(!isRequestSent($_SESSION['user']->get_email(), $_GET['user'], $pdo)){
            // "you" send friend request to "NPC"

            //TODO: check if db has this friend request instead because 
            //      the other user can decline request
            echo '<input type="submit" name="friend_request" value="Add Friend"> ';
        } else {

            echo '<input type="submit" name="cancel_friend_request" value="Cancel Request"> ';
        }
        echo '</form>';
    } else {
        echo "???";
    }
    ?>

    </div>

    <div class="row content">

        <div class="content__left col-md-4">
            <!-- left side -->
            <div class="left__intro">
                <h2 class="content__title content__title--font"><i class="fa fa-pencil-square-o content__icon content__icon--bg" aria-hidden="true"></i>Intro</h2>
                    <?php
                    if(!empty($info->get_description())) {
                        echo '<p class="intro__detail text-center" id="description">' . $info->get_description() . '</p>';
                    }
                    if(!empty($info->get_current_city()))
                        echo '<p class="intro__detail"><i class="fa fa-home"></i> Lives in ' . $info->get_current_city() . '</p>';
                    if(!empty($info->get_hometown())) 
                        echo '<p class="intro__detail"><i class="fa fa-map-marker"></i> From ' . $info->get_hometown() . '</p>';
                    
                    ?>

            </div>

            <!-- ********************** left: photos ********************** -->
            <div class="left__photos">
                <a href=#><h2 class="content__title content__title--font">
                    <i class="fa fa-picture-o content__icon content__icon--bg" aria-hidden="true"></i>
                    Photos
                </h2></a>

                <?php
                ?>

            </div> <!-- ********************** end photos ********************** -->

            <!-- ********************** left: friends ********************** -->
            <div class="left__friends">
                <!-- TODO: redirect to NPC's friends -->
                <a href="friends.php?user=<?php echo $user->get_email(); ?>">
                    <h2 class="content__title content__title--font">
                    <i class="fa fa-user-plus content__icon content__icon--bg" aria-hidden="true"></i>
                    Friends
                    </h2>
                </a>

                <div class="row photos__container">

                    <?php
                    $friends = loadFriends($user->get_email(), $pdo);
                    if($friends){
                        $counter = 0;
                        foreach($friends as $f) {
                            if($counter > 8) {
                                break;
                            }
                            //TODO: display profile picture instead
                            echo "<a href=\"NPC.php?user=". $f . "\">" . getUserNameByEmail($f, $pdo) . "</a>";
                            echo "&nbsp;";
                        }
                    } else {
                        echo "Lonely person :(";
                    }
                    ?>
                </div>
            </div> <!-- ********************** end friends ********************** -->

            <!-- ********************** left footer ********************** -->
            <div class="left__footer">
                <footer>
                    <ul class="">
                        <li class="footer__links"><a href="">Privacy</a></li>   
                        <li class="footer__links"><a href="">Terms</a></li>
                        <li class="footer__links"><a href="">Advertising</a></li>
                        <li class="footer__links"><a href="">Ad Choices</a></li>
                        <li class="footer__cookies"><a href="">Cookies</a></li>
                        <li class="footer__more"><a href="">More</a></li>
                        <li class="footer__copyright"><a href="">Facebook &copy 2017</a></li>
                    </ul>
                </footer>
            </div> <!-- ********************** left footer ********************** -->
        </div> <!-- end left column -->

        <!-- ********************** middle: post panel ********************** -->
        <div class="content__middle col-md-6">
            <div class="middle__timeline">
                <ul class="row">
                    <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <a href="#" class="active">
                            <i class="fa fa-calendar-check-o timeline__icon"></i>
                            timeline
                        </a>
                    </li>

                    <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <a href="about.php">
                            <i class="fa fa-user-circle timeline__icon"></i class="fa fa-user-circle timeline__icon">
                                about
                            </a>
                    </li>
                    
                    <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <a href="#">
                            <i class="fa fa-globe timeline__icon"></i>
                            friends
                        </a>
                    </li>

                    <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <a href="#">
                            <i class="fa fa-camera timeline__icon"></i>
                            photos
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="middle__status">
                <ul class="row">
                    <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3 status--text">
                        <i class="fa fa-pencil"></i>
                        Status
                    </li>

                    <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3 status--text">
                        <i class="fa fa-camera-retro"></i>
                        Photo / Video
                    </li>
                    <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3 status--text">
                        <i class="fa fa-video-camera"></i>
                        Live Video
                    </li>

                    <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3 status--text">
                        <i class="fa fa-flag"></i>
                        Life Events
                    </li>
                </ul>


                <!-- TODO: post on wall -->
                <form action="" method="POST" id="post_to_friend_form">
                <textarea placeholder="Write something to <?php 
                echo $full_user_name;
                ?>" 
                rows="3" name="post_to_friend" form="post_to_friend_form"></textarea>
                <input type="hidden" name="NPC_email" value="<?php echo $user->get_email()?>">
                <input type="submit" Value="Post">
                </form>
            </div> <!-- ********************** end panel ********************** -->

            <!-- ********************** middle: post ********************** -->

            <div class="middle__posts">
                <?php
                $posts = loadPosts($user->get_email(), $pdo);
                foreach($posts as $p):

                    // load all the comment of the current post.
                    $comments = load_comments($p->getPostID(), $pdo);
                    
                    // load name of person who commented.
                    $name = getUserNameByEmail($p->getAuthorEmail(), $pdo);

                    // load the like_count.
                    $like_count = getLikeCount($p->getPostID(), $pdo);

                    $post_id =  $p->getPostId();
                    include "../src/template/post_content.html";

                    endforeach;
                ?>

            </div>

            <!-- End middle__post -->
            

        </div> <!-- end middle column -->


        <div class="content__right col-md-2">
        <!-- ********************** right: online contacts bar ********************** -->
            <div class="right__contacts">
                <?php
                //TODO: load online contacts/friends


                ?>
                <!-- 
                <a href="#"><img src="../rsrc/img/friends/cat1.png" alt="friends"></a>
                -->


                <a href="#" class="contacts__setting"><i class="fa fa-cog"></i></a>
            </div> <!-- ********************** end online contacts bar ********************** -->

        </div> <!-- end right column -->

    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>
<script src="../include/scripts/js/script.js"></script>
<script src="../include/scripts/js/jquery_functions.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
  
</body>
</html>


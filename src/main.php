<!-- author:    Melanie Lin
                Jia Sheng Ma 
-->
<?php
require_once("../include/functions.php");
session_start();
// TODO: use user data to populate main.php

if ($_SESSION['loggedin'] !== TRUE) {
   header("Location: index.php");
}
$user = $_SESSION['user'];
$info = $_SESSION['user_info'];
$pdo = connect();

// if a form is sent to self, handle it
if (isset($_POST) && (isset($_POST["workspace"]) || isset($_POST["education"]) || isset($_POST["current_city"]) ||
    isset($_POST["hometown"]) || isset($_POST["relationship"]) || isset($_POST["description"]))) {
// if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["workspace"]))
        $info->set_workspace($_POST["workspace"]);
    else if (isset($_POST["education"]))
        $info->set_education($_POST["education"]);
    else if (isset($_POST["current_city"]))
        $info->set_current_city($_POST["current_city"]);
    else if (isset($_POST["hometown"]))
        $info->set_hometown($_POST["hometown"]);
    else if (isset($_POST["relationship"]))
        $info->set_relationship($_POST["relationship"]);
    else if (isset($_POST["description"]))
        $info->set_description($_POST["description"]);
    save_info_to_db($user->get_email(), $info, $pdo);
}

if(isset($_POST) && isset($_POST['post_content']) && ("" != trim($_POST['post_content']))) {
    if(!savePostToDB($user->get_email(), $pdo, $_POST['post_content'])) {
        echo "Error occurred while saving posting <br>";
    }
    // prevent resubmission of POST
    unset($_POST);
    var_dump($_POST);
    header('Location:' . $_SERVER['PHP_SELF']);
}

if(isset($_POST) && isset($_POST['post_comment_content']) && ("" != trim($_POST['post_comment_content']))) {
    //FIXME: $user->get_email() <= not really, $user can be anyone
    if(!saveCommentToDB($user->get_email(), $_POST['post__id'], $pdo, $_POST['post_comment_content'])){
        echo "Error occurred while commenting <br>";
    }

    var_dump($_POST);

    unset($_POST);

    var_dump($_POST);
    header('Location:'.$_SERVER['PHP_SELF']);

}

// default profile picture
$profile_pic = "../rsrc/img/photos/default-profile.png";

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>
  <?php 
  echo $user->get_first_name() . " " . $user->get_last_name();
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
                        echo $user->get_first_name() . " " . $user->get_last_name();
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
			  			<ul class="icon-setting--dropdown">
		                    <li><a href="settings.php">Settings</a></li>
		                    <li><a href="logout.php">Log Out</a></li>
		                </ul>

			  		</li>
		  			
		  		</div>
		  		<!-- search bar -->
		  		<div class="col-md-4 col-sm-12">
	                <li class="navbar__form">
			  			<form class="navbar__search-form form-inline" role="search" action="search.php" method="GET">
			 				<!-- <div class="navbar__search-container form-group"> -->
			  					<input type="text" name="search" class="navbar__search-input form-control" placeholder="Search">
                                <!--TODO: send a GET request to search.php -->
                                  <!-- <a href=# class="linka"><i class="fa fa-search"></i></a> -->
                                <input type="submit" value="Search" class="fa fa-search">
				  			<!-- </div> -->
						</form>
					</li>
				</div>

		  	</ul> 
		</div>
    </nav>
    <!-- cover image section -->
    <div class="cover">
        <div class="cover__container">
            
            <?php 
            if(empty($user->get_cover_photo())) {
                    // set default profile picture
                    echo '<img src="../rsrc/img/cover/default-cover.jpg">';
                } else {
                    // load user cover picture
                    //TODO:
                    
                }
            ?>
            <div class="cover__profile-container">
                <?php
                // load user profile picture
                if(! empty($user->get_profile_picture())) {
                    //TODO: 
                    // $profile_pic = 
                }
                echo '<img src="'. $profile_pic . '" ';

                ?>
                alt="profile photo" class="cover__photo"/>
                <div class="cover__username">
                    <?php 
                    echo $user->get_first_name() . " " . $user->get_last_name();
                    ?>
	    		</div>
	    		<div class="cover__update-info cover__update-info--decor" id="update-info-btn" onclick="show_update_info_page()">update info</div>
	    		<div class="cover__view-at cover__update-info--decor">view activity</div>

	    	</div>

            <!-- update info page -->
            <div id="update-info-page" class="update-info__modal">
                  <!-- page content -->
                  <div class="modal__page">
                        <span onclick="close_update_info_page()" class="modal__page-close">&times;</span>

                        <p class="modal__page--titles">Describe who you are</p>
                <!-- describe who you are-->
                        <?php
                        if(!empty($info->get_description())) {
                            // foreach($info->get_workspace() as $workspace) {
                            echo '<p class="modal__page--add" onclick="show_modal_input0()">'. $info->get_description() .'</p>';
                            // }
                        } else {
                            echo '<p class="modal__page--add" onclick="show_modal_input0()"><i class="fa fa-pencil"></i></p>';
                        }
                        ?>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="modal__page--input0">
                            <input type="text" name="description" class="modal__page--text">
                            <button type="submit" class="btn btn-primary modal__page--btn">Save</button>
                            <button type="button"class="btn btn-secondary modal__page--btn" onclick="close_modal_input1()">Cancel</button>
                        </form>
                        <p class="modal__page--titles">Workspace</p>
                <!-- echo all workplaces and schools-->
                        <?php
                        if(!empty($info->get_workspace())) {
                            // foreach($info->get_workspace() as $workspace) {
                            echo '<p class="modal__page--add" onclick="show_modal_input1()">'. $info->get_workspace() .'</p>';
                            // }
                        } else {
                            echo '<p class="modal__page--add" onclick="show_modal_input1()">Add workspace</p>';
                        }
                        ?>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="modal__page--input1">
                            <input type="text" name="workspace" class="modal__page--text">
                            <button type="submit" name="input_save" class="btn btn-primary modal__page--btn">Save</button>
                            <button type="button"class="btn btn-secondary modal__page--btn" onclick="close_modal_input1()">Cancel</button>
                        </form>

                        <p class="modal__page--titles">Education</p>
                        <?php
                        if(!empty($info->get_education())) {
                            // foreach($info->get_education() as $education) {
                                echo '<p class="modal__page--add" onclick="show_modal_input2()">'. $info->get_education() .'</p>';
                            // }   
                        } else {
                            echo '<p class="modal__page--add" onclick="show_modal_input2()">Add education</p>';
                        }
                        ?>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="modal__page--input2">
                            <input type="text" name="education" class="modal__page--text">
                            <button type="submit" class="btn btn-primary modal__page--btn">Save</button>
                            <button type="button" class="btn btn-secondary modal__page--btn" onclick="close_modal_input2()">Cancel</button>
                        </form>
                <!-- echo current city, hometown, and relationship -->
                        <p class="modal__page--titles">Current City</p>
                        <?php
                        if(empty($info->get_current_city())) {
                            echo '<p class="modal__page--add" onclick="show_modal_input3()">Add current city</p>';
                        } else {
                            echo '<p class="modal__page--add" onclick="show_modal_input3()">' . $info->get_current_city() . '</p>';
                        }
                        ?>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="modal__page--input3">
                            <input type="text" name="current_city" class="modal__page--text">
                            <button type="submit" class="btn btn-primary modal__page--btn">Save</button>
                            <button type="button" class="btn btn-secondary modal__page--btn" onclick="close_modal_input3()">Cancel</button>
                        </form>
                        <p class="modal__page--titles">Hometown</p>
                        <?php
                        if(empty($info->get_hometown())) {
                            echo '<p class="modal__page--add" onclick="show_modal_input4()">Add hometown</p>';
                        } else {
                            echo '<p class="modal__page--add" onclick="show_modal_input4()">' . $info->get_hometown() . '</p>';
                        }
                        ?>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="modal__page--input4">
                            <input type="text" name="hometown" class="modal__page--text">
                            <button type="submit" class="btn btn-primary modal__page--btn">Save</button>
                            <button type="button" class="btn btn-secondary modal__page--btn" onclick="close_modal_input4()">Cancel</button>
                        </form>
                        <p class="modal__page--titles">Relationship</p>
                        <?php
                        if(empty($info->get_relationship())) {
                            echo '<p class="modal__page--add" onclick="show_modal_input5()">Add relationship</p>';
                        } else {
                            echo '<p class="modal__page--add" onclick="show_modal_input5()">' . $info->get_relationship() . '</p>';
                        }
                        ?>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="modal__page--input5">
                            <input type="text" name="relationship" class="modal__page--text">
                            <button type="submit" class="btn btn-primary modal__page--btn">Save</button>
                            <button type="button" class="btn btn-secondary modal__page--btn" onclick="close_modal_input5()">Cancel</button>
                        </form>
                        <p class="modal__page--titles">About Info</p>
                        <p class="modal__page--add">Edit Your About Info</p>
                  </div>
              <!-- </form> -->
            </div>
    </div>
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
                <button class="intro__update-btn--font intro__update-btn--bg" onclick="show_update_info_page()">update info</button>
            </div>

            <!-- ********************** left: photos ********************** -->
            <div class="left__photos">
                <a href=#><h2 class="content__title content__title--font">
                    <i class="fa fa-picture-o content__icon content__icon--bg" aria-hidden="true"></i>
                    <!-- TODO: redirect to a photo upload page -->
                    Photos
                </h2></a>

                <?php
                //TODO: load 3x3 user photos if there's any
                // prompt user to upload otherwise
                ?>

<!--                <div class="row photos__container">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/photos/p1.jpeg"></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/photos/p2.jpeg"></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/photos/p3.jpeg"></div>
                </div> -->
                <!-- <div class="row photos__container">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/photos/p4.jpeg"></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/photos/p5.png"></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/photos/p6.jpeg"></div>
                </div>
                <div class="row photos__container">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/photos/p7.jpeg"></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/photos/p8.jpeg"></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/photos/p9.jpeg"></div>
                </div> -->
            </div> <!-- ********************** end photos ********************** -->

            <!-- ********************** left: friends ********************** -->
            <div class="left__friends">
                <!-- TODO: redirect to user's friends -->
                <a href="friends.php"><h2 class="content__title content__title--font">
                    <i class="fa fa-user-plus content__icon content__icon--bg" aria-hidden="true"></i>
                    Friends
                </h2></a>
                
                <div class="row photos__container">

                    <?php
                    $friends = loadFriends($user->get_email(), $pdo);
                    $_SESSION['friends'] = $friends;
                    $counter = 0;
                    foreach($friends as $f) {
                        if($counter > 8) {
                            break;
                        }
                        //TODO: display profile picture instead
                        echo "<a href=#>" . getUserNameByEmail($f, $pdo) . "</a>";
                    }
                    ?>
                    <!-- <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/friends/cat11.jpeg"></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/friends/cat1.png"></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/friends/cat3.jpeg"></div> -->
                </div>
                <!-- <div class="row photos__container">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/friends/cat4.jpeg"></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/friends/cat5.jpeg"></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/friends/cat6.jpeg"></div>
                </div>
                <div class="row photos__container">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/friends/cat7.jpeg"></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/friends/cat8.jpeg"></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><img src="../rsrc/img/friends/cat9.jpeg"></div>
                </div> -->
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


                <form action="" method="POST" id="post_form">
                <textarea placeholder="What's on your mind?" rows="3" name="post_content" form="post_form"></textarea>
                <input type="submit" Value="Post">
                </form>
            </div> <!-- ********************** end panel ********************** -->

            <!-- ********************** middle: post ********************** -->
            <div class="middle__posts">
                <?php
                //load user's posts if there's any
                // if there's none, set up a prompt maybe?
                $posts = loadPosts($user->get_email(), $pdo);
                // var_dump($posts);
                foreach($posts as $p) {
                    // header: user pic, user name
                    echo '<div class="post__header">';
                    echo '<img src="' . $profile_pic . '" class="post__header__author-photo">';
                    echo '<p class="post__header__info info__author"><a class="">' 
                        . $user->get_first_name() . " " . $user->get_last_name() . '</a>';
                    if($p->getIsEdited()) {
                        echo " Edited";
                    }
                    echo '</p>';
                    
                    echo '<p class="post__header__info info__date">' 
                        . $p->getPostTime() // load post's time
                        . '</p></div>';

                    // content
                    echo '<div class="post__content"> <p class="post__content__p">';
                    echo $p->getContent() . "<br></p></div>";

                    $comments = load_comments($p->getPostID(), $pdo);



                    //comment content
                    foreach($comments as $c){
                        echo ' <div class="comment_content"> &nbsp&nbsp'. $c->getCommentContent()  . '------('. $c->getAuthor() .')----------' . $c->getCommentTime() . '</div>';


                    }

                    // footer/actions: like, comment, share

                    echo '<div class="post__actions">
                    <div class="actions--setting actions--decor"><i class="fa fa-thumbs-up"></i></div>
                    <div class="actions--setting actions--decor"><i class="fa fa-share"></i></div>
                    <div class="actions--setting actions--decor actions__comment"></div>
                    <div class="actions--setting actions--decor actions__comment">';
                          
                          
                    echo '
                    <form action="" method="POST" id="post_comment_form">
                        <input type="text" name="post_comment_content" placeholder="Write some comment"/>
                        <input type="hidden" name="post__id" value="'  . $p->getPostId()  . '" >
                        <button type="submit">
                            <i class="fa fa-comment"></i>
                        </button>
                    </form>';

                    echo'
                    </div>
                    </div> <br><br>';

                    // echo '<div class="post__actions">
                    // <div class="actions--setting actions--decor"><i class="fa fa-thumbs-up"></i></div>
                    // <div class="actions--setting actions--decor"><i class="fa fa-share"></i></div>
                    // <div class="actions--setting actions--decor actions__comment"></div>
                    // <div class="actions--setting actions--decor actions__comment"><i class="fa fa-comment"></i></div>
                    // </div> ';

                }
                //TODO: load comments, likes, shares
                //FIXME: when refreshing page, post should not be resent to db
                ?>

                <!-- <div class="post__header">
                    <img src="../rsrc/img/photos/p11.jpeg" class="post__header__author-photo">
                    <p class="post__header__info info__author"><a class="">Meow Meow</a> shared a link</p>
                    <p class="post__header__info info__date">Jan 14 at 14:17 PM via Instagram</p>
                </div>
                <div class="post__content">
                    <p class="post__content__p">meow meow, meow meow meow meow, meow meow meow meow meow meow, meow meow!!!! meow meow meow meow!</p>
                    <img src="../rsrc/img/posts/p2.jpeg" alt="post content" class="post__content__img" />
                </div>
                <div class="post__actions">
                    <div class="actions--setting actions--decor"><i class="fa fa-thumbs-up"></i></div>
                    <div class="actions--setting actions--decor"><i class="fa fa-share"></i></div>
                    <div class="actions--setting actions--decor actions__comment">1</div>
                    <div class="actions--setting actions--decor actions__comment"><i class="fa fa-comment"></i></div>
                </div> -->
                    <!-- ********************** end post ********************** -->

<!--            <div class="middle__posts">
                <div class="post__header">
                    <img src="../rsrc/img/photos/p11.jpeg" class="post__header__author-photo">
                    <p class="post__header__info info__author"><a class="">Meow Meow</a> shared a link</p>
                    <p class="post__header__info info__date">Jan 14 at 14:17 PM via Instagram</p>
                </div>
                <div class="post__content">
                    <p class="post__content__p">My kingdom</p>
                    <img src="../rsrc/img/posts/p3.jpeg" alt="post content" class="post__content__img" />
                </div>
                <div class="post__actions">
                    <div class="actions--setting actions--decor"><i class="fa fa-thumbs-up"></i></div>
                    <div class="actions--setting actions--decor"><i class="fa fa-share"></i></div>
                    <div class="actions--setting actions--decor actions__comment">1</div>
                    <div class="actions--setting actions--decor actions__comment"><i class="fa fa-comment"></i></div>
                </div>
            </div>

            <div class="middle__posts">
                <div class="post__header">
                    <img src="../rsrc/img/photos/p11.jpeg" class="post__header__author-photo">
                    <p class="post__header__info info__author"><a class="">Meow Meow</a> shared a link</p>
                    <p class="post__header__info info__date">Jan 14 at 14:17 PM via Instagram</p>
                </div>
                <div class="post__content">
                    <p class="post__content__p">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sollicitudin, mauris ut tincidunt elementum, lacus nisl egestas augue, quis porta arcu lacus congue orci. </p>
                    <img src="../rsrc/img/posts/p5.jpeg" alt="post content" class="post__content__img" />
                </div>
                <div class="post__actions">
                    <div class="actions--setting actions--decor"><i class="fa fa-thumbs-up"></i></div>
                    <div class="actions--setting actions--decor"><i class="fa fa-share"></i></div>
                    <div class="actions--setting actions--decor actions__comment">1</div>
                    <div class="actions--setting actions--decor actions__comment"><i class="fa fa-comment"></i></div>
                </div>
            </div> -->

        </div> <!-- end middle column -->


        <div class="content__right col-md-2">
        <!-- ********************** right: online contacts bar ********************** -->
            <div class="right__contacts">
                <?php
                //TODO: load online contacts/friends


                ?>
                <!-- <a href="#"><img src="../rsrc/img/friends/cat1.png" alt="friends"></a>
                <a href="#"><img src="../rsrc/img/friends/cat2.jpeg" alt="friends"></a>
                <a href="#"><img src="../rsrc/img/friends/cat3.jpeg" alt="friends"></a>
                <a href="#"><img src="../rsrc/img/friends/cat4.jpeg" alt="friends"></a>
                <a href="#"><img src="../rsrc/img/friends/cat5.jpeg" alt="friends"></a>
                <a href="#"><img src="../rsrc/img/friends/cat6.jpeg" alt="friends"></a>
                <a href="#"><img src="../rsrc/img/friends/cat7.jpeg" alt="friends"></a>
                <a href="#"><img src="../rsrc/img/friends/cat8.jpeg" alt="friends"></a>
                <a href="#"><img src="../rsrc/img/friends/cat9.jpeg" alt="friends"></a> -->


                <a href="#" class="contacts__setting"><i class="fa fa-cog"></i></a>
            </div> <!-- ********************** end online contacts bar ********************** -->

        </div> <!-- end right column -->

    </div>

</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
  <script src="../include/scripts/js/script.js"></script>
</body>
</html>

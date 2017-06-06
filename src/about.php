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
                                <input type="submit" value="Q" class="fa fa-search">
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
            <div class="about">
                <h2 class="about__title about__title--font">About</h2>
                    
            </div>

            <div class=""></div> <!-- WARNING: keep this line, need an extra child to hold css style -->
        </div> <!-- end left column -->

        <!-- ********************** middle: post panel ********************** -->
        <div class="content__middle col-md-6">
            <div class="middle__timeline">
                <ul class="row">
                    <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <a href="main.php">
                            <i class="fa fa-calendar-check-o timeline__icon"></i>
                            timeline
                        </a>
                    </li>

                    <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <a href="#" class="active">
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


              
        </div> <!-- ********************** end middle bar ********************** -->


    </div>

</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
  <script src="../include/scripts/js/script.js"></script>
</body>
</html>

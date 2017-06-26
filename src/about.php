<!-- author:    Melanie Lin
                Jia Sheng Ma 
-->
<?php
require_once("../include/functions.php");
require_once("../include/loads/load_images.php");

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
    <?php
                include("template/navigation.php");
                include("template/banner.php");
    ?>
    <div class="row content">

        <div class="content__left col-md-4">
            <!-- left side -->
            <nav class="about">
                <h2 class="about__title about__title--font">About</h2>
                <ul class="about__nav">
                    <li><a href="#page--timeline" id="link--overview" onclick="show_about_page(this.id)">Overview</a></li>
                    <li><a href="#page--timeline" id="link--work-edu" onclick="show_about_page(this.id)">Work and Education</a></li>
                    <li><a href="#page--timeline" id="link--places"   onclick="show_about_page(this.id)">Places You've Lived</a></li>
                    <li><a href="#page--timeline" id="link--contact"  onclick="show_about_page(this.id)">Contact and Basic Info</a></li>
                    <li><a href="#page--timeline" id="link--family"   onclick="show_about_page(this.id)">Family and Relationships</a></li>
                    <li><a href="#page--timeline" id="link--details"  onclick="show_about_page(this.id)">Details About You</a></li>
                    <li><a href="#page--timeline" id="link--events"   onclick="show_about_page(this.id)">Life Events</a></li>
                </ul>
            </nav>

            <div class=""></div> <!-- WARNING: keep this line, need an extra child to hold css style -->
        </div> <!-- end left column -->

        <!-- ********************** middle: post panel ********************** -->
        <div class="content__middle col-md-6">
            <div class="middle__timeline" id="page--timeline">
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
        <!-- ********************** Overview ********************** -->
        <div class="about__overview" id="page--overview">
            <ul>
                <li><a href="#page--work-edu" id="link--work-edu" onclick="show_about_page(this.id)"><span>+</span>Add a workplace</a></li>
                <li><a href="#page--work-edu" id="link--work-edu" onclick="show_about_page(this.id)"><span>+</span>Add a school</a></li>
                <li><a href="#page--places"   id="link--places"   onclick="show_about_page(this.id)"><span>+</span>Add your current city</a></li>
                <li><a href="#page--places"   id="link--places"   onclick="show_about_page(this.id)"><span>+</span>Add a your hometown</a></li>
                <li><a href="#page--family"   id="link--family"   onclick="show_about_page(this.id)"><span>+</span>Add a relationship</a></li>
            </ul>
        </div>
        <!-- ********************** End Overview ********************** -->

        <!-- ********************** Work and Education ********************** -->
        <div class="about__work-edu" id="page--work-edu">
            <ul>
                <li>work</li>
                <li><span>+</span>Add a workplace
                    <form>
                    </form>
                </li>
            </ul>
            <ul>
                <li>professional skills</li>
                <li><span>+</span>Add a professional skill</li>
            </ul>
            <ul>
                <li>college</li>
                <li><span>+</span>Add a college</li>
            </ul>
            <ul>
                <li>high school</li>
                <li><span>+</span>Add a high school</li>
            </ul>
        </div>
        
        <!-- ********************** End Work and Education ********************** -->

        <!-- ********************** Places You've Lived ********************** -->
        <div class="about__places" id="page--places">
            <ul>
                <li>current city and hometown</li>
                <li><span>+</span>Add your current city</li>
                <li><span>+</span>Add your hometown</li>
            </ul>
            <ul>
                <li>other places lived</li>
                <li><span>+</span>Add a place</li>
            </ul>
        </div>
        <!-- ********************** End Places You've Lived ********************** -->

        <!-- ********************** Contact and Basic Info ********************** -->
        <div class="about__contact" id="page--contact">
            <ul>
                <li>contact information</li>
                <li><span>+</span>Add a email</li>
                <li><span>+</span>Add a mobile phone</li>
                <li><span>+</span>Add your address</li>
                <li><span>+</span>Add a public key</li>
            </ul>
            <ul>
                <li>websites and social links</li>
                <li><span>+</span>Add a website</li>
                <li><span>+</span>Add a social link</li>
            </ul>
            <ul>
                <li>basic information</li>
                <li><span>+</span>Add a who you're interested in</li>
                <li><span>+</span>Add a language</li>
                <li><span>+</span>Add a your religious views</li>
                <li><span>+</span>Add a political views</li>
            </ul>
        </div>
        <!-- ********************** End Contact and Basic Info ********************** -->

        <!-- ********************** Family and Relationships ********************** -->
        <div class="about__family" id="page--family">
            <ul>
                <li>relationship</li>
                <li><span>+</span>Add your relationship status</li>
            </ul>
            <ul>
                <li>family members</li>
                <li><span>+</span>Add a family member</li>
            </ul>
        </div>
        <!-- ********************** End Family and Relationships ********************** -->

        <!-- ********************** Details About You ********************** -->
        <div class="about__details" id="page--details">
            <ul>
                <li>about you</li>
                <li><span>+</span>Write some details about yourself</li>
            </ul>
            <ul>
                <li>name pronunciation</li>
                <li><span>+</span>How do you pronounce your name?</li>
            </ul>
            <ul>
                <li>other names</li>
                <li><span>+</span>Add a nickname, a birth name...</li>
            </ul>
            <ul>
                <li>favorite quotes</li>
                <li><span>+</span>Add your favorite quotations</li>
            </ul>
        </div>
        <!-- ********************** End Details About You ********************** -->

        <!-- ********************** Life Events ********************** -->
        <div class="about__events" id="page--events">
            <ul>
                <li>life events</li>
                <li><span>+</span>Add a life event</li>
            </ul>
        </div>
        <!-- ********************** End Life Events ********************** -->
              
        </div> <!-- ********************** end middle bar ********************** -->


    </div>

</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
  <script src="../include/scripts/js/script.js"></script>
</body>
</html>

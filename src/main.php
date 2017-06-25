<!-- author:    Melanie Lin
Jia Sheng Ma 
-->
<?php
require_once("../include/functions.php");
require_once("../include/loads/load_images.php");
session_start();

if ($_SESSION['loggedin'] !== TRUE) {
    header("Location: index.php");
}
$user = $_SESSION['user'];
$info = $_SESSION['user_info'];
$pdo = connect();

// default profile picture
$profile_pic = load_profile($user);
$cover_pic = load_cover($user);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>
<?php echo $user->get_first_name() . " " . $user->get_last_name(); ?>
</title>
<link rel="stylesheet" href="../include/styles/css/style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

          <meta name="viewport" content="width=device-width, initial-scale=1">
      </head>
      <body>
        <div class="container-fluid">
            <!-- Navigation and Banner-->
            <?php
                include("template/navigation.html");
                include("template/banner.html");
            ?>
            <!-- End Navigation and Banner-->

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
            <button class="intro__update-btn--font intro__update-btn--bg" id="update-info-btn" onclick="show_update_info_page()">update info</button>
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

                    if($friends){
                        $counter = 0;
                        foreach($friends as $f) {
                            if($counter > 8) {
                                break;
                            }
                            //TODO: display profile picture instead
                            echo "<a href=\"NPC.php?user=". $f . "\">" . getUserNameByEmail($f, $pdo) . "</a>";
                            echo "&nbsp;";
                            $counter++;
                            
                        }
                    } else {
                        echo "Lonely person :(";
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
                        <textarea placeholder="What's on your mind?" rows="3" name="post_content" id="posting_area"></textarea>
                        <input type="submit" Value="Post" class="btn" id="posting_btn">
                    </form>
                </div> <!-- ********************** end panel ********************** -->

                <!-- ********************** middle: post ********************** -->

                <!-- Begin middle__post -->

                
                <?php
                $posts = loadPosts($user->get_email(), $pdo);
                foreach($posts as $p):
                    
                    // load all the comment of the current post.
                    $comments = load_comments($p->getPostID(), $pdo);

                    // load the like_count.
                    $like_count = getLikeCount($p->getPostID(), $pdo);
                    $post_id = $p->getPostID();
                    echo '<div class="middle__posts">';
                    include "../src/template/post_content.html";
                    
                    echo '</div>';
                    endforeach;
                ?>
                
                </div>
                <!-- End middle__post -->

                <div class="content__right col-md-2">
                    <!-- ********************** right: online contacts bar ********************** -->
                    <div class="right__contacts">
                        <?php
                //TODO: load online contacts/friends


                        ?>
                <!-- <a href="#"><img src="../rsrc/img/friends/cat1.png" alt="friends"></a>
                <a href="#"><img src="../rsrc/img/friends/cat2.jpeg" alt="friends"></a>
                <a href="#"><img src="../rsrc/img/friends/cat9.jpeg" alt="friends"></a> -->


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

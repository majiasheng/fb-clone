    <!-- cover image section -->
    <div class="cover">
        <div class="cover__container">
             <div class="cover--fill">
                <?php 
                    echo '<img id="cover_photo" src="'.$cover_pic.'" />';
                ?>
                <form method="POST" action="submit_cover.php" enctype="multipart/form-data"  class="cover__pic"> 
                    <!-- use a <a> tag to trigger the file input, since file input css cant be modified -->
                    <a href="#" onclick="document.getElementById('file_cover').click();return false;"><i class="fa fa-camera"></i>Add Cover Photo</a>
                    <input style="visibility:hidden;" type="file" name="cover_image" onchange="this.form.submit()" id="file_cover" data-input="false"/>
                </form>
             </div>
            <div class="cover__profile-container">
                <div class="img_wrapper">
                <?php
                    if(isset($_SESSION['error'])) {
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    }

                    // load user profile picture
                    echo '<img src="'. $profile_pic . '" alt="profile photo" />';
                ?>
                </div>

                <form method="POST" action="submit_profile_photo.php" enctype="multipart/form-data"> 
                    <!-- use a <a> tag to trigger the file input, since file input css cant be modified -->
                    <a href="#" onclick="document.getElementById('file_profile').click();return false;"><i class="fa fa-camera"></i>Add Photo</a>
                    <input style="visibility:hidden;" type="file" name="profile_image" onchange="this.form.submit()" id="file_profile" data-input="false"/>
                </form>

            
            <div class="cover__username">
                <?php 
                echo $user->get_first_name() . " " . $user->get_last_name();
                ?>
            </div>
            <div class="cover__act">
            <div class="cover__update-info cover__update-info--decor" id="update-info-btn" onclick="show_update_info_page()">update info</div>
            <div class="cover__view-at cover__update-info--decor">view activity</div>
            </div>
            </div> 

        <!-- update info page -->
        <?php
            include("modals/update_info_modal.php");
        ?>
        <!-- end update_info page -->
</div>
</div>
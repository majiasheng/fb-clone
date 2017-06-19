<?php

// load cover pic
function load_cover($user) {
    // load the largest(latest) num, and load accordingly
    $index = $user->get_num_cover();

    // get the latest cover image (by the largest number)
    if($index != 0 && file_exists(PATH_TO_USERS.$user->get_email().'/cover')) {
        $index = $user->get_num_cover() - 1;        
        return PATH_TO_USERS.$user->get_email().'/cover/cover_img'.$index;
    }
    else
        return DEFAULT_COVER;
}

// load profile photo
function load_profile($user) {
	if(file_exists(PATH_TO_USERS.$user->get_email().'/profile'))
        return PATH_TO_USERS.$user->get_email().'/profile/profile_img';
    else
        return DEFAULT_PROFILE;
}

function load_profile_email($email){
	if(file_exists(PATH_TO_USERS.$email.'/profile'))
        return PATH_TO_USERS.$email.'/profile/profile_img';
    else
        return DEFAULT_PROFILE;
}

?>

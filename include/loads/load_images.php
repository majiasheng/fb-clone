<?php

// load cover pic
function load_cover($user) {
    // if folder exists, meaning that the user has updated cover, update, else use default
    if(file_exists(PATH_TO_USERS.$user->get_email().'/cover'))
        return PATH_TO_USERS.$user->get_email().'/cover/cover_img';
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


?>

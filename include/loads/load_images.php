<?php

// load cover pic
function load_cover($user) {
    // if folder exists, meaning that the user has updated cover, update, else use default
    if(file_exists(PATH_SRC_TO_RSRC_IMG.$user->get_email().'/cover'))
        return PATH_SRC_TO_RSRC_IMG.$user->get_email().'/cover/cover_img';
    else
        return IMG_COVER;
}



?>

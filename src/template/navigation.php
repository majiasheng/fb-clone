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
                                    <?php echo $user->get_first_name() . " " . $user->get_last_name(); ?>
                                </a>
                            </li>

                            <li class="header__home"><a href="main.php">Home</a></li>
                        </div>
                        <!-- friends, messages, and alerts -->
                        <div class="col-md-2 col-sm-12 navbar__header">
                         <li class="header__friends header--icon-setting">
                             <a href="#">
                                 <i class="fa fa-user" onclick="show_friend_requests()"></i>
                             </a>
                             <!-- icon-dropdown is the basic, fr is detailed css -->
                             <ul id="friend-request--dropdown" class="icon-dropdown fr-dropdown">
                                 <?php
                                 // handle friend request
                                 if(isset($_POST['friend_request'])) {
                                     if('Accept' == $_POST['friend_request']) {
                                         acceptFriendRequest($_POST['sender'], $_POST['receiver'], $pdo);
                                         // redirect to self to prevent resubmission by refreshing
                                        $self = $_SERVER['REQUEST_URI'];
                                        header("Location: $self");
                                     } else if('Decline' == $_POST['friend_request']) {
                                         removeFriendRequest($_POST['sender'], $_POST['receiver'], $pdo);
                                         // redirect to self to prevent resubmission by refreshing
                                        $self = $_SERVER['REQUEST_URI'];
                                        header("Location: $self");
                                     } else {
                                         echo "Something went wrong..";
                                     }
                                     unset($_POST);
                                 }
                                 echo "<h5 class='text text-left'>Friend requests</h5>";
                                 // check if there's friend request 
                                 $friend_requests = loadFriendRequests($user->get_email(),$pdo);
                                 if(count($friend_requests)) {
                                     echo "<ul>";
                                     foreach($friend_requests as $fr) {
                                         echo "<li><p>".
                                                // get user profile pic
                                                '<img src="'. loadProfileByEmail($fr, $pdo) . '" >'
                                                // get username
                                             . "<a href='NPC.php?user=". $fr . "' target='_blank'>" . getUserNameByEmail($fr, $pdo) 
                                             . "</a> </p>";
                                         echo '<form action="" method="POST"> ' 
                                             . '<input type="hidden" name="sender" value="' 
                                             . $fr . '">'
                                             . '<input type="hidden" name="receiver" value="' 
                                             . $user->get_email() . '">'
                                             . '<input type="submit" name="friend_request" value="Accept">'
                                             . '&nbsp;'
                                             . '<input type="submit" name="friend_request" value="Decline">'
                                             . "</form>";
                                         echo "</li>";
                                     }
                                     echo "</ul>";
                                 } else {
                                     echo '<p class="dropdown__no-request">You have no friend request, go send some instead!</p>';
                                 }
                                 echo "<h5 class='text text-left'>People you may know</h5>";
                                    // TODO: display: "No result" if no suggestion, else display the suggestion
                                 ?>
                             </ul>
                         </li>
                         
                         <!-- message bubble -->
                         <li class="header__message header--icon-setting">
                             <a href="#">
                                 <i class="fa fa-comments">
                                     
                                 </i>
                             </a>
                         </li> <!-- end message bubble -->

                         <!-- notification bubble -->
                         <li class="header__alert header--icon-setting">
                             <a href="#">
                                 <i class="fa fa-globe"></i>
                             </a>
                         </li> <!-- end notification bubble -->
                     </div>

                     <!-- privacy and settings (with a dropdown menu)-->
                     <div class="col-md-1 col-sm-12">
                         <li class="header__privacy header--icon-setting">
                             <a href="#"><i class="fa fa-lock"></i></a>
                         </li>

                         <li class="header__setting header--icon-setting">
                             <a href="#">
                                 <i class="fa fa-caret-down" onclick="show_setting_menu()"></i>
                             </a>
                             <ul class="icon-dropdown" id="icon-setting--dropdown">
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
                    <input type="submit" value="Search" class="fa fa-search form__search-btn" >
                    <!-- </div> -->
                </form>
                </li>
            </div>

    </ul> 
</div>
</nav>
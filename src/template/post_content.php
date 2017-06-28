 <!-- setting button: delete, edit -->
 <div class="cog fa fa-cog">
        <ul class="cog__dropdown">
            <!-- edit -->
            <li><?php echo $post_id; ?> </li>
            <li class="cog__dropdown--edit">
                <!-- <form action="" method="POST" class="post_edit_form" > -->
                    <!-- <input type="hidden" name="post__id" class="in" value="<?php echo $post_id; ?>" /> -->
                    <!-- trigger a modal to edit -->
                    <!-- <a data-toggle="modal" data-target="#editModal">Edit Post</a> -->

                    <!-- TODO -->
                    <a onclick="toggle_edit(<?php echo $class_index ?>)" class="edit__trigger">Edit Post</a>
                <!-- </form> -->

            </li>

            <!-- delete -->
            <li class="cog__dropdown--del">
                <form action="" method="POST" class="post_delete_form">
                    <input type="hidden" name="post__id" value="<?php echo $post_id; ?>" />
                    <a href="javascript:void(0);" onclick="$(this).closest('form').submit()">Delete Post</a>
                </form>
            </li>
        </ul>
</div>

<div class="post__edit">
    <form action="" method="POST" id="post_edit_form_id" class="post_edit_form">
        <h6>Edit Post</h6>
        <textarea rows="3" style="width:100%" name="new_content" id="edit_posting_area"></textarea>
        <input type="hidden" name="post__id" value="<?php echo $post_id; ?>" />
        <input type="submit" Value="Save" class="btn">
    </form>
</div>

<div class="post__header">
    <!-- load user pic -->
    <img src="<?php echo loadProfileByEmail($p->getAuthorEmail(), $pdo) ?>" class="post__header__author-photo">
    

    <p class="post__header__info info__author">
        <a class="" href="../src/NPC.php?user=<?php echo $p->getAuthorEmail(); ?>">
            <?php 
            echo getUserNameByEmail($p->getAuthorEmail(),$pdo); 
            ?>
        </a>
    </p>

    <p class="post__header__info info__date"><?php echo $p->getPostTime() ?></p>
   

</div>
<div class="post__content">
    <p class="post__content__p" id="post_content"><?php echo $p->getContent() ?></p>
</div>

<hr>


<div class="post__actions">
    <!-- like -->
    <div class="actions--setting actions--decor">
        <a href="javascript:void(0);" class="thumb_up">
            <i class="fa fa-thumbs-up"> <?php echo getLikeCount($p->getPostId(), $pdo)["count(liked)"] ?></i>
        </a>
    </div>
    <!-- share -->
    <div class="actions--setting actions--decor">
        <a href="javascript:void(0);" class="share_content">
            <i class="fa fa-share"></i>
        </a>
    </div>

    <!-- comment -->
    <div class="actions--setting actions--decor actions__comment">
        <form action="" method="POST" class="post_comment_form">
            <input type="text" name="post_comment_content" placeholder="Write some comment" required="true" oninvalid="this.setCustomValidity('Say something ...')" 
            oninput="setCustomValidity('')" 
            />
            <input type="hidden" name="post__id" value="<?php echo $post_id; ?>" />
           
            <a href="javascript:void(0);" onclick="$(this).closest('form').submit()"><i class="fa fa-comment"></i></a>
                
        </form>
    </div>

</div>
<div class="comment__content" id="<?php echo 'post__' . $post_id . ''?>">
    <?php
    foreach ($comments as $c) {
        $pic = loadProfileByEmail($c->getAuthor(), $pdo);

        echo '
            <div class="comment__details post__header">  
                <img src="'. $pic .'" class="comment__pic ">
                <div class="commenter">
                    <p class="comment__header__info info__commentor info__author">
                        <a href="../src/NPC.php?user=';
                        echo $c->getAuthor() . '">' . getUserNameByEmail($c->getAuthor(), $pdo) . '</a></p>
                    <p class="comment__header__info info__date">'. $c->getCommentTime() .'</p>
                    <p class="comment__content__p">'. $c->getCommentContent() .'</p>

                    
                </div>

            </div>
        ';
    }
    ?>
</div>
<br><br>
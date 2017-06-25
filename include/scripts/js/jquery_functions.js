$(document).ready(function(){

	$(".show").on("click", function(){
	  $(".mask").addClass("active");
	});




	// click anywhere to close 	// DOES NOT WORK ON CHROME?!
    $(window).click(function() {
	  	closeDropdown();
	});

    // toggle cog buttons
    cogToggle();

	// ajax to delete a post
	$('.post_delete_form').submit(function(e) {
		deletePost($(this), e);
	});

	// update info page
	$('.update-info-form').submit(function(event){
		updateInfo(this, event);
	});
    

	$('#post_form').submit(function(e){

		e.preventDefault(); // Prevent Default Submission

		$.post('../src/submit_post.php', $(this).serialize() )
		.done(function(data){
			$('.middle__posts').fadeOut('fast', function(){
				$('.middle__posts').fadeIn('fast').html(data);
			});
			// temporarily using: 
			window.location.reload();
			$("#post_form")[0].reset();
		})
		.fail(function(){
			alert('Post submit Failed ...');
		});
	});

	$('#post_to_friend_form').submit(function(e){

		e.preventDefault(); // Prevent Default Submission

		$.post('../src/post_to_NPC.php', $(this).serialize() )
		.done(function(data){
			$('.middle__posts').fadeOut('fast', function(){
				$('.middle__posts').fadeIn('fast').html(data);
			});
			$("#post_to_friend_form")[0].reset();
		})
		.fail(function(){
			alert('Post submit Failed ...');
		});
	});


	// $('.post_comment_form').submit(function(e){

	$(document).on('submit', '.post_comment_form', function(e){

		e.preventDefault(); // Prevent Default Submission

		// get the post_id.
		var id = $(this).find("input[type=hidden]").val();
		var name = 'post__' + id;

		$.post('../src/submit_comment.php', $(this).serialize() )
		.done(function(data){
			// update the comments based on the post id.
			$('#' + name).fadeOut('fast', function(){
				$('#' + name).fadeIn('fast').html(data);
			});

			// temporarily using: 
			window.location.reload();
			// empty out the comment.
			$('.post_comment_form').trigger("reset");
		})
		.fail(function(){
			alert('Comment submit failed ...');
		});

		return false;

	});

	// $(document).on('submit', '#edit_post_form', function(e){

	// 	e.preventDefault(); // Prevent Default Submission

	// 	// get the post_id.
	// 	var id = $('input[class=in]').val();
	// 	var name = 'post__' + id;
	// 	alert(id);
	// 	// $.post('../src/submit_comment.php', $(this).serialize() )
	// 	// .done(function(data){
	// 	// 	// update the comments based on the post id.
	// 	// 	$('#' + name).fadeOut('fast', function(){
	// 	// 		$('#' + name).fadeIn('fast').html(data);
	// 	// 	});

	// 	// 	// temporarily using: 
	// 	// 	window.location.reload();
	// 	// 	// empty out the comment.
	// 	// 	$('.post_comment_form').trigger("reset");
	// 	// })
	// 	// .fail(function(){
	// 	// 	alert('Comment submit failed ...');
	// 	// });

	// 	return false;

	// });



	


	// $(".thumb_up").on("click", function(e){
	$(document).on('click', '.thumb_up', function(e){
	// $('.thumb_up').click(function(e){

		e.preventDefault();
		//get the post_id of the clicked like button.
		var post_id = $(this).parent().siblings(".actions__comment").children().find("input[type=hidden]").val();
		console.log(post_id);

		$.ajax({
			context: this,
            url: '../src/submit_like.php',
            type: "post",
            data: { 'post_id': post_id },
            success: function(data) {
                $(this).fadeOut('fast', function(){
					$(this).fadeIn('fast').html(data);
				});
            },
            fail: function(data){
            	alert("Failed to like");
            }

        });

		return false;

	});

	// $(document).on('click', '.modal_trigger', function(e){
	// // $('.thumb_up').click(function(e){

	// 	e.preventDefault();
	// 	// $('.post__content__p').addClass("display_none");
	// 	$(".edit-modal").show();
	// 	return false;

	// });



	$(document).on('click', '.share_content', function(e){
	// $('.share_content').click(function(e){
		e.preventDefault();
		//get the post_id of the clicked like button.
		var post_id = $(this).parent().siblings(".actions__comment").children().find("input[type=hidden]").val();
		console.log(post_id);

		$.ajax({
			context: this,
            url: '../src/submit_share_content.php',
            type: "post",
            data: { 'post_id': post_id },
            success: function(data) {
				alert("This post has been shared to your timeline.");
            },
            fail: function(data){
            	alert("Failed to like");
            }
        });
	});

	

	$(":file").filestyle({input:false});

});

/**
*	Toggle the cog (setting) button on a post
*/
function cogToggle() {
	// cog (setting button on posts) show and hide onclick
	$(".cog").click(function(){
		$(this).find(".cog__dropdown").toggle();
    });
}

/**
*	Delete a post from wall
* 	thisObj: $this      	
*	e: event
*/
function deletePost(thisObj, e) {
	e.preventDefault();
	var id = thisObj.find("input[type=hidden]").val();
	var name = 'post__' + id;

	$.post('../src/submit_post_deletion.php', thisObj.serialize())
	.done(function(data) {
		// alert(name);
		window.location.reload();

	}) .fail(function() {
		alert("Deletion Failed ...");
	});
}

/**
*	Edit a post 
* 	thisObj: $this      	
*	e: event
*/
function editPost(thisObj, e) {
	e.preventDefault();
	var id = thisObj.find("input[type=hidden]").val();
	var name = 'post__' + id;

	$.post('../src/submit_post_edit.php', thisObj.serialize())
	.done(function(data) {
		// alert(name);
		window.location.reload();

	}) .fail(function() {
		alert("Failed to edit post ...");
	});
}

/**
*	Use AJAX to send update-info-form to backend
*	thisObj: this (no $)
*	event: event
*/
function updateInfo(thisObj, event) {
	event.preventDefault(); // Prevent Default Submission

	// create an array to store all display fields
	var display_fields = ["description", "workplace", "education", "current_city", "hometown", "relationship"];
	// get the class index of which form is submitted, since all forms have the same name
	var index = $(".update-info-form").index(thisObj);
	// get the content
	var id = $(thisObj).find("input[type=hidden]").val();
	// store the form name
	var form_name = "update-info-form";

	$.post('../src/submit_info.php', $(thisObj).serialize() )
	.done(function(data){
		// update
		$('.' + form_name).fadeOut('fast', function(){
			$('#' + display_fields[index]).fadeIn('fast').html(data);
		});

		// empty out the input field.
		$('#' + form_name).trigger("reset");
	})
	.fail(function(){
		alert('Failed to save your information ...');
	});
}

function closeDropdown() {
	if (!event.target.matches('.cog')) {
  		$(".cog__dropdown").hide();
  	}
}



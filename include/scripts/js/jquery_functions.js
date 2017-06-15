$(document).ready(function(){

	$('#post_form').submit(function(e){

		e.preventDefault(); // Prevent Default Submission

		$.post('../src/submit_post.php', $(this).serialize() )
		.done(function(data){
			$('.middle__posts').fadeOut('fast', function(){
				$('.middle__posts').fadeIn('fast').html(data);
			});
			$("#post_form")[0].reset();
		})
		.fail(function(){
			alert('Post submit Failed ...');
		});
	});


	$('.post_comment_form').submit(function(e){

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

			// empty out the comment.
			$('.post_comment_form').trigger("reset");
		})
		.fail(function(){
			alert('Comment submit Failed ...');
		});

		return false;

	});



	$(".thumb_up").on("click", function(e){
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

	$(".share_content").on("click", function(e){
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

	// Update info page
	$('.update-info-form').submit(function(event){
		event.preventDefault(); // Prevent Default Submission

		// create an array to store all display fields
		var display_fields = ["description", "workplace", "education", "current_city", "hometown", "relationship"];
		// get the class index of which form is submitted, since all forms have the same name
		var index = $(".update-info-form").index(this);
		// get the content
		var id = $(this).find("input[type=hidden]").val();
		// store the form name
		var form_name = "update-info-form";

		$.post('../src/submit_info.php', $(this).serialize() )
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
	});

	$(":file").filestyle({input:false});

});
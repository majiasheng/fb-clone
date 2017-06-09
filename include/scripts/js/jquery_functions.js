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


	$('.post_comment_form').submit(function(event){

		event.preventDefault(); // Prevent Default Submission

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

	});


	$('.thumb_up').click(function(){
		
		// e.preventDefault();

		// $.post("../src/submit_like.php", $(this).serialize())
		// .done(function(data){
		// 	alert("dhone");
		// })
		// .fail(function(data){
		// 	alert("cool");
		// });

	});

});
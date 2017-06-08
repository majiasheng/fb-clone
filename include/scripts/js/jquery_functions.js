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


	$('#post_comment_form').submit(function(e){

		e.preventDefault(); // Prevent Default Submission

		$.post('../src/submit_comment.php', $(this).serialize() )
		.done(function(data){
			$('.middle__posts').fadeOut('fast', function(){
				$('.middle__posts').fadeIn('fast').html(data);
			});
			$("#post_comment_forms")[0].reset();
		})
		.fail(function(){
			alert('Comment submit Failed ...');
		});

	});

});
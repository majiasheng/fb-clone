$(document).ready(function(){
	// $("#posting_area").focus();

	var source = null;
	var self_name = null;

	$('#post_form').submit(function(e){

  		
		e.preventDefault(); // Prevent Default Submission

		// var data_array = $(this).serializeArray();
		// data_array.push({name: 'update_page', value: true});
		var content = $(this).find("#posting_area").val();


		$.post('../src/submit_post.php', $(this).serialize())
		.done(function(data){
			$('.middle__posts').fadeOut('fast', function(){
				$('.middle__posts').fadeIn('fast').html(data);
			});
			$("#post_form")[0].reset();
		})
		.fail(function(){
			alert('Post submit Failed ...');
		});


		if(source){
  			source.close();
  		}

	  	source = new EventSource('server_update_page.php');
	  	source.addEventListener('message', function(sse_listener){
		    
		    var retval = JSON.parse(sse_listener.data);

		    
		    var friends = retval.splice(0, retval.length - 1);
		    var self_name = retval[0];

		    // notifyFriends(content);

		    // reload friend's data.

		    




		   	source.close();
		},false);


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

			// empty out the comment.
			$('.post_comment_form').trigger("reset");
		})
		.fail(function(){
			alert('Comment submit Failed ...');
		});

		return false;

	});


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

	$('#test_sse').click(function(e){

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




function notifyFriends(content, self_name) {
  if (!Notification) {
    alert('Desktop notifications not available in your browser. Try Chrome or Firefox.'); 
    return;
  }

  if (Notification.permission !== "granted")
    Notification.requestPermission();
  else {
    var notification = new Notification('Notification title', {
      body: content,
    });

    notification.onclick = function () {
      window.open("http://google.com");      
    };
    
  }

}



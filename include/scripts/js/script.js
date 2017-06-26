/** 
	author: Melanie Lin 

**/
/* Drop-down Menu */
function show_setting_menu() {
	var dropdown = document.getElementById("icon-setting--dropdown");
	 if(dropdown.style.display == "block") { 
	    dropdown.style.display = "none";
	  }
	  else { 
	    dropdown.style.display = "block";
	  }
}
function show_friend_requests() {
    var dropdown = document.getElementById("friend-request--dropdown");
    if(dropdown.style.display == "block") { 
        dropdown.style.display = "none";
    }
    else { 
        dropdown.style.display = "block";
    }
}

// click anythere to close 
window.onclick = function(event) {
 	if (!event.target.matches('.fa-caret-down')) {
		var setting = document.getElementById("icon-setting--dropdown");
		if(setting.style.display == "block") { 
	    	setting.style.display = "none";
	  	}
  	}
  	if (!event.target.matches('.fa-user')) {
  		var fr = document.getElementById("friend-request--dropdown");
		if(fr.style.display == "block") { 
	    	fr.style.display = "none";
	  	}
  	}
  	if (!event.target.matches('.cog')) {
  		var fr = document.getElementsByClassName("cog__dropdown");
		if(fr.style.display == "block") { 
	    	fr.style.display = "none";
	  	}
  	}
}

/* Update Info Page */
function show_update_info_page() {
	var modal = document.getElementById('update-info-page');				// get the page
	modal.style.display = "block";
}
function close_update_info_page() {
	var modal = document.getElementById('update-info-page');
	modal.style.display = "none";
}

// TODO: use a:focus or jQuery addClass()/removeClass() instead
// update info page: click add button to input
function show_modal(clicked_id) {
	// obj: add button and its correponding input box
	
	var id_to_modal = {
						'description'	: 'description_form',
						'workplace'		: 'workplace_form',
						'education'		: 'education_form',
						'current_city'	: 'current_city_form',
						'hometown'		: 'hometown_form',
						'relationship'	: 'relationship_form',

						};
	if (id_to_modal.hasOwnProperty(clicked_id)) {
		document.getElementById(id_to_modal[clicked_id]).style.display = "block";
	}						
}

function close_modal(clicked_id) {	
	// obj: add button and its correponding input box
	var id_to_modal = {
						'description_close'	: 'description_form',
						'workplace_close'	: 'workplace_form',
						'education_close'	: 'education_form',
						'current_city_close': 'current_city_form',
						'hometown_close'	: 'hometown_form',
						'relationship_close': 'relationship_form',

						};
	if (id_to_modal.hasOwnProperty(clicked_id)) {
		document.getElementById(id_to_modal[clicked_id]).style.display = "none";
	}
}

// about page
function show_about_page(link_id) {
	// create an object with all ids and correponding pages
	var links_to_pages = {
							'link--overview': 'page--overview',
							'link--work-edu': 'page--work-edu',
							'link--places'	: 'page--places',
							'link--contact' : 'page--contact',
							'link--family'	: 'page--family',
							'link--events'	: 'page--events', 
							'link--details'	: 'page--details'
							};

	// set style of the clicked element
	document.getElementById(link_id).style.color = "black";
	document.getElementById(link_id).style.fontWeight = "500";
	document.getElementById(link_id).style.borderLeft = "2px solid black";
	document.getElementById(links_to_pages[link_id]).style.display = "block";
	
	// remove the clicked element from the object
	var page = links_to_pages[link_id];
	delete links_to_pages[link_id];

	// remove all elements' style
	for (var key in links_to_pages) {
		document.getElementById(key).style.color = "gray";
		document.getElementById(key).style.fontWeight = "400";
		document.getElementById(key).style.borderLeft = "none";
		document.getElementById(links_to_pages[key]).style.display = "none";
	}

	// add the removed element back to the obj
	links_to_pages[link_id] = page;
}

function toggle_edit() {
	// var cog = document.getElementsByClassName("post_edit_form");
	// if(cog.style.display == "block") { 
	// 	cog.style.display = "none";
	// } else { 
	// 	cog.style.display = "block";
	// }
}

window.onload = function setDataSource(){
	// if(!!window.EventSource){
	// 	var source = new EventSource("server_update_page.php");

	// 	source.addEventListener("message", function(e){
	// 		console.log(e);
	// 	}, false);

	// 	source.addEventListener("open", function(e){
	// 		console.log("OPEN");
	// 	}, false);

	// 	source.addEventListener("error", function(e){
	// 		console.log("ERROR");
	// 	}, false);
	// }else{
	// 	// browser not supported....
	// }
}



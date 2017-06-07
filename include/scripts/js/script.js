/** 
	author: Melanie Lin 

**/

/* Drop-down Menu */
function show_setting_menu() {
	var dropdown = document.getElementsByClassName("icon-setting--dropdown")[0];
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

		var dropdown = document.getElementsByClassName("icon-setting--dropdown")[0];
		if(dropdown.style.display == "block") { 
	    	dropdown.style.display = "none";
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
function show_modal(clicked_id) {
	document.getElementById(clicked_id).style.display = "block";
}
function close_modal(clicked_id) {
	document.getElementById(clicked_id).style.display = "none";
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

function choose_file() {
	document.getElementById('file_upload').click();
}


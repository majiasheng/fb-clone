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

window.onclick = function(event) {
 	if (!event.target.matches('.fa-caret-down')) {

		var dropdown = document.getElementsByClassName("icon-setting--dropdown")[0];
		if(dropdown.style.display == "block") { 
	    	dropdown.style.display = "none";
	  	}

  }
}

/* Update Info Page */
var modal = document.getElementById('update-info-page');				// get the page
var btn = document.getElementById("update-info-btn");					// button to open the page
var span = document.getElementsByClassName("modal__page-close")[0];		// the close button

// open update-info page onclide
btn.onclick = function() {
    modal.style.display = "block";
}
// close onclick
span.onclick = function() {
    modal.style.display = "none";
}

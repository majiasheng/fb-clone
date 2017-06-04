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
function show_update_info_page() {
	var modal = document.getElementById('update-info-page');				// get the page
	modal.style.display = "block";
}
function close_update_info_page() {
	var modal = document.getElementById('update-info-page');
	modal.style.display = "none";

}
// TODO: NO REPETITIVE CODE
function show_modal_input1() {
	var container = document.getElementById('modal__page--input1');
	container.style.display = "block";
}
function close_modal_input1() {
	var container = document.getElementById('modal__page--input1');
	container.style.display = "none";
}
function show_modal_input2() {
	var container = document.getElementById('modal__page--input2');
	container.style.display = "block";
}
function close_modal_input2() {
	var container = document.getElementById('modal__page--input2');
	container.style.display = "none";
}
function show_modal_input3() {
	var container = document.getElementById('modal__page--input3');
	container.style.display = "block";
}
function close_modal_input3() {
	var container = document.getElementById('modal__page--input3');
	container.style.display = "none";
}
function show_modal_input4() {
	var container = document.getElementById('modal__page--input4');
	container.style.display = "block";
}
function close_modal_input4() {
	var container = document.getElementById('modal__page--input4');
	container.style.display = "none";
}
function show_modal_input5() {
	var container = document.getElementById('modal__page--input5');
	container.style.display = "block";
}
function close_modal_input5() {
	var container = document.getElementById('modal__page--input5');
	container.style.display = "none";
}

function popout(){
	var comment = prompt("Enter your comment");

	var doc = document.getElementsByClassName("comment_content").innerHTML;
	console.log(doc);


	
	// if(comment != null){

	// 	// ajax to php
	// 	var xmlhttp =new XMLHttpRequest();
	// 	xmlhttp.onreadystatechagne = function(){
	// 		if(this.readyState = 4 && this.status == 2000){
	// 			document.getElement
	// 		}
	// 	}

	// }

}


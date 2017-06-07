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
function show_modal_input0() {
	var container = document.getElementById('modal__page--input0');
	container.style.display = "block";
}
function close_modal_input0() {
	var container = document.getElementById('modal__page--input0');
	container.style.display = "none";
}
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

// about page
function show_overview() {
	document.getElementById('page--overview').style.display = "block";
	document.getElementById('page--work-edu').style.display = "none";
	document.getElementById('page--places').style.display = "none";
	document.getElementById('page--contact').style.display = "none";
	document.getElementById('page--family').style.display = "none";
	document.getElementById('page--events').style.display = "none";
}
function show_work_edu() {
	document.getElementById('page--overview').style.display = "none";
	document.getElementById('page--work-edu').style.display = "block";
	document.getElementById('page--places').style.display = "none";
	document.getElementById('page--contact').style.display = "none";
	document.getElementById('page--family').style.display = "none";
	document.getElementById('page--details').style.display = "none";
	document.getElementById('page--events').style.display = "none";
}
function show_places() {
	document.getElementById('page--overview').style.display = "none";
	document.getElementById('page--work-edu').style.display = "none";
	document.getElementById('page--places').style.display = "block";
	document.getElementById('page--contact').style.display = "none";
	document.getElementById('page--family').style.display = "none";
	document.getElementById('page--details').style.display = "none";
	document.getElementById('page--events').style.display = "none";
}
function show_contact() {
	document.getElementById('page--overview').style.display = "none";
	document.getElementById('page--work-edu').style.display = "none";
	document.getElementById('page--places').style.display = "none";
	document.getElementById('page--contact').style.display = "block";
	document.getElementById('page--family').style.display = "none";
	document.getElementById('page--details').style.display = "none";
	document.getElementById('page--events').style.display = "none";
}
function show_family() {
	document.getElementById('page--overview').style.display = "none";
	document.getElementById('page--work-edu').style.display = "none";
	document.getElementById('page--places').style.display = "none";
	document.getElementById('page--contact').style.display = "none";
	document.getElementById('page--family').style.display = "block";
	document.getElementById('page--details').style.display = "none";
	document.getElementById('page--events').style.display = "none";
}
function show_details() {
	document.getElementById('page--overview').style.display = "none";
	document.getElementById('page--work-edu').style.display = "none";
	document.getElementById('page--places').style.display = "none";
	document.getElementById('page--contact').style.display = "none";
	document.getElementById('page--family').style.display = "none";
	document.getElementById('page--details').style.display = "block";
	document.getElementById('page--events').style.display = "none";
}
function show_events() {
	document.getElementById('page--overview').style.display = "none";
	document.getElementById('page--work-edu').style.display = "none";
	document.getElementById('page--places').style.display = "none";
	document.getElementById('page--contact').style.display = "none";
	document.getElementById('page--family').style.display = "none";
	document.getElementById('page--details').style.display = "none";
	document.getElementById('page--events').style.display = "block";
}



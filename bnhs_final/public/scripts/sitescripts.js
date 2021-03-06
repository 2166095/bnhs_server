replacePageTitle();
$( document ).ready(function() {
	$( ".se-pre-con" ).fadeOut("slow");


	$( "#clickme" ).click(function() {
		if ($( ".leftmenu" ).css('display') === 'none') {
			$( ".contentpage" ).css( "margin", "0 0 0 calc(18.229166666666664%)" );
			$( ".leftmenu" ).fadeToggle();
		} else{
			$( ".leftmenu" ).toggle();
			$( ".contentpage" ).css( "margin", "25px 0 25px 50px" );
		}  if ($( ".topbarleft" ).css('display') === 'none') {
			$( ".topbarright" ).css( "width", "81.77083333333334%" );
			$( ".topbarleft" ).fadeToggle();
		} else {
			$( ".topbarleft" ).toggle();
			$( ".topbarright" ).css( "width", "100%" );
		} 
	});

	$( ".dropdown-menu .dropdown-btn" ).click(function(e) {
		e.stopPropagation();
		$(".dropdown-menu-content").fadeToggle();
	});

	$( "html" ).click(function(e) {
		e.stopPropagation();
		var container = $(".dropdown-menu-content");

		//check if the clicked area is dropDown or not
		if (container.has(e.target).length === 0) {
			$('.dropdown-menu-content').fadeOut();
		}
	});

	$( ".enrollcontent .tabs" ).tabs({ active: 1 });
	$( ".studentContent .tabs, .classesContent .tabs" ).tabs();

	$( "#datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "-100:+0"
	});

	var datatable = $( "#stud-list, #adv-table-1, #adv-table-2, #parent-table-1, #stud-attendance-table" ).DataTable({
		dom: "lBfrtip",
		buttons: [
        	'excel','pdf','print'
    	],
		"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
	});

	var calendar = $('#calendar').fullCalendar({
		header:{
			left:'prev,next today',
			center:'title',
			right:'month,agendaWeek,agendaDay'
		},
		events: 'app/model/unstructured/load.php',
		selectHelper:true,
		height: 400	
	});

	$( '#faculty_home .contentpage .widget .studentContent .cont .filtStudTable' ).change(function() {
		var grade = $(this).val();
		var data = 'grade='+grade;
		
		$.ajax({
			type: 'POST',
			url: 'app/model/unstructured/get-stud-list.php',
			data: data,
			success: function(result) {
				datatable.clear().draw();
				datatable.rows.add($.parseJSON(result)); 
				datatable.columns.adjust().draw();
			}
		});
	});

	$( '.sidebar-menu li' ).has('li.active-menu').addClass('active');
});

function replacePageTitle() {
	$('title').empty();
	$('title').append($( '.leftmenu nav ul li.active-menu' ).text());
}

/*function checkPasswordLength() {
	var newpass = document.getElementByID('password');
	var current = document.getElementByID('currentpass');
	if(current == newpass){
		alert("Enter different password!");
		document.getElementByID('password').value = '';
		document.getElementByID('currentpass').value = '';
		document.getElementByID('retypePass').value = '';
	} 
*/
/*	var password = document.getElementByID('password').value;
	var retypePass = document.getElementByID('password').value;
	if(password)*/
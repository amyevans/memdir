<?php
// $members = findMembers();
?>
<div id="search">
	<form medthod="POST" action="" id="search-form">
		<input type="radio" name="by" value="city-company-radio" checked>&nbsp;City, Last Name and Company &nbsp;&nbsp;|&nbsp;&nbsp;
		<input type="radio" name="by" value="id-radio" >&nbsp;ID<br><br>
		<span id="require-id" style="display:none;">Please, complete this field.</span>
		<span id="require-city-company" style="display:none;">Please, complete at least one field.</span>
		<div class="div-city-company">
			City<br>
			<input type="text" id="city" name="city" autofocus="true"><br>
			Last Name
			<input type="text" id="lastname" name="lastname">
			Company
			<input type="text" id="company" name="company"><br>
		</div>			
		<div class="div-id" style="display:none;">
			ID<br>
			<input type="text" id="id" name="id"> 
		</div>
		<input type="submit" value="Continue">
	</form>
</div>
<div id="result"></div>

<script>

//--NUMBER OF RESULTS TO SHOW WITH "MORE"
var moreQty = 5;

var uri = 'http://naifa-texas.org';

function validateFields(){
	jQuery("#require-id").hide();
	jQuery("#require-city-company").hide();
	var selected = jQuery('input[name=by]:checked', '#search-form').val();
	var inputId = jQuery("#id").val();
	var inputCity = jQuery("#city").val();
	var inputCompany = jQuery("#company").val();
	var inputLastName = jQuery("#lastname").val();
	if (selected == 'id-radio') {
		if (inputId == '') {
			jQuery("#require-id").fadeIn();
			return false;
		}
		return true;
	}
	else{
		if (inputCity == '' && inputCompany == '' && inputLastName == '') {
			jQuery("#require-city-company").fadeIn();
			return false;
		}
		return true;
	}
}

jQuery(document).ready(function() {
	jQuery("input[name=by]").change(function() {
		jQuery("#require-id").hide();
		jQuery("#require-city-company").hide();
		var selected = jQuery('input[name=by]:checked', '#search-form').val();
		if (selected == 'id-radio') {
			jQuery(".div-city-company").hide();
			jQuery("#city").val('');
			jQuery("#company").val('');	
			jQuery("#lastname").val('');	
			jQuery(".div-id").fadeIn();
			jQuery("#id").focus();
		}
		else{
			jQuery(".div-id").hide();
			jQuery("#id").val('');
			jQuery(".div-city-company").fadeIn();
			jQuery("#city").focus();
		}

	});

	jQuery(document).on("submit", "#search-form", function (e) {
		e.preventDefault();
		if (validateFields()){
			var selected = jQuery('input[name=by]:checked', '#search-form').val();
			if (selected == 'id-radio'){
				jQuery.ajax({
					data: {id: jQuery("#id").val()},
					url: uri + '/wp-content/themes/dante/includes/findMembersTable.php',
					type: 'post',
					beforeSend: function () {
						jQuery("#result").html('Searching...');
					},
					success: function (response) {
						jQuery("#result").html(response);
					}
				});
			}
			else{
				jQuery.ajax({
					data: {city: jQuery("#city").val(), company: jQuery("#company").val(), lastname: jQuery("#lastname").val()},
					url: uri + '/wp-content/themes/dante/includes/findMembersTable.php',
					type: 'post',
					beforeSend: function () {
						jQuery("#result").html('Searching...');
					},
					success: function (response) {
						jQuery("#result").html(response);
					}
				});
			}
		}
	});
});

jQuery(document).on("click", "#more", function () {
	var i=1;
	jQuery(".hidden-tr").each(function () {
		if (i<(moreQty+1)) {
			jQuery(this).removeClass('hidden-tr');
			jQuery(this).fadeIn();
			if (!jQuery(".hidden-tr").length) {
				jQuery("#more").remove();
			}
		}
		else{
			return false;
		}
		i++;
	});
});

//--ID NUMBERS ONLY
jQuery(document).ready(function () {
	jQuery("#id").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: Ctrl+V
                (e.keyCode == 86 && e.ctrlKey === true) ||        
                        // Allow: home, end, left, right
                        (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                return;
            }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                	e.preventDefault();
                }
            });
});
</script>
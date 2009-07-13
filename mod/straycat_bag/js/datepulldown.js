/**
 * caculate unix timestamp from years,months and days pulldown
 * and put the result into the hidden field
 */
/**
 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
 * @copyright FireBloom Studio
 * @link http://firebloom.cc
 */
$(function(){
	showDatePulldown();
});

function showDatePulldown(){
	$('.datepulldown').show();
}

function process_date_input(field){
	var year_field = field.concat('_years');
	var month_field = field.concat('_months');
	var day_field = field.concat('_days');
	var hidden_field = field.concat('_hidden');
	
	var year = document.getElementById(year_field).value;
	var month = document.getElementById(month_field).value;
	var day = document.getElementById(day_field).value;
	
	var hidden = document.getElementById(hidden_field);
	hidden.value = Date.UTC(year,month-1,day)/1000;		
}

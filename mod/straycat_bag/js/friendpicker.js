/**
 * support wider use of friendpicker 
 */
/**
 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
 * @copyright FireBloom Studio
 * @link http://firebloom.cc
 */
$(function(){
	processSelect4Picker();
});
/**
 * when use friends picker for a select
 * hide it by default,toggle by a link
 * change select option when click user name or icon in picker
 */
function processSelect4Picker(){
	var select4picker = $('#select4picker');
	
	if(select4picker.is('select')){
		var friends_picker = $('.friends_picker');
		friends_picker.hide('fast');
		
		var toggle_picker = $('#toggle_picker');
		toggle_picker.show();
		toggle_picker.click(function(){
			friends_picker.toggle('fast');
			return false;
		});
		
		$('.friends_picker_checkbox').remove();
		$('.friends_picker_name,.friends_picker_icon').click(function(eventObject){
			var guid = this.id.split('-')[1];
			var select_opt_id = '#opt-'+guid;
			$(select_opt_id).attr('selected',true);
			return false;
		});
	}
}
<?php
	/**
	 * river view of updating user profile
	 * shows user's profile items
	 *
	 * @package ImprovedProfile
	 */
	/**
	 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	$performed_by = get_entity($vars['item']->subject_guid);
	$object = get_entity($vars['item']->object_guid);
	
	if ('user' == $performed_by->type && 'user' == $object->type) {
	
		$show_comment = TRUE;
	
		$name = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
		$body = '<p>'.sprintf(elgg_echo("profile:river:update"),$name).'</p>';
		
		$body .= "<a href=\"\" class=\"user_details_toggle\" onclick=\"$('#user_details_toggle-{$object->guid}').toggle();return false;\">".elgg_echo('toggle_details')."</a>";
		$body .= "<div id=\"user_details_toggle-{$object->guid}\" style=\"display:none\">";
		$body .= elgg_view('profile/details',array('entity'=>$object));
		$body .= "</div>";
		
		echo elgg_view('river/item/extra',
						array('performed_by' => $performed_by,
							'object' => $object,
							'body' => $body,
							'show_comment' => $show_comment,)
						);
	}
?>
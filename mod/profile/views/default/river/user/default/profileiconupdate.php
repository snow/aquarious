<?php

	$performed_by = get_entity($vars['item']->subject_guid); // $statement->getSubject();
	$object = get_entity($vars['item']->object_guid);
	$time = $vars['item']->posted;
	
	//$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$string = sprintf(elgg_echo("profile:river:iconupdate"),'');
	$string .= "<div class=\"river_content\">";
	//$string .= elgg_view("profile/icon",array('entity' => $performed_by, 'size' => 'small', 'override' => 'true'));
	$string .= elgg_view("profile/icon",array('entity' => $performed_by, 'size' => 'large', 'override' => 'true'));
	$string .= "</div>";
	
	//system_message($vars['item']->object_guid);
	
	echo elgg_view('river/item/extra',
					array('performed_by'=>$performed_by,
						'object'=>$object,
						'time'=>$time,
						'body'=>$string,
						'show_comment'=>TRUE)
					);
	
?>
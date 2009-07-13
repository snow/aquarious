<?php
	/**
	 * Show full content of blog in river
	 *
	 * @package ImprovedRiverDashboard
	 */
	/**
	 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */

	$performed_by = get_entity($vars['item']->subject_guid); // $statement->getSubject();
	$object = get_entity($vars['item']->object_guid);
	$url = $object->getURL();
	
	$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$summary .= elgg_echo("blog:river:create") . " <a href=\"" . $object->getURL() . "\">" . $object->title . "</a>";
	$toggle = "<div><a onclick=\"$('#blog_details-{$object->guid}').toggle();return false;\" class=\"river_item_toggle_details\" href=\"\">".elgg_echo('toggle_details').'</a></div>';
	$details = "<div id=\"blog_details-{$object->guid}\" class=\"blog_post\" style=\"display:none\">";
	$details .= "<h2>$object->title</h2>";
	$details .= elgg_view('output/longtext',array('value'=>$object->description));
	$details .= '</div>';	

	echo elgg_view('river/item/extra',
					array('performed_by'=>$performed_by,
						'object'=>$object,
						'body'=>$summary.$toggle.$details,
						'show_comment'=>TRUE)); 
?>
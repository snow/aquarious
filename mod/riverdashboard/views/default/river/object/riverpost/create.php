<?php
	/**
	 * improved the wire post view
	 *
	 * @package ElggTheWire
	 */
	/**
	 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	$performed_by = get_entity($vars['item']->subject_guid);
	$object = get_entity($vars['item']->object_guid);

	$body = '<div class="river_post">';	
	$body .= '<span class=\"post_content\">'.elgg_view('output/longtext',array('value'=>$object->description)).'</span>';	
	$body .= '</div>';
	
	echo elgg_view('river/item/extra',
					array('performed_by' => $performed_by,
						'object' => $object,
						'body' => $body,
						'show_comment' => TRUE,)
					);
?>
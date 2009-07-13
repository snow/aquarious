<?php
	/**
	 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */

	$performed_by = get_entity($vars['item']->subject_guid);
	$object = get_entity($vars['item']->object_guid);
	$url = $vars['url'];	
	$mime = $object->mimetype;	
	
	$summary .= '<a href="'.$performed_by->getURL().'">'.$performed_by->name.'</a>'.elgg_echo("image:river:created");
	
	$goto_full = "<a href=\"{$object->getURL()}\" target=\"_blank\" class=\"goto_full\" id=\"image_toggle-{$object->guid}\">".elgg_echo('river:image:goto_full')."</a>";
	
	$thumb = "<img src=\"{$url}mod/tidypics/thumbnail.php?file_guid={$object->guid}&size=small\" border=\"0\" alt=\"thumbnail\"/>";
	
	echo elgg_view('river/item/extra',
					array('performed_by'=>$performed_by,
						'object'=>$object,
						'body'=>$summary.' - '.$goto_full.'<br />'.$thumb,
						'show_comment'=>TRUE)
					);
	
?>
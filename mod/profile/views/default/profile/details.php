<?php
	/**
	 * Display profile items for a user 
	 *
	 * @package ImporvedProfile
	 */
	/**
	 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	global $CONFIG;
	$profile = $CONFIG->profile;
	$entity = $vars['entity'];

	if (is_array($profile) && sizeof($profile) > 0){
		$even_odd = null;		
		foreach ($profile as $category) {
			foreach ($category as $item) {
				if ( '' == $entity->{$item->title}) {
					unset($profile[$item->category][$item->title]);
				}else{
					$item->value = $entity->{$item->title};
				}
			}
		}
		unset($profile['personal']['description']);
		unset($item);
		$profile = trigger_plugin_hook('profile:detailsview:preprocess','user',$profile,$profile);
		
		$last_field_category = '';
		foreach ($profile as $category) {
			foreach ($category as $item) {
				
				$shortname = $item->title;
				$valtype = $item->valuetype;
				$value = $item->value;
				
				$curr_field_category = $item->category;
				/*
				 * display profile category title
				 */
				if ($curr_field_category != $last_field_category) {
					echo "<p class=\"profile_category_title\" id=\"profile:category:$curr_field_category\">".elgg_echo("profile:category:$curr_field_category")."</p>";
				}
				/*
				 * display profile item
				 */
				$even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even';
				echo "<p class=\"$even_odd\" id=\"profile:{$shortname}\"><b>".elgg_echo("profile:{$shortname}").": </b>";
				if ('profile_left' == get_context()) {
					echo '<br />';					
				}
				
				
				switch ($valtype) {
					default:
						echo elgg_view("output/{$valtype}",array('value' => $value));
					break;
					
					case 'pulldown':
						echo elgg_echo("profile:".$value);
					break;
					
					case 'date':
						if ('birthday' == $shortname && !$entity->show_birth_year) {
							$format = 'm-d';
						}else {
							$format = 'Y-m-d';
						}
						echo elgg_view("output/{$valtype}",array('value' => $value,'format' => $format));
					break;
				}
				echo '</p>';
				$last_field_category = $curr_field_category;
			}
		}
	}//if (is_array($profile) && sizeof($profile) > 0)
?>
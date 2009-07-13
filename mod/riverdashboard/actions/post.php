<?php
	/**
	 * Save a discuss post
	 *
	 * @package Event
	 */
	/**
	 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */

	//secure first
	gatekeeper();
	action_gatekeeper();
	
	// Get input data
	$body = get_input('river_post');
	$access_id = get_default_access();
	
	$forward_param['m'] = $body;
	
	if ($body){
		if (strlen($body) > 420 ) {
			register_error(elgg_echo('river:post:toolong'));
		}else{
			$post = new ElggObject();
			$post->subtype = 'riverpost';
			$post->owner_guid = get_loggedin_userid();
			$post->access_id = ACCESS_LOGGED_IN;
			$post->description = $body;
			$save = $post->save();
			
			if ($save) {
				add_to_river('river/object/riverpost/create','create',$_SESSION['user']->guid,$post->guid);		
				system_message(elgg_echo("river:post:posted"));
				$forward_param = '';
			} else {
				register_error(elgg_echo("river:post:failure"));
			}
		}		
	}else{
		register_error( sprintf(elgg_echo('DataFormatException:field_required'),elgg_echo('riverdashboard:post')) );
	}
		
	friendlyforward($forward_param);
	
?>
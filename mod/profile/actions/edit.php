<?php
/**
 * Modified edit action to fit ElggObject based profile config
 * and add plugin hook after got input and save
 *
 * @package ImprovedProfile
 */
/**
 * @author Snow.Hellsing <snow@g7life.com>
 * @copyright FireBloom Studio
 * @link http://firebloom.cc
 */
/**
 * Elgg profile plugin edit action
 * 
 * @package ElggProfile
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd <info@elgg.com>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 */

// Load configuration
global $CONFIG;

// Get profile fields
$input = array ();
$accesslevel = get_input ( 'accesslevel' );
if (! is_array ( $accesslevel ))
	$accesslevel = array ();
	/*
	 * MOD START by Snow
	 * to fit ElggObject based profile config
	 *
	 */
$profile = $CONFIG->profile;
try {
	foreach ( $profile as $category ) {
		foreach ( $category as $item ) {
			$shortname = $item->title;
			$valuetype = $item->valuetype;
			
			switch ($valuetype) {
				default :
					$input [$shortname] = get_input ( $shortname );
					break;
				
				case 'tags' :
					$input [$shortname] = string_to_tag_array_snowMod ( get_input ( $shortname ) );
					break;
			}
		}
	}
	//put this out of foreach for performence thoughts
	if (isset ( $profile ['basic'] ['birthday'] )) {
		$input ['show_birth_year'] = get_input ( 'show_birth_year' );
	}
	
	$input = trigger_plugin_hook ( 'profile:update:preprocess', 'user', $input, $input );
	
	/*
	 * MOD END by Snow
	 */
	// Save stuff if we can, and forward to the user's profile
	

	if ($user = page_owner ()) {
		$user = page_owner_entity ();
	} else {
		$user = $_SESSION ['user'];
		set_page_owner ( $user->getGUID () );
	}
	if ($user->canEdit ()) {
		
		// Save stuff
		if (sizeof ( $input ) > 0)
			foreach ( $input as $shortname => $value ) {
				
				//$user->$shortname = $value;
				remove_metadata ( $user->guid, $shortname );
				if (isset ( $accesslevel [$shortname] )) {
					$access_id = ( int ) $accesslevel [$shortname];
				} else {
					// this should never be executed since the access level should always be set
					$access_id = ACCESS_PRIVATE;
				}
				if (is_array ( $value )) {
					$i = 0;
					foreach ( $value as $interval ) {
						$i ++;
						if ($i == 1) {
							$multiple = false;
						} else {
							$multiple = true;
						}
						create_metadata ( $user->guid, $shortname, $interval, 'text', $user->guid, $access_id, $multiple );
					}
				} else {
					create_metadata ( $user->guid, $shortname, $value, 'text', $user->guid, $access_id );
				}
			
			}
			/*
			 * MOD START by Snow
			 *
			 */
		$input ['user'] = $user;
		trigger_plugin_hook ( 'profile:update:postprocess', 'user', $input );
		/*
			 * MOD END by Snow
			 */
		$user->save ();
		
		// Notify of profile update
		trigger_elgg_event ( 'profileupdate', $user->type, $user );
		
		//add to river
		add_to_river ( 'river/user/default/profileupdate', 'update', $user->guid, $user->guid );
		
		system_message ( elgg_echo ( "profile:saved" ) );
		
		// Forward to the user's profile
		forward ( $user->getUrl () );
	
	} else {
		// If we can't, display an error
		system_message ( elgg_echo ( "profile:cantedit" ) );
	}
} catch ( Exception $e ) {
	register_error ( elgg_echo('exception').'<br />'.$e->getMessage () );
	friendlyforward ();
}

?>
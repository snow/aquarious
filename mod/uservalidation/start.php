<?php
	/**
	 * User validation plugin.
	 * 
	 * @package pluginUserValidation
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Ralf Fuhrmann, Euskirchen, Germany
	 * @copyright 2008 Ralf Fuhrmann, Euskirchen, Germany
	 * @link http://mysnc.de/
	 */
	/**
	 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */

	// Init
	register_elgg_event_handler('init','system','uservalidation_init');
	register_elgg_event_handler('pagesetup','system','uservalidation_pagesetup');
	 
	function uservalidation_init()
	{

		global $CONFIG;

		// Get the validation-method
		$validationMethod = get_plugin_setting('validationMethod', 'uservalidation');
		if (empty($validationMethod))
			$validationMethod = 'bymail';
		// Get the sendAdminMail option and save it to CONFIG for later use
		$sendAdminMail = get_plugin_setting('sendAdminMail', 'uservalidation');
		$CONFIG->uservalidation->sendAdminMail = $sendAdminMail ? $sendAdminMail : 'no';
		// Get the autoDeleteDays
		$autoDeleteDays = intval(get_plugin_setting('autoDeleteDays', 'uservalidation'));
		
		// Default action to confirm the registration
		register_action('uservalidation/confirm', true, $CONFIG->pluginspath . 'uservalidation/actions/confirm.php');
		// Register event-handler depending on the validation-method
		//register_elgg_event_handler('user', 'validate', 'uservalidation_' . $validationMethod . '_validation');
		// Register hook listening to new users.
		register_elgg_event_handler('validate', 'user', 'uservalidation_validate_user_handler');
		
		// Do this stuff only if an admin logged in
		if (isadminloggedin()) {
		
			if ($validationMethod != 'none') {
			
				register_page_handler('uservalidation','uservalidation_page_handler');
				register_action('uservalidation/deleteuser', true, $CONFIG->pluginspath . 'uservalidation/actions/deleteuser.php');
				register_action('uservalidation/activateuser', true, $CONFIG->pluginspath . 'uservalidation/actions/activateuser.php');

			}
			
			if ($autoDeleteDays > 0) {
		
				// Make a Query to get all disabled users to delete
				$deleteTime = (time() - ($autoDeleteDays * 24 * 60 * 60));
				$result = get_data("SELECT guid FROM {$CONFIG->dbprefix}entities WHERE type = 'user' AND enabled = 'no' AND time_created < {$deleteTime}");
				if (count($result)) {
			
					$access_status = access_get_show_hidden_status();
					access_show_hidden_entities(true);
					foreach ($result AS $result_guid) {
				
						$user = get_entity(intval($result_guid->guid));
						if (($user) && ($user instanceof ElggUser)) {
					
							if (empty($user->prev_last_action)) {
						
								$message .= "{$user->name} ({$user->username})\n"; 
								$user->delete();
							
							}
						}	
					}
					access_show_hidden_entities($access_status);
					if (!empty($message)) {
				
						@notify_user($CONFIG->site->guid, $CONFIG->site->guid, elgg_echo('uservalidation:autodelete:subject', $CONFIG->site->language), sprintf(elgg_echo('uservalidation:autodelete:body', $CONFIG->site->language), $message), NULL, 'email');
					
					}
				}
			}//if ($autoDeleteDays > 0)
		}
	}

	
	/**
	 * Uservalidation pagesetup.
	 *
	 */
	function uservalidation_pagesetup()
	{
	
		if (get_context() == 'admin' && isadminloggedin()) {
		
			global $CONFIG;
			add_submenu_item(elgg_echo('uservalidation:pendingusers'), $CONFIG->wwwroot . 'pg/uservalidation/', 'v');
			
		}
		
	}

	/**
	 * Uservalidation page_handler.
	 *
	 * @param array $page Array of page elements, forwarded by the page handling mechanism
	 */
	function uservalidation_page_handler($page) 
	{
		
		global $CONFIG;
		include($CONFIG->pluginspath . 'uservalidation/index.php'); 
		
	}
	
	/**
	 * call validate method depends on config
	 */
	function uservalidation_validate_user_handler($event, $object_type, $object) {
		if (($object) && ($object instanceof ElggUser)){
			
			$validationMethod = get_plugin_setting('validationMethod', 'uservalidation');
			
			switch ($validationMethod) {
				default:
					uservalidation_bymail_validation($object);
				break;
				
				case 'byadmin':
					uservalidation_byadmin_validation($object);
				break;
				
				case 'none':
					uservalidation_none_validation($object);
				break;
			}
		}
	}
	/**
	 * Request no validation.
	 */
	function uservalidation_none_validation($object)
	{
		global $CONFIG;		
		
		if ($CONFIG->uservalidation->sendAdminMail == 'every') {
		
			@notify_user($CONFIG->site->guid, $CONFIG->site->guid, sprintf(elgg_echo('uservalidation:adminmail:subject', $CONFIG->site->language), $object->name), sprintf(elgg_echo('uservalidation:adminmail:body', $CONFIG->site->language), $object->name, $object->username), NULL, 'email');
			
		}
		forward($CONFIG->site->url . 'action/uservalidation/confirm?m=none&u=' . $object->guid . '&c=' . uservalidation_generate_code($object->guid, $object->email));		
	}
	
	/**
	 * Request admin validation.
	 */
	function uservalidation_byadmin_validation($object)
	{
		global $CONFIG;		
		$result = notify_user($object->guid, $CONFIG->site->guid, sprintf(elgg_echo('uservalidation:admin:validate:subject'), $object->name), sprintf(elgg_echo('uservalidation:admin:validate:body'), $object->name, $CONFIG->site->name), NULL, 'email');
		if ($result) {
		
			if ($CONFIG->uservalidation->sendAdminMail == 'every' || $CONFIG->uservalidation->sendAdminMail == 'adminonly') {
			
				@notify_user($CONFIG->site->guid, $CONFIG->site->guid, sprintf(elgg_echo('uservalidation:adminmail:subject', $CONFIG->site->language), $object->name), sprintf(elgg_echo('uservalidation:adminmail:body', $CONFIG->site->language), $object->name, $object->username), NULL, 'email');
				
			}
			system_message(elgg_echo('uservalidation:admin:registerok'));
			
		}
	}

	/**
	 * Request user validation email.
	 * Send email out to the address and request a confirmation.
	 *
	 * @param int $user_guid The user
	 * @return mixed
	 */
	function uservalidation_bymail_validation($object)
	{
		global $CONFIG;
		// Work out validate link
		$link = $CONFIG->site->url . "action/uservalidation/confirm?u=$object->guid&c=" . uservalidation_generate_code($object->guid, $object->email);

		// Send validation email		
		$result = notify_user($object->guid, $CONFIG->site->guid, sprintf(elgg_echo('uservalidation:email:validate:subject'), $object->username), sprintf(elgg_echo('uservalidation:email:validate:body'), $object->name, $link), NULL, 'email');
		if ($result)
			system_message(elgg_echo('uservalidation:email:registerok'));
			
		return $result;
	}
	

	/**
	 * Generate an email activation code.
	 *
	 * @param int $user_guid The guid of the user
	 * @param string $email_address Email address 
	 * @return string
	 */
	function uservalidation_generate_code($user_guid, $email_address)
	{
		global $CONFIG;
		
		return md5($user_guid . $email_address . $CONFIG->site->url); // Note I bind to site URL, this is important on multisite!
	}
	
	/**
	 * Validate a user
	 *
	 * @param unknown_type $user_guid
	 * @param unknown_type $code
	 * @return unknown
	 */
	function uservalidationbyemail_validate_email($user_guid, $code)
	{
		$user = get_entity($user_guid);
		
		$valid = ($code == uservalidation_generate_code($user_guid, $user->email));
		if ($valid)
			set_user_validation_status($user_guid, true, 'email');
		
		return $valid;
	}
?>
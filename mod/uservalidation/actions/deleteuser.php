<?php
	/**
	 * User validation plugin.
	 * Delete User.
	 * 
	 * @package pluginUserValidation
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Ralf Fuhrmann, Euskirchen, Germany
	 * @copyright 2008 Ralf Fuhrmann, Euskirchen, Germany
	 * @link http://mysnc.de/
	 */

	// Admins only
	admin_gatekeeper();
	// Show hidden (not enabled) entities
	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(true);
	// Get the user guid
	$user = get_entity(intval(get_input('u')));
	
	// Check, if it is an ElggUser Object
	if (($user) && ($user instanceof ElggUser)) {
	
		// Delete User, if possible
		if ($user->delete()) {
		
			system_message(elgg_echo('admin:user:delete:yes'));
			
		} else {
		
			register_error(elgg_echo('admin:user:delete:no'));
			
		}
	} else {
	
		register_error(elgg_echo('admin:user:delete:no'));
		
	}
	// Reset the hidden-status	
	access_show_hidden_entities($access_status);
	// Forward to current page
	forward($_SERVER['HTTP_REFERER']);
	exit;
	
?>
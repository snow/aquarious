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

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
	// Admins only
	admin_gatekeeper();
	set_context('admin');
	set_page_owner($_SESSION['guid']);
	
	// Make a Query to get all disabled users
	$users = get_entities_from_metadata('validated',0,'user');	
	foreach ($users as $user) {
		$body .= elgg_view('uservalidation/pendingusers', array('entity' => $user));
	}	
	
	$title = elgg_view_title(elgg_echo('uservalidation:pendingusers'));
	// Draw the page
	page_draw(elgg_echo('uservalidation:pendingusers'), elgg_view_layout('two_column_left_sidebar', '', $title . $body));
	
?>

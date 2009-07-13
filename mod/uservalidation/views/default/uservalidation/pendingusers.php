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
	global $CONFIG;
	
	$friendlytime = friendly_time($vars['entity']->time_created);
	$applicant = $vars['entity'];
	
	if (empty($applicant->prev_last_action)) {
	
		$status = elgg_echo('uservalidation:waiting');
		
	} else {
	
		$status = elgg_echo('uservalidation:banned');
		
	}
	$info .= "<p>{$status}: {$applicant->name} ({$applicant->username})</p>\n";
	$info .= '<div>'.$applicant->verify_info.'</div>';
	$info .= "</p>\n";
	
	$info .= "<p class=\"owner_timestamp\">" . elgg_echo('uservalidation:registered') . ": {$friendlytime}</p>";
	$info .= "<p style=\"text-align:right;\">\n";	
	$info .= elgg_view('output/confirmlink',
						array('href' => "{$CONFIG->site->url}action/uservalidation/deleteuser?u={$applicant->guid}",
							'text' => elgg_echo('uservalidation:delete'),
							'confirm' => elgg_echo('question:areyousure')));
	$info .= '&nbsp;&nbsp;';
	$info .= "<a href=\"{$CONFIG->site->url}action/uservalidation/activateuser?u={$applicant->guid}\">" . elgg_echo('uservalidation:activate') . "</a>";
	$info .= "</p>\n";
	$icon = elgg_view("graphics/icon", array('size' => 'small', 'entity' => $applicant));
	echo elgg_view_listing($icon, $info);
		
?>
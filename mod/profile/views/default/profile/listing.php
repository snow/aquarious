<?php

	/**
	 * Elgg user display (small)
	 * 
	 * @package ElggProfile
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 * 
	 * @uses $vars['entity'] The user entity
	 */

		$icon = elgg_view(
				"profile/icon", array(
										'entity' => $vars['entity'],
										'size' => 'small',
									  )
			);
			
		$banned = $vars['entity']->isBanned();
	
		// Simple XFN
		$rel = "";
		if (page_owner() == $vars['entity']->guid)
			$rel = 'me';
		else if (check_entity_relationship(page_owner(), 'friend', $vars['entity']->guid))
			$rel = 'friend';
		
		if (!$banned) {
			$info .= "<p><b><a href=\"" . $vars['entity']->getUrl() . "\" rel=\"$rel\">" . $vars['entity']->name . "</a></b></p>";
			//create a view that a status plugin could extend - in the default case, this is the wire
	 		$info .= elgg_view("profile/status", array("entity" => $vars['entity']));

			$profession = $vars['entity']->profession;
			if ($profession) {
				$info .= '<p>' . elgg_echo("profile:profession") . ": $profession</p>";
			}
		}
		else
		{
			$info .= "<p><b><strike>";
			if (isadminloggedin())
				$info .= "<a href=\"" . $vars['entity']->getUrl() . "\">";
			$info .= $vars['entity']->name;
			if (isadminloggedin())
				$info .= "</a>";
			$info .= "</strike></b></p>";
		
			//$info .= "<p class=\"owner_timestamp\">" . elgg_echo('profile:banned') . "</p>";
			
		}
		
		/*
		 * MOD START by Snow
		 * add details toggle
		 */
		$info .= "<a href=\"\" class=\"user_details_toggle\" onclick=\"$('#user_details_toggle-{$vars['entity']->guid}').toggle();return false;\">".elgg_echo('toggle_details')."</a>";
		$info .= "<div id=\"user_details_toggle-{$vars['entity']->guid}\" style=\"display:none\">";
		$info .= elgg_view('profile/details',$vars);
		$info .= "</div>";
		/*
		 * MOD END by Snow
		 */ 
		
		echo elgg_view_listing($icon, $info);
			
?>
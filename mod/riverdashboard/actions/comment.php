<?php

	/**
	 * Elgg add comment action
	 * 
	 * @package Elgg
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider <curverider.co.uk>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */
	/**
	 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */

	// Make sure we're logged in; forward to the front page if not
		gatekeeper();
		action_gatekeeper();
		
	// Get input
		$entity_guid = (int) get_input('entity_guid');
		$comment_text = get_input('generic_comment');
		
		try {
			$entity = get_entity($entity_guid);
			if (!$entity) {
				throw new Exception(elgg_echo("generic_comment:notfound"));
			}
			if ( !$comment_text ) {
				throw new Exception(elgg_echo('generic_comment:empty'));
			}
			if ( strlen($comment_text)>140 ) {
				throw new Exception(elgg_echo('river:post:toolong'));
			}
			
			if ($entity->annotate('generic_comment',$comment_text,$entity->access_id, $_SESSION['guid'])) {
					
				if ($entity->owner_guid != $_SESSION['user']->getGUID())
				notify_user($entity->owner_guid, $_SESSION['user']->getGUID(), elgg_echo('generic_comment:email:subject'), 
					sprintf(
								elgg_echo('generic_comment:email:body'),
								$entity->title,
								$_SESSION['user']->name,
								$comment_text,
								$entity->getURL(),
								$_SESSION['user']->name,
								$_SESSION['user']->getURL()
							)
				); 
				
				system_message(elgg_echo("generic_comment:posted"));
				
			} else {
				throw new Exception(elgg_echo("generic_comment:failure"));
			}
			
		}catch (Exception $e){
			register_error($e->getMessage());
		}

		friendlyforward();
?>
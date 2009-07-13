<?php
	/**
	 * list random users on this site
	 *
	 * @package ElggMembers
	 */
	/**
	 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	/**
	 * list random members
	 *
	 * @param int $li the num of site members
	 */
	function list_random_users($limit = 5){
		global $CONFIG;

		$users = get_random_users($limit);

		$regen_link = "<a id=\"regen_link\" href=\"{$CONFIG->site->url}mod/members/index.php?filter=random\">".elgg_echo('members:random:regenerate').'</a>';

		return elgg_view_entity_list($users).$regen_link;
	}
	/**
	 *
	 */
	function get_random_users($limit = 5){
		global $CONFIG;

		$users = array();
		$members = get_number_users();
		$try_limit = 2*$members;
		$tried_times = 0;
		while (1){
			//get random row from the users_entity table
			$rand = rand(0,$members-1);
			$result = get_data_row("SELECT guid from {$CONFIG->dbprefix}users_entity limit $rand,1");
			//let's get the lucky puppy
			$guid = $result->guid;
			$user = get_entity($guid);
			//we met u twice?
			$dupee = FALSE;
			foreach ($users as $got) {
				if ($user->guid == $got->guid) {
					$dupee = TRUE;
					break;
				}
			}
			//see if her/him can get the nominate
			if (!$dupee && !random_exception($user)) {
				$users[] = $user;
			}
			//even if god hates u,make u can only get a same random FOREVER,I'll get u out of here
			$tried_times++;
			if (sizeof($users) >= $limit || $tried_times >= $try_limit) {
				break;
			}
		}

		return $users;
	}
	/**
	 * exception
	 */
	function random_exception($user){
		$exception = FALSE;
		if ($user->guid == $_SESSION['guid']//I don't want to meet myself
			|| check_entity_relationship($_SESSION['guid'],'friend',$user->guid)//I don't want to meet those guys again,get me some lovely girls
			) {
			$exception = TRUE;
		}
		/*
		 * trigger a hook let others add their logic
		 */
		return trigger_plugin_hook('members:random:exception','user',$user,$exception);
	}
?>
<?php
	/**
	 * 
	 *
	 * @package
	 */
	/**
	 * @author Snow.Hellsing <snow@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	require_once '../../../engine/start.php';
	
	gatekeeper();
	
	$guid = (int) get_input('guid');
	
	$msg = get_entity($guid);
	$msg->readYet = 1;
?>
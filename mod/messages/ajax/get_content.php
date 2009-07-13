<?php 
	/**
	 * TODO bio
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
	
	try {
		$msg = get_entity($guid);
		if (!$msg) {
			throw new Exception(elgg_echo('messages:notfound').$guid.$msg->subtype);
		}
		echo elgg_view('output/longtext',array('value'=>$msg->description));
	}catch (Exception $e){
		echo  $e->getMessage();
	}
	
?>
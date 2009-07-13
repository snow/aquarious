<?php
	/*
	 * Snow.Hellsing's function lib and something else
	 *
	 * @package straycat_bag
	 */
	/**
	 * @author Snow.Hellsing <snow@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */

	register_elgg_event_handler("init","system","straycat_bag_init");
	register_elgg_event_handler('init','system','straycat_bag_preloader',1);

	function straycat_bag_init() {		
		require_once(dirname(__FILE__).'/functions.php');
		require_once(dirname(__FILE__).'/exceptions.php');
		extend_view('css','straycat_bag/css');
		extend_view('page_elements/elgg_topbar','straycat_bag/preload',0);
	}   
	
	function straycat_bag_preloader(){
		extend_view('loadjs','straycat_bag/loadjs');
	}
?>
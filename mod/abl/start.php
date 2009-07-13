<?php
	/**
	 * the special business logic of a site will write in this plugin as hook handlers
	 *
	 * @package pyb_business_logic
	 * @author snow@firebloom.cc
	 * @copyright FireBloom Studio 2009
	 * @link http://firebloom.cc
	 */
	/**
	 * init this plugin in a high priviority to ensure when other plugin triggers a plugin hook
	 * pyb_business_logic have registered a handler
	 */
	register_elgg_event_handler("init","system","abl_init",300);
	register_action("aquarius/register",true,dirname(__FILE__)."/actions/register.php");
	
	function abl_init() {
		extend_view('css','abl/css');
	}
?>
<?php
	/**
	 * Improved Profile plugin
	 * uses an ElggObject based configure way
	 * added pulldown type to fields
	 * added datepulldown input
	 *
	 * @package ImprovedProfile
	 */
	/**
	 * @author Snow.Hellsing <snow@g7life.com>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	/**
	 * Elgg profile plugin
	 *
	 * @package ElggProfile
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

	/**
	 * Profile init function; sets up the profile functions
	 *
	 */
		function profile_init() {

			// Get config
				global $CONFIG;

			// Register a URL handler for users - this means that profile_url()
			// will dictate the URL for all ElggUser objects
				register_entity_url_handler('profile_url','user','all');

			// Metadata on users needs to be independent
				register_metadata_as_independent('user');

				elgg_view_register_simplecache('icon/user/default/tiny');
				elgg_view_register_simplecache('icon/user/default/topbar');
				elgg_view_register_simplecache('icon/user/default/small');
				elgg_view_register_simplecache('icon/user/default/medium');
				elgg_view_register_simplecache('icon/user/default/large');
				elgg_view_register_simplecache('icon/user/default/master');

			// For now, we'll hard code the profile items as follows:
			// TODO make this user configurable
				/*$CONFIG->profile = array(

					// Language short codes must be of the form "profile:key"
					// where key is the array key below
					'description' => 'longtext',
					'briefdescription' => 'text',
					'location' => 'tags',
					'interests' => 'tags',
					'skills' => 'tags',
					'contactemail' => 'email',
					'phone' => 'text',
					'mobile' => 'text',
					'website' => 'url',

				);*/
				require_once(dirname(__FILE__).'/profileitem.php');
				require_once(dirname(__FILE__).'/data_validations.php');
				require_once(dirname(__FILE__).'/profile_conf.php');
				require_once(dirname(__FILE__).'/hook_handlers.php');

			// Register a page handler, so we can have nice URLs
				register_page_handler('profile','profile_page_handler');
				/*
				 * MOD START by Snow
				 * Adieu,defaultprofile edit
				 *
				 * ORIGIN START
				 * register_page_handler('defaultprofile','profileedit_page_handler');
				 * ORIGIN END
				 * MOD END by Snow
				 */
				register_page_handler('icon','profile_icon_handler');
				register_page_handler('iconjs','profile_iconjs_handler');

			// Add Javascript reference to the page header
				extend_view('metatags','profile/metatags');
				extend_view('css','profile/css');
				extend_view('js/initialise_elgg','profile/javascript');
				if (get_context() == "profile")
				    extend_view('canvas_header/submenu','profile/submenu');

			//add submenu options
				if (get_context() == "profile") {
					add_submenu_item(elgg_echo('profile:editdetails'), $CONFIG->wwwroot . "mod/profile/edit.php");
					add_submenu_item(elgg_echo('profile:editicon'), $CONFIG->wwwroot . "mod/profile/editicon.php");
				}

			// Extend context menu with admin links
			if (isadminloggedin())
			{
	   			 extend_view('profile/menu/links','profile/menu/adminwrapper',10000);
			}
			
			// Now override icons
			register_plugin_hook('entity:icon:url', 'user', 'profile_usericon_hook');
			register_plugin_hook('profile:update:preprocess','user','profile_update_preprocess');
		}
	/**
	 * This function loads a set of default fields into the profile, then triggers a hook letting other plugins to edit
	 * add and delete fields.
	 *
	 * Note: This is a secondary system:init call and is run at a super low priority to guarantee that it is called after all
	 * other plugins have initialised.
	 */
		function profile_fields_setup()
		{
			global $CONFIG;
			/*
			 * just call get_pyb_profile_config()
			 * so we don't need to know how the config was built
			 */
			$CONFIG->profile = trigger_plugin_hook('profile:conf', 'profile', NULL, get_profile_conf());
			/*
			 * MOD START by Snow
			 * Adieu,profile default edit
			 *
			 * ORIGIN START
			 * $n = 0;
			$loaded_defaults = array();
			while ($translation = get_plugin_setting("admin_defined_profile_$n", 'profile'))
			{
				// Add a translation
				add_translation(get_current_language(), array("profile:admin_defined_profile_$n" => $translation));

				// Detect type
				$type = get_plugin_setting("admin_defined_profile_type_$n", 'profile');
				if (!$type) $type = 'text';

				// Set array
				$loaded_defaults["admin_defined_profile_$n"] = $type;

				$n++;
			}
			if (count($loaded_defaults)) {
				$CONFIG->profile_using_custom = true;
				$profile_defaults = $loaded_defaults;
			}
			 * ORIGIN END
			 */
			/*
			 * MOD END by Snow
			 */		
		}
	/**
	 * Profile page handler
	 *
	 * @param array $page Array of page elements, forwarded by the page handling mechanism
	 */
		function profile_page_handler($page) {

			global $CONFIG;

			// The username should be the file we're getting
			if (isset($page[0])) {
				set_input('username',$page[0]);
			}
			// Include the standard profile index
			include($CONFIG->pluginspath . "profile/index.php");

		}
		
	/**
	 * Profile edit page handler
	 *
	 * @param array $page Array of page elements, forwarded by the page handling mechanism
	 */
	/*
	 * MOD START by Snow
	 * Adieu,profile default edit
	 *
	 * ORIGIN START
	 * function profileedit_page_handler($page) {

			global $CONFIG;

			// The username should be the file we're getting
			if (isset($page[0])) {
				switch ($page[0])
				{
					case 'edit' :
					default: include($CONFIG->pluginspath . "profile/defaultprofile.php");
				}
			}

		}
	 * ORIGIN END
	 */
	/*
	 * MOD END by Snow
	 */ 
		
		
	/**
	 * Pagesetup function
	 *
	 */
	/*
	 * MOD START by Snow
	 * Adieu,profile default edit
	 *
	 * ORIGIN START
	 * function profile_pagesetup()
		{
			if (get_context() == 'admin' && isadminloggedin()) {
				global $CONFIG;
				add_submenu_item(elgg_echo('profile:edit:default'), $CONFIG->wwwroot . 'pg/defaultprofile/edit/');
			}
		}
	 * ORIGIN END
	 */
	/*
	 * MOD END by Snow
	 */

	/**
	 * Profile icon page handler
	 *
	 * @param array $page Array of page elements, forwarded by the page handling mechanism
	 */
		function profile_icon_handler($page) {

			global $CONFIG;

			// The username should be the file we're getting
			if (isset($page[0])) {
				set_input('username',$page[0]);
			}
			if (isset($page[1])) {
				set_input('size',$page[1]);
			}
			// Include the standard profile index
			include($CONFIG->pluginspath . "profile/icon.php");

		}

	/**
	 * Icon JS
	 */
		function profile_iconjs_handler($page) {

			global $CONFIG;

			include($CONFIG->pluginspath . "profile/javascript.php");

		}

	/**
	 * Profile URL generator for $user->getUrl();
	 *
	 * @param ElggUser $user
	 * @return string User URL
	 */
		function profile_url($user) {
			global $CONFIG;
			return $CONFIG->wwwroot . "pg/profile/" . $user->username;
		}
		
	/**
	 * This hooks into the getIcon API and provides nice user icons for users where possible.
	 *
	 * @param unknown_type $hook
	 * @param unknown_type $entity_type
	 * @param unknown_type $returnvalue
	 * @param unknown_type $params
	 * @return unknown
	 */
		function profile_usericon_hook($hook, $entity_type, $returnvalue, $params)
		{
			global $CONFIG;
			
			if ((!$returnvalue) && ($hook == 'entity:icon:url') && ($params['entity'] instanceof ElggUser))
			{
				
				$entity = $params['entity'];
				$type = $entity->type;
				$subtype = get_subtype_from_id($entity->subtype);
				$viewtype = $params['viewtype'];
				$size = $params['size'];
				$username = $entity->username;

				if ($icontime = $entity->icontime) {
					$icontime = "{$icontime}";
				} else {
					$icontime = "default";
				}

				if ($entity->isBanned()) {
					return elgg_view('icon/user/default/'.$size);
				}
				
				$filehandler = new ElggFile();
				$filehandler->owner_guid = $entity->getGUID();
				$filehandler->setFilename("profile/" . $username . $size . ".jpg");
				
				if ($filehandler->exists()) {
					//$url = $CONFIG->url . "pg/icon/$username/$size/$icontime.jpg";
					return $CONFIG->wwwroot . 'mod/profile/icondirect.php?lastcache='.$icontime.'&username='.$entity->username.'&size='.$size;
				}
			}
		}
	// Make sure the profile initialisation function is called on initialisation
		register_elgg_event_handler('init','system','profile_init',1);
		register_elgg_event_handler('init','system','profile_fields_setup', 10000); // Ensure this runs after other plugins
		
		/*
		 * MOD START by Snow
		 * diable default profile fields setup
		 *
		 * ORIGIN START
		 * register_elgg_event_handler('pagesetup','system','profile_pagesetup');
		 * ORIGIN END
		 */
		/*
		 * MOD END by Snow
		 */
		register_elgg_event_handler('profileupdate','all','object_notifications');

	// Register actions
		global $CONFIG;
		register_action("profile/edit",false,$CONFIG->pluginspath . "profile/actions/edit.php");
		register_action("profile/iconupload",false,$CONFIG->pluginspath . "profile/actions/iconupload.php");
		register_action("profile/cropicon",false,$CONFIG->pluginspath . "profile/actions/cropicon.php");
		/*
		 * MOD START by Snow
		 * Adieu,editdefault
		 *
		 * ORIGIN START
		 * register_action("profile/editdefault",false,$CONFIG->pluginspath . "profile/actions/editdefault.php", true);
		register_action("profile/editdefault/delete",false,$CONFIG->pluginspath . "profile/actions/deletedefaultprofileitem.php", true);
		register_action("profile/editdefault/reset",false,$CONFIG->pluginspath . "profile/actions/resetdefaultprofile.php", true);
		 * ORIGIN END
		 * MOD END by Snow
		 */

	// Define widgets for use in this context
		use_widgets('profile');

?>
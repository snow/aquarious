<?php
	/**
	 * Load js into head
	 *
	 * @package StrayCatBag
	 */
	/**
	 * @author Snow.Hellsing <snow@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
?>
<script type="text/javascript">
	if($('.datepulldown')){
		loadJS(site_url + 'mod/straycat_bag/js/datepulldown.js');
	}

	if($('.friends_picker')){
		loadJS(site_url + 'mod/straycat_bag/js/friendpicker.js');
	}
</script>
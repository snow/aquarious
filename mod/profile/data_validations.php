<?php
	/**
	 * functions for data validations
	 * which contains shortname,type,category and options(for pulldown) of a profile item.
	 *
	 * @package ImprovedProfile
	 */
	/**
	 * @author Snow.Hellsing <snow@g7life.com>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	/**
	 * determain if given string is a url
	 * 
	 * @param string $url
	 * @return bool
	 */	
	function is_url($url){
		$pattern = '/[^a-zA-Z0-9\:\/\.]/';
		return !preg_match($pattern,$url);
	}	
	/**
	 * determine if given string is a email addr
	 * 
	 * @param string $address
	 * @return bool
	 *
	function is_email_address_snowMod($address){
		//one and only one @ in a validate addr
		if ( 1 == substr_count($address,'@') ){
			//after @,there are at least one '.'
			$pos_of_at = strpos($address, '@');
			$pos_of_first_dot = strpos($address, '.', $pos_of_at);
			if ($pos_of_first_dot) {
				//after @domain. ,there are top domain,which has at least two digits
				$top_domain_len = strlen($address) - $pos_of_first_dot - 1;
				if ( $top_domain_len >= 2 ) {
					return TRUE;
				}
			}				
		}		
		return FALSE;
	}
	/**
	 * is this meta value own by some other in this site?
	 *
	 * @param $meta_name fieldname
	 * @parma $meta_value fieldvalue
	 * @return bool true if the someone else had this meta value
	 */
	function is_meta_value_exsits($meta_name, $meta_value) {
		global $is_admin;
		$is_her_or_him_really_admin = $is_admin;
		$is_admin = TRUE;
		$result = find_metadata($meta_name, $meta_value);
		$is_admin = $is_her_or_him_really_admin;
		if ($result) {
			if ( sizeof($result) > 1 ) {
				throw new ConfigurationException(elgg_echo('ConfigurationException:invalid_profile_config'));
			}
			if ( page_owner() ) {
				return $result[0]->entity_guid != page_owner();
			}else{
				return $result[0]->entity_guid != $_SESSION['guid'];
			}
			
		}else {
			return FALSE;
		}
	}	
?>
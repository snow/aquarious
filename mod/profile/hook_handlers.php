<?php
	function profile_update_preprocess($hook, $entity_type, $returnvalue, $params) {
		/*
		 * format check
		 */
		if ( !empty($params['website']) && !is_url($params['website'])) {
			throw new DataFormatException(sprintf(elgg_echo('DataFormatException:invalid_input_format'),elgg_echo('profile:website')));
		}
		if ( !empty($params['email']) && !is_email_address_snowMod($params['email'])) {
			throw new DataFormatException(elgg_echo('registration:emailnotvalid'));
		}
		/*
		 * check if in input qq,mobile,website is unique in this site
	 	 * or own by the user her/him self
		 */
		global $CONFIG;
		foreach ($CONFIG->profile as $category){
			foreach ($category as $item) {
				if ( $item->isRequired && empty($params[$item->title]) ){
					throw new DataFormatException( sprintf(elgg_echo("DataFormatException:field_required"),elgg_echo("profile:{$item->title}")) );;
				}
				
				if ( !empty($params[$item->title]) && $item->isUnique && is_meta_value_exsits($item->title,$params[$item->title])) {
					throw new BusinessLogicException( sprintf(elgg_echo("BusinessLogicException:unique_meta_duple"),elgg_echo("profile:{$item->title}")) );
				}
			}
		}
		return $params;
	}
?>
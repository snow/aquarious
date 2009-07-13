<?php
	/**
	 * This file define ProfileItem class
	 * which contains shortname,type,category and options(for pulldown) of a profile item.
	 *
	 * @package ElggProfile
	 */
	/**
	 * @author Snow.Hellsing <snow@g7life.com>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */

	/**
	 * make profilefield object
	 *
	 * @param string $fieldname
	 * @parma string $fieldtype
	 * @parma string $category
	 * @parma bool $isUnique
	 * @parma array $options
	 */
	function ProfileItem($title,$valuetype,$category,$isUnique = FALSE,$options = '',$isRequired = FALSE){
		//first check if necessary param is empty
		if ('' == $title
			|| '' == $valuetype
			|| '' == $category) {
			return FALSE;
		}

		$item = new ElggObject();
		$item->subtype = 'profileitem';
		$item->title = $title;
		$item->valuetype = $valuetype;
		$item->category = $category;
		$item->isUnique = $isUnique;
		$item->options = $options;
		$item->isRequired = $isRequired;
		return $item;
	}
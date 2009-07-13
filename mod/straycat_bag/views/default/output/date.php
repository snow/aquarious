<?php
	/**
	 * add format param
	 *
	 * @package ImprovedProfile
	 */

	/**
	 * Date
	 * Displays a properly formatted date
	 * 
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 * 
	 * @uses $vars['value'] A UNIX epoch timestamp
	 * @uses $vars['format'] format string for date()
	 * 
	 */
	$format = isset($vars['format'])?$vars['format']:'Y-m-d';

    if ($vars['value'] > 86400) {
        echo date($format,$vars['value']);
    }
?>
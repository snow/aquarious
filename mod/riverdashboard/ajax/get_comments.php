<?php
	/**
	 * return comments for ajax request
	 *
	 * @package ImprovedRiverDashboard
	 */
	/**
	 * @author Snow.Hellsing <snow@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	$guid = get_input('guid');
	$offset = get_input('offset');
	$limit = get_input('limit');
	$more_div_id = get_input('more_div_id');
	
	$comments = get_annotations($guid, "", "", 'generic_comment', "", "", $limit, $offset);
	
	$html = '';
	if (is_array($comments) && sizeof($comments) > 0) {
		foreach($comments as $comment) {
			$html .= elgg_view_annotation($comment, "", false);
		}
	}
	$response = array('more_div_id' => $more_div_id,
					'html' => $html);
	
	echo json_encode($response);
?>
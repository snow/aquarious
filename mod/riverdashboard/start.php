<?php

	/**
	 * Elgg river dashboard plugin
	 * Improved by Snow.Hellsing
	 * 
	 * @package ElggRiverDash
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */

	register_elgg_event_handler('init','system','riverdashboard_init',666);
		
	// Register actions
	global $CONFIG;
	register_action("riverdashboard/add",false,$CONFIG->pluginspath . "riverdashboard/actions/add.php");
	register_action("riverdashboard/delete",false,$CONFIG->pluginspath . "riverdashboard/actions/delete.php");
	register_action("riverdashboard/comment",false,$CONFIG->pluginspath . "riverdashboard/actions/comment.php");
	register_action("riverdashboard/post",false,$CONFIG->pluginspath . "riverdashboard/actions/post.php");

	function riverdashboard_init() {
	
		global $CONFIG;
		
		define('comment_limit',5);
		
		// Register and optionally replace the dashboard
		if (get_plugin_setting('useasdashboard', 'riverdashboard') == 'yes') {
			register_page_handler('dashboard','riverdashboard_page_handler');
		} else {
			// Activity main menu
			if (isloggedin())
			{
				add_menu(elgg_echo('activity'), $CONFIG->wwwroot . "mod/riverdashboard/");
			}
		}
	
		// Page handler
		register_page_handler('riverdashboard','riverdashboard_page_handler');
		
		extend_view('css','riverdashboard/css');
		
		add_widget_type('river_widget',elgg_echo('river:widget:title'), elgg_echo('river:widget:description'));			
	}
	
	/**
	 * Page handler for riverdash
	 *
	 * @param unknown_type $page
	 */
	function riverdashboard_page_handler($page)
	{
		global $CONFIG;
		
		switch ($page[0]) {
			default:
				@include(dirname(__FILE__) . "/index.php");
			break;
			
			case 'get_comments':
				@include_once 'ajax/get_comments.php';
			break;
			
			case 'add_comment':
				@include_once 'ajax/add_comment.php';
			break;
		}
	}
	
	function riverdashboard_dashboard() {
		
		include(dirname(__FILE__) . '/index.php');
		
	}

	function getRiverItemComments($guid){
		$offset = 0;
		$limit = 10;
		$first_cnt = 3;
		$latest_cnt = 2;
		$html = '';
		
		$count = count_annotations($guid, "", "", 'generic_comment');
		if ( 5 >= $count) {
			$comments = get_annotations($guid, "", "", 'generic_comment', "", "", $limit, $offset);
			
			if (is_array($comments) && sizeof($comments) > 0) {
				foreach($comments as $comment) {
					$html .= elgg_view_annotation($comment, "", false);
				}
			}
		}else{
			$first_comments = get_annotations($guid, "", "", 'generic_comment', "", "", $first_cnt, $offset);
			foreach($first_comments as $comment) {
				$html .= elgg_view_annotation($comment, "", false);
			}
			
			$left_comment_cnt = $count - $first_cnt - $latest_cnt;
			
			$show_more_cnt = ($left_comment_cnt > $limit)?$limit:$left_comment_cnt;
			
			$show_more_text = sprintf(elgg_echo('riverdashboard:show_more_comments'),$show_more_cnt);
			
			$offset = $first_cnt;
			$html .= '<div class="generic_comment">'
				.'<span class="offset js_meta">'.$offset.'</span>'
				.'<span class="limit js_meta">'.$limit.'</span>'
				.'<span class="left js_meta">'.$left_comment_cnt.'</span>'
				.'<a class="show_more_comments" href="">'.$show_more_text.'</a>'
				.'</div>';
			
			$latest_comments = get_annotations($guid, "", "", 'generic_comment', "", "", $latest_cnt, $count - $latest_cnt);
			foreach($latest_comments as $comment) {
				$html .= elgg_view_annotation($comment, "", false);
			}
		}
		
		return $html;
	}

?>
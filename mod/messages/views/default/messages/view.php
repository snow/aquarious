<?php

	/**
	 * Elgg messages view page
	 * 
	 * @package ElggMessages
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 * 
	 * @uses $vars['entity'] An array of messages to view
	 * @uses $vars['page_view'] This is the page the messages are being accessed from; inbox or sentbox
	 * 
	 */
	 
	$limit = $vars['limit']; if (empty($limit)) $limit = 10;
	$offset = $vars['offset']; if (!isset($offset)) $offset = 0;
	$context = $vars['page_view'];

	// If there are any messages to view, view them
	if (isloggedin())
    if (is_array($vars['entity']) && sizeof($vars['entity']) > 0) {
    		
?>
    <div id="messages" /><!-- start the main messages wrapper div -->
            
<?php	

		$counter = 0;
		
		foreach($vars['entity'] as $message) {
					
			if ('inbox' == $context) {
				if ($message->owner_guid != $vars['user']->guid
				|| $message->toID != $vars['user']->guid) {
					continue;
				}
				//make sure to only display the messages that have not been 'deleted' (1 = deleted)
				if ($message->hiddenFrom) {
					continue;
				}
				// check to see if the message has been read, if so, get the correct background color
				if ($message->readYet) {
					$wrapper_class = 'message_read';
				}else{
					$wrapper_class = 'message_notread';
				}
			}else{
				if ($message->hiddenTo) {
					continue;
				}    					
				$wrapper_class = 'message_sent';
			}
	  				
	 		echo "<div class=\"$wrapper_class\"  id=\"msg-$message->guid\" />";
	        /**
	         * message summary table
	         */
            //set the table
			echo "<table width=\"100%\" cellspacing='0'><tr>";       
            //get the icon of the user who owns the message
            $from = get_entity($message->fromId);
			echo "<td width='200px'>" . elgg_view("profile/icon",array('entity' => $from, 'size' => 'tiny')) . "<div class='msgsender'><b>" . $from->name . "</b><br /><small>" . friendly_time($message->time_created) . "</small></div></td>";
			//display the message title
		    echo "<td><div class='msgsubject'>";
		    echo "<input type=\"checkbox\" name=\"message_id[]\" value=\"{$message->guid}\" /> ";
		    if (strlen($message->description) > 48 ) {
		    	$label = substr($message->description,0,48).'...';
		    }else{
		    	$label = $message->description;
		    }
		    $label = preg_replace('/<.>/','',$label);
		    echo "<a class=\"show_details\" name=\"$message->guid\" href=\"{$message->getURL()}\">" . $label . "</a></div></td>";
		    //display the link to 'delete'
		    
		    echo "<td width='70px'>";
		    echo "<div class='delete_msg'>" . elgg_view("output/confirmlink", array(
										'href' => $vars['url'] . "action/messages/delete?message_id=" . $message->getGUID() . "&type=inbox&submit=" . urlencode(elgg_echo('delete')),
										'text' => elgg_echo('delete'),
										'confirm' => elgg_echo('deleteconfirm'),
									)) . "</div>";
           echo "</td></tr></table>";
           /**
            * message detail
            */
           echo '<div class="msg_details">';
           
           echo '<div class="content" title="empty"><img src="'.$vars['url'].'_graphics/ajax_loader.gif"/></div>';
           
           echo '<div class="options">';
           if ('inbox' == $context) {           
	           echo '<a class="toggle_reply" name="'.$message->guid.'" href="">'.elgg_echo('messages:answer').'</a>';
	           echo ' - ';
           }
           echo '<a class="hide_details" name="'.$message->guid.'" href="">'.elgg_echo('messages:hide_details').'</a>';
           echo ' - ';
           echo elgg_view("output/confirmlink", array(
									'href' => $vars['url'] . "action/messages/delete?message_id=" . $message->getGUID() . "&type=inbox&submit=" . urlencode(elgg_echo('delete')),
									'text' => elgg_echo('delete'),
									'confirm' => elgg_echo('deleteconfirm'),
								));
           echo '</div>';
           
           echo '<div class="reply">';
           echo '<label>'.elgg_echo("messages:message").':</label>';
           echo elgg_view("input/longtext",
           				array(
							"internalname" => "message",
							"value" => '',
						));
			echo "<input type='hidden' name='reply' value='" . $message->guid . "' />";
			echo "<input type='hidden' name='send_to' value='" . $message->fromId . "' />";
			echo '<input type="button" class="submit_button" value="'.elgg_echo("messages:fly").'!" />';
	           echo "</div>";
	           
	           echo '</div>';//cloase msg_detail div
	           echo '</div>';// close the message background div
			
			$counter++;
			if ($counter == $limit) break;
			
		}//end of for each loop
			
			
		$baseurl = $_SERVER['REQUEST_URI'];
		$baseurl = $baseurl = preg_replace('/[\&\?]offset\=[0-9]*/',"",$baseurl); 
		
		$nav = '';
		
		if (sizeof($vars['entity']) > $limit) {
			$newoffset = $offset + $limit;
			$urladdition = 'offset='.$newoffset;
			if (substr_count($baseurl,'?')) $nexturl=$baseurl . '&' . $urladdition; else $nexturl=$baseurl . '?' . $urladdition;
			
			$nav .= '<a class="pagination_previous" href="'.$nexturl.'">&laquo; ' . elgg_echo('previous') . '</a> ';
		}
			
		if ($offset > 0) {
			$newoffset = $offset - $limit;
			if ($newoffset < 0) $newoffset = 0;
			$urladdition = 'offset='.$newoffset;
			if (substr_count($baseurl,'?')) $prevurl=$baseurl . '&' . $urladdition; else $prevurl=$baseurl . '?' . $urladdition;
			
			$nav .= '<a class="pagination_next" href="'.$prevurl.'">' . elgg_echo('next') . ' &raquo;</a> ';
		}
	 
		
		if (!empty($nav)) {
			echo '<div class="pagination"><p>'.$nav.'</p><div class="clearfloat"></div></div>';
		}			
		echo "</div>"; // close the main messages wrapper div
		echo '<script src="'.$vars['url'].'mod/messages/js/msg_view.js"></script>';
			
    } else {
        
    	echo '<div id="messages" />' . elgg_echo("messages:nomessages") . '</div>';
    		
	}//end of the first if statement
?>
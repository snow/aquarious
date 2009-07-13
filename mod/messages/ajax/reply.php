<?php
	/**
	 * TODO bio
	 *
	 * @package
	 */
	/**
	 * @author Snow.Hellsing <snow@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	require_once '../../../engine/start.php';
	
	gatekeeper();
	
	// Get input data
	$title = 'message'; // message title
    $message_contents = get_input('message'); // the message
    $send_to = get_input('send_to'); // this is the user guid to whom the message is going to be sent
    $reply = get_input('reply',0); // this is the guid of the message replying to
    
    try {
    	$user = get_user($send_to);
	    if (!$user) {
	    	throw new Exception(elgg_echo("messages:user:nonexist"));
	    }
	    
	    // Make sure the message field, send to field and title are not blank
	    if (empty($message_contents) || empty($send_to)){
	    	throw new Exception(elgg_echo("messages:blank"));
	    }
	    
	    if(messages_send($title,$message_contents,$send_to,0,$reply)){
	    	echo elgg_view('messages/messages/list',array('object'=>array(elgg_echo("messages:posted"))));
	   	}else{
	   		throw new Exception(elgg_echo("messages:error"));
	   	}
    }catch (Exception $e){
    	echo elgg_view('messages/errors/list',array('object'=>array($e->getMessage())));
    }
?>
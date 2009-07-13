/**
 *
 */
$(function(){
	processShowDetailsLink();	
	processHideDetailsLink();
	processShowReplyLink();
	//processBatchSubmit();
	reply();
});
function processShowDetailsLink(){
	$('#messages .show_details').click(function(){
		var guid = this.name;
		showMsgDetails(guid);
		return false;
	});
}
function processHideDetailsLink(){
	$('#messages .hide_details').click(function(){
		var guid = this.name;
		hideMsgDetails(guid);
		return false;
	});
}
function processShowReplyLink(){
	$('#messages .toggle_reply').click(function(){
		var guid = this.name;
		var msg_div = $('#msg-'+guid);
		var reply_div = $('.reply',msg_div)[0];
		
		$(reply_div).toggle('fast');
		return false;
	});
}

function reply(){
	$('#messages .reply .submit_button').click(function(){
		var reply_div = this.parentNode;
		
		var msg_input = $("[name='message']",reply_div)[0];
		var msg = msg_input.value;
		var reply = $("[name='reply']",reply_div)[0].value;
		var send_to = $("[name='send_to']",reply_div)[0].value;
		
		var action = '../../mod/messages/ajax/reply.php';
		
		$.get(action,
			   {'message':msg,'reply':reply,'send_to':send_to},
			   function(response){
			$('body').append(response);
			msg_input.value = "";			
			hideMsgDetails(reply);
		});
		
		return false;
	});
}
/**
 *
 */
function showMsgDetails(guid){	
	var msg_div = $('#msg-'+guid);
	
	var detail_div = $('.msg_details',msg_div)[0];
	var content_div = $('.content',msg_div)[0];
	var subject_div = $('.msgsubject',msg_div)[0];
	
	$(detail_div).show('fast');		
	$(subject_div).hide('fast');		
	
	if( 'empty' == content_div.title){
		$(content_div).load('../../mod/messages/ajax/get_content.php',{'guid':guid});
		content_div.title = "";			
	}
	
	if('message_notread' == msg_div.attr('class')){
		markRead(guid);
		msg_div.attr('class','message_read');
		var new_msg_link = $('.privatemessages_new')[0];
		if(new_msg_link){
			new_msg_link = $(new_msg_link);
			var new_msg_count = new_msg_link.html().replace(/[\[\]]/g,'');
			
			new_msg_count--;
			if( '0' == new_msg_count){
				new_msg_link.empty();				
				new_msg_link.removeClass('privatemessages_new');
				new_msg_link.addClass('privatemessages');				
			}else{				
				new_msg_link.html('['+new_msg_count+']');
			}			
		}
	}
}

function hideMsgDetails(guid){
	var msg_div = $('#msg-'+guid);
	
	var detail_div = $('.msg_details',msg_div)[0];
	var subject_div = $('.msgsubject',msg_div)[0];
	
	$(detail_div).hide('fast');
	$(subject_div).show('fast');
}



function markRead(guid){
	var url = '../../mod/messages/ajax/mark_read.php';	
	$.post(url,{'guid':guid});	
}
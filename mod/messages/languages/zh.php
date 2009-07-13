<?php

	$chinese = array(
		'messages:toggle_picker' => '打开成员列表',
		'messages:hide_details' => '折叠',
		'notification:messages' => '站内信',
	
		/**
		 * Menu items and titles
		 */
	
			'messages' => "私信",
			'messages:back' => "返回收件箱",
			'messages:user' => "收件箱",
			'messages:sentMessages' => "发私信",
			'messages:posttitle' => "%s 的来信： %s",
			'messages:inbox' => "收件箱",
			'messages:send' => "发私信",
			'messages:sent' => "已发信件",
			'messages:message' => "内容",
			'messages:title' => "标题",
			'messages:to' => "到",
			'messages:from' => "来自",
			'messages:fly' => "发送",
			'messages:replying' => "回复",
			'messages:inbox' => "收件箱",
			'messages:sendmessage' => "发私信",
			'messages:compose' => "写信",
			'messages:sentmessages' => "已发信件",
			'messages:recent' => "最近私信",
			'messages:original' => "私信原件",
            'messages:yours' => "你的私信",
            'messages:answer' => "回复",
			'messages:toggle' => '全选/全不选',
			'messages:markread' => '标记为已读',
	
			'messages:new' => '新的私信',
	
			'notification:method:site' => '站内',
	
			'messages:error' => '保存信件时发生内部错误，请重试',
			
			'item:object:messages' => '私信',
	
		/**
		 * Status messages
		 */
	
			'messages:posted' => "您的信件已经成功的发出。",
			'messages:deleted' => "您的信件已经成功的删除。",
			'messages:markedread' => "信件已标记为已读",
	
		/**
		 * Email messages
		 */
	
			'messages:email:subject' => '您有新的来信！',
			'messages:email:body' => "您有一封来信来自 %s. 内容:

			
%s


查看信件，点击:

	%s

发送给 %s 写信，点击:

	%s

请不要回复本邮件",
	
		/**
		 * Error messages
		 */
	
			'messages:blank' => "抱歉，请再发布前输入内容。",
			'messages:notfound' => "抱歉，我们没有找到指定内容。",
			'messages:notdeleted' => "抱歉，我们无法删除本消息。",
			'messages:nopermission' => "您没有权限删除该消息。",
			'messages:nomessages' => "没有消息可以显示。",
			'messages:user:nonexist' => "我们没有在数据库中找到收件者的信息。",
	
	);
					
	add_translation("zh",$chinese);

?>
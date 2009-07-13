<?php

	$chinese = array(
		
		/**
		 * Menu items and titles
		 */
	
			'blog' => "日志",
			'blogs' => "日志",
			'blog:user' => "%s 的日志",
			'blog:user:friends' => "%s 的朋友的日志",
			'blog:your' => "你的日志",
			'blog:posttitle' => "%s's blog: %s",
			'blog:friends' => "Friends' blogs",
			'blog:yourfriends' => "Your friends' latest blogs",
			'blog:everyone' => "全站日志",
			'blog:newpost' => "新日志",
			'blog:via' => "via blog",
			'blog:read' => "Read blog",
	
			'blog:addpost' => "写新日志",
			'blog:editpost' => "编辑日志",
	
			'blog:text' => "正文",
	
			'blog:strapline' => "%s",
			
			'item:object:blog' => '日志',
	
			'blog:never' => '未保存',
			'blog:preview' => '预览',
	
			'blog:draft:save' => '保存为草稿',
			'blog:draft:saved' => '上次保存',
			'blog:comments:allow' => '允许回复',
	
			'blog:preview:description' => 'This is an unsaved preview of your blog post.',
			'blog:preview:description:link' => 'To continue editing or save your post, click here.',
	
			
         /**
	     * Blog river
	     **/
	        
	        //generic terms to use
	        'blog:river:created' => "%s 发表了一篇日志",
	        'blog:river:updated' => "%s 编辑了日志",
	        'blog:river:posted' => "%s 发表了一篇日志",
	        
	        //these get inserted into the river links to take the user to the entity
	        'blog:river:create' => "发表了日志:",
	        'blog:river:update' => "编辑了日志:",
	        'blog:river:annotate' => "回复了日志:",
			
	
		/**
		 * Status messages
		 */
	
			'blog:posted' => "日志已发表",
			'blog:deleted' => "日志已删除",
	
		/**
		 * Error messages
		 */
	
			'blog:error' => '抱歉，发生了内部错误，请尝试再来一遍',
			'blog:save:failure' => "抱歉，发生了内部错误，请尝试再来一遍",
			'blog:blank' => "请填写日志标题和正文",
			'blog:notfound' => "这篇日志不存在，可能已经被删除",
			'blog:notdeleted' => "抱歉，删除失败，可能发生了内部错误",
	
	);
					
	add_translation("zh",$chinese);

?>
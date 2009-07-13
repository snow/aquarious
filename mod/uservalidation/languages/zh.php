<?php
	/**
	 * User validation plugin.
	 * 
	 * @package pluginUserValidation
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Ralf Fuhrmann, Euskirchen, Germany
	 * @copyright 2008 Ralf Fuhrmann, Euskirchen, Germany
	 * @link http://mysnc.de/
	 */

	$chinese = array(
	
		/**
		 * Default translations
		 */
		
		'uservalidation:admin:confirm:fail' => "无法激活帐号",
		'uservalidation:admin:confirm:success' => "用户已经被激活啦 :)",//"Account has been activated !",
		'uservalidation:admin:registerok' => "注册申请已提交，管理员激活您的帐号后会发送通知到您的邮箱", 
		'uservalidation:confirm:fail' => "无法激活帐号，请再次尝试或者与网站管理员联系。",
		'uservalidation:confirm:success' => "您的帐户已激活",
		'uservalidation:email:registerok' => "请到您填写的邮箱查收激活邮件，点击其中的链接激活帐号", 
	    
		/**
		 * eMail translations
		 */

		'uservalidation:adminmail:subject' => "%s注册啦  !",
		'uservalidation:adminmail:body' => "
亲爱的管理员同志,
 %s (%s) 刚才提交了注册申请.
如果网站设置为需要管理员批准用户的注册申请，请激活ta的帐号。

本邮件由网站管理员发自异次元空间，请勿回复。",
	
		'uservalidation:autodelete:subject' => "Some users have been auto-deleted !",
		'uservalidation:autodelete:body' => "
Hi Admin,
the following users have been auto-deleted :
%s",

		'uservalidation:admin:validate:subject' => "%s 请稍等管理员激活您的帐号",
		'uservalidation:admin:validate:body' => "
嗨 %s,
管理员会尽快激活您的帐号.然后您就可以登录 %s 了。 ^^

本邮件由网站管理员发自异次元空间，请勿回复。",
	
		'uservalidation:email:validate:subject' => "%s 请激活您的帐号",
		'uservalidation:email:validate:body' => "
嗨 %s,
请点击下面的链接激活您的帐号:
%s
或者把链接复制粘贴到浏览器的地址栏打开网页，也可以完成激活步骤。

本邮件由网站管理员发自异次元空间，请勿回复。",
	
		'uservalidation:success:subject' => "%s 您的帐号已激活",
		'uservalidation:success:body' => "
嗨 %s,
欢迎回家，您的帐号已经激活了。 ^^
点击下面的链接会带您到 %s :
%s

本邮件由网站管理员发自异次元空间，请勿回复。",
         

	);
	add_translation('zh', $chinese);
	
	
	if (isadminloggedin())
	{
	

		$chinese = array(

			/**
			* Admin-Only translations
			*/

			'uservalidation:activate' => "通过",//"Activate user",
			'uservalidation:autodelete' => "Days, after that not activated users will be deleted",
			'uservalidation:autodelete:no' => "no auto-delete",
			'uservalidation:delete' => "删除",//"Delete user", 
			'uservalidation:banned' => "Banned",
			'uservalidation:method' => "Method for UserValidation",
			'uservalidation:method:none' => "no validation",
			'uservalidation:method:bymail' => "validate by mail",
			'uservalidation:method:byadmin' => "validate by admin(s)",
			'uservalidation:pendingusers' => "新用户审核",//"Pending registration(s)",
			'uservalidation:registered' => "申请时间",//"Registered",
			'uservalidation:adminmail' => "Admin receives eMail on registration",
			'uservalidation:adminmail:every' => "every registration",
			'uservalidation:adminmail:adminonly' => "only if an admin-action required",
			'uservalidation:waiting' => "待审核会员",//"Waiting for activation",

		);
		add_translation('zh', $chinese);
	
	}
	
?>
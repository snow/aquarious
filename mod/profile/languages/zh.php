<?php
	/*
	 * languages for improved profile
	 *
	 * @package ImprovedProfile
	 */
	/*
	 * @author Snow.Hellsing <snow@g7life.com>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */

	$chinese = array(
	
		'unselected' => '请选择:',		
		
		#profile
		#section:basic
		'profile:category:basic' => '基本信息',
		'profile:gender' => '性别',
		'profile:female' => '女',
		'profile:male' => '男',
		#birthday
		'profile:birthday' => '生日',
		'year' => '年',
		'month' => '月',
		'day' => '日',	
		'profile:birthday:show_year' => '显示 年-月-日 格式的完整生日',
		'profile:birthday:hide_year' => '隐藏出生年份，只显示月-日',
		'profile:hometown' => '家乡',
		#relationship
		'profile:relationship_status' => '婚恋状况',
		'profile:single' => '单身',
		'profile:in_relationship' => '恋爱中',
		'profile:engaged' => '已订婚',
		'profile:married' => '已婚',
		'profile:hard_to_tell' => '这个嘛，很复杂',
		'profile:open_relationship' => '另一半不介意我乱来',	
		#personal
		'profile:category:personal' => '个人信息',		
		#contact
		'profile:category:contact' => '联络方式',
		'profile:qq' => 'QQ',
		'profile:email' => '电子邮箱',		
		#profession
		'profile:category:profession' => '职业信息',
		'profile:profession' => '职业',
		'profile:company' => '就职于',
		'profile:position' => '职位',
		'profile:college' => '毕业于',
		'profile:course' => '专业',
			
		'DataFormatException:invalid_input_format' => '%s格式有误',
		'DataFormatException:field_required' => '请输入 %s',
		'DataFormatException:empty_input' => '网站遇到了技术问题，请联络管理员',
		'BusinessLogicException:unique_meta_duple' => '已经有人在使用这个%s',
		'ConfigurationException:invalid_profile_config' => '个人资料配置文件出错。如果你看到了这条信息请联系管理员或者程序员。',
	);

	add_translation("zh",$chinese);
?>
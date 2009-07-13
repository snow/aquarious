<?php

	/**
	 * Elgg thewire view page
	 * 
	 * @package ElggTheWire
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 * 
	 */
	$today = date('m-d');
	$tomorrow = date('m-d',mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));
	$after_tomorrow = date('m-d',mktime(0, 0, 0, date("m")  , date("d")+2, date("Y")));
	
	$members = get_entities('user','',0,'',0);
	$today_guys = array();
	$tomorrow_guys = array();
	$after_tomorrow_guys = array();
	foreach ($members as $user){
		if ($user->birthday) {
			$birthday = date('m-d',$user->birthday);
			switch ($birthday) {
				default:
					;
				break;
				case $today:
					$today_guys[] = $user;
				break;
				case $tomorrow:
					$tomorrow_guys[] = $user;
				break;
				case $after_tomorrow:
					$after_tomorrow_guys[] = $user;
				break;
			}			
		}		
	}
	unset($user);
	
?>

<div class="sidebarBox">
<h3><?php echo elgg_echo('sidebox:birthday_members'); ?></h3>
<div class="membersWrapper">
<div><?php echo elgg_echo('today'); ?>
<?php 
	foreach($today_guys as $mem){
		echo "<div class=\"recentMember\">" . elgg_view("profile/gallery-small",array('entity' => $mem)) . "</div>";
	}
?>
</div><div class="clearfloat"></div>
<div><?php echo elgg_echo('tomorrow'); ?>
<?php 
	foreach($tomorrow_guys as $mem){
		echo "<div class=\"recentMember\">" . elgg_view("profile/gallery-small",array('entity' => $mem)) . "</div>";
	}
?>
</div><div class="clearfloat"></div>
<div><?php echo elgg_echo('aftertomorrow'); ?>
<?php 
	foreach($after_tomorrow_guys as $mem){
		echo "<div class=\"recentMember\">" . elgg_view("profile/gallery-small",array('entity' => $mem)) . "</div>";
	}
?>
</div>
<div class="clearfloat"></div>
</div>
</div>
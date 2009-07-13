<?php
	$prev_context = get_context();
    set_context('random');
    $sidebarbox = '<div class="sidebarBox"><h3>'.elgg_echo('tagcloud').'</h3><div class="membersWrapper">';
	$sidebarbox .= display_tagcloud(0,30,'tags').'</div></div>';
	set_context($prev_context);
	echo $sidebarbox;
?>
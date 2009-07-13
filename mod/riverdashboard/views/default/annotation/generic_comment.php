<?php

	/**
	 * Elgg generic comment
	 *
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 *
	 */

	$owner = get_user($vars['annotation']->owner_guid);
	$comment = $vars['annotation']->value;
	$time_created = $vars['annotation']->time_created;

	if ($owner && $time_created && !empty($comment)) {
?>


	<div class="generic_comment"><!-- start of generic_comment div -->

		<div class="generic_comment_icon">
    		<?php
    			echo elgg_view("profile/icon",
    						array(
    							'entity' => $owner,
    							'size' => 'small'));
    		?>
		</div>
		<div class="generic_comment_details">
    		<span class="comment_owner"><a href="<?php echo $owner->getURL(); ?>"><?php echo $owner->name; ?></a></span>
		    <!-- output the actual comment -->
		    <?php echo elgg_view("output/longtext",array("value" => $comment)); ?>

		    <p class="generic_comment_owner">
    	    <?php echo friendly_time($time_created); ?>

		    <?php

		        // if the user looking at the comment can edit, show the delete link
			    if ($vars['annotation']->canEdit()) {

            ?>
		    &nbsp;|&nbsp;
		        <?php

			        echo elgg_view("output/confirmlink",array(
														'href' => $vars['url'] . "action/riverdashboard/delete?annotation_id=" . $vars['annotation']->id,
														'text' => elgg_echo('delete'),
														'confirm' => elgg_echo('deleteconfirm'),
													));

		        ?>
		    </p>

            <?php
			    } //end of can edit if statement
		    ?>
		</div><!-- end of generic_comment_details -->
	</div><!-- end of generic_comment div -->
<?php
	}// if ($owner)
?>
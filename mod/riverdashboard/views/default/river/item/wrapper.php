<?php
	/**
	 * add a <div class="basic_river_item_view"> inside <div class="river_type_subtype_actiontype">
	 * to make possible extra view could replace this div
	 *
	 * @package ImprovedRiverDashboard
	 */
	/**
	 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	/**
	 * Elgg river item wrapper.
	 * Wraps all river items.
	 * 
	 * @package Elgg
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
	
	$object_guid = $vars['item']->object_guid;
	$posted = $vars['item']->posted;


?>

	<div class="river_item" id="<?php echo $object_guid.'-'.$posted;?>">
		<div class="river_<?php echo $vars['item']->type; ?>">
			<div class="river_<?php echo $vars['item']->subtype; ?>">
				<div class="river_<?php echo $vars['item']->action_type; ?>">				
					<div class="river_<?php echo $vars['item']->type; ?>_<?php if($vars['item']->subtype) echo $vars['item']->subtype . "_"; ?><?php echo $vars['item']->action_type; ?>">
						<div class="basic_river_item_view">
							<?php
			
									echo $vars['body'];
					
							?>
							<span class="river_item_time">
								(<?php
					
									echo friendly_time($vars['item']->posted);
								
								?>)
							</span>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
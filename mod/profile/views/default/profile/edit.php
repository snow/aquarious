<?php
	/**
	 * Modified edit view to fit ElggObject based profile config
	 *
	 * @package ImprovedProfile
	 */
	/**
	 * @author Snow.Hellsing <snow@g7life.com>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	/**
	 * Elgg profile edit form
	 * 
	 * @package ElggProfile
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 * 
	 * @uses $vars['entity'] The user entity
	 * @uses $vars['profile'] Profile items from $CONFIG->profile, defined in profile/start.php for now 
	 */

?>
<div class="contentWrapper">
<form action="<?php echo $vars['url']; ?>action/profile/edit" method="post">

<?php
	$profile = $vars['config']->profile;
	//var_export($vars['profile']);
	if (is_array($profile) && sizeof($profile) > 0){		
		
		foreach($profile as $category) {
			$last_field_category = '';
			foreach ($category as $item) {
				$shortname = $item->title;
				$valuetype = $item->valuetype;
				$curr_field_category = $item->category;
			/*
			 * MOD END by Snow
			 */		
				if ($metadata = get_metadata_byname($vars['entity']->guid, $shortname)) {
					if (is_array($metadata)) {
						$value = '';
						foreach($metadata as $md) {
							if (!empty($value)) $value .= ', ';
							$value .= $md->value;
							$access_id = $md->access_id;
						}
					} else {
						$value = $metadata->value;
						$access_id = $metadata->access_id;
					}
				} else {
					$value = '';
					$access_id = ACCESS_DEFAULT;
				}
	
				/*
				 * MOD START by Snow
				 */
				/*
				 * HACK START
				 * replace email field value with user->email instead of meta
				 */
				/*if ('email' == $shortname) {
					$value = $vars['entity']->email;
				}*/
				/*
				 * HACK END
				 */
				/*
				 * now built the edit form
				 */
				if ($curr_field_category != $last_field_category) {
					echo "<p class=\"profile_category_title\" id=\"profile:category:$curr_field_category\">".elgg_echo("profile:category:$curr_field_category")."</p>";
				}
				echo "<p id=\"profile:{$shortname}\">";
				echo "<lable>".elgg_echo("profile:{$shortname}").'<br />';
				switch ($valuetype) {
					default:
						echo elgg_view("input/{$valuetype}",
									array(
										'internalname' => $shortname,
										'value' => $value,
										)
									);
					break;
					
					case 'pulldown':
						echo elgg_view("input/pulldown",
										array(
											'internalname' => $shortname,
											'value' => $value,
											'options_values' => $item->options,
											)
										);
					break;
					
					case 'date':
						echo elgg_view("input/datepulldown",
									array(
										'internalname' => $shortname,
										'value' => $value,
										)
									);
					break;
				}
				echo '</lable>';
				//special codes for birthday selecting
				if( 'birthday' == $shortname ){
					$show_birth_year = $vars['entity']->show_birth_year;
					echo elgg_view("input/pulldown",
							array(
								'internalname' => 'show_birth_year',
								'value' => $show_birth_year,
								'options_values' => array(TRUE => elgg_echo('profile:birthday:show_year'),FALSE => elgg_echo('profile:birthday:hide_year')),
								)
							);
				}
				echo elgg_view('input/access',array('internalname' => 'accesslevel['.$shortname.']', 'value' => $access_id));
				echo '</p>';
				$last_field_category = $curr_field_category;
				/*
				 * MOD END by Snow
				 */
			}//foreach
		}//foreach
	}
?>

	<p>
		<input type="hidden" name="username" value="<?php echo page_owner_entity()->username; ?>" />
		<input type="submit" class="submit_button" value="<?php echo elgg_echo("save"); ?>" />
	</p>

</form>
</div>
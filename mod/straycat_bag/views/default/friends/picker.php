<?php
	/**
	 * make friendpick wider use
	 *
	 * @package straycat_bag
	 */
	/**
	 * Elgg friends picker
	 * Lists the friends picker
	 * 
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 * 
	 * @uses $vars['entities'] The array of ElggUser objects
	 */
	/**
	 * @author Snow.Hellsing <snow@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */

	// Let the system know that the friends picker is in use
		global $pickerinuse;
		$pickerinuse = true;
		$chararray = elgg_echo('friendspicker:chararray');

	// Initialise internalname
		if (!isset($vars['internalname'])) {
			$internalname = "friend";
		} else {
			$internalname = $vars['internalname'];
		}
		
	// Are we highlighting default or all?
		if (empty($vars['highlight'])) $vars['highlight'] = 'default';
		if ($vars['highlight'] != 'all') $vars['highlight'] = 'default';
		
	// Initialise values
		if (!isset($vars['value'])) {
			$vars['value'] = array();
		} else {
			if (!is_array($vars['value'])) {
				$vars['value'] = (int) $vars['value'];
				$vars['value'] = array($vars['value']);
			}
		}

	// Initialise whether we're calling back or not
		if (isset($vars['callback'])) {
			$callback = $vars['callback'];
		} else {
			$callback = false;
		}
		
	// We need to count the number of friends pickers on the page.
		if (!isset($vars['friendspicker'])) {
			global $friendspicker;
			if (!isset($friendspicker)) $friendspicker = 0;
			$friendspicker++;
		} else {
			$friendspicker = $vars['friendspicker'];
		}

		$users = array();
		$activeletters = array();
		
	// Are we displaying form tags and submit buttons?
	// (If we've been given a target, then yes! Otherwise, no.)
		if (isset($vars['formtarget'])) {
			$formtarget = $vars['formtarget'];
		} else {
			$formtarget = false;
		}
		
	// Sort users by letter
	/*
	 * MOD START by Snow
	 * add zh2pinyin for chinese names,and except the user her/him self from list
	 */
		if (is_array($vars['entities']) && sizeof($vars['entities']))
			foreach($vars['entities'] as $user) {
				if ($user->guid == $_SESSION['guid']) {
					continue;
				}
				$name = Pinyin($user->name);	 			
				if (is_callable('mb_substr'))
					$letter = strtoupper(mb_substr($name,0,1));
				else
					$letter = strtoupper(substr($name,0,1));
				if (!substr_count($chararray,$letter)) {
					$letter = "*";
				}
				if (!isset($users[$letter])) {
					$users[$letter] = array();
				}
				$users[$letter][$name] = $user;
			}
	/*
	 * MOD END by Snow
	 */	
		
	if (!$callback) {
			
?>
<div class="friends_picker">

<?php

	if (isset($vars['content'])) echo $vars['content'];

	
?>

	<div id="friends_picker_placeholder<?php echo $friendspicker; ?>">

<?php
	
	}
	
	if (!isset($vars['replacement'])) {
	
		if ($formtarget) {
?>

	<script language="text/javascript">
		$(function() { // onload...do
		$('#collectionMembersForm<?php echo $friendspicker; ?>').submit(function() {
			var inputs = [];
			$(':input', this).each(function() {
				if (this.type != 'checkbox' || (this.type == 'checkbox' && this.checked != false)) {
					inputs.push(this.name + '=' + escape(this.value));
				}
			});
			jQuery.ajax({
				type: "POST",
				data: inputs.join('&'),
				url: this.action,
				success: function(){
     				$('a.collectionmembers<?php echo $friendspicker; ?>').click();
   				}

			});
			return false;
        })
      })

	</script>

	<!-- Collection members form -->
	<form id="collectionMembersForm<?php echo $friendspicker; ?>" action="<?php echo $formtarget; ?>" method="post"> <!-- action="" method=""> -->

<?php

		}

?>

	<div class="friendsPicker_wrapper">
	<div id="friendsPicker<?php echo $friendspicker; ?>">
		<div class="friendsPicker_container">
<?php

	// Initialise letters
		$chararray .= "*";
		if (is_callable('mb_substr'))
			$letter = mb_substr($chararray,0,1);
		else
			$letter = substr($chararray,0,1);
		$letpos = 0;
		while (1 == 1) {
?>
			<div class="panel" title="<?php 
					echo $letter;
			?>">
				<div class="wrapper">
					<h3><?php echo $letter; ?></h3>					
					
<?php

			if (isset($users[$letter])) {
				ksort($users[$letter]);
				
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				$col = 0;
				
				foreach($users[$letter] as $friend) {
					if ($col == 0) echo "<tr>";
					
					//echo "<p>" . $user->name . "</p>";
					$label = elgg_view("profile/icon",array('entity' => $friend, 'size' => 'tiny', 'override' => true)); 
					$options[$label] = $friend->getGUID();
					
					if ($vars['highlight'] == 'all'
						&& !in_array($letter,$activeletters)) {
							$activeletters[] = $letter;
						}
						
					
					if (in_array($friend->getGUID(),$vars['value'])) {
						$checked = "checked = \"checked\"";
						if (
								!in_array($letter,$activeletters)
								&& $vars['highlight'] == 'default'
							)
							$activeletters[] = $letter;
					} else {
						$checked = "";
					}

?>
			
			<td>
			
				<input class="friends_picker_checkbox" type="checkbox" <?php echo $checked; ?> name="<?php echo $internalname; ?>[]" value="<?php echo $options[$label]; ?>" />
			
			</td>

			<td class="friends_picker_icon" id="td_icon-<?php echo $friend->guid;?>">
			
				<div style="width: 25px; margin-bottom: 15px;"><a>
<?php

				echo $label;
			
?>
				</a></div>
			</td>
			<td class="friends_picker_name" id="td_name-<?php echo $friend->guid;?>" style="width: 200px; padding: 5px;" >
				<a>	
<?php

					echo $friend->name;
				
?>
				</a>
			</td>
			
<?php
					
					$col++;
					if ($col == 3){
						echo "</tr>";
						$col = 0;
					}
				}
				if ($col < 3) echo "</tr>";
				
				echo "</table>";
				
			}

?>
			
				</div>
			</div>
<?php			
			//if ($letter == 'Z') break;
			
			if (is_callable('mb_substr'))
				$substr = mb_substr($chararray,strlen($chararray) - 1,1);
			else
				$substr = substr($chararray,strlen($chararray) - 1,1);
			if ($letter == $substr) break;
			//$letter++;
			$letpos++;
			if (is_callable('mb_substr'))
				$letter = mb_substr($chararray,$letpos,1);
			else
				$letter = substr($chararray,$letpos,1);
		}
		
?>
		</div>
		
<?php

	if ($formtarget) {

		if (isset($vars['formcontents']))
			echo $vars['formcontents'];
		
?>
		<div class="clearfloat"></div>
		<div class="friendspicker_savebuttons">
			<input type="submit" class="submit_button" value="<?php echo elgg_echo('save'); ?>" />
			<input type="button" class="cancel_button" value="<?php echo elgg_echo('cancel'); ?>" onclick="$('a.collectionmembers<?php echo $friendspicker; ?>').click();" />
		<br /></div>
		</form>
		
<?php

	}

?>
		
	</div>
	</div>
	
<?php
	} else {
		echo $vars['replacement']; 
	}
	if (!$callback) {

?>
			
	</div>
</div>


<?php

	}

	if (!isset($vars['replacement'])) {
?>

<script type="text/javascript">
		// initialise picker
		$("div#friendsPicker<?php echo $friendspicker; ?>").friendsPicker(<?php echo $friendspicker; ?>);
</script>
<script>
	$(document).ready(function () {
	// manually add class to corresponding tab for panels that have content
<?php
	if (sizeof($activeletters) > 0)
		//$chararray = elgg_echo('friendspicker:chararray');
		foreach($activeletters as $letter) {
			$tab = strpos($chararray, $letter) + 1;
?>
	$("div#friendsPickerNavigation<?php echo $friendspicker; ?> li.tab<?php echo $tab; ?> a").addClass("tabHasContent");
<?php
		}

?>
	});
</script>
<?php

	}

?>
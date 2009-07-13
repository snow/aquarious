<?php
	/**
	 * Post texts,photo links or something else on the river
	 *
	 * @package ImprovedRiverdashboard
	 */
	/**
	 * @author Snow.Hellsing <snow.hellsing@firebloom.cc>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	/**
	 * Elgg thewire edit/add page
	 * 
	 * @package ElggTheWire
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 * 
	 */
	$action = "{$vars['url']}action/riverdashboard/post";
	$msg = get_input('m');
?>
<div class="post_to_wire">
<h3><?php echo elgg_echo("river:doing"); ?></h3>
<script>
function textCounter(field,cntfield,maxlimit) {
    // if too long...trim it!
    if (field.value.length > maxlimit) {
        field.value = field.value.substring(0, maxlimit);
    } else {
        // otherwise, update 'characters left' counter
        cntfield.value = maxlimit - field.value.length;
    }
}
</script>
<?php
	$form_body = "<textarea name='river_post' value='' onKeyDown=\"textCounter(document.river_post_form.river_post,document.river_post_form.remLen1,140)\" onKeyUp=\"textCounter(document.river_post_form.river_post,document.river_post_form.remLen1,140)\" id=\"river_post-textarea\">$msg</textarea>";
	$form_body .= "<div class='thewire_characters_remaining'><input readonly type=\"text\" name=\"remLen1\" size=\"3\" maxlength=\"3\" value=\"140\" class=\"thewire_characters_remaining_field\">";
	$form_body .= elgg_echo("river:post:charleft") . "</div>"; 
	$form_body .= elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('save')));
	echo elgg_view('input/form', array('action' => $action,'method'=>'post','internalname'=>'river_post_form', 'body' => $form_body));
?>
</div>
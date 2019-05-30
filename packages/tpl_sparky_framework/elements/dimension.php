<?php
/*------------------------------------------------------------------------
# "Sparky Framework" - Joomla Template Framework
# Copyright (C) 2016 HotThemes. All Rights Reserved.
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Author: HotThemes
# Website: http://www.hotjoomlatemplates.com
-------------------------------------------------------------------------*/

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldDimension extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'dimension';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
        $document = JFactory::getDocument();
		
		$this->value = htmlspecialchars(html_entity_decode($this->value, ENT_QUOTES), ENT_QUOTES);
		$dimension = explode("@", $this->value);

	    $OUT= '';
	    ob_start();
		?>
		<input type="number" name="<?php echo $this->name; ?>_dimension" id="<?php echo $this->id; ?>_dimension" value="<?php echo $dimension[0]; ?>" class="sparky_dimension" />
		<select name="<?php echo $this->name; ?>_unit" id="<?php echo $this->id; ?>_unit" class="sparky_dimension_select">
			<?php if (isset($dimension[1])) { ?>
			<option value="px" <?php if ($dimension[1] == "px") { ?>selected="selected"<?php } ?>>px</option>
			<option value="em" <?php if ($dimension[1] == "em") { ?>selected="selected"<?php } ?>>em</option>
			<option value="rem" <?php if ($dimension[1] == "rem") { ?>selected="selected"<?php } ?>>rem</option>
			<option value="vw" <?php if ($dimension[1] == "vw") { ?>selected="selected"<?php } ?>>vw</option>
			<option value="vh" <?php if ($dimension[1] == "vh") { ?>selected="selected"<?php } ?>>vh</option>
			<option value="%" <?php if ($dimension[1] == "%") { ?>selected="selected"<?php } ?>>%</option>
			<?php } else { ?>
			<option value="px" selected="selected">px</option>
			<option value="em">em</option>
			<option value="rem">rem</option>
			<option value="vw">vw</option>
			<option value="vh">vh</option>
			<option value="%">%</option>
			<?php } ?>
		</select>
		<input type="hidden" name="<?php echo $this->name; ?>" id="<?php echo $this->id; ?>" value="<?php if (isset($dimension[1])) { echo $this->value; } else { echo $this->value."@px"; } ?>" />
		<script type="text/javascript">
			jQuery("#<?php echo $this->id; ?>_dimension").change(function() {
				var dimension = jQuery("#<?php echo $this->id; ?>_dimension").val() + "@" + jQuery("#<?php echo $this->id; ?>_unit").val();
				jQuery("#<?php echo $this->id; ?>").val(dimension);
			});
		    jQuery("#<?php echo $this->id; ?>_unit").change(function() {
				var dimension = jQuery("#<?php echo $this->id; ?>_dimension").val() + "@" + jQuery("#<?php echo $this->id; ?>_unit").val();
				jQuery("#<?php echo $this->id; ?>").val(dimension);
			});
		</script>
		<?php
		$OUT = ob_get_contents();
        ob_end_clean();		
        return $OUT;
	}
}

?>
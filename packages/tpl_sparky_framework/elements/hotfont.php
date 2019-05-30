<?php
/*------------------------------------------------------------------------
# "Sparky Framework" - Joomla Template Framework
# Copyright (C) 2016 HotThemes. All Rights Reserved.
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Author: HotThemes
# Website: http://www.hotjoomlatemplates.com
-------------------------------------------------------------------------*/


defined('JPATH_BASE') or die;
if(!defined('DS'))
	define('DS',DIRECTORY_SEPARATOR);
//JHtml::_('behavior.modal', 'a.modal');
jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldHotfont extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'hotfont';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		$app    = JFactory::getApplication();
		$dir = dirname(__FILE__);
		$pos = strpos($dir, 'templates'); 
		$dir = substr($dir, $pos);
		$file = $_SERVER["SCRIPT_NAME"];
		$file = str_replace("administrator/index.php","",$file);
		
		$str = file_get_contents(dirname(__FILE__) . DS . ".." . DS . 'js' . DS . 'admin' . DS . 'google-fonts.json');
		
		$json_google = json_decode($str, true);
		$categories = [];
		$subsets = [];
		foreach($json_google["items"] as $obj){
			if(!in_array($obj["category"], $categories, true)){
				array_push($categories, $obj["category"]);
			}
			foreach($obj["subsets"] as $subset){
				if(!in_array($subset, $subsets, true)){
					array_push($subsets, $subset);
				}
			}
		}
		sort($categories);
		sort($subsets);
		
		$OUT= '';
		ob_start();
		?>
		<script type="text/javascript">
			
		</script>
			
			<div class="input-prepend input-append font">
			<?php 
				$replaced = str_replace("\"","&#34;",$this->value); 
				$replaced = str_replace("'","&#39;",$replaced); 
				$obj_label = json_decode(str_replace("\\","",$this->value));
			?>
				<input type="text" id="<?php echo $this->id; ?>_hot" class="input-small oldInput fontlbl" data-toggle="tooltip_font"  data-placement="top" title="<?php echo $obj_label->fontFamily; ?>" value="<?php echo $obj_label->fontFamily; ?>" readonly="readonly"/>
				<input type="hidden" json="true" class="font" value="<?php echo $replaced; ?>" name="<?php echo $this->name; ?>" readonly="readonly" id="<?php echo $this->id; ?>"/>
				<a class="modal btn system" title="Select" href="#system" rel="{size: {x: 800, y: 500}, onOpen: initializeForSystem}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SYSTEM_FONTS'); ?></a>
				<a class="modal btn google" title="Select" href="#google" rel="{size: {x: 800, y: 450}, onOpen: initializeForGoogle}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_GOOGLE_FONTS'); ?></a>
			</div>
			
			<div id="hidden" style="display: none;">
				<div id="system">
					<div class="fonts">
						<label>Font Family</label>
						<select id="fonts">
							<option val="1">Georgia, serif</option>
							<option val="2">'Palatino Linotype', 'Book Antiqua', Palatino, serif</option>
							<option val="3">'Times New Roman', Times, serif</option>
							<option val="4">Arial, Helvetica, sans-serif</option>
							<option val="5">'Arial Black', Gadget, sans-serif</option>
							<option val="6">'Comic Sans MS', cursive, sans-serif</option>
							<option val="7">Impact, Charcoal, sans-serif</option>
							<option val="8">'Lucida Sans Unicode', 'Lucida Grande', sans-serif</option>
							<option val="9">Tahoma, Geneva, sans-serif</option>
							<option val="10">'Trebuchet MS', Helvetica, sans-serif</option>
							<option val="11">Verdana, Geneva, sans-serif</option>
							<option val="12">'Courier New', Courier, monospace</option>
							<option val="13">'Lucida Console', Monaco, monospace</option>
						</select>
					</div>
					
					<div class="weightAndStyle">
						<div>
							<label>Font Weight</label>
							<select id="weight">
								<option value="100">100</option>
								<option value="200">200</option>
								<option value="300">300</option>
								<option value="normal">Normal</option>
								<option value="500">500</option>
								<option value="600">600</option>
								<option value="bold">Bold</option>
								<option value="800">800</option>
								<option value="900">900</option>
							</select>
							<br>
							<label>Font style</label>
							<select id="style">
								<option value="normal">Normal</option>
								<option value="italic">Italic</option>
							</select>
						</div>
					</div>
					<div class="well">
						<div class="fontPreview">
						</div>
						<hr>
						<div class="textPreview">
							<p style="font-size: 28px;">Wizard boy Jack loves the grumpy Queen's fox.</p>
						</div>
					</div>
					<button class="btn btn-primary" style="margin-left: 15px;" type="button" onclick="">Select Font</button>
					<button class="btn" type="button" onclick="window.parent.jModalClose();">Cancel</button>
				</div>
				<div id="google">
					<div class="googleFontPreview">
					</div>
					<p style="margin-left: 15px;">You can add more fonts to your collection in Features > Google Web Fonts.</p>
					<button class="btn btn-primary" type="button" style="margin-left: 15px; margin-top: 10px;" onclick="">Select Font</button>
					<button class="btn" type="button" style="margin-top: 10px;" onclick="window.parent.jModalClose();">Cancel</button>
				</div>
				
			</div>
			
	
		<?php
		$OUT = ob_get_contents();
		ob_end_clean();		
		return $OUT;
	}
}


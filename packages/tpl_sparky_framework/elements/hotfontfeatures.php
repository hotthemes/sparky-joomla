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
class JFormFieldHotfontfeatures extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'hotfontfeatures';

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
			<p class="above_fonts">Available fonts:</p>
			<div id="features" >
				<div id="google">
					<div class="categorysubset">
						<div>
							<div style="display: inline-block; width: 30%;" class="cat">
							<p>
								Categories
							</p>
							<select id="category" multiple="multiple">
								<?php foreach($categories as $cat){?>
								<option value="<?php echo $cat; ?>" <?php /* if ($cat == "sans-serif") echo "selected='selected'";*/ ?> ><?php echo $cat; ?></option>
								<?php } ?>
							</select>
							</div>
							<div style="display: inline-block; width: 30%;" class="sub">
							<p>
								Subsets
							</p>
							<select id="subset">
								<?php foreach($subsets as $sub){?>
								<option value="<?php echo $sub; ?>" <?php if ($sub == "latin") echo "selected='selected'"; ?> ><?php echo $sub; ?></option>
								<?php } ?>
							</select>
							</div>
							<input class="search_field form-control" type="text" value="" placeholder="Search">
							<div class="input_trigger">
							</div>
						</div>
					</div>
					<div class="googleFontPreview">
					</div>
					<button class="btn btn-primary" type="button" style="margin-left: 0px; margin-top: 10px; margin-bottom: 10px;" onclick="saveParams3();">Add Font</button>
				</div>
			</div>
			<div class="selected_fonts">
				<p class="note"></p>
				
			</div>
			
			<button class="btn btn-primary" type="button" style="margin-left: 0px; margin-top: 10px; margin-bottom: 10px;" onclick="removeFonts()">Remove Fonts</button>
			
	
		<?php
		$OUT = ob_get_contents();
		ob_end_clean();		
		return $OUT;
	}
}


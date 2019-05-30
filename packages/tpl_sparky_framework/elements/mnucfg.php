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
class JFormFieldMnucfg extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'mnucfg';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
	    require_once JPATH_ADMINISTRATOR . '/components/com_menus/helpers/menus.php';
		$menuTypes	= MenusHelper::getMenuTypes();
		$template_name = "sparky_framework";

		function unitSelector($target) {
			echo '
			<select parameter="'.$target.'" class="menu_unit">
				<option value="px" selected="selected">px</option>
				<option value="em">em</option>
				<option value="rem">rem</option>
				<option value="vw">vw</option>
				<option value="vh">vh</option>
				<option value="%">%</option>
			</select>';
		}
		
	    $OUT= '';
	    ob_start();
		?>
		
		<!-- THESE ARE MODELS FOR PARAMETER PANELS OF MENU TYPES -->
		
		<!-- DROP-DOWN MENU -->
		<div formenu="navv" class="menu_parms_panel" style="display:none">

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SHOW_MENU_NAME'); ?></label>
			<input parameter="show_menu_name_navv" type="hidden" class="flipyesno" value="0" autocomplete="off" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ANIM_EFFECT'); ?></label>
			<select parameter="animation_effect">
				<option value="fadeToggle" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FADE'); ?></option>
				<option value="slideToggle"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SLIDE'); ?></option>
				<option value="toggle"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SHOW'); ?></option>
				<option value="show(0)"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_NONE'); ?></option>
			</select>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ANIMATION_SPEED'); ?></label>
			<input parameter="animation_speed" type="number" value="300" autocomplete="off" size="3" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SHOW_ARROWS'); ?></label>
			<input parameter="arrows" type="hidden" class="flipyesno" value="0" autocomplete="off" />

			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_DIMENSIONS_PADDING'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MENU_ALIGNMENT'); ?></label>
			<select parameter="drop_down_alignment">
				<option value="left" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LEFT'); ?></option>
				<option value="center"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CENTER'); ?></option>
				<option value="right"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_RIGHT'); ?></option>
			</select>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MENU_HEIGHT'); ?></label>
			<input parameter="drop_down_button_height" type="number" value="30" autocomplete="off" size="3" />
			<?php unitSelector("drop_down_button_height_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MENU_BUTTON_WIDTH'); ?></label>
			<input parameter="drop_down_button_width" type="number" value="0" autocomplete="off" size="3" />
			<?php unitSelector("drop_down_button_width_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_HORIZONTAL_PADDING_FIRST_LEVEL'); ?></label>
			<input parameter="drop_down_button_horiz_padding" type="number" value="15" autocomplete="off" size="3" />
			<?php unitSelector("drop_down_button_horiz_padding_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_DROP_DOWN_PANE_WIDTH'); ?></label>
			<input parameter="drop_down_pane_width" type="number" value="160" autocomplete="off" size="3" />
			<?php unitSelector("drop_down_pane_width_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_DROP_DOWN_PANE_PADDING'); ?></label>
			<input parameter="drop_down_pane_padding" type="number" value="12" autocomplete="off" size="3" />
			<?php unitSelector("drop_down_pane_padding_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SUBITEMS_HEIGHT'); ?></label>
			<input parameter="drop_down_pane_height" type="number" value="25" autocomplete="off" size="3" />
			<?php unitSelector("drop_down_pane_height_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_HORIZONTAL_PADDING_SUBLEVELS'); ?></label>
			<input parameter="drop_down_pane_horiz_padding" type="number" value="10" autocomplete="off" size="3" />
			<?php unitSelector("drop_down_pane_horiz_padding_unit"); ?>

		   	<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SETTINGS'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SETTINGS'); ?></label>
			<input parameter="font_family_hotfont_lbl" type="text" filter="raw" readonly="readonly"  value="Arial, Helvetica, sans-serif" autocomplete="off" />
			<input parameter="font_family_hotfont" json="true" filter="raw" type="hidden" value='{"fontFamily":"Arial, Helvetica, sans-serif","fontWeight":"normal","fontStyle":"normal"}' autocomplete="off" /> 
			<a class="modal btn system menu" title="Select" href="#system" rel="{size: {x: 800, y: 500}, onOpen: initializeForSystem}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SYSTEM_FONTS'); ?></a>	
			<a class="modal btn google menu" title="Select" href="#google" rel="{size: {x: 800, y: 500}, onOpen: initializeForGoogleMenu}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_GOOGLE_FONTS'); ?></a>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SIZE_LBL'); ?></label>
			<input parameter="font_size" type="number" value="14" autocomplete="off" size="3" />
			<?php unitSelector("font_size_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_TEXT_ALIGN_LBL'); ?></label>
			<select parameter="text_align">
				<option value="left" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LEFT'); ?></option>
				<option value="center"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CENTER'); ?></option>
				<option value="right"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_RIGHT'); ?></option>
			</select>
		
			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_COLOR'); ?></label>
			<input parameter="text_color" value="#666666"  class="mini settings minicolors-theme-bootstrap" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ACTIVE_LINK_COLOR'); ?></label>
			<input parameter="active_text_color" value="#ffffff" class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_HOVER_COLOR'); ?></label>
			<input parameter="links_hover_color" value="#dddddd" class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

		   	<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SUBLEVEL_FONT_SETTINGS'); ?></h3>
			
			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SETTINGS'); ?></label>
			<input parameter="font_family_sub_hotfont_lbl" type="text" filter="raw" readonly="readonly"  value="Arial, Helvetica, sans-serif" autocomplete="off" />
			<input parameter="font_family_sub_hotfont" json="true" filter="raw" type="hidden" value='{"fontFamily":"Arial, Helvetica, sans-serif","fontWeight":"normal","fontStyle":"normal"}' autocomplete="off" /> 
			<a class="modal btn system menu" title="Select" href="#system" rel="{size: {x: 800, y: 500}, onOpen: initializeForSystem}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SYSTEM_FONTS'); ?></a>	
			<a class="modal btn google menu" title="Select" href="#google" rel="{size: {x: 800, y: 500}, onOpen: initializeForGoogleMenu}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_GOOGLE_FONTS'); ?></a>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SIZE_LBL'); ?></label>
			<input parameter="font_size_sub" type="number" value="12" autocomplete="off" size="3" />
			<?php unitSelector("font_size_sub_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_COLOR'); ?></label>
			<input parameter="text_color_sub" value="#666666"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_HOVER_COLOR'); ?></label>
			<input parameter="links_hover_color_sub" value="#333333"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

		   	<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BUTTONS_PANES_COLOR'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BUTTON_COLOR'); ?></label>
			<input parameter="button_bg" value="#dddddd"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ACTIVE_BUTTON_COLOR'); ?></label>
			<input parameter="active_button_bg" value="#333333"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BUTTON_HOVER_COLOR'); ?></label>
			<input  parameter="button_hover_bg" value="#666666"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_DROP_DOWN_PANE_BACKGROUND'); ?></label>
			<input parameter="drop_down_pane_bg" value="#eeeeee"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_DROP_DOWN_PANE_HOVER_BACKGROUND'); ?></label>
			<input parameter="drop_down_hover_bg" value="#e6e6e6"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BORDERS'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BORDER_THICKNESS_FIRST_LEVEL'); ?></label>
			<input parameter="border_size_first_lvl" type="number" value="1" autocomplete="off" size="3" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BORDER_COLOR_FIRST_LEVEL'); ?></label>
			<input parameter="border_color_first_lvl" value="#cccccc"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BORDER_THICKNESS_SUBLEVELS'); ?></label>
			<input parameter="border_size_sub_lvl" type="number" value="1" autocomplete="off" size="3" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BORDER_COLOR_SUBLEVELS'); ?></label>
			<input parameter="border_color_sub_lvl" value="#dddddd"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

		</div>
		<!-- END DROP-DOWN MENU -->
		 
		<!-- HORIZONTAL MENU -->
		<div formenu="navh" class="menu_parms_panel" style="display:none">
			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SHOW_MENU_NAME'); ?></label>
			<input parameter="show_menu_name_navh" type="hidden" class="flipyesno" value="0" autocomplete="off" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ANIMATION_SPEED'); ?></label>
			<input parameter="animation_speed" type="number"  value="450" autocomplete="off" size="3" />

			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FIRST_LEVEL'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_HORIZONTAL_PANE_COLOR'); ?></label>
			<input parameter="tab_color" value="#dddddd"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PANE_HEIGHT'); ?></label>
			<input parameter="tab_height" type="number" value="40" autocomplete="off" size="3" />
			<?php unitSelector("tab_height_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_HORIZONTAL_PADDING'); ?></label>
			<input parameter="horiz_button_padding" type="number" value="20" autocomplete="off" size="3" />
			<?php unitSelector("horiz_button_padding_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SETTINGS'); ?></label>
			<input parameter="font_family_hotfont_lbl" type="text" filter="raw" readonly="readonly" value="Arial, Helvetica, sans-serif" autocomplete="off" />
			<input parameter="font_family_hotfont" json="true" filter="raw" type="hidden" value='{"fontFamily":"Arial, Helvetica, sans-serif","fontWeight":"normal","fontStyle":"normal"}' autocomplete="off" /> 
			<a class="modal btn system menu" title="Select" href="#system" rel="{size: {x: 800, y: 500}, onOpen: initializeForSystem}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SYSTEM_FONTS'); ?></a>
			<a class="modal btn google menu" title="Select" href="#google" rel="{size: {x: 800, y: 500}, onOpen: initializeForGoogleMenu}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_GOOGLE_FONTS'); ?></a>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SIZE_LBL'); ?></label>
			<input parameter="font_size" type="number"  value="14" autocomplete="off" size="3" />
			<?php unitSelector("font_size_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_COLOR'); ?></label>
			<input parameter="text_color" value="#333333"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BUTTON_COLOR'); ?></label>
			<input parameter="button_bg" value="#cccccc"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_HOVER_COLOR'); ?></label>
			<input parameter="links_hover_color" value="#000000"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BUTTON_HOVER_COLOR'); ?></label>
			<input parameter="button_hover_bg" value="#aaaaaa"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ACTIVE_LINK_COLOR'); ?></label>
			<input parameter="active_text_color" value="#FFFFFF"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ACTIVE_BUTTON_COLOR'); ?></label>
			<input parameter="active_button_bg" value="#333333"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BORDER_THICKNESS_FIRST_LEVEL'); ?></label>
			<input parameter="border_size_first_lvl" type="number" value="1" autocomplete="off" size="3" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BORDER_COLOR_FIRST_LEVEL'); ?></label>
			<input parameter="border_color_first_lvl" value="#666666"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BORDER_COLOR_ACTIVE_BUTTON'); ?></label>
			<input parameter="border_color_active" value="#333333"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MARGIN'); ?></label>
			<input parameter="margin_size" type="number" value="0" autocomplete="off" size="3" />
			<?php unitSelector("margin_size_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_TOP_BORDER_RADIUS'); ?></label>
			<input parameter="border_radius" type="number" value="0" autocomplete="off" size="3" />
			
			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SECOND_LEVEL'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_HORIZONTAL_PANE_COLOR'); ?></label>
			<input parameter="tab_color_sub" value="#333333" class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PANE_HEIGHT'); ?></label>
			<input parameter="tab_height_sub" type="number" value="25" autocomplete="off" size="3" />
			<?php unitSelector("tab_height_sub_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_HORIZONTAL_PADDING'); ?></label>
			<input parameter="horiz_button_padding_sub" type="number" value="15" autocomplete="off" size="3" />
			<?php unitSelector("horiz_button_padding_sub_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SETTINGS'); ?></label>
			<input parameter="font_family_sub_hotfont_lbl" type="text" filter="raw" readonly="readonly" value="Arial, Helvetica, sans-serif" autocomplete="off" />
			<input parameter="font_family_sub_hotfont" json="true" filter="raw" type="hidden" value='{"fontFamily":"Arial, Helvetica, sans-serif","fontWeight":"normal","fontStyle":"normal"}' autocomplete="off" /> 	
			<a class="modal btn system menu" title="Select" href="#system" rel="{size: {x: 800, y: 500}, onOpen: initializeForSystem}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SYSTEM_FONTS'); ?></a>	
			<a class="modal btn google menu" title="Select" href="#google" rel="{size: {x: 800, y: 500}, onOpen: initializeForGoogleMenu}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_GOOGLE_FONTS'); ?></a>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SIZE_LBL'); ?></label>
			<input parameter="font_size_sub" type="number" value="12" autocomplete="off" size="3" />
			<?php unitSelector("font_size_sub_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SUBMENU_TEXT_COLOR'); ?></label>
			<input parameter="text_color_sub" value="#dddddd"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SUBMENU_TEXT_HOVER_COLOR'); ?></label>
			<input parameter="links_hover_color_sub" value="#ffffff"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_THIRD_LEVEL_DEEPER'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PANE_COLOR'); ?></label>
			<input parameter="tab_color_sub_sub" value="#782320"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PANE_WIDTH'); ?></label>
			<input parameter="tab_width_sub_sub" type="number" value="150" autocomplete="off" size="3" />
			<?php unitSelector("tab_width_sub_sub_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PANE_PADDING'); ?></label>
			<input parameter="horiz_pane_padding_sub_sub" type="number" value="15" autocomplete="off" size="3" />
			<?php unitSelector("horiz_pane_padding_sub_sub_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MENU_ITEM_HEIGHT'); ?></label>
			<input parameter="horiz_pane_menu_item_height_sub_sub" type="number" value="20" autocomplete="off" size="3" />
			<?php unitSelector("horiz_pane_menu_item_height_sub_sub_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SIZE_LBL'); ?></label>
			<input parameter="font_size_sub_sub" type="number"  value="11" autocomplete="off" size="3" />
			<?php unitSelector("font_size_sub_sub_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SUBMENU_TEXT_COLOR'); ?></label>
			<input parameter="text_color_sub_sub" value="#ffffff"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SUBMENU_TEXT_HOVER_COLOR'); ?></label>
			<input parameter="links_hover_color_sub_sub" value="#cccccc"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

		</div>
		<!-- END HORIZONTAL MENU -->
		
		<!-- ACCORDION MENU-->
		<div formenu="acc" class="menu_parms_panel" style="display:none">

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SHOW_MENU_NAME'); ?></label>
			<input parameter="show_menu_name_acc" type="hidden" class="flipyesno" value="0" autocomplete="off" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MENU_COLAPSIBLE'); ?></label>
			<input parameter="collapsible" type="hidden" class="flipyesno" value="1" autocomplete="off" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_EQUAL_HEIGHT_PANES'); ?></label>
			<input parameter="equalheight" type="hidden" class="flipyesno" value="0" autocomplete="off" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_TRIGGER_ACTION'); ?></label>
			<select parameter="trigger" >
				<option value="click" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CLICK'); ?></option>
				<option value="mouseover"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MOUSE_OVER'); ?></option>
			</select>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ANIM_EFFECT'); ?></label>
			<select parameter="animation" >
				<option value="slide" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SLIDE'); ?></option>
				<option value="bounceslide"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BOUNCE_SLIDE'); ?></option>
			</select>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_THIRD_LEVEL_SLIDE'); ?></label>
			<select parameter="subpanelslide">
				<option value="right" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_TO_RIGHT'); ?></option>
				<option value="down"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_DROP'); ?></option>
			</select>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ANIMATION_SPEED'); ?></label>
			<input parameter="animation_speed" type="number"  value="450" autocomplete="off" size="3" />

			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SETTINGS'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SETTINGS'); ?></label>
			<input parameter="font_family_hotfont_lbl" type="text" filter="raw" readonly="readonly" value="Arial, Helvetica, sans-serif" autocomplete="off" />
			<input parameter="font_family_hotfont" json="true" filter="raw" type="hidden" value='{"fontFamily":"Arial, Helvetica, sans-serif","fontWeight":"normal","fontStyle":"normal"}' autocomplete="off" /> 
			<a class="modal btn system menu" title="Select" href="#system" rel="{size: {x: 800, y: 500}, onOpen: initializeForSystem}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SYSTEM_FONTS'); ?></a>
			<a class="modal btn google menu" title="Select" href="#google" rel="{size: {x: 800, y: 500}, onOpen: initializeForGoogleMenu}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_GOOGLE_FONTS'); ?></a>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SIZE_LBL'); ?></label>
			<input parameter="font_size" type="number" value="12" autocomplete="off" size="3" />
			<?php unitSelector("font_size_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_COLOR'); ?></label>
			<input parameter="text_color" value="#FFFFFF"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_HOVER_COLOR'); ?></label>
			<input parameter="links_hover_color" value="#FFFFFF"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SIZE_SUB_LBL'); ?></label>
			<input parameter="font_size_sub" type="number" value="12" autocomplete="off" size="3" />
			<?php unitSelector("font_size_sub_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_COLOR'); ?></label>
			<input parameter="text_color_sub" value="#FFFFFF"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SUBLINKS_HOVER_COLOR'); ?></label>
			<input parameter="links_hover_color_sub" value="#ffffff"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ACCORDION_LAYOUT_STYLE'); ?></h3>
			
			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PANES_BACKGROUND_COLOR'); ?></label>
			<input parameter="accordion_pane_bg" value="#a0deb1" placeholder="#rrggbb" class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false">

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PANES_BORDER_COLOR'); ?></label>
			<input parameter="accordion_pane_border_color" value="#000000"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PANES_BORDER_THICKNESS'); ?></label>
			<input parameter="accordion_pane_border_size" type="number" value="1" autocomplete="off" size="3" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PANES_BORDER_RADIUS'); ?></label>
			<input parameter="accordion_pane_border_radius" type="number" value="5" autocomplete="off" size="3" />

		</div>
		<!-- END ACCORDION MENU -->

		<!-- OFF-CANVAS MENU -->
		<div formenu="offcanvas" class="menu_parms_panel" style="display:none">

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SHOW_MENU_NAME'); ?></label>
			<input parameter="show_menu_name_offcanvas" type="hidden" class="flipyesno" value="0" autocomplete="off" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_POSITION'); ?></label>
			<select parameter="offcanvas_position">
				<option value="left" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LEFT'); ?></option>
				<option value="right"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_RIGHT'); ?></option>
			</select>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_WIDTH'); ?></label>
			<input parameter="offcanvas_width" type="number" value="200" autocomplete="off" size="3" />
			<?php unitSelector("offcanvas_width_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BACKGROUND_COLOR'); ?></label>
			<input parameter="background_color" value="#333333" class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_OVERLAY_BACKGROUND_COLOR'); ?></label>
			<input parameter="overlay_background_color" type="text" value="0,0,0" autocomplete="off" size="10" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_TRANSPARENCY'); ?></label>
			<input parameter="overlay_transparency" type="text" value="0.6" autocomplete="off" size="10" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SETTINGS'); ?></label>
			<input parameter="font_family_hotfont_lbl" type="text" filter="raw" readonly="readonly" value="Arial, Helvetica, sans-serif" autocomplete="off" />
			<input parameter="font_family_hotfont" json="true" filter="raw" type="hidden" value='{"fontFamily":"Arial, Helvetica, sans-serif","fontWeight":"normal","fontStyle":"normal"}' autocomplete="off" /> 
			<a class="modal btn system menu" title="Select" href="#system" rel="{size: {x: 800, y: 500}, onOpen: initializeForSystem}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SYSTEM_FONTS'); ?></a>
			<a class="modal btn google menu" title="Select" href="#google" rel="{size: {x: 800, y: 500}, onOpen: initializeForGoogleMenu}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_GOOGLE_FONTS'); ?></a>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SIZE_LBL'); ?></label>
			<input parameter="font_size" type="number" value="14" autocomplete="off" size="3" />
			<?php unitSelector("font_size_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_COLOR_LBL'); ?></label>
			<input parameter="font_color" value="#cccccc" class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_HOVER_COLOR_LBL'); ?></label>
			<input parameter="font_color_hover" value="#dddddd" class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SIZE_SUB_LBL'); ?></label>
			<input parameter="font_size_sub" type="number" value="12" autocomplete="off" size="3" />
			<?php unitSelector("font_size_sub_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SUBLINKS_COLOR'); ?></label>
			<input parameter="font_color_sub" value="#cccccc" class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SUBLINKS_HOVER_COLOR'); ?></label>
			<input parameter="font_color_sub_hover" value="#dddddd" class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SUBMENU_ANIM_EFFECT'); ?></label>
			<select parameter="animation_effect">
				<option value="fadeToggle"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FADE'); ?></option>
				<option value="slideToggle" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SLIDE'); ?></option>
				<option value="toggle"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SHOW'); ?></option>
				<option value="show(0)"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_NONE'); ?></option>
			</select>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ANIMATION_SPEED'); ?></label>
			<input parameter="animation_speed" type="number" value="300" autocomplete="off" size="3" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CONTENT_BEFORE_MENU'); ?></label>
			<textarea parameter="content_before_menu" type="textarea" cols="50" rows="3" value="" autocomplete="off" filter="raw"></textarea>
			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CONTENT_AFTER_MENU'); ?></label>
			<textarea parameter="content_after_menu" type="textarea" cols="50" rows="3" value="" autocomplete="off" filter="raw"></textarea>

		</div>

		<!-- MEGA MENU -->
		<div formenu="mega" class="menu_parms_panel" style="display:none">

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SHOW_MENU_NAME'); ?></label>
			<input parameter="show_menu_name_mega" type="hidden" class="flipyesno" value="0" autocomplete="off" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ANIMATION_SPEED'); ?></label>
			<input parameter="animation_speed" type="number" value="300" autocomplete="off" size="3" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FADE'); ?></label>
			<input parameter="fade" type="hidden" class="flipyesno" value="1" autocomplete="off" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SLIDE'); ?></label>
			<input parameter="slide" type="hidden" class="flipyesno" value="1" autocomplete="off" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SHOW_ARROWS'); ?></label>
			<input parameter="arrows" type="hidden" class="flipyesno" value="0" autocomplete="off" />

			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_DIMENSIONS_PADDING'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MAXIMUM_COLUMNS'); ?></label>
			<select parameter="max_columns" style="width:60px;">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4" selected="selected">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
			</select>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MENU_ALIGNMENT'); ?></label>
			<select parameter="alignment">
				<option value="left" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LEFT'); ?></option>
				<option value="center"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CENTER'); ?></option>
				<option value="right"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_RIGHT'); ?></option>
			</select>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MENU_BUTTON_WIDTH'); ?></label>
			<input parameter="main_level_width" type="number" value="0" autocomplete="off" size="3" />
			<?php unitSelector("main_level_width_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MENU_BAR_HEIGHT'); ?></label>
			<input parameter="bar_height" type="number" value="30" autocomplete="off" size="3" />
			<?php unitSelector("bar_height_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_HORIZONTAL_PADDING'); ?></label>
			<input parameter="horizontal_padding" type="number" value="10" autocomplete="off" size="3" />
			<?php unitSelector("horizontal_padding_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_DROP_DOWN_PANE_WIDTH'); ?> (px)</label>
			<input parameter="mega_pane_width" type="number" value="160" autocomplete="off" size="3" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_DROP_DOWN_PANE_PADDING'); ?></label>
			<input parameter="mega_pane_padding" type="number" value="12" autocomplete="off" size="3" />
			<?php unitSelector("mega_pane_padding_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SUBITEMS_HEIGHT'); ?></label>
			<input parameter="subitems_height" type="number" value="25" autocomplete="off" size="3" />
			<?php unitSelector("subitems_height_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SUBSUBITEMS_HEIGHT'); ?></label>
			<input parameter="sub_subitems_height" type="number" value="20" autocomplete="off" size="3" />
			<?php unitSelector("sub_subitems_height_unit"); ?>

			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FIRST_LEVEL'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SETTINGS'); ?></label>
			<input parameter="font_family_hotfont_lbl" type="text" filter="raw" readonly="readonly"  value="Arial, Helvetica, sans-serif" autocomplete="off" />
			<input parameter="font_family_hotfont" json="true" filter="raw" type="hidden" value='{"fontFamily":"Arial, Helvetica, sans-serif","fontWeight":"normal","fontStyle":"normal"}' autocomplete="off" /> 
			<a class="modal btn system menu" title="Select" href="#system" rel="{size: {x: 800, y: 500}, onOpen: initializeForSystem}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SYSTEM_FONTS'); ?></a>	
			<a class="modal btn google menu" title="Select" href="#google" rel="{size: {x: 800, y: 500}, onOpen: initializeForGoogleMenu}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_GOOGLE_FONTS'); ?></a>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SIZE_LBL'); ?></label>
			<input parameter="font_size" type="number" value="14" autocomplete="off" size="3" />
			<?php unitSelector("font_size_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_TEXT_ALIGN_LBL'); ?></label>
			<select parameter="text_align">
				<option value="left"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LEFT'); ?></option>
				<option value="center" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CENTER'); ?></option>
				<option value="right"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_RIGHT'); ?></option>
			</select>
		
			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_COLOR'); ?></label>
			<input parameter="text_color" value="#666666"  class="mini settings minicolors-theme-bootstrap" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ACTIVE_LINK_COLOR'); ?></label>
			<input parameter="active_text_color" value="#ffffff" class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_HOVER_COLOR'); ?></label>
			<input parameter="links_hover_color" value="#dddddd" class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SECOND_LEVEL'); ?></h3>
			
			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SETTINGS'); ?></label>
			<input parameter="font_family_sub_hotfont_lbl" type="text" filter="raw" readonly="readonly"  value="Arial, Helvetica, sans-serif" autocomplete="off" />
			<input parameter="font_family_sub_hotfont" json="true" filter="raw" type="hidden" value='{"fontFamily":"Arial, Helvetica, sans-serif","fontWeight":"normal","fontStyle":"normal"}' autocomplete="off" /> 
			<a class="modal btn system menu" title="Select" href="#system" rel="{size: {x: 800, y: 500}, onOpen: initializeForSystem}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SYSTEM_FONTS'); ?></a>	
			<a class="modal btn google menu" title="Select" href="#google" rel="{size: {x: 800, y: 500}, onOpen: initializeForGoogleMenu}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_GOOGLE_FONTS'); ?></a>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SIZE_LBL'); ?></label>
			<input parameter="font_size_sub" type="number" value="12" autocomplete="off" size="3" />
			<?php unitSelector("font_size_sub_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_TEXT_ALIGN_LBL'); ?></label>
			<select parameter="sub_text_align">
				<option value="left" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LEFT'); ?></option>
				<option value="center"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CENTER'); ?></option>
				<option value="right"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_RIGHT'); ?></option>
			</select>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_COLOR'); ?></label>
			<input parameter="text_color_sub" value="#666666"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_HOVER_COLOR'); ?></label>
			<input parameter="links_hover_color_sub" value="#333333"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_THIRD_LEVEL'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SETTINGS'); ?></label>
			<input parameter="font_family_sub_sub_hotfont_lbl" type="text" filter="raw" readonly="readonly"  value="Arial, Helvetica, sans-serif" autocomplete="off" />
			<input parameter="font_family_sub_sub_hotfont" json="true" filter="raw" type="hidden" value='{"fontFamily":"Arial, Helvetica, sans-serif","fontWeight":"normal","fontStyle":"normal"}' autocomplete="off" /> 
			<a class="modal btn system menu" title="Select" href="#system" rel="{size: {x: 800, y: 500}, onOpen: initializeForSystem}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SYSTEM_FONTS'); ?></a>	
			<a class="modal btn google menu" title="Select" href="#google" rel="{size: {x: 800, y: 500}, onOpen: initializeForGoogleMenu}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_GOOGLE_FONTS'); ?></a>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SIZE_LBL'); ?></label>
			<input parameter="font_size_sub_sub" type="number" value="12" autocomplete="off" size="3" />
			<?php unitSelector("font_size_sub_sub_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_TEXT_ALIGN_LBL'); ?></label>
			<select parameter="sub_sub_text_align">
				<option value="left" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LEFT'); ?></option>
				<option value="center"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CENTER'); ?></option>
				<option value="right"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_RIGHT'); ?></option>
			</select>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_COLOR'); ?></label>
			<input parameter="text_color_sub_sub" value="#666666" class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_HOVER_COLOR'); ?></label>
			<input parameter="links_hover_color_sub_sub" value="#333333" class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BUTTONS_PANES_COLOR'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BUTTON_COLOR'); ?></label>
			<input parameter="button_bg" value="#dddddd"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ACTIVE_BUTTON_COLOR'); ?></label>
			<input parameter="active_button_bg" value="#333333"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BUTTON_HOVER_COLOR'); ?></label>
			<input  parameter="button_hover_bg" value="#666666"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_DROP_DOWN_PANE_BACKGROUND'); ?></label>
			<input parameter="mega_pane_bg" value="#eeeeee"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BORDERS'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BORDER_THICKNESS_FIRST_LEVEL'); ?></label>
			<input parameter="border_size_first_lvl" type="number" value="1" autocomplete="off" size="3" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BORDER_COLOR_FIRST_LEVEL'); ?></label>
			<input parameter="border_color_first_lvl" value="#cccccc"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PANE_BORDER_THICKNESS'); ?></label>
			<input parameter="pane_border_size" type="number" value="1" autocomplete="off" size="3" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PANE_BORDER_COLOR'); ?></label>
			<input parameter="pane_border_color" value="#dddddd"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_HORIZONTAL_BORDER_THICKNESS_SUBLEVELS'); ?></label>
			<input parameter="border_size_horiz_sub_lvl" type="number" value="1" autocomplete="off" size="3" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_HORIZONTAL_BORDER_COLOR_SUBLEVELS'); ?></label>
			<input parameter="border_color_horiz_sub_lvl" value="#dddddd"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MOBILE_OPTIONS'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_DROP_DOWN_PANE_WIDTH'); ?> (px)</label>
			<input parameter="mega_pane_width_mobile" type="number" value="160" autocomplete="off" size="3" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SHOW_MODULES'); ?></label>
			<input parameter="modules_mobile" type="hidden" class="flipyesno" value="1" autocomplete="off" />

		</div>
		
		<!-- JOOMLA STANDARD MENU -->
		<div formenu="standard" class="menu_parms_panel" style="display:none">
		    
		    <label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SHOW_MENU_NAME'); ?></label>
			<input parameter="show_menu_name_standard" type="hidden" class="flipyesno" value="0" autocomplete="off" />

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MENU_ORIENTATION'); ?></label>
			<select parameter="direction">
				<option value="vertical" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_VERTICAL'); ?></option>
				<option value="horizontal"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_HORIZONTAL'); ?></option>
			</select> 
			
			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MAIN_LEVEL'); ?></h3>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SETTINGS'); ?></label>
			<input parameter="font_family_hotfont_lbl" type="text" filter="raw" readonly="readonly" value="Arial, Helvetica, sans-serif" autocomplete="off" />
			<input parameter="font_family_hotfont" json="true" filter="raw" type="hidden" value='{"fontFamily":"Arial, Helvetica, sans-serif","fontWeight":"normal","fontStyle":"normal"}' autocomplete="off" /> 
			<a class="modal btn system menu" title="Select" href="#system" rel="{size: {x: 800, y: 500}, onOpen: initializeForSystem}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SYSTEM_FONTS'); ?></a>
			<a class="modal btn google menu" title="Select" href="#google" rel="{size: {x: 800, y: 500}, onOpen: initializeForGoogleMenu}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_GOOGLE_FONTS'); ?></a>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SIZE_LBL'); ?></label>
			<input parameter="font_size" type="number" value="14" autocomplete="off" size="3" />
			<?php unitSelector("font_size_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_TEXT_ALIGN_LBL'); ?></label>
			<select parameter="text_align">
				<option value="left" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LEFT'); ?></option>
				<option value="center"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CENTER'); ?></option>
				<option value="right"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_RIGHT'); ?></option>
			</select>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_COLOR'); ?></label>
			<input parameter="text_color" value="#666666"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_HOVER_COLOR'); ?></label>
			<input parameter="links_hover_color" value="#333333"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_VERTICAL_PADDING'); ?></label>
			<input parameter="vertical_padding" type="number" value="5" autocomplete="off" size="3" />
			<?php unitSelector("vertical_padding_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_HORIZONTAL_PADDING'); ?></label>
			<input parameter="horizontal_padding" type="number" value="0" autocomplete="off" size="3" />
			<?php unitSelector("horizontal_padding_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BOTTOM_MARGIN'); ?></label>
			<input parameter="bottom_margin" type="number" value="5" autocomplete="off" size="3" />
			<?php unitSelector("bottom_margin_unit"); ?>

			<h3><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SUBLEVELS'); ?></h3>
			
			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SETTINGS'); ?></label>
			<input parameter="font_family_sub_hotfont_lbl" type="text" filter="raw" readonly="readonly" value="Arial, Helvetica, sans-serif" autocomplete="off" />
			<input parameter="font_family_sub_hotfont" json="true" filter="raw" type="hidden" value='{"fontFamily":"Arial, Helvetica, sans-serif","fontWeight":"normal","fontStyle":"normal"}' autocomplete="off" /> 
			<a class="modal btn system menu" title="Select" href="#system" rel="{size: {x: 800, y: 500}, onOpen: initializeForSystem}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SYSTEM_FONTS'); ?></a>
			<a class="modal btn google menu" title="Select" href="#google" rel="{size: {x: 800, y: 500}, onOpen: initializeForGoogleMenu}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_GOOGLE_FONTS'); ?></a>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FONT_SIZE_LBL'); ?></label>
			<input parameter="font_size_sub" type="number" value="11" autocomplete="off" size="3" />
			<?php unitSelector("font_size_sub_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_TEXT_ALIGN_LBL'); ?></label>
			<select parameter="text_align_sub">
				<option value="left" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LEFT'); ?></option>
				<option value="center"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CENTER'); ?></option>
				<option value="right"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_RIGHT'); ?></option>
			</select>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_COLOR'); ?></label>
			<input parameter="text_color_sub" value="#782320"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LINK_HOVER_COLOR'); ?></label>
			<input parameter="links_hover_color_sub" value="#333333"  class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MARGIN'); ?></label>
			<input parameter="margin_sub" type="number" value="10" autocomplete="off" size="3" />
			<?php unitSelector("margin_sub_unit"); ?>

			<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MENU_ITEM_HEIGHT'); ?></label>
			<input parameter="subitem_height" type="number" value="15" autocomplete="off" size="3" />
			<?php unitSelector("subitem_height_unit"); ?>

		</div>
		<!-- END JOOMLA STANDARD MENU -->
		
		<!-- PARAMETER PANELS END -->
		
	    <input type="hidden" name="<?php echo $this->name; ?>" id="<?php echo $this->id; ?>" value="" />
		<script type="text/javascript">
		    var mcfg = <?php echo $this->value ? $this->value : "[]"; ?>;
			var current = mcfg;
			jQuery("#<?php echo $this->id; ?>").val(JSON.stringify(mcfg));
		</script>
		<div id="mnupanel<?php echo $this->id; ?>">
			<p><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MENU_NAME_CLICK'); ?></p>

			<?php
		
			// get template options from DB
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select($db->quoteName('params'));
			$query->from($db->quoteName('#__template_styles'));
			$query->where($db->quoteName('template') . ' LIKE '. $db->quote($template_name));
			$db->setQuery($query);
			$mnucfg = $db->loadResult();

			// decode menus options
			$mnucfg = json_decode($mnucfg, "[]");
			$mnu_load = json_decode($mnucfg['mnucfg'], "[]");

			if(isset($mnu_load)) {
				foreach($mnu_load as $mnu){
					$mnu_name = $mnu['name'];
					$mnu_type = $mnu['type'];
					$current_menu_type[$mnu_name] = $mnu_type;
				}
			}

			$menuTypes2 = $menuTypes;

			// this loop will create $menu_name array with menu names
			foreach ($menuTypes as $menutype) {
				// Get title of the menu from db per menutype
				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->select($db->quoteName('title'));
				$query->from($db->quoteName('#__menu_types'));
				$query->where($db->quoteName('menutype') . ' LIKE '. $db->quote($menutype));
				$db->setQuery($query);
				$menu_name[$menutype] = $db->loadResult();
			}

			// this loop will list each menu as <option>
			foreach ($menuTypes as $menutype) {
			?>

			<h4 class="menusSettingsTab"><?php echo $menu_name[$menutype]; ?></h4>
			<div class="menusSettingsContainer">

				<span class="menus_graphics"></span>
				<select menu="<?php echo $menutype;?>" class="MenuTypeSelect">
					<option value="acc"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ACCORDION_MENU');?></option>
					<option value="standard"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CLASSIC_MENU');?></option>
					<option value="navv"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_DROPDOWN_MENU');?></option>
					<option value="navh"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_HORIZONTAL_MENU');?></option>
					<option value="mega"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MEGA_MENU');?></option>
					<option value="offcanvas"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_OFFCANVAS_MENU');?></option>
					<option value="none"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_NONE');?></option>
					<option disabled selected value> --------------------------------- </option>
					<?php
					foreach ($menuTypes2 as $menutype2) {

						$findme = 'copy_';
						$pos = strpos($current_menu_type[$menutype2], $findme);

						if($menutype2 != $menutype && $pos !== 0 ){
						?>
						<option value="copy_<?php echo $menutype2;?>">Copy from <?php echo $menu_name[$menutype2]; ?></option>	
						<?php	
						}
					}
					?>
				</select>

				<div class="menusSettingsField"></div>
				<div class="clr"></div>
			</div>
		<?php
		}
		?>
		</div>

	    <script type="text/javascript">
			var current_menu_clicked;
			jQuery(document).ready(function(){
				jQuery(document).on("click",".MenuTypeSelect.chzn-done",function(){
					current_menu_clicked = jQuery(this).attr("menu");
				});
			});
			window.setTimeout(function(){ 
				window.loadMenuPanel<?php echo $this->id; ?> = function(fobject,menu_type,sparms) {
				    if(!menu_type){
						menu_type = fobject.val();  
					}
					var from_copy = false;
					var panel = fobject.parent().find('DIV').first();
					var real_menu_type = "";
					var real_menu = "";
					if(menu_type.indexOf("copy") > -1){

						if(menu_type.indexOf(' ') > -1)
							real_menu = menu_type.substring(5, menu_type.indexOf(' '));
						else
							real_menu = menu_type.substr(5);
						
						for(var k = 0; k < current.length ; k++){
							if(current[k].name == real_menu)
								break;	
						}
						real_menu_type = current[k].type;
					
						if(real_menu_type.indexOf("copy") > -1)
						{
						
							from_copy = true;
						}
						sparms = current[k].config;
					}
					else
						real_menu_type  = menu_type;
					
					
					if(!jQuery('.menu_parms_panel[formenu="' + real_menu_type + '"]')[0] || real_menu == current_menu_clicked || from_copy) {
		
						panel.html("");
						if(!(menu_type.indexOf("copy") > -1))
							fobject.val("none");
						return;	
					}
			
					panel.html(jQuery('.menu_parms_panel[formenu="' + real_menu_type + '"]').html());
				 
				 
					if(menu_type.indexOf("copy") > -1)
						panel.css("display","none");
					else
						panel.css("display","inline-block");
				 
					try{

						if(!sparms){
							sparms = window.getMenuParms<?php echo $this->id; ?>(fobject);
						}
						var mnu_parms = (typeof sparms === 'object') ? sparms : eval("(" + sparms + ")");
						
						for(var prop in mnu_parms){
						   if(mnu_parms.hasOwnProperty(prop)){
							   panel.find('*[parameter="'+ prop +'"]').val(mnu_parms[prop]);
						   } 	
						}
			

					}catch(e){}	
	            
					panel.find('.flipyesno').each(function(ind){
					    window.createFlipYesNo(jQuery(this));
				    });
				
				};

	        	window.getMenuParms<?php echo $this->id; ?> = function(fobject){
					var panel = fobject.parent().find('DIV').first();
					var sparms = {};
	            	panel.find('select, input, textarea').each(function(IndP){
					   sparms[jQuery(this).attr('parameter')] = jQuery(this).val();
					   
					});            
	  				return sparms;
				};  

				window.lastsaveMenuParmsTime = 0;
				
	        	window.saveMenuParms<?php echo $this->id; ?> = function(){
					
					if(window.lastsaveMenuParmsTime + 200 > new Date().getTime())
						return;
					
					window.lastsaveMenuParmsTime = new Date().getTime();
					
					var newVal = [];
					
			        jQuery("#mnupanel<?php echo $this->id; ?> .MenuTypeSelect").each(function(ind){
						
						var mnu    = {};
						mnu.name   = jQuery(this).attr("menu");
						mnu.type   = jQuery(this).val();

						if(mnu.type.indexOf("copy") > -1){
						
						}
						else{
							mnu.config = window.getMenuParms<?php echo $this->id; ?>(jQuery(this));
							newVal.push(mnu);
						}
						
					});
					
					jQuery("#mnupanel<?php echo $this->id; ?> .MenuTypeSelect").each(function(ind){
						
						var mnu    = {};
						mnu.name   = jQuery(this).attr("menu");
						mnu.type   = jQuery(this).val();
						if(mnu.type.indexOf("copy") > -1){
							
							if(mnu.type.indexOf(' ') > -1)
								var real_menu = mnu.type.substring(5,mnu.type.indexOf(' '));
							else
								var real_menu = mnu.type.substr(5);
							
							for(var k = 0; k < newVal.length ; k++){
								if(newVal[k].name == real_menu)
									break;	
							}	
							mnu.type += " "+newVal[k].type;
							mnu.config = newVal[k].config;
							newVal.push(mnu);
						}
						
					});
					
					current = newVal;
					
			        jQuery("#<?php echo $this->id; ?>").val( JSON.stringify( newVal ))  ;
				};		

                window.save_menu_cfg_fn = window.saveMenuParms<?php echo $this->id; ?>; 				
			  
				jQuery("#mnupanel<?php echo $this->id; ?> .MenuTypeSelect").each(function(indx){
					window.loadMenuPanel<?php echo $this->id; ?>(jQuery(this),'none',null);
				});
			  
	        	var vals = mcfg;
				for(var i = 0; i < vals.length ; i++){
					
					var mnu       = vals[i].name;
					var mnu_val   = vals[i].type;
					if(mnu_val == "") mnu_val = "standard";
					var config = vals[i].config;
					
					var real_menu = "";
					
					if(vals[i].type.indexOf("copy") > -1){
		
						if(vals[i].type.indexOf(' ') > -1)
							real_menu = vals[i].type.substring(5, vals[i].type.indexOf(' '));
						else
							real_menu = vals[i].type.substr(5);
						
						for(var k = 0; k < vals.length ; k++){
							if(vals[k].name == real_menu)
								break;	
						}
						
						config = vals[k].config;
					}
					
					var fobject = jQuery('#mnupanel<?php echo $this->id; ?> select[menu="' + mnu + '"]');
					if(mnu_val.indexOf(' ') > -1)
						fobject.val(mnu_val.substring(0, mnu_val.indexOf(' ')));
					else
						fobject.val(mnu_val);
					
					window.loadMenuPanel<?php echo $this->id; ?>(fobject,mnu_val,config);
				}
				

				jQuery("#mnupanel<?php echo $this->id; ?> .MenuTypeSelect").change(function(){
					window.loadMenuPanel<?php echo $this->id; ?>(jQuery(this),null,null);   				
				});
				
				window.setInterval(function(){
					window.saveMenuParms<?php echo $this->id; ?>();
				},200);
				
	 
			},150);
	  	</script>

		<?php
		$OUT = ob_get_contents();
        ob_end_clean();		
        
		return $OUT;
	}
}

?>
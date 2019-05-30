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
JHtml::_('behavior.modal', 'a.modal');
/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldDesignLayout extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'designlayout';
	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		global $TEMPLATE_FOLDER;

		/* GET IMAGES */
		
		$directory = '/templates/'.$TEMPLATE_FOLDER.'/images/';
		
		$extensions = "bmp|gif|jpg|png";
		if (!$directory)
		{
			$directory = '/images/';
		}
		$imageFiles = new DirectoryIterator(JPATH_SITE . '/' . $directory);
		$images = array();
		foreach ($imageFiles as $file)
		{
			$fileName = $file->getFilename();
			if (!$file->isFile())
			{
				continue;
			}
			if (preg_match('#(' . $extensions . ')$#', $fileName))
			{
				$images[] = $fileName;
			}
		}
		
        $OUT= '';
	    ob_start();
		$replaced=str_replace("\"","&#34;",$this->value); 
		$replaced = str_replace("'","&#39;",$replaced); 
		?>
		<div id="layoutdesigner<?php echo $this->id; ?>">
			<input type="hidden" name="<?php echo $this->name; ?>" id="<?php echo $this->id; ?>" value="<?php echo $replaced; ?>" />
			<table class="layoutDesigner">
				<tr>
					<td class="ui-state-default" style="background-position: 50% 0;">
		    			<ul class="toolBox">
	        				<li class="edit_row" id="layout_addRow" style="background-position: 50% 0;">
								<span class="caption"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ADD_ROW') ;?></span>
 			    				<table cellpadding="0" cellspacing="0">
									<tr>
                						<td>	
				    						<table cellpadding="0" cellspacing="0">
				    							<tr>
													<td>
														<a class="modal btn settings nice_button" title="Select" href="#layout_settings" rel="{size: {x: 600, y: 500}, onOpen: initializeForSettings}"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_SETTINGS') ;?></a>
                    								</td>
												</tr>
				    							<tr>
				    								<td>
				    									<a class="deleteRow btn nice_button" href="#" class="deleteRow"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_DELETE') ;?></a>
				    								</td>													
				    							</tr>
											</table>
										</td>
										<td>
											<div class="layout_row_container">
	                    						<ul class="layout_row">
	                    						</ul>
	                    						
                							</div>					
										</td>
									</tr>
								</table>
							</li>
							<li class="ui-state-default" style="background-position: 50% 0;">
			    				<span class="caption"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_UNASSIGNED_MODULE_POSITIONS'); ?></span>
			    				<ul class="unassignedPositions drag_module_positions" >
									<?php
										global $tadmin_mpos;
										global $tadmin_menus;
										// listing of CONTENT on Layout builder
										echo '<li wX="1" off="0" mp="joom_content" class="mpos_draggable cpos"><span>'.jText::sprintf('TPL_SPARKY_FRAMEWORK_CONTENT_BOX').'</span><div class="clr"></div><a title="Move left" href="javascript:void(0);" class="off_left"></a><a title="Move right" href="javascript:void(0);" class="off_right"></a><a class="remove_block" href="#">&times;</a></li>';
										// listing of all module positions and sparky elements on Layout builder
										foreach($tadmin_mpos as $mpos){
											if ($mpos != "abovecontent" && $mpos != "belowcontent" && strpos($mpos, "megamenu") === false) {
										  		echo '<li wX="1" off="0" mp="'.$mpos.'" class="mpos_draggable '.$mpos.'"><span>'.$mpos.'</span><div class="clr"></div><a title="Move left" href="javascript:void(0);" class="off_left"></a><a title="Move right" href="javascript:void(0);" class="off_right"></a><a class="remove_block" href="#">&times;</a></li>';
											}
										}
										// listing of menus on Layout builder
										foreach($tadmin_menus as $mpos){
										  	echo '<li wX="1" off="0" mp="'.$mpos.'" class="mpos_draggable sparky_menu '.$mpos.'"><span>'.$mpos.'</span><div class="clr"></div><a title="Move left" href="javascript:void(0);" class="off_left"></a><a title="Move right" href="javascript:void(0);" class="off_right"></a><a class="remove_block" href="#">&times;</a></li>';
										}				
								    ?>
								</ul>
							</li>
            			</ul>
					</td>
				</tr>
				<tr>
					<td>
						<div class="LayoutModel">
							<ul id="sortable">
							</ul>
						</div>
						<div class="sparky_legend"><span class="cpos"></span> <?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MAIN_CONTENT'); ?> <span class="modulepositions"></span> <?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MODULE_POSITIONS'); ?> <span class="sparky_menu"></span> <?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MENUS_LEGEND'); ?> <span class="sparkyfeatures"></span> <?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SPARKY_FEATURES'); ?></div>
					</td>
				</tr>
			</table>
			<div style="display: none;">
				<div id="layout_settings">
				<div class="layout_settings no_undo">

					<div class="control-label">
						<div class="hotspacer">
							<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_PROPERTIES'); ?></label>
						</div>
					</div>

					<div class="control-group">
						<div class="control-label">
							<label id="ContainerType-lbl" for="ContainerType" class="hasTooltip" title="" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_CONTAINER_TYPE_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_CONTAINER_TYPE_DESC'); ?>">
							<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_CONTAINER_TYPE_LBL'); ?></label>
						</div>
						<div class="controls">
							<select id="ContainerType" name="jform[params][ContainerType]" class="chzn-done container_type" style="display: none;">
								<option value="div" selected="selected">div</option>
								<option value="header">header</option>
								<option value="section">section</option>
								<option value="aside">aside</option>
								<option value="footer">footer</option>
							</select>
							<div class="chzn-container chzn-container-single chzn-container-single-nosearch" style="width: 224px;" title="" id="containerType_chzn"><a class="chzn-single" tabindex="-1"><span>div</span></a></div>
						</div>
						<div style="clear:both;"></div>
					</div>

					<div class="control-group">
						<div class="control-label">
							<label class="hasTooltip" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_NAME_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_NAME_DESC'); ?>"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_NAME_LBL'); ?></label>
						</div>
						<div class="controls">
							<input type="text" class="settings_name">
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label">
							<label class="hasTooltip" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CLASS_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CLASS_DESC'); ?>"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CLASS_LBL'); ?></label>
						</div>
						<div class="controls">
							<input type="text" class="settings_class">
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label">
							<label class="hasTooltip" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_HEADING_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_HEADING_DESC'); ?>"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_HEADING_LBL'); ?></label>
						</div>
						<div class="controls">
							<input type="text" class="settings_heading">
						</div>
					</div>

					<div class="control-group">
						<div class="control-label">
							<label class="hasTooltip" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_SUBHEADING_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_SUBHEADING_DESC'); ?>"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_SUBHEADING_LBL'); ?></label>
						</div>
						<div class="controls">
							<input type="text" class="settings_subheading">
						</div>
					</div>

					<div class="control-group">
						<div class="control-label">
							<label id="full_width-lbl" for="full_width" class="hasTooltip" title="" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FULL_WIDTH_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FULL_WIDTH_DESC'); ?>">
							<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FULL_WIDTH_LBL'); ?></label>
						</div>
						<div class="controls">		
							<input type="hidden" name="jform[params][full_width]" id="full_width" value="0" class="flipyesno full" flipcreated="0">
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label">
							<label id="floating-lbl" for="floating" class="hasTooltip" title="" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FLOATING_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FLOATING_DESC'); ?>">
							<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FLOATING_LBL'); ?></label>
						</div>
						<div class="controls">		
							<input type="hidden" name="jform[params][floating]" id="floating" value="0" class="flipyesno floating" flipcreated="0">
						</div>
					</div>

					<div class="control-group">
						<div class="control-label">
							<label id="no_collapse-lbl" for="no_collapse" class="hasTooltip" title="" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_NO_COLLAPSE_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_NO_COLLAPSE_DESC'); ?>">
							<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_NO_COLLAPSE_LBL'); ?></label>
						</div>
						<div class="controls">		
							<input type="hidden" name="jform[params][no_collapse]" id="no_collapse" value="0" class="flipyesno collapse" flipcreated="0">
						</div>
					</div>

					<div class="control-group">
						<div class="control-label">
							<label id="EqualCellsWidth-lbl" for="EqualCellsWidth" class="hasTooltip" title="" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_EQUAL_WIDTH_CELLS_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_EQUAL_WIDTH_CELLS_DESC'); ?>">
								<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_EQUAL_WIDTH_CELLS_LBL'); ?></label>
						</div>
						<div class="controls">	
							<input type="hidden" id="EqualCellsWidth" value="0" class="flipyesno equal_cells_width" flipcreated="0">
						</div>
						<div style="clear:both;"></div>
					</div>
					
					<div class="control-label">
						<div class="hotspacer">
							<label><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_BACKGROUND'); ?></label>
						</div>
					</div>

					<div class="control-group">
						<div class="control-label">
							<label   class="hasTooltip" title="" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_BACKGROUND_COLOR'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_COLOR_DESC'); ?>">
							<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ROW_BACKGROUND_COLOR'); ?></label>
						</div>
						<div class="controls">			
							<input parameter="active_text_color" for_settings="1" id="BgColor" value="#ffffff" class="mini settings" data-position="right" data-control="hue" size="7" maxlength="7" aria-invalid="false"/>
						</div>
					<div style="clear:both;"></div>
					</div>
					
					<div class="control-group">
						<div class="control-label">
							<label  class="hasTooltip" title="" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_IMAGE_SELECT_DESC'); ?>">
								<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_LBL'); ?></label>
						</div>
						<div class="controls">
							<select class="settings_image">
								<option value=""><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_NONE_SELECTED'); ?></option>
								<?php foreach($images as $img){?>
								<option value="<?php echo $img; ?>"><?php echo $img ?></option>
								<?php }?>
							</select>
							<div class="image_preview">
								<span title=""><span class="icon-eye"></span></span>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div>
			
					<div class="control-group">
						<div class="control-label">
							<label id="BgImageVerticalAlign-lbl" for="BgImageVerticalAlign" class="hasTooltip" title="" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_VERTICAL_ALIGN_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_VERTICAL_ALIGN_DESC'); ?>">
							<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_VERTICAL_ALIGN_LBL'); ?></label>
						</div>
						<div class="controls">
							<select id="BgImageVerticalAlign" name="jform[params][BgImageVerticalAlign]" class="chzn-done vertical_align" style="display: none;">
								<option value="top" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_TOP'); ?></option>
								<option value="center"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CENTER'); ?></option>
								<option value="bottom"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BOTTOM'); ?></option>
							</select>
							<div class="chzn-container chzn-container-single chzn-container-single-nosearch" style="width: 224px;" title="" id="BgImageVerticalAlign_chzn"><a class="chzn-single" tabindex="-1"><span><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CENTER'); ?></span><div><b></b></div></a><div class="chzn-drop"><div class="chzn-search"><input type="text" autocomplete="off" readonly=""></div><ul class="chzn-results"><li class="active-result result-selected" style="" data-option-array-index="0"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_TOP'); ?></li><li class="active-result result-selected" style="" data-option-array-index="1"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CENTER'); ?></li><li class="active-result" style="" data-option-array-index="2"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BOTTOM'); ?></li></ul></div></div>
						</div>
						<div style="clear:both;">
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label">
							<label id="BgImageHorizontalAlign-lbl" for="BgImageHorizontalAlign" class="hasTooltip" title="" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_HORIZONTAL_ALIGN_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_HORIZONTAL_ALIGN_DESC'); ?>">
							<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_HORIZONTAL_ALIGN_LBL'); ?></label>
						</div>
						<div class="controls">
							<select id="BgImageHorizontalAlign" name="jform[params][BgImageHorizontalAlign]" class="chzn-done horizontal_align" style="display: none;">
								<option value="left"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_LEFT'); ?></option>
								<option value="center" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CENTER'); ?></option>
								<option value="right"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_RIGHT'); ?></option>
							</select>
							<div class="chzn-container chzn-container-single chzn-container-single-nosearch" style="width: 224px;" title="" id="BgImageHorizontalAlign_chzn"><a class="chzn-single" tabindex="-1"><span><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CENTER'); ?></span><div><b></b></div></a><div class="chzn-drop"><div class="chzn-search"><input type="text" autocomplete="off" readonly=""></div><ul class="chzn-results"></ul></div></div>
						</div>
						<div style="clear:both;"></div>
					</div>
					
					<div class="control-group">
						<div class="control-label">
							<label id="BgImageRepeat-lbl" for="BgImageRepeat" class="hasTooltip" title="" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_REPEAT_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_REPEAT_DESC'); ?>">
							<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_REPEAT_LBL'); ?></label>
						</div>
						<div class="controls">
							<select id="BgImageRepeat" name="jform[params][BgImageRepeat]" class="chzn-done image_repeat" style="display: none;">
								<option value="repeat" selected="selected"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_REPEAT_REPEAT_LBL'); ?></option>
								<option value="repeat-x"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_REPEAT_REPEAT_HORIZONTALLY_LBL'); ?></option>
								<option value="repeat-y"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_REPEAT_REPEAT_VERTICALLY_LBL'); ?></option>
								<option value="no-repeat"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_REPEAT_NO_REPEAT_LBL'); ?></option>
							</select>
							<div class="chzn-container chzn-container-single chzn-container-single-nosearch" style="width: 224px;" title="" id="bodyBgImageRepeat_chzn"><a class="chzn-single" tabindex="-1"><span><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BG_IMAGE_REPEAT_REPEAT_HORIZONTALLY_LBL'); ?></span><div><b></b></div></a><div class="chzn-drop"><div class="chzn-search"><input type="text" autocomplete="off" readonly=""></div><ul class="chzn-results"></ul></div></div>
						</div>
						<div style="clear:both;"></div>
					</div>

					<div class="control-group">
						<div class="control-label">
							<label class="hasTooltip" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BACKGROUND_SIZE_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BACKGROUND_SIZE_DESC'); ?>"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BACKGROUND_SIZE_LBL'); ?></label>
						</div>
						<div class="controls">
							<input type="text" class="background_size">
						</div>
					</div>
					
					<div class="control-group">
						<div class="control-label">
							<label id="BgImageFixedSwitch-lbl" for="BgImageFixedSwitch" class="hasTooltip" title="" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BODY_BG_IMAGE_FIXED_SWITCH_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BODY_BG_IMAGE_FIXED_SWITCH_DESC'); ?>">
							<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_BODY_BG_IMAGE_FIXED_SWITCH_LBL'); ?></label>
						</div>
						<div class="controls">		
							<input type="hidden" name="jform[params][BgImageFixedSwitch]" id="BgImageFixedSwitch" value="" class="flipyesno fixed_background" flipcreated="0">
						</div>
					<div style="clear:both;"></div>	
					</div>

					<div class="control-group">
						<div class="control-label">
							<label id="parallax-lbl" for="parallax" class="hasTooltip" title="" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PARALLAX_SCROLL_LOAD_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PARALLAX_SCROLL_LOAD_DESC'); ?>">
							<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PARALLAX_SCROLL_LOAD_LBL'); ?></label>
						</div>
						<div class="controls">		
							<input type="hidden" name="jform[params][parallax]" id="parallax" value="0" class="flipyesno parallax" flipcreated="0">
						</div>
					</div>
		
					<div class="control-group">
						<div class="control-label">
							<label id="parallaxSpeed-lbl" for="parallaxSpeed" class="hasTooltip" title="" data-original-title="<strong><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PARALLAX_SCROLL_SPEED_LBL'); ?></strong><br /><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PARALLAX_SCROLL_SPEED_DESC'); ?>">
							<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_PARALLAX_SCROLL_SPEED_LBL'); ?></label>
						</div>
						<div class="controls">
							<select id="parallaxSpeed" name="jform[params][parallaxSpeed]" class="chzn-done scroll_speed" style="display: none;">
								<option value="1">1X</option>
								<option value="2" selected="selected">2X</option>
								<option value="4">4X</option>
								<option value="6">6X</option>
								<option value="8">8X</option>
								<option value="10">10X</option>
								<option value="20">20X</option>
							</select>
							<div class="chzn-container chzn-container-single chzn-container-single-nosearch" style="width: 224px;" title="" id="parallaxSpeed_chzn"><a class="chzn-single" tabindex="-1"><span><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FAST_LBL'); ?></span><div><b></b></div></a><div class="chzn-drop"><div class="chzn-search"><input type="text" autocomplete="off" readonly=""></div><ul class="chzn-results"><li class="active-result result-selected" style="" data-option-array-index="0"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_FAST_LBL'); ?></li><li class="active-result" style="" data-option-array-index="1"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_MEDIUM_LBL'); ?></li><li class="active-result" style="" data-option-array-index="2"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SLOW_LBL'); ?></li></ul></div></div>
							</div>
						<div style="clear:both;"></div>
					</div>

					<div class="control-group">
						<br><br>
					</div>
					
				</div>
				<div class="settings_box">
					<button class="btn btn-primary" style="margin-left: 15px;" type="button" onclick="saveSettingsParams(); window.parent.jModalClose(); setTimeout(function(){	Joomla.submitsparkyoptions('style.apply'); },400); setTimeout(function(){ showRowSettings(); },800);"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_SAVE_SETTINGS'); ?></button>
					<button class="btn" type="button" onclick="window.parent.jModalClose();"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_CANCEL'); ?></button>
				</div>
				</div>
			</div>
			<script type="text/javascript">
				var currentGrid = 0;
				var changed = false;
				var gridSize = {
					"1":"800",
					"2":"399",
					"3":"265",
					"4":"198",
					"5":"158",
					"6":"131",
					"7":"112",
					"8":"98",
					"9":"87",
					"10":"78",
					"11":"70",
					"12":"64",
					"13":"59",
					"14":"55",
					"15":"51",
					"16":"49",
					"17":"45",
					"18":"42",
					"19":"40",
					"20":"38",
					"21":"36",
					"22":"34",
					"23":"32",
					"24":"30",
				};

				jQuery(document).ready(function(){
						
					/* config */
					xOffset = -30;
					yOffset = 0;
					
					// these 2 variables determine popup's distance from the cursor
					// you might want to adjust to get the right result
					var Mx = jQuery(window).width();
					var My = jQuery(window).height();
						
					// delete position from layout
					jQuery(document).on("click",".remove_block", function(){
						var res = confirm("<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_REMOVE_ELEMENT_LAYOUT') ;?>");
						var el = jQuery(this).parent(".mpos_draggable");
						if(res){
							el.appendTo(jQuery('#layoutdesigner<?php echo $this->id; ?> .unassignedPositions'));
						}
					});

					var callback = function(event) {
						var $img = jQuery(".preview_image_thumb");
						
						// top-right corner coords' offset
						var trc_x = xOffset + $img.width();
						var trc_y = yOffset + $img.height();
						
						trc_x = Math.min(trc_x + event.pageX, Mx);
						trc_y = Math.min(trc_y + event.pageY, My);
						$img
							.css("top", (trc_y - $img.height()) + "px")
							.css("left", (trc_x - $img.width())+ "px");
					};
				
					jQuery(document).on("hover",".image_preview",function(e){
					
						Mx = jQuery(document).width();
						My = jQuery(document).height();

						if(jQuery(this).prev().prev().val()=="")
							return;

						var href = '../templates/<?php echo $TEMPLATE_FOLDER."/images/"; ?>' + jQuery(this).prev().prev().val();
						jQuery("body").append("<p class='preview_image_thumb'><img src='"+ href +"' alt='Image preview' /></p>");
						callback(e);
						jQuery(".preview_image_thumb").fadeIn("fast");
					});
				
					jQuery(document).on("mouseleave",".image_preview",function(e){
						jQuery(".preview_image_thumb").remove();
					});
					
					currentGrid = parseInt(jQuery("#jform_params_gridSystem").val());
					jQuery(".LayoutModel").addClass("grid"+currentGrid);
					
					jQuery('.width_value input').each(function(ind){
						var WIDTH_ID = jQuery(this).attr('id');
						if (WIDTH_ID=="jform_params_gridSystem") {
							jQuery("#width" + WIDTH_ID).slider({
								value:jQuery(this).val(),
								min: 1,
								max: 24,
								step: 1,
								slide: function( event, ui ) {
									jQuery("#" + WIDTH_ID).val( ui.value ).trigger('change');
									jQuery("#disp" + WIDTH_ID).html( ui.value );
								},
								change: function( event, ui ) {
									if(parseInt(jQuery("#jform_params_gridSystem").val())!=currentGrid){
										if(confirm("<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_GRID_CONFIRM') ;?>")){
											jQuery('#sortable > .edit_row').each(function(){
												jQuery(this).find('.mpos_draggable').appendTo(jQuery('#layoutdesigner<?php echo $this->id; ?> .unassignedPositions'));
												jQuery(this).remove();
											});
											setTimeout(function(){
												jQuery("#toolbar-apply button").click();
											},300);
										} else {
											jQuery("#jform_params_gridSystem").val(currentGrid);
											jQuery("#width" + WIDTH_ID).slider( "option", "value", currentGrid );
											jQuery("#dispjform_params_gridSystem").html(currentGrid);
										}
									}
								},
								orientation: "horizontal"
							});
						}	
					});
				});

				window.setTimeout(function(){
					
					if(jQuery('#<?php echo $this->id; ?>').val()!="")
						layout_object = JSON.parse(jQuery('#<?php echo $this->id; ?>').val());
					else
						layout_object = JSON.parse("{}");
					
					var gridSystem = parseInt(jQuery("#jform_params_gridSystem").val());
					var min = parseInt(gridSize[gridSystem]);
					jQuery(".layout_row").css("background-size",min+2+"px 50px");
					
					var css = '.mpos_draggable {width:'+min+'px;}',
					head = document.head || document.getElementsByTagName('head')[0],
					style = document.createElement('style');

					style.type = 'text/css';
					if (style.styleSheet){
						style.styleSheet.cssText = css;
					} else {
						style.appendChild(document.createTextNode(css));
					}
					head.appendChild(style);
					
			        if(window.layoutEditorLoaded<?php echo $this->id; ?>){ 
						return;
					}
					window.layoutEditorLoaded<?php echo $this->id; ?> = true;
					
					jQuery( "#layoutdesigner<?php echo $this->id; ?> #sortable" ).sortable({
						revert: true,
						receive: function(event, ui) { 
					    	window.hookRowEvents<?php echo $this->id; ?>(); 
						}
					});
					
					jQuery( "#layoutdesigner<?php echo $this->id; ?> #layout_addRow" ).click(function(){
						
						var row_num = Object.size(layout_object)+1;
						var name = "row"+row_num;
						var element = {};

						// space for default values
						element['settings']={p1: "", p2: "", p3: "", p4: "", p5: "", p6: "", p7: "", p8: "", p9: "", p10: "", p11: "", p12: "", p13: "", p14: "", p15: "", p16: "", p17: "", p18: "div", p19: ""};
						element['position']="";
						 
						layout_object[name]=element;
						 
					    var row = jQuery('#layoutdesigner<?php echo $this->id; ?> #layout_addRow').clone(false).first();
						row.attr("layout_settings",JSON.stringify(element['settings']));
						row.removeAttr('id');
						row.removeClass('ui-state-hover');
						jQuery('#layoutdesigner<?php echo $this->id; ?> #sortable').append(row);
						window.hookRowEvents<?php echo $this->id; ?>();
						SqueezeBox.initialize({});SqueezeBox.initialize({});
						SqueezeBox.assign(row.find('a.modal').get(), {
							parse: 'rel'
						}); 
					});
					
					jQuery( "#layoutdesigner<?php echo $this->id; ?> ul, #layoutdesigner<?php echo $this->id; ?> li" ).disableSelection();
					
					jQuery('#layoutdesigner<?php echo $this->id; ?> #layout_addRow').button({
						text: true,
						icons: {
							primary: 'ui-icon-plusthick'
						}
					});
					
				    jQuery('#layoutdesigner<?php echo $this->id; ?> .off_left').addClass('ui-widget-content ui-icon ui-icon-triangle-1-w');
					jQuery('#layoutdesigner<?php echo $this->id; ?> .off_right').addClass('ui-widget-content ui-icon ui-icon-triangle-1-e');
					
					jQuery('#layoutdesigner<?php echo $this->id; ?> .off_left').click(function(){
						if(jQuery(this).parent().parent().hasClass('layout_row')){
					    	if(parseInt(jQuery(this).parent().css('marginLeft')) > 10){
								var off = parseInt(jQuery(this).parent().attr('off'));
								jQuery(this).parent().attr('off',off - 1);
								jQuery(this).parent().css('marginLeft', String((off - 1) * (min+2)-2) + 'px' );
							}
						}
					});
					
					jQuery('#layoutdesigner<?php echo $this->id; ?> .off_right').click(function(){
						if(jQuery(this).parent().parent().hasClass('layout_row')){
					    	var totalRowW = 0;
							jQuery(this).parent().parent().find('.mpos_draggable').each(function(ind){
								totalRowW += (jQuery(this).outerWidth() + parseInt(jQuery(this).css('marginLeft')));
							});
						 
							if(totalRowW + min < 804){
								var off = parseInt(jQuery(this).parent().attr('off'));
								jQuery(this).parent().attr('off',off + 1);
								jQuery(this).parent().css('marginLeft', String((off + 1) * min +2*off+1) + 'px' );
							}
					  	}
					}); 
					
	 			    jQuery('#layoutdesigner<?php echo $this->id; ?> .unassignedPositions').sortable({
						connectWith: "#layoutdesigner<?php echo $this->id; ?> .drag_module_positions",
						revert: true,
						tolerance: "touch"
				    }).disableSelection();
			 
		        	window.hookRowEvents<?php echo $this->id; ?> = function(){
				    	jQuery('#layoutdesigner<?php echo $this->id; ?> .LayoutModel .edit_row:not([hooked])').each(function(ind){
					    	jQuery(this).attr('hooked',true);
						 
							jQuery(this).find('.deleteRow')
								.button({ text: true, icons: { primary: 'ui-icon-closethick'} })
								.click(function(){
									if(confirm("<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_DELETE_ROW_CONFIRM') ;?>")){
										var r_el = jQuery(this).closest('.edit_row');
										r_el.find('.mpos_draggable').appendTo(jQuery('#layoutdesigner<?php echo $this->id; ?> .unassignedPositions'));
										var index = jQuery('#sortable .edit_row').index(r_el);
										var name_remove = "row"+(index+1);
										
										/*delete layout_object[name_remove];*/
								
										r_el.remove();
										//pushObjectLayout();
									}
								});
						 
							jQuery(this).find('.layout_row').attr('id','ID_' + String(Math.floor(Math.random()*1000000)));
		                	jQuery(this).find('.layout_row').addClass('drag_module_positions');
							jQuery(this).find('.layout_row').sortable({
								connectWith: "#layoutdesigner<?php echo $this->id; ?> .drag_module_positions",
								revert: 100,
								tolerance: "touch", 
								receive: function(event, ui) { 
								
			  				    	ui.item.css('marginLeft',0);
									ui.item.attr('off',0);
									var totalRowW = 0;
									ui.item.parent().find('.mpos_draggable').each(function(ind) {
								    	totalRowW += jQuery(this).outerWidth();
									});
									var cells = Math.round(ui.item.innerWidth() / (min + 2));
									var diff =  Math.round(( getRowWidth() - totalRowW ) / (min + 2));
									
									var grw = getRowWidth();
									
									if(totalRowW > grw) {
										
										var avail = (grw - (totalRowW - ui.item.outerWidth()));
										
										if( avail >= min) {							
											ui.item.innerWidth((cells - Math.abs(diff)) * min + 10 );	
											ui.item.attr('wX', (cells - Math.abs(diff)));					
											
										}else{
								    		ui.item.appendTo(ui.sender);			
										}
									}
								},
								update: function(){
								//pushObjectLayout();
							}
							}).disableSelection();
						});
					};
			   
					window.save_layout<?php echo $this->id; ?> = function (){
						
				    	var serialised = '{';
						var k = 1;
				    	jQuery('#layoutdesigner<?php echo $this->id; ?> .LayoutModel .edit_row').each(function(ind){
							var name = "row"+k;

							if(jQuery(this).attr("layout_settings")=="" || jQuery(this).attr("layout_settings")== undefined)
								return;
							else
								var temp = JSON.parse(jQuery(this).attr("layout_settings"));
							
					    	var entry = '"'+name+'":{"settings": '+JSON.stringify(temp)+ ', ';
							var mposs = '';
							jQuery(this).find('.mpos_draggable').each(function(index){
						    	if(mposs != ''){
									mposs = mposs + ',';
								}
								mposs = mposs + jQuery(this).attr('mp') + '=' + jQuery(this).attr('wX') + '=' + jQuery(this).attr('off');
							});			 
							entry += ' "position": "'+mposs+'"}';
							if(serialised != '{'){
								serialised = serialised + ',';
							}
							serialised = serialised + entry;
							k++;
						});
						
						serialised = serialised + '}';
		            	jQuery('#<?php echo $this->id; ?>').val(serialised);
					}
				
					Object.size = function(obj) {
						var size = 0, key;
						for (key in obj) {
							if (obj.hasOwnProperty(key)) size++;
						}
						return size;
					};
			   
					window.load_layout<?php echo $this->id; ?> = function(passed){
				    	try{
							jQuery(".LayoutModel .mpos_draggable").appendTo('.unassignedPositions');
							jQuery(".LayoutModel .edit_row").remove();
							
							if(passed){
								layout_object=JSON.parse(passed);
							}
							else{
								if(jQuery('#<?php echo $this->id; ?>').val()!="")
									layout_object = JSON.parse(jQuery('#<?php echo $this->id; ?>').val());
								else
									layout_object = JSON.parse("{}");

							}
							for(var i = 0; i < Object.size(layout_object); i++){
								
								var name = "row"+(i+1);
								var rowNumber = i+1;
								
								var current = layout_object[name];
							
								var row = jQuery('#layoutdesigner<?php echo $this->id; ?> #layout_addRow').clone(false).first();
								row.removeAttr('id');

								
								
								jQuery('#layoutdesigner<?php echo $this->id; ?> #sortable').append(row);
								row.attr("layout_settings",JSON.stringify(current.settings));
								var temp = current.position.split(',');

								for(var j = 0; j < temp.length; j++){
								    var pName  = temp[j].split('=')[0];
									var pWidth = parseInt(temp[j].split('=')[1]);
									var pOff   = parseInt(temp[j].split('=')[2]);
								
									if(String(pWidth) == 'NaN') pWidth = 0;
									if(String(pOff) == 'NaN') pOff = 0;
								
									var box = null;
									box = jQuery('#layoutdesigner<?php echo $this->id; ?> .unassignedPositions .mpos_draggable[mp="' + pName + '"]');
								    box.appendTo(row.find('.layout_row').first());
									box.attr('wX',pWidth);
									box.attr('off',pOff);
								
									box.innerWidth(pWidth * min - 2);
									box.css('marginLeft',String(pOff * min) + 'px');
								}

								

							}
							window.hookRowEvents<?php echo $this->id; ?>();
						}catch(ex){
						}

						window.setInterval( function(){
							try{
								jQuery('#layoutdesigner<?php echo $this->id; ?> .unassignedPositions .mpos_draggable').resizable( "disable" );
							}catch(e1){	
							}

							jQuery('#layoutdesigner<?php echo $this->id; ?> .unassignedPositions .mpos_draggable').css({'width':'70px'});
							jQuery('#layoutdesigner<?php echo $this->id; ?> .unassignedPositions .mpos_draggable').css({'width':'auto'});

							try{
								jQuery('#layoutdesigner<?php echo $this->id; ?> .LayoutModel .mpos_draggable').resizable( "enable" );
							}catch(e2){	
							}
						
						    if( jQuery('#layoutdesigner<?php echo $this->id; ?> #sortable .edit_row').length == 0){
								if( jQuery('#layoutdesigner<?php echo $this->id; ?> #sortable .initialRow').length == 0){
									jQuery('#layoutdesigner<?php echo $this->id; ?> #sortable').append(jQuery('<li class="initialRow"><?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_ADD_DRAG'); ?></li>')); 
								}
							}else{
							    if( jQuery('#layoutdesigner<?php echo $this->id; ?> #sortable .initialRow').length > 0){
									jQuery('#layoutdesigner<?php echo $this->id; ?> #sortable .initialRow').remove();
								}
							}
						    window.save_layout<?php echo $this->id; ?>();
						},350);
					}
				
					function getRowWidth(){
						return gridSystem * (min + 2) - 2;
					}

					window.load_layout<?php echo $this->id; ?>();

					jQuery('#layoutdesigner<?php echo $this->id; ?> .mpos_draggable').resizable({
						maxHeight: 48,
						maxWidth: getRowWidth(),
						minHeight: 48,
						minWidth: min,
						grid: min+2,
						handles: 'e',
						create: function(){
							var cells = Math.round(jQuery(this).innerWidth()/min);
							if(cells>1){
								jQuery(this).innerWidth(cells*(min + 2) -2);
							}
							else{
								jQuery(this).innerWidth(min);
							}
							
						},
						stop: function(event, ui) { 
							var cells =Math.round(jQuery(this).innerWidth() / (min+2));
							jQuery(this).attr('wX', cells);
							jQuery(this).innerWidth(cells*(min + 2) - 2);
	 
							if(jQuery(this).parent().hasClass('layout_row')){
						    	var RowTotalW = 0;
								jQuery(this).parent().find('.mpos_draggable').each(function(ind){
									RowTotalW += jQuery(this).outerWidth();
								});
								
								var diff =  Math.round(( getRowWidth() - RowTotalW ) / (min+2));
								
								if(RowTotalW > getRowWidth()){
									jQuery(this).innerWidth( (cells - Math.abs(diff)) * (min + 2) -2 );
									jQuery(this).attr('wX', (cells - Math.abs(diff)));
								}
							}
							//pushObjectLayout();
						}
					});
				},300);

				function showRowSettings() {

					if(jQuery('#<?php echo $this->id; ?>').val()!="")
						layout_object2 = JSON.parse(jQuery('#<?php echo $this->id; ?>').val());
					else
						layout_object2 = JSON.parse("{}");

					Object.size = function(obj) {
						var size = 0, key;
						for (key in obj) {
							if (obj.hasOwnProperty(key)) size++;
						}
						return size;
					};

					window.setTimeout( function(){
						for(var i = 0; i < Object.size(layout_object2); i++){

							currentRowNum = i + 1;
							currentRow = jQuery('.LayoutModel ul li.edit_row:nth-child(' + currentRowNum +') .layout_row_container');

							if ( !jQuery('.row_info' + currentRowNum).length ) {
								currentRow.append('<div class="row_info' + currentRowNum + '"></div>');
							}

							currentRowContainer = layout_object2['row'+currentRowNum]['settings']['p18'];
							currentRowName = layout_object2['row'+currentRowNum]['settings']['p1'];
							currentRowClass = layout_object2['row'+currentRowNum]['settings']['p2'];

							row_info = "";

							row_info = currentRowContainer;
							if (currentRowName) {
								row_info = row_info + '#' + currentRowName;
							}
							row_info = row_info + '.sparky_row' + currentRowNum;
							if (currentRowClass) {
								row_info = row_info + '.' + currentRowClass;
							}
							
							jQuery('.row_info' + currentRowNum).html(row_info);

						}
					},2000);

					// write container, ID and class for each row
					// row.find('.layout_row_container').append(current['settings']['p18']);
					// if (current['settings']['p1']) {
					// 	row.find('.layout_row_container').append('#' + current['settings']['p1']);
					// }
					// if (current['settings']['p2']) {
					// 	row.find('.layout_row_container').append('.' + current['settings']['p2']);
					// }
					// row.find('.layout_row_container').append('.sparky_row' + rowNumber);

				}
				showRowSettings();
			</script>
		</div> 
		 
	<?php
		$OUT = ob_get_contents();
    	ob_end_clean();		
    	return $OUT;
	}
}
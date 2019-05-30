<?php
/*------------------------------------------------------------------------
# "Sparky On Save" Joomla plugin
# Copyright (C) 2016 HotThemes. All Rights Reserved.
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Author: HotThemes
# Website: http://www.hotjoomlatemplates.com
-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.plugin.plugin');

class plgSystemSparkyonsave extends JPlugin
{
	
	function onExtensionAfterSave($option, $data)
	{
		if(!defined('DS')) {
		    define("DS", DIRECTORY_SEPARATOR);
		}

		// execute only for templates
		if($option == "com_templates.style") {

			// get params for template style that's being edited
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query
				->select('*')
				->from('#__template_styles')
				->where('id=' . $db->quote($data->id));

			$db->setQuery($query);
			$db->execute();
			$template_style = $db->loadObjectList();

			// joomla url
			$joomla_url = str_replace("/administrator", "", JURI::base("true"));

			// template path
			$template_path = $joomla_url."/templates/".$template_style[0]->template;

			// absolute paths
			$abs_template_path = $_SERVER['DOCUMENT_ROOT'].JURI::root("true").DS."templates".DS.$template_style[0]->template.DS;
			$css_path = $abs_template_path."css".DS;
			$js_path = $abs_template_path."js".DS;

			// decode template style params - you'll need them for making CSS file
			$tparams = json_decode($template_style[0]->params);

			// get current CSS file name into $cssfile_current
			preg_match('/"exportedcssfile":\"([^\"]*)\"/', $template_style[0]->params, $cssfile_current);

			// get current JS file name into $jsfile_current
			preg_match('/"exportedjsfile":\"([^\"]*)\"/', $template_style[0]->params, $jsfile_current);

			// get current JS footer file name into $jsfile_footer_current
			preg_match('/"exportedjsfooterfile":\"([^\"]*)\"/', $template_style[0]->params, $jsfile_footer_current);

			// delete current CSS/JS files

			//unlink($css_path.$cssfile_current[1]);
			array_map('unlink', glob($css_path."sparky-id".$template_style[0]->id."*.css"));
			//unlink($js_path.$jsfile_current[1]);
			array_map('unlink', glob($js_path."sparky-id".$template_style[0]->id."*.js"));
			//unlink($js_path.$jsfile_footer_current[1]);
			array_map('unlink', glob($js_path."sparky-footer-id".$template_style[0]->id."*.js"));

			// make new CSS file name (per time stamp) and get path for it
			$css_file_name = "sparky-id".$template_style[0]->id."-".date("ymdHis").".css";
			$css_file = $css_path.$css_file_name;

			// make new JS file name (per time stamp) and get path for it
			$js_file_name = "sparky-id".$template_style[0]->id."-".date("ymdHis").".js";
			$js_file = $js_path.$js_file_name;

			// make new JS footer file name (per time stamp) and get path for it
			$js_footer_file_name = "sparky-footer-id".$template_style[0]->id."-".date("ymdHis").".js";
			$js_footer_file = $js_path.$js_footer_file_name;

			// new template style params string with new CSS/JS files in it
			$updated_template_params = preg_replace('/\"exportedcssfile\":\\"([^\\"]*)\\"/', '"exportedcssfile":"'.$css_file_name.'"', $template_style[0]->params);
			$updated_template_params = preg_replace('/\"exportedjsfile\":\\"([^\\"]*)\\"/', '"exportedjsfile":"'.$js_file_name.'"', $updated_template_params);
			$updated_template_params = preg_replace('/\"exportedjsfooterfile\":\\"([^\\"]*)\\"/', '"exportedjsfooterfile":"'.$js_footer_file_name.'"', $updated_template_params);

			if ($updated_template_params != $template_style[0]->params) {

				jimport( 'joomla.application.module.helper' );

				// Decode JSON of fonts
				$pFontHot = json_decode($tparams->pFontHot);
				$h1FontHot = json_decode($tparams->h1FontHot);
				$h2FontHot = json_decode($tparams->h2FontHot);
				$h3FontHot = json_decode($tparams->h3FontHot);
				$h4FontHot = json_decode($tparams->h4FontHot);
				$logoFontHot = json_decode($tparams->logoFontHot);
				$sloganFontHot = json_decode($tparams->sloganFontHot);

				// Detect published menus
				$LoadMENU_Acc  = false;
				$LoadMENU_Mega = false;
				$LoadMENU_Navh = false;
				$LoadMENU_Navv  = false;
				$LoadMENU_Offcanvas  = false;

				$mnucfg = array();
				$mnu_load = json_decode($tparams->mnucfg, "[]");

				foreach($mnu_load as $mnu){
				    
				    $mnu_name = $mnu['name'];
				    $mnu_val  = $mnu['type'];

				    if($mnu_val == "acc" || strpos($mnu_val, "acc")){
				        $LoadMENU_Acc = true;
				    }else if($mnu_val == "navh" || strpos($mnu_val, "navh")){
				        $LoadMENU_Navh = true;
				    }else if($mnu_val == "navv" || strpos($mnu_val, "navv")){
				        $LoadMENU_Navv = true;
				    }else if($mnu_val == "offcanvas" || strpos($mnu_val, "offcanvas")){
						$LoadMENU_Offcanvas = true;
					}else if($mnu_val == "mega" || strpos($mnu_val, "mega")){
						$LoadMENU_Mega = true;
					}


				    $mnucfg[$mnu_name] = array();
				    $mnucfg[$mnu_name]['type'] = $mnu_val;
				    
				    foreach ($mnu['config'] as $prop => $value) {
				        $mnucfg[$mnu_name][$prop] = $value;
				    }
				}

				// Detect copied menus
				$menu_copies = array();

				foreach($mnucfg as $menu_name => $menu) {
				    if(strpos($menu['type'], "copy") !== false){
				        $index = strpos($menu['type']," ")-5;
				        $real_type = substr($menu['type'],5,$index); 
				        $menu_copies[$real_type][] = $menu_name;
				    }
				}

				// Count row elements

				$module_grid = json_decode($tparams->layoutdesign);
				require($abs_template_path."library".DS."sparky_grid.php");

				$k = 1;
				$floating_rows = 0;
				$parallax_images = array();
				$font_resize_enabled = false;

				foreach ($module_grid2 as $gridRow) {

				    // count modules in the row
				    require($abs_template_path."library".DS."sparky_module_counter.php");

				    // check if this row is floating
				    if ($modules_in_row && $module_grid->{$gridRow[0]}->settings->p15=="1") {
				        $floating_rows++;
				    }

				    // count rows with parallax
				    if ($module_grid->{$gridRow[0]}->settings->p11 == "1" && $module_grid->{$gridRow[0]}->settings->p16 != "") {
						$parallax_images[$k]= intval($module_grid->{$gridRow[0]}->settings->p12);
					}

					// check if fontresize is in layout
					foreach ($gridRow[2] as $element) {
						if ($element[0]=="fontresize") {
							$font_resize_enabled = true;
						}
					}

				    $k++;

				} // end foreach

				// Get contents of CSS file
				require($css_path."sparky_css.php");

				// TODO Compress CSS


				// Write CSS file
				file_put_contents($css_file, $cssoutput);

				// Get contents of JS file
				require($js_path."sparky_js.php");

				// TODO Compress JS


				// Write JS file
				file_put_contents($js_file, $jsoutput);

				// Get contents of JS footer file
				require($js_path."sparky_js_footer.php");

				// TODO Compress JS


				// Write JS footer file
				file_put_contents($js_footer_file, $jsoutputfooter);

				// set new CSS/JS files in DB of template options
				$db  = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->update('#__template_styles');
				$query->set($db->quoteName('params') . ' = ' . $db->quote($updated_template_params));
				$query->where($db->quoteName('id') . ' = ' . $db->quote($template_style[0]->id));
				$db->setQuery($query);
				$db->execute();

			}
		}
	}
}
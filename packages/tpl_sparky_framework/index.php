<?php
/*------------------------------------------------------------------------
# "Sparky Framework" - Joomla Template Framework
# Copyright (C) 2016 HotThemes. All Rights Reserved.
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Author: HotThemes
# Website: http://www.hotjoomlatemplates.com
-------------------------------------------------------------------------*/
defined( '_JEXEC' ) or die( 'Restricted access' );
if(!defined('DS')) {
    define("DS", DIRECTORY_SEPARATOR);
}
define( 'YOURBASEPATH', dirname(__FILE__) );
$doc = JFactory::getDocument();
$template_path = $this->baseurl.'/templates/'.$this->template;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php
// Google fonts
$google_obj = $this->params->get("googleUrl","{}");
if ($google_obj != "{}") {
	$google_href = "https://fonts.googleapis.com/css?family=";
	$google_obj = json_decode($google_obj, true);
	$subsets = "";
	$pos = false;
	$i = 0;
	$len = count($google_obj);

	foreach($google_obj as $key => $g_o) {
		$variant = implode(",",$g_o['variant']);
		foreach($g_o['charsets'] as $subset) {
			$pos = strpos($subsets, $subset);
			if( $pos === false ) {
				$subsets = $subsets . "," . $subset;
			}
		}
		$google_href .= str_replace(" ","+",$key).":".$variant;
		if ($i < $len - 1) {
			$google_href .= "%7C";
		}
		$i++;
	}

	$subsets = ltrim($subsets, ',');
	$google_href .= "&amp;subset=".$subsets;

	$doc->addStyleSheet($google_href);
}
	
// Get Sparky parameters
require(dirname(__FILE__).DS.'library'.DS.'sparky_parameters.php');
	
// READ MENU CONFIGURATION ///////////////////////////////////////////////////////

$LoadMENU_Acc = false;
$LoadMENU_Navh = false;
$LoadMENU_Navv = false;
$LoadMENU_Offcanvas = false;
$LoadMENU_Mega = false;

global $mnucfg;
$mnucfg = array();

$mnu_load = json_decode($this->params->get("mnucfg", "[]"));
foreach($mnu_load as $mnu){
	
	$mnu_name = $mnu->name;
	$mnu_val  = $mnu->type;

	if ($mnu_val == "acc" || strpos($mnu_val, "acc")) {
		$LoadMENU_Acc = true;
		$doc->addScript('templates/' . $this->template . '/js/jquery-ui.min.js');
	} else if($mnu_val == "navh" || strpos($mnu_val, "navh")) {
		$LoadMENU_Navh = true;
	} else if($mnu_val == "navv" || strpos($mnu_val, "navv")) {
		$LoadMENU_Navv = true;
	} else if($mnu_val == "offcanvas" || strpos($mnu_val, "offcanvas")) {
		$LoadMENU_Offcanvas = true;
	} else if($mnu_val == "mega" || strpos($mnu_val, "mega")) {
		$LoadMENU_Mega = true;
		$doc->addScript('templates/' . $this->template . '/js/jquery-ui.min.js');
	}

	$mnucfg[$mnu_name] = array();
	$mnucfg[$mnu_name]['type'] = $mnu_val;
	
	foreach ($mnu->config as $prop => $value) {
		$mnucfg[$mnu_name][$prop] = $value;
	}
}		
// now we have, in example: echo $mnucfg['footer1']['text_color'];

// GRID LAYOUT ///////////////////////////////////////////////////////
	
//$gridRow[0] - Name
//$gridRow[1] - Class
//$gridRow[2] - ModulePos1,ModulePos2...
//$gridRow[3] - Holds content flag: true/false
//$mposition[0] - position name 
//$mposition[1] - number of grid cells occupied by position
//$mposition[2] - number of empty cells left of module 

$module_grid = json_decode($layoutdesign);
require(dirname(__FILE__).DS.'library'.DS.'sparky_grid.php');

// normalize.css
$doc->addStyleSheet('templates/' . $this->template . '/css/normalize.css');

if ($loadBootstrap) {
	JHtml::_('bootstrap.framework');
	$doc->addStyleSheet($this->baseurl . '/media/jui/css/bootstrap.min.css');
}

// add automatically generated CSS file
if ($exportedcssfile) {
	$doc->addStyleSheet('templates/' . $this->template . '/css/'.$exportedcssfile);
}
?>
<!--[if lt IE 9]>
	<script src="<?php echo $template_path ?>/js/html5shiv.min.js"></script>
	<script src="<?php echo $template_path ?>/js/respond.min.js"></script>
<![endif]-->

<?php
// Live style switching (cookie based)
	
// check if in cookie
if (isset($_COOKIE['Style'])) {
	$templateStyle = $_COOKIE['Style'];
}

$templateStyleTest = "";

// check if in link
if (isset($_GET['style'])) {
	$templateStyleTest = $_GET['style']; 
}

if ($templateStyleTest) { 
	$templateStyle = $templateStyleTest;
	$Month = 2592000 + time(); 
	setcookie("Style", $templateStyle, $Month);
}

// Get custom.css if it's not empty
if (file_get_contents(YOURBASEPATH.'/css/custom.css') != '') {
    $doc->addStyleSheet('templates/' . $this->template . '/css/custom.css');
}
if ($this->direction == "rtl") {
	if (file_get_contents(YOURBASEPATH.'/css/custom_rtl.css') != '') {
	    $doc->addStyleSheet('templates/' . $this->template . '/css/custom_rtl.css');
	}
}

// Get specific parameters for this style from /css/styles
if ($templateStyle) {
	$doc->addStyleSheet('templates/' . $this->template . '/css/styles/style'.$templateStyle.'.css');
}

if ($favicon != -1) {
?>
<link href="<?php echo $template_path.DS.'images'.DS.'icons'.DS.$favicon; ?>" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<?php }
if ($appleicon != -1) {
?>
<link href="<?php echo $template_path.DS.'images'.DS.'icons'.DS.$appleicon; ?>" rel="apple-touch-icon" />
<?php }
if ($androidicon != -1) {
?>
<link href="<?php echo $template_path.DS.'images'.DS.'icons'.DS.$androidicon; ?>" rel="icon" sizes="192x192" />
<?php } ?>

<jdoc:include type="head" />

<?php
// load jQuery UI
if ($loadJqueryUI) {
	$doc->addScript('templates/' . $this->template . '/js/jquery-ui.min.js');
}

// add automatically generated JS file
if ($exportedjsfile) {
	$doc->addScript('templates/' . $this->template . '/js/'.$exportedjsfile);
}

if($enableResponsiveMenu){ ?><script type="text/javascript" src="<?php echo $template_path ?>/js/responsive-nav.min.js"></script><?php } ?>
</head>
<?php 
$menu = JFactory::getApplication()->getMenu();
$lang = JFactory::getLanguage();
if (isset($menu->getActive()->alias)) {
	$pageAlias = $menu->getActive()->alias;
} else {
	$pageAlias = "";
}
?>
<body<?php if($menu->getActive() == $menu->getDefault($lang->getTag())) { echo ' class="sparky_home '.$pageAlias.'"'; }else{ echo ' class="sparky_inner '.$pageAlias.'"'; } ?>>
<?php if ($LoadMENU_Navv) { ?><div id="blocker"></div><?php } ?>
<?php if ($pageTransition) { ?><div id="page_transition_mask"></div><?php } ?>
<?php if ($LoadMENU_Offcanvas) { ?><div class="offcanvas-menu-overlay"></div><?php } ?>
<?php if ($topPanelSwitch) {
	require(dirname(__FILE__).DS.'library'.DS.'top_panel.php');
} ?>
<div class="sparky_wrapper">
<?php if (!$layoutdesign) { echo JText::_('TPL_SPARKY_FRAMEWORK_NO_LAYOUT'); } ?>
<?php
$cell_size = (int) $templateWidth / (int) $gridSystem;
$cell_size = floor($cell_size);  
$empty_no  = 0;
$floating_rows = 0;
$row_number = 1;
$k = 1;
foreach($module_grid2 as $gridRow) {
	
//$gridRow[0] - Name
//$gridRow[1] - Class
//$gridRow[2] - ModulePos1,ModulePos2...
//$gridRow[3] - Holds content flag: true/false
//$mposition[0] - position name 
//$mposition[1] - number of grid cells occupied by position
//$mposition[2] - number of empty cells left of module 

	require(dirname(__FILE__).DS.'library'.DS.'sparky_module_counter.php');
	if($modules_in_row) {
	?>
    <<?php if($module_grid->{$gridRow[0]}->settings->p18) { echo $module_grid->{$gridRow[0]}->settings->p18." "; }else{ echo "div "; } if($module_grid->{$gridRow[0]}->settings->p1) { echo 'id="'.$module_grid->{$gridRow[0]}->settings->p1.'"'; } ?> class="sparky_row<?php echo $row_number; ?> sparky_full<?php if($module_grid->{$gridRow[0]}->settings->p2) { echo ' '.$module_grid->{$gridRow[0]}->settings->p2; } if($module_grid->{$gridRow[0]}->settings->p13=="1") { echo ' one'; } if($module_grid->{$gridRow[0]}->settings->p14=="1") { echo ' full'; } if($module_grid->{$gridRow[0]}->settings->p15=="1") { echo ' floating'; $floating_rows++; }	?>">
        <div class="sparky_container">
        <?php
		if(isset($module_grid->{$gridRow[0]}->settings->p3) && $module_grid->{$gridRow[0]}->settings->p3 != "") {
			?><h2 class="row_heading"><?php echo $module_grid->{$gridRow[0]}->settings->p3; ?></h2> 
		<?php
		}
		if(isset($module_grid->{$gridRow[0]}->settings->p19) && $module_grid->{$gridRow[0]}->settings->p19 != "") {
			?><h3 class="row_subheading"><?php echo $module_grid->{$gridRow[0]}->settings->p19; ?></h3> 
		<?php
		}
        foreach($gridRow[2] as $mposition) {
			$mpwidth = $cell_size * $mposition[1];  
			if($mpwidth == 0) continue;
			$mpleft_off = $cell_size * $mposition[2];  
			if($mposition[0] == "joom_content") {			/////////////////// if CONTENT cell
                if($mpleft_off){							// if empty cells
                	require(dirname(__FILE__).DS.'library'.DS.'empty.php');
					$empty_no++;
                }  
                ?>
                <main class="sparky_cell content_sparky sparkle<?php echo $mposition[1];?>">
                    <jdoc:include type="message" />
                    <?php if ($this->countModules('abovecontent')) { ?>
                    <aside class="abovecontent">
                    	<jdoc:include type="modules" name="abovecontent" style="xhtml" />
                    </aside>
                    <?php } ?>
                    <jdoc:include type="component" />
                    <?php if ($this->countModules('belowcontent')) { ?>
                    <aside class="belowcontent">
                    	<jdoc:include type="modules" name="belowcontent" style="xhtml" />
                    </aside>
                    <?php } ?>
                </main>
            <?php
            }elseif($mposition[0] == "logo") {				/////////////////// if logo cell
				if($mpleft_off){							// if empty cells
					require(dirname(__FILE__).DS.'library'.DS.'empty.php');
					$empty_no++;
				}
				require(dirname(__FILE__).DS.'library'.DS.'logo.php');
			}elseif($mposition[0] == "fontresize") {		/////////////////// if fontresize cell
				if($mpleft_off){							// if empty cells
					require(dirname(__FILE__).DS.'library'.DS.'empty.php');
					$empty_no++;
				}
				require(dirname(__FILE__).DS.'library'.DS.'font_resize.php');
			}elseif($mposition[0] == "copyright") {			/////////////////// if copyright cell
				if($mpleft_off){							// if empty cells
					require(dirname(__FILE__).DS.'library'.DS.'empty.php');
					$empty_no++;
				}
				require(dirname(__FILE__).DS.'library'.DS.'c.php');
			}elseif(in_array($mposition[0], $all_menus)) {	/////////////////// if menu cell
				if($mpleft_off){							// if empty cells
					require(dirname(__FILE__).DS.'library'.DS.'empty.php');
					$empty_no++;
				}
				require(dirname(__FILE__).DS.'library'.DS.'menu_loader.php');
			}else{											/////////////////// if module position cell
                if($mpleft_off){							// if empty cells
					require(dirname(__FILE__).DS.'library'.DS.'empty.php');
					$empty_no++;
                } 
                ?>
				<div class="sparky_cell mp_<?php echo $mposition[0];?> sparkle<?php echo $mposition[1];?>">
					<jdoc:include type="modules" name="<?php echo $mposition[0]; ?>" style="xhtml" />
				</div>
                <?php
	        }
        } ?>
        </div>
    </<?php if($module_grid->{$gridRow[0]}->settings->p18) { echo $module_grid->{$gridRow[0]}->settings->p18; }else{ echo "div"; } ?>>
<?php
	} // if $modules_in_row
	$row_number++;
	$k++;	
} // foreach($module_grid as $gridRow)
?>
</div>
<?php
// load modules reserved for mega menu
if ($LoadMENU_Mega) { ?>
<div class="megamenu_blocks">
    <div class="megamenu_separator1"><jdoc:include type="modules" name="megamenu1" style="none" /></div>
    <div class="megamenu_separator2"><jdoc:include type="modules" name="megamenu2" style="none" /></div>
    <div class="megamenu_separator3"><jdoc:include type="modules" name="megamenu3" style="none" /></div>
    <div class="megamenu_separator4"><jdoc:include type="modules" name="megamenu4" style="none" /></div>
    <div class="megamenu_separator5"><jdoc:include type="modules" name="megamenu5" style="none" /></div>
    <div class="megamenu_separator6"><jdoc:include type="modules" name="megamenu6" style="none" /></div>
    <div class="megamenu_separator7"><jdoc:include type="modules" name="megamenu7" style="none" /></div>
    <div class="megamenu_separator8"><jdoc:include type="modules" name="megamenu8" style="none" /></div>
    <div class="megamenu_separator9"><jdoc:include type="modules" name="megamenu9" style="none" /></div>
    <div class="megamenu_separator10"><jdoc:include type="modules" name="megamenu10" style="none" /></div>
</div>
<?php
}
if ($scrollToTopImageFile!=-1 && $scrollToTopImageFile!="") {
	require(dirname(__FILE__).DS.'library'.DS.'scroll_to_top.php');
}
if ($analyticsSwitch && $analyticsAccount) {
	require(dirname(__FILE__).DS.'library'.DS.'analytics.php');
}
if ($exportedjsfooterfile) {
?>
<script type="text/javascript" src="<?php echo $template_path.DS.'js'.DS.$exportedjsfooterfile; ?>"></script>
<?php
}

// Get custom.js if it's not empty
if (file_get_contents(YOURBASEPATH.'/js/custom.js') != '') { ?>
	<script type="text/javascript" src="<?php echo $template_path.DS.'js/custom.js'; ?>"></script>
<?php
}
?>
</body>
</html>
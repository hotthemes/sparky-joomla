<?php
/*------------------------------------------------------------------------
# "Sparky Framework" - Joomla Template Framework
# Copyright (C) 2016 HotThemes. All Rights Reserved.
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Author: HotThemes
# Website: http://www.hotjoomlatemplates.com
-------------------------------------------------------------------------*/

// FONTS  ------------------------------------------------------------
$cat = array(
    "sans-serif" => "sans-serif",
    "serif" => "serif",
    "display" => "cursive",
    "handwriting" => "cursive",
    "monospace" => "monospace"
);

$h1FontHot = json_decode(str_replace("\\","",$this->params->get("h1FontHot", "{fontFamily:'Arial, Helvetica, sans-serif', fontWeight: 'normal', fontStyle:'normal'}")),"true");
if(isset($h1FontHot['googleFont']) && $h1FontHot['googleFont'] == "yes")
	$h1Family = "'".$h1FontHot['fontFamily']."', ".$cat[$h1FontHot['categories']];
else
	$h1Family = $h1FontHot['fontFamily'];
$h1Weight = $h1FontHot['fontWeight'];
$h1Style = $h1FontHot['fontStyle'];
$h1Color = $this->params->get("h1Color", "#333333");
$h1Size = $this->params->get("h1Size", "60@px");
$h1LineHeight = $this->params->get("h1LineHeight", "1.4");
$h1Align = $this->params->get("h1Align", "left");
$h1Underline = $this->params->get("h1Underline", "0");

$h2FontHot = json_decode(str_replace("\\","",$this->params->get("h2FontHot", "{fontFamily:'Arial, Helvetica, sans-serif', fontWeight: 'normal', fontStyle:'normal'}")),"true");
if(isset($h2FontHot['googleFont']) && $h2FontHot['googleFont'] == "yes")
	$h2Family = "'".$h2FontHot['fontFamily']."', ".$cat[$h2FontHot['categories']];
else
	$h2Family = $h2FontHot['fontFamily'];
$h2Weight = $h2FontHot['fontWeight'];
$h2Style = $h2FontHot['fontStyle'];
$h2Color = $this->params->get("h2Color", "#333333");
$h2Size = $this->params->get("h2Size", "32@px");
$h2LineHeight = $this->params->get("h2LineHeight", "1.4");
$h2Align = $this->params->get("h2Align", "left");
$h2Underline = $this->params->get("h2Underline", "0");

$h3FontHot = json_decode(str_replace("\\","",$this->params->get("h3FontHot", "{fontFamily:'Arial, Helvetica, sans-serif', fontWeight: 'normal', fontStyle:'normal'}")),"true");
if(isset($h3FontHot['googleFont']) && $h3FontHot['googleFont'] == "yes")
	$h3Family = "'".$h3FontHot['fontFamily']."', ".$cat[$h3FontHot['categories']];
else
	$h3Family = $h3FontHot['fontFamily'];
$h3Weight = $h3FontHot['fontWeight'];
$h3Style = $h3FontHot['fontStyle'];
$h3Color = $this->params->get("h3Color", "#333333");
$h3Size = $this->params->get("h3Size", "24@px");
$h3LineHeight = $this->params->get("h3LineHeight", "1.4");
$h3Align = $this->params->get("h3Align", "left");
$h3Underline = $this->params->get("h3Underline", "0");

$h4FontHot = json_decode(str_replace("\\","",$this->params->get("h4FontHot", "{fontFamily:'Arial, Helvetica, sans-serif', fontWeight: 'normal', fontStyle:'normal'}")),"true");
if(isset($h4FontHot['googleFont']) && $h4FontHot['googleFont'] == "yes")
	$h4Family = "'".$h4FontHot['fontFamily']."', ".$cat[$h4FontHot['categories']];
else
	$h4Family = $h4FontHot['fontFamily'];
$h4Weight = $h4FontHot['fontWeight'];
$h4Style = $h4FontHot['fontStyle'];
$h4Color = $this->params->get("h4Color", "#333333");
$h4Size = $this->params->get("h4Size", "14@px");
$h4LineHeight = $this->params->get("h4LineHeight", "1.4");
$h4Align = $this->params->get("h4Align", "left");
$h4Underline = $this->params->get("h4Underline", "0");

$pFontHot = json_decode(str_replace("\\","",$this->params->get("pFontHot", "{fontFamily:'Arial, Helvetica, sans-serif', fontWeight: 'normal', fontStyle:'normal'}")),"true");
if(isset($pFontHot['googleFont']) && $pFontHot['googleFont'] == "yes")
	$pFamily = "'".$pFontHot['fontFamily']."', ".$cat[$pFontHot['categories']];
else
	$pFamily = $pFontHot['fontFamily'];
$pWeight = $pFontHot['fontWeight'];
$pStyle = $pFontHot['fontStyle'];
$pColor = $this->params->get("pColor", "#333333");
$pSize = $this->params->get("pSize", "14@px");
$pLineHeight = $this->params->get("pLineHeight", "1.4");
$pAlign = $this->params->get("pAlign", "left");

$linksColor = $this->params->get("linksColor", "#8B1E20");
$linksHoverColor = $this->params->get("linksHoverColor", "#333333");
$linksWeight = $this->params->get("linksWeight", "normal");
$linksStyle = $this->params->get("linksStyle", "normal");
$linksUnderline = $this->params->get("linksUnderline", "0");
$linksUnderlineHover = $this->params->get("linksUnderlineHover", "0");

// LAYOUT  ------------------------------------------------------------

$templateWidth = $this->params->get("templateWidth", "960@px");
$layoutdesign = $this->params->get("layoutdesign", "");
$cellPaddingHorizontal = $this->params->get("cellPaddingHorizontal", "0@px");
$cellPaddingVertical = $this->params->get("cellPaddingVertical", "0@px");

// FEATURES  ------------------------------------------------------------

$scrollToTopImageFile = $this->params->get("scrollToTopImageFile", "top.png");
$scrollToTopPosition = $this->params->get("scrollToTopPosition", "bottom_right");

$equalHeightClasses = $this->params->get("equalHeightClasses", "");

// BODY BACKGROUND  -----------------------------------------------------

$bodyBgColor = $this->params->get("bodyBgColor", "");
$bodyBgImageFile = $this->params->get("bodyBgImageFile", "");
$bodyBgImageVerticalAlign = $this->params->get("bodyBgImageVerticalAlign", "top");
$bodyBgImageHorizontalAlign = $this->params->get("bodyBgImageHorizontalAlign", "center");
$bodyBgImageRepeat = $this->params->get("bodyBgImageRepeat", "repeat");
$bodyBgImageFixedSwitch = $this->params->get("bodyBgImageFixedSwitch", "");
$containerBgColor = $this->params->get("containerBgColor", "");

// LOGO  ----------------------------------------------------------------

$logoImageFile = $this->params->get("logoImageFile", "");
$logoImageAlt = $this->params->get("logoImageAlt", "");

$logoFontHot = json_decode(str_replace("\\","",$this->params->get("logoFontHot", "{fontFamily:'Arial, Helvetica, sans-serif', fontWeight: 'normal', fontStyle:'normal'}")),"true");
$logoFamily = $logoFontHot['fontFamily'];
$logoWeight = $logoFontHot['fontWeight'];
$logoStyle = $logoFontHot['fontStyle'];
$logoText = $this->params->get("logoText", "Sparky");
$logoColor = $this->params->get("logoColor", "#000000");
$logoSize = $this->params->get("logoSize", "24@px");
$logoAlign = $this->params->get("logoAlign", "left");

$sloganFontHot = json_decode(str_replace("\\","",$this->params->get("sloganFontHot", "{fontFamily:'Arial, Helvetica, sans-serif', fontWeight: 'normal', fontStyle:'normal'}")),"true");
$sloganFamily = $sloganFontHot['fontFamily'];
$sloganWeight = $sloganFontHot['fontWeight'];
$sloganStyle = $sloganFontHot['fontStyle'];
$sloganText = $this->params->get("sloganText", "");
$sloganColor = $this->params->get("sloganColor", "#000000");
$sloganSize = $this->params->get("sloganSize", "12@px");
$sloganAlign = $this->params->get("sloganAlign", "left");

$favicon = $this->params->get("favicon", "favicon.ico");
$appleicon = $this->params->get("appleicon", "icon180x180.png");
$androidicon = $this->params->get("androidicon", "icon192x192.png");

$copyright = $this->params->get("copyright", "Your Company");

// TOP PANEL  ----------------------------------------------------------------

$topPanelSwitch = $this->params->get("topPanelSwitch", "0");
$topPanelOpen = $this->params->get("topPanelOpen", "Open");
$topPanelClose = $this->params->get("topPanelClose", "Close");
$topPanelButtonWidth = $this->params->get("topPanelButtonWidth", "75@px");
$topPanelButtonHeight = $this->params->get("topPanelButtonHeight", "18@px");
$topPanelButtonBgColor = $this->params->get("topPanelButtonBgColor", "#000000");
$topPanelButtonTextColor = $this->params->get("topPanelButtonTextColor", "#FFFFFF");
$topPanelButtonTextSize = $this->params->get("topPanelButtonTextSize", "10@px");
$topPanelButtonBorderColor = $this->params->get("topPanelButtonBorderColor", "#666666");
$topPanelButtonBorderRadius = $this->params->get("topPanelButtonBorderRadius", "5");
$topPanelBgColor = $this->params->get("topPanelBgColor", "#000000");
$topPanelH3Color = $this->params->get("topPanelH3Color", "#CCCCCC");
$topPanelTextColor = $this->params->get("topPanelTextColor", "#CCCCCC");

// FONT RESIZE  --------------------------------------------------------------

$fontResizeMinus = $this->params->get("fontResizeMinus", "A-");
$fontResizeReset = $this->params->get("fontResizeReset", "Reset");
$fontResizePlus = $this->params->get("fontResizePlus", "A+");

// ANALYTICS  ----------------------------------------------------------------

$analyticsSwitch = $this->params->get("analyticsSwitch", "0");
$analyticsAccount = $this->params->get("analyticsAccount", "");

// GOOGLE FONTS  -------------------------------------------------------------

$googleWebFonts = $this->params->get("googleWebFonts", "");

// RESPONSIVENESS  -----------------------------------------------------------

$enableResponsive = $this->params->get("enableResponsive", "1");
$enableResponsiveMenu = $this->params->get("enableResponsiveMenu", "1");
$responsiveMenuTriggerValue = $this->params->get("responsiveMenuTriggerValue", "992@px");
$menuIcon = $this->params->get("menuIcon", "");
$menuIconImage = $this->params->get("menuIconImage", "");
$enableMenuIconImage = $this->params->get("enableMenuIconImage", "0");

// IMAGE ANIMATION  -----------------------------------------------------------

$imageAnimation = $this->params->get("imageAnimation", "0");

// PAGE TRANSITION  -----------------------------------------------------------

$pageTransition = $this->params->get("pageTransition", "0");
$pageTransitionDelay = $this->params->get("pageTransitionDelay", "1000");
$pageTransitionBg = $this->params->get("pageTransitionBg", "#333333");
$pageTransitionSpinner = $this->params->get("pageTransitionSpinner", "spinner1");
$pageTransitionImage = $this->params->get("pageTransitionImage", "-1");

// SCRIPTS LOADING

$loadBootstrap = $this->params->get("loadBootstrap", "0");
$loadJqueryUI = $this->params->get("loadJqueryUI", "0");
$loadFontAwesome = $this->params->get("loadFontAwesome", "0");
$lazyLoad = $this->params->get("lazyLoad", "0");

// GRID SYSTEM
$gridSystem = $this->params->get("gridSystem", "12");

// CUSTOM CODE
$customcodecss = $this->params->get("customcodecss", "");
$customcodejs = $this->params->get("customcodejs", "");

// STYLE AND GENERATED FILES
$templateStyle = $this->params->get("templateStyle", "0");
$exportedcssfile = $this->params->get("exportedcssfile", "");
$exportedjsfile = $this->params->get("exportedjsfile", "");
$exportedjsfooterfile = $this->params->get("exportedjsfooterfile", "");

?>
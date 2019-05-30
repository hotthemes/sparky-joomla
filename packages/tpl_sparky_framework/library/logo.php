<?php
/*------------------------------------------------------------------------
# "Sparky Framework" - Joomla Template Framework
# Copyright (C) 2016 HotThemes. All Rights Reserved.
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Author: HotThemes
# Website: http://www.hotjoomlatemplates.com
-------------------------------------------------------------------------*/

// retina image
$logo_img_extension = "";
$logo_img = explode(".", $logoImageFile);
$retina_image = false;

if (end($logo_img) == "jpg" || end($logo_img) == "jpeg" || end($logo_img) == "png" || end($logo_img) == "gif") {
	$logo_img_extension = $logo_img[1];
}

if ($logo_img_extension != "") {
	if (file_exists(JPATH_THEMES.DS.$this->template.DS."images".DS.$logo_img[0]."-2x.".$logo_img_extension)) {
		$retina_image = true;
	}
}
?>
<div class="sparky_cell mp_<?php echo $mposition[0]; ?> sparkle<?php echo $mposition[1]; ?>">
	<div class="sparky_feature">
		<a href="<?php echo $this->baseurl; ?>" class="sparky_logo_link">
			<?php if($logoImageFile!=-1 && $logoImageFile!="") { ?>
		    <div class="sparky_logo_image">
		    	<img src="<?php echo $template_path."/images/".$logoImageFile; ?>" <?php if ($retina_image) { ?>srcset="<?php echo $template_path.DS."images".DS.$logo_img[0]."-2x.".$logo_img_extension ?> 2x"<?php } ?> alt="<?php echo $logoImageAlt; ?>">
		    </div>
			<?php } else {
				if ($logoText) { ?>
		    	<div class="sparky_logo"><?php echo $logoText; ?></div>
		    	<?php
		    	}
		    	if ($sloganText) { ?>
		    	<div class="sparky_slogan"><?php echo $sloganText; ?></div>
		    	<?php
		    	}
			} ?>
	    </a>
	</div>
</div>
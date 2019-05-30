<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;
$params  = $displayData->params;

$images = json_decode($displayData->images);

// srcset for retina images
$intro_img_file = htmlspecialchars($images->image_intro);
$image_extensions = [".jpg", ".png", ".gif", ".jpeg"];

foreach ($image_extensions as $image_extension) {
	$pos = strpos($intro_img_file, $image_extension);
	if($pos !== false) {
		$intro_img_file_without_extension = explode($image_extension, $intro_img_file);
		$intro_img_file_extension = $image_extension;
		break;
	}
}

// check if retina image exists
$retina_image = false;
if (isset($intro_img_file_extension)) {
	if (file_exists(JPATH_BASE.DIRECTORY_SEPARATOR.$intro_img_file_without_extension[0]."-2x".$intro_img_file_extension)) {
		$retina_image = true;
	}
}
if (isset($images->image_intro) && !empty($images->image_intro)) :
	$imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro;
	$image_size = getimagesize(htmlspecialchars($images->image_intro));
	?>
	<div class="pull-<?php echo htmlspecialchars($imgfloat); ?> item-image"> 
	<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
		<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language)); ?>">
			<img
				<?php if ($images->image_intro_caption) {
					echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_intro_caption) . '"';
				} ?>
				src="<?php echo htmlspecialchars($images->image_intro); ?>"
				width="<?php echo $image_size[0]; ?>"
				height="<?php echo $image_size[1]; ?>"
				<?php if($retina_image === true) { ?>
				srcset="<?php echo JURI::base(true).DIRECTORY_SEPARATOR.$intro_img_file_without_extension[0]."-2x".$intro_img_file_extension; ?> 2x" 
				<?php } ?>
				alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"
				itemprop="thumbnailUrl"
			/>
		</a>
	<?php else : ?>
		<img
			<?php if ($images->image_intro_caption):
				echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_intro_caption) . '"';
			endif; ?>
			src="<?php echo htmlspecialchars($images->image_intro); ?>"
			<?php if($retina_image === true) { ?>
			srcset="<?php echo JURI::base(true).DIRECTORY_SEPARATOR.$intro_img_file_without_extension[0]."-@2x".$intro_img_file_extension; ?> 2x" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"
			<?php } ?>
			alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"
			itemprop="thumbnailUrl"
		/>
	<?php endif; ?>
</div>
<?php endif; ?>

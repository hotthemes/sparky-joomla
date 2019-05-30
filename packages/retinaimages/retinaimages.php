<?php
/*------------------------------------------------------------------------
# "Retina Images" Joomla plugin
# Copyright (C) 2016 HotThemes. All Rights Reserved.
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Author: HotThemes
# Website: http://www.hotjoomlatemplates.com
-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.plugin.plugin');

class plgContentRetinaImages extends JPlugin
{
	
	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{
		
		// checking if there are images in article
		if (strpos($article->text, '<img') === false) {
			return true;
		}
		
		$regex		= '#<img(.*?)>#s';
		$matches	= array();
		
		$fileNameExtension = $this->params->def('fileNameExtension', '-2x');
		
		// find all instances of <img> and put in $matches
		preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);
		
		foreach ($matches as $match) {
				
				// Isolate string inside src of the <img>
				preg_match("/src=\"([^\"]*)\"/", $match[1], $image_src);
				
				// Image name without extension:
				// Since image name can contain dots, we should explode string per .
				// Then join all elements, except the last element.

				$image_name_without_extension = "";
				if (isset($image_src[1])) {
					$image_name_array = explode(".", $image_src[1]);
				}
				$image_name_parts = count($image_name_array);

				foreach ($image_name_array as $image_name_part) {

					if($image_name_part != end($image_name_array)) {
						$image_name_without_extension = $image_name_without_extension . $image_name_part . ".";
					}

				}

				// remove the last dot
				$image_name_without_extension = rtrim($image_name_without_extension, ".");

				// this is retina image
				$retina_image = $image_name_without_extension.$fileNameExtension.'.'.end($image_name_array);

				// if retina image exists AND if there's no srcset already defined
				// add srcset to the <img>

				$srcset_exists = strpos($match[1], "srcset");

				if (file_exists($retina_image) && $srcset_exists === false) {
				    $output = '<img srcset="'.JURI::base().$image_name_without_extension.$fileNameExtension.'.'.end($image_name_array).' 2x"' . $match[1] . '>';
					$article->text = preg_replace( "#<img($match[1])>#s", $output , $article->text );
				}

				// END retina image code
			
		}	
	}
}
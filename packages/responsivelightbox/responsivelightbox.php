<?php
/*------------------------------------------------------------------------
# "Responsive Lightbox" Joomla plugin
# Copyright (C) 2015 HotThemes. All Rights Reserved.
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Author: HotJoomlaTemplates.com
# Website: http://www.hotjoomlatemplates.com
-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.plugin.plugin');

class plgContentResponsiveLightbox extends JPlugin
{

	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{
		
		// checking
		if (strpos($article->text, 'responsivelightbox') === false) {
			return true;
		}
		
		$regex		= '#{responsivelightbox}(.*?){/responsivelightbox}#s';
		$matches	= array();
		
		$lightboxMode = $this->params->def('lightboxMode', 'g');
		$backgroundColor = $this->params->def('backgroundColor', '#EEEEEE');
		$backgroundHoverColor = $this->params->def('backgroundHoverColor', '#FFFFFF');
		$overlay = $this->params->def('overlay', '255,255,255');
		$borderWidth = $this->params->def('borderWidth', '1');
		$borderColor = $this->params->def('borderColor', '#cccccc');
		$borderHoverColor = $this->params->def('borderHoverColor', '#999999');
		$thumbsMarginH = $this->params->def('thumbsMarginH', '10');
		$thumbsMarginV = $this->params->def('thumbsMarginV', '10');
		$thumbsPadding = $this->params->def('thumbsPadding', '3');
		$thumbs_width = $this->params->def('thumbsWidth', '200');
		$thumbs_height = $this->params->def('thumbsHeight', '200');
		$image_quality = $this->params->def('imageQuality', '80');
		
		// $plugin =& JPluginHelper::getPlugin('content', 'responsivelightbox');
		// $pluginParams = new JParameter( $plugin->params );	
		
		// find all instances of plugin and put in $matches
		preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);
		
		$photogallerycount = -1;
		
		foreach ($matches as $match) {
			       
				$photogallerycount++;
				$images_dir = preg_replace("/{.+?}/", "", $match);
				$images_dir[0] = $images_dir[0]."/";
				$images_dir_var = $images_dir[0];
				$images_dir2 = preg_replace("/{.+?}/", "", $match);
				$thumbs_dir = $images_dir[0]."thumbs/";
				
				
				// START gallery code
				
				/* function: creates thumbnails */
				
				if(!function_exists('make_thumb')){			
					function make_thumb($Dir,$Image,$NewDir,$NewImage,$MaxWidth,$MaxHeight,$Quality) {
					  list($ImageWidth,$ImageHeight,$TypeCode)=getimagesize($Dir.$Image);
					  $ImageType=($TypeCode==1?"gif":($TypeCode==2?"jpeg":
								 ($TypeCode==3?"png":FALSE)));
					  $CreateFunction="imagecreatefrom".$ImageType;
					  $OutputFunction="image".$ImageType;
					  if ($ImageType) {
						$Ratio=($ImageHeight/$ImageWidth);
						$ImageSource=$CreateFunction($Dir.$Image);
						if ($ImageWidth > $MaxWidth || $ImageHeight > $MaxHeight) {
						  if ($ImageWidth > $MaxWidth) {
							 $ResizedWidth=$MaxWidth;
							 $ResizedHeight=$ResizedWidth*$Ratio;
						  }
						  else {
							$ResizedWidth=$ImageWidth;
							$ResizedHeight=$ImageHeight;
						  }       
						  if ($ResizedHeight > $MaxHeight) {
							$ResizedHeight=$MaxHeight;
							$ResizedWidth=$ResizedHeight/$Ratio;
						  }      
						  $ResizedImage=imagecreatetruecolor($ResizedWidth,$ResizedHeight);
						  imagecopyresampled($ResizedImage,$ImageSource,0,0,0,0,$ResizedWidth,
											 $ResizedHeight,$ImageWidth,$ImageHeight);
						}
						else {
						  $ResizedWidth=$ImageWidth;
						  $ResizedHeight=$ImageHeight;     
						  $ResizedImage=$ImageSource;
						}   
						$OutputFunction($ResizedImage,$NewDir.$NewImage,$Quality);
						return true;
					  }   
					  else
						return false;
					}
				}
				
				/* function:  returns files from dir */
				if(!function_exists('get_files')){
					function get_files($images_dir_var,$exts = array('jpg')) {
						$files = array();
						if($handle = opendir($images_dir_var)) {
							while(false !== ($file = readdir($handle))) {
								$extension = strtolower(get_file_extension($file));
								if($extension && in_array($extension,$exts)) {
									$files[] = $file;
								}
							}
							closedir($handle);
						}
						return $files;
					}
				}
				
				/* function:  returns a file's extension */
				if(!function_exists('get_file_extension')){
					function get_file_extension($file_name) {
						return substr(strrchr($file_name,'.'),1);
					}
				}

				/** settings **/
				
				//$images_dir = 'preload-images/';
				if(!is_dir($images_dir[0]."thumbs")) {
				       mkdir($images_dir[0]."thumbs", 0777);
				}

				//$thumbs_width = 200;
				//$images_per_row = 3;
				
				// adding CSS and JS in head
				$doc = JFactory::getDocument();
				
				// add your stylesheet
				$doc->addStyleSheet( JURI :: base().'plugins/content/responsivelightbox/css/style.css' );

				// allow multiple galleries on a page
				$UniqueNo = rand();
				
				// style declaration
				$doc->addStyleDeclaration( '

				#responsivelightbox'.$UniqueNo.' {
					text-align: center;
				}

				#responsivelightbox'.$UniqueNo.' ul {
					margin: 0;
					padding: 0;
				}
						
				#responsivelightbox'.$UniqueNo.' li {
					display: inline-block;
					background: none;
					padding: 0;
					margin:'.$thumbsMarginV.'px '.$thumbsMarginH.'px;
				}

				#responsivelightbox'.$UniqueNo.' img {
					border: 0.625em solid rgba( 255, 255, 255, .5 ); /* 10 */
					-webkit-box-shadow: 0 0 0.313em rgba( 0, 0, 0, .05 ); /* 5 */
					box-shadow: 0 0 0.313em rgba( 0, 0, 0, .05 ); /* 5 */
					-webkit-transition: -webkit-box-shadow .3s ease, border-color .3s ease;
					transition: box-shadow .3s ease, border-color .3s ease;
					width:'.$thumbs_width.'px;
					height:'.$thumbs_height.'px;
					border:'.$borderWidth.'px solid '.$borderColor.';
					padding:'.$thumbsPadding.'px;
					background: #eee;
				}

				#responsivelightbox'.$UniqueNo.' img:hover,
				#responsivelightbox'.$UniqueNo.' img:focus {
					-webkit-box-shadow: 0 0 0.938em rgba( 0, 0, 0, .25 ); /* 15 */
					box-shadow: 0 0 0.938em rgba( 0, 0, 0, .25 ); /* 15 */
					border:'.$borderWidth.'px solid '.$borderHoverColor.';
					background: #fff;
				}

				#imagelightbox-overlay {
					background-color: rgba( '.$overlay.', .9 );
				}

				@media only screen and (max-width: 41.250em) {

					#responsivelightbox'.$UniqueNo.' {
						width: 100%;
					}

				}
				
				' );
				
				/** generate photo gallery **/
				
				if($photogallerycount < 1){
				JHtml::_('jquery.framework');
				
				echo '<script src="'.JURI :: base().'plugins/content/responsivelightbox/js/imagelightbox.min.js"></script>';
                }
                $output = '<!-- Hot Responsive Lightbox Plugin starts here -->';
				$output.= '<div id="responsivelightbox'.$UniqueNo.'"><ul>';
				$image_files = get_files($images_dir_var);
				
				sort($image_files);
				
				if(count($image_files)) {
					$index = 0;
					foreach($image_files as $index=>$file) {
						$index++;
						$thumbnail_image = $thumbs_dir."thumb_".$file;
						if(!file_exists($thumbnail_image)) {
							$extension = get_file_extension($thumbnail_image);
							if($extension) {
								make_thumb($images_dir[0],$file,$thumbs_dir,"thumb_".$file,$thumbs_width,$thumbs_height,$image_quality);
							}
						}
						$output.= '<li><a href="'.JURI :: base().'/'.$images_dir[0].$file.'" data-imagelightbox="'.$lightboxMode.'"><img src="'.$thumbnail_image.'" alt="" /></a></li>';
					}
				}
				else {
					$output.= '<p>There are no images in this gallery.</p>';
				}
				$output.= '</ul></div>';
				
				$article->text = preg_replace( "#{responsivelightbox}".$images_dir2[0]."{/responsivelightbox}#s", $output , $article->text );
				
				// END gallery code
			
		}	
	}
}
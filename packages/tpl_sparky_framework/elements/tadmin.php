<?php
/*------------------------------------------------------------------------
# "Sparky Framework" - Joomla Template Framework
# Copyright (C) 2016 HotThemes. All Rights Reserved.
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Author: HotThemes
# Website: http://www.hotjoomlatemplates.com
-------------------------------------------------------------------------*/

defined('JPATH_BASE') or die;
if(!defined('DS')) {
    define("DS", DIRECTORY_SEPARATOR);
}
jimport('joomla.form.formfield');
/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
 

//add undo / redo in toolbar
$dispatcher = JEventDispatcher::getInstance();
//$dispatcher->register('onBeforeRender', 'UndoRedoButtons');

//inserting undo / redo values into newly created database
/*
if(isset($_REQUEST['undo']) && isset($_REQUEST['redo'])){
	$undo	= $_REQUEST['undo'];
	$redo	= $_REQUEST['redo'];
	
	global $db;
	if($db  == null)
		$db = JFactory::getDBO();
	
	$db->setQuery("SELECT * FROM #__sparky_undo_redo_steps");
	$row = $db->loadObjectList();

	if(!count($row)){
		$db->setQuery("INSERT INTO #__sparky_undo_redo_steps (data_undo, data_redo) VALUES (".$db->quote($undo).",".$db->quote($redo).")");
		$db->query();
	}else{
		$id = $row[0]->id;
		$db->setQuery("UPDATE #__sparky_undo_redo_steps SET data_undo=".$db->quote($undo).", data_redo=".$db->quote($redo)." WHERE id=$id");
		$db->query();
	}
	
	echo json_encode(true);
	die;
}
*/

function UndoRedoButtons(){
		
     // Get the application object
	$app = JFactory::getApplication();

	// Run in backend
	if ($app->isAdmin() === true)
	{
		// Get the input object
		$input = $app->input;
		//$template = JFactory::getTemplate();
		// Append button just on Templates
		$db = JFactory::getDbo();
		$db->setQuery("SELECT id from #__template_styles WHERE template like '%sparky%' OR template like '%hot%'");
		$id = $db->loadObjectList();
	   
		foreach($id as $ids){
		if ($input->getCmd('option') === 'com_templates' && $input->getCmd('view', 'style') === 'style' && $input->getCmd('id') == $ids->id)
			{
				// Get an instance of the Toolbar
				$toolbar = JToolbar::getInstance('toolbar');

				// Add your custom button here
				$toolbar->appendButton('Link', 'undo', 'Undo', "");
				$toolbar->appendButton('Link', 'redo', 'Redo', "");
			}
		}
		$pref = $db->getPrefix();
		if( substr($pref, strlen($pref) - 1) != "_"){
			$pref.= "_";
		}
		
		$db->setQuery("SHOW TABLES LIKE '".$pref."sparky_undo_redo_steps%'");
		if(!count($db->loadObjectList())){
			try{
			$db->setQuery("CREATE TABLE `".$pref."sparky_undo_redo_steps` (
						  `id`      int(11) NOT NULL AUTO_INCREMENT,
						  `data_undo` MEDIUMTEXT CHARACTER SET utf8,
						  `data_redo` MEDIUMTEXT CHARACTER SET utf8,
						  PRIMARY KEY (`id`)
						) DEFAULT CHARSET=utf8;");
			$db->query();	
			}
			catch(Exception $e){
				
			}		
		}
	}
}

class JFormFieldTadmin extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'tadmin';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
	    global $TEMPLATE_FOLDER;
	    $TEMPLATE_FOLDER = basename(realpath( dirname(__FILE__) . DIRECTORY_SEPARATOR . '..'));
	
 	    $document = JFactory::getDocument();

 	    // backend CSS
		$document->addStyleSheet(JURI::root(1) . '/templates/'.$TEMPLATE_FOLDER.'/css/admin/tadmin.css');
		$document->addStyleSheet(JURI::root(1) . '/templates/'.$TEMPLATE_FOLDER.'/css/admin/codemirror.css');

		// code mirror
		$document->addScript(JURI::root(1) . '/templates/'.$TEMPLATE_FOLDER.'/js/admin/codemirror/codemirror.js');
	    $document->addScript(JURI::root(1) . '/templates/'.$TEMPLATE_FOLDER.'/js/admin/codemirror/css.js');
	    $document->addScript(JURI::root(1) . '/templates/'.$TEMPLATE_FOLDER.'/js/admin/codemirror/javascript.js');

	    //backend JavaScript
		$document->addScript(JURI::root(1) . '/templates/'.$TEMPLATE_FOLDER.'/js/jquery-ui.min.js');
		$document->addScript(JURI::root(1) . '/templates/'.$TEMPLATE_FOLDER.'/js/admin/jquery.form.js');
	    $document->addScript(JURI::root(1) . '/templates/'.$TEMPLATE_FOLDER.'/js/admin/tadmin.js');
	    //$document->addScript(JURI::root(1) . '/templates/'.$TEMPLATE_FOLDER.'/js/admin/undo_redo.js');
	    $document->addScript(JURI::root(1) . '/templates/'.$TEMPLATE_FOLDER.'/js/admin/bootstrap-multiselect.js');
	    $document->addScript(JURI::root(1) . '/templates/'.$TEMPLATE_FOLDER.'/js/admin/jquery.visible.js');
	
		$lang = JFactory::getLanguage();
		$lpreff= $lang->getTag();
		
		//reading undo / redo values
		/*
		global $db;
		if($db  == null)
			$db = JFactory::getDBO();
		$undo_vals = "";	
		$redo_vals = "";
		
		try{
			$db->setQuery("SELECT * FROM #__sparky_undo_redo_steps");
			$row = $db->loadObjectList();
			if(count($row)){
				$undo_vals = $row[0]->data_undo;
				$redo_vals = $row[0]->data_redo;
			}
		}
		catch(Exception $e){
		}
		*/
		//
		$OUT= '';
		ob_start();		
		?>
		  <script type="text/javascript" >
		   $ = jQuery;
		   var TADMSCRIPTTRANS = {};
		   TADMSCRIPTTRANS.general    = '<?php echo jText::sprintf('TPL_SPARKY_FRAMEWORK_GENERAL'); ?>';
		   var TADMIN_JOOMLABASE      = '<?php echo JURI::root(1); ?>';
		   var TADMIN_TEMPLATE_FOLDER = '<?php echo $TEMPLATE_FOLDER; ?>';
		   var TADMIN_LANG = {
				details: '<?php echo JText::sprintf("TPL_SPARKY_FRAMEWORK_DETAILS"); ?>',
				menusassignment: '<?php echo JText::sprintf("TPL_SPARKY_FRAMEWORK_ASIGNMENT"); ?>'
		   };

		  </script>
		  
		<!--<input type="hidden" id="jform_params_undo" name="jform_params_undo" value='<?php //echo ($undo_vals!="") ? $undo_vals : ""; ?>'>-->
		<!--<input type="hidden" id="jform_params_redo" name="jform_params_redo" value='<?php //echo ($redo_vals!="") ? $redo_vals : ""; ?>'>-->
		  
		<script type="text/javascript">
			//script and ajax call for undo redo saving
			// jQuery(document).on('click','#toolbar-apply button, #toolbar-save button, #toolbar-save-copy button',function(e){
			// 	e.stopImmediatePropagation();
			// 	var undo_data = jQuery("#jform_params_undo").val();
			// 	var redo_data = jQuery("#jform_params_redo").val();
			// 	jQuery.ajax({
			// 		type: "POST",
			// 		dataType: "json",
			// 		data: {undo: undo_data, redo: redo_data},
			// 		success: function (response) {
			// 		},
			// 		error: function(a,b,c){						
			// 		}	
			// 	});
			// });
		</script>
		<?php
		
		$OUT .= ob_get_contents();
		ob_end_clean();
		
		$doc = new DOMDocument(); 
        $doc->load('..'.DS.'templates'.DS.$TEMPLATE_FOLDER.DS.'templateDetails.xml');
		
		// put all module positions and sparky elements from XML file (structure is extension/positions/position) into object 

		$XPositions = $doc->getElementsByTagName( "extension" )->item(0);
		$XPositions = $XPositions->getElementsByTagName( "positions" )->item(0);
		$XPositions = $XPositions->getElementsByTagName( "position" );

		global $tadmin_mpos; 
		global $tadmin_menus; 
		$tadmin_mpos = array();
		$tadmin_menus = array();

		$loop = 0;
		foreach($XPositions as $XPosition) {
			$tadmin_mpos[$loop] = $XPosition->nodeValue;
			$loop++;
		}

		// get all menu types from DB into $tadmin_menus array

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName('menutype'));
		$query->from($db->quoteName('#__menu_types'));
		$db->setQuery($query);
		$tadmin_menus = $db->loadColumn();
	   
        return $OUT;
		
	}
}

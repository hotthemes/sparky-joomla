<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.module.helper' );

//set this to 'false' if you don't want modules to spread to empty modules right of them
$spread_mode = true;

// Get all menu types from DB into $all_menus array
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select($db->quoteName('menutype'));
$query->from($db->quoteName('#__menu_types'));
$db->setQuery($query);
$all_menus = $db->loadColumn();

//READ MODULE GRID START////////////////////////////////////////////////////////

//$module_grid = explode('&',$module_grid);
$module_grid2 = array();
$loop = 0;

if (isset($module_grid)) {
	foreach($module_grid as $name => $row){
		
		$module_grid2[$loop][0] = $name;
		//$module_grid[$loop] = explode('+',$module_grid[$loop]);
		if (stripos($row->position, "joom_content") > -1) {
	    	$module_grid2[$loop][3] = true; 
		} else {
	    	$module_grid2[$loop][3] = false;
		}
		//$module_grid[$loop][2] = explode(',',$module_grid[$loop][2]);
		$module_grid2[$loop][2] = explode(',',$row->position);
		$I = 0;

		for ($I = 0; $I < count($module_grid2[$loop][2]) ; $I++) {
			$module_grid2[$loop][2][$I] = explode('=',$module_grid2[$loop][2][$I]); 
			if (isset($module_grid2[$loop][2][$I][1])) {
				$module_grid2[$loop][2][$I][1] =intval($module_grid2[$loop][2][$I][1]);
			}
			if (isset($module_grid2[$loop][2][$I][2])) {
				$module_grid2[$loop][2][$I][2] =intval($module_grid2[$loop][2][$I][2]);
			}
		}
	   
		if($spread_mode){
			$carry_cell = 0;
			$last_hasm  = -1;
		   
			for ($I = count($module_grid2[$loop][2]) - 1 ;$I >= 0; $I--) {
				if (
					// if no modules in position, and not Sparky element, and not menu
				 	(count(JModuleHelper::getModules($module_grid2[$loop][2][$I][0])) == 0)
				 	&&
				 	$module_grid2[$loop][2][$I][0] != 'joom_content'
				 	&&
				 	$module_grid2[$loop][2][$I][0] != 'logo'
				 	&&
				 	$module_grid2[$loop][2][$I][0] != 'fontresize'
				 	&&
				 	$module_grid2[$loop][2][$I][0] != 'copyright'
				 	&&
				 	(!in_array($module_grid2[$loop][2][$I][0], $all_menus))
			 	) {
			 		if(isset($module_grid2[$loop][2][$I][1]) && isset($module_grid2[$loop][2][$I][2])) {
						$carry_cell += ($module_grid2[$loop][2][$I][1] + $module_grid2[$loop][2][$I][2]);
					}
					$module_grid2[$loop][2][$I][1] = 0;
					$module_grid2[$loop][2][$I][2] = 0;
				} else {
					// otherwise, it's module position with modules published
					$module_grid2[$loop][2][$I][1] += $carry_cell;
					$carry_cell = 0;
					$last_hasm  = $I;
				}
			}
		   
			if ($last_hasm != -1 && $carry_cell > 0) {
				$module_grid2[$loop][2][$last_hasm][1] += $carry_cell; 
			}
		} 
		$loop++;
	}
}

//READ MODULE GRID END////////////////////////////////////////////////////////
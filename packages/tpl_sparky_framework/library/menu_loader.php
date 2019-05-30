<?php
/*------------------------------------------------------------------------
# "Sparky Framework" - Joomla Template Framework
# Copyright (C) 2016 HotThemes. All Rights Reserved.
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Author: HotThemes
# Website: http://www.hotjoomlatemplates.com
-------------------------------------------------------------------------*/?>
<div class="sparky_cell mp_<?php echo $mposition[0]; ?> sparkle<?php echo $mposition[1]; ?>">
	<div class="sparky_menu">
	<?php
		require_once JPATH_ADMINISTRATOR . '/components/com_menus/helpers/menus.php';
		$menuTypes	= MenusHelper::getMenuTypes();

		foreach ($menuTypes as $menutype) {

			if($menutype == $mposition[0]) {

				foreach($mnucfg as $menu_name => $menu){
					if($menu_name == $mposition[0]) {

						// Get title of the menu from db per menutype
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->select($db->quoteName('title'));
						$query->from($db->quoteName('#__menu_types'));
						$query->where($db->quoteName('menutype') . ' LIKE '. $db->quote($mposition[0]));
						$db->setQuery($query);
						$real_menu_name = $db->loadResult();

  						if(
  							((strpos($menu['type'], "navv") || $menu['type'] == "navv") && $menu['show_menu_name_navv']) ||
  							((strpos($menu['type'], "navh") || $menu['type'] == "navh") && $menu['show_menu_name_navh']) ||
  							((strpos($menu['type'], "acc") || $menu['type'] == "acc") && $menu['show_menu_name_acc']) ||
  							((strpos($menu['type'], "offcanvas") || $menu['type'] == "offcanvas") && $menu['show_menu_name_offcanvas']) ||
  							((strpos($menu['type'], "standard") || $menu['type'] == "standard") && $menu['show_menu_name_standard']) ||
  							((strpos($menu['type'], "mega") || $menu['type'] == "mega") && $menu['show_menu_name_mega'])
  						){
  							echo '<h3>'.$real_menu_name.'</h3>';
  						}
  							// this code will render Joomla menu's HTML
							jimport('joomla.application.module.helper');
							$module = JModuleHelper::getModule('mod_menu',$real_menu_name);
							$module->params = "menutype=".$mposition[0]."\nshowAllChildren=1";
							echo JModuleHelper::renderModule($module);
					}
					
				}

			}

		}

	?>
	</div>
</div>
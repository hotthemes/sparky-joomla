<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.module.helper' );

// counting modules in row
$modules_in_row = 0;
foreach($gridRow[2] as $mposition) {

    // number of active modules in the row increases
    $modules_in_row += count(JModuleHelper::getModules($mposition[0]));

    // if position is CONTENT or Sparky feature, we increase number of modules in row
    if ($mposition[0] == "joom_content" || $mposition[0] == "logo" || $mposition[0] == "fontresize" || $mposition[0] == "copyright") {
        $modules_in_row++;
    }

    // if position is in $all_menus array, we increase number of modules in row
    if (in_array($mposition[0], $all_menus)) {
        $modules_in_row++;
    }

}
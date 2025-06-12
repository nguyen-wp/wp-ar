<?php
/**
* @package N3COMMERCIALREALTY 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/

// https://docsv3.redux.io/
// https://devs.redux.io/core-fields/

if ( ! class_exists( 'Redux' ) ) {
	return;
}

require_once 'options/options.php';
require_once 'options/function.php';
// INI TABS
require_once 'tabs/tab-info.php';
require_once 'tabs/tab-tailwind.php';
require_once 'tabs/tab-cdn.php';
require_once 'tabs/tab-css-js.php';
require_once 'tabs/tab-api.php';
require_once 'tabs/tab-dashboard.php';
require_once 'tabs/tab-tool.php';

// CALL ACTION 
// require_once 'options/helps.php';
// require_once 'options/docs.php';
require_once 'options/init.php';


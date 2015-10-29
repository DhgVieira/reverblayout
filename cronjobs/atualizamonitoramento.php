<?php
// ini_set('include_path', ini_get('include_path') . ':/reverbcity.com/library');

// define('APPLICATION_PATH','/reverbcity.com/application');
// define('APPLICATION_ENVIRONMENT','production');

// //Include the loader (for loading ZF resources)
// require_once '../library/Zend/Loader.php';

// //Include the model (to access the Sites model in this case)
// require_once('../application/modules/user/models/Cestas.php');

// Zend_Loader::registerAutoload();

// $configuration = new Zend_Config_Ini(
//     APPLICATION_PATH . '/config/config.ini',
//     APPLICATION_ENVIRONMENT
// );

// // DB adapter
// $dbAdapter = Zend_Db::factory($configuration->database);

// // DB table setup
// Zend_Db_Table_Abstract::setDefaultAdapter($dbAdapter);

//defino o formato de data
					date_default_timezone_set('America/Sao_Paulo');
				$data_hoje = date("Y-m-d H:i:s");

				echo $data_hoje;die();

?>
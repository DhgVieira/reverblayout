<?php

define('DB_SERVER', '186.202.189.89');
define('DB_USERNAME', 'dev_rvb');
define('DB_PASSWORD', 'uiw7389s2');
define('DB_DATABASE', 'dev_rvb');
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());
?>

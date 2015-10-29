<?php 
include 'auth.php';
include 'lib.php';

$action 				= mysql_real_escape_string($_POST['action']); 
$pagina 				= mysql_real_escape_string($_POST['pg']);
$updateRecordsArray 	= $_POST['recordsArray'];

$pagina--;

if ($action == "updateRecordsListings"){
	
	$listingCounter = $pagina*140+1;
	foreach ($updateRecordsArray as $recordIDValue) {
		
		$query = "UPDATE produtos SET NR_ORDEM_SALE_PRRC = " . $listingCounter . " WHERE NR_SEQ_PRODUTO_PRRC = " . $recordIDValue;
		mysql_query($query);
		$listingCounter++;	
	}
}
?>
<?php 
include 'auth.php';
include 'lib.php';

$action 				= mysql_real_escape_string($_POST['action']); 
$pagina 				= mysql_real_escape_string($_POST['pg']);
$updateRecordsArray 	= $_POST['recordsArray'];

$pagina--;

if ($action == "updateRecordsListings"){
	
	$listingCounter = $pagina*105+1;
	foreach ($updateRecordsArray as $recordIDValue) {
		
		$query = "UPDATE me_fotos SET NR_POSICAO_FORC = " . $listingCounter . " WHERE NR_SEQ_FOTO_FORC = " . $recordIDValue;
		mysql_query($query);
		$listingCounter++;	
	}
}
?>
<?
include 'auth.php';
include 'lib.php';

$vl_primeira	   = request("valor_pc");
$st_primeira	   = request("status_pc");
$msg_primeira	   = request("msg_pc");
$st_aniver		   = request("status_ni");
$msg_aniver		   = request("msg_ni");
$st_frete		   = request("status_frete");
$vl_frete		   = request("valor_frete");

$vl_primeira_int = explode(",", $vl_primeira);
$vl_primeira = $vl_primeira_int[0];

$vl_frete_int = explode(",", $vl_frete);
$vl_frete = $vl_frete_int[0];

// $msg_primeira = utf8_encode($msg_primeira);

// $msg_aniver = utf8_encode($msg_aniver);


$str = "UPDATE
			promocoes 
		SET 
			st_primeira_compra  = $st_primeira, 
			vl_primeira_compra  = $vl_primeira, 
			msg_primeira_compra = '$msg_primeira', 
			st_promo_niver = $st_aniver,
			msg_promo_niver = '$msg_aniver',
			st_frete_londrina = $st_frete,
			vl_frete_londrina	= $vl_frete";


$st = mysql_query($str);



GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou Promos");

mysql_close($con);

Header("Location: promocoes.php");
?>
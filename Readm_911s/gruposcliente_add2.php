<?php 
include 'auth.php';
include 'lib.php';

$id_cadcli = request ("id_cadcli");
$idc = request("idc");
if (!$id_cadcli){
	$msg = "Voce precisa informar o cliente!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

$grupo = $_POST["grupo"];
if ($grupo == 0){
	if (!$idc) {
        $msg = "Voce precisa informar o Grupo!";
    	$msg = str_replace(" ","%20", $msg);
    	Header("Location: erro.php?msg=$msg");
        exit();
    }else{
    	Header("Location: compras_ver.php?idc=$idc");
        exit();
    }
}

foreach ($grupo as $grp){
	//echo $grp.'<br>';
	$sql = "select NR_SEQ_CADASTRO_CADGP 
			from cadastros_grupocad
			where NR_SEQ_CADASTRO_CADGP = '$id_cadcli' and NR_SEQ_GRUPO_CADGP = '$grp'";
	$st = mysql_query($sql);
	if (mysql_num_rows($st) > 0 ){		
	}else{
		$str = "INSERT INTO cadastros_grupocad (NR_SEQ_CADASTRO_CADGP,NR_SEQ_GRUPO_CADGP) VALUES ('$id_cadcli', '$grp')";
		$sr = mysql_query($str);
	}	
}
//GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Add grupo o cliente $d_cadcli");
mysql_close($con);

if (!$idc) {
    Header("Location: compras.php?st=P");
}else{
   	Header("Location: compras_ver.php?idc=$idc");
    exit();
}


?>
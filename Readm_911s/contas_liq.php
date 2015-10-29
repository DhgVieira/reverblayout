<?php 
include 'auth.php';
include 'lib.php';

$id_conta = request("id_conta");
$ds_tipo = request("ds_tipo");
$tipo = request("tipo");
//***** ALTERA O TIPO DA CONTA 
// D = a pagar
// P = paga
// C = a receber
// R = recebida
//*****
if ($ds_tipo == 'D'){
	$sql = "UPDATE contas SET DS_TIPO_CORC = 'P', DT_TIPO_CORC = sysdate() WHERE NR_SEQ_CONTA_CORC = $id_conta";
	$st = mysql_query($sql);
	GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou conta $id_conta para PAGAS ");	
}

if ($ds_tipo == 'P'){
	$sql = "UPDATE contas SET DS_TIPO_CORC = 'D', DT_TIPO_CORC = sysdate() WHERE NR_SEQ_CONTA_CORC = $id_conta";
	$st = mysql_query($sql);
	GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou conta $id_conta para A PAGAR ");
}

if ($ds_tipo == 'C'){
	$sql = "UPDATE contas SET DS_TIPO_CORC = 'R', DT_TIPO_CORC = sysdate() WHERE NR_SEQ_CONTA_CORC = $id_conta";
	$st = mysql_query($sql);
	GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou conta $id_conta para RECEBIDAS ");
}
if ($ds_tipo == 'R'){
	$sql = "UPDATE contas SET DS_TIPO_CORC = 'C', DT_TIPO_CORC = sysdate() WHERE NR_SEQ_CONTA_CORC = $id_conta";
	$st = mysql_query($sql);
	GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou conta $id_conta para A RECEBER ");
}

$pagina = "contas_apagar.php";
switch($ds_tipo){
    case 'D':
        $pagina = "contas_apagar.php";
        break;
    case 'P':
        $pagina = "contas_pagas.php";
        break;
    case 'C':
        $pagina = "contas_areceber.php";
        break;
    case 'R':
        $pagina = "contas_recebidas.php";
        break;
    case 'U':
        $pagina = "contas_unificado.php";
        break;
}

mysql_close($con);
Header("Location: $pagina");
exit();
?>
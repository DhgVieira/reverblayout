<?php
include 'auth.php';
include 'lib.php';

$idc 		= request("idc");
$loja 		= request("loja");
$categoria 	= request("categoria");
$subcategoria = request("subcategoria");
$descricao 	= request("descricao");
$valor 		= request("valor");
$data 		= request("data");
$tipo 		= request("tipo");
$forma      = request("forma");

if (!$descricao){
	$msg = "Voce precisa informar a descricao da Conta!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$valor) $valor = 0;
$valor = str_replace(",",".",$valor);
  
$str = "UPDATE contas SET NR_SEQ_CATCONTA_CORC = $categoria, NR_SEQ_SUBCATCONTA_CORC = $subcategoria, NR_SEQ_LOJA_CORC = $loja, DS_DESCRICAO_CORC = '$descricao',
						  NR_FORMA_PGTO_CORC = $forma, VL_CONTA_CORC = $valor, DT_VCTO_CORC = STR_TO_DATE('$data','%d/%m/%Y'), DS_TIPO_CORC = '$tipo' where NR_SEQ_CONTA_CORC = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou lancamento do Contas $idc");

mysql_close($con);

$pagina = "contas_apagar.php";
switch($tipo){
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

Header("Location: $pagina");
exit();
?>
<?php
include 'auth.php';
include 'lib.php';

$loja 		= request("loja");
$categoria 	= request("categoria");
$subcategoria = request("subcategoria");
$descricao 	= request("descricao");
$descricao2 	= request("descricao2");
$valor 		= request("valor");
$data 		= request("data");
$tipo 		= request("tipo");
$forma      = request("forma");
$idcat      = request("idcat");

$dataemiss  = request("dataemiss");
$nrdcto     = request("nrdcto");
$periodo    = request("periodo");
$nrvezes    = request("nrvezes");

if (!$nrvezes) $nrvezes = 1;
if (!$dataemiss) $dataemiss = date("d/m/Y");
if (!$periodo) $periodo = 1;
if (!$nrdcto) $nrdcto = "-";
if (!$descricao) $descricao = 0;

if (!$descricao2){
	$msg = "Voce precisa informar a descricao da Conta!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (is_numeric($idcat)){
    if (!$valor) $valor = 0;
    $valor = str_replace(",",".",$valor);
    
    if ($periodo > 1){
        for ($x=1;$x<=$nrvezes;$x++){
            $str = "INSERT INTO contas (NR_REPETIR_CORC, NR_PERIODICIDADE_CORC, DS_NRDOCTO_CORC, NR_SEQ_CATCONTA_CORC, NR_SEQ_SUBCATCONTA_CORC, NR_SEQ_LOJA_CORC, DS_DESCRICAO_CORC, VL_CONTA_CORC, DT_CADASTRO_CORC, DT_VCTO_CORC, DS_TIPO_CORC, NR_FORMA_PGTO_CORC, NR_SEQ_DESCRICAO_CORC)
    				 VALUES ($nrvezes, $periodo, '$nrdcto', $idcat, $subcategoria, $loja, '$descricao2', $valor, STR_TO_DATE('$dataemiss','%d/%m/%Y'), STR_TO_DATE('$data','%d/%m/%Y'), '$tipo', $forma, $descricao)";
            $st = mysql_query($str);
            
            $data = dateAdd_dias($data,$periodo);
            GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inlcuiu lancamento no contas parcela $x/$nrvezes");
        }
    }else{
        $str = "INSERT INTO contas (NR_REPETIR_CORC, NR_PERIODICIDADE_CORC, DS_NRDOCTO_CORC, NR_SEQ_CATCONTA_CORC, NR_SEQ_SUBCATCONTA_CORC, NR_SEQ_LOJA_CORC, DS_DESCRICAO_CORC, VL_CONTA_CORC, DT_CADASTRO_CORC, DT_VCTO_CORC, DS_TIPO_CORC, NR_FORMA_PGTO_CORC, NR_SEQ_DESCRICAO_CORC)
    				 VALUES ($nrvezes, $periodo, '$nrdcto', $idcat, $subcategoria, $loja, '$descricao2', $valor, STR_TO_DATE('$dataemiss','%d/%m/%Y'), STR_TO_DATE('$data','%d/%m/%Y'), '$tipo', $forma, $descricao)";
        $st = mysql_query($str);
        GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inlcuiu lancamento no contas");
    }
    
    mysql_close($con);

		list($datanova, $hora) = explode(" ",$data);
		list($dia, $mes, $ano) = explode("/",$datanova);
		$dataini = mktime ( 0, 0, 0, $mes ,$dia, $ano );
		$dataini= strftime("%d/%m/%Y 00:00:00", $dataini);
		$datafim = mktime ( 0, 0, 0, $mes ,$dia, $ano );
		$datafim= strftime("%d/%m/%Y 23:59:59", $datafim);
}

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

Header("Location: $pagina?dataini=$dataini&datafim=$datafim");
exit();
?>
<?php
include 'auth.php';
include 'lib.php';

$idc = request("idc");
$tipo = request("tp");

$str = "INSERT INTO contas (
			NR_SEQ_CATCONTA_CORC,
			NR_SEQ_SUBCATCONTA_CORC,
			NR_SEQ_LOJA_CORC,
			NR_FORMA_PGTO_CORC,
			DS_DESCRICAO_CORC,
			VL_CONTA_CORC,
			DT_CADASTRO_CORC,
			DT_VCTO_CORC,
			DS_TIPO_CORC,
			DT_TIPO_CORC
) SELECT 
			NR_SEQ_CATCONTA_CORC,
			NR_SEQ_SUBCATCONTA_CORC,
			NR_SEQ_LOJA_CORC,
			NR_FORMA_PGTO_CORC,
			DS_DESCRICAO_CORC,
			VL_CONTA_CORC,
			sysdate(),
			DATE_ADD(DT_VCTO_CORC, INTERVAL 1 MONTH),
			DS_TIPO_CORC,
			DT_TIPO_CORC
 FROM contas WHERE NR_SEQ_CONTA_CORC = $idc";
 
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Jogou lancamento do Contas $idc para mes seguinte");

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
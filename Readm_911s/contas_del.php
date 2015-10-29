<?php 
include 'auth.php';
include 'lib.php';

$idc = request("idc");
$tp = request("tp");

$str = "DELETE FROM contas WHERE NR_SEQ_CONTA_CORC = $idc";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Deletou lancamento no contas $idc");

mysql_close($con);

$pagina = "contas_apagar.php";
switch($tp){
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
?>
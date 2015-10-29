<?php
include 'auth.php';
include 'lib.php';

$avisemes = $_POST['selec'];

$msg = "";
$msg = "Nenhum registro foi deletado!";   

if ($avisemes){
    foreach ($avisemes as $idav) {
        $str = "DELETE FROM aviseme WHERE NR_SEQ_AVISEME_AVRC = $idav";
        $st = mysql_query($str);
        $msg = "Registro(s) excluidos com sucesso!";
    }

    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Apagou registros do avise-me (lote)");
}
?>
<script language="JavaScript">
   alert('<?php echo $msg; ?>');
   window.location.href=('grupos_aviso2.php');
</script>
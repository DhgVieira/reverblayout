<?php
include 'auth.php';
include 'lib.php';

$idf 		= request("idf");
$dia 		= request("dia");
$mes 		= request("mes");
$ano 		= request("ano");
$descri		= request("descricao");
$horas		= request("horas");

$data = $ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($dia,2,"0",STR_PAD_LEFT);

$str = "INSERT INTO funcionarios_ponto_exc (NR_SEQ_FUNCIONARIO_PERC, NR_SEQ_USUARIO_PERC, DT_EXCESSAO_PERC,
        DS_MOTIVO_PERC, DS_TEMPO_PERC) VALUES ($idf,$SS_logadm,'$data','$descri','$horas')";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"$SS_logadm Adicionou Exceзгo no ponto: $idf | $data");

mysql_close($con);

Header("Location: ponto2.php?id=$idf&mes=$mes&ano=$ano");
exit();
?>
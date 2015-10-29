<?php
include 'auth.php';
include 'lib.php';

$idf 		= request("f");
$dia 		= request("d");
$mes 		= request("mes");
$ano 		= request("ano");
$acao		= request("a");

$data = $ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($dia,2,"0",STR_PAD_LEFT);

if ($SS_nivel > 100){

    if ($acao == "I"){
        $str = "INSERT INTO funcionarios_ponto_aut (NR_SEQ_FUNCIONARIO_EARC, NR_SEQ_USUARIO_EARC, DT_AUTORIZADA_EARC,
            DT_AUTORIZACAO_EARC) VALUES ($idf,$SS_logadm,'$data',SYSDATE())";
        $st = mysql_query($str);
        GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"$SS_logadm Autorizou Extra no ponto: $idf | $data");
    }else{
        $str = "DELETE FROM funcionarios_ponto_aut WHERE NR_SEQ_FUNCIONARIO_EARC = $idf AND DT_AUTORIZADA_EARC = '$data'";
        $st = mysql_query($str);
        GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"$SS_logadm Desautorizou Extra no ponto: $idf | $data");
    }

}

mysql_close($con);

Header("Location: ponto2.php?id=$idf&mes=$mes&ano=$ano");
exit();
?>
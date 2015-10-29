<?php
include 'auth.php';
include 'lib.php';

$func = 1;

$msg = "";

$sql = "select TIMESTAMPDIFF(SECOND,DT_REGISTRO_FRRC,SYSDATE()), DS_FUNCIONARIO_FURC from funcionarios_ponto, 
        funcionarios WHERE NR_SEQ_FUNCIONARIO_FRRC = NR_SEQ_FUNCIONARIO_FURC AND 
        NR_SEQ_FUNCIONARIO_FRRC = $func ORDER BY DT_REGISTRO_FRRC desc LIMIT 1";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_row($st);
    if ($row[0] < 300){
        $msg = urlencode("Seu registro j&aacute; foi efetuado!");
    }else{
        $str = "INSERT INTO funcionarios_ponto (NR_SEQ_FUNCIONARIO_FRRC, DT_REGISTRO_FRRC) VALUES ($func,sysdate())";
        $st = mysql_query($str);
        $msg = urlencode("Batida Registrada!");
    }
}

mysql_close($con);

if ($SS_logadm == 1){
    Header("Location: ponto2.php?id=$func&mes=".date("m")."&ano=".date("Y"));
    exit();
}else{
    Header("Location: index.php?ms=$msg");
    exit();
}
?>
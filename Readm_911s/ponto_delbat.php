<?php
include 'auth.php';
include 'lib.php';

$func = request("func");
$idb = request("idb");
$mes = request("mes");
$ano = request("ano");

$bat = request("bat");

$msg = "";

$sql = "DELETE FROM funcionarios_ponto WHERE NR_SEQ_REGISTRO_FRRC = $idb";
$st = mysql_query($sql);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"$SS_logadm Excluiu registro no ponto: $idb | $func | $mes/$ano");

$sql2 = "select DS_FUNCIONARIO_FURC from funcionarios, funcionarios_ponto_just where
		NR_SEQ_FUNCIONARIO_FURC = NR_SEQ_FUNCIONARIO_JUPO and NR_SEQ_FUNCIONARIO_FURC = $func limit 1";
$st = mysql_query($sql2);
if (mysql_num_rows($st) > 0) {
    $row2 = mysql_fetch_row($st);
    $funcionario = $row2[0];
}

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                <p>O usuário da adm: <strong>'.$SS_login.'</strong> excluiu a seguinte batida do funcionário <strong>'.utf8_decode($funcionario).'</strong>:</p> 
                
              </div>    
              <div style="background-color: #dcddde; padding: 15px 10px 15px 25px; font-family:Verdana;font-size:11px;color: #646464; width: 565px; margin: 25px 0 25px 0;">
                  <strong>Batida:</strong> '.date("d/m/Y G:i",strtotime($bat)).'
              </div>
                <p style="font-family:Verdana;font-size:11px;color: #555555;padding: 0 25px 0 25px;">
                Para acessar o ponto do funcionário, clique no link abaixo:
                <br /><br />
                http://www.reverbcity.com/Readm_911s/ponto2.php?id='.$func.'&mes='.$mes.'&ano='.$ano.' ou <a href=http://www.reverbcity.com/Readm_911s/ponto2.php?id='.$func.'&mes='.$mes.'&ano='.$ano.'>clique aqui</a>
                <br /><br /></p>
              ';
    $corpo = IncluiPapelCarta("sistema",$texto,"ALTERAÇÃO NO PONTO");

    EnviaMailer("atendimento@reverbcity.com","Reverbcity","gustavo@reverbcity.com","Tony","","Alteracao no ponto do funcionario $funcionario",$corpo);

mysql_close($con);

Header("Location: ponto2.php?id=$func&mes=".$mes."&ano=".$ano);
exit();
?>
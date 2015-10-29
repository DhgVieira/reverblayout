<?php
include 'auth.php';
include 'lib.php';

$idf 		= request("idf");
$mes 		= request("mes");
$ano 		= request("ano");
$dataini 	= FormataDataMysql(request("dataini"));

//$dataini = date("Y-m-d G:i:s", strtotime($dataini)); 

$str = "INSERT INTO funcionarios_ponto (NR_SEQ_FUNCIONARIO_FRRC, DT_REGISTRO_FRRC) VALUES ($idf,'$dataini')";

$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"$SS_logadm Adicionou registro no ponto: $idf | $dataini");

$sql2 = "select DS_FUNCIONARIO_FURC from funcionarios, funcionarios_ponto_just where
		NR_SEQ_FUNCIONARIO_FURC = NR_SEQ_FUNCIONARIO_JUPO and NR_SEQ_FUNCIONARIO_FURC = $idf limit 1";
$st = mysql_query($sql2);
if (mysql_num_rows($st) > 0) {
    $row2 = mysql_fetch_row($st);
    $funcionario = $row2[0];
}

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                <p>O usuário da adm: <strong>'.$SS_login.'</strong> adicionou a seguinte batida do funcionário <strong>'.utf8_decode($funcionario).'</strong>:</p> 
                
              </div>    
              <div style="background-color: #dcddde; padding: 15px 10px 15px 25px; font-family:Verdana;font-size:11px;color: #646464; width: 565px; margin: 25px 0 25px 0;">
                  <strong>Batida:</strong> '.date("d/m/Y G:i",strtotime($dataini)).'
              </div>
                <p style="font-family:Verdana;font-size:11px;color: #555555;padding: 0 25px 0 25px;">
                Para acessar o ponto do funcionário, clique no link abaixo:
                <br /><br />
                http://www.reverbcity.com/Readm_911s/ponto2.php?id='.$idf.'&mes='.$mes.'&ano='.$ano.' ou <a href=http://www.reverbcity.com/Readm_911s/ponto2.php?id='.$idf.'&mes='.$mes.'&ano='.$ano.'>clique aqui</a>
                <br /><br /></p>
              ';
$corpo = IncluiPapelCarta("sistema",$texto,"ALTERA&Ccedil;&Atilde;O NO PONTO");

EnviaMailer("atendimento@reverbcity.com","Reverbcity","contato@reverbcity.com","Tony","","Alteracao no ponto do funcionario $funcionario",$corpo);

mysql_close($con);

Header("Location: ponto2.php?id=$idf&mes=$mes&ano=$ano");
exit();
?>
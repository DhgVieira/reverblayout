<?php 
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$pg = request("pg");

$sql = "UPDATE produtos SET DS_CLASSIC_PRRC = 'N' WHERE NR_SEQ_PRODUTO_PRRC = $idp";
$st = mysql_query($sql);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Mudou produto $idp para o classics");

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
            <p>O funcionário <strong>'.utf8_decode($SS_login).'</strong> retirou do classics o seguinte produto:</p> 
          </div>    
          <div style="background-color: #dcddde; padding: 15px 10px 15px 25px; font-family:Verdana;font-size:11px;color: #646464; width: 565px; margin: 25px 0 25px 0;">
               <strong>Produto:</strong> http://www.reverbcity.com/Readm_911s/produto.php?idp='.$idp.' ou <a href=http://www.reverbcity.com/Readm_911s/produto.php?idp='.$idp.'>Clique Aqui</a>
          </div>
            <br /><br />
          ';
$corpo = IncluiPapelCarta("sistema",$texto,"PRODUTO RETIRADO DO CLASSICS");

EnviaMailer("atendimento@reverbcity.com","Reverbcity","desenvolvimento@reverbcity.com","Daniel","Produto Retirado do Classics!",$corpo);


mysql_close($con);

Header("Location: classics.php?pagina=$pg");
?>
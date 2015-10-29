<?php
include 'lib.php';

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 25px 25px; width: 550px;">
                <strong>As pessoas abaixo se cadastraram ontem no site:</strong>
                <br /><br />
                A partir de agora, além de poder comprar nossos produtos online, eles poderão participar da nossa rede social, por isso, adicione-o(a)s como amigos e envie um scrap de boas vindas :)
                <br />
          </div>    
          <div style="background-color: #dcddde; padding: 25px; font-family:Verdana;font-size:12px;color: #313131; width: 550px;">';
          
$sql = "select NR_SEQ_CADASTRO_CASO, DS_NOME_CASO, DS_EMAIL_CASO from cadastros where 
        DAY(DT_CADASTRO_CASO) = DAY(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) AND
        MONTH(DT_CADASTRO_CASO) = MONTH(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) AND
        YEAR(DT_CADASTRO_CASO) = YEAR(DATE_SUB(SYSDATE(), INTERVAL 1 DAY))";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $nrcad	= $row[0];
        $nome	= utf8_decode($row[1]);
        $email	= $row[2];
    
        $texto .= "        	<strong>$nome</strong> ($email)<br />";
        $texto .= "        	Link do Me: http://www.reverbcity.com/me/me_perfil.php?idme=$nrcad ou <a href=http://www.reverbcity.com/me/me_perfil.php?idme=$nrcad>Clique Aqui</a><br /><br />";
       
    }
}

$texto .= "</div>";
$corpo = IncluiPapelCarta("sistema",$texto,"NOVOS CADASTROS REVERBCITY!"); 

EnviaEmailNovo("news@reverbcity.com","Reverbcity","marcio@reverbcity.com","","","Novos cadastros Reverbcity!", $corpo);
EnviaEmailNovo("news@reverbcity.com","Reverbcity","campana@reverbcity.com","","","Novos cadastros Reverbcity!", $corpo);

mysql_close($con);
?>
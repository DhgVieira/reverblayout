<?php
include 'lib.php';
$sql = "select NR_SEQ_FUNCIONARIO_FURC from funcionarios";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
while($row = mysql_fetch_row($st)) {
$nrfunc	= $row[0];
$testa = VerificaExtraAnt($nrfunc);
if ($testa[0] && $testa[2] > 600){
$str = "INSERT INTO funcionarios_ponto_just (NR_SEQ_FUNCIONARIO_JUPO, DT_PONTO_JUPO, ST_JUSTIFICADO_JUPO, NR_SEGUNDOS_JUPO)
values ($nrfunc,'".$testa[1]."','N', ".$testa[2].");";
$st2 = mysql_query($str);
}
}
}
// $texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 25px 25px; width: 550px;">
// <strong>As pessoas abaixo se cadastraram ontem no site:</strong>
// <br /><br />
// A partir de agora, além de poder comprar nossos produtos online, eles poderão participar da nossa rede social, por isso, adicione-o(a)s como amigos e envie um scrap de boas vindas :)
// <br />
// </div>    
// <div style="background-color: #dcddde; padding: 25px; font-family:Verdana;font-size:12px;color: #313131; width: 550px;">';

// $sql = "select NR_SEQ_CADASTRO_CASO, DS_NOME_CASO, DS_EMAIL_CASO from cadastros where 
// DAY(DT_CADASTRO_CASO) = DAY(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) AND
// MONTH(DT_CADASTRO_CASO) = MONTH(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) AND
// YEAR(DT_CADASTRO_CASO) = YEAR(DATE_SUB(SYSDATE(), INTERVAL 1 DAY))";
// $st = mysql_query($sql);

// if (mysql_num_rows($st) > 0) {
// while($row = mysql_fetch_row($st)) {
// $nrcad	= $row[0];
// $nome	= utf8_decode($row[1]);
// $email	= $row[2];

// $texto .= "        	<strong>$nome</strong> ($email)<br />";
// $texto .= "        	Link do Me: http://www.reverbcity.com/me/me_perfil.php?idme=$nrcad ou <a href=http://www.reverbcity.com/me/me_perfil.php?idme=$nrcad>Clique Aqui</a><br /><br />";

// }
// }

// $texto .= "</div>";
// $corpo = IncluiPapelCarta("sistema",$texto,"NOVOS CADASTROS REVERBCITY!"); 

// EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity","compras@reverbcity.com","","","Novos cadastros Reverbcity!", $corpo);
// EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity","contato@reverbcity.com","","","Novos cadastros Reverbcity!", $corpo);
// EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity","vendas@reverbcity.com","","","Novos cadastros Reverbcity!", $corpo);
// EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity","marcio@reverbcity.com","","","Novos cadastros Reverbcity!", $corpo);
// EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity","marketing@reverbcity.com","","","Novos cadastros Reverbcity!", $corpo);
// EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity","diego@reverbcity.com","","","Novos cadastros Reverbcity!", $corpo);

$str = "update produtos set VL_PROMO_PRRC = null where VL_PRODUTO_PRRC = VL_PROMO_PRRC";
$st = mysql_query($str);
$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
<p>Segue abaixo o link para o estoque atual de Londrina/Site:</p> 
</div>    
<div style="background-color: #dcddde; padding: 15px 10px 15px 15px; font-family:Verdana;font-size:11px;color: #646464; width: 575px; margin: 25px 0 25px 0;">
&nbsp;&nbsp;<a href="http://www.reverbcity.com/Readm_911s/xx_estoq.php?data=' . date("Y-m-d") . '">http://www.reverbcity.com/Readm_911s/xx_estoq.php?data=' . date("Y-m-d") . '</a>
</div>
<p style="font-family:Verdana;font-size:11px;color: #555555;padding: 0 25px 0 25px;">
Para acessá-lo você precisa estar logado na adm Londrina com um usuário válido.
<br /> 
</p>';

$corpo = IncluiPapelCarta("sistema",utf8_encode($texto),"ESTOQUE LONDRINA");

EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity","contato@reverbcity.com","","","Estoque Londrina - ".date("d/m/Y"), $corpo);
EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity","marketing@reverbcity.com","","","Estoque Londrina - ".date("d/m/Y"), $corpo);
EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity","diego@reverbcity.com","","","Estoque Londrina - ".date("d/m/Y"), $corpo);
EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity","gustavo@reverbcity.com","","","Estoque Londrina - ".date("d/m/Y"), $corpo);
EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity","vendas@reverbcity.com","","","Estoque Londrina - ".date("d/m/Y"), $corpo);
EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity","atendimento@reverbcity.com","","","Estoque Londrina - ".date("d/m/Y"), $corpo);
EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity","janaina@reverbcity.com","","","Estoque Londrina - ".date("d/m/Y"), $corpo);
EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity","moda@reverbcity.com","","","Estoque Londrina - ".date("d/m/Y"), $corpo);

$corpo = "";

$sql = "select NR_SEQ_CADASTRO_CASO, DS_NOME_CASO, DS_EMAIL_CASO, DS_DDDCEL_CASO,
DS_CELULAR_CASO, ST_ENVIOSMS_CACH, ST_BLOQUEIOMAIL_CACH from cadastros
where DATEDIFF(sysdate(),DT_CADASTRO_CASO) = 25";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
while($row = mysql_fetch_row($st)) {
$nrcad	= $row[0];
$nome	= $row[1];
$email	= $row[2];
$celddd  = $row[3];
$celular = $row[4];
$enviar  = $row[5];
$stbloq  = $row[6];

$sql2 = "select NR_SEQ_COMPRA_COSO from compras where NR_SEQ_CADASTRO_COSO = $nrcad and ST_COMPRA_COSO <> 'C'";
$st2 = mysql_query($sql2);

if (mysql_num_rows($st2) <= 0) {
$subject  = "Reverbcity - 15% off na primeira compra!";

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
<p>Ol&aacute; <strong>'.$nome.'</strong>,</p>

<p>Voc&ecirc; fez o cadastro no nosso site mas at&eacute; agora n&atilde;o fez uma compra :(</p> 

<p>Pedidos a partir de R$59 em itens fora de promo&ccedil;&atilde;o ganham 15% de desconto para serem usando em uma pr&oacute;xima compra em at&eacute; 90 dias. </p>

<p><strong>Aproveite!</strong></p>
</div>    
';

$corpo = IncluiPapelCarta("padrao",$texto,"&Uacute;LTIMOS DIAS PARA GANHAR");

EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$email,"","",$subject, $corpo);

if ($enviar == "S" && $stbloq == "N"){
$celddd = str_replace("(","",$celddd);
$celddd = str_replace(")","",$celddd);
$celddd = str_replace(" ","",$celddd);

$celular = str_replace("-","",$celular);
$celular = str_replace(".","",$celular);
$celular = str_replace("/","",$celular);
$celular = str_replace("=","",$celular);
$celular = str_replace(" ","",$celular);

$celularcomp = $celddd.$celular;

$texto = "Aproveite os ultimos 5 dias pra vc fazer uma compra (a partir de $$59) e ganhar 15% http://rvb.la";

if (substr($celularcomp,0,1) == "0"){
$celularcomp = substr($celularcomp,1,strlen($celularcomp));
}

if (strlen($celularcomp)==10 || strlen($celularcomp)==11){
EnviaSMS(1,$nrcad,$celularcomp,$texto);   
$x++;
}
}
}
}
}

mysql_close($con);
?>
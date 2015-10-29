<?php
include 'auth.php';
include 'lib.php';

$idp = request("idp");
$marca = request("m");
$pos = request("pos");

if (!$marca) {
	$marca = "N";
}

$str = "UPDATE produtos SET ST_MARCA_PRRC = '$marca' where NR_SEQ_PRODUTO_PRRC = $idp";
$st = mysql_query($str);

if ($marca == "S"){
    $corpo = "<table width=\"557\" height=\"400\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
    $corpo .= "<tr><td width=\"557\" height=\"87\" valign=\"bottom\" colspan=\"3\"><img src=\"http://www.reverbcity.com/mailing/mail/images/top_mailing.gif\" width=\"557\" height=\"87\"></td>";
    $corpo .= "</tr><tr>";
    $corpo .= "<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
    $corpo .= "<td><table width=\"100%\" cellpadding=\"3\" cellspacing=\"3\">";
    $corpo .= "<tr><td style=\"font-family:Arial, Helvetica, sans-serif;\" width=\"555\">";
    $corpo .= "<strong>Produto marcado para Produção!</strong>";
    $corpo .= "<br /><br />";
    $corpo .= "Acesso a lista: http://www.reverbcity.com/Readm_911s/grupos_marcados.php<br />";
    $corpo .= "<br /><br />";
    $corpo .= "Reverbcity Skynet System<br />";
    $corpo .= "www.reverbcity.com";
    $corpo .= "</td></tr>";
    $corpo .= "</table></td>";
    $corpo .= "<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
    $corpo .= "</tr><tr>";
    $corpo .= "<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
    $corpo .= "<td height=\"1\">&nbsp;</td>";
    $corpo .= "<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
    $corpo .= "</tr><tr><td width=\"557\" height=\"26\" colspan=\"3\" valign=\"top\"><img src=\"http://www.reverbcity.com/mailing/mail/images/rod_mailing.gif\" width=\"557\" height=\"26\" border=0></td>";
    $corpo .= "</tr></table>";
    
    EnviaMailer("atendimento@reverbcity.com","Reverbcity","rafael@reverbcity.com","Rafael","design@reverbcity.com","Novo Produto Marcado para Producao",$corpo);
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Marcou produto $idp $marca");

mysql_close($con);

Header("Location: index.php#$pos");
exit();
?>
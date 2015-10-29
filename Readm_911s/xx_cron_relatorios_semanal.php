<?php
include 'lib.php';

$primrodiacomp = date("Y-m-d", strtotime("-7 days"))." 00:00:00";

$ultimodiacomp = date("Y-m-d")." 23:59:59";

$diainicio = date("d/m",strtotime($primrodiacomp));
$diafim = date("d/m",strtotime($ultimodiacomp));

$subject  =  utf8_decode("Reverbcity - Relatório de fechamento de  vendas para Lojistas de   ".$diainicio . " - ". $diafim );

$texto =  utf8_decode('<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
<p>Seguem abaixo os links contendo os relatórios de fechamento dos dias '.$diainicio . ' até '. $diafim .':</p> 
</div>    
<div style="background-color: #dcddde; padding: 15px 10px 15px 15px; font-family:Verdana;font-size:11px;color: #646464; width: 575px; margin: 25px 0 25px 0;">
Vendas para lojistas:<br />
<a href="http://www.reverbcity.com/Readm_911s/rel_atacado_sem.php">Link</a><br /><br />
</div>
<p style="font-family:Verdana;font-size:11px;color: #555555;padding: 0 25px 0 25px;">
Para acessá-los você precisa estar logado na adm Londrina com um usuário válido.
<br /> 
</p>');

$corpo = IncluiPapelCarta("sistema",$texto, utf8_decode("Relatório de fechamento de  vendas para Lojistas de  ".$diainicio . " - ". $diafim ));

EnviaMailer("atendimento@reverbcity.com","Reverbcity","contato@reverbcity.com","Tony","",$subject,utf8_encode($corpo));
EnviaMailer("atendimento@reverbcity.com","Reverbcity","marketing@reverbcity.com","Gabriela","",$subject,utf8_encode($corpo));
EnviaMailer("atendimento@reverbcity.com","Reverbcity","vendas@reverbcity.com","Cloe","",$subject,utf8_encode($corpo));
EnviaMailer("atendimento@reverbcity.com","Reverbcity","vendas@reverbcity.com","Miri","",$subject,utf8_encode($corpo));
EnviaMailer("financeiro@reverbcity.com","Reverbcity","vendas@reverbcity.com","Rose","",$subject,utf8_encode($corpo));
?>
<?php
include '../adm/lib.php';

$nome = request("nome");
$email = request("email");

$subject  = "ReverbCity - Feliz Aniversário!";

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                <p>Parabéns, <strong>'.$nome.'</strong>!</p>	
                <p>Que a sua vida seja repleta de boa música, seja no seu fone de ouvido ou nas nossas camisetas!</p> 
                <p>Durante o m&ecirc;s do seu anivers&aacute;rio, voc&ecirc; ganha 20% DE DESCONTO em itens fora de promoção aqui na Reverbcity!</p>
                <p>Confira nossas estampas:</p>
                <div style="background-color: #dcddde; padding: 5px; font-family:Verdana;font-size:12px;color: #313131; width: 550px;">
                <a href="http://rvb.la/FelizBday">http://rvb.la/FelizBday</a>
                </div>
                <br /> 
                * Basta colocar o que deseja no carrinho e o desconto será aplicado automaticamente
                <br /><br />
                Que os próximos anos sejam ainda mais rock and roll,<br /> 
                Equipe Reverbcity.
          </div>';

$corpo = IncluiPapelCarta("niver",$texto);

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: desenvolvimento@reverbcity.com (Reverbcity)\r\n";
$headers .= "Return-Path: contato@reverbcity.com\r\n";
$headers .= "Reply-To: contato@reverbcity.com\r\n";

mail($email, $subject, str_replace("\n","",$corpo), $headers);

?>
<script language="JavaScript">
   alert('Email de aniversario enviado com Sucesso!');
   window.location.href=('index.php#niver');
</script>
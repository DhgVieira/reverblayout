<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");

$nome = request("nome");
$email = request("email");
$idc = request("idc");

$subject  = "ReverbCity - Confirmação de Compra!";

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                <p>Olá <strong>'.$nome.'</strong>,</p>

                <p>O seu pagamento referente ao pedido <strong>'.$idgrp.'</strong> foi confirmado com sucesso e já estamos separando sua compra aqui na Reverbcity!</p> 
                
                <p>Qualquer dúvida basta entrar em contato: <strong><a href=mailto:atendimento@reverbcity.com>atendimento@reverbcity.com</a></strong></p>
          </div>    
          <div style="background-color: #dcddde; padding: 15px 10px 15px 15px; font-family:Verdana;font-size:11px;color: #646464; width: 575px; margin: 25px 0 25px 0;">
                <b>Prazo para a postagem:</b>
                                Pedidos com o pagamento confirmado até as 13:00 de um dia útil serão postados no mesmo dia, após este horário a postagem se dará no próximo dia útil.

                                Prazo para a entrega:
                                Os prazos de entregam dependem da forma de envio escolhida durante a compra.

                                Os envios por E-sedex, Sedex e TAM levam em média três dias úteis após a postagem.

                                Os envios por PAC podem levar até 23 dias úteis, dependendo da região do país. Veja abaixo o prazo médio para sua região:
                                1 a 2 dias úteis para as capitais PR, SC, SP, RJ e MG
                                3 a 7 dias úteis para demais cidades do interior e os estados RS, DF, ES, GO, MS, BA, MT, SE e TO
                                7 a 12 dias úteis para os estados e capitais de AL, AC, AP, CE, MA, PA, PB, PE, PI, RN, RO e RR
                                até 23 dias úteis para AM
          </div>';
          
$corpo = IncluiPapelCarta("confpgto",$texto);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Email de Confirmação</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #FFFFFF;
}
-->
</style>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
.fonte1 {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	color:#000000
}
-->
</style>
</head>
<body>    	
<div id="Criar">
                         <form action="envia_mail_conf2.php" method="post">
                         	<input name="email" type="hidden" value="<?php echo $email; ?>" />
                            <input name="nome" type="hidden" value="<?php echo $nome; ?>" />
                             <input name="idc" type="hidden" value="<?php echo $idc; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="titulo" class="fonte1">
                                       Assunto do E-Mail:<br />
                                       <input class="form02" type="text" name="titulo" value="<?php echo $subject; ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="conteudo" class="fonte1">
                                       Conteudo:<br />
                                       <?php
                                            //$contmala = "<table width=\"600\" align=\"center\" border=\"0\"><tr><td><img src=\"http://www.cheida15.can.br/img/topo_new.jpg\" border=\"0\" /></td></tr><tr><td height=\"150\">&nbsp;</td></tr><tr><td><img src=\"http://www.cheida15.can.br/img/rodape_new.jpg\" border=\"0\" /></td></tr><tr><td align=\"center\">Caso voc&ecirc; n&atilde;o queira mais receber este mailing, <a href=mailto:imprensa@cheida15.can.br?subject=CANCELAR>clique aqui</a></td></tr></table>";
                                            $oFCKeditor = new FCKeditor('FCKeditor1') ;
                                            $oFCKeditor->ToolbarSet = 'MyToolbar';
                                            $oFCKeditor->BasePath = 'fckeditor/' ;
                                            $oFCKeditor->Height = 320 ;
											$oFCKeditor->Width = 590 ;
                                            $oFCKeditor->Value = $corpo ;
                                            $oFCKeditor->Create('conteudo');
                                            ?>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Enviar Email" />
                                   </li>
                                   </ul>
                             </fieldset>

                         </form>
                         </div>
 </body>
</html>
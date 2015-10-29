<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");

$nome = request("nome");
$email = request("email");
$idc = request("idc");
$rastre = request("rastre");

if (!$rastre){
    $rastre = "XXXXXXXXXXXXXX";
    $str = "update compras SET DS_RASTREAMENTO_COSO = null where NR_SEQ_COMPRA_COSO = $idc";
    $stp = mysql_query($str);
}else{
    $str = "update compras SET DS_RASTREAMENTO_COSO = '$rastre' where NR_SEQ_COMPRA_COSO = $idc";
    $stp = mysql_query($str);
}

$subject  = "ReverbCity - Confirmação de Envio (Rastreamento)!";

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 25px 25px; width: 550px;">
                Pronto para o Rock and Roll, <strong>'.utf8_decode($nome).'</strong>?
                <br /><br />
                A turnê da sua camiseta vai começar! Segue abaixo o código de rastreamento da sua compra número <strong>'.$idc.'</strong>
          </div>    
          <div style="background-color: #dcddde; padding: 25px; font-family:Verdana;font-size:12px;color: #313131; width: 550px;">
                Código: <strong>'.$rastre.'</strong>
          </div>
          <p style="font-family:Verdana;font-size:11px;color: #555555;padding: 0 25px 0 25px;">
                Para consultar o status do envio acesse o nosso site clicando no link <strong>Rastreamento</strong> no<br/ >rodapé e informe o código acima.
                <br /><br /></p>
          ';
$corpo = IncluiPapelCarta("rast",$texto,"ReverbCity RASTREAMENTO");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Email de Rastreamento</title>
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
<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");

$nome = trim(request("nome"));
$email = request("email");

if (strpos($nome," ") > 0){
	$nome = substr($nome,0,strpos($nome," "));
}

$subject  = "ReverbCity - REMINDER!";

$corpo = "<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"500\">";
$corpo .= "	<tr><td colspan=2><img src=\"http://www.reverbcity.com/mailing/mail/images/top_mailing.gif\" /></td></tr>";
$corpo .= "    <tr><td bgcolor=\"#e5d6c5\" height=\"290\" align=\"center\" colspan=2>";
$corpo .= "        	<table width=\"70%\" height=\"290\" align=\"center\"><tr>";
$corpo .= "                	<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#6b4922;\">";
$corpo .= "                    	<strong>$nome,</strong>";
$corpo .= "						<br /><br />";
$corpo .= "                        Hey dear, honey...";
$corpo .= "                        <br /><br />";
$corpo .= "                        Estamos com saudades suas!  <br /><br />";
$corpo .= "                        Faz um tempão que seu carrinho está vazio...Boraaa voltar a encheê-lo com boa música!";
$corpo .= "                        <br /><br />";
$corpo .= "                        Abraços,";
$corpo .= "                        <br /><br />";
$corpo .= "                        <strong>Equipe Reverbcity</strong>.";
$corpo .= "                    </td></tr>";
$corpo .= "            </table></td></tr>";
$corpo .= "    <tr><td width=57 bgcolor=#36190e></td><td><img src=\"http://www.reverbcity.com/mailing/mail/images/rod_niver.gif\" usemap=\"#Map\" border=\"0\" /></td></tr>";
$corpo .= "    <tr><td colspan=2 align=\"center\" height=\"55\">&nbsp;</td></tr>";
$corpo .= "</table>";
$corpo .= "<map name=\"Map\" id=\"Map\"><area shape=\"rect\" coords=\"345,16,466,33\" href=\"http://www.reverbcity.com\" /></map>";

?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Aviso</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);">Enviando Email</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">

                    <div id="Criar">

                         <form action="aviso2.php" method="post">
                         	<input name="email" type="hidden" value="<?php echo $email; ?>" />
                            <input name="nome" type="hidden" value="<?php echo $nome; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="titulo">
                                       Assunto do E-Mail:<br />
                                       <input class="form02" type="text" name="titulo" value="<?php echo utf8_encode($subject); ?>" /> <input type="submit" id="postar" name="postar" value="Enviar Email" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="conteudo">
                                       Conteudo:<br />
                                       <?php
                                            //$contmala = "<table width=\"600\" align=\"center\" border=\"0\"><tr><td><img src=\"http://www.cheida15.can.br/img/topo_new.jpg\" border=\"0\" /></td></tr><tr><td height=\"150\">&nbsp;</td></tr><tr><td><img src=\"http://www.cheida15.can.br/img/rodape_new.jpg\" border=\"0\" /></td></tr><tr><td align=\"center\">Caso voc&ecirc; n&atilde;o queira mais receber este mailing, <a href=mailto:imprensa@cheida15.can.br?subject=CANCELAR>clique aqui</a></td></tr></table>";
                                            $oFCKeditor = new FCKeditor('FCKeditor1') ;
                                            $oFCKeditor->ToolbarSet = 'MyToolbar';
                                            $oFCKeditor->BasePath = 'fckeditor/' ;
                                            $oFCKeditor->Height = 400 ;
											$oFCKeditor->Width = 600 ;
                                            $oFCKeditor->Value = $corpo;
                                            $oFCKeditor->Create('conteudo');
                                            ?>
                                     </label>
                                   </li>
                                   </ul>
                             </fieldset>

                         </form>
                    
                    </div> <!-- /criar -->
                    
              

                    <script>
                      defineAba("abaCriar","Criar");
                      defineAbaAtiva("abaCriar");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<? include 'rodape.php'; ?>

<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");

$nome = trim(request("nome"));
$email = request("email");

if (strpos($nome," ") > 0){
	$nome = substr($nome,0,strpos($nome," "));
}

$subject  = "Reverbcity contato!";

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                <p>Olá <strong>'.$nome.'</strong>,</p>

                <br /><br />
                
                <br /><br />
                
                <br /><br />
                
          </div>';
          
$corpo = IncluiPapelCarta("padrao",$texto,"REVERBCITY CONTATO");

//$corpo = "<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"500\">";
//$corpo .= "	<tr><td><a href=\"http://www.reverbcity.com/shop/produtos2_nosale.php\"><img src=\"http://www.reverbcity.com/mailing/mail/images/top_mailing.gif\" border=\"0\" /></a></td></tr>";
//$corpo .= "    <tr><td bgcolor=\"#ffffff\" height=\"290\" align=\"center\">";
//$corpo .= "        	<table width=\"90%\" height=\"290\" align=\"center\"><tr>";
//$corpo .= "                	<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#6b4922;\">";
//$corpo .= "						<br />";
//$corpo .= "        	Olá $nome,";
//$corpo .= "        	<br /><br />";
//$corpo .= "        	<br /><br />";
//$corpo .= "        	<br /><br />";
//$corpo .= "        	<br /><br />";
//$corpo .= "        	<br /><br />";
//$corpo .= "        	Um abraço rock n’ roll,";
//$corpo .= "        	<br /><br />";
//$corpo .= "        	Equipe Reverbcity<br />";
//$corpo .= "        	www.reverbcity.com";
//$corpo .= "                    <br /><br /></td></tr>";
//$corpo .= "            </table></td></tr>";
//$corpo .= "    <tr><td><img src=\"http://www.reverbcity.com/mailing/mail/images/rod_mailing.gif\" usemap=\"#Map\" border=\"0\" /></td></tr>";
//$corpo .= "</table>";
//$corpo .= "<map name=\"Map\" id=\"Map\"><area shape=\"rect\" coords=\"345,16,466,33\" href=\"http://www.reverbcity.com\" /></map>";


?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0" style="font-size: 10px;">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Enviando E-mail</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">

                    <div id="Criar">

                         <form action="envia_email2.php" method="post">
                            <input name="retorno" type="hidden" value="creditos" />
                         	<input name="email" type="hidden" value="<?php echo $email; ?>" />
                            <input name="nome" type="hidden" value="<?php echo $nome; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="titulo">
                                       Assunto do E-Mail:<br />
                                       <input class="form02" type="text" name="titulo" value="<?php echo $subject; ?>" /> <input type="submit" id="postar" name="postar" value="Enviar Email" />
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
                                            $oFCKeditor->Height = 700 ;
											$oFCKeditor->Width = 650 ;
                                            $oFCKeditor->Value = $corpo ;
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
<?php include 'rodape.php'; ?>
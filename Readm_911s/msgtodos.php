<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");
//***** seleciona todos os membros do forum
$todosemail = "";
	$sqlt = "select distinct NR_SEQ_CADASTRO_MESO from msgs";
		$stt = mysql_query($sqlt);
	if (mysql_num_rows($stt) > 0 ){
		while ($rowt = mysql_fetch_row($stt)){
			$post = $rowt[0];
			
			$sqlm = "select DS_EMAIL_CASO from cadastros WHERE ST_BLOQUEIOMAIL_CACH = 'N' and NR_SEQ_CADASTRO_CASO = '$post'";
			$stm = mysql_query($sqlm);
			if (mysql_num_rows($stm) > 0 ){
				while ($rowm = mysql_fetch_row($stm)){
					$email = $rowm[0];
					
					$todosemail .= $email."; ";
					
				}
			}
			
		}
	}
													   
								
$subject  = "ReverbCity - Forum!";

$corpo = "<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"500\">";
$corpo .= "	<tr><td><img src=\"http://www.reverbcity.com/mailing/mail/images/top_mailing.gif\" width=\"500px\" /></td></tr>";
$corpo .= "    <tr><td bgcolor=\"#e5d6c5\" height=\"290\" align=\"center\">";
$corpo .= "        	<table width=\"70%\" height=\"290\" align=\"center\"><tr>";
$corpo .= "                	<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#6b4922;\">";
$corpo .= "                    </td></tr>";
$corpo .= "     				<tr><td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#6b4922;\">";
$corpo .= "                        Abraços,";
$corpo .= "                        <br /><br />";
$corpo .= "                        <strong>Equipe Reverbcity</strong>.";							
$corpo .= "     				</td> </tr>	";
$corpo .= "            </table></td></tr>";
$corpo .= "    <tr><td><img src=\"http://www.reverbcity.com/mailing/mail/images/rod_niver.gif\" usemap=\"#Map\" border=\"0\" /></td></tr>";
$corpo .= "    <tr><td align=\"center\" height=\"55\">&nbsp;</td></tr>";
$corpo .= "</table>";
$corpo .= "<map name=\"Map\" id=\"Map\"><area shape=\"rect\" coords=\"345,16,466,33\" href=\"http://www.reverbcity.com\" /></map>";

?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Topicos</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);">Escrevendo Mensagem</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">

                    <div id="Criar">

                         <form action="msgtodos2.php" method="post">
                         	

                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                        
                            			<label><strong>Membros do forum:</strong></label><br  />
                                			<textarea rows="10" style="width:600px" name="email"><?php echo $todosemail;?></textarea><br />
                                   
                                     <label for="titulo">
                                       <strong>Assunto do E-Mail</strong>:<br />
                                       <input class="form02" type="text" name="titulo" value="<?php echo utf8_encode($subject); ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="conteudo">
                                       <strong>Conteudo:</strong><br />
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
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Enviar Email" />
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

<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");

$mes = request("mes");

$subject  = "Happy bday! Aproveite o seu dia com uma promo exclusiva: 15% de desconto!";

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                <p>Parab&eacute;ns, <strong>##nome##</strong>!</p>	
                <p>Que a sua vida seja repleta de boa m&uacute;sica, seja no seu fone de ouvido ou nas nossas camisetas!</p> 
                <p>Durante o m&ecirc;s do seu anivers&aacute;rio, voc&ecirc; ganha 15% DE DESCONTO em itens fora de promo&ccedil;&atilde;o aqui na Reverbcity!</p>
                <p>Confira nossas estampas:</p>
                <div style="background-color: #dcddde; padding: 5px; font-family:Verdana;font-size:12px;color: #313131; width: 550px;">
                <a href="http://rvb.la/FelizBday">http://rvb.la/FelizBday</a>
                </div>
                <br /> 
                Que os próximos anos sejam ainda mais rock and roll,<br /> 
                Equipe Reverbcity.
          </div>';
$corpo = IncluiPapelCarta("niver",utf8_encode($texto));

?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Envio Compradores</li>
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
                         <form action="envia_mail_nivers2.php" method="post">
                         	<input name="mes" type="hidden" value="<?php echo $mes; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="titulo" class="fonte1">
                                       Assunto do E-Mail:<br />
                                       <input class="form02" type="text" name="titulo" value="<?php echo $subject; ?>" />
                                       <input type="submit" id="postar" name="postar" value="Enviar E-mails" />
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
                                            $oFCKeditor->Height = 640 ;
											$oFCKeditor->Width = 590 ;
                                            $oFCKeditor->Value = $corpo ;
                                            $oFCKeditor->Create('conteudo');
                                            ?>
                                     </label>
                                   </li>
                                   </ul>
                             </fieldset>

                         </form>
                    </div>

                    <script>
                      defineAba("abaCriar","Criar");
                      defineAbaAtiva("abaCriar");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>
<? include 'rodape.php'; ?>

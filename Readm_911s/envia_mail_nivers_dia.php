<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");

$mes = request("mes");

$subject  = "Happy bday! Aproveite o seu dia com uma promo exclusiva: 15% de desconto!";

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                <p>Parab&eacute;ns, <strong>'.$nome.'</strong>!</p>
                <p>Na primeira compra efetuada dentro mês do seu aniversário você ganha 15% de desconto ao finalizar o pedido.</p>
                <p>Caso ultrapasse os R$ 150,00 você também ganha o frete para todo Brasil.</p>
          </div>';
          
//$corpo = "<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"539\" border=\"0\" bgcolor=\"#ffe99e\">";
//$corpo .= "	<tr><td><a href=\"http://www.reverbcity.com/shop/produtos2.php?tip=6\"><img src=\"http://www.reverbcity.com/images/topo_niver.jpg\" width=\"539\" border=\"0\" /></a></td></tr>";
//$corpo .= "    <tr><td align=\"center\">";
//$corpo .= "        	<table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr>";
//$corpo .= "                	<td align=\"center\">";
//$corpo .= "                    	<table width=\"90%\" border=\"0\"><tr><td style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#000000;\"><br />Feliz Aniversário <strong>##nome##</strong>!!";
//$corpo .= "						<br /><br />";
//$corpo .= "						<span style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#000000;\">Especialmente no mês do seu aniversário, você ganha uma camiseta de presente da Reverbcity! Para ativar a promoção, basta você realizar uma compra de produtos que não estejam em promoção, a partir de R$150 que você ganha outra tee!</span>";
//$corpo .= "						<br /><br />";
//$corpo .= "                        Nas compras a partir de $260, o <strong>frete é grátis!!!!</strong>";
//$corpo .= "                        <br /><br />";
//$corpo .= "                        Confira nossas camisetas:<br /><a href=http://www.reverbcity.com/shop/produtos2.php?tip=6>http://www.reverbcity.com/shop/produtos2.php?tip=6</a><br /><br />";
//$corpo .= "                        Que os próximos anos sejam ainda mais rock and roll,";
//$corpo .= "                        <br /><br />";
//$corpo .= "                        <strong>Equipe Reverbcity</strong>.";
//$corpo .= "                      <br /><br /><span style=\"font-size:12px;\">* Após atingir o valor estipulado, basta estar logado e adicionar a camiseta desejada no seu carrinho.</span>";
//$corpo .= "                      <br /><span style=\"font-size:12px;\">* A promoção é válida apenas no mês do seu aniversário e não é acumulativa.</span>";
//$corpo .= "                      <br /><span style=\"font-size:12px;\">* A Reverbcity reserva-se no direito de alterar ou cancelar a promoção a qualquer momento.</span>";
//$corpo .= "                        <br /><br />";
//$corpo .= "                	</td></tr></table></td>";
//$corpo .= "                 </tr>";
//$corpo .= "            </table></td></tr>";
//$corpo .= "    <tr><td bgcolor=\"#ffffff\"><a href=\"http://www.reverbcity.com/shop/produtos2.php?tip=6\"><img src=\"http://www.reverbcity.com/images/rodape_niver.jpg\" width=\"539\" border=\"0\" /></a></td></tr>";
//$corpo .= "</table>";

$corpo = IncluiPapelCarta("niver",$texto);

?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Envio Aniversariantes</li>
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
                         <p style="margin: 0 0 0 20px;">A tag <strong>##nome##</strong> ser&aacute; substitu&iacute;da pelo nome dos aniversariantes</p>
                         <form action="envia_mail_nivers_dia2.php" method="post">
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
<?php include 'rodape.php'; ?>
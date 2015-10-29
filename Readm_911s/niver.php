<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");

$nome = trim(request("nome"));
$email = request("email");

if (strpos($nome," ") > 0){
	$nome = substr($nome,0,strpos($nome," "));
}

$subject  = "Happy bday! Aproveite o seu dia com uma promo exclusiva: 20% de desconto!";

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                <p>Parab&eacute;ns, <strong>'.$nome.'</strong>!</p>	
                <p>Que a sua vida seja repleta de boa m&uacute;sica, seja no seu fone de ouvido ou nas nossas camisetas!</p> 
                <p>Durante o m&ecirc;s do seu anivers&aacute;rio, voc&ecirc; ganha 20% DE DESCONTO em itens fora de promo&ccedil;&atilde;o aqui na Reverbcity!</p>
               
                <div style="background-color: #dcddde; padding: 5px; font-family:Verdana;font-size:12px;color: #313131; width: 550px;">
                 <p>Confira nossas estampas: <b><a href="http://rvb.la/FelizBday" style="text-decoration:none; font-size:12pz; color:#313131;">http://rvb.la/FelizBday</a></b><p>
                </div>
                <br /> 
                Que os pr&oacute;ximos anos sejam ainda mais rock and roll,<br /> 
                Equipe Reverbcity.
          </div>';

//$corpo = "<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"539\" border=\"0\" bgcolor=\"#ffe99e\">";
//$corpo .= "	<tr><td><a href=\"http://www.reverbcity.com/shop/produtos2.php?tip=6\"><img src=\"http://www.reverbcity.com/images/topo_niver.jpg\" width=\"539\" border=\"0\" /></a></td></tr>";
//$corpo .= "    <tr><td align=\"center\">";
//$corpo .= "        	<table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr>";
//$corpo .= "                	<td align=\"center\">";
//$corpo .= "                    	<table width=\"90%\" border=\"0\"><tr><td style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#000000;\"><br />Feliz Aniversário <strong>$nome</strong>!!";
//$corpo .= "						<br /><br />";
//$corpo .= "						<span style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#000000;\">Especialmente no mês do seu aniversário, você ganha uma camiseta de presente da Reverbcity! Para ativar a promoção, basta você realizar uma compra de produtos que não estejam em promoção, a partir de R$150 que você ganha outra tee!</span>";
//$corpo .= "						<br /><br />";
//$corpo .= "                        Nas compras a partir de $260, o <strong>frete é grátis!!!!</strong>";
//$corpo .= "                        <br /><br />";
//$corpo .= "                        Confira nossas Camisetas:<br /><a href=http://www.reverbcity.com/shop/produtos2.php?tip=6>http://www.reverbcity.com/shop/produtos2.php?tip=6</a><br /><br />";
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

$corpo = IncluiPapelCarta("niver",utf8_decode($texto));

?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0" style="font-size: 10px;">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Aniversariante</li>
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

                         <form action="niver2.php" method="post">
                         	<input name="email" type="hidden" value="<?php echo utf8_decode($email); ?>" />
                            <input name="nome" type="hidden" value="<?php echo utf8_decode($nome); ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="titulo">
                                       Assunto do E-Mail:<br />
                                       <input class="form02" type="text" name="titulo" value="<?php echo utf8_decode($subject); ?>" /> <input type="submit" id="postar" name="postar" value="Enviar Email" />
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
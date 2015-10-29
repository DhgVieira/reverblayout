<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");

$nome = trim(request("nome"));
$email = request("email");

if (strpos($nome," ") > 0){
	$nome = substr($nome,0,strpos($nome," "));
}

$subject  = "Bem vindo a Reverbcity! Promo para primeira compra!";

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                <p>Olá <strong>'.$nome.'</strong>,</p>

                <p>Seu cadastro foi efetuado com sucesso e para comemorar temos um presente para você! </p>
                
                <p>Para a sua primeira compra a partir de R$150 em produtos fora de promoção, você ganha mais uma camiseta de presente!</p>
                
                <p>Além de poder comprar nossos produtos online, você pode participar da rede social, o  <strong>ReverbME</strong>, e também do nosso <strong>fórum</strong>.</p>
                <br />
                <p style="font-family:Verdana;font-size:9px;color: #b2b4b6;">* Após atingir o valor estipulado, basta estar logado e adicionar a camiseta desejada no seu carrinho.<br />
                * Promoção válida por 30 dias a partir da data do cadastro e não é cumulativa.<br />
                * A Reverbcity reserva-se no direito de alterar ou cancelar a promoção a qualquer momento e sem aviso prévio.</p>
          </div>';
          
$corpo = IncluiPapelCarta("novocad",$texto);

//$corpo = "<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"500\">";
//$corpo .= "	<tr><td><a href=\"http://www.reverbcity.com/shop/produtos2_nosale.php\"><img src=\"http://www.reverbcity.com/mailing/mail/images/top_mailing.gif\" border=\"0\" /></a></td></tr>";
//$corpo .= "    <tr><td bgcolor=\"#ffffff\" height=\"290\" align=\"center\">";
//$corpo .= "        	<table width=\"90%\" height=\"290\" align=\"center\"><tr>";
//$corpo .= "                	<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#6b4922;\">";
//$corpo .= "						<br /><br />";
//
//$corpo .= "        	<strong>Seja muito bem-vindo(a)!</strong>";
//$corpo .= "        	<br /><br />";
//$corpo .= "        	$nome, seu cadastro foi efetuado com sucesso.";
//$corpo .= "        	<br /><br />";
//$corpo .= "        	Olha o nosso presente de boas-vindas para você: para sua primeira compra a partir de R$150, em camisetas fora de promoção,<strong> você ganha outra camiseta</strong> de presente a sua escolha!";
//$corpo .= "        	<br /><br />";
//$corpo .= "        	A partir de agora, além de poder comprar nossos produtos online, você poderá participar da rede social exclusiva da marca ReverbME e também do nosso fórum.";
//$corpo .= "        	<br /><br />";
//$corpo .= "        	Aproveite para seguir a Reverbcity no <strong>Twitter</strong> @reverbcity e acompanhar a gente no <strong>Facebook</strong> https://www.facebook.com/Reverbcity";
//$corpo .= "        	<br /><br />";
//$corpo .= "        	Um abraço rock n’ roll,";
//$corpo .= "        	<br /><br />";
//$corpo .= "        	<strong>Equipe Reverbcity</strong><br />";
//$corpo .= "        	<strong>www.reverbcity.com</strong>";
//$corpo .= "                      <br /><br /><span style=\"font-size:12px;\">* Após atingir o valor estipulado, basta estar logado e adicionar a camiseta (de até R$ 65,00) desejada no seu carrinho.</span>";
//$corpo .= "                      <br /><span style=\"font-size:12px;\">* Promoção válida por 30 dias a partir da data do cadastro e não é acumulativa.</span>";
//$corpo .= "                      <br /><span style=\"font-size:12px;\">* Frete grátis para compras acima de R$260,00.</span>";
//$corpo .= "                      <br /><span style=\"font-size:12px;\">* A Reverbcity reserva-se no direito de alterar ou cancelar a promoção a qualquer momento.</span>";
//$corpo .= "                    </td></tr>";
//$corpo .= "            </table></td></tr>";
//$corpo .= "    <tr><td><img src=\"http://www.reverbcity.com/mailing/mail/images/rod_mailing.gif\" usemap=\"#Map\" border=\"0\" /></td></tr>";
//$corpo .= "</table>";
//$corpo .= "<map name=\"Map\" id=\"Map\"><area shape=\"rect\" coords=\"345,16,466,33\" href=\"http://www.reverbcity.com\" /></map>";
//

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
											$oFCKeditor->Width = 670 ;
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
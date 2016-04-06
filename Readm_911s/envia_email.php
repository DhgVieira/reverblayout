<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");

$nome = trim(urldecode(request("nome")));

$email = request("email");

if (strpos($nome," ") > 0){
    $nome = substr($nome,0,strpos($nome," "));
}

$subject  = "Bem vindo a Reverbcity! Promo para primeira compra!";

$texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                <p>Olá <strong>'.utf8_encode($nome).'</strong>,</p>

                <p>Seu cadastro foi efetuado com sucesso!</p>

                <p>Na sua primeira compra, você GANHA 15% DE DESCONTO na Reverbcity para usar em até 30 dias!</p>

                <p>Caso o pedido seja em um valor a partir de R$ 150,00 você também ganha o frete grátis</p>
          </div>';

$corpo = IncluiPapelCarta("novocad",$texto);

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
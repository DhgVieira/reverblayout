<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");

$idp = request("idp");

$newprod = request("idp2");

if (!$newprod){
    $corpo2 = "";
    $newprod = 0;
}else{
    $corpo2 = "";
    $sql = "SELECT NR_SEQ_FOTO_FORC, DS_EXT_FORC FROM fotos WHERE NR_SEQ_PRODUTO_FORC = $newprod order by NR_ORDEM_FORC, NR_SEQ_FOTO_FORC LIMIT 1";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
    	$row = mysql_fetch_row($st);
    	$idfoto = $row[0];
    	$extens = $row[1];
        $corpo2 = "<div style=\"width: 100%; text-align: center;\"><a href=\"http://www.reverbcity.com/shop/shop_produto.php?idp=$newprod\"><img src=\"http://www.reverbcity.com/images/produtos/adic/$idfoto.$extens\" width=\"250\" border=\"0\"></a></div>";
    }
}

$subject  = "ReverbCity!";

$corpo = "<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"500\">";
$corpo .= "	<tr><td><img src=\"http://www.reverbcity.com/mailing/mail/images/top_mailing.gif\" /></td></tr>";
$corpo .= "    <tr><td bgcolor=\"#e5d6c5\" height=\"290\" align=\"center\">";
$corpo .= "        	<table width=\"70%\" height=\"290\" align=\"center\"><tr>";
$corpo .= "                	<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#6b4922;\">";
$corpo .= "						<br /><br />";
$corpo .= "                        Olá,";
$corpo .= "                        <br /><br />";
$corpo .= "                        Gostaríamos de informar a chegada do produto:<br /><br />";

$corpo .= $corpo2;

$corpo .= "                        <br /><br /><strong>MANY THANKS POR ESCOLHER REVERBCITY!</strong>.";
$corpo .= "                        <br /><br />";
$corpo .= "                        Qualquer dúvida: <a href=mailto:contato@reverbcity.com>contato@reverbcity.com</a>";
$corpo .= "                        <br /><br />";
$corpo .= "                        Até a próxima,";
$corpo .= "                        <br /><br />";
$corpo .= "                        <strong>REVERBCITY música que veste.</strong><br />";
$corpo .= "                        <strong>www.reverbcity.com </strong><br /><br />";
$corpo .= "                    </td></tr>";
$corpo .= "            </table></td></tr>";
$corpo .= "    <tr><td><img src=\"http://www.reverbcity.com/mailing/mail/images/rod_mailing.gif\" usemap=\"#Map\" border=\"0\" /></td></tr>";
$corpo .= "</table>";
$corpo .= "<map name=\"Map\" id=\"Map\"><area shape=\"rect\" coords=\"345,16,466,33\" href=\"http://www.reverbcity.com\" /></map>";

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
                         <form action="envia_mail_comp2.php" method="post">
                         	<input name="idp" type="hidden" value="<?php echo $idp; ?>" />
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
                                     <label for="titulo" class="fonte1">
                                       Novo Produto:<br />
                                       <select name="idp2" onchange="document.location.href='envia_mail_comp.php?idp=<?php echo $idp ?>&idp2='+this.value">
                                         <option value="0">-- Ecolha o Produto --</option>
                                         <?php
                                         $sqlp = "select NR_SEQ_PRODUTO_PRRC, DS_PRODUTO2_PRRC, DS_CATEGORIA_PTRC from produtos, estoque, produtos_tipo where 
                                                  NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
                                                  and NR_SEQ_LOJAS_PRRC = 1 and NR_SEQ_PRODUTO_PRRC <> $idp and
                                                  DS_CLASSIC_PRRC = 'N' AND NR_QTDE_ESRC > 0 AND ST_PRODUTOS_PRRC = 'A'
                                                  group by NR_SEQ_PRODUTO_PRRC order by DT_CADASTRO_PRRC desc limit 100";
                                         $stp = mysql_query($sqlp);
                                         if (mysql_num_rows($stp) > 0) {
                                            while($rowp = mysql_fetch_row($stp)) {
                                         ?>
                                              <option value="<?php echo $rowp[0]; ?>"<?php if ($rowp[0] == $newprod) echo " selected"; ?>><?php echo $rowp[2]; ?> - <?php echo $rowp[1]; ?></option>
                                         <?php
                                            }
                                         }
                                         ?>
                                       </select>
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
<?php include 'rodape.php'; ?>
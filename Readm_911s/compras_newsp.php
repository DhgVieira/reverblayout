<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");

$idc   = request("idc");

$sqlnome = "select DS_NOME_CASO, DS_EMAIL_CASO, TP_CADASTRO_CACH, VL_TOTAL_COSO, VL_DESCPROMO_COSO from compras, cadastros where NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
        and NR_SEQ_COMPRA_COSO = $idc";
$stnome = mysql_query($sqlnome); 
if (mysql_num_rows($stnome) > 0) {
	$rownome = mysql_fetch_row($stnome);
    $nome = $rownome[0];
    $email = $rownome[1];
    $tipocad = $rownome[2];  
    $vlr_compra_at = $rownome[3]; 
    $vlr_desconto_at = $rownome[4]; 
}

$str = "update compras set ST_COMPRA_COSO = 'A' WHERE NR_SEQ_COMPRA_COSO = $idc";
$st = mysql_query($str);

$testa = true;
while($testa){
	$CaracteresAceitos = 'ABCDEFGHIJKLMNOPQRSTUVXYZ0123456789';
	$max = strlen($CaracteresAceitos)-1;
	//$password = date('Ymdhis');
	$codigo = "";
	for($i=0; $i < 20; $i++) {
	   $codigo .= $CaracteresAceitos{mt_rand(0, $max)};
	}
	$testa = false;
}

$str = "INSERT INTO controle_novo_pgto (NR_SEQ_COMPRA_NPRC, DT_CRIACAO_NPRC, ST_USO_NPRC, DS_CODIGO_NPRC, DT_VALIDADE_NPRC) VALUES (
        $idc, SYSDATE(), 'A', '$codigo', DATE_ADD(SYSDATE(), INTERVAL 5 DAY))";
$st = mysql_query($str);

$link = "http://www.reverbcity.com/shop/pgto.php?ch=$codigo";

if (strpos($nome," ") > 0){
	$nome = substr($nome,0,strpos($nome," "));
}

$subject  = "Reverbcity - Finalização de Compra!";

$corpo = "<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"500\">";
$corpo .= "	<tr><td><img src=\"http://www.reverbcity.com/mailing/mail/images/top_mailing.gif\" /></td></tr>";
$corpo .= "    <tr><td bgcolor=\"#ffffff\" height=\"290\" align=\"center\">";
$corpo .= "        	<table width=\"90%\" height=\"290\" align=\"center\"><tr>";
$corpo .= "                	<td align=\"left\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#6b4922;\">";
$corpo .= "						<br />";

$corpo .= "        	            Olá <strong>$nome</strong>!!";
$corpo .= "						<br /><br />";
$corpo .= "                     Segue abaixo o link para efetuar o pagamento do seu pedido Reverbcity:";
$corpo .= "						<br /><br />";
$corpo .= "                     <strong>$link</strong> ou <a href=\"$link\">Clique Aqui</a>";
$corpo .= "                     <br /><br />";
$corpo .= "                     Seu pedido fica reservado por 2(dois) dias.</strong>.";
$corpo .= "						<br /><br />";
$corpo .= "                     Atenciosamente,<br /><strong>Equipe Reverbcity</strong>.";
$corpo .= "                     <br /><br />";

$corpo .= "                    </td></tr>";
$corpo .= "            </table></td></tr>";
$corpo .= "    <tr><td><img src=\"http://www.reverbcity.com/mailing/mail/images/rod_mailing.gif\" usemap=\"#Map\" border=\"0\" /></td></tr>";
$corpo .= "</table>";
$corpo .= "<map name=\"Map\" id=\"Map\"><area shape=\"rect\" coords=\"345,16,466,33\" href=\"http://www.reverbcity.com\" /></map>";

?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0" style="font-size: 10px;">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Link para Pagamento</li>
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

                         <form action="compras_new2.php" method="post">
                            <input name="pg" type="hidden" value="9999999" />
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
                                            $oFCKeditor->Height = 400 ;
											$oFCKeditor->Width = 600 ;
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
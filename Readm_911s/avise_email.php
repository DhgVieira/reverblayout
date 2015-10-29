<?php
include 'auth.php';
include 'lib.php';
include_once("fckeditor/fckeditor.php");

$nome = trim(request("nome"));
$email = request("email");
$idp = request("idp");
$idav = request("idav");

$sql = "SELECT DS_PRODUTO2_PRRC, DS_CATEGORIA_PTRC, NR_SEQ_PRODUTO_PRRC
        from produtos, produtos_tipo 
        WHERE
        NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and 			
        NR_SEQ_PRODUTO_PRRC = $idp";
$st = mysql_query($sql); 
$x = 0;
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_row($st);
    $ds_prod	   = $row[0];
    $ds_categoria  = $row[1];
    $idproduto     = $row[2];    
    $ds_categoria = str_replace("&","e;",$ds_categoria);
    $ds_prod_url = str_replace("&","e;",$ds_prod);
}

$linkproduto = 'produto/'.urlencode($ds_prod_url).'/'.$idproduto;

$sql = "SELECT NR_SEQ_FOTO_FORC, DS_EXT_FORC FROM fotos WHERE NR_SEQ_PRODUTO_FORC = $idp order by NR_ORDEM_FORC, NR_SEQ_FOTO_FORC LIMIT 1";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);
	$idfoto = $row[0];
	$extens = $row[1];
}
if (strpos($nome," ") > 0){
	$nome = substr($nome,0,strpos($nome," "));
}

$subject  = "ReverbCity - Seu Produto Chegou!";

$texto = '<div style="background-color: #dcddde; padding: 15px 5px 15px 5px; font-family:Verdana;font-size:11px;color: #646464; width: 595px; height: 315px; margin: 0 0 20px 0;">
                <div style="float:left;width:240px;padding:15px;">
                    <p>Olá <strong>'.$nome.'</strong>,</p>
                    
                    <p>Sabia que aquele produto que você tanto queria finalmente está de volta ao estoque da Reverbcity?</p>

                    <p>Aproveite para garantir o seu, pois a quantidade desta reposição é limitada e não faremos um novo reprint!</p>
                    
                    <p><br />Clique na imagem ao lado para ir diretamente ao produto.</p>
                </div>
                <div style="float:left;width:280px;text-align: center;">
                    <a href="http://www.reverbcity.com/'.$linkproduto.'"><img src="http://www.reverbcity.com/arquivos/uploads/fotosprodutos/'.$idfoto.'.'.$extens.'" width="265"></a>
                </div>
          </div>';

$corpo = IncluiPapelCarta("aviseme",$texto);

?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">AVISE-ME</li>
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

                         <form action="avise_email2.php" method="post">
                         	<input name="email" type="hidden" value="<?php echo $email; ?>" />
                            <input name="nome" type="hidden" value="<?php echo $nome; ?>" />
                            <input name="idav" type="hidden" value="<?php echo $idav; ?>" />
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
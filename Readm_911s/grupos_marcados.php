<?php
include 'auth.php';
include 'lib.php';

$PHP_SELF = "grupos_marcados.php";
?>
<?php include 'topo.php'; ?>

    <table class="textosjogos" cellpadding="0" cellspacing="0" width="100%">
        	<tr>
            	<td height="20" align="left" class="textostabelas">
                	<table width="1000">
                        <tr>
                            <td>
                        	<ul id="titulos_abas">
                              <li id="menuDepo" class="abaativa">Produtos Marcados</li>
                              <li id="menuDepo2" onMouseOver="trataMouseAba(this);" class="abainativa" onclick="document.location.href='grupos_marcados2.php'">Executados</li>
                            </ul>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <div id="Ver">
                        <table border="0" cellpadding="0" cellspacing="0" height="30">
                            	<tr>
                                	<td align="center" width="38">&nbsp;</td>
                                	<td align="center" width="80"><strong>Img</strong></td>
                                	<td align="center" width="80"><strong>Data Cad.</strong></td>
                                    <td align="left" width="120"><strong>Tipo</strong></td>
                                    <td align="left" width="120"><strong>Categoria</strong></td>
                                    <td align="left" width="68"><strong>Ref.</strong></td>
                                    <td align="left" width="200"><strong>Descri&ccedil;&atilde;o</strong></td>
                                    <td align="left" width="48"><strong>Estoque</strong></td>
                                </tr>
                            </table>
                   		 <ul class="noticias">
						<?php
						
						  $sql = "select NR_SEQ_PRODUTO_PRRC, DT_CADASTRO_PRRC, DS_CATEGORIA_PTRC, DS_REFERENCIA_PRRC, VL_PRODUTO_PRRC,
						  				 DS_PRODUTO2_PRRC, DS_LOJA_LJRC, DS_EXT_PRRC, DS_EXTTAM_PRRC, ST_PRODUTOS_PRRC, VL_PROMO_PRRC,
										 DS_CATEGORIA_PCRC from produtos, produtos_tipo, lojas, produtos_categoria 
										 WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND 
										 NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC AND DS_CLASSIC_PRRC = 'N'
                                         AND NR_SEQ_LOJAS_PRRC = $SS_loja AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC
                                         AND ST_MARCA_PRRC = 'S' ";

						  $sql .= "order by DT_CADASTRO_PRRC desc";
						  $st = mysql_query($sql);

						  if (mysql_num_rows($st) > 0) {
							$xtot = 0;
						  	while($row = mysql_fetch_row($st)) {
							 $mostraprod = true;
							 
							 $id_prod	   = $row[0];
					         $dt_prod	   = $row[1];
							 $ds_tipo	   = $row[2];
							 $ds_ref	   = $row[3];
							 $vl_prod	   = $row[4];
							 $ds_prod	   = $row[5];
							 $ds_loja	   = $row[6];
							 $ext		   = $row[7];
							 $ext2		   = $row[8];
							 $status	   = $row[9];
							 $vlrpromo	   = $row[10];
                             $ds_categ	   = $row[11];
							 
							 $sql2 = "SELECT sum(NR_QTDE_ESRC) from estoque WHERE NR_SEQ_PRODUTO_ESRC = $id_prod";
							 $st2 = mysql_query($sql2);
							 if (mysql_num_rows($st2) > 0) {
							 	$row2 = mysql_fetch_row($st2);
								$estoq = $row2[0];
								if (!$estoq) $estoq = 0;
							 }else{
							 	$estoq = 0;
							 }
							 
							 if ($tipo == "E1") {
							 	if ($estoq < $desc) $mostraprod = false;
							 }
							 
							 if ($tipo == "E2") {
							 	if ($estoq > $desc) $mostraprod = false;
							 }
							 
							 if ($tipo == "E3") {
							 	if ($estoq != $desc) $mostraprod = false;
							 }
							 
							 if ($mostraprod) {
							 $xtot++;
                             
                             $ds_categoria = str_replace("&","e;",$ds_categ);
                             $ds_prod_url = str_replace("&","e;",$ds_prod);
							?>
							<li style="width:790px;">
                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                            	<tr<?php if ($status == "I") echo " bgcolor=\"#FDEBDF\" "; ?>>
                                    <td align="left" width="30"><strong><?php echo $id_prod; ?></strong></td>
                                    <td align="center" width="80">
                                    <?php if ($ext == "swf") {?>
                                      <object data="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ext; ?>" type="application/x-shockwave-flash" width="70" height="81">
                                        <param name="quality" value="high" />
                                        <param name="flashvars" value="URLname=<?php echo $id_prod; ?>" />
                                        <param name="movie" value="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ext; ?>" />
                                        <param name="wmode" value="opaque" />
                                      </object>
                                    <?php }else{ ?>
                                	<img src="..../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ext; ?>" width="70" height="81" border="0" />
                                	<?php } ?>
                                    </td>
                                    <td align="center" width="80"><?php echo date("d/m/Y", strtotime($dt_prod));?></td>
                                    <td align="left" width="120"><strong><?php echo $ds_tipo; ?></strong></td>
                                    <td align="left" width="120"><strong><?php echo $ds_categ; ?></strong></td>
                                    <td align="left" width="70"><strong><?php echo $ds_ref; ?></strong></td>
                                    <td align="left"><?php echo $ds_prod; ?></td>
                                    <td align="center" width="45"><strong><?php echo $estoq; ?></strong></td>
                                    <td align="center" width="25"><a href="grupos_marca2.php?idp=<?php echo $id_prod ?>" title="Executado"><img src="img/ico_check.gif" border="0" /></a></td>
                                    <td align="center" width="25"><a href="grupos_marca2.php?idp=<?php echo $id_prod ?>&m=M" title="Limpar Marca"><img src="img/ico_cancel.gif" border="0" /></a></td>
                                </tr>
                            </table>
                            </li>
							<?php
							  }
							}
						  }
						 
						?>
                      </ul>
                      
                      </div> <!-- /ver -->
                    
					<script>
					  defineAba("abaVer","Ver");
                      defineAbaAtiva("abaVer");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>

<?php
include 'auth.php';
include_once("fckeditor/fckeditor.php");
include 'lib.php';
$pagina = request("pagina");
$PHP_SELF = "classics.php";
?>
<?php include 'topo.php'; ?>
<script language="javascript">
	function confirma_cla(idp) {
		var confirma = confirm("Tem certeza que voce deseja reativar este produto?")
		if ( confirma ){
			document.location.href='classics_cla.php?&idp='+idp+'&pg=<?php echo $pagina; ?>';
		} else {
			return false
		} 
	}
</script> 

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Classics</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Produtos Cadastrados</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <div id="Ver">
                    	<table width="880">
                        	<tr>
                            	<?php 
								$loja = 1;
								$tipo = request("tipo");
								$desc = request("desc");
								if (!$tipo) $tipo = "D";
								?>
                            	<form action="classics.php" method="post" name="frm">
                                <td height="20" align="right" valign="middle">
                                    <strong>Procurar por:</strong>
                                    <select name="tipo" class="frm_pesq" style="width:90px;height:20px;">
                                        <option value="D">Descri&ccedil;&atilde;o</option>
                                        <option value="R">Refer&ecirc;ncia</option>
                                    </select>
                                    <input style="width:120px;height:14px;" class="frm_pesq" type="text" name="desc" value="<?php echo $desc; ?>" />
                                    <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                                </td></form>
                                 <script language="JavaScript">
								   document.frm.tipo.value = "<?php echo $tipo;?>";
								</script>
                            </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" height="30">
                            	<tr>
                                	<td align="center" width="10">&nbsp;</td>
                                    <td align="center" width="50">&nbsp;</td>
                                	<td align="center" width="60"><strong>Img</strong></td>
                                	<td align="center" width="80"><strong>Data Cad.</strong></td>
                                    <td align="left" width="100"><strong>Tipo</strong></td>
                                    <td align="left" width="68"><strong>Ref.</strong></td>
                                    <td align="left" width="246"><strong>Descri&ccedil;&atilde;o</strong></td>
                                </tr>
                            </table>
                   		 <ul class="noticias">
						<?
						  $num_por_pagina = 20;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_PRODUTO_PRRC, DT_CADASTRO_PRRC, DS_CATEGORIA_PTRC, DS_REFERENCIA_PRRC, VL_PRODUTO_PRRC,
						  				 DS_PRODUTO2_PRRC, DS_LOJA_LJRC, DS_EXT_PRRC, DS_EXTTAM_PRRC 
										 from produtos, produtos_tipo, lojas 
										 WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND 
										 NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC AND DS_CLASSIC_PRRC = 'S' ";
						  if ($loja != 0) {
						  	  $sql .= " AND NR_SEQ_LOJAS_PRRC = $loja ";
						  }
						  if ($tipo == "D") {
						  	  $sql .= " AND DS_PRODUTO2_PRRC like '%$desc%' ";
						  }
						  if ($tipo == "R") {
						  	  $sql .= " AND DS_REFERENCIA_PRRC like '%$desc%' ";
						  }
						  $sql .= "order by DT_CADASTRO_PRRC desc LIMIT $primeiro_registro, $num_por_pagina";
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
							 $ds_prod	   = utf8_encode($row[5]);
							 $ds_loja	   = utf8_encode($row[6]);
							 $ext		   = $row[7];
							 $ext2		   = $row[8];
							 
							 if ($mostraprod) {
							 $xtot++;
							?>
							<li>
                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td align="left" width="50"><strong><?php echo $id_prod; ?></strong></td>
                                    <td align="center" width="60"><img src="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ext; ?>" width="31" height="36" border="0" /></td>
                                	<td align="center" width="80"><? echo date("d/m/Y", strtotime($dt_prod));?></td>
                                    <td align="left" width="100"><strong><?php echo $ds_tipo; ?></strong></td>
                                    <td align="left" width="70"><strong><?php echo $ds_ref; ?></strong></td>
                                    <td align="left"><?php echo $ds_prod; ?></td>
                                    <td align="center" width="25"><a href="classics_coments.php?idp=<?php echo $id_prod;?>&pg=<?php echo $pagina;?>" title="Comentarios"><img src="img/ico_coment.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="#" onclick="confirma_cla(<?php echo $id_prod; ?>);" title="Retirar do Classics"><img src="img/ico_classicsa.gif" border="0" /></a></td>
                                    <td align="center" width="25"><a href="clientes_produto.php?idp=<?php echo $id_prod;?>" title="Compradores"><img src="img/ico_search.gif" border="0" /></a></td>
                                    <td align="center" width="25"><a href="grupos_fotos.php?idp=<? echo $id_prod;?>" title="Imagens do Produto"><img src="img/foto.gif" border="0" /></a></td>
                                    <td align="center" width="25"><a href="grupos_alt.php?idp=<? echo $id_prod;?>" title="Alterar Produto"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="produto.php?idp=<?php echo $id_prod ?>" target="_blank" title="Visualizar"><img src="img/eye.png" width="16" height="16" border="0" /></a></td>
                                    
                                </tr>
                            </table>
                            </li>
							<?
							  }
							}
						  }
						 
						?>
                      </ul>
                      <ul class="paginacao">
						<?
                        $consulta = "select count(*) from produtos, produtos_tipo WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND DS_CLASSIC_PRRC = 'S'";
						if ($loja != 0) {
						  	  $consulta .= " AND NR_SEQ_LOJAS_PRRC = $loja ";
						}
						if ($tipo == "D") {
						  	  $consulta .= " AND DS_PRODUTO2_PRRC like '%$desc%' ";
						}
						if ($tipo == "R") {
						  	  $consulta .= " AND DS_REFERENCIA_PRRC like '%$desc%' ";
						}
						if (is_numeric($tipo)) {
						  	  $consulta .= " AND NR_SEQ_TIPO_PRRC = $tipo ";
						}
                        list($total_usuarios) = mysql_fetch_array(mysql_query($consulta,$con));
                        
                        $total_paginas = $total_usuarios/$num_por_pagina;
                        $prev = $pagina - 1;
                        $next = $pagina + 1;
                        if ($pagina > 1) {
                        $prev_link = "<li><a href=\"$PHP_SELF?pagina=$prev\">Anterior</a></li>";
                        } else { 
                        $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas > $pagina) {
                        $next_link = "<li><a href=\"$PHP_SELF?pagina=$next\">Proxima</a></li>";
                        } else {
                        $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas = ceil($total_paginas);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas; $x++) {
                          if ($x==$pagina) { 
                            $painel .= "<li>[$x]</li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?pagina=$x\">[$x]</a></li>";
                          }
                        }
                        echo "$prev_link";
                        echo "$painel";
                        echo "$next_link";
						
                        ?>                
                    </ul> <!-- /paginacao -->
                      </div> <!-- /ver -->
                   
					<script>
					  defineAba("abaVer","Ver");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<? include 'rodape.php'; ?>
<?php mysql_close($con);?>

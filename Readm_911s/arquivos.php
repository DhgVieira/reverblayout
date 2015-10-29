<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$aba = request("aba");

$PHP_SELF = "arquivos.php";
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma_cat(idc) {
	var confirma = confirm("Confirma a Exclusao dessa Categoria?")
	if ( confirma ){
		document.location.href='arquivos_cat_del.php?&idc='+idc;
	} else {
		return false
	} 
}

function confirma_del(ida,extensao) {
	var confirma = confirm("Confirma a Exclusao desse Arquivo e todas as suas versoes?")
	if ( confirma ){
		document.location.href='arquivos_del.php?arq='+ida+'&ext='+extensao;
	} else {
		return false
	} 
}
</script> 
    <table class="textosjogos" cellpadding="0" cellspacing="0" width="100%">
        	<tr>
            	<td height="20" align="left" class="textostabelas">
                	<table>
                        <tr>
                            <td>
                        	<ul id="titulos_abas">
                              <li id="menuDepo" class="abaativa">Arquivos</li>
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
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Arquivos Cadastrados</li>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Novo Arquivo</li>
                      <li id="abaCateg" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Categorias</li>
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
								$cat = request("cat");
								?>
                            	<form action="arquivos.php" method="post" name="frm">
                                <td height="20" align="right" valign="middle">
                                    <strong>Filtrar por:</strong>
                                    <select name="cat" class="frm_pesq" style="width:90px;height:20px;">
                                         <?php
										$sql = "select NR_SEQ_CATEGPRO_PCRC, DS_CATEGORIA_PCRC from arquivos_categoria order by DS_CATEGORIA_PCRC";
										$st = mysql_query($sql);
			
										if (mysql_num_rows($st) > 0) {
										  while($row = mysql_fetch_row($st)) {
										   $id_tipo	   = $row[0];
										   $ds_tipo	   = $row[1];
										?>
										<option value="<?php echo $id_tipo; ?>"><?php echo $ds_tipo; ?></option>
										<?php
										  }
										}
										?>
                                    </select>
                                    <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                                </td></form>
                                 <script language="JavaScript">
								   document.frm.cat.value = "<?php echo $cat;?>";
								</script>
                            </tr>
                        </table>
                        <ul class="noticias">
                        <li style="width:905px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            	<tr>
                                	<td align="center" width="80"><strong>&Uacute;ltima At.</strong></td>
                                    <td align="left" width="120"><strong>Categoria</strong></td>
                                    <td align="left" width="120"><strong>Usu&aacute;rio</strong></td>
                                    <td align="left"><strong>Nome</strong></td>
                                    <td align="left" width="200"><strong>Arquivo</strong></td>
                                    <td align="center" width="50"><strong>Vers&atilde;o</strong></td>
                                    <td align="left" width="100">&nbsp;</td>
                                </tr>
                            </table>
                         </li>
                         </ul>
                   		 <ul class="noticias">
						<?php
						  $num_por_pagina = 70;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_ARQUIVO_AQRC, NR_SEQ_USER_AQRC, DS_ARQUIVO_AQRC, DS_DESCRICAO_AQRC,
                                         DT_ARQUIVO_AQRC, DS_NOME_ORIG_AQRC, DS_EXT_AQRC, DS_CATEGORIA_PCRC, NR_SEQ_CATEGPRO_PCRC
                                  from arquivos, arquivos_categoria, arquivos_rel where NR_SEQ_CATEGORIA_AQRC = NR_SEQ_CATEGPRO_PCRC 
                                         AND NR_SEQ_ARQUIVO_AQRC = NR_SEQ_ARQUIVO_AURC AND NR_SEQ_USER_AURC = $SS_logadm ";
						  if (is_numeric($cat)) {
						  	  $sql .= "and NR_SEQ_CATEGORIA_AQRC = $cat ";
						  }
						  $sql .= "order by DT_ARQUIVO_AQRC desc LIMIT $primeiro_registro, $num_por_pagina";
						  $st = mysql_query($sql);

						  if (mysql_num_rows($st) > 0) {
							$xtot = 0;
						  	while($row = mysql_fetch_row($st)) {
							 $mostraprod = true;
							 
							 $id_arq	   = $row[0];
					         $nr_user	   = $row[1];
							 $ds_arq	   = $row[2];
							 $ds_desc	   = $row[3];
							 $dt_arq	   = $row[4];
							 $ds_nmorig	   = $row[5];
							 $ds_ext	   = $row[6];
                             $ds_categ	   = $row[7];
                             $id_categ	   = $row[8];
                             
                             $sql2 = "select count(*) from arquivos_historico where NR_SEQ_ARQUIVO_AHRC = $id_arq";
                             $st2 = mysql_query($sql2);
                             $row2 = mysql_fetch_row($st2);
                             $versoes = $row2[0];
                             
                             $sql2 = "select DS_LOGIN_USRC from usuarios where NR_SEQ_USUARIO_USRC = $nr_user";
                             $st2 = mysql_query($sql2);
                             $row2 = mysql_fetch_row($st2);
                             $ds_user = $row2[0];
                             
                             $versoes += 1;
							?>
							<li style="width:905px;">
                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                            	<tr>
                                    <td align="center" width="80"><?php echo date("d/m/Y", strtotime($dt_arq));?></td>
                                    <td align="left" width="120"><strong><?php echo $ds_categ; ?></strong></td>
                                    <td align="left" width="120"><strong><?php echo $ds_user; ?></strong></td>
                                    <td align="left"><?php echo $ds_arq; ?></td>
                                    <td align="left" width="200"><?php echo $ds_nmorig; ?></td>
                                    <td align="center" width="50"><strong><?php echo $versoes; ?></strong></td>
                                    <td align="center" width="25"><a href="arquivos_baixar.php?file=arquivos/<?php echo $id_arq; ?>.<?php echo $ds_ext; ?>&arq=<?php echo $id_arq; ?>"><img src="img/download.png" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="arquivos_alt.php?arq=<?php echo $id_arq; ?>&ver=<?php echo $versoes; ?>&cat=<?php echo $id_categ ?>"><img src="img/ico-det.gif" width="16" height="16" border="0" /></td>
                                    <?php if (($nr_user == $SS_logadm) || $nr_user == 1){ ?>
                                    <td align="center" width="25"><a href="arquivos_permis.php?arq=<?php echo $id_arq; ?>"><img src="img/ico_alerta.gif" width="16" height="16" border="0" /></a></td>
                                    <?php } else { ?>
                                    <td width="25">&nbsp;</td>
                                    <?php } ?>
                                    <?php if (($nr_user == $SS_logadm) || $SS_nivel == 100){ ?>
                                    <td align="center" width="25"><a href="#" onclick="confirma_del(<?php echo $id_arq; ?>,'<?php echo $ds_ext; ?>');"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                    <?php } else { ?>
                                    <td width="25">&nbsp;</td>
                                    <?php } ?>
                                </tr>
                            </table>
                            </li>
							<?php
							}
						  }
						 
						?>
                      </ul>
                      <ul class="paginacao" style="width:905px;">
						<?php
                        $consulta = "select count(*) from arquivos, arquivos_categoria, arquivos_rel where 
                                     NR_SEQ_CATEGORIA_AQRC = NR_SEQ_CATEGPRO_PCRC AND NR_SEQ_ARQUIVO_AQRC = NR_SEQ_ARQUIVO_AURC AND NR_SEQ_USER_AURC = $SS_logadm ";
						if (is_numeric($cat)) {
						  	  $consulta .= "AND NR_SEQ_CATEGORIA_AQRC = $cat ";
						}
                        list($total_usuarios) = mysql_fetch_array(mysql_query($consulta,$con));
                        
                        $total_paginas = $total_usuarios/$num_por_pagina;
                        $prev = $pagina - 1;
                        $next = $pagina + 1;
                        if ($pagina > 1) {
                        $prev_link = "<li><a href=\"$PHP_SELF?pagina=$prev&loja=$loja&tipo=$tipo&desc=$desc\">Anterior</a></li>";
                        } else { 
                        $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas > $pagina) {
                        $next_link = "<li><a href=\"$PHP_SELF?pagina=$next&loja=$loja&tipo=$tipo&desc=$desc\">Proxima</a></li>";
                        } else {
                        $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas = ceil($total_paginas);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas; $x++) {
                          if ($x==$pagina) { 
                            $painel .= "<li>[$x]</li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?pagina=$x&loja=$loja&tipo=$tipo&desc=$desc\">[$x]</a></li>";
                          }
                        }
                        echo "$prev_link";
                        echo "$painel";
                        echo "$next_link";
						
                        ?>                
                    </ul> <!-- /paginacao -->
                      </div> <!-- /ver -->
                    
                    <div id="Criar">
                        <form action="arquivos_inc.php" method="post" name="myform" enctype="multipart/form-data">
						<table width="880">
                        	<tr>
                            	<td valign="top">
                                <table cellpadding="3" cellspacing="3">
                                    <tr>
                                        <td>
                                           <label for="tipo">
                                           <strong>Categoria:</strong><br />
                                           <select name="categoria">
                                                <?php
                                                $sql = "select NR_SEQ_CATEGPRO_PCRC, DS_CATEGORIA_PCRC from arquivos_categoria order by DS_CATEGORIA_PCRC";
                                                $st = mysql_query($sql);
                    
                                                if (mysql_num_rows($st) > 0) {
                                                  while($row = mysql_fetch_row($st)) {
                                                   $id_cate	   = $row[0];
                                                   $ds_cate	   = $row[1];
                                                ?>
                                                <option value="<?php echo $id_cate; ?>"><?php echo $ds_cate; ?></option>
                                                <?php
                                                  }
                                                }
                                                ?>
                                           </select>
                                           </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="nome">
                                               <strong>Nome:</strong><br />
                                               <input class="form02" type="text" name="nome" style="width:435px;" />
                                             </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="nome">
                                               <strong>Descri&ccedil;&atilde;o:</strong><br />
                                               <textarea class="form02" name="descricao" style="width:435px; height: 50px;" rows="3"></textarea>
                                             </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="img">
                                               <strong>Arquivo:</strong><br />
                                               <input class="form02" size="60" type="file" name="FILE1" style="width:435px;height:26px;" />
                                             </label>
                                        </td>
                                    </tr>
                                    <tr><td><input type="submit" id="postar" name="postar" value="Incluir Arquivo" /></td></tr>
                                </table>
                        	</td>
                            <td valign="top">
                                &nbsp;
                            </td>
                            </tr>
                        </table>
                        </form>
                    
                    </div> <!-- /criar -->
                    
                    <div id="Categ">
                    
                    	<form action="arquivos_cat_inc.php" method="post">
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_cat">
                                       Categoria:<br />
                                       <input class="form02" type="text" id="nome_cat" name="nome_cat" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Categoria" />
                                   </li>
                                 </ul>
                         </form>
                         
                          <ul class="noticias">
                          	   <li>
                               <span><strong>Categorias</strong></span>
                               <div>EXC</div>
                               <div>ALT</div>
                               </li>
                            <?php
                              $sql = "select NR_SEQ_CATEGPRO_PCRC, DS_CATEGORIA_PCRC from arquivos_categoria order by DS_CATEGORIA_PCRC";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_cat	   = $row[0];
                                 $nm_cat	   = $row[1];
                                ?>
                                <li>
                                <span><strong><?php echo $nm_cat;?></strong></span>
                                <div>
                                <a href="#" title="deletar categoria" onclick="confirma_cat(<?php echo $id_cat; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                <div><a href="arquivos_cat_alt.php?idc=<?php echo $id_cat;?>" title="Alterar"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a></div>
                                </li>
                                <?php
                                }
                              }
                            ?>
                          </ul>
                      
                    </div> <!-- /categoria -->
                    
                    
					<script>
					  defineAba("abaVer","Ver");
                      defineAba("abaCriar","Criar");
                      defineAba("abaCateg","Categ");
					  <?php
					  switch($aba){
					  	  case 1:
						  	  echo "defineAbaAtiva(\"abaCriar\");";
							  break;
						  case 2:
						  	  echo "defineAbaAtiva(\"abaVer\");";
							  break;
						  case 3:
						  	  echo "defineAbaAtiva(\"abaCateg\");";
							  break;
						  default:
						  	  echo "defineAbaAtiva(\"abaVer\");";
							  break;
					   }
					  ?>
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

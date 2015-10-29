<?php
include 'auth.php';
include_once("fckeditor/fckeditor.php");
include 'lib.php';
$pagina = request("pagina");
$aba = request("aba");

$PHP_SELF = "grupos_inativos.php";
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma_tip(idt) {
	var confirma = confirm("Confirma a Exclusao desse Tipo?")
	if ( confirma ){
		document.location.href='prod_tip_del.php?&idt='+idt;
	} else {
		return false
	} 
}

function confirma_cla(idp) {
	var confirma = confirm("Tem certeza que voce deseja mover este produto para o Clssics?")
	if ( confirma ){
		document.location.href='grupos_cla.php?&idp='+idp;
	} else {
		return false
	} 
}

function confirma_cat(idc) {
	var confirma = confirm("Confirma a Exclusao dessa Categoria?")
	if ( confirma ){
		document.location.href='prod_cat_del.php?&idc='+idc;
	} else {
		return false
	} 
}

function confirma_est(idm) {
	var confirma = confirm("Confirma a Exclusao desse Estilo?")
	if ( confirma ){
		document.location.href='prod_estilo_del.php?&idm='+idm;
	} else {
		return false
	} 
}

function confirma_mus(idm) {
	var confirma = confirm("Confirma a Exclusao dessa Musica?")
	if ( confirma ){
		document.location.href='prod_musica_del.php?&idm='+idm;
	} else {
		return false
	} 
}

function confirma_pro(idp,ext,ext2) {
	var confirma = confirm("Confirma a Exclusao desse Produto?")
	if ( confirma ){
		document.location.href='grupos_del.php?&idp='+idp+'&ext='+ext+'&ext2='+ext2;
	} else {
		return false
	} 
}

function AtualizaImagem(){
   if (document.myform.FILE1.value == ""){
	   document.myform.FILE1.focus();
   }else{
		document.imagem_foto.src=document.myform.FILE1.value;
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
                              <li id="menuDepo" onMouseOver="trataMouseAba(this);" class="abainativa" onclick="document.location.href='grupos.php'">Produtos</li>
                              <li id="menuInativos" class="abaativa">Produtos Inativos</li>
                              <?php if ($SS_nivel >= 50) { ?>
                              <li id="menuAviseme" onMouseOver="trataMouseAba(this);" class="abainativa" onclick="document.location.href='grupos_aviso.php'">Produtos Avise-me</li>
                              <?php } ?>
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
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Produtos Cadastrados</li>
                      <?php if ($SS_nivel >= 50) { ?>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Novo Produto</li>
                      <li id="abaCateg" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Categorias</li>
                      <li id="abaTipos" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Tipos</li>
                      <li id="abaEstil" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Estilos</li>
                      <li id="abaMusic" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">M&uacute;sicas</li>
                      <?php } ?>
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
								$loja = request("loja");
								$tipo = request("tipo");
								$desc = request("desc");
								
								if (!$loja) $loja = 0;
								
								if ( ($tipo == "E1" || $tipo == "E2" || $tipo == "E3") && (!$desc) ) {
									$desc = 0;
								}
								?>
                            	<form action="grupos_inativos.php" method="post" name="frm">
                                <td height="20" align="right" valign="middle">
                                    <strong>Procurar por:</strong>
                                    <select name="tipo" class="frm_pesq" style="width:90px;height:20px;">
                                        <option value="D">Descri&ccedil;&atilde;o</option>
                                        <option value="R">Refer&ecirc;ncia</option>
                                        <option value="E1">Estoque >= que</option>
                                        <option value="E2">Estoque <= que</option>
                                        <option value="E3">Estoque =</option>
                                         <?php
										$sql = "select NR_SEQ_CATEGPRO_PTRC, DS_CATEGORIA_PTRC from produtos_tipo order by DS_CATEGORIA_PTRC";
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
                                    <input style="width:120px;height:14px;" class="frm_pesq" type="text" name="desc" id="desc" value="<?php echo $desc; ?>" />
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
                                	<td align="center" width="60"><strong>Img</strong></td>
                                	<td align="center" width="80"><strong>Data Cad.</strong></td>
                                    <td align="left" width="100"><strong>Loja</strong></td>
                                    <td align="left" width="120"><strong>Tipo</strong></td>
                                    <td align="left" width="120"><strong>Categoria</strong></td>
                                    <td align="left" width="68"><strong>Ref.</strong></td>
                                    <td align="left" width="218"><strong>Descri&ccedil;&atilde;o</strong></td>
                                    <td align="right" width="80"><strong>Valor</strong></td>
                                    <td align="center" width="45"><strong>Qtd</strong></td>
                                </tr>
                            </table>
                   		 <ul class="noticias">
						<?php
						  $num_por_pagina = 50;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_PRODUTO_PRRC, DT_CADASTRO_PRRC, DS_CATEGORIA_PTRC, DS_REFERENCIA_PRRC, VL_PRODUTO_PRRC,
						  				 DS_PRODUTO2_PRRC, DS_LOJA_LJRC, DS_EXT_PRRC, DS_EXTTAM_PRRC, ST_PRODUTOS_PRRC, VL_PROMO_PRRC,
										 DS_CATEGORIA_PCRC from produtos, produtos_tipo, lojas, produtos_categoria 
										 WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND 
										 NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC AND DS_CLASSIC_PRRC = 'N'
                                         AND NR_SEQ_LOJAS_PRRC = $SS_loja AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC AND ST_PRODUTOS_PRRC = 'I' ";

						  if ($tipo == "D") {
						  	  $sql .= " AND DS_PRODUTO2_PRRC like '%$desc%' ";
						  }
						  if ($tipo == "R") {
						  	  $sql .= " AND DS_REFERENCIA_PRRC like '%$desc%' ";
						  }
						  if (is_numeric($tipo)) {
						  	  $sql .= " AND NR_SEQ_TIPO_PRRC = $tipo ";
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
							?>
							<li style="width:905px;">
                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                            	<tr<?php if ($status == "I") echo " bgcolor=\"#FDEBDF\" "; ?>>
                                    <td align="center" width="60">
                                    <?php if ($ext == "swf") {?>
                                      <object data="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ext; ?>" type="application/x-shockwave-flash" width="31" height="36">
                                        <param name="quality" value="high" />
                                        <param name="flashvars" value="URLname=<?php echo $id_prod; ?>" />
                                        <param name="movie" value="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ext; ?>" />
                                        <param name="wmode" value="opaque" />
                                      </object>
                                    <?php }else{ ?>
                                	<img src="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ext; ?>" width="31" height="36" border="0" />
                                	<?php } ?>
                                    </td>
                                    <td align="center" width="80"><?php echo date("d/m/Y", strtotime($dt_prod));?></td>
                                    <td align="left" width="100"><strong><?php echo $ds_loja; ?></strong></td>
                                    <td align="left" width="120"><strong><?php echo $ds_tipo; ?></strong></td>
                                    <td align="left" width="120"><strong><?php echo $ds_categ; ?></strong></td>
                                    <td align="left" width="70"><strong><?php echo $ds_ref; ?></strong></td>
                                    <td align="left"><?php echo $ds_prod; ?></td>
                                    <td align="right" width="75">
                                    	<?php if ($vlrpromo > 0) { ?>
                                        (<font style="text-decoration:line-through;">R$ <?php echo number_format($vl_prod,2,",",""); ?></font>)<br />R$ <?php echo number_format($vlrpromo,2,",",""); ?>
                                        <?php } else { ?>
                                        R$ <?php echo number_format($vl_prod,2,",",""); ?>
                                        <?php } ?>
                                    </td>
                                    <td align="center" width="45"><strong><?php echo $estoq; ?></strong></td>
                                    <?php if ($SS_nivel >= 50) { ?>
                                    <td align="center" width="25"><a href="grupos_fotos.php?idp=<?php echo $id_prod;?>" title="Imagens do Produto"><img src="img/foto.gif" border="0" /></a></td>
                                    <td align="center" width="25"><a href="#" onclick="confirma_cla(<?php echo $id_prod; ?>);" title="Mover para Classics"><img src="img/ico_classicsp.gif" border="0" /></a></td>
                                    <td align="center" width="25"><a href="#" onclick="confirma_pro(<?php echo $id_prod; ?>,'<?php echo $ext; ?>','<?php echo $ext2; ?>');" title="Deletar Produto"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="clientes_produto.php?idp=<?php echo $id_prod;?>" title="Compradores"><img src="img/ico_search.gif" border="0" /></a></td>
                                    <td align="center" width="25"><a href="grupos_alt.php?idp=<?php echo $id_prod;?>&pg=<?php echo $pagina; ?>" title="Alterar Produto"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a></td>
                                    <?php } ?>
                                    <td align="center" width="25"><a href="estoque.php?idp=<?php echo $id_prod;?>&pg=<?php echo $pagina; ?>" title="Alterar Estoque"><img src="img/ico_cxopen.gif" width="16" height="16" border="0" /></a></td>
                                </tr>
                            </table>
                            </li>
							<?php
							  }
							}
						  }
						 
						?>
                      </ul>
                      <ul class="paginacao" style="width:905px;">
						<?php
                        $consulta = "select count(*) from produtos, produtos_tipo WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
                                     AND DS_CLASSIC_PRRC = 'N' AND NR_SEQ_LOJAS_PRRC = $SS_loja AND ST_PRODUTOS_PRRC = 'I' ";
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
                    
                    <?php if ($SS_nivel >= 50) { ?>
                    <div id="Criar">
                        <form action="grupos_inc.php" method="post" name="myform" enctype="multipart/form-data">
						<table width="880">
                        	<tr>
                            	<td valign="top">
                                <table cellpadding="3" cellspacing="3">
                                    <tr>
                                        <td>
                                            <label for="loja">
                                            <strong>Loja:</strong><br />
                                            <select name="loja">
                                                <option value="0">Todas</option>
                                                <?php
                                                $sql = "select NR_SEQ_LOJA_LJRC, DS_LOJA_LJRC from lojas order by NR_SEQ_LOJA_LJRC";
                                                $st = mysql_query($sql);
                    
                                                if (mysql_num_rows($st) > 0) {
                                                  while($row = mysql_fetch_row($st)) {
                                                   $id_loja	   = $row[0];
                                                   $ds_loja	   = $row[1];
                                                   $checa = "";
                                                   if ($id_loja == $SS_loja) $checa = " selected";
                                                ?>
                                                <option value="<?php echo $id_loja; ?>"<?php echo $checa; ?>><?php echo $ds_loja; ?></option>
                                                <?php
                                                  }
                                                }
                                                ?>
                                            </select>
                                            </label>
                                        </td>
                                        <td>
                                           <label for="tipo">
                                           <strong>Tipo:</strong><br />
                                           <select name="tipo">
                                                <?php
                                                $sql = "select NR_SEQ_CATEGPRO_PTRC, DS_CATEGORIA_PTRC from produtos_tipo order by DS_CATEGORIA_PTRC";
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
                                           </label>
                                        </td>
                                        <td>
                                           <label for="tipo">
                                           <strong>Categoria:</strong><br />
                                           <select name="categoria">
                                                <?php
                                                $sql = "select NR_SEQ_CATEGPRO_PCRC, DS_CATEGORIA_PCRC from produtos_categoria order by DS_CATEGORIA_PCRC";
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
                                        <td>
                                           <label for="tipo">
                                           <strong>Estilo:</strong><br />
                                           <select name="estilo">
                                                <?php
                                                $sql = "select NR_SEQ_ESTILO_ESRC, DS_MUSICA_ESRC from produtos_estilo order by DT_CADASTRO_ESRC";
                                                $st = mysql_query($sql);
                    
                                                if (mysql_num_rows($st) > 0) {
                                                  while($row = mysql_fetch_row($st)) {
                                                   $id_est	   = $row[0];
                                                   $ds_est     = $row[1];
                                                ?>
                                                <option value="<?php echo $id_est; ?>"><?php echo $ds_est; ?></option>
                                                <?php
                                                  }
                                                }
                                                ?>
                                           </select>
                                           </label>
                                        </td>
                                        <td>
                                           <label for="tipo">
                                           <strong>M&uacute;sica:</strong><br />
                                           <select name="musica">
                                                <?php
                                                $sql = "select NR_SEQ_MUSICA_MURC, DS_MUSICA_MURC from produtos_musica order by DS_MUSICA_MURC";
                                                $st = mysql_query($sql);
                    
                                                if (mysql_num_rows($st) > 0) {
                                                  while($row = mysql_fetch_row($st)) {
                                                   $id_mus	   = $row[0];
                                                   $ds_mus     = $row[1];
                                                ?>
                                                <option value="<?php echo $id_mus; ?>"><?php echo $ds_mus; ?></option>
                                                <?php
                                                  }
                                                }
                                                ?>
                                           </select>
                                           </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <label for="nome">
                                               <strong>Descri&ccedil;&atilde;o:</strong><br />
                                               <input class="form02" type="text" name="descricao" style="width:435px;" />
                                             </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="ref">
                                               <strong>Refer&ecirc;ncia:</strong><br />
                                                <input class="form00" type="text" name="ref" style="width:110px;" />
                                             </label>
                                        </td>
                                        <td>
                                             <label for="valor">
                                               <strong>Valor (R$):</strong><br />
                                                <input class="form00" type="text" name="valor" />
                                             </label>
                                        </td>
                                        <td>
                                             <label for="valorsp">
                                               <strong>Valor Custo (R$):</strong><br />
                                                <input class="form00" type="text" name="valor2" />
                                             </label>
                                        </td>
                                        <td>
                                             <label for="Peso">
                                                <strong>Peso (gramas):</strong><br />
                                                <input class="form00" type="text" name="peso" />
                                             </label>
                                        </td>
                                        <td>
                                             <label for="garantia">
                                               <strong>Garantia (meses):</strong><br />
                                               <input class="form00" type="text" name="garantia" />
                                             </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <label for="img">
                                               <strong>Imagem Inicial:</strong><br />
                                               <input class="form02" size="60" type="file" name="FILE1" style="width:435px;height:26px;" onChange="AtualizaImagem();" />
                                             </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                             <label for="img">
                                               <strong>Imagem Medidas:</strong><br />
                                               <input class="form02" size="60" type="file" name="FILE2" style="width:435px;height:26px;" />
                                             </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <label for="descricao">
                                               Informa&ccedil;&otilde;es:<br />
                                               <?php
                                                $oFCKeditor = new FCKeditor('FCKeditor1') ;
                                                $oFCKeditor->ToolbarSet = 'MyToolbar';
                                                $oFCKeditor->BasePath = 'fckeditor/' ;
                                                $oFCKeditor->Width = 500 ;
                                                $oFCKeditor->Height = 200 ;
                                                $oFCKeditor->ForceSimpleAmpersand = false ;
                                                $oFCKeditor->Value = '' ;
                                                $oFCKeditor->Create('informacoes');
                                                ?>
                                             </label>
                                        </td>
                                    </tr>
                                </table>
                        	</td>
                            <td valign="top">
                                <table width="370">
                                    <!--
                                    <tr>
                                        <td>
                                            <strong>Tamanhos Quantidade:</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Masculina:</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                         <label for="PP">
                                                           <strong>PP:</strong><br />
                                                           <input class="form00" type="text" name="m_tamPP" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="P">
                                                           <strong>P:</strong><br />
                                                           <input class="form00" type="text" name="m_tamP" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="M">
                                                           <strong>M:</strong><br />
                                                           <input class="form00" type="text" name="m_tamM" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="G">
                                                           <strong>G:</strong><br />
                                                           <input class="form00" type="text" name="m_tamG" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="GG">
                                                           <strong>GG:</strong><br />
                                                           <input class="form00" type="text" name="m_tamGG" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Feminina:</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                         <label for="fPP">
                                                           <strong>PP:</strong><br />
                                                           <input class="form00" type="text" name="f_tamPP" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="fP">
                                                           <strong>P:</strong><br />
                                                           <input class="form00" type="text" name="f_tamP" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="fM">
                                                           <strong>M:</strong><br />
                                                           <input class="form00" type="text" name="f_tamM" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="fG">
                                                           <strong>G:</strong><br />
                                                           <input class="form00" type="text" name="f_tamG" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="fGG">
                                                           <strong>GG:</strong><br />
                                                           <input class="form00" type="text" name="f_tamGG" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Numeração:</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                         <label for="33">
                                                           <strong>33:</strong><br />
                                                           <input class="form00" type="text" name="tam33" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="34">
                                                           <strong>34:</strong><br />
                                                           <input class="form00" type="text" name="tam34" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="35">
                                                           <strong>35:</strong><br />
                                                           <input class="form00" type="text" name="tam35" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="36">
                                                           <strong>36:</strong><br />
                                                           <input class="form00" type="text" name="tam36" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="37">
                                                           <strong>37:</strong><br />
                                                           <input class="form00" type="text" name="tam37" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <label for="38">
                                                           <strong>38:</strong><br />
                                                           <input class="form00" type="text" name="tam38" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="39">
                                                           <strong>39:</strong><br />
                                                           <input class="form00" type="text" name="tam39" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="40">
                                                           <strong>40:</strong><br />
                                                           <input class="form00" type="text" name="tam40" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="41">
                                                           <strong>41:</strong><br />
                                                           <input class="form00" type="text" name="tam41" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="42">
                                                           <strong>42:</strong><br />
                                                           <input class="form00" type="text" name="tam42" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <label for="43">
                                                           <strong>43:</strong><br />
                                                           <input class="form00" type="text" name="tam43" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="44">
                                                           <strong>44:</strong><br />
                                                           <input class="form00" type="text" name="tam44" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="45">
                                                           <strong>45:</strong><br />
                                                           <input class="form00" type="text" name="tam45" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="46">
                                                           <strong>46:</strong><br />
                                                           <input class="form00" type="text" name="tam46" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                                         </label>
                                                    </td>
                                                    <td>&nbsp;
                                                         
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Tamanho &Uacute;nico:</strong> <input name="tam_un" type="checkbox" value="S" /><br />
											<input class="form00" type="text" name="tam_unqt" style="width:30px;height:20px;text-align:center;vertical-align:middle;" />
                                        </td>
                                    </tr>
                                    -->
                                    <tr>
                                        <td height="30">
                                            <strong>Colocar Destaque:</strong> <input name="destaque" type="radio" value="0" checked="checked" /> N&atilde;o <input name="destaque" type="radio" value="1" /> New <input name="destaque" type="radio" value="2" /> Sale <input name="destaque" type="radio" value="3" /> Reprint<br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="30">
                                            <strong>Frete Gr&aacute;tis:</strong> <input name="frete" type="radio" value="N" checked="checked" /> N&atilde;o <input name="frete" type="radio" value="S" /> Sim<br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="30">
                                            <strong>Valor Promocional (R$):</strong> <input class="form00" type="text" name="vlrpromo" style="width:60px;" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="30">
                                            <strong>Status do Produto:</strong> 
                                            <select name="status" class="form00" style="width:80px;height:23px;">
                                            	<option value="A" selected="selected">Ativo</option>
                                                <option value="I">Inativo</option>
                                            </select>
                                        </td>
                                    </tr>
 <!-- //***** O ANO DA CRIACAO -->
                                    <tr>
                                    	<td height="30">
                                        	<strong> Ano da Criação:</strong>
                                            <input type="text" name="anocriacao" class="form00" >
                                        </td>
                                    </tr>
<!-- //***** -->

<!-- //***** MUSICA DO PRODUTO -->
                                    <tr>
                                    	<td >
                                        	<strong> Música do Produto:</strong><br />&nbsp;&nbsp;&nbsp;Ex: http://media.imeem.com/m/TmYGQ6hQZ5/aus=false
                                            <input type="text" name="musicprod" class="form00" style="width:280px"  />
                                        </td>
                                    </tr>
<!-- //***** -->
                                    <tr><td height="55"><input type="submit" id="postar" name="postar" value="Cadastrar Produto" /></td></tr>
                                </table>
								<img src="img/x.gif" name="imagem_foto" border="0">
                            </td>
                            </tr>
                        </table>
                        </form>
                    
                    </div> <!-- /criar -->
                    
                    <div id="Categ">
                    
                    	<form action="prod_cat_inc.php" method="post">
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
                               <div>Exc</div>
                               </li>
                            <?php
                              $sql = "select NR_SEQ_CATEGPRO_PCRC, DS_CATEGORIA_PCRC, NR_SEQ_LOJA_PCRC from produtos_categoria order by DS_CATEGORIA_PCRC";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_cat	   = $row[0];
                                 $nm_cat	   = $row[1];
                                 $nr_loja	   = $row[2];
                                ?>
                                <li>
                                <span><strong><?php echo $nm_cat;?></strong></span>
                                <?php if ($SS_loja == $nr_loja) { ?>
                                <div>
                                <a href="#" title="deletar categoria" onclick="confirma_cat(<?php echo $id_cat; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                <?php } ?>
                                </li>
                                <?php
                                }
                              }
                            ?>
                          </ul>
                      
                    </div> <!-- /categoria -->
                    
            		<div id="Tipos">
                    
                    	<form action="prod_tipo_inc.php" method="post">
                      
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_tip">
                                       Produto Tipo:<br />
                                       <input class="form02" type="text" id="nome_tip" name="nome_tip" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Tipo" />
                                   </li>
                                 </ul>
                
                         </form>
                        
                          <ul class="noticias">
                          	   <li>
                               <span><strong>Tipos</strong></span>
                               <div>Exc</div>
                               </li>
                            <?php
                              $sql = "select NR_SEQ_CATEGPRO_PTRC, DS_CATEGORIA_PTRC, NR_SEQ_LOJA_PTRC from produtos_tipo order by DS_CATEGORIA_PTRC";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_tip	   = $row[0];
                                 $nm_tip	   = $row[1];
                                 $nr_loja      = $row[2];
                                ?>
                                <li>
                                <span><strong><?php echo $nm_tip;?></strong></span>
                                <?php if ($SS_loja == $nr_loja) { ?>
                                <div>
                                <a href="#" title="deletar tipo" onclick="confirma_tip(<?php echo $id_tip; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                <?php } ?>
                                </li>
                                <?php
                                }
                              }
                            ?>
                          </ul>
                      
                    </div> <!-- /Tipo -->
                    
                    <div id="estil">
                    
                    	<form action="prod_estilo_inc.php" method="post">
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_estilo">
                                       Estilo:<br />
                                       <input class="form02" type="text" id="nome_estilo" name="nome_estilo" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Estilo" />
                                   </li>
                                 </ul>
                         </form>
                        
                          <ul class="noticias">
                          	   <li>
                               <span><strong>Estilos</strong></span>
                               <div>Exc</div>
                               </li>
                            <?php
                              $sql = "select NR_SEQ_ESTILO_ESRC, DS_MUSICA_ESRC, NR_SEQ_LOJA_ESRC from produtos_estilo order by DT_CADASTRO_ESRC";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_estilo	   = $row[0];
                                 $nm_estilo	   = $row[1];
                                 $nr_loja      = $row[2];
                                ?>
                                <li>
                                <span><strong><?php echo $nm_estilo;?></strong></span>
                                <?php if ($SS_loja == $nr_loja) { ?>
                                <div>
                                <a href="#" title="deletar estilo" onclick="confirma_est(<?php echo $id_estilo; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                <?php } ?>
                                </li>
                                <?php
                                }
                              }
                            ?>
                          </ul>
                      
                    </div>
                    
                    <div id="Music">
                    
                    	<form action="prod_musica_inc.php" method="post">
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_musica">
                                       M&uacute;sica:<br />
                                       <input class="form02" type="text" id="nome_musica" name="nome_musica" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar M&uacute;sica" />
                                   </li>
                                 </ul>
                         </form>
                        
                          <ul class="noticias">
                          	   <li>
                               <span><strong>M&uacute;sicas</strong></span>
                               <div>Exc</div>
                               </li>
                            <?php
                              $sql = "select NR_SEQ_MUSICA_MURC, DS_MUSICA_MURC, NR_SEQ_LOJA_MURC from produtos_musica order by DS_MUSICA_MURC";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_musica	   = $row[0];
                                 $nm_musica	   = $row[1];
                                 $nr_loja      = $row[2];
                                ?>
                                <li>
                                <span><strong><?php echo $nm_musica;?></strong></span>
                                <?php if ($SS_loja == $nr_loja) { ?>
                                <div>
                                <a href="#" title="deletar musica" onclick="confirma_mus(<?php echo $id_musica; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                <?php } ?>
                                </li>
                                <?php
                                }
                              }
                            ?>
                          </ul>
                      
                    </div> <!-- /Tipo -->
                    
                    <?php } ?>
                    
					<script>
					  defineAba("abaVer","Ver");
                      <?php if ($SS_nivel >= 50) { ?>
                      defineAba("abaCriar","Criar");
					  defineAba("abaCateg","Categ");
					  defineAba("abaTipos","Tipos");
					  defineAba("abaEstil","estil");
					  defineAba("abaMusic","Music");
                      <?php } ?>
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
						  case 4:
						  	  echo "defineAbaAtiva(\"abaTipos\");";
							  break;
						  case 6:
						  	  echo "defineAbaAtiva(\"abaEstil\");";
							  break;
						  case 5:
						  	  echo "defineAbaAtiva(\"abaMusic\");";
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
                <br>
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>

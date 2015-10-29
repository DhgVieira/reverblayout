<?php
include 'auth.php';
include 'lib.php';

$arq = request("arq");
$ver = request("ver");
$cat = request("cat");

$sql = "select NR_SEQ_ARQUIVO_AQRC, NR_SEQ_USER_AQRC, DS_ARQUIVO_AQRC, DS_DESCRICAO_AQRC,
             DT_ARQUIVO_AQRC, DS_NOME_ORIG_AQRC, DS_EXT_AQRC, DS_CATEGORIA_PCRC, NR_SEQ_CATEGPRO_PCRC
        from arquivos, arquivos_categoria where NR_SEQ_CATEGORIA_AQRC = NR_SEQ_CATEGPRO_PCRC 
              AND NR_SEQ_ARQUIVO_AQRC = $arq ";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_row($st);
    $id_arq	   = $row[0];
    $nr_user   = $row[1];
    $ds_arq	   = $row[2];
    $ds_desc   = $row[3];
    $dt_arq	   = $row[4];
    $ds_nmorig = $row[5];
    $ds_ext	   = $row[6];
    $ds_categ  = $row[7];
    $id_categ  = $row[8];
    
    $sql2 = "select DT_ALTERA플O_AHRC from arquivos_historico where NR_SEQ_ARQUIVO_AHRC = $id_arq order by DT_ALTERA플O_AHRC desc limit 1";
    $st2 = mysql_query($sql2);
    if (mysql_num_rows($st2) > 0) {
        $row2 = mysql_fetch_row($st2);
        $dt_versao = $row2[0];
    }else{
        $dt_versao = $dt_arq;
    }
}
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma_del(ida,extensao) {
	var confirma = confirm("Confirma a Exclusao desse Arquivo?")
	if ( confirma ){
		document.location.href='arquivos_hist_del.php?arq='+ida+'&ext='+extensao;
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
                              <li id="menuDepo" class="abaativa">Arquivos Altera&ccedil;&atilde;o</li>
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
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='arquivos.php';">Arquivos</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Arquivo</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <div id="Criar">
                        <form action="arquivos_hist_inc.php" method="post" name="myform" enctype="multipart/form-data">
						<input type="hidden" name="arqorig" value="<?php echo $arq ?>" />
                        <input type="hidden" name="extorig" value="<?php echo $ds_ext ?>" />
                        <table width="880">
                        	<tr>
                            	<td valign="top">
                                <table cellpadding="3" cellspacing="3">
                                    <tr>
                                        <td>
                                           <label for="tipo">
                                           <strong>Categoria:</strong><br />
                                           <select name="categoria"<?php if ($nr_user != $SS_logadm) echo " disabled=\"disabled\""; ?>>
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
                                           <script type="text/javascript">
                                                document.myform.categoria.value = <?php echo $cat ?>;
                                           </script>
                                           </label>
                                        </td>
                                        <td>
                                            <label for="versao">
                                               <strong>Vers&atilde;o Atual:&nbsp;&nbsp;<?php echo $ver ?></strong> de <?php echo date("d/m/Y G:i",strtotime($dt_versao)); ?>
                                             </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label for="nome">
                                               <strong>Nome:</strong><br />
                                               <strong><?php echo $ds_arq; ?></strong>
                                             </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label for="nome">
                                               <strong>Descri&ccedil;&atilde;o Anterior:</strong><br />
                                               <textarea class="form02" name="descri" style="width:435px; height: 50px;" rows="3" disabled="disabled"><?php echo $ds_desc; ?></textarea>
                                             </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label for="nome">
                                               <strong>Nova Descri&ccedil;&atilde;o:</strong><br />
                                               <textarea class="form02" name="descricao" style="width:435px; height: 50px;" rows="3"><?php echo $ds_desc; ?></textarea>
                                             </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label for="img">
                                               <strong>Atualizar Arquivo:</strong><br />
                                               <input class="form02" size="60" type="file" name="FILE1" style="width:435px;height:26px;" />
                                             </label>
                                        </td>
                                    </tr>
                                    <tr><td colspan="2"><input type="submit" id="postar" name="postar" value="Atualizar Arquivo" /></td></tr>
                                </table>
                        	</td>
                            <td valign="top">
                                &nbsp;
                            </td>
                            </tr>
                        </table>
                        </form>
                        <ul class="noticias">
                        <li style="width:905px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            	<tr>
                                	<td align="left"><strong>VERS&Otilde;ES ANTERIORES</strong></td>
                                </tr>
                            </table>
                        </li>
                        <li style="width:905px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            	<tr>
                                	<td align="center" width="20"><strong>Vr</strong></td>
                                    <td align="center" width="110"><strong>Data Cad.</strong></td>
                                    <td align="left" width="120"><strong>Categoria</strong></td>
                                    <td align="left"><strong>Nome</strong></td>
                                    <td align="left" width="300"><strong>Arquivo</strong></td>
                                    <td align="left" width="50">&nbsp;</td>
                                </tr>
                            </table>
                         </li>
                         </ul>
                        <ul class="noticias">
                          <?php 
                          $sql = "select NR_SEQ_ARQ_HIST_AHRC, NR_SEQ_USER_AHRC, DS_ARQUIVO_AHRC, DS_DESCRICAO_AHRC,
                                         DT_ALTERA플O_AHRC, DS_NOMEORIG_AHRC, DS_EXT_AHRC, DS_CATEGORIA_PCRC, NR_SEQ_CATEG_AHRC
                                  from arquivos_historico, arquivos_categoria where NR_SEQ_CATEG_AHRC = NR_SEQ_CATEGPRO_PCRC 
                                         AND NR_SEQ_ARQUIVO_AHRC = $id_arq ";
						  $sql .= "order by DT_ALTERA플O_AHRC asc";
						  $st = mysql_query($sql);

						  if (mysql_num_rows($st) > 0) {
							$xtot = 1;
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
    					  ?>
							<li style="width:905px;">
                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                            	<tr>
                                    <td align="center" width="20"><strong><?php echo $xtot; ?></strong></td>
                                    <td align="center" width="110"><?php echo date("d/m/Y G:i", strtotime($dt_arq));?></td>
                                    <td align="left" width="120"><strong><?php echo $ds_categ; ?></strong></td>
                                    <td align="left"><?php echo $ds_arq; ?></td>
                                    <td align="left" width="300"><?php echo $ds_nmorig; ?></td>
                                    <td align="center" width="25"><a href="arquivos_baixar.php?file=arquivos/historico/<?php echo $id_arq; ?>.<?php echo $ds_ext; ?>&arq=<?php echo $id_arq ?>&tipo=2"><img src="img/download.png" width="16" height="16" border="0" /></a></td>
                                    <?php if ($SS_logadm == 1){ ?>
                                    <td align="center" width="25"><a href="#" onclick="confirma_del(<?php echo $id_arq; ?>,'<?php echo $ds_ext; ?>');"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                    <?php } else { ?>
                                    <td>&nbsp;</td>
                                    <?php } ?>
                                </tr>
                            </table>
                            </li>
							<?php
                            $xtot++;
							}
						  }
						 
						?>
                        </ul>
                    
                    </div> <!-- /criar -->
                    
					<script>
					  defineAba("abaVer","Ver");
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
<?php mysql_close($con);?>

<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$PHP_SELF = "campanhas.php";

$pesq_nom = request("nome");

include 'topo.php';
?>
<script language="javascript">
function confirma(idcomp) {
	var confirma = confirm("Confirma a Exclusao dessa Campanha e suas estatisticas?\nEsta operacao nao podera ser revertida.")
	if ( confirma ){
		document.location.href='campanhas_del.php?idc='+idcomp+'&pg=<?php echo $pagina; ?>';
	} else {
		return false
	} 
}
</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Campanhas</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Campanhas Cadastradas</li>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Nova Campanha</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas">
                <br />
                
                
                    <div id="Ver">
                        <table><tr>
                   <td width="700" align="left">&nbsp;</td>
                   <form action="campanhas.php" method="post" name="formnews" id="formnews">
                <td height="20" align="right" valign="middle">
                	<strong>Buscar por: </strong><input style="width:170px;height:14px;" class="frm_pesq" type="text" name="nome" value="<?php echo $pesq_nom; ?>" />
 
                    <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                </td></form>

                    </tr></table>
                    <ul class="compras">
                    <li>
                        <table border="0" cellpadding="0" cellspacing="0" height="30" width="1090">
                            <tr>
                                <td width="100" align="center"><strong>Dta.Cadastro</strong></td>
                                <td align="left"><strong>Campanha</strong></td>
                                <td width="140" align="left"><strong>Parametros</strong></td>
                                <td width="20">&nbsp;</td>
                                <td width="20">&nbsp;</td>
                                <td width="90" align="center">Vendas<br />Concretizadas</td>
                                <td width="90" align="center">Total R$</td>
                                <td width="80" align="center">Vendas<br />&Uacute;ltimos 7 dias</td>
                                <td width="90" align="center">Total R$</td>
                                <td width="80" align="center">Vendas<br />&Uacute;ltimos 30 dias</td>
                                <td width="80" align="center">Total R$</td>
                            </tr>
                        </table>
                    </li>
                    </ul>
                	<ul class="compras">
						<?php
						  $num_por_pagina = 80;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_CAMPANHA_CARC, DS_CAMPANHA_CARC, DT_CRIACAO_CARC from campanhas ";
						  if ($pesq_nom) {
                              if (strpos($pesq_nom," ") > 0){
                                 $nome1 = substr($pesq_nom,0,strpos($pesq_nom," "));
                                 $nome2 = str_replace($nome1." ","",$pesq_nom);
                                 $sql .= " WHERE (DS_CAMPANHA_CARC like '%$nome1%' and DS_CAMPANHA_CARC like '%$nome2%')";
                              }else{
                                 $sql .= " WHERE DS_CAMPANHA_CARC LIKE '%$pesq_nom%'";
                              }
                          }
                          $sql .= " order by DT_CRIACAO_CARC desc LIMIT $primeiro_registro, $num_por_pagina";
                          $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
						  	while($row = mysql_fetch_row($st)) {
							 $id_camp	   = $row[0];
					         $ds_camp	   = $row[1];
							 $dt_camp	   = $row[2];
                             
                             $sqlv = "SELECT count(*), sum(VL_TOTAL_COSO) from compras, campanhas_hist
                                      where NR_SEQ_COMPRA_COSO = DS_OBS_ACRC AND NR_SEQ_CAMPANHA_ACRC = $id_camp AND
                                      NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) and ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A'";
                             $stv = mysql_query($sqlv);
                             $total = 0;
                             if (mysql_num_rows($stv) > 0) {
                                $rowv = mysql_fetch_row($stv);
                                $total = $rowv[0];
                                $totalv = $rowv[1];
                             }
                             
                             $sqlv = "SELECT count(*), sum(VL_TOTAL_COSO) from compras, campanhas_hist
                                      where NR_SEQ_COMPRA_COSO = DS_OBS_ACRC AND NR_SEQ_CAMPANHA_ACRC = $id_camp AND
                                      NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) and ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A'
                                      and DT_COMPRA_COSO > DATE_SUB(SYSDATE(), INTERVAL 7 DAY)";
                             $stv = mysql_query($sqlv);
                             $total7 = 0;
                             if (mysql_num_rows($stv) > 0) {
                                $rowv = mysql_fetch_row($stv);
                                $total7 = $rowv[0];
                                $total7v = $rowv[1];
                             }
                             
                             $sqlv = "SELECT count(*), sum(VL_TOTAL_COSO) from compras, campanhas_hist
                                      where NR_SEQ_COMPRA_COSO = DS_OBS_ACRC AND NR_SEQ_CAMPANHA_ACRC = $id_camp AND
                                      NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) and ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A'
                                      and DT_COMPRA_COSO > DATE_SUB(SYSDATE(), INTERVAL 30 DAY)";
                             $stv = mysql_query($sqlv);
                             $total30 = 0;
                             if (mysql_num_rows($stv) > 0) {
                                $rowv = mysql_fetch_row($stv);
                                $total30 = $rowv[0];
                                $total30v = $rowv[1];
                             }
							?>
                            <li>
                            <table border="0" width="1090" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="100" align="center"><?php echo date("d/m/Y G:i", strtotime($dt_camp));?></td>
                                    <td align="left"><strong><?php echo $ds_camp; ?></strong></td>
                                    <td width="140" align="left">?cp=<?php echo $id_camp; ?> / &amp;cp=<?php echo $id_camp; ?></td>
                                    <td align="center" width="20"><a href="campanhas_alt.php?idc=<?php echo $id_camp; ?>" title="Alterar Campanha"><img src="img/ico-det.gif" border="0" /></a></td>
                                    <td align="center" width="20"><a href="#" title="Apagar Campanha" onclick="confirma(<?php echo $id_camp;?>);"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                    <td width="90" align="center"><strong><?php echo $total; ?></strong></td>
                                    <td width="90" align="center"><strong>R$ <?php echo number_format($totalv,2,",","."); ?></strong></td>
                                    <td width="80" align="center"><strong><?php echo $total7; ?></strong></td>
                                    <td width="90" align="center"><strong>R$ <?php echo number_format($total7v,2,",","."); ?></strong></td>
                                    <td width="80" align="center"><strong><?php echo $total30; ?></strong></td>
                                    <td width="80" align="center"><strong>R$ <?php echo number_format($total30v,2,",","."); ?></strong></td>
                                </tr>
                            </table>
                            </li>
							<?php
							}
						  }
						 
						?>
                      </ul>
                      <?php if ($mostrapag) {?>
                      <ul class="paginacao">
						<?php
                        $consulta = "select count(*) from campanhas ";
                        if ($pesq_nom) {
                              if (strpos($pesq_nom," ") > 0){
                                 $nome1 = substr($pesq_nom,0,strpos($pesq_nom," "));
                                 $nome2 = str_replace($nome1." ","",$pesq_nom);
                                 $consulta .= " WHERE (DS_CAMPANHA_CARC like '%$nome1%' and DS_CAMPANHA_CARC like '%$nome2%')";
                              }else{
                                 $consulta .= " WHERE DS_CAMPANHA_CARC LIKE '%$pesq_nom%'";
                              }
                          }
                        list($total_usuarios) = mysql_fetch_array(mysql_query($consulta,$con));
                        
                        $total_paginas = $total_usuarios/$num_por_pagina;
                        $prev = $pagina - 1;
                        $next = $pagina + 1;
                        if ($pagina > 1) {
                        $prev_link = "<li><a href=\"$PHP_SELF?pagina=$prev&nome=$pesq_nom\">Anterior</a></li>";
                        } else { 
                        $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas > $pagina) {
                        $next_link = "<li><a href=\"$PHP_SELF?pagina=$next&nome=$pesq_nom\">Proxima</a></li>";
                        } else {
                        $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas = ceil($total_paginas);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas; $x++) {
                          if ($x==$pagina) { 
                            $painel .= "<li>[$x]</li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?pagina=$x&nome=$pesq_nom\">[$x]</a></li>";
                          }
                        }
                        echo "$prev_link";
                        echo "$painel";
                        echo "$next_link";
						
						 mysql_close($con);
                        ?>                
                    </ul> <!-- /paginacao -->
                    <?php } ?>
                      </div> <!-- /ver -->
                    
                    <div id="Criar">

                         <form action="campanhas_inc.php" method="post">
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_noticia">
                                       Nome da Campanha:<br />
                                       <input class="form02" type="text" name="nome" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Criar Campanha " />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                    
                    </div> <!-- /criar -->
                    
                    
                    <script>
                      defineAba("abaVer","Ver");
                      defineAba("abaCriar","Criar");
					 
					  <?php if (!$mostrapag) {?>
					  defineAbaAtiva("abaCriar");					  
					  <?php }else{?>
                      defineAbaAtiva("abaVer");
					  <?php }?>
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>
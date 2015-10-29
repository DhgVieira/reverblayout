<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$PHP_SELF = "topicos.php";

$idf = request("idf");
$pesq_nom = request("nome");
if (!$idf) $idf = 1;

$sql = "select DS_FORUM_FOSO from foruns where NR_SEQ_FORUM_FOSO = $idf";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);
	$nm_forum = $row[0];
}
?>

<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idcomp) {
	var confirma = confirm("Confirma a Exclusao desse Topico e suas mensagens?\nEsta operacao nao podera ser revertida.")
	if ( confirma ){
		document.location.href='topicos_del.php?idf=<?php echo $idf; ?>&pg=<?php echo $pagina; ?>&idt='+idcomp;
	} else {
		return false
	} 
}
</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Topicos</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Topicos Cadastrados</li>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Novo Topico</li>
                      <li id="abaEnviar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='msgtodos.php'">Escrever Mensagem</li>
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
                   <td width="700" align="left">&nbsp;&nbsp;&nbsp;Forum selecionado: <strong><?php echo $nm_forum; ?></strong></td>
                   <form action="topicos.php" method="post" name="formnews" id="formnews">
                <td height="20" align="right" valign="middle">
                	<strong>Buscar por: </strong><input style="width:170px;height:14px;" class="frm_pesq" type="text" name="nome" value="<?php echo $pesq_nom; ?>" />
 
                    <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                </td></form>

                    </tr></table>
                        <table border="0" cellpadding="0" cellspacing="0" height="30">
                            <tr>
                            	<td width="10">&nbsp;</td>
                                <td width="100" align="center"><strong>Dta.Cadastro</strong></td>
                                <td width="380" align="left"><strong>Topico</strong></td>
                                <td width="140" align="left"><strong>Autor</strong></td>
                                <td width="180" align="left"><strong>E-Mail</strong></td>
                                <td width="35" align="center"><strong>Msg</strong></td>
                                <td width="35" align="center"><strong>ST</strong></td>
                            </tr>
                        </table>
                	<ul class="compras">
						<?php
						  $num_por_pagina = 20;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_TOPICO_TOSO, DS_TOPICO_TOSO, ST_TOPICO_TOSO, DT_CADASTRO_TOSO, DS_NOME_CASO, DS_EMAIL_CASO, NR_MSGS_TOSO from topicos, cadastros where NR_SEQ_CADASTRO_TOSO = NR_SEQ_CADASTRO_CASO and NR_SEQ_FORUM_TOSO = $idf ";
						  if ($pesq_nom) {
                              if (strpos($pesq_nom," ") > 0){
                                 $nome1 = substr($pesq_nom,0,strpos($pesq_nom," "));
                                 $nome2 = str_replace($nome1." ","",$pesq_nom);
                                 $sql .= " AND (DS_TOPICO_TOSO like '%$nome1%' and DS_TOPICO_TOSO like '%$nome2%')";
                              }else{
                                 $sql .= " AND DS_TOPICO_TOSO LIKE '%$pesq_nom%'";
                              }
                          }
                          $sql .= " order by DT_CADASTRO_TOSO desc LIMIT $primeiro_registro, $num_por_pagina";
                          $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
						  	while($row = mysql_fetch_row($st)) {
							 $id_forum	   = $row[0];
					         $ds_forum	   = $row[1];
							 $st_forum	   = $row[2];
							 $dt_cad	   = $row[3];
							 $ds_nome	   = $row[4];
							 $ds_email	   = $row[5];
							 $nr_msgs	   = $row[6];
							?>
							<li>
                            <table border="0" width="950" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="100" align="center"><?php echo date("d/m/Y G:i", strtotime($dt_cad));?></td>
                                    <td align="left"><strong><?php echo $ds_forum; ?></strong></td>
                                    <td width="140" align="left"><?php echo $ds_nome; ?></td>
                                    <td width="180" align="left"><a href="mailto:<?php echo $ds_email; ?>" class="linksmenu"><?php echo $ds_email; ?></a></td>
                                    <td width="35" align="center"><strong><?php echo $nr_msgs; ?></strong></td>
                                    <td width="35" align="center"><strong><?php echo $st_forum; ?></strong></td>
                                    <td align="center" width="20"><a href="topicos_alt.php?idf=<?php echo $idf; ?>&idt=<?php echo $id_forum;?>" title="Alterar Topico"><img src="img/ico-det.gif" border="0" /></a></td>
                                    <td align="center" width="20"><a href="topicos_sta.php?pg=<?php echo $pagina; ?>&idt=<?php echo $id_forum;?>&idf=<?php echo $idf; ?>&st=<?php echo $st_forum; ?>" title="Alterar Status"><img src="img/ico_check.gif" border="0" /></a></td>
                                    <td align="center" width="20"><a href="msgs.php?idt=<?php echo $id_forum;?>&idf=<?php echo $idf; ?>" title="Ver Mensagens"><img src="img/ico_search.gif" border="0" /></a></td>
                                    <td align="center" width="20"><a href="#" title="Deletar Topico" onclick="confirma(<?php echo $id_forum;?>);"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
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
                        $consulta = "select count(*) from topicos, cadastros where NR_SEQ_CADASTRO_TOSO = NR_SEQ_CADASTRO_CASO and NR_SEQ_FORUM_TOSO = $idf ";
                        if ($pesq_nom) {
                              if (strpos($pesq_nom," ") > 0){
                                 $nome1 = substr($pesq_nom,0,strpos($pesq_nom," "));
                                 $nome2 = str_replace($nome1." ","",$pesq_nom);
                                 $consulta .= " AND (DS_TOPICO_TOSO like '%$nome1%' and DS_TOPICO_TOSO like '%$nome2%')";
                              }else{
                                 $consulta .= " AND DS_TOPICO_TOSO LIKE '%$pesq_nom%'";
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

                         <form action="topicos_inc.php" method="post">
                         <input name="idf" type="hidden" value="<?php echo $idf; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_noticia">
                                       Nome do Topico:<br />
                                       <input class="form02" type="text" name="nome" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="postar topico" />
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
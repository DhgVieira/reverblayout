<?php
include 'auth.php';
include 'lib.php';

$PHP_SELF = "encurtador.php";

$num_por_pagina = 50;

$pagina = request("pagina");
$pesq_nom = request("pesq_nom");

if (!$pagina) {
	$pagina = 1;
}
$primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;

include 'topo.php';
mysql_close($con);

// $con2 = mysql_connect("187.45.250.76","reverb_div","ay7ydfgw-e23") or die("Conexão Falhou!");
// mysql_select_db("reverb_div",$con2) or die("Database Inválido");

$con2 = mysql_connect("reverbcity1.cp48hix4ktfm.sa-east-1.rds.amazonaws.com","reverb","reverbserver2014") or die("Conexão Falhou!");
mysql_select_db("rvbla",$con2) or die("Database Inválido");

$consulta = "SELECT COUNT(*) FROM urls ";
if ($pesq_nom) $consulta .= "WHERE DS_URLFULL_URDB LIKE '%$pesq_nom%'";   
list($total_usuarios) = mysql_fetch_array(mysql_query($consulta,$con2));
?>
<script language="javascript">
function confirma(idu) {
	var confirma = confirm("Confirma a Exclusão dessa URL? Essa operação não poderá ser revertida.")
	if ( confirma ){
		document.location.href='encurtador_del.php?pg=<?php echo $pagina; ?>&idu='+idu
	} else {
		return false
	} 
}
</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Encurtador de Urls</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Urls Encurtadas (<?php echo $total_usuarios; ?>)</li>
                    </ul>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td align="left" colspan="3">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas">
                   <div id="Ver">
                   
                   <table><tr>
                   <td width="30">&nbsp;</td>
                   <form action="encurtador.php" method="post" name="formnews" id="formnews">
                <td height="20" align="right" valign="middle">
                	<strong>Procurar link: </strong><input style="width:420px;height:14px;" class="frm_pesq" type="text" name="pesq_nom" value="<?php echo $pesq_nom; ?>" />
                    <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                </td></form>

                    </tr></table>
                   
                    <form action="encurtador_inc.php" method="post" name="frmurl" id="frmurl">
                     <ul class="formularios">
                       <li style="width: 1000px;">
                         <label for="nome_cat">
                           URL:<br />
                           <input class="form02" type="text" id="urlfull" name="urlfull" /> Forçar link (opcional):  http://rvb.la/<input class="form00" type="text" id="link" name="link" maxlength="30" />
                         </label>
                       </li>
                       <li>
                         <input type="submit" id="postar" name="postar" value="Encurtar" />
                       </li>
                     </ul>
                    </form>
                    <script type="text/javascript">document.frmurl.urlfull.focus();</script>
                	<ul class="compras">
                    <li>
                    <table border="0" width="1000" cellpadding="0" cellspacing="2">
                            <tr>
                                <td align="center" width="130"><strong>Data Criação</strong></td>
                                <td align="left"><strong>URL Destino</strong></td>
                                <td align="left" width="150"><strong>URL Encurtada</strong></td>
                                <td align="center" width="50"><strong>Cliques</strong></td>
                                <td align="center" width="20">&nbsp;</td>
                                <td align="center" width="20">&nbsp;</td>
                            </tr>
                        </table>
                    </li>
						<?php
						  $sql = "select NR_SEQ_URL_URDB, DT_CADASTRO_URDB, DS_URLFULL_URDB, DS_URLCUT_URDB, NR_VIEWS_URDB
                                     from urls "; 
                          if ($pesq_nom) $sql .= "WHERE DS_URLFULL_URDB LIKE '%$pesq_nom%'";                        
                          $sql .= " order by DT_CADASTRO_URDB desc LIMIT $primeiro_registro, $num_por_pagina";
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
						  	while($row = mysql_fetch_row($st)) {
							 $id_url	   = $row[0];
					         $ds_urlfull   = $row[2];
							 $ds_urlcut	   = $row[3];
							 $nr_views	   = $row[4];
							 $dt_cad	   = $row[1];
							?>
							<li style="width: 1000px;">
                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                <tr>
                                    <td align="center" width="130"><strong><?php echo date("d/m/Y G:i",strtotime($dt_cad)); ?></strong></td>
                                    <td align="left"><a href="<?php echo $ds_urlfull; ?>" target="_blank"><?php echo $ds_urlfull; ?></a></td>
                                    <td align="left" width="150"><input type="text" style="width:150px;height:14px;" class="frm_pesq" name="urlcut" value="http://rvb.la/<?php echo $ds_urlcut; ?>" onClick="javascript:this.focus();this.select();" /></td>
                                    <td align="center" width="50"><?php echo $nr_views; ?></td>
                                    <td align="center" width="20"><a href="http://rvb.la/<?php echo $ds_urlcut; ?>" target="_blank"><img src="img/compras_ver.gif" border="0" /></a></td>
                                    <td align="center" width="20"><a href="#" title="Deletar URL" onclick="confirma(<?php echo $id_url;?>);"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                </tr>
                            </table>
                            </li>
							<?php
							}
						  }
						 
						?>
                      </ul>
                      <?php if ($mostrapag) {?>
                      <ul class="paginacao2">
						<?php
                        $total_paginas = $total_usuarios/$num_por_pagina;
                        $prev = $pagina - 1;
                        $next = $pagina + 1;
                        if ($pagina > 1) {
                        $prev_link = "<li><a href=\"$PHP_SELF?pagina=$prev&pesq_nom=$pesq_nom\">Anterior</a></li>";
                        } else { 
                        $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas > $pagina) {
                        $next_link = "<li><a href=\"$PHP_SELF?pagina=$next&pesq_nom=$pesq_nom\">Proxima</a></li>";
                        } else {
                        $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas = ceil($total_paginas);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas; $x++) {
                          if ($x==$pagina) { 
                            $painel .= "<li>[$x]</li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?pagina=$x&pesq_nom=$pesq_nom\">[$x]</a></li>";
                          }
                        }
                        
                        $mostrapainel = true;
                        
                        
                        echo "$prev_link";
                        if ($mostrapainel) echo "$painel";
                        echo "$next_link";
						
						
                        ?>                
                    </ul> <!-- /paginacao -->
                    <?php } ?>
                  	</div>	<!-- Ver -->
                                     
                    <script>
                      defineAba("abaVer","Ver");
                    </script>
                    
                    
              <?php  mysql_close($con2);    ?>
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>
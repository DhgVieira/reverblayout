<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$PHP_SELF = "reverbcycle.php";
?>
<? include 'topo.php'; ?>
<script language="javascript">
function confirma(idp,ext) {
	var confirma = confirm("Confirma a Exclusao desse Cycle?")
	if ( confirma ){
		document.location.href='reverbcycle_del.php?pg=<?php echo $pagina; ?>&idp='+idp+'&ext='+ext;
	} else {
		return false
	} 
}

</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">ReverbCycle</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Objetos Cadastradss</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <div id="Ver">
                    
                	<ul class="noticias">
                    	<li>
							<table border="0" width="875" cellpadding="0" cellspacing="0">
                                <tr>
                                	<td align="center" width="60"><strong>Imagem</strong></td>
                                    <td align="center" width="120"><strong>Dt.Cadastro</strong></td>
                                    <td align="left" width="170"><strong>Autor</strong></td>
                                    <td align="left"><strong>Caracteristicas</strong></td>
                                    <td align="center" width="25"><strong>ST</strong></td>
                                    <td align="center" width="20">&nbsp;</td>
                                    <td align="center" width="20">&nbsp;</td>
                                </tr>
                            </table>
                            </li>
						<?
						  $num_por_pagina = 20;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_REVERBCYCLE_RCRC, DS_OBJETO_RCRC, DS_EXT_RCRC, DS_CARACTERISTICAS_RCRC, DS_NOME_CASO, NR_SEQ_CADASTRO_RCRC, DT_CADASTRO_RCRC, ST_CYCLE_RCRC
							from reverbcycle, cadastros WHERE NR_SEQ_CADASTRO_RCRC = NR_SEQ_CADASTRO_CASO order by DT_CADASTRO_RCRC desc LIMIT $primeiro_registro, $num_por_pagina";
							$st = mysql_query($sql);
							if (mysql_num_rows($st) > 0) {
								while($row = mysql_fetch_row($st)) {
									$id_recyc	   = $row[0];
									$ds_objeto	   = $row[1];
									$ds_ext	  	   = $row[2];
									$ds_carac	   = $row[3];
									$ds_autor	   = $row[4];
									$id_autor	   = $row[5];
									$dt_cad	 	   = $row[6];
									$status	 	   = $row[7];
							?>
                            <li>
							<table border="0" width="875" cellpadding="0" cellspacing="0">
                                <tr>
                                	<td align="center" width="60"><a href="../images/reverbcycle/<?php echo $id_recyc; ?>.<?php echo $ds_ext; ?>" class="lightview"><img src="../images/reverbcycle/<?php echo $id_recyc; ?>p.<?php echo $ds_ext; ?>" border="0" width="50" height="50" /></a></td>
                                    <td align="center" width="120"><strong><?php echo date("d/m/Y G:i", strtotime($dt_cad)); ?></strong></td>
                                    <td align="left" width="170"><?php echo $ds_autor; ?></td>
                                    <td align="left"><?php echo $ds_carac; ?></td>
                                    <td align="center" width="25"><strong><?php echo $status; ?></strong></td>
                                    <td align="center" width="20"><a href="reverbcycle_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&idp=<? echo $id_recyc;?>" title="Alterar Status"><img src="img/ico_cancel.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="20"><a href="#" title="Deletar Party" onclick="confirma(<?php echo $id_recyc;?>,'<?php echo $ds_ext; ?>');"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                </tr>
                            </table>
                            </li>
							<?
							}
						  }
						 
						?>
                      </ul>
                      <?php if ($mostrapag) {?>
                      <ul class="paginacao">
						<?
                        $consulta = "select count(*) from reverbcycle, cadastros WHERE NR_SEQ_CADASTRO_RCRC = NR_SEQ_CADASTRO_CASO";
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
                    <?php } ?>
                      </div> <!-- /ver -->
                

                    <script>
					  defineAba("abaVer","Ver");
					  defineAbaAtiva("abaVer");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?
mysql_close($con);
include 'rodape.php'; ?>
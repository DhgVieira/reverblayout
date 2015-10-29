<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
 $aba = request("aba");
$PHP_SELF = "people.php";
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idp,ext) {
	var confirma = confirm("Confirma a Exclusao dessa Foto e seus comentarios?")
	if ( confirma ){
		document.location.href='people_del.php?pg=<?php echo $pagina; ?>&idp='+idp+'&ext='+ext;
	} else {
		return false
	} 
}

</script> 

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">People</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Fotos Cadastradas</li>
                      <li id="abaPos" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='people_ordem.php';">Posição das Fotos</li>
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
                                	<td align="center" width="60"><strong>Foto</strong></td>
                                    <td align="center" width="120"><strong>Dt.Cadastro</strong></td>
                                    <td align="left" width="170"><strong>Autor</strong></td>
                                    <td align="left"><strong>Descricao</strong></td>
                                    <td align="center" width="25"><strong>ST</strong></td>
                                    <td align="center" width="20">&nbsp;</td>
                                    <td align="center" width="20">&nbsp;</td>
                                    <td align="center" width="20">&nbsp;</td>
                                </tr>
                            </table>
                            </li>
						<?php
						  $num_por_pagina = 20;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_FOTO_FORC, DT_CADASTRO_FORC, DS_NOME_FORC, ST_PEOPLE_FORC, DS_NOME_CASO, DS_EXT_FORC, NR_SEQ_CADASTRO_FORC from me_fotos, cadastros WHERE NR_SEQ_CADASTRO_FORC = NR_SEQ_CADASTRO_CASO and DS_PEOPLE_FORC = 'S' order by DT_CADASTRO_FORC desc LIMIT $primeiro_registro, $num_por_pagina";
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
						  	while($row = mysql_fetch_row($st)) {
							 $id_foto	   = $row[0];
					         $dt_cad	   = $row[1];
							 $ds_foto	   = $row[2];
							 $status	   = $row[3];
							 $ds_autor	   = $row[4];
							 $ds_ext	   = $row[5];
                             $id_cad	   = $row[6];
                             if(!empty($ds_ext)){
							?>
                            <li>
							<table border="0" width="875" cellpadding="0" cellspacing="0">
                                <tr>
                                	<td align="center" width="60"><a href="/thumb/people/1/0/0/<?php echo $id_foto; ?>.<?php echo $ds_ext; ?>" class="lightview"><img src="/thumb/people/1/50/50/<?php echo $id_foto; ?>.<?php echo $ds_ext; ?>" border="0" width="50" height="50" /></a></td>
                                    <td align="center" width="120"><strong><?php echo date("d/m/Y G:i", strtotime($dt_cad)); ?></strong></td>
                                    <td align="left" width="200"><?php echo ChecaClubStyle($id_cad,$ds_autor); ?></td>
                                    <td align="left"><?php echo $ds_foto; ?></td>
                                    <td align="center" width="25"><strong><?php echo $status; ?></strong></td>
                                    <td align="center" width="20"><a href="people_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&idp=<?php echo $id_foto;?>" title="Alterar Status"><img src="img/ico_cancel.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="20"><a href="people_coments.php?idp=<?php echo $id_foto;?>&pg=<?php echo $pagina;?>" title="Comentarios"><img src="img/ico_coment.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="20"><a href="#" title="Deletar People" onclick="confirma(<?php echo $id_foto;?>,'<?php echo $ds_ext; ?>');"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                </tr>
                            </table>
                            </li>
							<?php
                            }
							}
						  }
						 
						?>
                      </ul>
                      <?php if ($mostrapag) {?>
                      <ul class="paginacao" style="width: 900px;">
						<?php
                        $consulta = "SELECT COUNT(*) FROM me_fotos, cadastros WHERE NR_SEQ_CADASTRO_FORC = NR_SEQ_CADASTRO_CASO and DS_PEOPLE_FORC = 'S'";
                        list($total_usuarios) = mysql_fetch_array(mysql_query($consulta,$con));
                        
                        $total_paginas = $total_usuarios/$num_por_pagina;
                        $prev = $pagina - 1;
                        $next = $pagina + 1;
                        if ($pagina > 1) {
                        $prev_link = "<li><a href=\"$PHP_SELF?pagina=$prev\">Anterior</a></li>\n";
                        } else { 
                        $prev_link = "<li>Anterior</li>\n";
                        }
                        if ($total_paginas > $pagina) {
                        $next_link = "<li><a href=\"$PHP_SELF?pagina=$next\">Proxima</a></li>\n";
                        } else {
                        $next_link = "<li>Proxima</li>\n";
                        }
                        $total_paginas = ceil($total_paginas);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas; $x++) {
                          if ($x==$pagina) { 
                            $painel .= "<li>[$x]</li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?pagina=$x\">[$x]</a></li>\n";
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
					   <?php
					 
					  switch($aba){
					  	  case 1:
						  	  echo "defineAbaAtiva(\"abaVer\");";
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
<?php
mysql_close($con);
include 'rodape.php'; ?>
<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$PHP_SELF = "foruns.php";
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idcomp) {
	var confirma = confirm("Confirma a Exclusao desse Forum e seus topicos e mensagens?\nEsta operacao nao podera ser revertida.")
	if ( confirma ){
		document.location.href='foruns_del.php?pg=<?php echo $pagina; ?>&idf='+idcomp;
	} else {
		return false
	} 
}
</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Foruns</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Foruns Cadastrados</li>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Novo Forum</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <div id="Ver">
                        <table border="0" cellpadding="0" cellspacing="0" height="30">
                            <tr>
                            	<td width="15">&nbsp;</td>
                                <td width="105" align="center"><strong>Dta.Cadastro</strong></td>
                                <td width="292" align="left"><strong>Forum</strong></td>
                                <td width="150" align="left"><strong>Autor</strong></td>
                                <td width="140" align="left"><strong>E-Mail</strong></td>
                                <td width="20" align="center"><strong>ST</strong></td>
                            </tr>
                        </table>
                	<ul class="compras">
						<?
						  $num_por_pagina = 20;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_FORUM_FOSO, DS_FORUM_FOSO, ST_FORUM_FOSO, DT_CADASTRO_FOSO, DS_NOME_CASO, DS_EMAIL_CASO from foruns, cadastros where NR_SEQ_CADASTRO_FOSO = NR_SEQ_CADASTRO_CASO order by DT_CADASTRO_FOSO desc LIMIT $primeiro_registro, $num_por_pagina";
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
							?>
							<li>
                            <table border="0" width="810" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="110" align="center"><?php echo date("d/m/Y G:i", strtotime($dt_cad));?></td>
                                    <td align="left"><strong><?php echo $ds_forum; ?></strong></td>
                                    <td width="150" align="left"><?php echo $ds_nome; ?></td>
                                    <td width="130" align="left"><a href="mailto:<?php echo $ds_email; ?>" class="linksmenu"><?php echo $ds_email; ?></a></td>
                                    <td width="40" align="center"><strong><?php echo $st_forum; ?></strong></td>
                                    <td align="center" width="22"><a href="foruns_alt.php?idf=<? echo $id_forum;?>" title="Alterar Forum"><img src="img/ico-det.gif" border="0" /></a></td>
                                    <td align="center" width="22"><a href="foruns_sta.php?pg=<?php echo $pagina; ?>&idf=<? echo $id_forum;?>&st=<?php echo $st_forum; ?>" title="Alterar Status"><img src="img/ico_check.gif" border="0" /></a></td>
                                    <td align="center" width="22"><a href="topicos.php?idf=<? echo $id_forum;?>" title="Ver Topicos"><img src="img/ico_search.gif" border="0" /></a></td>
                                    <td align="center" width="22"><a href="#" title="deletar forum" onclick="confirma(<? echo $id_forum;?>);"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
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
                        $consulta = "select count(*) from foruns, cadastros where NR_SEQ_CADASTRO_FOSO = NR_SEQ_CADASTRO_CASO";
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
						
						 mysql_close($con);
                        ?>                
                    </ul> <!-- /paginacao -->
                    <?php } ?>
                      </div> <!-- /ver -->
                    
                    <div id="Criar">

                         <form action="foruns_inc.php" method="post">
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_noticia">
                                       Nome do Forum:<br />
                                       <input class="form02" type="text" name="nome" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="postar forum" />
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
<? include 'rodape.php'; ?>

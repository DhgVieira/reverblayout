<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$PHP_SELF = "msgs.php";

$idf = request("idf");
$idt = request("idt");

$sql = "select DS_FORUM_FOSO from foruns where NR_SEQ_FORUM_FOSO = $idf";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);
	$nm_forum = $row[0];
}

$sql = "select DS_TOPICO_TOSO from topicos where NR_SEQ_TOPICO_TOSO = $idt";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);
	$nm_topico = $row[0];
}
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idcomp) {
	var confirma = confirm("Confirma a Exclusao desse Topico e suas mensagens?\nEsta operacao nao podera ser revertida.")
	if ( confirma ){
		document.location.href='msgs_del.php?idf=<?php echo $idf; ?>&idt=<?php echo $idt; ?>&pg=<?php echo $pagina; ?>&idm='+idcomp;
	} else {
		return false
	} 
}
</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Mensagens</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Mensagens Cadastradas</li>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Nova Mensagem</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas">
                <br />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Forum selecionado: <strong><?php echo $nm_forum; ?></strong><br />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;-> Topico selecionado: <strong><?php echo $nm_topico; ?></strong>
                
                    <div id="Ver">
                        <table border="0" cellpadding="0" cellspacing="0" height="30">
                            <tr>
                            	<td width="10">&nbsp;</td>
                                <td width="100" align="center"><strong>Dta.Cadastro</strong></td>
                                <td width="345" align="left"><strong>Mensagem</strong></td>
                                <td width="140" align="left"><strong>Autor</strong></td>
                                <td width="130" align="left"><strong>E-Mail</strong></td>
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
					
						  $sql = "select NR_SEQ_MSG_MESO, DS_MSG_MESO, ST_MSG_MESO, DT_CADASTRO_MESO, DS_NOME_CASO, DS_EMAIL_CASO from msgs, cadastros where NR_SEQ_CADASTRO_MESO = NR_SEQ_CADASTRO_CASO and NR_SEQ_TOPICO_MESO = $idt order by DT_CADASTRO_MESO desc LIMIT $primeiro_registro, $num_por_pagina";
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
						  	while($row = mysql_fetch_row($st)) {
							 $id_msg	   = $row[0];
					         $ds_msg	   = $row[1];
							 $st_msg	   = $row[2];
							 $dt_cad	   = $row[3];
							 $ds_nome	   = $row[4];
							 $ds_email	   = $row[5];
							?>
							<li>
                            <table border="0" width="810" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="100" align="center"><?php echo date("d/m/Y G:i", strtotime($dt_cad));?></td>
                                    <td align="left"><strong><?php echo $ds_msg; ?></strong></td>
                                    <td width="140" align="left"><?php echo $ds_nome; ?></td>
                                    <td width="130" align="left"><a href="mailto:<?php echo $ds_email; ?>" class="linksmenu"><?php echo $ds_email; ?></a></td>
                                    <td width="35" align="center"><strong><?php echo $st_msg; ?></strong></td>
                                    <td align="center" width="20"><a href="msgs_alt.php?idm=<? echo $id_msg;?>&idf=<? echo $idf;?>&idt=<? echo $idt;?>" title="Alterar mensagem"><img src="img/ico-det.gif" border="0" /></a></td>
                                    <td align="center" width="20"><a href="msgs_sta.php?pg=<?php echo $pagina; ?>&idt=<? echo $idt;?>&idf=<?php echo $idf; ?>&idm=<?php echo $id_msg; ?>&st=<?php echo $st_msg; ?>" title="Alterar Status"><img src="img/ico_check.gif" border="0" /></a></td>
                                    <td align="center" width="20"><a href="#" title="Deletar Mensagem" onclick="confirma(<? echo $id_msg;?>);"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
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
                        $consulta = "select count(*) from msgs, cadastros where NR_SEQ_CADASTRO_MESO = NR_SEQ_CADASTRO_CASO and NR_SEQ_TOPICO_MESO = $idt";
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

                         <form action="msgs_inc.php" method="post">
                         <input name="idt" type="hidden" value="<?php echo $idt; ?>" />
                         <input name="idf" type="hidden" value="<?php echo $idf; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_noticia">
                                       Mensagem:<br />
                                       <textarea name="msg" cols="30" rows="10" class="form02" style="height:100px;"></textarea>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Postar Mensagem" />
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

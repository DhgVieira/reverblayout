<?php
include 'auth.php';
include 'lib.php';
$status = request("st");
$PHP_SELF = "compras.php";
if (!$status) $status = "A";
$pagina = request("pagina");
?>
<? include 'topo.php'; ?>
<script language="javascript">
function confirma(idcomp) {
	var confirma = confirm("Confirma a Exclusao dessa compra e seus itens?\nEsta operacao nao podera ser revertida.")
	if ( confirma ){
		document.location.href='compras_del.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&idc='+idcomp;
	} else {
		return false
	} 
}
</script>
<script language="JavaScript" src="calendar1.js"></script>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td>
                	<ul id="titulos_abas">
                    	<?php
						if ($status == "A") {
							$tit_page = "Compras em Aberto";
							echo "<li id='menu1' class='abaativa'>Compras em Aberto</li>";
						}else{
							echo "<li id='menu1' class='abainativa' onMouseOver='trataMouseAba(this);' onClick=\"javascript:document.location.href='compras.php?st=A'\">Compras em Aberto</li>";
						}
						if ($status == "P") {
							$tit_page = "Compras Pagas";
							echo "<li id='menu2' class='abaativa'>Compras Pagas</li>";
						}else{
							echo "<li id='menu2' class='abainativa' onMouseOver='trataMouseAba(this);' onClick=\"javascript:document.location.href='compras.php?st=P'\">Compras Pagas</li>";
						}
						if ($status == "V") {
							$tit_page = "Compras Enviadas";
							echo "<li id='menu2' class='abaativa'>Compras Enviadas</li>";
						}else{
							echo "<li id='menu2' class='abainativa' onMouseOver='trataMouseAba(this);' onClick=\"javascript:document.location.href='compras.php?st=V'\">Compras Enviadas</li>";
						}
						if ($status == "E") {
							$tit_page = "Compras Entregues";
							echo "<li id='menu2' class='abaativa'>Compras Entregues</li>";
						}else{
							echo "<li id='menu2' class='abainativa' onMouseOver='trataMouseAba(this);' onClick=\"javascript:document.location.href='compras.php?st=E'\">Compras Entregues</li>";
						}
						if ($status == "C") {
							$tit_page = "Compras Canceladas";
							echo "<li id='menu3' class='abaativa'>Compras Canceladas</li>";
						}else{
							echo "<li id='menu3' class='abainativa' onMouseOver='trataMouseAba(this);' onClick=\"javascript:document.location.href='compras.php?st=C'\">Compras Canceladas</li>";
						}
						?>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr>
                	<td bgcolor="#FFFFFF">
                    	<?php 
						$dataini = request("dataini");
						$datafim = request("datafim");
						?>
                    	<table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#CCCCCC">
                           <tr><form action="compras.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>" method="post" name="form1">
                                <td><input type="Button" value="Gerar Etiquetas" onClick="document.frmEtiq.submit();" class="form00" style="width:120px;height:20px;"></td>
                                <td height="20" align="right" valign="middle">
                                    <strong>Data Inicial: </strong><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" />
                                    <a href="javascript:cal1.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a>
                                    <strong>Data Final: </strong><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" />
                                    <a href="javascript:cal2.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a>
                                    &nbsp;&nbsp;<input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />&nbsp;&nbsp;
                                </td>
                                </form>
                                <script language="JavaScript">
								<!--
								var cal1 = new calendar1(document.forms['form1'].elements['dataini']);
								cal1.year_scroll = false;
								cal1.time_comp = true;
								
								var cal2 = new calendar1(document.forms['form1'].elements['datafim']);
								cal2.year_scroll = false;
								cal2.time_comp = true;
								-->
								</script>
                            </tr>
                           </table>
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#CCCCCC">
                        <form action="compras_etiquetas.php" method="post" name="frmEtiq" id="frmEtiq">
                            <tr>
                            	<td align="center" width="15">&nbsp;</td>
                                <td align="center" width="60"><strong>NRO</strong></td>
                                <td align="center" width="145"><strong>Data Compra</strong></td>
                                <td align="left"><strong>Nome</strong></td>
                                <td align="left" width="150"><strong>E-mail</strong></td>
                                <td align="center" width="100"><strong>Telefone</strong></td>
                                <td align="center" width="100"><strong>Forma Pgto.</strong></td>
                                <td align="center" width="120"><strong>Valor Total</strong></td>
                                <td align="center" width="30"><strong>Parc</strong></td>
                                <td align="center" width="30"><strong>ST</strong></td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                            </tr>
                        </table>
                    <ul class="compras">
						<?
						  $num_por_pagina = 40;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_COMPRA_COSO, DT_COMPRA_COSO, DS_FORMAPGTO_COSO, VL_TOTAL_COSO, DS_NOME_CASO, DS_EMAIL_CASO, DS_DDDFONE_CASO,
						  				 DS_FONE_CASO, NR_SEQ_CADASTRO_COSO, NR_PARCELAS_COSO from compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND
										 ST_COMPRA_COSO = '$status' ";
						  if ($dataini) {
						  	if (!$datafim) $datafim = date("d/m/Y")." 23:59:59";
							$sql .= " and DT_COMPRA_COSO between STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') and STR_TO_DATE('$datafim','%d/%m/%Y %H:%i:%s') ";
						  }
						  $sql .= " ORDER BY DT_COMPRA_COSO desc LIMIT $primeiro_registro, $num_por_pagina";
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
							$x = 0;
							$totger = 0;
						  	while($row = mysql_fetch_row($st)) {
							 $id_compra	   = $row[0];
					         $dt_compra	   = $row[1];
							 $formapgto	   = $row[2];
							 $valor		   = $row[3];
							 $nome		   = $row[4];
							 $email		   = $row[5];
							 $dddfone	   = $row[6];
							 $fone		   = $row[7];
							 $idcli		   = $row[8];
							 $parcelas	   = $row[9];
							 
							 $totger += $valor;
							 
							 if ($x == 0) {
							 	$bg = "#FFFFFF";
								$x = 1;
							 }else{
							 	$bg = "#ECECFF";
								$x = 0;
							 }
							 
							 
							?>
							<table border="0" width="100%" cellpadding="0" cellspacing="0" height="30" bgcolor="<?php echo $bg; ?>">
                                <tr>
                                	<td align="center" width="10"><input name="etiq[]" type="checkbox" value="<?php echo $id_compra; ?>" /></td>
                                    <td align="center" width="60"><strong><?php echo $id_compra; ?></strong></td>
                                    <td align="center" width="145" nowrap="nowrap"><?php echo date("d/m/Y G:i", strtotime($dt_compra)); ?></td>
                                    <td align="left"><strong><?php echo $nome; ?></strong></td>
                                    <td align="left" width="150" nowrap="nowrap"><a href="mailto:<?php echo $email; ?>" class="linksmenu"><?php echo $email; ?></a></td>
                                    <td align="center" width="100" nowrap="nowrap"><?php echo $dddfone . " " . $fone; ?></td>
                                    <td align="center" width="100" nowrap="nowrap"><?php echo $formapgto; ?></td>
                                    <td align="center" width="120" nowrap="nowrap"><strong>R$ <?php echo number_format($valor,2,",","."); ?></strong></td>
                                    <td align="center" width="30"><strong><?php echo $parcelas; ?></strong></td>
                                    <td align="center" width="30"><strong><?php echo $status; ?></strong></td>
                                    <td align="center" width="27"><a href="compras_ver.php?idcli=<? echo $idcli;?>&idc=<? echo $id_compra;?>" id="iframe" title="::  :: width: 640, height: 470" class="lightview"><img src="img/ico-det.gif" width="16" height="16" border="0" alt="Ver Detalhamento" /></a></td>
                                    <?php if ($status != "A") {?>
                                    <td align="center" width="27"><a href="compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=A&idgrp=<? echo $id_compra;?>" title="Re-Abrir Compra"><img src="img/ico_alerta.gif" width="16" height="16" border="0" /></a></td>
                                    <?php }?>
                                    <?php if ($status != "P") {?>
                                    <td align="center" width="27"><a href="compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=P&idgrp=<? echo $id_compra;?>" title="Confirmar Pagamento"><img src="img/ico_check.gif" width="16" height="16" border="0" /></a></td>
                                    <?php }?>
                                    <?php if ($status != "V") {?>
                                    <td align="center" width="27"><a href="compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=V&idgrp=<? echo $id_compra;?>" title="Compra Enviada"><img src="img/ico_entrega.gif" width="18" height="16" border="0" /></a></td>
                                    <?php }?>
                                    <?php if ($status != "E") {?>
                                    <td align="center" width="27"><a href="compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=E&idgrp=<? echo $id_compra;?>" title="Compra Entregue"><img src="img/ico_cxopen.gif" width="16" height="16" border="0" /></a></td>
                                    <?php }?>
                                    <?php if ($status != "C") {?>
                                    <td align="center" width="27"><a href="compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=C&idgrp=<? echo $id_compra;?>" title="Cancelar Compra"><img src="img/ico_cancel.gif" width="16" height="16" border="0" /></a></td>
                                    <?php }?>
                                    <td align="center" width="27"><a href="#" title="Deletar Compra" onclick="confirma(<? echo $id_compra;?>);"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                </tr>
                        	</table>
							<?
							}
							?>
                            <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#CCCCCC">
                            <tr>
                                <td align="center" width="60">&nbsp;</td>
                                <td align="center" width="145">&nbsp;</td>
                                <td align="left">&nbsp;</td>
                                <td align="left" width="150">&nbsp;</td>
                                <td align="center" width="100">&nbsp;</td>
                                <td align="right" width="100"><strong>Total:</strong></td>
                                <td align="center" width="120"><strong>R$ <?php echo number_format($totger,2,",","."); ?></strong></td>
                                <td align="center" width="30">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                            </tr>
                        </table>
                        </form>
                            <?
						  }else{
						  ?>
                          <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#FFFFFF">
                            <tr>
                                <td align="center" height="80">Nenhum registro encontrado!</td>
                            </tr>
                        </table>
                          <?
						  }
						?>
                        
                      </ul>
                      <?php if ($mostrapag) {?>
                      <ul class="paginacao2">
						<?
                        $consulta = "SELECT COUNT(*) from compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND ST_COMPRA_COSO = '$status'";
                        list($total_usuarios) = mysql_fetch_array(mysql_query($consulta,$con));
                        
                        $total_paginas = $total_usuarios/$num_por_pagina;
                        $prev = $pagina - 1;
                        $next = $pagina + 1;
                        if ($pagina > 1) {
                        $prev_link = "<li><a href=\"$PHP_SELF?st=$status&pagina=$prev\">Anterior</a></li>";
                        } else { 
                        $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas > $pagina) {
                        $next_link = "<li><a href=\"$PHP_SELF?st=$status&pagina=$next\">Proxima</a></li>";
                        } else {
                        $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas = ceil($total_paginas);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas; $x++) {
                          if ($x==$pagina) { 
                            $painel .= "<li>[$x]</li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?st=$status&pagina=$x\">[$x]</a></li>";
                          }
                        }
                        echo "$prev_link";
                        echo "$painel";
                        echo "$next_link";
						
						 mysql_close($con);
                        ?>                
                    </ul> <!-- /paginacao -->
                    <?php } ?>
        			</td>
            	</tr>
        		</table>
                 <br>
                </td>
            </tr>
        </table>
<? include 'rodape.php'; ?>
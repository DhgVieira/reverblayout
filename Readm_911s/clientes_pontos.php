<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$idc = request("idc");
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idp) {
	var confirma = confirm("Confirma a Exclusão dos pontos?")
	if ( confirma ){
		document.location.href='clientes_pontos_del.php?idp='+idp+'&idc=<?php echo $idc ?>';
	} else {
		return false
	} 
}
</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Clientes</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='clientes.php?pagina=<?php echo $pagina ?>';">Clientes Cadastrados</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Pontos</li>
                      <li id="abaAdic" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Creditar Pontos</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    
                    <div id="Criar">
                        <div style="margin:0 0 0 40px; min-height:300px">
                            <h2 style="margin:0 0 20px 0; padding:5px;float:left;clear:both;"><?php echo PegaNome($idc) ?></h2>
                                <?php
                                $sql = "SELECT NR_SEQ_PONTOS_PORC, NR_SEQ_REFERENCIA_PORC, NR_SEQ_COMPRA_PORC, NR_QTDE_PORC, DT_INCLUSAO_PORC, ST_PONTOS_PORC,
										NR_SEQ_COMPRAUTIL_PORC FROM pontos WHERE NR_SEQ_CADASTRO_PORC = $idc ORDER BY DT_INCLUSAO_PORC";
                                $st = mysql_query($sql);
                                
                                if (mysql_num_rows($st) > 0) {
									?>
                                    <ul class="noticias" style="float:left; clear:both;">
                                    <li>
                                    <table width="800">
                                    	<tr>
                                        	<td width="100" align="center"><strong>Data</strong></td>
                                            <td width="50" align="center"><strong>Pontos</strong></td>
                                            <td width="300"><strong>Referente</strong></td>
                                            <td width="100"><strong>Status</strong></td>
                                            <td width="100"><strong>Compra</strong></td>
                                            <td width="150"><strong>Funções</strong></td>
                                        </tr>
                                    </table>
                                    </li>
                                    <?php
									$total = 0;
									$totalutil = 0;
									$totaldisp = 0;
									while($row = mysql_fetch_row($st)) {
										$idponto	= $row[0];
										$nrrefer	= $row[1];
										$nrseqcom	= $row[2];
										$nrpontos	= $row[3];
										$datainc	= $row[4];
										$stpontos	= $row[5];
										$comprauti	= $row[6];
										
										$total += $nrpontos;
									?>
									<li>
                                    <table width="800">
                                    	<tr>
                                        	<td width="100" align="center"><?php echo date("d/m/Y G:i", strtotime($datainc));?></td>
                                            <td width="50" align="center"><strong><?php echo $nrpontos ?></strong></td>
                                            <td width="300" align="left">
                                            	<?php
                                                switch($nrrefer){
													case 1:
														echo "Compra realizada: <a href=\"compras_ver.php?idcli=$idc&idc=$nrseqcom\" id=\"iframe\" title=\"::  :: width: 640, height: 470\" class=\"lightview\">$nrseqcom</a>";
														break;
													case 2:
														echo "Foto liberada no People";
														break;
												}
												?>
                                            </td>
                                            <td width="100" align="left">
                                            	<?php
                                                switch($stpontos){
													case "U":
														echo "Utilizado";
														$totalutil += $nrpontos;
														break;
													case "C":
														echo "Cancelado";
														break;
													case "E":
														echo "Disponível";
														$totaldisp += $nrpontos;
														break;
												}
												?>
                                            </td>
                                            <td width="100" align="left"><a href="compras_ver.php?idcli=<? echo $idc;?>&idc=<? echo $comprauti;?>" id="iframe" title="::  :: width: 640, height: 470" class="lightview"><?php echo $comprauti ?></a></td>
                                            <td width="150" align="left">
                                                <a href="clientes_pontos_alt.php?idp=<? echo $idponto;?>&idc=<?php echo $idc ?>" title="Alterar Pontos"><img src="img/ico-det.gif" width="16" height="16" border="0" alt="Alterar Pontos" /></a>
                                                &nbsp;&nbsp;
                                                <a href="#" title="Deletar Pontos" onclick="confirma(<?php echo $idponto;?>);"><img src="img/cancel.png" width="16" height="16" border="0" alt="Deletar Pontos" /></a>
                                            </td>
                                        </tr>
                                    </table>
                                    </li>
									<?php
									}
									?>
                                    <li>
                                    <table width="800">
                                    	<tr><td colspan="5">&nbsp;</td></tr>
                                        <tr>
                                        	<td width="100" align="right"><strong>Total Geral:</strong></td>
                                            <td width="50" align="center"><strong><?php echo $total ?></strong></td>
                                            <td width="300">&nbsp;</td>
                                            <td width="100">&nbsp;</td>
                                            <td width="100">&nbsp;</td>
                                            <td width="150">&nbsp;</td>
                                        </tr>
                                    </table>
                                    <table width="800">
                                    	<tr>
                                        	<td width="100" align="right"><strong>Total Utilizado:</strong></td>
                                            <td width="50" align="center"><strong><?php echo $totalutil ?></strong></td>
                                            <td width="300">&nbsp;</td>
                                            <td width="100">&nbsp;</td>
                                            <td width="100">&nbsp;</td>
                                            <td width="150">&nbsp;</td>
                                        </tr>
                                    </table>
                                    <table width="800">
                                    	<tr>
                                        	<td width="100" align="right"><strong>Total Disponível:</strong></td>
                                            <td width="50" align="center"><strong><?php echo $totaldisp ?></strong></td>
                                            <td width="300">&nbsp;</td>
                                            <td width="100">&nbsp;</td>
                                            <td width="100">&nbsp;</td>
                                            <td width="150">&nbsp;</td>
                                        </tr>
                                    </table>
                                    </li>
                                    </ul>
                                    <?php
                                }else{
                                    echo "<p>&nbsp;</p><p><strong>Este cliente não possui pontos</strong></p>";
                                }
                                ?>
                        </div>
                    </div> <!-- /criar -->
                    
                    <div id="Adicionar">
                    	<div style="margin:0 0 0 40px; min-height:300px">
                            <h2 style="margin:0 0 20px 0; padding:5px;float:left;clear:both;"><?php echo PegaNome($idc) ?></h2>
                            
                            <form action="clientes_pontos_inc.php" method="post" name="myform">
                         	<input name="idc" type="hidden" value="<?php echo $idc; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="Pontos">
                                       Quantidade de Pontos:<br />
                                       <input class="form02" style="width:80px;" type="text" name="pontos" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="refere">
                                       Referente:<br />
                                       <select name="refere">
                                       		<option value="1">Compra Realizada</option>
                                            <option value="2">Foto liberada no People</option>
                                        </select>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="compra">
                                       Compra (ID - não obrigatório):<br />
                                       <input class="form02" style="width:80px;" type="text" name="compra" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="compruti">
                                       Compra Utilizado (ID - não obrigatório):<br />
                                       <input class="form02" style="width:80px;" type="text" name="compruti" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="status">
                                       Status dos Pontos:<br />
                                       <select name="status">
                                       		<option value="E">Disponível</option>
                                            <option value="U">Utilizado</option>
                                            <option value="C">Cancelado</option>
                                        </select>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Incluir Pontos" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                        </div>
                    </div>

                    <script>
                      defineAba("abaCriar","Criar");
					  defineAba("abaAdic","Adicionar");
					  defineAbaAtiva("abaCriar");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<? include 'rodape.php'; ?>
<?php mysql_close($con);?>

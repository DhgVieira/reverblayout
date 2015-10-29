<?php
include 'auth.php';
include 'lib.php';

$dataini = request("dataini");
$datafim = request("datafim");
$lojapesq = request("lojapesq");

if (!$dataini) $dataini = "01/".date("m/Y");
if (!$datafim) $datafim = date("d/m/Y");
if (!$lojapesq) $lojapesq = $SS_loja;

//montacombolojas
$sql = "select NR_SEQ_LOJA_LJRC, DS_LOJA_LJRC from lojas order by NR_SEQ_LOJA_LJRC";
$st = mysql_query($sql);
$str_lojas = "";
if (mysql_num_rows($st) > 0) {
  while($row = mysql_fetch_row($st)) {
   $id_loja	   = $row[0];
   $ds_loja	   = utf8_encode($row[1]);
   $checa = "";
   if ($lojapesq == $id_loja) $checa = " checked";
   $str_lojas .= "<option value=\"$id_loja\"$checa>$ds_loja</option>\n";
  }
}

?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idc, tipo) {
	var confirma = confirm("Confirma a Exclusão desse lançamento? Essa operação não poderá ser revertida.")
	if ( confirma ){
		document.location.href='contas_del.php?idc='+idc+'&tp='+tipo;
	} else {
		return false
	} 
}

function jNumerico(e)
	{
		if(document.all) // Internet Explorer
			var tecla = event.keyCode;
			else if(document.layers) // Nestcape
			var tecla = e.which;
			
			if(tecla > 47 && tecla < 58) // numeros de 0 a 9
			return true;
		else
		{
			if (tecla != 8 && tecla != 44) // backspace
			return false;
			else
			return true;
		}
	}
//***** PARA ALTERAR O TIPO DE CONTA
function confirma_liq(id_conta, ds_tipo,tipo) {
	if (ds_tipo == 'D'){
		var confirma = confirm("Tem certeza que voce deseja mover esta conta para a CONTAS PAGAS?")
	}
	else if (ds_tipo == 'C'){
		var confirma = confirm("Tem certeza que voce deseja mover esta conta para a CONTAS RECEBIDAS?")
	}
	else if (ds_tipo == 'P'){
		var confirma = confirm("Tem certeza que voce deseja mover esta conta para a CONTAS A PAGAR?")
	}
	else if (ds_tipo == 'R'){
		var confirma = confirm("Tem certeza que voce deseja mover esta conta para a CONTAS A RECEBER?")
	}
	if ( confirma ){
		document.location.href='contas_liq.php?&id_conta='+id_conta+'&ds_tipo='+ds_tipo+'&tipo='+tipo ;
	} else {
		return false
	} 
}
//***** 
</script>

<script type='text/javascript' src="scripts/autocomplete/jquery.tools.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/dateskin.css"/>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Contas</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li style="width: 125px;" id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_apagar.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">A PAGAR</li>
                      <li style="width: 125px;" id="abaVerR" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_areceber.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">A RECEBER</li>
                      <li style="width: 125px;" id="abaVerP" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_pagas.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">CONTAS PAGAS</li>
                      <li style="width: 140px;" id="abaVerRL" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">CONTAS RECEBIDAS</li>
                      <li style="width: 125px;" id="abaVerU" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_unificado.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">UNIFICADO</li>
                      <li style="width: 125px;" id="abaVerC" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_categorias.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">CATEGORIAS</li>
                      <li style="width: 125px;" id="abaVerS" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_subcategorias.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">SUBCATEGORIAS</li>
                      <li style="width: 125px;" id="abaVerD" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_descricao.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">FORNECEDORES</li>
                      <li style="width: 140px;" id="abaVerN" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_novo.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">NOVO LANÇAMENTO</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas">
<!-- //***** CONTAS RECEBIDAS                 -->
                   <div id="liqreceb">
                   <table width="885">
                   <tr><form action="contas_recebidas.php" method="post" name="formrecebidas">
                   <input name="tipo" type="hidden" value="R" />
                        <td height="20" align="right" valign="middle">
                        	<strong>Loja: <select name="lojapesq"><?php echo $str_lojas; ?></select></strong>
                            <strong>Data Inicial: </strong><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="date" name="dataini" value="<?php echo $dataini; ?>" />
                            <strong>Data Final: </strong><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="date" name="datafim" value="<?php echo $datafim; ?>" />
                            <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                        </td>
                        </form>
                        <script language="JavaScript">
						   document.form1.lojapesq.value = "<?php echo $lojapesq; ?>";
						</script>
                    </tr>
                   </table>
                   <form action="contas_dup_all.php" method="post">
                   <input name="tp" type="hidden" value="R" />
                	<ul class="compras">
                    <li>
                    <table border="0" cellpadding="0" cellspacing="2" height="20">
                            <tr>
                                <td width="17">&nbsp;</td>
                                <td align="center" width="102"><strong style="color:#993300;">Recebida</strong></td>
                                <td align="center" width="107"><strong style="color:#993300;">Data Lançamento</strong></td>
                                <!--<td align="left" width="90"><strong style="color:#993300;">Loja</strong></td>-->
                                <td align="left" width="174"><strong style="color:#993300;">Descrição</strong></td>
                                <td align="left" width="110"><strong style="color:#993300;">Categoria</strong></td>
                                <td align="left" width="140"><strong style="color:#993300;">SubCategoria</strong></td>
                                <td align="left" width="150"><strong style="color:#993300;">Descrição</strong></td>
                                <td align="right" width="100"><strong style="color:#993300;">Valor</strong></td>
                                <td align="center" width="20"><strong style="color:#993300;">Tp</strong></td>
                                <td align="center" width="25">&nbsp;</td>
                                <td align="center" width="25">&nbsp;</td>
                                <td align="center" width="25">&nbsp;</td>
                            </tr>
                        </table>
                    </li>
						<?php
						  $sql = "select NR_SEQ_CONTA_CORC, NR_SEQ_CATCONTA_CORC, DS_DESCRICAO_CORC, VL_CONTA_CORC, DT_CADASTRO_CORC, DT_TIPO_CORC, DS_TIPO_CORC,
						  				DS_CATEGORIA_CCRC, DS_LOJA_LJRC, NR_SEQ_SUBCATCONTA_CORC, NR_FORMA_PGTO_CORC, NR_SEQ_DESCRICAO_CORC
                                           from contas, contas_categorias, lojas WHERE NR_SEQ_CATCONTA_CORC = NR_SEQ_CATCONTA_CCRC AND
										NR_SEQ_LOJA_CORC = NR_SEQ_LOJA_LJRC and DS_TIPO_CORC = 'R' AND NR_SEQ_LOJA_CORC = $lojapesq AND
										DT_VCTO_CORC between STR_TO_DATE('$dataini','%d/%m/%Y') and STR_TO_DATE('$datafim','%d/%m/%Y')";
						  $sql .= " order by DT_VCTO_CORC";

						  $st = mysql_query($sql);

						  if (mysql_num_rows($st) > 0) {
							$total = 0;
						  	while($row = mysql_fetch_row($st)) {
							 $id_conta	   = $row[0];
					         $nr_categ	   = $row[1];
							 $ds_conta	   = $row[2];
							 $vl_conta	   = $row[3];
							 $dt_lanca	   = $row[4];
							 $dt_vcto	   = $row[5];
							 $ds_tipo	   = $row[6];
							 $ds_categ	   = $row[7];
							 $ds_loja	   = $row[8];
							 $nrseqsub	   = $row[9];
                             $forma 	   = $row[10];
                             $nrseqdes	   = $row[11];
                             
                             switch($forma){
                                case 0:
                                    $forma = "-";
                                    break;
                                case 1:
                                    $forma = "Boleto";
                                    break;
                                case 2:
                                    $forma = "Cheque";
                                    break;
                                case 3:
                                    $forma = "Dinheiro";
                                    break;
                                case 4:
                                    $forma = "Cartão Visa";
                                    break;
                                case 5:
                                    $forma = "Cartão Master";
                                    break;
                                case 6:
                                    $forma = "Transferência";
                                    break;
                                case 7:
                                    $forma = "Depósito Cheque";
                                    break;
                                case 8:
                                    $forma = "Depósito Dinheiro";
                                    break;
                                case 9:
                                    $forma = "Débito Automático";
                                    break;
                                
                             }
							 
							 $sqlsub = "SELECT DS_SUBCATEGORIA_SCRC FROM contas_subcategorias where NR_SEQ_SUBCATCONTA_SCRC = $nrseqsub";
							 $stsub = mysql_query($sqlsub);
							 if (mysql_num_rows($stsub) > 0) {
							 	$rowsub = mysql_fetch_row($stsub);
							 	$dssubcateg = $rowsub[0];
							 }else{
							 	$dssubcateg = " - ";
							 }
                             
                             $sqlsub = "SELECT DS_SUBCATEGORIA_DCRC FROM contas_descricao where NR_SEQ_SUBCATCONTA_DCRC = $nrseqdes";
							 $stsub = mysql_query($sqlsub);
							 if (mysql_num_rows($stsub) > 0) {
							 	$rowsub = mysql_fetch_row($stsub);
							 	$dsdesc = $rowsub[0];
							 }else{
							 	$dsdesc = " - ";
							 }
							 
							 $total += $vl_conta;
							?>
							<li>
                            <table border="0" width="1110" cellpadding="0" cellspacing="2" height="28">
                                <tr>
                                    <td align="center" width="24"><input type="checkbox" name="contas[]" value="<?php echo $id_conta ?>" /></td>
                                    <td align="center" width="101"><strong><?php echo date("d/m/Y", strtotime($dt_vcto));?></strong></td>
                                    <td align="center" width="109"><?php echo date("d/m/Y G:i", strtotime($dt_lanca));?></td>
                                    <!--<td align="left" width="89"><?php echo $ds_loja;?></td>-->
                                    <td width="194" align="left"><strong><?php echo $ds_conta; ?></strong></td>
                                    <td align="left" width="132"><?php echo $ds_categ; ?></td>
                                    <td align="left" width="163"><?php echo $dssubcateg; ?></td>
                                    <td align="left" width="150"><?php echo $dsdesc; ?></td>
                                    <td align="right" width="99"><strong>R$ <?php echo number_format($vl_conta,2,",","."); ?></strong></td>
                                    <td align="center" width="19"><strong style="color:#FF0000;"><?php echo $ds_tipo; ?></strong></td>
                                    <td align="center" width="80"><?php echo $forma; ?></td>
                                    <td align="center" width="25"><a href="#" onclick="confirma(<?php echo $id_conta; ?>,'R');" title="Deletar Conta"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="contas_alt.php?idc=<?php echo $id_conta;?>" title="Alterar Conta"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="#" onclick="confirma_liq(<?php echo $id_conta;?>,'R','R');" title="Mover para Contas Pagas"><img src="img/ico_classicsp.gif" border="0" /></a></td>
                                    <td align="center" width="25"><a href="contas_dup.php?idc=<?php echo $id_conta;?>&tp=R" title="Jogar para o mês seguinte"><img src="img/ico_mais.gif" width="16" height="16" border="0" alt="Jogar para o mês seguinte" /></a></td>
                                </tr>
                            </table>
                        </li>
							<?php
							}
							?>
                            <li>
                            <table border="0" width="1004" cellpadding="0" cellspacing="2" height="20">
                                <tr>
                                    <td align="left" width="203" colspan="2"><input type="submit" value="  Copiar p/ mês seguinte  " /></td>
                                    <td width="411" align="left">&nbsp;</td>
                                    <td align="right" width="171"><strong style="color:#993300;">Total:</strong></td>
                                    <td align="right" width="107"><strong style="color:#993300;">R$ <?php echo number_format($total,2,",","."); ?></strong></td>
                                    <td align="center" width="46">&nbsp;</td>
                                    <td align="center" width="26">&nbsp;</td>
                                    <td align="center" width="22">&nbsp;</td>


                                </tr>
                            </table>
                            </li>
                        <?php
						  }
						?>
                        </form>
                      </ul>
                     
                  	</div>
<!-- //***** FIM CONTAS RECEBIDAS                    -->                    

                    <script>
					  defineAba("abaVerRL","liqreceb");
					  <?php
					  	echo "defineAbaAtiva(\"abaVerRL\");";
					  ?>
                    </script>
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<script>
   $(":date").dateinput({ format: 'dd/mm/yyyy' });
</script>
<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>
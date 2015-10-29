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
function confirma_cat(idc) {
	var confirma = confirm("Confirma a Exclusão dessa Categoria?")
	if ( confirma ){
		document.location.href='contas_cat_del.php?idc='+idc;
	} else {
		return false
	} 
}

function confirma_subcat(idc) {
	var confirma = confirm("Confirma a Exclusão dessa Subcategoria?")
	if ( confirma ){
		document.location.href='contas_subcat_del.php?idc='+idc;
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
<script type='text/javascript' src='scripts/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='scripts/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='scripts/autocomplete/thickbox-compressed.js'></script>
<script type='text/javascript' src='scripts/autocomplete/jquery.autocomplete.js'></script>
<script type='text/javascript' src='scripts/autocomplete/jquery.functions_contas.js'></script>
<script type='text/javascript' src="scripts/autocomplete/jquery.tools.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/dateskin.css"/>
<link rel="stylesheet" type="text/css" href="scripts/autocomplete/jquery.autocomplete.css" />

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
                      <li style="width: 125px;" id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">A PAGAR</li>
                      <li style="width: 125px;" id="abaVerR" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">A RECEBER</li>
                      <li style="width: 125px;" id="abaVerP" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">CONTAS PAGAS</li>
                      <li style="width: 140px;" id="abaVerRL" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">CONTAS RECEBIDAS</li>
                      <li style="width: 125px;" id="abaVerU" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">UNIFICADO</li>
                      <li style="width: 125px;" id="abaVerC" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">CATEGORIAS</li>
                      <li style="width: 125px;" id="abaVerS" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">SUBCATEGORIAS</li>
                      <li style="width: 140px;" id="abaVerN" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">NOVO LANÇAMENTO</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas">
                   <div id="pagar">
                   <table width="885">
                   <tr><form action="contas.php" method="post" name="form1">
                   <input name="tipo" type="hidden" value="D" />
                        <td height="20" align="right" valign="middle">
                        	<strong>Loja: <select name="lojapesq"><?php echo $str_lojas; ?></select></strong>
                            <strong>Data Inicial: </strong><input style="width:100px;height:14px;text-align:center;" type="date" name="dataini" value="<?php echo $dataini; ?>" />
                            <strong>Data Final: </strong><input style="width:100px;height:14px;text-align:center;" type="date" name="datafim" value="<?php echo $datafim; ?>" />
                            <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                        </td>
                        </form>
                        
                        <script language="JavaScript">
						   document.form1.lojapesq.value = "<?php echo $lojapesq; ?>";
						</script>
                    </tr>
                   </table>
                   <form action="contas_dup_all.php" method="post">
                	<ul class="compras">
                    <li>
                    <table border="0" cellpadding="0" cellspacing="2" height="20">
                            <tr>
                                <td width="17">&nbsp;</td>
                                <td align="center" width="102"><strong style="color:#993300;">Vencimento</strong></td>
                                <td align="center" width="107"><strong style="color:#993300;">Data Lançamento</strong></td>
                                <td align="left" width="90"><strong style="color:#993300;">Loja</strong></td>
                                <td align="left" width="184"><strong style="color:#993300;">Descrição</strong></td>
                                <td align="left" width="130"><strong style="color:#993300;">Categoria</strong></td>
                                <td align="left" width="150"><strong style="color:#993300;">SubCategoria</strong></td>
                                <td align="right" width="100"><strong style="color:#993300;">Valor</strong></td>
                                <td align="center" width="20"><strong style="color:#993300;">Tp</strong></td>
                            </tr>
                        </table>
                    </li>
						<?php
						  $sql = "select NR_SEQ_CONTA_CORC, NR_SEQ_CATCONTA_CORC, DS_DESCRICAO_CORC, VL_CONTA_CORC, DT_CADASTRO_CORC, DT_VCTO_CORC, DS_TIPO_CORC,
						  				DS_CATEGORIA_CCRC, DS_LOJA_LJRC, NR_SEQ_SUBCATCONTA_CORC, NR_FORMA_PGTO_CORC from contas, contas_categorias, lojas WHERE NR_SEQ_CATCONTA_CORC = NR_SEQ_CATCONTA_CCRC AND
										NR_SEQ_LOJA_CORC = NR_SEQ_LOJA_LJRC and DS_TIPO_CORC = 'D' AND NR_SEQ_LOJA_CORC = $lojapesq AND
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
							 
							 $total += $vl_conta;
							?>
							<li>
                            <table border="0" width="1110" cellpadding="0" cellspacing="2" height="20">
                                <tr>
                                    <td align="center" width="24"><input type="checkbox" name="contas[]" value="<?php echo $id_conta ?>" /></td>
                                    <td align="center" width="99"><strong><?php echo date("d/m/Y", strtotime($dt_vcto));?></strong></td>
                                    <td align="center" width="109"><?php echo date("d/m/Y G:i", strtotime($dt_lanca));?></td>
                                    <td align="left" width="92"><?php echo $ds_loja;?></td>
                                    <td width="194" align="left"><strong><?php echo $ds_conta; ?></strong></td>
                                    <td align="left" width="129"><?php echo $ds_categ; ?></td>
                                    <td align="left" width="166"><?php echo $dssubcateg; ?></td>
                                    <td align="right" width="94"><strong>R$ <?php echo number_format($vl_conta,2,",","."); ?></strong></td>
                                    <td align="center" width="23"><strong style="color:#FF0000;"><?php echo $ds_tipo; ?></strong></td>
                                    <td align="center" width="80"><?php echo $forma; ?></td>
                                    <td align="center" width="25"><a href="#" onclick="confirma(<?php echo $id_conta; ?>,'D');" title="Deletar Conta"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="contas_alt.php?idc=<?php echo $id_conta;?>" title="Alterar Conta"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="#" onclick="confirma_liq(<?php echo $id_conta;?>,'D','D');" title="Mover para Contas Pagas"><img src="img/ico_classicsp.gif" border="0" /></a></td>
                                    <td align="center" width="25"><a href="contas_dup.php?idc=<?php echo $id_conta;?>&tp=D" title="Jogar para o mês seguinte"><img src="img/ico_mais.gif" width="16" height="16" border="0" alt="Jogar para o mês seguinte" /></a></td>
                                </tr>
                            </table>
                            </li>
							<?php
							}
							?>
                            <li>
                            <table border="0" width="975" cellpadding="0" cellspacing="2" height="20">
                                <tr>
                                    <td align="left" width="210" colspan="2"><input type="submit" value="  Copiar p/ mês seguinte  " /></td>
                                    <td align="left">&nbsp;</td>
                                    <td align="right" width="150"><strong style="color:#993300;">Total:</strong></td>
                                    <td align="right" width="130"><strong style="color:#993300;">R$ <?php echo number_format($total,2,",","."); ?></strong></td>
                                    <td align="center" width="20">&nbsp;</td>
                                    <td align="center" width="25">&nbsp;</td>
                                    <td align="center" width="25">&nbsp;</td>
                                </tr>
                            </table>
                            </li>
                        <?php
						  }
						?>
                      </ul>
                     </form>
                  	</div>

					<div id="receber">
                    <table width="885">
                  <tr><form action="contas.php" method="post" name="formpesq2">
                   <input name="tipo" type="hidden" value="C" />
                        <td height="20" align="right" valign="middle">
                        	<strong>Loja: <select name="lojapesq"><?php echo $str_lojas; ?></select></strong>
                            <strong>Data Inicial: </strong><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" />
                            <strong>Data Final: </strong><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" />
                            <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                        </td>
                        <script language="JavaScript">
						   document.formpesq2.lojapesq.value = "<?php echo $lojapesq; ?>";
						</script>
                        </form>
                    </tr>
                   </table>
                   <form action="contas_dup_all.php" method="post">
                	<ul class="compras">
                    <li>
                    <table border="0" cellpadding="0" cellspacing="2" height="20">
                            <tr>
                                <td width="17">&nbsp;</td>
                                <td align="center" width="102"><strong style="color:#993300;">Vencimento</strong></td>
                                <td align="center" width="107"><strong style="color:#993300;">Data Lançamento</strong></td>
                                <td align="left" width="90"><strong style="color:#993300;">Loja</strong></td>
                                <td align="left" width="194"><strong style="color:#993300;">Descrição</strong></td>
                                <td align="left" width="130"><strong style="color:#993300;">Categoria</strong></td>
                                <td align="left" width="162"><strong style="color:#993300;">SubCategoria</strong></td>
                                <td align="right" width="100"><strong style="color:#993300;">Valor</strong></td>
                                <td align="center" width="20"><strong style="color:#993300;">Tp</strong></td>
                            </tr>
                        </table>
                    </li>
						<?php
						  $sql = "select NR_SEQ_CONTA_CORC, NR_SEQ_CATCONTA_CORC, DS_DESCRICAO_CORC, VL_CONTA_CORC, DT_CADASTRO_CORC, DT_VCTO_CORC, DS_TIPO_CORC,
						  				DS_CATEGORIA_CCRC, DS_LOJA_LJRC, NR_SEQ_SUBCATCONTA_CORC, NR_FORMA_PGTO_CORC from contas, contas_categorias, lojas WHERE NR_SEQ_CATCONTA_CORC = NR_SEQ_CATCONTA_CCRC AND
										NR_SEQ_LOJA_CORC = NR_SEQ_LOJA_LJRC and DS_TIPO_CORC = 'C' AND NR_SEQ_LOJA_CORC = $lojapesq AND
										DT_VCTO_CORC between STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') and STR_TO_DATE('$datafim','%d/%m/%Y %H:%i:%s')";
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
							 
							 $total += $vl_conta;
							?>
							<li>
                            <table border="0" width="1110" cellpadding="0" cellspacing="2" height="20">
                                <tr>
                                    <td align="center" width="24"><input type="checkbox" name="contas[]" value="<?php echo $id_conta ?>" /></td>
                                    <td align="center" width="100"><strong><?php echo date("d/m/Y", strtotime($dt_vcto));?></strong></td>
                                    <td align="center" width="110"><?php echo date("d/m/Y G:i", strtotime($dt_lanca));?></td>
                                    <td align="left" width="90"><?php echo $ds_loja;?></td>
                                    <td width="193" align="left"><strong><?php echo $ds_conta; ?></strong></td>
                                    <td align="left" width="132"><?php echo $ds_categ; ?></td>
                                    <td align="left" width="163"><?php echo $dssubcateg; ?></td>
                                    <td align="right" width="97"><strong>R$ <?php echo number_format($vl_conta,2,",","."); ?></strong></td>
                                    <td align="center" width="20"><strong style="color:#FF0000;"><?php echo $ds_tipo; ?></strong></td>
                                    <td align="center" width="80"><?php echo $forma; ?></td>
                                    <td align="center" width="26"><a href="#" onclick="confirma(<?php echo $id_conta; ?>,'C');" title="Deletar Conta"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="contas_alt.php?idc=<?php echo $id_conta;?>" title="Alterar Conta"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="#" onclick="confirma_liq(<?php echo $id_conta;?>,'C','C');" title="Mover para Contas Recebidas"><img src="img/ico_classicsp.gif" border="0" /></a></td>
                                    <td align="center" width="25"><a href="contas_dup.php?idc=<?php echo $id_conta;?>&tp=C" title="Jogar para o mês seguinte"><img src="img/ico_mais.gif" width="16" height="16" border="0" alt="Jogar para o mês seguinte" /></a></td>
                                </tr>
                            </table>
                            </li>
							<?php
							}
							?>
                            <li>
                            <table border="0" width="975" cellpadding="0" cellspacing="2" height="20">
                                <tr>
                                    <td align="left" width="210" colspan="2"><input type="submit" value="  Copiar p/ mês seguinte  " /></td>
                                    <td align="left">&nbsp;</td>
                                    <td align="right" width="150"><strong style="color:#993300;">Total:</strong></td>
                                    <td align="right" width="130"><strong style="color:#993300;">R$ <?php echo number_format($total,2,",","."); ?></strong></td>
                                    <td align="center" width="20">&nbsp;</td>
                                    <td align="center" width="25">&nbsp;</td>
                                    <td align="center" width="25">&nbsp;</td>
                                </tr>
                            </table>
                            </li>
                        <?php
						  }
						?>
                      </ul>
                      </form>
                    </div>
                    
                    <div id="uni">
                    <table width="885">
                       <tr><form action="contas.php" method="post" name="formpesq3">
                   		<input name="tipo" type="hidden" value="U" />
                        <td height="20" align="right" valign="middle">
                        	<strong>Loja: <select name="lojapesq"><?php echo $str_lojas; ?></select></strong>
                            <strong>Data Inicial: </strong><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" />
                            <strong>Data Final: </strong><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" />
                            <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                        </td>
                        <script language="JavaScript">
						   document.formpesq3.lojapesq.value = "<?php echo $lojapesq; ?>";
						</script>
                        </form>
                    </tr>
                       </table>
                       <form action="contas_dup_all.php" method="post">
                        <ul class="compras">
                        <li>
                        <table border="0" cellpadding="0" cellspacing="2" height="20">
                               <tr>
                                <td width="17">&nbsp;</td>
                                <td align="center" width="102"><strong style="color:#993300;">Vencimento/ Liquidada</strong></td>
                                <td align="center" width="107"><strong style="color:#993300;">Data Lançamento</strong></td>
                                <td align="left" width="90"><strong style="color:#993300;">Loja</strong></td>
                                <td align="left" width="194"><strong style="color:#993300;">Descrição</strong></td>
                                <td align="left" width="130"><strong style="color:#993300;">Categoria</strong></td>
                                <td align="left" width="162"><strong style="color:#993300;">SubCategoria</strong></td>
                                <td align="right" width="100"><strong style="color:#993300;">Valor</strong></td>
                                <td align="center" width="20"><strong style="color:#993300;">Tp</strong></td>
                            </tr>
                        </table>
                        </li>
                            <?php
                              $sql = "select NR_SEQ_CONTA_CORC, NR_SEQ_CATCONTA_CORC, DS_DESCRICAO_CORC, VL_CONTA_CORC, DT_CADASTRO_CORC, DT_VCTO_CORC, DS_TIPO_CORC,
						  				DS_CATEGORIA_CCRC, DS_LOJA_LJRC, NR_SEQ_SUBCATCONTA_CORC, DT_TIPO_CORC, NR_FORMA_PGTO_CORC from contas, contas_categorias, lojas WHERE NR_SEQ_CATCONTA_CORC = NR_SEQ_CATCONTA_CCRC AND
										NR_SEQ_LOJA_CORC = NR_SEQ_LOJA_LJRC AND NR_SEQ_LOJA_CORC = $lojapesq AND
										DT_VCTO_CORC between STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') and STR_TO_DATE('$datafim','%d/%m/%Y %H:%i:%s')";
						  	$sql .= " order by DS_TIPO_CORC, DT_VCTO_CORC";
    
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
								 $dt_tipo	   = $row[10];
                                 $forma 	   = $row[11];
                                 
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
                                 
								 if($ds_tipo == "C" ){
	                                 $total += $vl_conta;
									 $cortipo = "#090";
								 }else if ($ds_tipo == "R"){
									 $total += $vl_conta;
									 $cortipo = "#00F";
						 		 }
									else if ($ds_tipo == "D"){
									 $total -= $vl_conta;
									 $cortipo = "#F00";
						 		 }
									else if ($ds_tipo == "P"){
									 $total -= $vl_conta;
									 $cortipo = "#609";
						 		 }
								 
                                ?>
                                <li>
                                <table border="0" width="1080" cellpadding="0" cellspacing="2" height="20">
                                    <tr>
                                        <td align="center" width="24"><input type="checkbox" name="contas[]" value="<?php echo $id_conta ?>" /></td>
                                        <td align="center" width="100"><strong><?php if ($ds_tipo == "C" || $ds_tipo == "D") echo date("d/m/Y", strtotime($dt_vcto)); else echo date("d/m/Y", strtotime($dt_tipo)); ?></strong></td>
                                        <td align="center" width="110"><?php echo date("d/m/Y G:i", strtotime($dt_lanca));?></td>
                                        <td align="left" width="90"><?php echo $ds_loja;?></td>
                                        <td align="left"><strong><?php echo $ds_conta; ?></strong></td>
                                        <td align="left" width="130"><?php echo $ds_categ; ?></td>
                                        <td align="left" width="130"><?php echo $dssubcateg; ?></td>
                                        <td align="right" width="130"><strong>R$ <?php echo number_format($vl_conta,2,",","."); ?></strong></td>
                                        <td align="center" width="20"><strong style="color:<?php echo $cortipo;?>;"><?php echo $ds_tipo; ?></strong></td>
                                        <td align="center" width="80"><?php echo $forma; ?></td>
                                        <td align="center" width="25"><a href="#" onclick="confirma(<?php echo $id_conta; ?>,'U');" title="Deletar Conta"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                        <td align="center" width="25"><a href="contas_alt.php?idc=<?php echo $id_conta;?>" title="Alterar Conta"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a></td>
                                        <td align="center" width="25"><a href="contas_dup.php?idc=<?php echo $id_conta;?>&tp=U" title="Jogar para o mês seguinte"><img src="img/ico_mais.gif" width="16" height="16" border="0" alt="Jogar para o mês seguinte" /></a></td>
                                    </tr>
                                </table>
                                </li>
                                <?php
                                }
                                ?>
                                <li>
                                <table border="0" width="975" cellpadding="0" cellspacing="2" height="20">
                                    <tr>
                                        <td align="left" width="210" colspan="2"><input type="submit" value="  Copiar p/ mês seguinte  " /></td>
                                        <td align="left">&nbsp;</td>
                                        <td align="right" width="150"><strong style="color:#993300;">Saldo:</strong></td>
                                        <td align="right" width="130"><strong style="color:#993300;">R$ <?php echo number_format($total,2,",","."); ?></strong></td>
                                        <td align="center" width="20">&nbsp;</td>
                                        <td align="center" width="25">&nbsp;</td>
                                        <td align="center" width="25">&nbsp;</td>
                                    </tr>
                                </table>
                                </li>
                            <?php
                              }
                            ?>
                      </ul>
                      </form>
                    </div>
                    
                    <div id="categoria">
                        <form action="contas_cat_inc.php" method="post">
                         
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_cat">
                                       Categoria:<br />
                                       <input class="form02" type="text" id="nome_cat" name="nome_cat" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Categoria" />
                                   </li>
                                 </ul>
                 
                         </form>
                        
                          <ul class="noticias">
                          	   <li>
                               <span><strong>Categorias</strong></span>
                               <div>Exc</div>
                               </li>
                            <?php
                              $sql = "select NR_SEQ_CATCONTA_CCRC, DS_CATEGORIA_CCRC from contas_categorias order by DS_CATEGORIA_CCRC";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_cat	   = $row[0];
                                 $nm_cat	   = $row[1];
                                ?>
                                <li>
                                <span><strong><?php echo $nm_cat;?></strong></span>
                                <div>
                                <a href="#" title="deletar categoria" onclick="confirma_cat(<?php echo $id_cat; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                </li>
                                <?php
                                }
                              }
                            ?>
                          </ul>
                    </div>
                    
                    <div id="subcategoria">
                        <form action="contas_subcat_inc.php" method="post">
                         
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_subcat">
                                       Subcategoria:<br />
                                       <input class="form02" type="text" id="nome_subcat" name="nome_subcat" />
                                     </label>
                                   </li>
                                   <li>
                                   	 <label for="">
                                     Categoria:<br />
										<select name="categoria">
											<?php
                                            $sql = "select NR_SEQ_CATCONTA_CCRC, DS_CATEGORIA_CCRC from contas_categorias order by DS_CATEGORIA_CCRC";
                                            $st = mysql_query($sql);
                
                                            if (mysql_num_rows($st) > 0) {
                                              while($row = mysql_fetch_row($st)) {
                                               $id_cate	   = $row[0];
                                               $ds_cate	   = $row[1];
                                            ?>
                                            <option value="<?php echo $id_cate; ?>"><?php echo $ds_cate; ?></option>
                                            <?php
                                              }
                                            }
                                            ?>
                                       </select>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Subcategoria" />
                                   </li>
                                 </ul>
                 
                         </form>
                        
                          <ul class="noticias">
                          	   <li>
                               <span><strong>Subcategorias</strong></span>
                               <div>Exc</div>
                               <div style="margin:0 60px 0 0">Categoria</div>
                               </li>
                            <?php
                              $sql = "select NR_SEQ_SUBCATCONTA_SCRC, DS_SUBCATEGORIA_SCRC, DS_CATEGORIA_CCRC from contas_subcategorias, contas_categorias WHERE NR_SEQ_CATCONTA_SCRC = NR_SEQ_CATCONTA_CCRC order by DS_SUBCATEGORIA_SCRC";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_subcat	   = $row[0];
                                 $nm_subcat	   = $row[1];
								 $nm_cat	   = $row[2];
                                ?>
                                <li>
                                <span><strong><?php echo $nm_subcat;?></strong></span>
                                <div>
                                <a href="#" title="deletar subcategoria" onclick="confirma_subcat(<?php echo $id_subcat; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                <div style="margin:0 60px 0 0"><strong><?php echo $nm_cat; ?></strong></div>
                                </li>
                                <?php
                                }
                              }
                            ?>
                          </ul>
                    </div>
                    
                    <div id="novo">
                    	<form action="contas_inc.php" method="post" name="frmContas" id="frmContas">
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="loja">
                                       <strong>Loja:</strong><br />
                                       <select name="loja">
											<?php echo utf8_decode($str_lojas); ?>
                                        </select>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="categoria">
                                       <strong>Categoria:</strong><br />
                                       <select name="categoria" onchange="document.location.href='contas.php?tipo=N&idcatego='+this.value+'&desc='+document.frmContas.descricao.value+'&valor='+document.frmContas.valor.value;">
											<?php
                                            $idcategoria = request("idcatego");
                                            $sql = "select NR_SEQ_CATCONTA_CCRC, DS_CATEGORIA_CCRC from contas_categorias order by DS_CATEGORIA_CCRC";
                                            $st = mysql_query($sql);
                
                                            if (mysql_num_rows($st) > 0) {
                                              while($row = mysql_fetch_row($st)) {
                                               $id_cate	   = $row[0];
                                               $ds_cate	   = $row[1];
                                               if (!$idcategoria) $idcategoria = $id_cate;
                                            ?>
                                            <option value="<?php echo $id_cate; ?>"<?php if ($id_cate == $idcategoria) echo " selected";?>><?php echo $ds_cate; ?></option>
                                            <?php
                                              }
                                            }
                                            ?>
                                       </select>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="SubCategoria">
                                       <strong>SubCategoria:</strong><br />
                                       <select name="subcategoria">
											<?php
                                            $sql = "select NR_SEQ_SUBCATCONTA_SCRC, DS_SUBCATEGORIA_SCRC from contas_subcategorias WHERE NR_SEQ_CATCONTA_SCRC = $idcategoria order by DS_SUBCATEGORIA_SCRC";
                                            $st = mysql_query($sql);
                                            $tem = "";
                                            if (mysql_num_rows($st) > 0) {
                                              while($row = mysql_fetch_row($st)) {
                                               $id_subcate	   = $row[0];
                                               $ds_subcate	   = $row[1];
                                               $tem = $id_subcate;
                                            ?>
                                            <option value="<?php echo $id_subcate; ?>"><?php echo $ds_subcate; ?></option>
                                            <?php
                                              }
                                            }
                                            if (!$tem) echo "<option value=\"0\">Não possui</option>";
                                            ?>
                                       </select>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="descricao">
                                       <strong>Descrição:</strong><br />
                                       <input class="form02" type="text" id="descricao" name="descricao" value="<?php echo request("desc"); ?>" />
                                     </label>
                                   </li>
                                   <li>
                                   	 <table cellpadding="0" cellspacing="0" width="240">
                                        <tr>
                                            <td><strong>Valor (R$):</strong></td>
                                            <td><strong>Vencimento:</strong></td>
                                        </tr>
                                        <tr>
                                        	<td><input class="form00" type="text" name="valor" value="<?php echo request("valor"); ?>" /></td>
                                            <td><input class="form00" type="text" name="data" value="<?php echo date("d/m/Y"); ?>" /></td>
                                        </tr>
                                    </table>
                                   </li>
                                   <li>
                                     <label for="tipo">
                                       <strong>Tipo:</strong><br />
                                        <select name="tipo">
                                        	<option value="D">Contas à Pagar</option>
                                            <option value="C">Contas à Receber</option>
                                        </select>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="forma">
                                       <strong>Forma de Pagamento:</strong><br />
                                        <select name="forma">
                                            <option value="0">Escolha aqui</option>
                                        	<option value="1">Boleto</option>
                                            <option value="2">Cheque</option>
                                            <option value="3">Dinheiro</option>
                                            <option value="4">Cartão Visa</option>
                                            <option value="5">Cartão Master</option>
                                            <option value="6">Transferência</option>
                                            <option value="7">Depósito Cheque</option>
                                            <option value="8">Depósito Dinheiro</option>
                                            <option value="9">Débito Automático</option>
                                        </select>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Lançamento" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                    </div>
                    
<!-- //***** CONTAS PAGAS                    -->
                   <div id="pagas">
                   <table width="885">
                   <tr><form action="contas.php" method="post" name="formpagas">
                   <input name="tipo" type="hidden" value="P" />
                        <td height="20" align="right" valign="middle">
                        	<strong>Loja: <select name="lojapesq"><?php echo $str_lojas; ?></select></strong>
                            <strong>Data Inicial: </strong><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" />
                            <strong>Data Final: </strong><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" />
                            <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                        </td>
                        </form>
                        <script language="JavaScript">
						   document.form1.lojapesq.value = "<?php echo $lojapesq; ?>";
						</script>
                    </tr>
                   </table>
                   <form action="contas_dup_all.php" method="post">
                	<ul class="compras">
                    <li>
                    <table border="0" cellpadding="0" cellspacing="2" height="20">
                            <tr>
                                <td width="17">&nbsp;</td>
                                <td align="center" width="102"><strong style="color:#993300;">Paga</strong></td>
                                <td align="center" width="107"><strong style="color:#993300;">Data Lançamento</strong></td>
                                <td align="left" width="90"><strong style="color:#993300;">Loja</strong></td>
                                <td align="left" width="194"><strong style="color:#993300;">Descrição</strong></td>
                                <td align="left" width="130"><strong style="color:#993300;">Categoria</strong></td>
                                <td align="left" width="162"><strong style="color:#993300;">SubCategoria</strong></td>
                                <td align="right" width="100"><strong style="color:#993300;">Valor</strong></td>
                                <td align="center" width="20"><strong style="color:#993300;">Tp</strong></td>
                            </tr>
                        </table>
                    </li>
						<?php
						  $sql = "select NR_SEQ_CONTA_CORC, NR_SEQ_CATCONTA_CORC, DS_DESCRICAO_CORC, VL_CONTA_CORC, DT_CADASTRO_CORC, DT_TIPO_CORC, DS_TIPO_CORC,
						  				DS_CATEGORIA_CCRC, DS_LOJA_LJRC, NR_SEQ_SUBCATCONTA_CORC, NR_FORMA_PGTO_CORC from contas, contas_categorias, lojas WHERE NR_SEQ_CATCONTA_CORC = NR_SEQ_CATCONTA_CCRC AND
										NR_SEQ_LOJA_CORC = NR_SEQ_LOJA_LJRC and DS_TIPO_CORC = 'P' AND NR_SEQ_LOJA_CORC = $lojapesq AND
										DT_VCTO_CORC between STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') and STR_TO_DATE('$datafim','%d/%m/%Y %H:%i:%s')";
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
							 
							 $total += $vl_conta;
							?>
							<li>
                            <table border="0" width="1110" cellpadding="0" cellspacing="2" height="20">
                                <tr>
                                    <td align="center" width="24"><input type="checkbox" name="contas[]" value="<?php echo $id_conta ?>" /></td>
                                    <td align="center" width="100"><strong><?php echo date("d/m/Y", strtotime($dt_vcto));?></strong></td>
                                    <td align="center" width="110"><?php echo date("d/m/Y G:i", strtotime($dt_lanca));?></td>
                                    <td align="left" width="90"><?php echo $ds_loja;?></td>
                                    <td align="left"><strong><?php echo $ds_conta; ?></strong></td>
                                    <td align="left" width="130"><?php echo $ds_categ; ?></td>
                                    <td align="left" width="130"><?php echo $dssubcateg; ?></td>
                                    <td align="right" width="130"><strong>R$ <?php echo number_format($vl_conta,2,",","."); ?></strong></td>
                                    <td align="center" width="20"><strong style="color:#FF0000;"><?php echo $ds_tipo; ?></strong></td>
                                    <td align="center" width="80"><?php echo $forma; ?></td>
                                    <td align="center" width="25"><a href="#" onclick="confirma(<?php echo $id_conta; ?>,'P');" title="Deletar Conta"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="contas_alt.php?idc=<?php echo $id_conta;?>" title="Alterar Conta"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="#" onclick="confirma_liq(<?php echo $id_conta;?>,'P','P');" title="Mover para Contas Pagas"><img src="img/ico_classicsp.gif" border="0" /></a></td>
                                    <td align="center" width="25"><a href="contas_dup.php?idc=<?php echo $id_conta;?>&tp=P" title="Jogar para o mês seguinte"><img src="img/ico_mais.gif" width="16" height="16" border="0" alt="Jogar para o mês seguinte" /></a></td>
                                </tr>
                            </table>
                            </li>
							<?php
							}
							?>
                            <li>
                            <table border="0" width="975" cellpadding="0" cellspacing="2" height="20">
                                <tr>
                                    <td align="left" width="210" colspan="2"><input type="submit" value="  Copiar p/ mês seguinte  " /></td>
                                    <td align="left">&nbsp;</td>
                                    <td align="right" width="150"><strong style="color:#993300;">Total:</strong></td>
                                    <td align="right" width="130"><strong style="color:#993300;">R$ <?php echo number_format($total,2,",","."); ?></strong></td>
                                    <td align="center" width="20">&nbsp;</td>
                                    <td align="center" width="25">&nbsp;</td>
                                    <td align="center" width="25">&nbsp;</td>
                                </tr>
                            </table>
                            </li>
                        <?php
						  }
						?>
                        </form>
                      </ul>
                     
                  	</div>
<!-- //***** FIM CONTAS PAGAS                    -->                    


<!-- //***** CONTAS RECEBIDAS                 -->
                   <div id="liqreceb">
                   <table width="885">
                   <tr><form action="contas.php" method="post" name="formrecebidas">
                   <input name="tipo" type="hidden" value="R" />
                        <td height="20" align="right" valign="middle">
                        	<strong>Loja: <select name="lojapesq"><?php echo $str_lojas; ?></select></strong>
                            <strong>Data Inicial: </strong><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" />
                            <strong>Data Final: </strong><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" />
                            <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                        </td>
                        </form>
                        <script language="JavaScript">
						   document.form1.lojapesq.value = "<?php echo $lojapesq; ?>";
						</script>
                    </tr>
                   </table>
                   <form action="contas_dup_all.php" method="post">
                	<ul class="compras">
                    <li>
                    <table border="0" cellpadding="0" cellspacing="2" height="20">
                            <tr>
                                <td width="17">&nbsp;</td>
                                <td align="center" width="102"><strong style="color:#993300;">Recebida</strong></td>
                                <td align="center" width="107"><strong style="color:#993300;">Data Lançamento</strong></td>
                                <td align="left" width="90"><strong style="color:#993300;">Loja</strong></td>
                                <td align="left" width="194"><strong style="color:#993300;">Descrição</strong></td>
                                <td align="left" width="130"><strong style="color:#993300;">Categoria</strong></td>
                                <td align="left" width="162"><strong style="color:#993300;">SubCategoria</strong></td>
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
						  				DS_CATEGORIA_CCRC, DS_LOJA_LJRC, NR_SEQ_SUBCATCONTA_CORC, NR_FORMA_PGTO_CORC from contas, contas_categorias, lojas WHERE NR_SEQ_CATCONTA_CORC = NR_SEQ_CATCONTA_CCRC AND
										NR_SEQ_LOJA_CORC = NR_SEQ_LOJA_LJRC and DS_TIPO_CORC = 'R' AND NR_SEQ_LOJA_CORC = $lojapesq AND
										DT_VCTO_CORC between STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') and STR_TO_DATE('$datafim','%d/%m/%Y %H:%i:%s')";
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
							 
							 $total += $vl_conta;
							?>
							<li>
                            <table border="0" width="1110" cellpadding="0" cellspacing="2" height="28">
                                <tr>
                                    <td align="center" width="24"><input type="checkbox" name="contas[]" value="<?php echo $id_conta ?>" /></td>
                                    <td align="center" width="101"><strong><?php echo date("d/m/Y", strtotime($dt_vcto));?></strong></td>
                                    <td align="center" width="109"><?php echo date("d/m/Y G:i", strtotime($dt_lanca));?></td>
                                    <td align="left" width="89"><?php echo $ds_loja;?></td>
                                    <td width="194" align="left"><strong><?php echo $ds_conta; ?></strong></td>
                                    <td align="left" width="132"><?php echo $ds_categ; ?></td>
                                    <td align="left" width="163"><?php echo $dssubcateg; ?></td>
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
					  defineAba("abaVer","pagar");
                      defineAba("abaVerR","receber");
					  defineAba("abaVerU","uni");
					  defineAba("abaVerC","categoria");
					  defineAba("abaVerS","subcategoria");
					  defineAba("abaVerN","novo");
					  defineAba("abaVerP","pagas");
					  defineAba("abaVerRL","liqreceb");
					  <?php
					  switch(request("tipo")){
					  	case "C":
							echo "defineAbaAtiva(\"abaVerR\");";
							break;
						case "D":
							echo "defineAbaAtiva(\"abaVer\");";
							break;
						case "U":
							echo "defineAbaAtiva(\"abaVerU\");";
							break;
						case "I":
							echo "defineAbaAtiva(\"abaVerC\");";
							break;
						case "S":
							echo "defineAbaAtiva(\"abaVerS\");";
							break;
						case "N":
							echo "defineAbaAtiva(\"abaVerN\");";
							break;
						case "P":
							echo "defineAbaAtiva(\"abaVerP\");";
							break;
						case "R":
							echo "defineAbaAtiva(\"abaVerRL\");";
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
<script>
   $(":date").dateinput({ format: 'dd/mm/yyyy' });
</script>
<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>
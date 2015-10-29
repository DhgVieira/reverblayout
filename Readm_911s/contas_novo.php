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
                      <li style="width: 125px;" id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_apagar.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">A PAGAR</li>
                      <li style="width: 125px;" id="abaVerR" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_areceber.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">A RECEBER</li>
                      <li style="width: 125px;" id="abaVerP" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_pagas.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">CONTAS PAGAS</li>
                      <li style="width: 140px;" id="abaVerRL" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_recebidas.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">CONTAS RECEBIDAS</li>
                      <li style="width: 125px;" id="abaVerU" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_unificado.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">UNIFICADO</li>
                      <li style="width: 125px;" id="abaVerC" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_categorias.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">CATEGORIAS</li>
                      <li style="width: 125px;" id="abaVerS" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_subcategorias.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">SUBCATEGORIAS</li>
                      <li style="width: 125px;" id="abaVerD" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_descricao.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">FORNECEDORES</li>
                      <li style="width: 140px;" id="abaVerN" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">NOVO LANÇAMENTO</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas">
                 
                    <div id="novo">
                    	<form action="contas_inc.php" method="post" name="frmContas" id="frmContas" >
                        <input type="hidden" name="idcat" id="idcat" value="" />
                        <input type="hidden" name="idscat" id="idscat" value="" />
                            
                                  <table cellpadding="0" cellspacing="0" width="420">
                                     <tr>
                                        <td><b>Tipo de Lançamento</b></td>
                                        <td><b>Forma de Pagamento</b></td>
                                        <td><b>Loja</b></td>
                                      </tr>
                                        <td>
                                          <select name="tipo">
                                            <option value="" selected>Selecione...</option>
                                            <option value="D">Contas à Pagar</option>
                                            <option value="C">Contas à Receber</option>
                                          </select>
                                        </td>
                                        <td>
                                          <select name="forma">
                                            <option value="0">Selecione...</option>
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
                                        </td>       
                                        <td>
                                          <select name="loja">
                                            <option value="" selected>Selecione...</option>
                                            <?php echo utf8_decode($str_lojas); ?>
                                          </select>
                                        </td>
                                      <tr>
                                      </tr>
                                      <tr>
                                          <td colspan="2"><b>Categoria:</b></td>
                                          <td><b>Subcategoria:</b></td>
                                      </tr>
                                      <tr>
                                          <td colspan="2">
                                              <input  type="text" id="categoria" name="categoria" size="41"/> 
                                          </td>
                                          <td>
                                             <select name="subcategoria" id="subcategoria" style="min-width:115px">
                                              <option>Selecione...</option>
                                            </select> 
                                          </td>
                                      </tr>
                                      <tr>
                                        <td colspan="3">
                                          <b>Fornecedor:</b>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="3">
                                          <select name="descricao" id="descricao" style="min-width:411px">
                                            <option value="" selected>Selecione...</option>
                                          </select> 
                                        </td>
                                      </tr>
                                      <tr>
                                        <td><strong>Data de Emiss&atilde;o:</strong></td>
                                        <td><strong>1º Vencimento</strong></td>
                                        <td><strong>Nº do Documento:</strong></td>
                                      </tr>
                                      <tr>
                                        <td><input style="width: 120px;" type="date" name="dataemiss" value="<?php echo date("d/m/Y"); ?>" /></td>
                                        <td><input style="width: 120px;" type="date" name="data" value="<?php echo date("d/m/Y"); ?>" /></td>
                                        <td><input style="width: 110px;" type="text" name="nrdcto" /></td>
                                      </tr>
                                      <tr>
                                        <td><strong>Valor:</strong></td>
                                        <td><strong>Periodicidade:</strong></td>
                                        <td><strong>Repetir (nº de vezes):</strong></td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <input style="width: 120px;" type="text" name="valor" value="<?php echo request("valor"); ?>"/>
                                        </td>
                                        <td>
                                           <select class="form00" name="periodo" style="width: 130px; height: 25px;">
                                              <option value="1">Pagamento Único</option>
                                              <option value="15">Quinzenal</option>
                                              <option value="30">Mensal</option>
                                            </select>
                                        </td>
                                        <td>
                                          <input class="form00" type="text" name="nrvezes" value="1" style="width: 110px;"/>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="3">
                                          <b> Descrição: </b>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="3">
                                          <textarea id="descricao2" name="descricao2" cols="49" rows="5"><?php echo request("desc"); ?></textarea>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="3">
                                          <input type="submit" id="postar" name="postar" value="Cadastrar Lançamento" />
                                        </td>
                                      </tr>
                                  </table>
                                 
                             <!-- </fieldset> -->
                         </form>
                    </div>

                    <script>
					  defineAba("abaVerN","novo");
					  <?php
					  echo "defineAbaAtiva(\"abaVerN\");";
					  ?>
                    </script>
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>
<script>
   $(":date").dateinput({ format: 'dd/mm/yyyy' });
</script>
<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>
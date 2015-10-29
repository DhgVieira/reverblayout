<?php
include 'auth.php';
include 'lib.php';

//montacombolojas
$sql = "select NR_SEQ_LOJA_LJRC, DS_LOJA_LJRC from lojas order by NR_SEQ_LOJA_LJRC";
$st = mysql_query($sql);
$str_lojas = "";
if (mysql_num_rows($st) > 0) {
  while($row = mysql_fetch_row($st)) {
   $id_loja	   = $row[0];
   $ds_loja	   = utf8_encode($row[1]);
   $str_lojas .= "<option value=\"$id_loja\">$ds_loja</option>\n";
  }
}

?>
<?php include 'topo.php'; ?>
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
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas.php'">Contas</li>
                      <li id="abaVerR" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Conta</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas">
                    
                    <div id="novo">
                    	<?php
						  $idc = request("idc");
						  $sql = "select NR_SEQ_CONTA_CORC, NR_SEQ_CATCONTA_CORC, DS_DESCRICAO_CORC, VL_CONTA_CORC, DT_CADASTRO_CORC, DT_VCTO_CORC, DS_TIPO_CORC,
						  				DS_CATEGORIA_CCRC, NR_SEQ_LOJA_CORC, NR_SEQ_SUBCATCONTA_CORC, NR_FORMA_PGTO_CORC from contas, contas_categorias, lojas WHERE NR_SEQ_CATCONTA_CORC = NR_SEQ_CATCONTA_CCRC AND
										NR_SEQ_LOJA_CORC = NR_SEQ_LOJA_LJRC and NR_SEQ_CONTA_CORC = $idc";
						  $sql .= " order by DT_VCTO_CORC";

						  $st = mysql_query($sql);

						  if (mysql_num_rows($st) > 0) {
							$total = 0;
						  	 $row = mysql_fetch_row($st);
							 $id_conta	   = $row[0];
					         $nr_categ	   = $row[1];
							 $ds_conta	   = $row[2];
							 $vl_conta	   = $row[3];
							 $dt_lanca	   = $row[4];
							 $dt_vcto	   = $row[5];
							 $ds_tipo	   = $row[6];
							 $ds_categ	   = $row[7];
							 $nr_loja	   = $row[8];
							 $nrseqsub	   = $row[9];
                             $forma        = $row[10];
							 
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
                    	<form action="contas_alt2.php" method="post" name="frmContas" id="frmContas">
                        	<input name="idc" type="hidden" value="<?php echo $idc ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="loja">
                                       <strong>Loja:</strong><br />
                                       <select name="loja">
											<?php echo $str_lojas; ?>
                                        </select>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="categoria">
                                       <strong>Categoria:</strong><br />
                                       <select name="categoria" onchange="document.location.href='contas_alt.php?idc=<?php echo $idc ?>&tipo=N&idcatego='+this.value+'&desc='+document.frmContas.descricao.value+'&valor='+document.frmContas.valor.value;">
											<?php
                                            $idcategoria = request("idcatego");
                                            $sql = "select NR_SEQ_CATCONTA_CCRC, DS_CATEGORIA_CCRC from contas_categorias order by DS_CATEGORIA_CCRC";
                                            $st = mysql_query($sql);
                
                                            if (mysql_num_rows($st) > 0) {
                                              while($row = mysql_fetch_row($st)) {
                                               $id_cate	   = $row[0];
                                               $ds_cate	   = $row[1];
                                               if (!$idcategoria) $idcategoria = $nr_categ;
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
                                            <option value="<?php echo $id_subcate; ?>"<?php if ($id_subcate == $nrseqsub) echo " selected";?>><?php echo $ds_subcate; ?></option>
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
                                       <input class="form02" type="text" id="descricao" name="descricao" value="<?php echo $ds_conta; ?>" />
                                     </label>
                                   </li>
                                   <li>
                                   	 <table cellpadding="0" cellspacing="0" width="240">
                                        <tr>
                                            <td><strong>Valor (R$):</strong></td>
                                            <td><strong>Vencimento:</strong></td>
                                        </tr>
                                        <tr>
                                        	<td><input class="form00" type="text" name="valor" value="<?php echo $vl_conta; ?>" /></td>
                                            <td><input class="form00" type="text" name="data" value="<?php echo date("d/m/Y", strtotime($dt_vcto)); ?>" /></td>
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
                                        </select>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Alterar Lançamento" />
                                   </li>
                                 </ul>
                             </fieldset>
                             <script language="JavaScript">
							   document.frmContas.loja.value = "<?php echo $nr_loja; ?>";
							   document.frmContas.tipo.value = "<?php echo $ds_tipo; ?>";
                               document.frmContas.forma.value = <?php echo $forma; ?>;
							</script>
                         </form>
                         <?php } ?>
                    </div>
                    
                    <script>
					  defineAba("abaVerR","novo");
					  defineAbaAtiva("abaVerR");
                    </script>
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>
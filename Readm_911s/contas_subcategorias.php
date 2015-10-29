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
                      <li style="width: 125px;" id="abaVerS" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">SUBCATEGORIAS</li>
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
                  
                    <script>
					  defineAba("abaVerS","subcategoria");
					  <?php
					  echo "defineAbaAtiva(\"abaVerS\");";
					  ?>
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
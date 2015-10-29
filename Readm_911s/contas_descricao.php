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

function confirma_desc(idc) {
	var confirma = confirm("Confirma a Exclusão dessa Descrição?")
	if ( confirma ){
		document.location.href='contas_desc_del.php?idc='+idc;
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
                      <li style="width: 125px;" id="abaVerS" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='contas_subcategorias.php?dataini=<?php echo $dataini ?>&datafim=<?php echo $datafim ?>';">SUBCATEGORIAS</li>
                      <li style="width: 125px;" id="abaVerD" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">FORNECEDORES</li>
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
                        <form action="contas_descricao_inc.php" method="post">
                         
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_subcat">
                                       Fornecedor (nome fantasia):<br />
                                       <input class="form02" type="text" id="nome_subcat" name="nome_subcat" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="razao">
                                       Raz&atilde;o Social:<br />
                                       <input class="form02" type="text" id="razao" name="razao" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="cnpj">
                                       CNPJ:<br />
                                       <input class="form02" type="text" id="cnpj" name="cnpj" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="ie">
                                       IE:<br />
                                       <input class="form02" type="text" id="ie" name="ie" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="endereco">
                                       Endere&ccedil;o:<br />
                                       <input class="form02" type="text" id="endereco" name="endereco" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="fone">
                                       Fone:<br />
                                       <input class="form02" type="text" id="fone" name="fone" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="email">
                                       E-mail:<br />
                                       <input class="form02" type="text" id="email" name="email" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="contato">
                                       Contato:<br />
                                       <input class="form02" type="text" id="contato" name="contato" />
                                     </label>
                                   </li>
                                    <li>
                                     <label for="nome_favorecido">
                                       Nome do Favorecido:<br />
                                       <input class="form02" type="text" id="nome_favorecido" name="nome_favorecido" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="banco">
                                       Banco:<br />
                                       <input class="form02" type="text" id="banco" name="banco" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="agencia">
                                      Agência:<br />
                                       <input class="form02" type="text" id="agencia" name="agencia" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="conta">
                                       Número da Conta:<br />
                                       <input class="form02" type="text" id="conta" name="conta" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="observacoes">
                                       Observações:<br />
                                       <textarea cols="49" rows="5" name="observacoes" id="observacoes"></textarea>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Fornecedor" />
                                   </li>
                                 </ul>
                 
                         </form>
                        
                          <ul class="noticias">
                          	   <li>
                               <span><strong>Fornecedores</strong></span>
                               <div><b>Exc</b></div>
                               <div><b>Editar</b></div>
                               <div style="margin:0 60px 0 0"><b>Fone</b></div>
                               <div style="margin:0 120px 0 0"><b>E-mail</b></div>
                               <div style="margin:0 120px 0 0"><b>Contato</b></div>
                               </li>
                            <?php
                              $sql = "select NR_SEQ_SUBCATCONTA_DCRC, DS_SUBCATEGORIA_DCRC, DS_EMAIL_DCRC, DS_CONTATO_DCRC, DS_FONE_DCRC from contas_descricao
                                      order by DS_SUBCATEGORIA_DCRC";
                              $st = mysql_query($sql);
                         
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_desc	   = $row[0];
                                 $nm_desc	   = $row[1];
								                 $email	   = $row[2];
                                 $contato	   = $row[3];
                                 $fone	   = $row[4];
                                ?>
                                <li>
                                <span><strong><?php echo $nm_desc;?></strong></span>
                                <div>
                                  <a href="#" title="deletar descricao" onclick="confirma_desc(<?php echo $id_desc; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                <div>
                                  <a href="contas_desc_alt.php?idc=<?php echo $id_desc;?>" title="Alterar"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a>
                                </div>
                                <div style="margin:0 60px 0 0"><?php echo $fone; ?></div>
                                <div style="margin:0 120px 0 0"><?php echo $email; ?></div>
                                <div style="margin:0 120px 0 0"><?php echo $contato; ?></div>
                                </li>
                                <?php
                                }
                              }
                            ?>
                          </ul>
                    </div>
                  
                    <script>
					  defineAba("abaVerD","subcategoria");
					  <?php
					  echo "defineAbaAtiva(\"abaVerD\");";
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
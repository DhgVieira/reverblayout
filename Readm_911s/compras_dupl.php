<?php
include 'auth.php';
include 'lib.php';
$status = request("st");
$PHP_SELF = "compras.php";
if (!$status) $status = "A";
$pagina = request("pagina");
?>

<?php 
$dataini = request("dataini");
$datafim = request("datafim");
$pesq_nom = request("nomeps");
$pesq_email = request ("emailps");
$cidade = request("cidade");
$estado = request("estado");
$nrpedido = request("nrpedido");

$sqlnf = "select NR_SEQNF_NFRC from notas_fiscais ORDER BY DT_EMISSAO_NFRC desc, NR_SEQ_NFE_NFRC desc limit 1";
$stnf = mysql_query($sqlnf);
$nr_nfe = 0;
if (mysql_num_rows($stnf) > 0) {
    $rownf = mysql_fetch_row($stnf);
    $nr_nfe = $rownf[0];
}

$nr_nfe++;

?>
<?php include 'topo.php'; ?>

<script language="javascript">
function confirma(idcomp) {
	var confirma = confirm("Confirma a Exclusao dessa compra e seus itens?\nEsta operacao nao podera ser revertida.")
	if ( confirma ){
		document.location.href='compras_del.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&idc='+idcomp;
	} else {
		return false
	} 
}

function confirmaC(idcomp) {
	var confirma = confirm("Confirma o Cancelamento dessa compra e seus itens?")
	if ( confirma ){
		document.location.href='compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=C&idgrp='+idcomp;
	} else {
		return false
	} 
}

function delfrete(idf) {
	var confirma = confirm("Confirma a Exclusao desse frete?\nEsta operacao nao podera ser revertida.")
	if ( confirma ){
		document.location.href='fretecruz_del.php?idf='+idf;
	} else {
		return false
	} 
}

function GeraCusto(){
    document.frmEtiq.action = "gera_custo.php";
    document.frmEtiq.target = "_blank";
    document.frmEtiq.submit();
}

function GeraNfe(){
    $("#nfe").val($("#nr_nfe").val());
    document.frmEtiq.action = "compras_nfe20.php";
    document.frmEtiq.target = "_blank";
    document.frmEtiq.submit();
}

</script>
<script language="JavaScript" src="calendar1.js"></script>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td>
                <table width="1100" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left">
                        
                        <ul id="titulos_abas" style="width: 100%;">
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
                	
                </td>
            </tr>
        </table>
        <?php if ($status != "F") { ?>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr>
                	<td bgcolor="#FFFFFF">
                    	
                    	<table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#CCCCCC">
                           <tr><form action="compras.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>" method="post" name="form1">
                                <td>
                                    <input type="Button" value="Gerar Etiquetas" onClick="document.frmEtiq.submit();" class="form00" style="width:100px;height:20px;" />
                                    <input type="Button" value="Gerar Custo" onClick="GeraCusto();" class="form00" style="width:80px;height:20px;" />
                                    <input type="Button" value="Gerar NFe" onClick="GeraNfe();" class="form00" style="width:65px;height:20px;" />
                                    <input style="width:40px;height:14px;" class="frm_pesq" type="text" name="nr_nfe" id="nr_nfe" value="<?php echo $nr_nfe; ?>" />
                                </td>
                                <td height="20" align="right" valign="middle">
                                	<strong>Pedido: </strong><input style="width:50px;height:14px;" class="frm_pesq" type="text" name="nrpedido" value="<?php echo $nrpedido; ?>" />
                                    <strong>Nome: </strong><input style="width:110px;height:14px;" class="frm_pesq" type="text" name="nomeps" value="<?php echo $pesq_nom; ?>" />
                   					<strong>E-mail: </strong><input style="width:110px;height:14px;" class="frm_pesq" type="text" name="emailps" value="<?php echo $pesq_email; ?>" />
                                    <strong>Cidade/UF: </strong>
                    <input style="width:100px;height:14px;" class="frm_pesq" type="text" name="cidade" value="<?php echo $cidade; ?>" />
                    <select name="estado" class="input" id="estado" style="width:45px;"/>
                    		<option value="">--</option>
                        	<option value="AC">AC</option> 
                            <option value="AL">AL</option> 
                            <option value="AP">AP</option> 
                            <option value="AM">AM</option> 
                            <option value="BA">BA</option> 
                            <option value="CE">CE</option> 
                            <option value="DF">DF</option> 
                            <option value="ES">ES</option> 
                            <option value="GO">GO</option> 
                            <option value="MA">MA</option> 
                            <option value="MT">MT</option> 
                            <option value="MS">MS</option> 
                            <option value="MG">MG</option> 
                            <option value="PA">PA</option> 
                            <option value="PB">PB</option> 
                            <option value="PR">PR</option> 
                            <option value="PE">PE</option> 
                            <option value="PI">PI</option> 
                            <option value="RJ">RJ</option> 
                            <option value="RN">RN</option> 
                            <option value="RS">RS</option> 
                            <option value="RO">RO</option> 
                            <option value="RR">RR</option> 
                            <option value="SC">SC</option> 
                            <option value="SP">SP</option> 
                            <option value="SE">SE</option> 
                            <option value="TO">TO</option> 
                        </select>  
                                    <strong>Data Inicial: </strong><input style="width:80px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" />
                                    <a href="javascript:cal1.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a>
                                    <strong>Data Final: </strong><input style="width:80px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" />
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
                        <input type="hidden" name="nfe" id="nfe" />
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
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                                <td align="center" width="27">&nbsp;</td>
                            </tr>
                        </table>
                    <ul class="compras">
						<?php
						  
					
						  $sql = "select NR_SEQ_COMPRA_COSO, DT_COMPRA_COSO, DS_FORMAPGTO_COSO, VL_TOTAL_COSO, DS_NOME_CASO, DS_EMAIL_CASO, DS_DDDFONE_CASO,
						  				 DS_FONE_CASO, NR_SEQ_CADASTRO_COSO, NR_PARCELAS_COSO, DT_NASCIMENTO_CASO, ST_COMPRA_COSO, VL_DESCPROMO_COSO,
                                         DS_DESCPROMO_COSO, DS_CELULAR_CASO, DS_TWITTER_CACH from compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND
										 NR_SEQ_LOJA_COSO = $SS_loja  and DT_COMPRA_COSO > '2011-09-23 16:30:00' and ST_COMPRA_COSO <> 'C'";
						 
                          $sql .= " AND NR_SEQ_CADASTRO_COSO in (5281	,
6101	,
6496	,
6751	,
9701	,
9780	,
9917	,
10367	,
10758	,
10879	,
10977	,
11279	,
11292	,
12034	,
12129	,
12320	,
12775	,
13231	,
13497	,
14281	,
14475	,
14570	,
14589	,
15088	,
15143	,
15293	,
15832	,
16030	,
16291	,
16297	,
16313	,
16388	,
16394	,
16401	,
16411	,
16414	,
16564	,
16645	
	
)";

						  $sql .= " ORDER BY NR_SEQ_CADASTRO_COSO, DT_COMPRA_COSO desc ";
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
                             
                             $datanasc     = $row[10];
                             $status       = $row[11];
                             
                             $dian         = date("d",strtotime($datanasc));
                             $mesn         = date("m",strtotime($datanasc));
                             
                             $diac         = date("d",strtotime($dt_compra));
                             $mesc         = date("m",strtotime($dt_compra));
                             
                             $compraniver = false;
                             $textodestaque = "";

							 $totger += $valor;
							 
							 if ($x == 0) {
							 	$bg = "#FFFFFF";
								$x = 1;
							 }else{
							 	$bg = "#ECECFF";
								$x = 0;
							 }
                             
                             if ($dian == $diac && $mesn == $mesc){
                                $bg = "#B3FE97";
                                $textodestaque = "Compra de Aniversariante";                                
                             }
                             
                             $desconto     = $row[12];
                             $textopro     = $row[13];
                             $celular      = $row[14];
                             
                             $celular = str_replace("-","",$celular);
                             $celular = str_replace(".","",$celular);
                             $celular = str_replace("/","",$celular);
                             $celular = str_replace("=","",$celular);
                             $celular = str_replace(" ","",$celular);
                             
                             $twitter      = $row[15];
                             
                             if ($desconto > 0 && strpos($textopro,"primeira compra") > 0){
                                $textodestaque = "Primeira Compra";   
                                $bg = "#FBFE98";                             
                             }
                             
                             if (strpos($textopro,"Dia dos Namorados") > 0){
                                $textodestaque = "Promo Dia dos Namorados";   
                                $bg = "#FBDBFC";                             
                             }
                             
                             if (strpos($textopro,"Shirt Club") > 0){
                                $textodestaque = "T-Shirt Club";   
                                $bg = "#e8ce52";                       
                             }
                             
                             if (strpos($textopro,"Tee de Banda com ChocoKisses") > 0){
                                $textodestaque = "Promo Tee + Choco";   
                                $bg = "#F5DD82";                       
                             }
                             
                             if (strpos($textopro,"Mugshot Jimi Hendrix") > 0){
                                $textodestaque = "Promo Jeans F + Hendrix";   
                                $bg = "#F5DD82";                       
                             }
                             
                             $sqlb = "SELECT NR_SEQ_CUPOM_CURC from cupons where NR_SEQ_COMPRA_USO_CURC = $id_compra";
                    		 $stb = mysql_query($sqlb);
                    		 if (mysql_num_rows($stb) > 0) {
               		            $textodestaque = "Cupom de Desconto";   
                                $bg = "#C8CEFF";    
                             }
							 
							 
							?>
							<table border="0" width="100%" cellpadding="0" cellspacing="0" height="30" bgcolor="<?php echo $bg; ?>">
                                <tr>
                                	<td align="center" width="10"><input name="etiq[]" type="checkbox" value="<?php echo $id_compra; ?>" /></td>
                                    <td align="center" width="60"><strong><?php echo $id_compra; ?></strong></td>
                                    <td align="center" width="145" nowrap="nowrap"><?php echo date("d/m/Y G:i", strtotime($dt_compra)); ?></td>
                                    <td align="left"><strong><?php echo ChecaClubStyle($idcli,$nome); ?></strong><?php if ($textodestaque) echo " ($textodestaque)"; ?></td>
                                    <td align="left" width="150" nowrap="nowrap"><a href="mailto:<?php echo $email; ?>" class="linksmenu"><?php echo $email; ?></a></td>
                                    <td align="center" width="100" nowrap="nowrap"><?php echo $dddfone . " " . $fone; ?></td>
                                    <td align="center" width="100" nowrap="nowrap"><?php echo $formapgto; ?></td>
                                    <td align="center" width="120" nowrap="nowrap"><strong>R$ <?php echo number_format($valor,2,",","."); ?></strong></td>
                                    <td align="center" width="30"><strong><?php echo $parcelas; ?></strong></td>
                                    <td align="center" width="30"><strong><?php echo $status; ?></strong></td>
                                    <td align="center" width="27"><a href="compras_ver.php?idcli=<?php echo $idcli;?>&idc=<?php echo $id_compra;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Detalhamento da Compra Nr <?php echo $id_compra ?>" class="thickbox"><img src="img/compras_ver.gif" width="16" height="16" border="0" alt="Ver Detalhamento" /></a></td>
                                    <td align="center" width="27"><a href="clientes_alt.php?idc=<?php echo $idcli;?>"><img src="img/ico-det.gif" width="16" height="16" border="0" alt="Alterar Dados" /></a></td>
                                    <td align="center" width="27"><a href="#" title="Cancelar Compra" onclick="confirmaC(<?php echo $id_compra;?>);"><img src="img/ico_cancel.gif" width="16" height="16" border="0" /></a></td>
                                    
                                </tr>
                        	</table>
							<?php
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
                            <?php
						  }else{
						  ?>
                          <table border="0" width="100%" cellpadding="0" cellspacing="0" height="20" bgcolor="#FFFFFF">
                            <tr>
                                <td align="center" height="80">Nenhum registro encontrado!</td>
                            </tr>
                        </table>
                          <?php
						  }
						?>
                        
                      </ul>
                   
        			</td>
            	</tr>
        		</table>
                 <br />
                </td>
            </tr>
        </table>
        
<?php } ?>  
<?php include 'rodape.php'; ?>
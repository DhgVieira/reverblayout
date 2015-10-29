<?php
include 'auth.php';
include 'lib.php';
?>
<?php include 'topo.php'; ?>

<script language="javascript">
function recriar(idcomp) {
	var confirma = confirm("Tem certeza que voce quer recriar essa compra? Ela sera cancelada e uma nova compra com a mesma data sera criada.")
	if ( confirma ){
		document.location.href='compras_new.php?pg=<?php echo $pagina; ?>&idc='+idcomp;
	} else {
		return false
	} 
}

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

function confirmaPg(idcomp) {
	var confirma = confirm("Confirma o Pagamento dessa compra? Um e-mail de confirmacao sera enviado ao cliente.")
	if ( confirma ){
		document.location.href='compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=P&idgrp='+idcomp;
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
                <table width="1200" cellpadding="0" cellspacing="0">
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
                            $tit_page = "Compras Pr&eacute;-Venda";
                            echo "<li id='menu10' class='abaativa'>Pr&eacute;-Vendas</li>";
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
                    	
                    <ul class="compras">
						<?php
						  $sql = "select NR_SEQ_COMPRA_COSO, DT_COMPRA_COSO, DS_FORMAPGTO_COSO, VL_TOTAL_COSO, DS_NOME_CASO, DS_EMAIL_CASO, DS_DDDFONE_CASO,
                                DS_FONE_CASO, NR_SEQ_CADASTRO_COSO, NR_PARCELAS_COSO, DT_NASCIMENTO_CASO, ST_COMPRA_COSO, VL_DESCPROMO_COSO,
                                DS_DESCPROMO_COSO, DS_CELULAR_CASO, DS_TWITTER_CACH, DS_OBS_COSO, TP_CADASTRO_CACH, DS_FACEBOOK_CACH
                                from compras, cadastros, cestas, produtos WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND
                                NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC and
                                NR_SEQ_LOJA_COSO = $SS_loja and TP_DESTAQUE_PRRC = 4 and ST_COMPRA_COSO <> 'C' and DT_COMPRA_COSO > '2013-05-20 00:00:00' 
                                GROUP BY NR_SEQ_COMPRA_COSO ORDER BY DT_COMPRA_COSO desc";
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
                             
                             $desconto     = $row[12];
                             $textopro     = $row[13];
                             $celular      = $row[14];
                             
                             $celular = str_replace("-","",$celular);
                             $celular = str_replace(".","",$celular);
                             $celular = str_replace("/","",$celular);
                             $celular = str_replace("=","",$celular);
                             $celular = str_replace(" ","",$celular);
                             
                             $twitter      = $row[15];
                             $dsobs        = $row[16];
                             
                             $tipocad      = $row[17]; 
                             
                             $facebook     = $row[18];
                             
                             $facebook = trim(str_replace("-","",$facebook));
                             
                             if ($facebook){
                                if (strpos($facebook,"http://") <= 0){
                                    $facebook = str_replace("http//","",$facebook);
                                    $facebook = str_replace("http/","",$facebook);
                                    $facebook = str_replace("http://","",$facebook);
                                    $facebook = str_replace("http://www.reverbcity.com/Readm_911s/","",$facebook);

                                    if (strpos($facebook,"facebook.com/") > 0){
                                        $facebook = str_replace("www.facebook.com/","",$facebook);
                                        $facebook = str_replace("facebook.com/","",$facebook);
                                        $facebook = str_replace("facebook.com.br/","",$facebook);
                                        $facebook = str_replace("www.facebook.com.br/","",$facebook);
                                    }
                                    
                                    $facebook = "http://facebook.com/".$facebook;
                                 }  
                             }
                             
                             if (strpos($textopro,"vamos te dar um presente!") > 0){
                                $textodestaque = "Compra de Aniversariante";   
                                $bg = "#B3FE97";                             
                             }
                             
                             if ((strpos($textopro,"primeira compra") || (strpos($textopro,"130,00! Escolha j"))) > 0){
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
                             
                             if (strpos($dsobs,"recriada a partir") > 0){
                                $textodestaque = "Aguardando novo Pgto.";   
                                $bg = "#b8bbe1";                             
                             }
                             
                             $sqlb = "SELECT NR_SEQ_CUPOM_CURC from cupons where NR_SEQ_COMPRA_USO_CURC = $id_compra";
                    		 $stb = mysql_query($sqlb);
                    		 if (mysql_num_rows($stb) > 0) {
               		            $textodestaque = "Cupom de Desconto";   
                                $bg = "#C8CEFF";    
                             }
                             
                             if ($tipocad == 2){
                                $textodestaque = "Vendedor";   
                                $bg = "#e1a463";   
                             }
                             
                             if ($tipocad == 3){
                                $textodestaque = "Parceiro";   
                                $bg = "#ffa3b4";   
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
                                    <?php if ($status == "A") {?>
                                    <td align="center" width="27"><a href="#" title="Recriar Compra" onclick="recriar(<?php echo $id_compra;?>);"><img src="img/money2.gif" border="0" /></a></td>
                                    <?php }?>
                                    <?php if ($status != "A") {?>
                                    <td align="center" width="27"><a href="compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=A&idgrp=<?php echo $id_compra;?>" title="Re-Abrir Compra"><img src="img/ico_alerta.gif" width="16" height="16" border="0" /></a></td>
                                    <?php }?>
                                    <?php if ($status != "P") {?>
                                    <td align="center" width="27"><a onclick="confirmaPg(<?php echo $id_compra;?>);" href="#" title="Confirmar Pagamento"><img src="img/ico_check.gif" width="16" height="16" border="0" /></a></td>
                                    <?php }?>
                                    <?php if ($status != "V") {?>
                                    <td align="center" width="27"><a href="compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=V&idgrp=<?php echo $id_compra;?>" title="Compra Enviada"><img src="img/ico_entrega.gif" width="18" height="16" border="0" /></a></td>
                                    <?php }?>
                                    <?php if ($status != "E") {?>
                                    <td align="center" width="27"><a href="compras_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&stn=E&idgrp=<?php echo $id_compra;?>" title="Compra Entregue"><img src="img/ico_cxopen.gif" width="16" height="16" border="0" /></a></td>
                                    <?php }?>
                                    <?php if ($status != "C") {?>
                                    <td align="center" width="27"><a href="#" title="Cancelar Compra" onclick="confirmaC(<?php echo $id_compra;?>);"><img src="img/ico_cancel.gif" width="16" height="16" border="0" /></a></td>
                                    <?php }?>
                                    <?php if ($SS_nivel == 100) {?>
                                    <td align="center" width="27"><a href="#" title="Deletar Compra" onclick="confirma(<?php echo $id_compra;?>);"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                    <?php }?>
                                    <?php if ($status == "P") {?>
                                    <td align="center" width="27"><a href="gruposcliente_add.php?id_cadcli=<?php echo $idcli; ?>" title="Adicionar ao Grupo "><img src="img/ico_usuarios.gif" width="16" height="16" border="0" /></a></td>
                                    <?php }?>
                                    <?php if (strlen($celular)==8) { ?>
                                    <td align="center" width="27"><a href="envia_sms.php?idcli=<?php echo $idcli;?>&KeepThis=true&TB_iframe=true&height=210&width=400" title="Enviando SMS" class="thickbox"><img src="img/ico_celular.png" width="10" height="17" border="0" alt="Enviar SMS" /></a></td>
                                    <?php }else{ ?>
                                    <td align="center" width="27">&nbsp;</td>
                                    <?php } ?>
                                    <?php if ($twitter) { ?>
                                    <td align="center" width="27"><a href="http://twitter.com/<?php echo $twitter;?>" title="Twitter" target="_blank"><img src="img/ico_twitter.png" width="18" height="13" border="0" alt="Twitter" /></a></td>
                                    <?php }else{ ?>
                                    <td align="center" width="27">&nbsp;</td>
                                    <?php } ?>
                                    <?php if ($facebook) { ?>
                                        <td align="center" width="24"><a href="<?php echo $facebook;?>" title="Facebook" target="_blank"><img src="img/facebook_icon.png" width="16" height="16" border="0" alt="facebook" /></a></td>
                                    <?php }else{ ?>
                                        <td align="center" width="24">&nbsp;</td>
                                    <?php } ?>
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
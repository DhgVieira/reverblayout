<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$aba	= request("aba");
$idc 	= request("idc");

$datap = DateAdd(15);
$datap = $datap[2]."/".str_pad($datap[1],2,"0",STR_PAD_LEFT)."/".str_pad($datap[0],2,"0",STR_PAD_LEFT);
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idc,idcli) {
	var confirma = confirm("Confirma a Exclusao desse Lancamento?")
	if ( confirma ){
		document.location.href='sortecred_det3.php?idc='+idc+'&nrseq=<?php echo $idc ?>&idcli='+idcli;
	} else {
		return false
	} 
}
</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Cr&eacute;ditos</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='sortecred.php';">Cr&eacute;ditos Geral</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Detalhamento de Compras</li>
                      <li id="abaLcto" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Novo Lançamento</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    
                    <div id="Criar">
						<?php 
						  $sql2 = "select DT_LANCAMENTO_CRSA, VL_LANCAMENTO_CRSA, TP_LANCAMENTO_CRSA, DS_OBSERVACAO_CRSA, 
                                          DS_NOME_CASO, NR_SEQ_CONTA_CRSA, NR_SEQ_COMPRA_CRSA, NR_SEQ_CADASTRO_CRSA, DT_VENCIMENTO_CRSA, ST_EXPIRADO_CRSA
                                          from contacorrente, cadastros WHERE NR_SEQ_CADASTRO_CRSA = NR_SEQ_CADASTRO_CASO
                                          and NR_SEQ_CADASTRO_CRSA = $idc order by DT_LANCAMENTO_CRSA";
                          $st = mysql_query($sql2);
						  if (mysql_num_rows($st) > 0) {
						  	?>
                            <ul class="noticias">
                            <li>
                            	<table width="880">
                                	<tr>
                                    	<td width="100"><strong>Data</strong></td>
                                        <td width="100"><strong>Data Expiração</strong></td>
                                        <td><strong>Descrição</strong></td>
                                        <td width="100" align="center"><strong>Compra</strong></td>
                                        <td width="70" align="center"><strong>Valor</strong></td>
                                        <td width="30" align="center"><strong>Tipo</strong></td>
                                        <td width="225" align="left"><strong>Cliente</strong></td>
                                        <td width="25" align="center">&nbsp;</td>
                                    </tr>
                                </table>
                             </li>
                            <?php
							$valorfim = 0;
						  	while($row2 = mysql_fetch_row($st)) {
							 $datalct   = $row2[0];
							 $vlrlcto   = $row2[1];
							 $tiplcto   = $row2[2];
							 $dsobs     = $row2[3];
							 $nome      = $row2[4];
							 $nrseqlc   = $row2[5];
                             $nrseqcomp = $row2[6];
                             $nrseqcad  = $row2[7];
                             $dtvcto    = $row2[8];
                             $status    = $row2[9];
                             
                             if (!$dtvcto){
                                $dtvcto = "";
                             }else{
                                $dtvcto = date("d/m/Y G:i", strtotime($dtvcto));
                             }
                             
                             if ($tiplcto == "D") {
                                $dtvcto = "";  
                             }else{
                                if ($dtvcto == ""){
                                    $dtvcto = "<strong>Sem Data</strong>";
                                }
                             }
							 if($status == 'N'){
                  $valorfim += $vlrlcto;
               }  
							?>
                            <li>
                            	<table width="880">
                                	<tr>
                                    	<td width="100"><?php echo date("d/m/Y G:i", strtotime($datalct));?></td>
                                        <td width="100"><?php echo $dtvcto;?></td>
                                        <td><?php echo $dsobs;?></td>
                                        <td width="100" align="center">
                                        <?php if ($nrseqcomp){ ?>
                                        <a href="compras_ver.php?idcli=<?php echo $nrseqcad;?>&idc=<?php echo $nrseqcomp;?>&KeepThis=true&TB_iframe=true&height=470&width=640" title="Detalhamento da Compra Nr <?php echo $nrseqcomp ?>" class="thickbox"><?php echo $nrseqcomp ?></a>
                                        <?php }else{ ?>
                                        &nbsp;
                                        <?php }?>
                                        </td>
                                        <td width="70" align="center"<?php if($tiplcto == "D") echo " style=\"color:#FF0000\""; ?>><strong>R$ <?php echo number_format($vlrlcto,2,",",".") ?></strong></td>
                                        <td width="30" align="center"<?php if($tiplcto == "D") echo " style=\"color:#FF0000\""; ?>><?php echo $tiplcto; ?></td>
                                    	<td width="225" align="left"><?php echo $nome ?></td>
                                        <td align="center" width="25">
                                            <?php if ($nrseqcomp){ ?>
                                            &nbsp;
                                            <?php }else{ ?>
                                            <a href="#" title="deletar lancamento" onclick="confirma(<?php echo $nrseqlc;?>,<?php echo $nrseqcad;?>);"><img src="img/cancel.png" width="16" height="16" border="0" /></a>
                                            <?php }?>
                                        </td>
                                    </tr>
                                </table>
                            </li>
                            <?php }?>
                            <li>
                            	<table width="880">
                                	<tr>
                                    	<td width="100">&nbsp;</td>
                                        <td width="100">&nbsp;</td>
                                        <td align="right"><strong>Saldo Final:</strong></td>
                                        <td width="100" align="center">&nbsp;</td>
                                        <td width="70" align="center"><strong>R$ <?php echo number_format($valorfim,2,",",".") ?></strong></td>
                                        <td width="30" align="center">&nbsp;</td>
                                        <td width="225" align="left">&nbsp;</td>
                                        <td width="25" align="center">&nbsp;</td>
                                    </tr>
                                </table>
                            </li>
                           </ul>
                         <?php }?>
                    </div> <!-- /criar -->
					
                    <div id="Lctos">

                         <form action="sortecred_det2.php" method="post">
                         <input name="idc" type="hidden" value="<?php echo $idc ?>">
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="descricao">
                                       Descri&ccedil;&atilde;o:<br />
                                       <input class="form01" type="text" name="descricao" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="valor">
                                       Valor (R$):<br />
                                       <input class="form00" type="text" name="valor" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="comprazo">
                                       Com prazo para utilização? <input type="radio" name="comprazo" checked="checked" value="S" /> SIM <input type="radio" name="comprazo" value="N" /> N&Atilde;O 
                                     </label>
                                   </li>
                                   <li>
                                     <label for="datafim">
                                       <br />
                                       <input class="form00" style="width: 100px;" type="text" name="datafim" value="<?php echo $datap." ".date("G:i") ;?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="valor">
                                       Tipo:<br />
                                       <select name="tipo">
                                       		<option value="C">Cr&eacute;dito</option>
                                            <option value="D">D&eacute;bito</option>
                                       </select>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Lan&ccedil;amento" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                    
                    </div> <!-- /criar -->
                    
                    <script>
                      defineAba("abaCriar","Criar");
					  defineAba("abaLcto","Lctos");
					  defineAbaAtiva("abaCriar");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>

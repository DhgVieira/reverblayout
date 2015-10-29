<?php
include 'auth.php';
include 'lib.php';

$dataini = request("dataini");
$datafim = request("datafim");

//d/m/Y G:i
if (!$datafim) $datafim = date("Y-m-j G:i:s");

if (!$dataini){
    $date = date("Y-m-j G:i:s");
    $newdate = strtotime ( '-7 day' , strtotime ( $date ) ) ;
    $dataini = date ( 'Y-m-j G:i:s' , $newdate );
}

if (strpos($dataini,"/") > 0){
    $spdata1 = explode("/",$dataini);
    $dataini = $spdata1[2]."-".$spdata1[1]."-".$spdata1[0]." 00:00:01";
}
if (strpos($datafim,"/") > 0){
    $spdata1 = explode("/",$datafim);
    $datafim = $spdata1[2]."-".$spdata1[1]."-".$spdata1[0]." 23:59:59";
}
?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Resumo Marketing</li>              
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li style="width: 125px;" id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Resumo</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas" style="padding: 20px;">
                   <div id="pagar">
                   <table>
                   <tr><form action="resumo_mkt.php" method="post" name="form1">
                        <td height="20" align="left" valign="middle">
                            <strong>Data Inicial: </strong><input style="width:100px;height:14px;text-align:center;" name="dataini" value="<?php echo date("d/m/Y",strtotime($dataini)); ?>" />
                            <strong>Data Final: </strong><input style="width:100px;height:14px;text-align:center;" name="datafim" value="<?php echo date("d/m/Y",strtotime($datafim)); ?>" />
                            <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                        </td>
                        </form>
                    </tr>
                   </table>

                   <table style="padding: 5px; font-size: 12px;">
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    </table>
                    <table>
                        <tr>
                            <td valign=top>
                                <?php
                                $sql = "select sum(VL_TOTAL_COSO), count(*) from compras, cadastros where
                                        NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and
                                        DT_COMPRA_COSO > '$dataini' and DT_COMPRA_COSO < '$datafim'
                                        and NR_SEQ_LOJA_COSO = 1 and TP_CADASTRO_CACH <> 1
                                        and NR_SEQ_CADASTRO_COSO <> 8074;";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    $row = mysql_fetch_row($st);
                                    $total_conf = $row[0];
                                    $total_vendas = $row[1];
                                }
                                
                                $sql = "select sum(VL_TOTAL_COSO), count(*) from compras, cadastros where
                                        NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and
                                        DT_COMPRA_COSO > '$dataini' and DT_COMPRA_COSO < '$datafim'
                                        and NR_SEQ_LOJA_COSO = 1 and TP_CADASTRO_CACH <> 1 and ST_COMPRA_COSO = 'C'
                                        and NR_SEQ_CADASTRO_COSO <> 8074;";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    $row = mysql_fetch_row($st);
                                    $total_cancel = $row[0];
                                    $total_vendasc = $row[1];
                                }
                                $totalconfvl = $total_conf-$total_cancel;
                                $qtdetotconf = $total_vendas-$total_vendasc;
                                
                                $sql = "SELECT sum(NR_QTDE_CESO) from cestas, compras, cadastros where 
                                NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
                                    and
                                    DT_COMPRA_COSO > '$dataini' and DT_COMPRA_COSO < '$datafim'
                                    and NR_SEQ_LOJA_COSO = 1 and TP_CADASTRO_CACH <> 1 and ST_COMPRA_COSO <> 'C'
                                    and NR_SEQ_CADASTRO_COSO <> 8074;
                                ";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    $row = mysql_fetch_row($st);
                                    $total_itens = $row[0];
                                }
                                
                                $sql = "SELECT count(*) from cadastros where TP_CADASTRO_CACH <> 1 and
                                DT_CADASTRO_CASO > '$dataini' and DT_CADASTRO_CASO < '$datafim';";
                                
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    $row = mysql_fetch_row($st);
                                    $total_cadastros = $row[0];
                                }
                                
                                $sql = "SELECT COUNT(*),SUM(VL_TOTAL_COSO) from compras, cadastros where NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
                                        AND  ST_COMPRA_COSO <> 'C' AND DT_CADASTRO_CASO > '$dataini' and DT_CADASTRO_CASO < '$datafim'
                                        and DT_COMPRA_COSO > '$dataini' and DT_COMPRA_COSO < '$datafim'
                                        ";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    $row = mysql_fetch_row($st);
                                    $total_cad_compraram = $row[0];
                                    $total_cad_comp_vlr = $row[1];
                                }
                                
                                $sql = "SELECT count(*) from cadastros where TP_CADASTRO_CACH <> 1 and 
                        			DT_CADASTRO_CASO > '$dataini' and DT_CADASTRO_CASO < '$datafim'
                        			and NR_SEQ_CADASTRO_CASO in (SELECT NR_SEQ_CADASTRO_COSO from compras, cestas where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                        			and ST_COMPRA_COSO <> 'C' and VL_PRODUTO_CESO = 0
                        			and DT_COMPRA_COSO > '$dataini' and DT_COMPRA_COSO < '$datafim')";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    $row = mysql_fetch_row($st);
                                    $total_cad_comppromo = $row[0];
                                }
                                
                                $sql = "select count(*), sum(VL_TOTAL_COSO)
                                         from compras, cadastros where
                                         NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and
                                        ST_COMPRA_COSO <> 'C' AND MONTH(DT_COMPRA_COSO) = MONTH(DT_NASCIMENTO_CASO) 
                                        and DT_COMPRA_COSO > '$dataini' and DT_COMPRA_COSO < '$datafim'
                                        AND TP_CADASTRO_CACH <> 1 and NR_SEQ_LOJA_CASO = 1";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    $row = mysql_fetch_row($st);
                                    $total_nivers = $row[0];
                                    $total_nivers_vl = $row[1];
                                }
                                
                                $sql = "select count(*), sum(VL_TOTAL_COSO)
                                         from compras, cadastros where
                                         NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and
                                        ST_COMPRA_COSO <> 'C' AND MONTH(DT_COMPRA_COSO) = MONTH(DT_NASCIMENTO_CASO) 
                                        and DT_COMPRA_COSO > '$dataini' and DT_COMPRA_COSO < '$datafim'
                                        AND TP_CADASTRO_CACH <> 1 and NR_SEQ_LOJA_CASO = 1 and VL_TOTAL_COSO >= 150";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    $row = mysql_fetch_row($st);
                                    $total_nivers_promo = $row[0];
                                    $total_nivers_promovl = $row[1];
                                }
                                                                ?>
                                <table style="padding: 5px; font-size: 12px;">
                                <tr>
                                    <td><strong>Total de Pedidos:</strong></td>
                                    <td style="text-align: center;"><?php echo $total_vendas; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Pedidos Confirmados:</strong></td>
                                    <td style="text-align: center;"><?php echo $qtdetotconf; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Vendas Canceladas:</strong></td>
                                    <td style="text-align: center;"><?php echo $total_vendasc; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Ticket M&eacute;dio:</strong></td>
                                    <td style="text-align: center;">R$ <?php echo number_format($totalconfvl/$qtdetotconf,2,",","."); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>M&eacute;dia de itens p/pedido:</strong></td>
                                    <td style="text-align: center;"><?php echo number_format($total_itens/$qtdetotconf,2,",",""); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong>Novos Cadastros:</strong></td>
                                    <td style="text-align: center;"><?php echo $total_cadastros; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Novos Cadastros c/compras:</strong></td>
                                    <td style="text-align: center;"><?php echo $total_cad_compraram; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Valor Total:</strong></td>
                                    <td style="text-align: center;">R$ <?php echo number_format($total_cad_comp_vlr,2,",","."); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Ticket M&eacute;dio:</strong></td>
                                    <td style="text-align: center;">R$ <?php echo number_format($total_cad_comp_vlr/$total_cad_compraram,2,",","."); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Novos Cadastros c/promo:</strong></td>
                                    <td style="text-align: center;"><?php echo $total_cad_comppromo; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong>Compras de Aniversariantes:</strong></td>
                                    <td style="text-align: center;"><?php echo $total_nivers; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Valor Total:</strong></td>
                                    <td style="text-align: center;">R$ <?php echo number_format($total_nivers_vl,2,",","."); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Ticket M&eacute;dio:</strong></td>
                                    <td style="text-align: center;">R$ <?php echo number_format($total_nivers_vl/$total_nivers,2,",","."); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Compras de Aniversariantes c/promo:</strong></td>
                                    <td style="text-align: center;"><?php echo $total_nivers_promo; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Valor Total:</strong></td>
                                    <td style="text-align: center;">R$ <?php echo number_format($total_nivers_promovl,2,",","."); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Ticket M&eacute;dio:</strong></td>
                                    <td style="text-align: center;">R$ <?php echo number_format($total_nivers_promovl/$total_nivers_promo,2,",","."); ?></td>
                                </tr>
                               </table>
                            </td>
                            <td>&nbsp;&nbsp;</td>
                            <td valign=top>
                            
                            <table style="padding: 5px; font-size: 12px;">
                                <tr>
                                    <td><strong>Valor Total Confirmado:</strong></td>
                                    <td style="text-align: center;">R$ <?php echo number_format($totalconfvl,2,",","."); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Valor Cancelado:</strong></td>
                                    <td style="text-align: center;">R$ <?php echo number_format($total_cancel,2,",","."); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Tipos Vendidos:</strong></td>
                                </tr>
                            </table>
                            <table style="padding: 5px; font-size: 12px;">
                                <?php
                                $sql = "SELECT
                                        				DS_CATEGORIA_PTRC, sum(NR_QTDE_CESO),
                                        				sum(VL_PRODUTO_CESO*NR_QTDE_CESO), DS_CATEGORIA_PCRC
                                        from 
                                        				cestas, compras, produtos, produtos_tipo, cadastros, produtos_categoria 
                                        WHERE 
                                        				NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND 
                                        			    NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC and
                                        				ST_COMPRA_COSO <> 'C' AND
                                        				NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC 
                                        				and DT_COMPRA_COSO > '$dataini' and DT_COMPRA_COSO < '$datafim'
                                        				AND NR_SEQ_LOJAS_PRRC = 1 
                                        				AND NR_SEQ_CADASTRO_COSO <> 8074
                                        				AND TP_CADASTRO_CACH <> 1 AND NR_SEQ_TIPO_PRRC <> 137
                                        GROUP BY 
                                        				NR_SEQ_TIPO_PRRC, NR_SEQ_CATEGORIA_PRRC order by DS_CATEGORIA_PTRC, DS_CATEGORIA_PCRC;";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    while($row = mysql_fetch_row($st)){
                                        ?>
                                        <tr>
                                            <td><strong><?php echo $row[0];?></strong></td>
                                            <td>&nbsp;</td>
                                            <td><strong><?php echo $row[3];?></strong></td>
                                            <td>&nbsp;</td>
                                            <td style="text-align: center;width: 50px;"><?php echo $row[1];?></td>
                                            <td>&nbsp;</td>
                                            <td><strong>R$ <?php echo number_format($row[2],2,",","."); ?></strong></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                               </table>
                            
                            </td>
                            <td>&nbsp;</td>
                            <td valign=top>
                                <table style="padding: 5px; font-size: 12px;">
                                <tr>
                                    <td colspan="2"><strong>10 Camisetas mais Vendidas:</strong></td>
                                </tr>
                                <?php
                                $sql = "SELECT
                                        				DS_CATEGORIA_PTRC, DS_CATEGORIA_PCRC, DS_PRODUTO2_PRRC, sum(NR_QTDE_CESO) as total
                                        from 
                                        				cestas, compras, produtos, cadastros, produtos_tipo, produtos_categoria 
                                        WHERE 
                                        				NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND 
                                        			  NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
                                        				AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC
                                        				AND ST_COMPRA_COSO <> 'C'
                                        				AND DT_COMPRA_COSO > '$dataini' and DT_COMPRA_COSO < '$datafim'
                                        				AND NR_SEQ_LOJAS_PRRC = 1 and NR_SEQ_TIPO_PRRC = 6
                                        				AND NR_SEQ_CADASTRO_COSO <> 8074
                                        				AND TP_CADASTRO_CACH <> 1 
                                        GROUP BY 
                                        				NR_SEQ_PRODUTO_CESO
                                        ORDER BY total desc LIMIT 10;";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    while($row = mysql_fetch_row($st)){
                                        ?>
                                        <tr>
                                            <td><?php echo $row[0];?>/<?php echo $row[1];?></td>
                                            <td>&nbsp;</td>
                                            <td><?php echo $row[2];?></td>
                                            <td>&nbsp;</td>
                                            <td><strong><?php echo $row[3];?></strong></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </table>
                                <p>&nbsp;</p>
                                <table style="padding: 5px; font-size: 12px;">
                                <tr>
                                    <td colspan="2"><strong>10 Buttons mais Vendidos:</strong></td>
                                </tr>
                                <?php
                                $sql = "SELECT
                                        				DS_CATEGORIA_PTRC, DS_CATEGORIA_PCRC, DS_PRODUTO2_PRRC, sum(NR_QTDE_CESO) as total
                                        from 
                                        				cestas, compras, produtos, cadastros, produtos_tipo, produtos_categoria 
                                        WHERE 
                                        				NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND 
                                        			  NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
                                        				AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC
                                        				AND ST_COMPRA_COSO <> 'C'
                                        				AND DT_COMPRA_COSO > '$dataini' and DT_COMPRA_COSO < '$datafim'
                                        				AND NR_SEQ_LOJAS_PRRC = 1 and NR_SEQ_TIPO_PRRC = 4
                                        				AND NR_SEQ_CADASTRO_COSO <> 8074
                                        				AND TP_CADASTRO_CACH <> 1 
                                        GROUP BY 
                                        				NR_SEQ_PRODUTO_CESO
                                        ORDER BY total desc LIMIT 10;";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    while($row = mysql_fetch_row($st)){
                                        ?>
                                        <tr>
                                            <td><?php echo $row[0];?>/<?php echo $row[1];?></td>
                                            <td>&nbsp;</td>
                                            <td><?php echo $row[2];?></td>
                                            <td>&nbsp;</td>
                                            <td><strong><?php echo $row[3];?></strong></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </table>
                            </td>
                        </tr>
                    </table>   
             	</div>
            

                <script>
				  defineAba("abaVer","pagar");
			
				  <?php
				  
						echo "defineAbaAtiva(\"abaVer\");";
			
				  ?>
                </script>
                </div>	 <!-- /abas --></div>
				</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>

<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>
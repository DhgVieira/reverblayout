<?php
include 'auth.php';
include 'lib.php';

$PHP_SELF = "producao.php";

$pagina = request("pagina");
$pgvolta = request("pg");
$idp = request("idp");

$num_por_pagina = 20;

if (!$pagina) {
	$pagina = 1;
}
$primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;

$html = "";

include 'topo.php';
?>
<script type="text/javascript">
    function EnviaEmail(){
        
    }
</script>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">ESTOQUE</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Previsão de Produção</li>
                      <li style="width: 500px;"><table><tr><td width=50 bgcolor="#78ff78">&nbsp;</td><td align=left>Saldo Suficiente</td><td width=50 bgcolor="#fffe95">&nbsp;</td><td align=left>Iniciar Produção</td><td width=50 bgcolor="#ffa7a7">&nbsp;</td><td align=left>Saldo Insuficiente</td></tr></table></li>
                    </ul>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td align="left" colspan="3">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
                <div id="abas">
                   <div id="Ver">
                   <form id="frmhtml" name="frmhtml" action="producao_mail.php" method="post" target="_blank">
                   <table width="880">
                    	<tr>
                        	<?php 
							$desc = request("desc");
							
							?>
                        	<td align="left">&nbsp;&nbsp;&nbsp;<a target="_blank" href="producao_imp.php?pagina=<?php echo $pagina; ?>"><img src="img/ico_imprimir.gif" width="75" height="30" /></a></td>
                            <td align="left">&nbsp;&nbsp;&nbsp;
                                <strong>E-mail:</strong> <input style="width:120px;height:14px;" class="frm_pesq" type="text" name="email" id="email" />
                                <input name="Enviar Email" type="submit" value="Enviar Email" align="absmiddle" />
                            </td></form>
                            <form action="producao.php?pagina=<?php echo $pagina; ?>" method="post" name="frm">
                            <td height="20" align="right" valign="middle">
                                <strong>Procurar por:</strong>
                                <input style="width:120px;height:14px;" class="frm_pesq" type="text" name="desc" id="desc" value="<?php echo $desc; ?>" />
                                <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                            </td></form>
                        </tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                    </table>
                   
                    <ul class="compras">
						<?php
						  $sqlo = "select NR_SEQ_PRODUTO_PORC from producao_fora order by NR_SEQ_PRODOUT_PORC";
                          $sto = mysql_query($sqlo);
                          $fora = "";
	   					  if (mysql_num_rows($sto) > 0) {
					  	    while($rowo = mysql_fetch_row($sto)) {
					  	        $fora .= $rowo[0].",";
                            }   
                          }
                          if (strlen($fora)>0){
                            $fora = substr($fora,0,strlen($fora)-1);
                          }
                          
                          $sql = "select NR_SEQ_PRODUTO_PRRC, CAST((DATEDIFF(SYSDATE(),DT_CADASTRO_PRRC)/30) as UNSIGNED), sum(NR_QTDE_ESRC) as total,
                                DS_PRODUTO2_PRRC, DS_EXT_PRRC
                        		from produtos, estoque WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_LOJAS_PRRC = 1 ";
                          if ($desc){
                              $sql .= "AND (DS_PRODUTO2_PRRC like '%$desc%' or DS_PRODUTO2_PRRC like '%".utf8_decode($desc)."%' or DS_PRODUTO2_PRRC like '%".utf8_encode($desc)."%') ";
                          }else{
                              //$sql .= "AND NR_SEQ_PRODUTO_PRRC in (4658,4510,497,2195,2168,4540,
//                                    4675,4655,525,2190,4654,2313,1912,2180,1913,621,2340,4638,2192,2324,4647,
//                                    2166,4536,1755,4606,2473,4936,1759,4621,4906,2450,2394,716,4669,4641,
//                                    4938,4614,4921,498,830,4652,4629,4988,2019,2296,4951,4922,2167,4621,2168,4988,2166,
//                            4638,2165,2164,4904,4645,1916,1912,4688,2331,2044,2029,1755,
//                            1697,1566,1559,554,536,43,4951,4900,4896,4738,4723,4633,
//                            2296,1749,181,179,4945,4905,4898,2212,4680,2181,1787,4644,
//                            2339,2180,1530,1564,1524,4636,1913,1917,4907,4906,4580,4582,
//                            4895,2313,525,559,314,313,4683,2337,1568,873,65,2019,2018,
//                            2048,1699,516,303,62,4646,2342,2341,2340,304,2367,2366) ";
                              $sql .= " and NR_SEQ_TIPO_PRRC = 6 and DS_CLASSIC_PRRC = 'N' ";
                          }
                          
                          if ($fora){
                            $sql .= " AND NR_SEQ_PRODUTO_PRRC not in ($fora) ";
                          }
                               
                          $sql .= " GROUP BY NR_SEQ_PRODUTO_PRRC ORDER BY NR_TEMPLIXO_PRRC desc LIMIT $primeiro_registro, $num_por_pagina";
    					  
                          $st = mysql_query($sql);
	   					  if (mysql_num_rows($st) > 0) {
					  	    while($row = mysql_fetch_row($st)) {
							 $id_produto   = $row[0];
                             $meses_ativo  = $row[1];
                             $ds_produto   = $row[3];
                             $ds_ext       = $row[4];
                             $saldo_atual  = $row[2];
                             
                             if ($meses_ativo >= 12){
                                $meses_ativo = 12;
                             }
                             if ($meses_ativo == 0) $meses_ativo = 1;
                             
                             $totais = array();
                             $y=0;
                             
                             $mesesadiante=date("m");
                             $mesesadiante = $mesesadiante + 3;
                             
                             for ($f=date("m");$f<=$mesesadiante;$f++){
                                $totais[$y] = 0;
                                $y++;
                             }
                             
                             $sql2 = "SELECT SUM(NR_QTDE_CESO) AS total, DS_TAMANHO_TARC, NR_SEQ_TAMANHO_CESO
                                      from cestas, compras, produtos, tamanhos WHERE 
                    				  NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND 
                    				  NR_SEQ_TAMANHO_CESO = NR_SEQ_TAMANHO_TARC
                    				  AND ST_COMPRA_COSO <> 'C' AND DT_COMPRA_COSO > DATE_SUB(SYSDATE(), INTERVAL $meses_ativo MONTH)
                    				  AND NR_SEQ_CADASTRO_COSO <> 8074
                                      AND NR_SEQ_PRODUTO_CESO = $id_produto
                                      GROUP BY NR_SEQ_TAMANHO_CESO order by NR_ORDEM_TARC";
                            $st2 = mysql_query($sql2);
    	   					if (mysql_num_rows($st2) >= 0) {
    					  	      echo "<li style=\"width: 1000px;\">";
                                  $html_linha = "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"2\" style=\"font:11px Tahoma, Helvetica, sans-serif;\">";
                                  $html_linha .= "<tr><td valign=top align=center width=70><img src=\"http://www.reverbcity.com/arquivos/uploads/produtos/".$id_produto.".$ds_ext\" width=\"60\" border=\"0\" /><br />";
                                  echo "<input type=button onclick=\"document.location.href='producao_rem.php?idp=$id_produto&pg=$pagina';\" value='Remover'>";
                                  $html_linha .= "</td><td valign=top>";
                                  $html_linha .= "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"2\">";
                                  $montarest = 6+(13-date("m"));
                                  $html_linha .= "<tr><td colspan=6 height=20><strong>$ds_produto</strong></td><td bgcolor=#DADADA colspan=".($montarest+2)." align=center><strong>Estimativa de falta do produto (Mensal)</strong></td></tr>";
                                  $html_linha .= "<tr>";
                                  $html_linha .= "  <td align=\"left\"><strong>Tamanho</strong></td>";
                                  $html_linha .= "  <td align=\"center\" width=\"50\"><strong>Vendas</strong></td>";
                                  $html_linha .= "  <td align=\"center\" width=\"50\"><strong>Mêses</strong></td>";
                                  $html_linha .= "  <td align=\"center\" width=\"50\"><strong>Média/Mês</strong></td>";
                                  $html_linha .= "  <td align=\"center\" width=\"80\"><strong>Saldo Atual</strong></td>";
                                  $html_linha .= "  <td align=\"center\" width=\"80\"><strong>Tempo.Prod.</strong></td>";
                                  //echo "  <td align=\"center\" width=\"80\"><strong>Previsão</strong></td>";
                                  for ($f=date("m");$f<=$mesesadiante;$f++){
                                     $most = 0;
                                     if($f > 12){
                                        $most = $f-12;
                                     }else{
                                        $most = $f;
                                     }
                                     $html_linha .= "  <td align=\"center\" width=\"50\"><strong>".str_pad($most,2,"0",STR_PAD_LEFT)."</strong></td>";
                                  }
                                  $html_linha .= "</tr>";
                                  echo $html_linha;
                                  $html .= $html_linha;
                                  while($row2 = mysql_fetch_row($st2)) {
 							      $ds_tama   = $row2[1];
                                  $nr_qtde   = $row2[0];
                                  $nrseq_ta  = $row2[2];
                                  $meses_saldo = 0;
                                  $mediames = 0;
                                  
                                  $saldoatual = SaldoTamanho($id_produto, $nrseq_ta);
                                  
                                  $mediames = $nr_qtde/$meses_ativo;
                                  
                                  $meses_saldo = ceil($saldoatual/$mediames);
                                  $baixames = $mediames;
						
                                $html_linha2 = "<tr>";
                                $html_linha2 .= "    <td align=\"left\">$ds_tama</td>";
                                $html_linha2 .= "    <td align=\"center\" width=\"50\">$nr_qtde</td>";
                                $html_linha2 .= "    <td align=\"center\" width=\"50\">$meses_ativo</td>";
                                $html_linha2 .= "    <td align=\"center\" width=\"50\">".number_format($mediames,3,",","")."</td>";
                                $html_linha2 .= "    <td align=\"center\" width=\"80\">$saldoatual</td>";
                                $html_linha2 .= "    <td align=\"center\" width=\"80\">50 dias</td>";
                                //$html_linha .= "    <!--<td align=\"center\" width=\"80\">".number_format(($saldoatual/$mediames),2,",","")."</td>-->";
                                   
                                    $x=1;
                                    for ($f=date("m");$f<=$mesesadiante;$f++){
                                        $meses_saldo = $meses_saldo - $baixames;
                                        
                                        $cortd = " bgcolor=\"#fffe95\"";
                                        
                                        if ($meses_saldo < 0){
                                            $cortd = " bgcolor=\"#ffa7a7\"";   
                                        }else if (($meses_saldo - $baixames) < 1){
                                            $cortd = " bgcolor=\"#fffe95\"";
                                        }
                                        
                                        if (($meses_saldo - ($baixames*2)) >= 0){
                                            $cortd = " bgcolor=\"#78ff78\"";
                                        }
                                        
                                        
                                        $html_linha2 .= "  <td$cortd align=\"center\" width=\"50\">".number_format($meses_saldo,2,",","")."</td>";
                                        $totais[$x-1] = $totais[$x-1] + ($meses_saldo*-1);
                                        $x++;
                                    }
                                    
                                    $html_linha2 .= "</tr>";
                                    echo $html_linha2;
                                    $html .= $html_linha2;
                                  }
                                  
                                  $html_linha3 = "<tr bgcolor=#DADADA><td colspan=4>&nbsp;</td><td align=center><strong>$saldo_atual</strong></td><td>&nbsp;</td>";
                                  $y=0;
                                  for ($f=date("m");$f<=$mesesadiante;$f++){
                                    $produzir = $totais[$y];
                                    if ($produzir <= 0) $produzir = 0;
                                    $html_linha3 .= "  <td align=\"center\" width=\"50\">".number_format($produzir,0,",","")."</td>";
                                    $y++;
                                  }
                                  $html_linha3 .= "</tr></table></td></tr></table>";
                                  echo $html_linha3;
                                  echo "</li>";
                                  $html .= $html_linha3;
                                }
							}
						  }
						 
						?>
                      </ul>
                      <ul class="paginacao2" style="width: 1000px; clear: both;">
						<?php
                        $consulta = "select NR_SEQ_PRODUTO_PRRC, CAST((DATEDIFF(SYSDATE(),DT_CADASTRO_PRRC)/30) as UNSIGNED), sum(NR_QTDE_ESRC) as total,
                                DS_PRODUTO2_PRRC, DS_EXT_PRRC
                        		from produtos, estoque WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_LOJAS_PRRC = 1 ";
                        if ($desc){
                             $consulta .= "AND (DS_PRODUTO2_PRRC like '%$desc%' or DS_PRODUTO2_PRRC like '%".utf8_decode($desc)."%' or DS_PRODUTO2_PRRC like '%".utf8_encode($desc)."%') ";
                        }else{
                            // $consulta .= "AND NR_SEQ_PRODUTO_PRRC in (4658,4510,497,2195,2168,4540,
//                                    4675,4655,525,2190,4654,2313,1912,2180,1913,621,2340,4638,2192,2324,4647,
//                                    2166,4536,1755,4606,2473,4936,1759,4621,4906,2450,2394,716,4669,4641,
//                                    4938,4614,4921,498,830,4652,4629,4988,2019,2296,4951,4922,2167,4621,2168,4988,2166,
//                            4638,2165,2164,4904,4645,1916,1912,4688,2331,2044,2029,1755,
//                            1697,1566,1559,554,536,43,4951,4900,4896,4738,4723,4633,
//                            2296,1749,181,179,4945,4905,4898,2212,4680,2181,1787,4644,
//                            2339,2180,1530,1564,1524,4636,1913,1917,4907,4906,4580,4582,
//                            4895,2313,525,559,314,313,4683,2337,1568,873,65,2019,2018,
//                            2048,1699,516,303,62,4646,2342,2341,2340,304,2367,2366) ";
                            $consulta .= " and NR_SEQ_TIPO_PRRC = 6 and DS_CLASSIC_PRRC = 'N' ";
                        }   
                        if ($fora){
                            $consulta .= " AND NR_SEQ_PRODUTO_PRRC not in ($fora) ";
                          }  
                        $consulta .= " GROUP BY NR_SEQ_PRODUTO_PRRC";
                        
                       
                        
                        $st = mysql_query($consulta);
				        $total_usuarios = mysql_num_rows($st);
                        

                        $total_paginas = $total_usuarios/$num_por_pagina;
                        $prev = $pagina - 1;
                        $next = $pagina + 1;
                        if ($pagina > 1) {
                        $prev_link = "<li><a href=\"$PHP_SELF?pagina=$prev&desc=$desc\">Anterior</a></li>";
                        } else { 
                        $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas > $pagina) {
                        $next_link = "<li><a href=\"$PHP_SELF?pagina=$next&desc=$desc\">Proxima</a></li>";
                        } else {
                        $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas = ceil($total_paginas);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas; $x++) {
                          if ($x==$pagina) { 
                            $painel .= "<li> <strong>$x</strong> </li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?pagina=$x&desc=$desc\">[$x]</a></li>";
                          }
                        }
                        
                        
                        echo "$prev_link";
                        echo "$painel";
                        echo "$next_link";
						
						
                        ?>                
                    </ul> <!-- /paginacao -->
                    <input type="hidden" name="html" value="<?php echo htmlspecialchars($html); ?>" />
                    </form>   
                  	</div>	<!-- Ver -->
                                     
                    <script>
                      defineAba("abaVer","Ver");
                    </script>
                    
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>
              
<?php 
function SaldoTamanho($nrprod, $nrtam){
    $sqlt = "select NR_QTDE_ESRC from estoque where NR_SEQ_PRODUTO_ESRC = $nrprod and NR_SEQ_TAMANHO_ESRC = $nrtam";
    $stt = mysql_query($sqlt);
    $saldo = 0;
    if (mysql_num_rows($stt) > 0) {
        $rowt = mysql_fetch_row($stt);
        $saldo = $rowt[0];
    }
    return $saldo;
}
include 'rodape.php'; ?>
<?php
include 'auth.php';
include 'lib.php';

$pagina = request("pagina");
$idp = request("idp");

$num_por_pagina = 20;

if (!$pagina) {
	$pagina = 1;
}
$primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<title>Reverbcity - Previs&atilde;o de Produ&ccedil;&atilde;o</title>
    <link href="css/estilos.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="scripts/abas.js"></script>
    <link href="css/aba.css" media="all" rel="stylesheet" type="text/css" />
</head>

<body onload="self.print();self.close();">
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">PRODU&Ccedil;&Atilde;O</li>
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
                              $sql .= "AND NR_SEQ_PRODUTO_PRRC in (4658,4510,497,2195,2168,4540,
                                    4675,4655,525,2190,4654,2313,1912,2180,1913,621,2340,4638,2192,2324,4647,
                                    2166,4536,1755,4606,2473,4936,1759,4621,4906,2450,2394,716,4669,4641,
                                    4938,4614,4921,498,830,4652,4629,4988,2019,2296,4951,4922,2167,4621,2168,4988,2166,
                            4638,2165,2164,4904,4645,1916,1912,4688,2331,2044,2029,1755,
                            1697,1566,1559,554,536,43,4951,4900,4896,4738,4723,4633,
                            2296,1749,181,179,4945,4905,4898,2212,4680,2181,1787,4644,
                            2339,2180,1530,1564,1524,4636,1913,1917,4907,4906,4580,4582,
                            4895,2313,525,559,314,313,4683,2337,1568,873,65,2019,2018,
                            2048,1699,516,303,62,4646,2342,2341,2340,304,2367,2366) ";
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
                                      GROUP BY NR_SEQ_TAMANHO_CESO order by total desc;";
                            $st2 = mysql_query($sql2);
    	   					if (mysql_num_rows($st2) >= 0) {
    					  	      echo "<li style=\"width: 1000px;\">";
                                  echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"2\">";
                                  echo "<tr><td valign=top align=center width=70><img src=\"../images/produtos/".$id_produto."p.$ds_ext\" width=\"60\" border=\"0\" /><br /><input type=button onclick=\"document.location.href='producao_rem.php?idp=$id_produto&pg=$pagina';\" value='Remover'></td><td valign=top>";
                                  echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"2\">";
                                  $montarest = 6+(13-date("m"));
                                  echo "<tr><td colspan=6 height=20><strong>$ds_produto</strong></td><td bgcolor=#DADADA colspan=".($montarest+2)." align=center><strong>Estimativa de falta do produto (Mensal)</strong></td></tr>";
                                  echo "<tr>";
                                  echo "  <td align=\"left\"><strong>Tamanho</strong></td>";
                                  echo "  <td align=\"center\" width=\"50\"><strong>Vendas</strong></td>";
                                  echo "  <td align=\"center\" width=\"50\"><strong>Mêses</strong></td>";
                                  echo "  <td align=\"center\" width=\"50\"><strong>Média/Mês</strong></td>";
                                  echo "  <td align=\"center\" width=\"80\"><strong>Saldo Atual</strong></td>";
                                  echo "  <td align=\"center\" width=\"80\"><strong>Tempo.Prod.</strong></td>";
                                  //echo "  <td align=\"center\" width=\"80\"><strong>Previsão</strong></td>";
                                  for ($f=date("m");$f<=$mesesadiante;$f++){
                                     $most = 0;
                                     if($f > 12){
                                        $most = $f-12;
                                     }else{
                                        $most = $f;
                                     }
                                     echo "  <td align=\"center\" width=\"50\"><strong>".str_pad($most,2,"0",STR_PAD_LEFT)."</strong></td>";
                                  }
                                  echo "</tr>";
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
							?>
                                <tr>
                                    <td align="left"><?php echo $ds_tama; ?></td>
                                    <td align="center" width="50"><?php echo $nr_qtde; ?></td>
                                    <td align="center" width="50"><?php echo $meses_ativo; ?></td>
                                    <td align="center" width="50"><?php echo number_format($mediames,3,",",""); ?></td>
                                    <td align="center" width="80"><?php echo $saldoatual; ?></td>
                                    <td align="center" width="80">50 dias</td>
                                    <!--<td align="center" width="80"><?php echo number_format(($saldoatual/$mediames),2,",",""); ?></td>-->
                                    <?php
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
                                        
                                        
                                        echo "  <td$cortd align=\"center\" width=\"50\">".number_format($meses_saldo,2,",","")."</td>";
                                        $totais[$x-1] = $totais[$x-1] + ($meses_saldo*-1);
                                        $x++;
                                    }
                                    ?>
                                </tr>
      	<?php
                                  }
                                  echo "<tr bgcolor=#DADADA><td colspan=4>&nbsp;</td><td align=center><strong>$saldo_atual</strong></td><td>&nbsp;</td>";
                                  $y=0;
                                  for ($f=date("m");$f<=$mesesadiante;$f++){
                                    $produzir = $totais[$y];
                                    if ($produzir <= 0) $produzir = 0;
                                    echo "  <td align=\"center\" width=\"50\">".number_format($produzir,0,",","")."</td>";
                                    $y++;
                                  }
                                  echo "</tr></table></td></tr></table></li>";
                                }
							}
						  }
						 
						?>
                      </ul>
                      
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
?>
</body>
</html>
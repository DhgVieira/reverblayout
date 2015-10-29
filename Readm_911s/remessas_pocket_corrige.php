<?php
include 'lib.php';
include 'auth.php';

$str = "select NR_SEQ_COMPRA_COSO, VL_FRETECUSTO_COSO, VL_TOTAL_COSO from compras where        
	ST_COMPRA_COSO <> 'C' AND NR_SEQ_LOJA_COSO = 1 and
    NR_SEQ_CADASTRO_COSO = 22364";
$st = mysql_query($str);
if (mysql_num_rows($st) > 0) {
    $para = false;
    while($row = mysql_fetch_row($st)) {
		$nrseqcompra = $row[0];
        $frete = $row[1];
        $totalantes = $row[2];
        
        $sql2 = "SELECT VL_PRODUTO_CESO, NR_QTDE_CESO, NR_SEQ_PRODUTO_CESO, NR_SEQ_CESTA_CESO, VL_PRODUTO_PRRC,
                 VL_PRODUTO2_PRRC, NR_SEQ_TIPO_PRRC, NR_SEQ_COMPRA_CESO, NR_PESOGRAMAS_PRRC
                 FROM cestas, produtos
			        WHERE NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND NR_SEQ_COMPRA_CESO = $nrseqcompra";
		$st2 = mysql_query($sql2);
		
		$vl_geral = 0;
			
		if (mysql_num_rows($st2) > 0) {
			$x = 0;
            $pesotot = 0;
			while($row2 = mysql_fetch_row($st2)) {
				$vl_total = 0;
				
				$vl_prod_cesta = $row2[0];
				$qt_prod	   = $row2[1];
                $id_prod	   = $row2[2];
                $id_cesta	   = $row2[3];
                $vl_prod       = $row2[4]; 
                $vl_custo      = $row2[5];
                $tipo          = $row2[6];
                $idCompra      = $row2[7]; 
                $peso          = $row2[8];
                
                $pesotot += number_format($peso,0,".","")*$qt_prod;
                
                if (!$vl_custo || $vl_custo == 0){
                    $vl_custo = $vl_prod * 40 / 100;
                }
                
                //if ($vl_prod_cesta > $vl_custo){
//                    $str = "update cestas set VL_PRODUTO_CESO = ".$vl_custo." WHERE NR_SEQ_CESTA_CESO = ".$id_cesta;
//                    $stcesta = mysql_query($str);
//                    echo $str."<br />";
//                }else{
//                    echo "vl_prod_cesta: ".$vl_prod_cesta." - vl_custo: $vl_custo<br />"; 
//                }

                $str = "update cestas set VL_PRODUTO_CESO = ".$vl_custo." WHERE NR_SEQ_CESTA_CESO = ".$id_cesta;
                $stcesta = mysql_query($str);
                
				$vl_total += ($vl_custo*$qt_prod);
				$vl_geral += $vl_total;
            }
        }
        
        $pesotot = number_format($pesotot/1000,2,".","");
        
       // if (!$frete || $frete == 0){
//            $sqlf = "SELECT 'SP' FROM fretes where NR_FAIXAPESO_FRRC >= ".$pesotot." order by NR_FAIXAPESO_FRRC limit 1";
//            $stf = mysql_query($sqlf);
//            if (mysql_num_rows($stf) > 0) {
//                $rowf = mysql_fetch_row($stf);
//                $frete = $rowf[0];
//                $str = "UPDATE compra SET VL_FRETECUSTO_COSO = $frete, VL_FRETE_COSO = $frete where NR_SEQ_COMPRA_COSO = $nrseqcompra";
//               // echo $str."<br />";
//            }else{
//                $frete = 84.54;
//                $str = "UPDATE compra SET VL_FRETECUSTO_COSO = $frete, VL_FRETE_COSO = $frete where NR_SEQ_COMPRA_COSO = $nrseqcompra";
//              //  echo $str."<br />";
//            }
//        }
        
        $vl_geral += $frete;
        
        echo "<br />vlr anterior da compra: ".$totalantes."<br />";
        
        $str = "UPDATE compras SET VL_TOTAL_COSO = $vl_geral where NR_SEQ_COMPRA_COSO = $nrseqcompra";
        $stcompra = mysql_query($str);
        echo $str."<br />";
        //echo $idCompra." - ".$id_prod." - ".$vl_prod." - ".$vl_prod_cesta."<br />";
                    //$para = true;
        
        //if ($para) exit();
        //exit();
    }
}

mysql_close($con); 
?>
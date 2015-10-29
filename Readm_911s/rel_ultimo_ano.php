<?php 
include '../Readm_911s/lib.php';
include '../Readm_911s/auth.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" />
        <meta charset="UTF-8">
        <title>Ultimos 12 meses</title>
        <style>
            body {
                font-family:Calibri, Helvetica, sans-serif;
                font-size: 14px;
            }
        </style>
        <style>
            #shop .produto {
                width:120px;
                float:left;
                height:171px;
                background:#FFFFFF;
                border: solid 1px #6b4922;
                padding: 4px;
                margin: 0 0 10px 0;
            }

                #shop .produto img {
                    margin:0;
                    padding:0;
                }

            #shop .preco-produto {
                float:left;
                width:30px;
                margin:10px 0 0 0;
                padding:0;
            }

            #shop .desc-produto {
                float:left;
                margin: 10px 0 0 10px;
                padding:0;
            }
        </style>
    </head>
    <body>
        <?php 
        $tip = 4;
        $cat = request("cat");
        $tam = request("tam");
        $mus = request("mus");
        $tam2 = request("tam2");

        if ($tam2){ $tip ="";
                    $cat = "";
                    $tam="";
                    $mus="";
        }
        ?>

        <div id="geral" style="background-color: white;">
      
        <div id="corpo" style="background-color: white;">
        
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <span style="font-size: 30px;">Relatório de vendas <br> 01/10/2013 até 31/10/2014</span>
                </td>
            </tr>
            <tr>
                <td valign="top" align="center">
                    <div id="shop" style="background-color: white;">
                        
                        <div id="listaprodutos" style="width: 990px;">
                
                            <?php
                            $totalest = 0;
                            
                            $num_por_pagina = 1000;
                            if (!$pagina) {
                               $pagina = 1;
                            }
                            $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
                                    
                             $sql = "SELECT 
                                        COUNT(nr_seq_produto_prrc),
                                        NR_SEQ_PRODUTO_PRRC,
                                        DS_PRODUTO2_PRRC
                                    FROM
                                        produtos
                                            INNER JOIN
                                        cestas ON NR_SEQ_PRODUTO_CESO = nr_seq_produto_prrc
                                            INNER JOIN
                                        compras ON NR_SEQ_COMPRA_CESO = nr_seq_compra_coso
                                    WHERE
                                        st_compra_coso NOT IN ('C' , 'A')
                                            AND DATE_FORMAT(dt_compra_coso, '%Y-%m-%d') >= '2013-10-01'
                                    GROUP BY NR_SEQ_PRODUTO_PRRC
                                    ORDER BY COUNT(nr_seq_produto_prrc) DESC";
       
                            
                            $st = mysql_query($sql);
                            if (mysql_num_rows($st) > 0) {
                                $marg_es = 10;
                                $marg_to = 0;
                                $totp = 0;
                                $qtde_total = 0;

                                $maisVendidos = array();
                                $contador = 0;

                                while($row = mysql_fetch_row($st)) {
                                    $qtd_prod      = $row[0];
                                    $id_prod       = $row[1];
                                    $ds_prod       = $row[2];

                                    if($contador <= 30){
                                        $maisVendidos[] = $id_prod;
                                    }

                                    $contador++;

                                    $select_fotos = "SELECT
                                              NR_SEQ_FOTO_FORC,
                                              NR_SEQ_PRODUTO_FORC,
                                              DS_EXT_FORC
                                      FROM
                                         fotos
                                      WHERE
                                         NR_SEQ_PRODUTO_FORC = ". $id_prod ."
                                      ORDER BY
                                              NR_ORDEM_FORC ASC
                                      LIMIT 2";
                                      $stFoto = mysql_query($select_fotos);
                                      $fotoRow = mysql_fetch_row($stFoto);
                                    ?>
                                    <div class="produto"  style="margin: 0 0 7px 6px;position: relative; z-index:1; height: 200px;width: 160px;text-align: center;">
                                    <div style="text-align: center;"><strong><?php echo $qtd_prod ?></strong></div>
                                      
                                      <img src="/thumb/fotosprodutos/1/120/120/<?php echo $fotoRow[0]; ?>.<?php echo $fotoRow[2]; ?>" border="0" alt="<?php echo $ds_prod; ?>" width="120" />
                                      <div>                                        
                                        <p>
                                            <?php echo utf8_encode($ds_prod); ?>

                                        </p>
                                      </div>
                                      <div style="clear: both;">

                             <br />         
                           </div>
                                  </div>
                                  
                                  <?php
                                }
                                
                            }
                         
                            ?>           
                       </div> 
                        
                    </div>
                </td>
            </tr>
        </table>
      
      <!-- Rodapé -->
      
</div>
    <div style="width: 80%; margin-left: auto; margin-right: auto;">
        <?php
            $maisVendidos = implode(', ', $maisVendidos);
            for($m = 12; $m >= 0; $m--){
                $selectPorMes = "SELECT 
                                    COUNT(nr_seq_produto_prrc),
                                    NR_SEQ_PRODUTO_PRRC,
                                    DS_PRODUTO2_PRRC,
                                    DATE_FORMAT(DATE_SUB('2014-10-31', INTERVAL ". $m ." MONTH), '%m/%Y')
                                FROM
                                    produtos
                                        INNER JOIN
                                    cestas ON NR_SEQ_PRODUTO_CESO = nr_seq_produto_prrc
                                        INNER JOIN
                                    compras ON NR_SEQ_COMPRA_CESO = nr_seq_compra_coso
                                WHERE
                                    st_compra_coso NOT IN ('C' , 'A')
                                        AND DATE_FORMAT(dt_compra_coso, '%Y-%m') = DATE_FORMAT(DATE_SUB('2014-10-31', INTERVAL ". $m ." MONTH), '%Y-%m')
                                        AND NR_SEQ_PRODUTO_PRRC IN(". $maisVendidos .")
                                GROUP BY NR_SEQ_PRODUTO_PRRC
                                ORDER BY COUNT(nr_seq_produto_prrc) DESC";
                $stMes = mysql_query($selectPorMes);
                $produtoMes = mysql_fetch_row($stMes);
                mysql_data_seek($stMes, 0);
                ?>
                <table align="center" valign="top" style="display: inline-block; margin-bottom: 65px;">
                    <tr>
                        <td colspan="2" align="center" style="border: 1px solid black;"><span style="font-size: 25px;"><?php echo $produtoMes[3]; ?></span></td>
                    </tr>   
                    <tr>
                        <td style="border: 1px solid black;"><b>Quantidade</b></td>
                        <td style="border: 1px solid black;"><b>Produto</b></td>
                    </tr>
                <?php
                while($produtoMes = mysql_fetch_row($stMes)){
                    $select_fotos = "SELECT
                              NR_SEQ_FOTO_FORC,
                              NR_SEQ_PRODUTO_FORC,
                              DS_EXT_FORC
                      FROM
                         fotos
                      WHERE
                         NR_SEQ_PRODUTO_FORC = ". $produtoMes[1] ."
                      ORDER BY
                              NR_ORDEM_FORC ASC
                      LIMIT 2";

                      $stFoto = mysql_query($select_fotos);
                      $fotoRow = mysql_fetch_row($stFoto);
                    ?>
                        <tr>
                            <td style="border: 1px solid black;">
                                <?php echo $produtoMes[0]; ?>
                            </td>
                            <td style="border: 1px solid black;">
                                <img src="/thumb/fotosprodutos/1/40/40/<?php echo $fotoRow[0]; ?>.<?php echo $fotoRow[2]; ?>" border="0" alt="<?php echo $ds_prod; ?>" width="40" />
                                <?php echo utf8_encode($produtoMes[2]); ?>
                            </td>
                        </tr>
                    <?php
                }
                ?>
                </table>
                <?php
            }
        ?>
    </div>
    </body>
</html>
<?php mysql_close($con); ?>
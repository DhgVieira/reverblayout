<?php 
include '../Readm_911s/lib.php';
include '../Readm_911s/auth.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" />
        <meta charset="UTF-8">
        <title>Ultimos 6 meses - Sale</title>
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
            for($m = 6; $m >= 0; $m--){
                $selectPorMes = "SELECT 
								    SUM(vl_total_coso) AS valor,
								    COUNT(*) AS quantidade,
								    DATE_FORMAT(DATE_SUB(NOW(), INTERVAL ".$m." MONTH), '%m/%Y') as data,
								    (SELECT 
								            COUNT(*)
								        FROM
								            compras
								                INNER JOIN
								            cestas ON nr_seq_compra_ceso = nr_seq_compra_coso
								                INNER JOIN
								            produtos ON nr_seq_produto_prrc = nr_seq_produto_ceso
								        WHERE
								            st_compra_coso NOT IN ('C' , 'A')
								                AND NR_SEQ_TIPO_PRRC NOT IN (4 , 24, 139, 140, 65, 59)
								                AND TP_DESTAQUE_PRRC = 2
								                AND DATE_FORMAT(dt_compra_coso, '%Y-%m') = DATE_FORMAT(DATE_SUB(NOW(),
								                        INTERVAL ".$m." MONTH),
								                    '%Y-%m')
								                AND DS_GENERO_PRRC = 'M') AS masc,
								    (SELECT 
								            COUNT(*)
								        FROM
								            compras
								                INNER JOIN
								            cestas ON nr_seq_compra_ceso = nr_seq_compra_coso
								                INNER JOIN
								            produtos ON nr_seq_produto_prrc = nr_seq_produto_ceso
								        WHERE
								            st_compra_coso NOT IN ('C' , 'A')
								                AND NR_SEQ_TIPO_PRRC NOT IN (4 , 24, 139, 140, 65, 59)
								                AND TP_DESTAQUE_PRRC = 2
								                AND DATE_FORMAT(dt_compra_coso, '%Y-%m') = DATE_FORMAT(DATE_SUB(NOW(),
								                        INTERVAL ".$m."  MONTH),
								                    '%Y-%m')
								                AND DS_GENERO_PRRC = 'F') AS fem
								FROM
								    (SELECT 
								        vl_total_coso
								    FROM
								        compras
								    INNER JOIN cestas ON nr_seq_compra_ceso = nr_seq_compra_coso
								    INNER JOIN produtos ON nr_seq_produto_prrc = nr_seq_produto_ceso
								    WHERE
								        st_compra_coso NOT IN ('C' , 'A')
								            AND NR_SEQ_TIPO_PRRC NOT IN (4 , 24, 139, 140, 65, 59)
								            AND TP_DESTAQUE_PRRC = 2
								            AND DATE_FORMAT(dt_compra_coso, '%Y-%m') = DATE_FORMAT(DATE_SUB(NOW(), INTERVAL ".$m." MONTH), '%Y-%m')
								    GROUP BY nr_seq_compra_coso) AS tb
								";
                $stMes = mysql_query($selectPorMes);
                $produtoMes = mysql_fetch_row($stMes);
                mysql_data_seek($stMes, 0);
                ?>
                <table align="center">
		            <tr align="center">
		                <td colspan="4"><strong style="font-size: 25px;"><?php echo $produtoMes[2]; ?></strong></td>
		            </tr>
		            <tr bgcolor="silver">
		                <td>Valor</td>
		                <td>Quantidade</td>
		                <td>Masculina</td>
		                <td>Feminina</td>
		                <!-- <td>Valor</td> -->
		            </tr>   
		            <?php
		                $total = $produtoMes[3] + $produtoMes[4];
		                $porFem = (($produtoMes[4] / $total) * 100);
		                $porMasc = (($produtoMes[3] / $total) * 100);
		            ?>
		            <tr bgcolor="#DFDFDF">
		            	<td><?php echo number_format($produtoMes[0], 2, ",", "."); ?></td>
		            	<td><?php echo $produtoMes[1] ?></td>
		                <td><?php echo number_format($porFem, 2, ",", "."); ?>%</td>
		                <td><?php echo number_format($porMasc, 2, ",", "."); ?>%</td>
		            </tr>
		        </table>
                <?php
            }
        ?>
    </body>
</html>
<?php mysql_close($con); ?>
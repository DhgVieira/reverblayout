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
            for($m = 12; $m >= 0; $m--){
                $selectPorMes = "SELECT 
                                    SUM(vl_total_coso) AS valor,
                                    COUNT(*) AS quantidade,
                                    DATE_FORMAT(DATE_SUB(NOW(), INTERVAL ".$m." MONTH),
                                            '%m/%Y') AS data,
                                    DS_FORMAPGTO_COSO,
                                    NR_PARCELAS_COSO
                                FROM
                                    compras
                                WHERE
                                    st_compra_coso NOT IN ('C' , 'A')
                                        AND DATE_FORMAT(dt_compra_coso, '%Y-%m') = DATE_FORMAT(DATE_SUB(NOW(), INTERVAL ".$m." MONTH),
                                            '%Y-%m')
                                        and DS_FORMAPGTO_COSO is not null
                                GROUP BY DS_FORMAPGTO_COSO , NR_PARCELAS_COSO
                                ORDER BY DS_FORMAPGTO_COSO";
                $stMes = mysql_query($selectPorMes);
                $produtoMes = mysql_fetch_row($stMes);
                mysql_data_seek($stMes, 0);
                ?>
                <table align="center">
		            <tr align="center">
		                <td colspan="4"><strong style="font-size: 25px;"><?php echo $produtoMes[2]; ?></strong></td>
		            </tr>
		            <tr bgcolor="silver">
		                <td>Forma de pagamento</td>
                        <td>Parcelas</td>
		                <td>Pedidos</td>
		                <td>Valor</td>
		            </tr>   
                    <?php
                        while ($row = mysql_fetch_row($stMes)){
                    ?>
		            <tr bgcolor="#DFDFDF">
		            	<td><?php echo $row[3] ?></td>
		            	<td><?php echo $row[4] ?></td>
		                <td><?php echo $row[1] ?></td>
		                <td>R$ <?php echo number_format($row[0], 2, ",", "."); ?></td>
		            </tr>
                    <?php
                        }
                    ?>
		        </table>
                <?php
            }
        ?>
    </body>
</html>
<?php mysql_close($con); ?>
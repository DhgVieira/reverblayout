<?php 
include '../Readm_911s/lib.php';
include '../Readm_911s/auth.php';

$data = request('data');

if(empty($data)){
	$data = date('Y-m-d', strtotime('-1 days'));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" />
        <meta charset="UTF-8">
        <title>Produto do dia</title>
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
    	<table align="center">
            <tr align="center">
                <td colspan="6"><strong style="font-size: 25px;">Produto do dia</strong></td>
            </tr>
			<tr align="center">
	            <td colspan="6"><strong style="font-size: 19px;"><?php echo date('d/m/Y', strtotime($data)); ?></strong></td>
	        </tr>		
            <tr bgcolor="silver">
            	<td>N° compra</td>
            	<td>N° cliente</td>
            	<td>Nome</td>
                <td>Email</td>
                <td>Data</td>
                <td>Valor</td>
            </tr>
	    	<?php
	    		$selectProduto = "SELECT 
								    nr_seq_produto_barc
								FROM
								    banners_agendados
								WHERE
								    DATE_FORMAT(dt_publicacao_barc, '%Y-%m-%d') = '".$data."'";
			    $stProduto = mysql_query($selectProduto);
			    $rowProduto = mysql_fetch_row($stProduto);

	    		$selectRecuperacao = "SELECT 
									    nr_seq_compra_coso,
									    nr_seq_cadastro_caso,
									    ds_nome_caso,
									    ds_email_caso,
									    VL_TOTAL_COSO,
									    dt_compra_coso
									FROM
									    compras
									        INNER JOIN
									    cestas ON nr_seq_compra_coso = nr_seq_compra_ceso
									        INNER JOIN
									    cadastros ON nr_seq_cadastro_caso = nr_seq_cadastro_coso
									WHERE date_format(dt_compra_coso, '%Y-%m-%d') = '".$data."' and nr_seq_produto_ceso = " . $rowProduto[0] . " and vl_total_coso is not null and st_compra_coso <> 'C'";

			    $stRecuperacao = mysql_query($selectRecuperacao);
		    	while($row = mysql_fetch_row($stRecuperacao)){
	    		?>
	    			<tr bgcolor="#DFDFDF">
		            	<td><?php echo $row[0] ?></td>
		            	<td><?php echo $row[1] ?></td>
		            	<td><?php echo utf8_encode($row[2]) ?></td>
		            	<td><?php echo $row[3] ?></td>
		            	<td><?php echo date('d/m/Y', strtotime($row[5])) ?></td>
		            	<td>R$ <?php echo number_format($row[4], 2, ",", ".") ?></td>
		            </tr>  
	    		<?php
			    }
	    	?>
    	</table>
    </body>
</html>
<?php mysql_close($con); ?>
<?php 
include '../Readm_911s/lib.php';
include '../Readm_911s/auth.php';

$data = request('data');

if(!empty($data)){
	$dataInicio = date('Y-m-d', strtotime($data . ' -7 days'));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" />
        <meta charset="UTF-8">
        <title>Recuperação de carrinho</title>
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
                <td colspan="6"><strong style="font-size: 25px;">Recuperação de carrinho</strong></td>
            </tr>
            <?php 
            	if(!empty($data)){
            		?>
            			<tr align="center">
			                <td colspan="6"><strong style="font-size: 19px;"><?php echo date('d/m/Y', strtotime($dataInicio)); ?> até <?php echo date('d/m/Y', strtotime($data)); ?></strong></td>
			            </tr>		
            		<?php
            	}
            ?>
            <tr bgcolor="silver">
            	<td>N° compra</td>
            	<td>N° cliente</td>
            	<td>Nome</td>
                <td>Email</td>
                <td>Data</td>
                <td>Valor</td>
            </tr>
	    	<?php
	    		$selectRecuperacao = "SELECT 
									    nr_seq_compra_coso,
									    nr_seq_cadastro_caso,
									    ds_nome_caso,
									    ds_email_caso,
									    VL_TOTAL_COSO,
									    dt_compra_coso
									FROM
									    carrinho
									        INNER JOIN
									    compras ON nr_seq_compra_coso = compras_id
									        INNER JOIN
									    cadastros ON nr_seq_cadastro_caso = cadastros_id
									WHERE
									    ST_COMPRA_COSO <> 'C'";
			    if($dataInicio){
			    	$selectRecuperacao .= " AND DATE_FORMAT(dt_compra_coso, '%Y-%m-%d') >= '".$dataInicio ."' AND DATE_FORMAT(dt_compra_coso, '%Y-%m-%d') <= '".$data."'";
			    }

			    $selectRecuperacao .= " ORDER BY dt_compra_coso ASC";

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


        <?php
        	$selectEnviado = "SELECT 
							    COUNT(*)
							FROM
							    carrinho
							WHERE
							    email_enviado = 1";
		    if($dataInicio){
		    	$selectEnviado .= " AND DATE_FORMAT(hora, '%Y-%m-%d') >= '".$dataInicio ."' AND DATE_FORMAT(hora, '%Y-%m-%d') <= '".$data."'";
		    }

            $stEnviado = mysql_query($selectEnviado);
            $enviado = mysql_fetch_row($stEnviado);

            $selectRecuperado = "SELECT 
								    count(*), sum(vl_total_coso)
								FROM
								    carrinho
								    inner join compras on nr_seq_compra_coso = compras_id
								WHERE
								    st_compra_coso <> 'C'";
		    if($dataInicio){
		    	$selectRecuperado .= " AND DATE_FORMAT(dt_compra_coso, '%Y-%m-%d') >= '".$dataInicio ."' AND DATE_FORMAT(dt_compra_coso, '%Y-%m-%d') <= '".$data."'";
		    }

            $stRecuperado = mysql_query($selectRecuperado);
            $recuperado = mysql_fetch_row($stRecuperado);

            $selectLido = "SELECT 
							    COUNT(*)
							FROM
							    carrinho
							WHERE
							    email_lido = 1";
		    if($dataInicio){
		    	$selectLido .= " AND DATE_FORMAT(hora, '%Y-%m-%d') >= '".$dataInicio ."' AND DATE_FORMAT(hora, '%Y-%m-%d') <= '".$data."'";
		    }

            $stLido = mysql_query($selectLido);
            $lido = mysql_fetch_row($stLido);

            $selectMasculino = "SELECT 
								    count(*), sum(vl_produto_ceso)
								FROM
								    carrinho
								        INNER JOIN
								    compras ON nr_seq_compra_coso = compras_id
								        INNER JOIN
								    cestas on nr_seq_compra_ceso = nr_seq_compra_coso
								    inner join
								    produtos on nr_seq_produto_prrc = nr_seq_produto_ceso
								WHERE
								    ST_COMPRA_COSO <> 'C'
								    and DS_GENERO_PRRC = 'M'";
		    if($dataInicio){
		    	$selectMasculino .= " AND DATE_FORMAT(dt_compra_coso, '%Y-%m-%d') >= '".$dataInicio ."' AND DATE_FORMAT(dt_compra_coso, '%Y-%m-%d') <= '".$data."'";
		    }
		    $selectMasculino .= " group by DS_GENERO_PRRC";

		    $stMasculino = mysql_query($selectMasculino);
		    $masculino = mysql_fetch_row($stMasculino);

		    $selectFeminino = "SELECT 
								    count(*), sum(vl_produto_ceso)
								FROM
								    carrinho
								        INNER JOIN
								    compras ON nr_seq_compra_coso = compras_id
								        INNER JOIN
								    cestas on nr_seq_compra_ceso = nr_seq_compra_coso
								    inner join
								    produtos on nr_seq_produto_prrc = nr_seq_produto_ceso
								WHERE
								    ST_COMPRA_COSO <> 'C'
								    and DS_GENERO_PRRC = 'F'";
		    if($dataInicio){
		    	$selectFeminino .= " AND DATE_FORMAT(dt_compra_coso, '%Y-%m-%d') >= '".$dataInicio ."' AND DATE_FORMAT(dt_compra_coso, '%Y-%m-%d') <= '".$data."'";
		    }

		    $selectFeminino .= " group by DS_GENERO_PRRC";

		    $stFeminino = mysql_query($selectFeminino);
		    $feminino = mysql_fetch_row($stFeminino);

		    $selectUni = "SELECT 
								    count(*), sum(vl_produto_ceso)
								FROM
								    carrinho
								        INNER JOIN
								    compras ON nr_seq_compra_coso = compras_id
								        INNER JOIN
								    cestas on nr_seq_compra_ceso = nr_seq_compra_coso
								    inner join
								    produtos on nr_seq_produto_prrc = nr_seq_produto_ceso
								WHERE
								    ST_COMPRA_COSO <> 'C'
								    and DS_GENERO_PRRC NOT IN ('F', 'M')";
		    if($dataInicio){
		    	$selectUni .= " AND DATE_FORMAT(dt_compra_coso, '%Y-%m-%d') >= '".$dataInicio ."' AND DATE_FORMAT(dt_compra_coso, '%Y-%m-%d') <= '".$data."'";
		    }

		    $selectUni .= " group by DS_GENERO_PRRC";

		    $stUni = mysql_query($selectUni);
		    $unisex = mysql_fetch_row($stUni);

		    $sexoTotal = $masculino[0] + $feminino[0] + $unisex[0];
		    $porFem = (($feminino[0] / $sexoTotal) * 100);
            $porMasc = (($masculino[0] / $sexoTotal) * 100);
            $porUni = (($unisex[0] / $sexoTotal) * 100);

            $selectNaoLido = "SELECT 
							    COUNT(*)
							FROM
							    carrinho
							WHERE
							    email_lido = 0
						    	and email_enviado = 1";
	    	if($dataInicio){
		    	$selectNaoLido .= " AND DATE_FORMAT(hora, '%Y-%m-%d') >= '".$dataInicio ."' AND DATE_FORMAT(hora, '%Y-%m-%d') <= '".$data."'";
		    }

            $stNaoLido = mysql_query($selectNaoLido);
            $naoLido = mysql_fetch_row($stNaoLido);

            $porRecuperado = (($recuperado[0] / $enviado[0]) * 100);
            $porLido = (($lido[0] / $enviado[0]) * 100);
            $porNaoLido = (($naoLido[0] / $enviado[0]) * 100);
            $porEnviado = (($enviado[0] / $enviado[0]) * 100);

            ?>
            <table align="center">
	            <tr align="center">
	                <td colspan="4"><strong style="font-size: 25px;">Totais</strong></td>
	            </tr>
	            <tr bgcolor="silver">
	            	<td></td>
	            	<td>Quantidade</td>
	            	<td>Porcentagem</td>
	                <td>Valor</td>
	            </tr>
	            <tr bgcolor="#DFDFDF">
	            	<td><strong>Emails enviado</strong></td>
	            	<td><?php echo $enviado[0] ?></td>
	            	<td><?php echo number_format($porEnviado, 2, ",", "."); ?> %</td>
	            	<td></td>
	            </tr>   
	            <tr bgcolor="#DFDFDF">
	            	<td><strong>Emails lido</strong></td>
	            	<td><?php echo $lido[0] ?></td>
	            	<td><?php echo number_format($porLido, 2, ",", "."); ?> %</td>
	            	<td></td>
	            </tr>
	            <tr bgcolor="#DFDFDF">
	            	<td><strong>Emails não lido</strong></td>
	            	<td><?php echo $naoLido[0] ?></td>
	            	<td><?php echo number_format($porNaoLido, 2, ",", "."); ?> %</td>
	            	<td></td>
	            </tr>
	            <tr bgcolor="#DFDFDF">
	            	<td><strong>Masculino</strong></td>
	            	<td><?php echo $masculino[0] ?> (produtos)</td>
	            	<td><?php echo number_format($porMasc, 2, ",", "."); ?> %</td>
	            	<td>R$ <?php echo number_format($masculino[1], 2, ",", "."); ?></td>
	            </tr>
	            <tr bgcolor="#DFDFDF">
	            	<td><strong>Feminino</strong></td>
	            	<td><?php echo $feminino[0] ?> (produtos)</td>
	            	<td><?php echo number_format($porFem, 2, ",", "."); ?> %</td>
	            	<td>R$ <?php echo number_format($feminino[1], 2, ",", "."); ?></td>
	            </tr>
	            <tr bgcolor="#DFDFDF">
	            	<td><strong>Unisex</strong></td>
	            	<td><?php echo $unisex[0] ?> (produtos)</td>
	            	<td><?php echo number_format($porUni, 2, ",", "."); ?> %</td>
	            	<td>R$ <?php echo number_format($unisex[1], 2, ",", "."); ?></td>
	            </tr>
	            <tr bgcolor="#DFDFDF">
	            	<td><strong>Compras recuperadas</strong></td>
	            	<td><?php echo $recuperado[0] ?></td>
	            	<td><?php echo number_format($porRecuperado, 2, ",", "."); ?> %</td>
	            	<td>R$ <?php echo number_format($recuperado[1], 2, ",", "."); ?></td>
	            </tr>
	        </table>
    </body>
</html>
<?php mysql_close($con); ?>
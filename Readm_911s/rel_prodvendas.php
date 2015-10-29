<?php
include 'auth.php';
include 'lib.php';
	$dataini = request("dataini");
	$datafim = request("datafim");
	$aba = request("aba");
	$loja = request("loja");
	$tipo = request("tipo");
	$categ = request("categ");
	$ordem = request("ordem");
	$tamanh = request("tamanh");
	$frete = request("frete");
	$corpo ="";
	$x=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ReverbCity - Relatório</title>
<style>
	.fontlogo{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size:24px;
	}
	.font16{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:16px;
	}
	.font12{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
</style>
<script language="javascript">
	function valida(){ 

				
		if(document.formrel.email.value=="" || document.formrel.email.value.indexOf('@')==-1 || document.formrel.email.value.indexOf('.')==-1 ) 
		{ 
		alert( "Preencha o campo E-MAIL corretamente!" ); 
		document.formrel.email.focus(); 
		return false; 
		}
		
		document.formrel.submit();
		}
		
</script>
</head>
<body>

<form method="post" action="relatorios_funcoes.php" target="_blank" name="formrel"> 
<input type="hidden" name="aba" value="<?php echo $aba;?>"  />
<input type="hidden" name="assunto" value="Relatorio de Produtos Vendidos" />
<table width="820">
	<tr>
		<td>&nbsp;</td>
    	<td align="right"><label>Email: </label><input type="text" style="border:1px solid #dad7cf; width:200px" name="email" /> <input type="hidden" name="tipo" value="Enviar" target= /> <button type="button" onclick="valida();">Enviar</button></td>
    	<td align="right"><input type="submit" value="Gerar PDF"name="tipo"/> </td>
		<td align="right"><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td></tr>
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="900" /></td></tr>
	<tr>
    	<td height="70" align="left" class="fontlogo" width="200"><strong>ReverbCity</strong></td>
        <td class="font16" align="center" height="70"><strong>Relatório de Produtos Vendidos</strong><br /><font class="font12"><?php echo $dataini.' - '.$datafim; ?></font></td>
        <td colspan="2" class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="900" /></td></tr>
</table>
<table width="820" class="font12">
	<tr>
        <td align="left" width="100"><strong>Loja</strong></td>
        <td align="left" width="100"><strong>Tipo</strong></td>
        <td align="left" width="55"><strong>Ref.</strong></td>
        <td align="left" width="85"><strong>Categoria</strong></td>
		<td align="left" width="85"><strong>Tamanho</strong></td>
        <td align="left"><strong>Descri&ccedil;&atilde;o</strong></td>
        <td align="right" width="140"><strong>Valor Total</strong></td>
        <td align="center" width="55"><strong>Qtde</strong></td>
    </tr>
    <tr><td colspan="8" height="2"><img src="img/xb.gif" height="2" width="900" /></td></tr>
	<?php
		$corpo .="<!DOCTYPE html PUBLIC -//W3C//DTD XHTML 1.0 Transitional//EN http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd>
<html xmlns=http://www.w3.org/1999/xhtml>
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8 />
<title>ReverbCity - Relatório</title>
<style>
	.fontlogo{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size:24px;
	}
	.font16{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:16px;
	}
	.font12{
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
</style>
</head>
<body>
<table >
	<tr>
    	<td height=70 align=left class=fontlogo width=200><strong>ReverbCity</strong></td>
        <td class=font16 align=center height=70><strong>Relatório de Produtos Vendidos</strong><br /><font class=font12>". $dataini.' - '.$datafim."</font></td>
        <td class=font12 align=right height=70 width=200>". date("d/m/Y G:i")."</td>
    </tr>
</table>
<table class=font12>
	<tr>
        <td align=left ><strong>Loja</strong></td>
        <td align=left ><strong>Tipo</strong></td>
        <td align=left ><strong>Ref.</strong></td>
        <td align=left ><strong>Categoria</strong></td>
		<td align=left ><strong>Tamanho</strong></td>
        <td align=left><strong>Descrição</strong></td>
        <td align=right ><strong>Valor Total</strong></td>
        <td align=center ><strong>Qtde</strong></td>
    </tr>
";
	?>
    <?php
	
	
	//COUNT(*) as total,SUM(VL_PRODUTO_CESO)
	$sql = "SELECT NR_SEQ_PRODUTO_CESO, DS_CATEGORIA_PTRC, DS_REFERENCIA_PRRC, DS_PRODUTO2_PRRC, DS_LOJA_LJRC, sum(NR_QTDE_CESO) as total, 
			sum(VL_PRODUTO_CESO*NR_QTDE_CESO), DS_CATEGORIA_PCRC, DS_TAMANHO_TARC 
			from cestas, compras, produtos, produtos_tipo, lojas, produtos_categoria, tamanhos 
			WHERE NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND (ST_COMPRA_COSO = 'E' OR ST_COMPRA_COSO = 'V' OR ST_COMPRA_COSO = 'P')
			AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC
			and DT_PAGAMENTO_COSO between STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') and STR_TO_DATE('$datafim','%d/%m/%Y %H:%i:%s') AND
			NR_SEQ_TAMANHO_CESO = NR_SEQ_TAMANHO_TARC AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) ";
			
	if ($loja != 0) {
	  $sql .= " AND NR_SEQ_LOJAS_PRRC = $loja ";
	}
	if ($tipo != 0) {
	  $sql .= " AND NR_SEQ_TIPO_PRRC = $tipo ";
	}
	if ($categ != 0) {
	  $sql .= " AND NR_SEQ_CATEGORIA_PRRC = $categ ";
	}
	if ($tamanh != 0) {
	  $sql .= " AND NR_SEQ_TAMANHO_CESO = $tamanh ";
	}
	if ($frete == 1) {
	  $sql .= " AND VL_FRETE_COSO <> '0' ";
	}else if ($frete == 2) {
	  $sql .= " AND VL_FRETE_COSO = '0' ";
	}
	
	$sql .= " GROUP BY NR_SEQ_PRODUTO_CESO ";
	switch($ordem){
		case "0":
			$sql .= "order by total desc";
			break;
		case "1":
			$sql .= "order by total asc";
			break;
		case "2":
			$sql .= "order by DS_PRODUTO2_PRRC";
			break;
	}
	
	$st = mysql_query($sql);
	
	//echo $sql;
	//exit();
	
	if (mysql_num_rows($st) > 0) {
		$xtot = 0;
		$vtot = 0;
		while($row = mysql_fetch_row($st)) {
			$mostraprod = true;
			
			$id_prod	   = $row[0];
			$ds_tipo	   = $row[1];
			$ds_ref	  	   = $row[2];
			$ds_prod	   = $row[3];
			$ds_loja	   = $row[4];
			$totalvendido  = $row[5];
			$valortotal	   = $row[6];
			$categoria	   = $row[7];
			$tamanho       = $row[8];
			
			$xtot += $totalvendido;
			$vtot += $valortotal;
			?>
			<tr>
				<td align="left"><?php echo $ds_loja; ?></td>
				<td align="left"><?php echo $ds_tipo; ?></td>
				<td align="left"><?php echo $ds_ref; ?></td>
                <td align="left"><?php echo $categoria; ?></td>
				<td align="left"><?php echo $tamanho; ?></td>
				<td align="left"><?php echo $ds_prod; ?></td>
				<td align="right">R$ <?php echo number_format($valortotal,2,",",""); ?></td>
				<td align="center"><strong><?php echo $totalvendido; ?></strong></td>
			</tr>
			<?php
				if ($x == 0) {
							 	$bg = "#CCCCCC";
								$x = 1;
							 }else{
							 	$bg = "#FFFFFF";
								$x = 0;
							 }
			$corpo .= "<tr  bgcolor=".$bg.">
				<td align=left>".$ds_loja."</td>
				<td align=left>". $ds_tipo."</td>
				<td align=left>".$ds_ref."</td>
                <td align=left>". $categoria."</td>
				<td align=left>". $tamanho."</td>
				<td align=left>". $ds_prod."</td>
				<td align=right>R$ ".number_format($valortotal,2,",","")."</td>
				<td align=center><strong>".$totalvendido."</strong></td>
			</tr>";
			?>
			<?php
		}
		?>
        	<tr><td colspan="8" height="2"><img src="img/xb.gif" height="2" width="900" /></td></tr>
       		<tr>
				<td align="left"><strong>Total Geral</strong></td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
				<td align="right"><strong>R$ <?php echo number_format($vtot,2,",",""); ?></strong></td>
				<td align="center"><strong><?php echo $xtot; ?></strong></td>
			</tr>
			<?php
				$corpo .="<tr>
				<td align=left><strong>Total Geral</strong></td>
				<td align=left></td>
				<td align=left></td>
				<td align=left></td>
				<td align=left></td>
                <td align=left></td>
				<td align=right><strong>R$ ". number_format($vtot,2,",","")."</strong></td>
				<td align=center><strong>". $xtot."</strong></td>
			</tr>";
			?>			
        <?php
	}

?>
    <tr><td colspan="8" height="2"><img src="img/xb.gif" height="2" width="900" /></td></tr>
</table>
<?php $corpo .= " <tr><td colspan=8 height=2></td></tr>
</table></body>
</html>";
?>
	<textarea name="texto" style="visibility:hidden" ><?php echo $corpo;?></textarea>
</form>
</body>
</html>
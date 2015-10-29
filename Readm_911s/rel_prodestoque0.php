<?php
include 'auth.php';
include 'lib.php';
$aba = request("aba");
	$loja = request("loja");
	$tipo = request("tipo");
	$ordem = request("ordem");
	$status = request("status");
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
<input type="hidden" name="assunto" value="Relatorio de Produtos sem Estoque" />
<table width="820">
	<tr>
		<td>&nbsp;</td>
    	<td align="right"><label>Email: </label><input type="text" style="border:1px solid #dad7cf; width:200px" name="email" /> <input type="hidden" name="tipo" value="Enviar" target= /> <button type="button" onclick="valida();">Enviar</button></td>
    	<td align="right"><input type="submit" value="Gerar PDF"name="tipo"/> </td>
		<td align="right"><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td></tr>
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
	<tr>
    	<td height="70" align="left" class="fontlogo" width="200"><strong>ReverbCity</strong></td>
        <td class="font16" align="center" height="70"><strong>Relatório de Produtos sem Estoque</strong></td>
        <td  colspan="2" class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
</table>
<table width="820" class="font12">
	<tr>
        <td align="center" width="120"><strong>Data Cad.</strong></td>
        <td align="left" width="100"><strong>Loja</strong></td>
        <td align="left" width="100"><strong>Tipo</strong></td>
        <td align="left" width="75"><strong>Ref.</strong></td>
        <td align="left"><strong>Descri&ccedil;&atilde;o</strong></td>
        <td align="right" width="140"><strong>Valor</strong></td>
        <td align="center" width="55"><strong>Qtd</strong></td>
    </tr>
    <tr><td colspan="7" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
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
<table width=820>
	<tr>
    	<td height=70 align=left class=fontlogo width=200><strong>ReverbCity</strong></td>
        <td class=font16 align=center height=70><strong>Relatório de Produtos sem Estoque</strong></td>
        <td class=font12 align=right height=70 width=200>".date("d/m/Y G:i")."</td>
    </tr>
</table>
<table width=820 class=font12>
	<tr>
        <td align=center width=120><strong>Data Cad.</strong></td>
        <td align=left width=100><strong>Loja</strong></td>
        <td align=left width=100><strong>Tipo</strong></td>
        <td align=left width=75><strong>Ref.</strong></td>
        <td align=left><strong>Descri&ccedil;&atilde;o</strong></td>
        <td align=right width=140><strong>Valor</strong></td>
        <td align=center width=55><strong>Qtd</strong></td>
    </tr>
";
	?>
	
    <?php
	
	
    $sql = "select NR_SEQ_PRODUTO_PRRC, DT_CADASTRO_PRRC, DS_CATEGORIA_PTRC, DS_REFERENCIA_PRRC, VL_PRODUTO_PRRC,
			 DS_PRODUTO2_PRRC, DS_LOJA_LJRC, DS_EXT_PRRC, DS_EXTTAM_PRRC, ST_PRODUTOS_PRRC,
			 (SELECT sum(NR_QTDE_ESRC) from estoque WHERE NR_SEQ_PRODUTO_ESRC = NR_SEQ_PRODUTO_PRRC) as estoque, VL_PROMO_PRRC
			 from produtos, produtos_tipo, lojas WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND
			 NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC AND DS_CLASSIC_PRRC = 'N' AND ST_PRODUTOS_PRRC = '$status' 
             AND NR_SEQ_TIPO_PRRC <> 9 ";
	if ($loja != 0) {
	  $sql .= " AND NR_SEQ_LOJAS_PRRC = $loja ";
	}
	if ($tipo != 0) {
	  $sql .= " AND NR_SEQ_TIPO_PRRC = $tipo ";
	}
	switch($ordem){
		case "0":
			$sql .= "order by DS_PRODUTO2_PRRC";
			break;
		case "1":
			$sql .= "order by VL_PRODUTO_PRRC desc";
			break;
	}
	
	$st = mysql_query($sql);
	
	//echo $sql;
	//exit();
	
	if (mysql_num_rows($st) > 0) {
		$xtot = 0;
		while($row = mysql_fetch_row($st)) {
			$mostraprod = true;
			
			$id_prod	   = $row[0];
			$dt_prod	   = $row[1];
			$ds_tipo	   = $row[2];
			$ds_ref	  	   = $row[3];
			$vl_prod	   = $row[4];
			$ds_prod	   = $row[5];
			$ds_loja	   = $row[6];
			$ext		   = $row[7];
			$ext2		   = $row[8];
			$status	   	   = $row[9];
			$estoque   	   = $row[10];
			$vlrpromo	   = $row[11];
			
			if (!$estoque) $estoque = 0;
			
			if ($estoque <= 0) {
			?>
			<tr>
				<!--<td align="center" width="60"><img src="../images/produtos/<?php echo $id_prod; ?>.<?php echo $ext; ?>" width="31" height="36" border="0" /></td>-->
				<td align="center"><?php echo date("d/m/Y", strtotime($dt_prod));?></td>
				<td align="left"><?php echo $ds_loja; ?></td>
				<td align="left"><?php echo $ds_tipo; ?></td>
				<td align="left"><?php echo $ds_ref; ?></td>
				<td align="left"><?php echo $ds_prod; ?></td>
				<td align="right">
                	<?php if ($vlrpromo > 0) { ?>
                    (<font style="text-decoration:line-through;">R$ <?php echo number_format($vl_prod,2,",",""); ?></font>) R$ <?php echo number_format($vlrpromo,2,",",""); ?>
                    <?php } else { ?>
                    R$ <?php echo number_format($vl_prod,2,",",""); ?>
                    <?php } ?>
                </td>
				<td align="center"><strong><?php echo $estoque; ?></strong></td>
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
				<td align=center>".date("d/m/Y", strtotime($dt_prod))."</td>
				<td align=left>".$ds_loja."</td>
				<td align=left>".$ds_tipo."</td>
				<td align=left>".$ds_ref."</td>
				<td align=left>".$ds_prod."</td>
				<td align=right>";
                	 if ($vlrpromo > 0) { 
						$corpo .= "(<font style=text-decoration:line-through;>R$ ".number_format($vl_prod,2,",","")."</font>) R$ ".number_format($vlrpromo,2,",","");
                     } else { 
						$corpo .= "R$ ". number_format($vl_prod,2,",",""); 
                     } 
                $corpo .= "</td>
				<td align=center><strong>".$estoque."</strong></td>
			</tr>";
			?>
			
			<?php
			}
		}
	}

?>
    <tr><td colspan="7" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
</table>
<?php $corpo .= " <tr><td colspan=7 height=2></td></tr>
</table></body>
</html>"; ?>
	<textarea name="texto" style="visibility:hidden" ><?php echo $corpo;?></textarea>
</form>
</body>
</html>
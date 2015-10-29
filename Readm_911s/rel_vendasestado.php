<?php
include 'auth.php';
include 'lib.php';
	$aba = request("aba");
	$loja = request("loja");
	$dataini = request("dataini");
	$datafim = request("datafim");
	$tipo = request("tipo");
$corpo="";
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
<input type="hidden" name="assunto" value="Relatorio de Frete Cruzados" />

<table width="820" >
	<tr><td>&nbsp;</td>
    	<td align="right"><label>Email: </label><input type="text" style="border:1px solid #dad7cf; width:200px" name="email" /> <input type="hidden" name="tipo" value="Enviar" target= /> <button type="button" onclick="valida();">Enviar</button></td>
    	<td align="right"><input type="submit" value="Gerar PDF"name="tipo"/> </td>
        <td  align="right"><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td></tr>
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
	<tr>
    	<td height="70" align="left" class="fontlogo" width="200"><strong>ReverbCity</strong></td>
        <td class="font16" align="center" height="70"><strong>Relatório de Vendas por Estados</strong><br /><font size="-1"><?php echo $dataini.' - '.$datafim;?></font></td>
        <td colspan="2" class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
</table>
<table width="820" class="font12" >
	<tr>
        <td align="center" width="100"><strong>Estado</strong></td>
        <td align="center" width="100"><strong>Qtde</strong></td>
        <td width="600">&nbsp;</td>
	</tr>
    <tr><td colspan="3" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
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
        <td class=font16 align=center height=70><strong>Relatório de Vendas por Estados</strong><br /><font size=-1>".$datafim.'/'.$datafim."</font></td>
        <td class=font12 align=right height=70 width=200>".date("d/m/Y G:i")."</td>
    </tr>
</table>
<table  class=font12>
	<tr>
        <td align=center width=100><strong>Estado</strong></td>
        <td align=center width=100><strong>Qtde</strong></td>

	</tr>
";
	?>
    <?php

	
	$sql = "select DS_UF_CASO, SUM(NR_QTDE_CESO) from produtos, compras, cestas, cadastros where 
			NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC";
	if ($tipo != 0) $sql .= " AND NR_SEQ_TIPO_PRRC = $tipo ";
	$sql .= " AND ST_COMPRA_COSO IN ('V','E','P') and DT_PAGAMENTO_COSO between STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') and STR_TO_DATE('$datafim','%d/%m/%Y %H:%i:%s')
			AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) group by DS_UF_CASO ORDER BY DS_UF_CASO";

	$st = mysql_query($sql);
	
	//echo $sql;
	//exit();
	
	if (mysql_num_rows($st) > 0) {
		$xtot = 0;
		while($row = mysql_fetch_row($st)) {
			 $estado	   = $row[0];
			 $quantidade   = $row[1];
			 
			$xtot += $quantidade;
			?>
			<tr>
				<td align="center"><strong><?php echo $estado; ?></strong></td>
                <td align="center"><strong><?php echo $quantidade; ?></strong></td>
                <td width="600">&nbsp;</td>
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
				<td align=center><strong>".$estado."</strong></td>
                <td align=center><strong>".$quantidade."</strong></td>
                
			</tr>
			";
			?>
            
			<?php
		}
		?>
        	<tr><td colspan="3" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
       		<tr>
				<td align="center"><strong>Total Geral</strong></td>
				<td align="center"><strong><?php echo number_format($xtot,0,"","."); ?></strong></td>
                <td width="600">&nbsp;</td>
			</tr>
            <?php 
				$corpo .= "	<tr>
				<td align=center><strong>Total Geral</strong></td>
				<td align=center><strong>".number_format($xtot,0,"",".")."</strong></td>
               
			</tr>";
			?>
        <?php
	}

?>
    <tr><td colspan="3" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
</table>
 <?php $corpo .= " <tr><td colspan=3 height=2></td></tr>
</table></body>
</html>";
?>
	<textarea name="texto" style="visibility:hidden" ><?php echo $corpo;?></textarea>
</form>
</body>
</html>
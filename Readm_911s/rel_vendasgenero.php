<?php
include 'auth.php';
include 'lib.php';
	$aba = request("aba");
	$loja = request("loja");
	$dataini = request("dataini");
	$datafim = request("datafim");
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
<input type="hidden" name="assunto" value="Relatorio de Vendas por Genero" />

<table width="820" >
	<tr><td>&nbsp;</td>
    	<td align="right"><label>Email: </label><input type="text" style="border:1px solid #dad7cf; width:200px" name="email" /> <input type="hidden" name="tipo" value="Enviar" /> <button type="button" onclick="valida();">Enviar</button></td>
    	<td align="right"><input type="submit" value="Gerar PDF"name="tipo"/> </td>
        <td  align="right"><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td></tr>
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
	<tr>
    	<td height="70" align="left" class="fontlogo" width="200"><strong>ReverbCity</strong></td>
        <td class="font16" align="center" height="70"><strong>Relatório de Vendas por Gênero</strong><br /><font size="-1"><?php echo $dataini.' - '.$datafim;?></font></td>
        <td colspan="2" class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
</table>
<table width="820" class="font12" >
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
        <td class=font16 align=center height=70><strong>Relatório de Vendas por Genero</strong><br /><font size=-1>".$dataini.'/'.$datafim."</font></td>
        <td class=font12 align=right height=70 width=200>".date("d/m/Y G:i")."</td>
    </tr>
</table>
<table  class=font12>
";
	?>
    <?php
    if (strpos($dataini,":") <= 0) $dataini = $dataini." 00:00:00";
    if (strpos($datafim,":") <= 0) $datafim = $datafim." 23:59:59";
    $total_fem = 0;
    $sql = "select count(*) from compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
    AND DT_PAGAMENTO_COSO BETWEEN STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') AND STR_TO_DATE('$datafim','%d/%m/%Y %H:%i:%s') 
    AND ST_COMPRA_COSO <> 'C' 
    and NR_SEQ_CADASTRO_COSO not in (8074, 6605, 22364) 
    AND DS_SEXO_CACH in ('F','Feminino')";
    if ($loja != 0) $sql .= " AND NR_SEQ_LOJA_CASO = $loja";
    $st = mysql_query($sql);

    if (mysql_num_rows($st) > 0) {
        $row = mysql_fetch_row($st);
        $total_fem = $row[0];
    }
    
    
    $total_masc = 0;
    $sql = "select count(*) from compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
    AND DT_PAGAMENTO_COSO BETWEEN STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') AND STR_TO_DATE('$datafim','%d/%m/%Y %H:%i:%s') 
    AND ST_COMPRA_COSO <> 'C' 
    and NR_SEQ_CADASTRO_COSO not in (8074, 6605, 22364) 
    AND DS_SEXO_CACH in ('M','Masculino')";
    if ($loja != 0) $sql .= " AND NR_SEQ_LOJA_CASO = $loja";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
        $row = mysql_fetch_row($st);
        $total_masc = $row[0];
    }
    

			?>
			<tr>
				<td align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
                <td width="600" rowspan="2" align="center">
                    <img src="grafico_pizza_genero.php?fem=<?php echo $total_fem; ?>&mas=<?php echo $total_masc; ?>" border="0" />
                </td>
			</tr>
            <tr>
				<td align="center" colspan="2">
                    <strong>Homens: <?php echo $total_masc; ?></strong> <br /> <br />
                    <strong>Mulheres: <?php echo $total_fem; ?></strong>
                </td>
			</tr>
            <?php
			$corpo .= "<tr  bgcolor=#FFFFFF>
				<td align=center><strong>Homens</strong></td>
                <td align=center><strong>".$total_masc."</strong></td>
                <td width=\"600\" rowspan=\"2\"><img src=\"http://www.reverbcity.com/adm/grafico_pizza_genero.php?fem=$total_fem&mas=$total_masc\" border=\"0\" /></td>
			</tr>
			";
            $corpo .= "<tr  bgcolor=#FFFFFF>
				<td align=center><strong>Mulheres</strong></td>
                <td align=center><strong>".$total_fem."</strong></td>
                
			</tr>
			";
			?>

        	<tr><td colspan="3" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
       		<tr>
				<td align="center"><strong>Total Geral</strong></td>
				<td align="center"><strong><?php echo number_format($total_masc+$total_fem,0,"","."); ?></strong></td>
			</tr>
            <?php 
				$corpo .= "	<tr>
				<td align=center><strong>Total Geral</strong></td>
				<td align=center><strong>".number_format($total_masc+$total_fem,0,"",".")."</strong></td>
               
			</tr>";
			?>
        <?php


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
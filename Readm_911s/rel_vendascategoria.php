<?php
include 'auth.php';
include 'lib.php';
$aba = request("aba");
$loja = request("loja");
$dataini = request("dataini");
$datafim = request("datafim");
$categoria = request("categoria");
$tamanho = request("tamanho");
$corpo = "";
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
<input type="hidden" name="assunto" value="Relatorio de Vendas por Categoria/Tamanho" />
<table width="820" >
	<tr>
    <td>&nbsp;</td>
    	<td align="right"><label>Email: </label><input type="text" style="border:1px solid #dad7cf; width:200px" name="email" /> <input type="hidden" name="tipo" value="Enviar" target= /> <button type="button" onclick="valida();">Enviar</button></td>
    	<td align="right"><input type="submit" value="Gerar PDF"name="tipo"/> </td>
        <td  align="right"><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td></tr>
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="1000" /></td></tr>
	<tr>
    	<td height="70" align="left" class="fontlogo" width="200"><strong>ReverbCity</strong></td>
        <td class="font16" align="center" height="70"><strong>Relatório de Vendas por Categoria/Tamanho</strong><br /><font class="font12"> <?php echo $dataini.' - '.$datafim;	 ?></font></td>
        <td colspan="2" class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="1000" /></td></tr>
</table>
<table width="820" class="font12">
	<tr>
        <td align="center" width="83"><strong>NRO</strong></td>
        <td align="center" width="198"><strong>Data Compra</strong></td>
        <td width="220" align="left"><strong>Nome</strong></td>
        <td align="left" width="124"><strong>Categoria</strong></td>
        <td align="left" width="151"><strong>Produto</strong></td>
        <td align="center" width="88"><strong>Quantidade</strong></td>
        <td align="center" width="104"><strong>Tamanho</strong></td>
	</tr>
    <tr><td colspan="8" height="2"><img src="img/xb.gif" height="2" width="1000" /></td></tr>
    
<?php
	$corpo .=  "<!DOCTYPE html PUBLIC -//W3C//DTD XHTML 1.0 Transitional//EN http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd>
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
        <td class=font16 align=center height=70><strong>Relatório de Vendas por Categoria/Tamanho</strong><br /><font class=font12>".$dataini.' - '.$datafim."</font></td>
        <td class=font12 align=right height=70 width=200>".date("d/m/Y G:i")."</td>
    </tr>
</table>
<table class=font12>
	<tr>
        <td align=center ><strong>NRO</strong></td>
        <td align=center ><strong>Data Compra</strong></td>
        <td  align=left><strong>Nome</strong></td>
        <td align=left ><strong>Categoria</strong></td>
        <td align=left ><strong>Produto</strong></td>
        <td align=center ><strong>Quantidade</strong></td>
        <td align=center ><strong>Tamanho</strong></td>
	</tr>
    ";
?>
    <?php

 	$sql = "select NR_SEQ_COMPRA_COSO, DT_COMPRA_COSO, ST_COMPRA_COSO, NR_SEQ_CADASTRO_COSO					
					from compras
					WHERE
					(ST_COMPRA_COSO = 'E' OR ST_COMPRA_COSO = 'V' OR ST_COMPRA_COSO = 'P')and
					DT_PAGAMENTO_COSO between STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') and STR_TO_DATE('$datafim','%d/%m/%Y %H:%i:%s') 
                    AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364) ";	
	
	$sql .= "order by DT_PAGAMENTO_COSO desc";
	
	$st = mysql_query($sql);
	
	if (mysql_num_rows($st) > 0) {
	$xtot =0;
// $i=1;
		while($row = mysql_fetch_row($st)) {
			 $id_compra	   = $row[0];
			 $dt_compra	   = $row[1];
			 $st_compra	   = $row[2];
			 $id_comprador	   = $row[3];
// echo "<BR>COMPRA  = ".$i++;
			
			 $sql2 = "select NR_SEQ_PRODUTO_CESO, NR_SEQ_TAMANHO_CESO, NR_QTDE_CESO
			 				from cestas
							WHERE NR_SEQ_COMPRA_CESO = '$id_compra' "; 
							
			 $st2 = mysql_query($sql2);
			 if (mysql_num_rows($st2) > 0) {
// $j=1;
				 while($row = mysql_fetch_row($st2)) {
					 $prodcesta	   = $row[0];
					 $tamcesta	   = $row[1];			 
					 $quantcesta   = $row[2];
// echo "<BR>CESTA  _______ = ".$j++;
 				  	 $sql3 = "select DS_PRODUTO2_PRRC,
								DS_CATEGORIA_PCRC,
								DS_TAMANHO_TARC,
								DS_NOME_CASO
								from produtos, produtos_categoria, tamanhos, cadastros
								WHERE NR_SEQ_PRODUTO_PRRC = '$prodcesta' and
								NR_SEQ_CADASTRO_CASO = '$id_comprador' and
								NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC and
								$tamcesta = NR_SEQ_TAMANHO_TARC
								"; 
							
					if ($categoria != 0) {
						$sql3 .= "and  NR_SEQ_CATEGORIA_PRRC = '$categoria' and NR_SEQ_CATEGPRO_PCRC = '$categoria' ";
					}
					if ($tamanho != 0) {
						$sql3 .= "and  $tamcesta = '$tamanho'";
					}
				
					
					 $st3 = mysql_query($sql3);
					 if (mysql_num_rows($st3) > 0) {
// $k=1;
						 while($row = mysql_fetch_row($st3)) {
							$desprod   = $row[0];
			 				$descateg	= $row[1];
			 				$destam	   = $row[2];
							$nomecomprador = $row[3];
							
 //echo "<BR>PRODUTO ________________ = ".$k++;
		 				  $xtot += $quantcesta;
							?>
							<tr>
								<td align="center"><strong><?php echo $id_compra; ?></strong></td>
								<td align="center" nowrap="nowrap"><?php echo date("d/m/Y G:i", strtotime($dt_compra)); ?></td>
								<td align="left"><strong><?php echo $nomecomprador; ?></strong></td>
								<td align="left" nowrap="nowrap"><?php echo $descateg; ?></td>
								<td align="left" nowrap="nowrap"><strong><?php echo $desprod; ?></strong></td>
								<td align="center"><strong><?php echo $quantcesta; ?></strong></td>
								<td align="center"><strong><?php echo $destam; ?></strong></td>
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
								<td align=center><strong>".$id_compra."</strong></td>
								<td align=center >".date("d/m/Y G:i", strtotime($dt_compra))."</td>
								<td align=left><strong>".$nomecomprador."</strong></td>
								<td align=left >".$descateg."</td>
								<td align=left ><strong>".$desprod."</strong></td>
								<td align=center><strong>".$quantcesta."</strong></td>
								<td align=center><strong>".$destam."</strong></td>
							</tr>";
							?>
                            
							<?php
								   
						 } // FIM WHILE ST3
						 	
					 }// FIM IF ST3
					 
					
				 } // FIMWHILE ST2
			 }// FIM IF ST2
			 
		
		} // FIM WHILE SQL
		?>
        	<tr><td colspan="7" height="2"><img src="img/xb.gif" height="2" width="1000" /></td></tr>
       		<tr>
				<td align="left" colspan="2"><strong>Total Geral</strong></td>
				<td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
				<td align="right">&nbsp;</td>
		    <td align="center"><strong><?php echo $xtot; ?></strong></td>
                
                <td align="left">&nbsp;</td>
			</tr>
            <?php
				$corpo.="<tr>
				<td align=left colspan=2><strong>Total Geral</strong></td>
				<td align=left></td>
                <td align=left></td>
				<td align=right></td>
		    <td align=center><strong>".$xtot."</strong></td>
                
                <td align=left></td>
			</tr>";
			?>
        <?php
	}// FIM IF SQL

?>
    <tr><td colspan="7" height="2"><img src="img/xb.gif" height="2" width="1000" /></td></tr>
</table>
 <?php $corpo .= " <tr><td colspan=7 height=2></td></tr>
</table></body>
</html>";
?>
	<textarea name="texto" style="visibility:hidden" ><?php echo $corpo;?></textarea>
</form>
</body>
</html>
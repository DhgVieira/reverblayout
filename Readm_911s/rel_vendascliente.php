<?php
include 'auth.php';
include 'lib.php';
	$aba = request("aba");
	$dataini = request("dataini");
	$datafim = request("datafim");
	$tipo = request("tipo");
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
<input type="hidden" name="assunto" value="Relatorio de Vendas por Cliente" />
<table width="820" >
	<tr>
    	<td>&nbsp;</td>
    	<td align="right"><label>Email: </label><input type="text" style="border:1px solid #dad7cf; width:200px" name="email" /> <input type="hidden" name="tipo" value="Enviar" target= /> <button type="button" onclick="valida();">Enviar</button></td>
    	<td align="right"><input type="submit" value="Gerar PDF"name="tipo"/> </td>
	    <td align="right"><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td>
    </tr>
    <tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
    <tr>
    	<td height=70 align=left class=fontlogo width=200><strong>ReverbCity</strong></td>
        <td class=font16 align=center height=70><strong>Relatório de Vendas por Cliente</strong><br /><font style=font-size:11px> <?php echo $dataini.' - '.$datafim; ?></font></td>
        <td colspan="2" class=font12 align=right height=70 width=200><?php echo date("d/m/Y G:i");?></td>
    </tr>
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
</table>

<table width="820" class="font12" >
	<tr>
        <td align="center" width="60"><strong>NRO</strong></td>
        <td align="center" width="145"><strong>Data Compra</strong></td>
        <td align="left"><strong>Nome</strong></td>
        <td align="left" width="90"><strong>Forma Pgto.</strong></td>
        <td align="right" width="110"><strong>Valor Total</strong></td>
        <td align="center" width="30"><strong>ST</strong></td>
        <td align="center" width="30"><strong>Tipo</strong></td>
        <td align="center" width="30"><strong>&nbsp;</strong></td>
	</tr>
    <tr><td colspan="8" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
    <?php 
		$corpo .= "<!DOCTYPE html PUBLIC -//W3C//DTD XHTML 1.0 Transitional//EN http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd>
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
        <td class=font16 align=center height=70><strong>Relatório de Vendas por Cliente</strong><br /><font style=font-size:11px>".$dataini.' - '.$datafim."</font></td>
        <td class=font12 align=right height=70 width=200>".date("d/m/Y G:i")."</td>
    </tr>
</table>
<table width=760>
	<tr>
        <td align=center ><strong>NRO</strong></td>
        <td align=center ><strong>Data Compra</strong></td>
        <td align=left><strong>Nome</strong></td>
        <td align=left ><strong>Forma Pgto.</strong></td>
        <td align=right ><strong>Valor Total</strong></td>
        <td align=center ><strong>ST</strong></td>
        <td align=center ><strong>Tipo</strong></td>
	</tr>

    ";
	?>
    
    <?php
	

	if ($tipo == 0){
		$sql = "select NR_SEQ_CADASTRO_CADGP, NR_SEQ_GRUPO_CADGP from cadastros_grupocad";
	}
	else{
		$sql = "select NR_SEQ_CADASTRO_CADGP, NR_SEQ_GRUPO_CADGP from cadastros_grupocad where NR_SEQ_GRUPO_CADGP = '$tipo' ";
	}
	
	$st = mysql_query($sql);
	if (mysql_num_rows($st) > 0 ){
		while ($row = mysql_fetch_row($st)){
			$cad = $row[0];
			$grp = $row[1];
			
			$sq = "select DS_GRUPO_GPCAD from grupocad where NR_SEQ_GRUPO_GPCAD = '$grp'";
			$s = mysql_query($sq);
			if (mysql_num_rows($s) > 0 ){
				$row = mysql_fetch_row($s);
				$ds_grp = $row[0];
			}
			$sql2 = "select NR_SEQ_COMPRA_COSO, DT_COMPRA_COSO, DS_FORMAPGTO_COSO, VL_TOTAL_COSO, DS_NOME_CASO, DS_EMAIL_CASO, DS_DDDFONE_CASO, DS_FONE_CASO, NR_SEQ_CADASTRO_COSO, ST_COMPRA_COSO 
					from compras, cadastros
					WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
					and NR_SEQ_CADASTRO_CASO = '$cad'  
					and DT_COMPRA_COSO between STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') and STR_TO_DATE('$datafim','%d/%m/%Y %H:%i:%s') ";
			$st2 = mysql_query($sql2);
	
	//echo $sql;
	//exit();
	
			if (mysql_num_rows($st2) > 0) {
				$xtot = 0;
				while($row = mysql_fetch_row($st2)) {
					 $id_compra	   = $row[0];
					 $dt_compra	   = $row[1];
					 $formapgto	   = $row[2];
					 $valor		   = $row[3];
					 $nome		   = $row[4];
					 $email		   = $row[5];
					 $dddfone	   = $row[6];
					 $fone		   = $row[7];
					 $idcli		   = $row[8];
					 $status	   = $row[9];
					
					$xtot += $valor;
					?>
					<tr>
						<td align="center"><strong><?php echo $id_compra; ?></strong></td>
						<td align="center" nowrap="nowrap"><?php echo date("d/m/Y G:i", strtotime($dt_compra)); ?></td>
						<td align="left"><strong><?php echo $nome; ?></strong></td>
						<td align="left" nowrap="nowrap"><?php echo $formapgto; ?></td>
						<td align="right" nowrap="nowrap"><strong>R$ <?php echo number_format($valor,2,",","."); ?></strong></td>
						<td align="center"><strong><?php echo $status; ?></strong></td>
                        <td align="center"><strong><?php echo $ds_grp; ?></strong></td>
						<td align="center"><a href="compras_ver.php?idcli=<? echo $idcli;?>&idc=<? echo $id_compra;?>" target="_blank"><img src="img/ico-det.gif" width="16" height="16" border="0" alt="Ver Detalhamento" /></a></td>
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
						<td align=center nowrap=nowrap>".date("d/m/Y G:i", strtotime($dt_compra))."</td>
						<td align=left><strong>".$nome."</strong></td>
						<td align=left nowrap=nowrap>".$formapgto."</td>
						<td align=right nowrap=nowrap><strong>R$ ".number_format($valor,2,",",".")."</strong></td>
						<td align=center><strong>".$status."</strong></td>
                        <td align=center><strong>".$ds_grp."</strong></td>
					</tr>
			";
?>

					<?
				}
				?>
					<tr><td colspan="8" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
					<tr>
						<td align="left" colspan="2"><strong>Total Geral</strong></td>
						<td align="left">&nbsp;</td>
						<td align="left">&nbsp;</td>
						<td align="right"><strong>R$ <?php echo number_format($xtot,2,",","."); ?></strong></td>
						<td align="center">&nbsp;</td>
						<td align="left">&nbsp;</td>
					</tr>
                    
<?php
	$corpo .="<tr>
						<td align=left colspan=2><strong>Total Geral</strong></td>
						<td align=left></td>
						<td align=left></td>
						<td align=right><strong>R$ ".number_format($xtot,2,",",".")."</strong></td>
						<td align=center></td>
						<td align=left></td>
					</tr>";
?>
				<?php
			}
		
		
		}
	}
	?>	
	
    <tr><td colspan="8" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
</table>
<?php $corpo .= "<tr><td colspan=7 height=2></td></tr>
</table></body>
</html>";
?>
	<textarea name="texto" style="visibility:hidden" ><?php echo $corpo;?></textarea>
</form>
</body>
</html>

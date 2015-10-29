<?php
include 'auth.php';
include 'lib.php';

    $aba = request("aba");
	$loja = request("loja");
	$dataini = request("dataini");
	if ($dataini){
		list($data, $hora) = explode(" ",$dataini);
		
		$dataini = $data.' 00:00:00 ';
		$datafim = $data.' 23:59:59 ';
		//echo $dataini.' & '. $datafim;
	}
	$total = 0;
	$corpo ="";
	$x =0;
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
<input type="hidden" name="assunto" value="Relatorio Movimento do Dia" />
<table width="820">
	<tr>
    	<td>&nbsp;</td>
    	<td align="right"><label>Email: </label><input type="text" style="border:1px solid #dad7cf; width:200px" name="email" /> <input type="hidden" name="tipo" value="Enviar" target= /> <button type="button" onclick="valida();">Enviar</button></td>
    	<td align="right"><input type="submit" value="Gerar PDF"name="tipo"/> </td>
	    <td align="right"><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td>
    </tr>
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
	<tr>
    	<td height="70" align="left" class="fontlogo" width="200"><strong>ReverbCity</strong></td>
        <td class="font16" align="center" height="70"><strong>Movimento do Dia</strong><br /><font class="font12"><? echo $data;?></font></td>
        <td colspan="2" class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
</table>
<table width="820" class="font12">
	<tr>
        <td align="left" width="90"><strong>Loja/ Compra</strong></td>
        <td align="left" width="102"><strong>Vencimento</strong></td>
        <td align="left" width="107"><strong>Data Lançamento</strong></td>
        <td align="left" width="107"><strong>Data Status</strong></td>
        <td align="left" width="194" ><strong>Descri&ccedil;&atilde;o</strong></td>
        <td align="left" width="130"><strong>Categoria</strong></td>
        <td align="right" width="162"><strong>Subcategoria</strong></td>
        <td align="center" width="100"><strong>Valor</strong></td>
        <td align="center" width="50"><strong >Tipo</strong></td>
    </tr>
    <tr><td colspan="9" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
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
<table width=720>
	<tr>
    	<td height=70 align=left class=fontlogo width=200><strong>ReverbCity</strong></td>
        <td class=font16 align=center height=70><strong>Movimento do Dia</strong><br /><font class=font12>".$data."</font></td>
        <td class=font12 align=right height=70 width=200>".date("d/m/Y G:i")."</td>
    </tr>
</table>
<table width=820 class=font12>
	<tr>
        <td align=left ><strong>Loja/ Compra</strong></td>
        <td align=left ><strong>Vencimento</strong></td>
        <td align=left ><strong>Data Lançamento</strong></td>
        <td align=left ><strong>Data Status</strong></td>
        <td align=left ><strong>Descri&ccedil;&atilde;o</strong></td>
        <td align=left ><strong>Categoria</strong></td>
        <td align=right><strong>Subcategoria</strong></td>
        <td align=center ><strong>Valor</strong></td>
        <td align=center ><strong >Tipo</strong></td>
    </tr>
    </table><table width=820>";
	?>
    <?php
	
	$sql = "select NR_SEQ_CONTA_CORC, NR_SEQ_CATCONTA_CORC, DS_DESCRICAO_CORC, VL_CONTA_CORC, DT_CADASTRO_CORC, DT_VCTO_CORC, DS_TIPO_CORC,
						  				DS_CATEGORIA_CCRC, DS_LOJA_LJRC, NR_SEQ_SUBCATCONTA_CORC from contas, contas_categorias, lojas WHERE NR_SEQ_CATCONTA_CORC = NR_SEQ_CATCONTA_CCRC AND
										NR_SEQ_LOJA_CORC = NR_SEQ_LOJA_LJRC AND NR_SEQ_LOJA_CORC = $loja AND (DS_TIPO_CORC = 'D' OR DS_TIPO_CORC = 'C' )AND
										DT_VCTO_CORC = STR_TO_DATE('$dataini','%d/%m/%Y')";
						  	$sql .= " order by DT_VCTO_CORC";
    
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                
                                while($row = mysql_fetch_row($st)) {
                                 $id_conta	   = $row[0];
                                 $nr_categ	   = $row[1];
                                 $ds_conta	   = $row[2];
                                 $vl_conta	   = $row[3];
                                 $dt_lanca	   = $row[4];
                                 $dt_vcto	   = $row[5];
                                 $ds_tipo	   = $row[6];
                                 $ds_categ	   = $row[7];
								 $ds_loja	   = $row[8];
								 $nrseqsub	   = $row[9];
							 
								 $sqlsub = "SELECT DS_SUBCATEGORIA_SCRC FROM contas_subcategorias where NR_SEQ_SUBCATCONTA_SCRC = $nrseqsub";
								 $stsub = mysql_query($sqlsub);
								 if (mysql_num_rows($stsub) > 0) {
									$rowsub = mysql_fetch_row($stsub);
									$dssubcateg = $rowsub[0];
								 }else{
									$dssubcateg = " - ";
								 }
                                 
								 if($ds_tipo == "C"){
	                                 $total += $vl_conta;
									 $cortipo = "#090";
								 }else{
								 	 $total -= $vl_conta;
									 $cortipo = "#FF0000";
								 }
			?>
			<tr>
				<td align="left"><?php echo $ds_loja; ?></td>
				<td align="left"><?php echo date('d/m/Y',strtotime($dt_vcto)); ?></td>
				<td align="left"><?php echo date('d/m/Y',strtotime($dt_lanca)); ?></td>
                <td align="right">&nbsp;</td>                
                <td align="left"><?php echo $ds_conta; ?></td>
				<td align="left"><?php echo $ds_categ; ?></td>
				<td align="right"><?php echo $dssubcateg; ?></td>
				<td align="center"><strong>R$ <?php echo number_format($vl_conta,2,",",""); ?></strong></td>
                <td align="center" width="20"><strong style="color:<?PHP echo $cortipo;?>;"><?php echo $ds_tipo; ?></strong></td>
                
			</tr>
            
            <?php
			if ($x == 0) {
							 	$bg = "#CCCCCC";
								$x = 1;
							 }else{
							 	$bg = "#FFFFFF";
								$x = 0;
							 }
				$corpo .="<tr bgcolor=".$bg.">
				<td align=left>".$ds_loja."</td>
				<td align=left>".date('d/m/Y',strtotime($dt_vcto))."</td>
				<td align=left>".date('d/m/Y',strtotime($dt_lanca))."</td>
                <td align=right></td>                
                <td align=left>".$ds_conta."</td>
				<td align=left>".$ds_categ."</td>
				<td align=right>".$dssubcateg."</td>
				<td align=center><strong>R$ ".number_format($vl_conta,2,",","")."</strong></td>
                <td align=center ><strong >".$ds_tipo."</strong></td>
                
			</tr>";
			?>
            
								<?
								} //***** fim while
							  } //***** fim if
                            ?>

             <?PHP 
			 $datanovo = date('m/d/Y',strtotime($dataini));
		$sq2 = "select NR_SEQ_COMPRA_COSO, DT_COMPRA_COSO, DT_STATUS_COSO, VL_TOTAL_COSO, ST_COMPRA_COSO 
			from compras 
			WHERE(ST_COMPRA_COSO = 'P' or ST_COMPRA_COSO = 'E' or ST_COMPRA_COSO = 'V')AND
			DT_STATUS_COSO between STR_TO_DATE('$dataini','%d/%m/%Y %H:%i:%s') and STR_TO_DATE('$datafim','%d/%m/%Y %H:%i:%s')
			order by ST_COMPRA_COSO, DT_STATUS_COSO";
										
	$st2 = mysql_query($sq2);
	if( mysql_num_rows($st2) > 0 ){
		while ($row2 = mysql_fetch_row($st2)){
			$idCompra = $row2[0];
			$dtCompra = $row2[1];
			$dtStatus = $row2[2];
			$vtCompra = $row2[3];
			$stStatus = $row2[4];
		
			if($stStatus == "P"){				
				 $cortipo = "#00F";
			}
			else if($stStatus == "V"){				 
				 $cortipo = "#F90";
				}
				else if($stStatus == "E"){				
				 $cortipo = "#609";
			 }	
		
			$total += $vtCompra;
			?>
			<tr>
				<td align="left"><?php echo $idCompra; ?></td>
                <td align="right">&nbsp;</td>				
				<td align="left"><?php echo date('d/m/Y',strtotime($dtCompra)); ?></td>
                <td align="left"><?php if ($dtStatus == NULL) echo ' - '; else echo date('d/m/Y',strtotime($dtStatus)); ?></td>
                <td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td align="right">&nbsp;</td>
				<td align="center"><strong>R$ <?php echo number_format($vtCompra,2,",",""); ?></strong></td>
                <td align="center" width="20"><strong style="color:<?PHP echo $cortipo;?>;"><?php echo $stStatus; ?></strong></td>
                
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
				<td align=left>".$idCompra."</td>
                <td align=right></td>				
				<td align=left>".date('d/m/Y',strtotime($dtCompra))."</td>
                <td align=left>";
				if ($dtStatus == NULL) $corpo .= " - "; else $corpo .= date('d/m/Y',strtotime($dtStatus));
				$corpo .="</td>
                <td align=left></td>
				<td align=left></td>
				<td align=right></td>
				<td align=center><strong>R$ ".number_format($vtCompra,2,",","")."</strong></td>
                <td align=center ><strong>".$stStatus."</strong></td>                
			</tr>";
			?>
								<?
			
		}
	}
?>               
                            
        	<tr><td colspan="9" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
       		<tr>
				<td align="left"><strong>Total Geral</strong></td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td align="center"><strong>R$ <?php echo number_format($total,2,",",""); ?></strong></td>
                <td align="left">&nbsp;</td>
			</tr>
 
    <tr><td colspan="9" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
</table>
<?php
	$corpo .="<tr><td colspan=9 height=2></td></tr>
       		<tr>
				<td align=left><strong>Total Geral</strong></td>
				<td align=left></td>
				<td align=left></td>
				<td align=left></td>
                <td align=left></td>
                <td align=left></td>
				<td align=left></td>
				<td align=center><strong>R$ ".number_format($total,2,",","")."</strong></td>
                <td align=left></td>
			</tr>
 
    <tr><td colspan=9 height=2></td></tr>
</table>
</body>
</html>";
?>
	<textarea name="texto" style="visibility:hidden" ><?php echo $corpo;?></textarea>
</form>
</body>
</html>

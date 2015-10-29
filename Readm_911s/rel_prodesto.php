<?php
include 'auth.php';
include 'lib.php';
	$aba = request("aba");
	$loja = request("loja");
	$tipo = request("tipo");
	$ordem = request("ordem");
	$taman = request("taman");
	$corpo ="";
	$x=0;
	$tot=0;
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
<input type="hidden" name="assunto" value="Relatorio de Estoque" />
<table width="820">
	<tr>
	
	<td>&nbsp;</td>
    	<td align="right"><label>Email: </label><input type="text" style="border:1px solid #dad7cf; width:200px" name="email" /> <input type="hidden" name="tipo" value="Enviar" target= /> <button type="button" onclick="valida();">Enviar</button></td>
    	<td align="right"><input type="submit" value="Gerar PDF"name="tipo"/> </td>
		<td align="right"><a href="#" onclick="window.print();"><img src="img/ico_imprimir.gif" border="0" alt="Imprimir" /></a></td></tr>
	<tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
	<tr>
    	<td height="70" align="left" class="fontlogo" width="200"><strong>ReverbCity</strong></td>
        <td class="font16" align="center" height="70"><strong>Relatório de Estoque</strong></td>
        <td colspan="2" class="font12" align="right" height="70" width="200"><?php echo date("d/m/Y G:i"); ?></td>
    </tr>
    <tr><td colspan="4" height="1"><img src="img/xb.gif" height="2" width="820" /></td></tr>
</table>
<table width="820" class="font12">
	<tr>
        <td align="left" width="100"><strong>Loja</strong></td>
        <td align="left" width="100"><strong>Tipo</strong></td>
        <td align="left" width="75"><strong>Ref.</strong></td>
        <td align="left"><strong>Descri&ccedil;&atilde;o</strong></td>
        <td align="right" width="140"><strong>Valor</strong></td>
        <td align="center" width="65"><strong>Qtde</strong></td>
        <td align="center" width="125"><strong>Tamanhos</strong></td>
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
<table width=720>
	<tr>
    	<td height=70 align=left class=fontlogo width=200><strong>ReverbCity</strong></td>
        <td class=font16 align=center height=70><strong>Relatorio de Estqoue</strong></td>
        <td class=font12 align=right height=70 width=200>". date("d/m/Y G:i")."</td>
    </tr>
</table>
<table width=720 class=font12>
	<tr>
        <td align=left width=100><strong>Tipo</strong></td>
        <td align=left width=75><strong>Ref.</strong></td>
        <td align=left><strong>Descricao</strong></td>
        <td align=right width=140><strong>Valor</strong></td>
        <td align=center width=65><strong>Qtde</strong></td>
		<td align=center width=125><strong>Tamanhos</strong></td>
    </tr>
";
	?>
	
    <?php


	$sql = "SELECT DS_CATEGORIA_PTRC, DS_REFERENCIA_PRRC, VL_PRODUTO_PRRC, DS_PRODUTO2_PRRC, DS_LOJA_LJRC, ST_PRODUTOS_PRRC, VL_PROMO_PRRC, sum(NR_QTDE_ESRC) as total, NR_SEQ_PRODUTO_PRRC
			FROM produtos, estoque, produtos_tipo, lojas 
			where NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC
			and NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC and NR_QTDE_ESRC > 0";	
	if ($loja != 0) {
	  $sql .= " AND NR_SEQ_LOJAS_PRRC = $loja ";
	}
	if ($tipo != 0) {
	  $sql .= " AND NR_SEQ_TIPO_PRRC = $tipo ";
	}

	$sql .= " group by NR_SEQ_PRODUTO_PRRC order by total desc, DS_PRODUTO2_PRRC";

	
	$st = mysql_query($sql);
	
	//echo $sql;
	//exit();
	
	if (mysql_num_rows($st) > 0) {
		$xtot = 0;
		while($row = mysql_fetch_row($st)) {
			$mostraprod = true;
			
			$ds_tipo	   = $row[0];
			$ds_ref	  	   = $row[1];
			$valor	  	   = $row[2];
			$ds_prod	   = $row[3];
			$ds_loja	   = $row[4];
			$vlrpromo	   = $row[6];
			$qtde		   = $row[7];
			$idp		   = $row[8];
			?>
			<tr>
				<td align="left"><?php echo $ds_loja; ?></td>
				<td align="left"><?php echo $ds_tipo; ?></td>
				<td align="left"><?php echo $ds_ref; ?></td>
				<td align="left"><?php echo $ds_prod; ?></td>
				<td align="right">
                	<?php if ($vlrpromo > 0) { ?>
                    (<font style="text-decoration:line-through;">R$ <?php echo number_format($valor,2,",",""); ?></font>) R$ <?php echo number_format($vlrpromo,2,",",""); ?>
                    <?php 
					$tot += $vlrpromo * $qtde;
					} else { ?>
                    R$ <?php echo number_format($valor,2,",",""); ?>
                    <?php $tot += $valor * $qtde;
					} ?>
                </td>
				<td align="center"><strong><?php echo $qtde; ?></strong></td>
                <td align="center" style="font-size:9px;">
                	<?php 
					$sqlt = "SELECT NR_QTDE_ESRC, DS_SIGLA_TARC, NR_SEQ_TAMANHO_TARC FROM estoque, tamanhos WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_PRODUTO_ESRC = $idp and NR_QTDE_ESRC > 0";
					$stt = mysql_query($sqlt);
					if (mysql_num_rows($stt) > 0) {
						$mostrapdf = "";
                        while($rowt = mysql_fetch_row($stt)) {
							$qtdet	= $rowt[0];
							$sigla	= $rowt[1];
							$idtam	= $rowt[2];
							
							$mostra = "";
							if ($idtam >= 6 && $idtam <= 10) {
								$mostra = $qtdet.$sigla."(F) ";
							}else{
								$mostra = $qtdet.$sigla." ";
							}
							echo $mostra;
                            $mostrapdf .= $mostra;
						}
					}
					?>
                </td>
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
				<td align=left><font size=1>". str_replace("Ã³","ó",$ds_tipo)."</font></td>
				<td align=left>". $ds_ref."</td>
				<td align=left>". $ds_prod."</td>
				<td align=right><font size=1>";
                	if ($vlrpromo > 0) { 
                $corpo .= "    (<font style=text-decoration:line-through;>R$ ". number_format($valor,2,",","")."</font>) R$ ".number_format($vlrpromo,2,",","");
					 } else { 
                $corpo .= "R$ ". number_format($valor,2,",",""); 
                    } 
                $corpo .= "</font></td>
				<td align=center><strong>". $qtde."</strong></td>
				<td align=center>$mostrapdf</td>
			</tr>";
		?>
			<?php
			$xtot += $qtde;
		}
		?>
        	<tr><td colspan="7" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
       		<tr>
				<td align="left"><strong>Total Geral</strong></td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
				<td align="left">&nbsp;</td>
                <td align="right">R$ <?php echo number_format($tot,2,",",""); ?></td>
                <td align="center"><strong><?php echo $xtot; ?></strong></td>
				<td align="right">&nbsp;</td>
			</tr>
		<?php
			$corpo .="<tr>
				<td align=left><strong>Total Geral</strong></td>
				<td align=left> </td>
				<td align=left> </td>
                <td align=right>R$ ".number_format($tot,2,",","")."</td>
				<td align=center><strong>". $xtot."</strong></td>
				<td align=right>&nbsp;</td>
			</tr>";
		?>	
	
        <?php
	}

?>
    <tr><td colspan="7" height="2"><img src="img/xb.gif" height="2" width="820" /></td></tr>
</table>
<?php $corpo .= " <tr><td colspan=7 height=2></td></tr>
</table></body>
</html>";
?>
	<textarea name="texto" style="visibility:hidden" ><?php echo $corpo;?></textarea>
</form>
</body>
</html>
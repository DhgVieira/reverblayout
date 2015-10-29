<?php
include 'auth.php';
include 'lib.php';

$dataini = request("dataini");
$datafim = request("datafim");
$lojapesq = request("lojapesq");

if (!$dataini) $dataini = "01/".date("m/Y")." 00:00:00";
if (!$datafim) $datafim = date("d/m/Y")." 23:59:59";
if (!$lojapesq) $lojapesq = "1";

$aba	= request("aba");
if (!$aba) $aba = "V";

//montacombolojas
$sql = "select NR_SEQ_LOJA_LJRC, DS_LOJA_LJRC from lojas order by NR_SEQ_LOJA_LJRC";
$st = mysql_query($sql);
$str_lojas = "";
if (mysql_num_rows($st) > 0) {
  while($row = mysql_fetch_row($st)) {
   $id_loja	   = $row[0];
   $ds_loja	   = $row[1];
   $str_lojas .= "<option value=\"$id_loja\">$ds_loja</option>\n";
  }
}

//montacombotipo                                   
$sql = "select NR_SEQ_CATEGPRO_PTRC, DS_CATEGORIA_PTRC from produtos_tipo where NR_SEQ_LOJA_PTRC = 1 order by DS_CATEGORIA_PTRC";
$st = mysql_query($sql);
$str_tipos = "";
if (mysql_num_rows($st) > 0) {
  while($row = mysql_fetch_row($st)) {
   $id_tipo	   = $row[0];
   $ds_tipo	   = $row[1];
   $str_tipos .= "<option value=\"$id_tipo\">$ds_tipo</option>\n";
  }
}

//montacombotamanhos                                  
$sql = "select NR_SEQ_TAMANHO_TARC, DS_TAMANHO_TARC from tamanhos WHERE NR_SEQ_TAMANHO_TARC <> 12 order by DS_TAMANHO_TARC";
$st = mysql_query($sql);
$str_tam = "";
if (mysql_num_rows($st) > 0) {
  while($row = mysql_fetch_row($st)) {
   $id_tam	   = $row[0];
   $ds_tam	   = $row[1];
   $str_tam .= "<option value=\"$id_tam\">$ds_tam</option>\n";
  }
}

//castegorias                                  
$sql = "select NR_SEQ_CATEGPRO_PCRC, DS_CATEGORIA_PCRC from produtos_categoria order by DS_CATEGORIA_PCRC";
$st = mysql_query($sql);

$strcat = "";
if (mysql_num_rows($st) > 0) {
  while($row = mysql_fetch_row($st)) {
   $id_cate	   = $row[0];
   $ds_cate	   = $row[1];
   $strcat .= "<option value=\"$id_cate\">$ds_cate</option>\n";
  }
}

//**** CATEGORIAS DE CONTAS
$sql = "select NR_SEQ_CATCONTA_CCRC, DS_CATEGORIA_CCRC from contas_categorias order by DS_CATEGORIA_CCRC";
$st = mysql_query($sql);

$contascat = "";
if (mysql_num_rows($st) > 0) {
  while($row = mysql_fetch_row($st)) {
   $id_cate	   = $row[0];
   $ds_cate	   = $row[1];
   $contascat .= "<option value=\"$id_cate\">$ds_cate</option>\n";
  }
}

//**** SUBCATEGORIAS DE CONTAS
$sql = "select NR_SEQ_SUBCATCONTA_SCRC, DS_SUBCATEGORIA_SCRC from contas_subcategorias order by DS_SUBCATEGORIA_SCRC";
$st = mysql_query($sql);

$contassubcat = "";
if (mysql_num_rows($st) > 0) {
  while($row = mysql_fetch_row($st)) {
   $id_cate	   = $row[0];
   $ds_cate	   = $row[1];
   $contassubcat .= "<option value=\"$id_cate\">$ds_cate</option>\n";
  }
}

//**** TAMANHO DE PRODUTO
$sql = "select NR_SEQ_TAMANHO_TARC, DS_TAMANHO_TARC from tamanhos order by DS_TAMANHO_TARC";
$st = mysql_query($sql);

$tamprod = "";
if (mysql_num_rows($st) > 0) {
  while($row = mysql_fetch_row($st)) {
   $id_tam	   = $row[0];
   $ds_tam	   = $row[1];
   $tamprod .= "<option value=\"$id_tam\">$ds_tam</option>\n";
  }
}

//**** clientes
$sql = "select NR_SEQ_GRUPO_GPCAD, DS_GRUPO_GPCAD from grupocad order by DS_GRUPO_GPCAD";
$st = mysql_query($sql);

$str_cliente = "";
if (mysql_num_rows($st) > 0) {
  while($row = mysql_fetch_row($st)) {
   $id_cli	   = $row[0];
   $ds_cli	   = $row[1];
   $str_cliente .= "<option value=\"$id_cli\">$ds_cli</option>\n";
  }
}

$sql = "select count(*) from cadastros where NR_SEQ_CADASTRO_CASO not IN
        (SELECT NR_SEQ_CADASTRO_COSO from compras WHERE ST_COMPRA_COSO IN ('P','V','E','A'))
        AND NR_SEQ_CADASTRO_CASO <> 1 AND NR_SEQ_CADASTRO_CASO <> 3
        and DS_SEXO_CACH in ('M','Masculino')";
$st = mysql_query($sql);
$totcadsM = 0;
if (mysql_num_rows($st) > 0) {
 $row = mysql_fetch_row($st);
 $totcadsM = $row[0];
}else{
 $totcadsM = 0;
}

$sql = "select count(*) from cadastros where NR_SEQ_CADASTRO_CASO not IN
        (SELECT NR_SEQ_CADASTRO_COSO from compras WHERE ST_COMPRA_COSO IN ('P','V','E','A'))
        AND NR_SEQ_CADASTRO_CASO <> 1 AND NR_SEQ_CADASTRO_CASO <> 3
        and DS_SEXO_CACH in ('F','Feminino')";
$st = mysql_query($sql);
$totcadsF = 0;
if (mysql_num_rows($st) > 0) {
 $row = mysql_fetch_row($st);
 $totcadsF = $row[0];
}else{
 $totcadsF = 0;
}



$sql = "select count(*) from cadastros where NR_SEQ_CADASTRO_CASO not IN
(SELECT NR_SEQ_CADASTRO_COSO from compras where DT_COMPRA_COSO > DATE_SUB(SYSDATE(), INTERVAL 1 YEAR) AND ST_COMPRA_COSO <> 'C')
AND NR_SEQ_CADASTRO_CASO IN
(SELECT NR_SEQ_CADASTRO_COSO from compras WHERE ST_COMPRA_COSO <> 'C')
and DS_SEXO_CACH in ('M','Masculino')";
$st = mysql_query($sql);
$totcadsM1 = 0;
if (mysql_num_rows($st) > 0) {
 $row = mysql_fetch_row($st);
 $totcadsM1 = $row[0];
}else{
 $totcadsM1 = 0;
}

$sql = "select count(*) from cadastros where NR_SEQ_CADASTRO_CASO not IN
(SELECT NR_SEQ_CADASTRO_COSO from compras where DT_COMPRA_COSO > DATE_SUB(SYSDATE(), INTERVAL 1 YEAR) AND ST_COMPRA_COSO <> 'C')
AND NR_SEQ_CADASTRO_CASO IN
(SELECT NR_SEQ_CADASTRO_COSO from compras WHERE ST_COMPRA_COSO <> 'C')
and DS_SEXO_CACH in ('F','Feminino')";
$st = mysql_query($sql);
$totcadsF1 = 0;
if (mysql_num_rows($st) > 0) {
 $row = mysql_fetch_row($st);
 $totcadsF1 = $row[0];
}else{
 $totcadsF1 = 0;
}

$sql = "select count(*) from cadastros where NR_SEQ_CADASTRO_CASO IN
(SELECT NR_SEQ_CADASTRO_COSO from compras where DT_COMPRA_COSO > DATE_SUB(SYSDATE(), INTERVAL 6 MONTH)
AND ST_COMPRA_COSO <> 'C'
and NR_SEQ_CADASTRO_COSO <> 8074
and NR_SEQ_CADASTRO_COSO <> 6605)
AND DS_SEXO_CACH in ('M','Masculino')";
$st = mysql_query($sql);
$totcadsM6 = 0;
if (mysql_num_rows($st) > 0) {
 $row = mysql_fetch_row($st);
 $totcadsM6 = $row[0];
}else{
 $totcadsM6 = 0;
}

$sql = "select count(*) from cadastros where NR_SEQ_CADASTRO_CASO IN
(SELECT NR_SEQ_CADASTRO_COSO from compras where DT_COMPRA_COSO > DATE_SUB(SYSDATE(), INTERVAL 6 MONTH)
AND ST_COMPRA_COSO <> 'C'
and NR_SEQ_CADASTRO_COSO <> 8074
and NR_SEQ_CADASTRO_COSO <> 6605)
AND DS_SEXO_CACH in ('F','Feminino')";
$st = mysql_query($sql);
$totcadsF6 = 0;
if (mysql_num_rows($st) > 0) {
 $row = mysql_fetch_row($st);
 $totcadsF6 = $row[0];
}else{
 $totcadsF6 = 0;
}

$diaanterior = DateAdd(-1);
?>
<?php include 'topo.php'; ?>
<script type='text/javascript' src="calendar1.js"></script>
<script type='text/javascript' src="scripts/autocomplete/jquery.tools.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/dateskin.css"/>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Relatórios</li>
                      <li id="menuDepo" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='graficos.php';">GR&Aacute;FICOS</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVend" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">GERAIS</li>
                      <li id="abaProd" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">PRODUTOS</li>
                      <li id="abaCome" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">COMÉRCIO</li>
                      <li id="abaAdm" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">CONTAS ADM</li>
                      <li id="abaMkt" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">MARKETING</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                
              	<div id="abas">
                	
                    <div id="vendas">
                        <table width="885">
                        	<tr>
                            	<td width="50%" valign="top">
                                  <table>
                                        <form action="fram_vendasdia.php" method="post" name="formvd">
                                        <input name="aba" type="hidden" value="V" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Vendas Diárias Líquidas</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Resumo de todas as Vendas de um dia específico</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Dia: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datadiavd" value="<?php echo str_pad($diaanterior[2],2,"0",STR_PAD_LEFT)."/".str_pad($diaanterior[1],2,"0",STR_PAD_LEFT)."/".$diaanterior[0] ?>" /> <a href="javascript:calvd.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table>
                                </td>
                                <td width="50%" valign="top">
                                	<table>
                                        <form action="fram_vendasdiabanco.php" method="post" name="formvd2">
                                        <input name="aba" type="hidden" value="V" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Vendas Diárias (sem taxas)</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Resumo de todas as Vendas do Mês, dia a dia para verificação de entradas em bancos</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Mês/Ano: </strong></td><td>
                                            <input style="width:30px;height:14px;text-align:center;" class="frm_pesq" type="text" name="mes" value="<?php echo date("m");?>" />
                                            <input style="width:40px;height:14px;text-align:center;" class="frm_pesq" type="text" name="ano" value="<?php echo date("Y");?>" />
                                            </td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                            	<td width="50%" valign="top">
                                  <table>
                                        <form action="fram_vendasteesuf.php" method="post" name="formvd3">
                                        <input name="aba" type="hidden" value="V" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Vendas de Camisetas por Estados</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Quantidade de Camisetas vendidas, dia a dia, por estados</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Mês/Ano: </strong></td><td>
                                            <input style="width:30px;height:14px;text-align:center;" class="frm_pesq" type="text" name="mes" value="<?php echo date("m");?>" />
                                            <input style="width:40px;height:14px;text-align:center;" class="frm_pesq" type="text" name="ano" value="<?php echo date("Y");?>" />
                                            </td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table>
                                </td>
                                <td width="50%" valign="top">
                                	<table>
                                        <form action="fram_vendas_uf.php" method="post" name="formvd4">
                                        <input name="aba" type="hidden" value="V" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Vendas de itens por Estados</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Quantidade de itens vendidos, dia a dia, por estados</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Mês/Ano: </strong></td><td>
                                            <input style="width:30px;height:14px;text-align:center;" class="frm_pesq" type="text" name="mes" value="<?php echo date("m");?>" />
                                            <input style="width:40px;height:14px;text-align:center;" class="frm_pesq" type="text" name="ano" value="<?php echo date("Y");?>" />
                                            </td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                            	<td width="50%" valign="top">
                                  <table>
                                        <form action="fram_atividade_equip.php" method="post" name="formvd3">
                                        <input name="aba" type="hidden" value="V" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Atividade da Equipe no Site</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Resumo da participação dos funcionários no Site</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Mês/Ano: </strong></td><td>
                                            <input style="width:30px;height:14px;text-align:center;" class="frm_pesq" type="text" name="mes" value="<?php echo date("m");?>" />
                                            <input style="width:40px;height:14px;text-align:center;" class="frm_pesq" type="text" name="ano" value="<?php echo date("Y");?>" />
                                            </td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table>
                                </td>
                                <td width="50%" valign="top">
                                  <table>
                                        <form action="fram_venda_atacado.php" method="post" name="formvd3">
                                        <input name="aba" type="hidden" value="V" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Vendas de Atacado</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Vendas de Atacado com c&aacute;lculo de comiss&otilde;es</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Mês/Ano: </strong></td><td>
                                            <input style="width:30px;height:14px;text-align:center;" class="frm_pesq" type="text" name="mes" value="<?php echo date("m");?>" />
                                            <input style="width:40px;height:14px;text-align:center;" class="frm_pesq" type="text" name="ano" value="<?php echo date("Y");?>" />
                                            </td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" valign="top">
                                    <table>
									<?php 
									
										list($data, $hora) = explode(" ",$dataini);
										list($dia, $mes, $ano) = explode("/",$data);
										$dataini = mktime ( 0, 0, 0, $mes - 1,21, $ano );
												$dataini= strftime("%d/%m/%Y 00:00:00", $dataini);

										
										$datafinal = '20/'.$mes.'/'.$ano.' 23:59:59';
									?>
                                        <form action="fram_frete.php" method="post" name="form12">
                                        <input name="aba" type="hidden" value="A" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Informações de frete </strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todos os cruzamentos de informações de fretes.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data inicial: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:cald.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data final: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafinal" value="<?php echo $datafinal; ?>" /> <a href="javascript:cald2.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
										
                                        </form>
                                         <script language="JavaScript">
                                        <!--
                                        var cald = new calendar1(document.forms['form12'].elements['dataini']);
                                        cald.year_scroll = false;
                                        cald.time_comp = true;
										var cald2 = new calendar1(document.forms['form12'].elements['datafinal']);
                                        cald2.year_scroll = false;
                                        cald2.time_comp = true;
                                        -->
                                        </script>
                                    </table><br />
                                </td>
                                <td width="50%" valign="top">
                                    &nbsp;
                                </td>
                            </tr>
                         </table>
                         <script language="JavaScript">
                            <!--
                            var calvd = new calendar1(document.forms['formvd'].elements['datadiavd']);
                            calvd.year_scroll = true;
                            calvd.time_comp = false;
                            -->
                        </script>
                    </div>
                    
                    <div id="produtos">
                    	<table width="885">
                        	<tr>
                            	<td width="50%" valign="top">
                                    <table>
                                        <form action="fram_maisvendtam.php" method="post" name="formvd2">
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Média Mais Vendidos</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Resumo dos 40 produtos mais vendidos, com qtde total e média mensal por tamanho</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table>
                                </td>
                                <td width="50%" valign="top">
                                    <table>
                                        <form action="fram_maisvend.php" method="post" name="formvd2">
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Produtos Mais Vendidos</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Resumo dos 50 produtos mais vendidos no site com total</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table>
                                </td>
                            </tr>
                            <tr bgcolor="#F7F7F7"><td colspan="2">&nbsp;</td></tr>
                            <tr>
                            	<td width="50%" valign="top">
                                   <table>
                                        <form action="fram_estoqueatual.php" method="post" name="form3">
                                        <input name="aba" type="hidden" value="P" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Estoque Atual</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista o estoque atual da loja escolhida (todos produtos ativos).</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table>
                                    <br />
                                    <table>
                                        <form action="fram_produtosmes.php" method="post" name="formvd2">
                                        <input name="aba" type="hidden" value="V" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Produtos Vendidos</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Resumo de todos os produtos vendidos no Mês</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Mês/Ano: </strong></td><td>
                                            <input style="width:30px;height:14px;text-align:center;" class="frm_pesq" type="text" name="mes" value="<?php echo date("m");?>" />
                                            <input style="width:40px;height:14px;text-align:center;" class="frm_pesq" type="text" name="ano" value="<?php echo date("Y");?>" />
                                            </td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table>
                                </td>
                                <td width="50%" valign="top">
                                	<table>
                                        <form action="fram_prodestoq.php" method="post" name="form0">
                                        <input name="aba" type="hidden" value="P" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Produtos Com Estoque</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todos os produtos cadastros com estoque e quantidade.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><option value="0">Todas</option><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Tipo: </strong></td><td><select name="tipo"><option value="0">Todos</option><?php echo $str_tipos; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Status: </strong></td><td><select name="status"><option value="A">Ativos</option><option value="I">Inativos</option></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Ordenação: </strong></td><td><select name="ordem"><option value="0">Mais Estoque</option><option value="1">Menos Estoque</option><option value="2">Descrição do Produto</option><option value="3">Valor</option></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Categoria: </strong></td><td><select name="catcat"><option value="0">Todas</option><?php echo $strcat; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Tamanho: </strong></td><td><select name="tamtam"><option value="0">Todos</option><?php echo $tamprod; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                            	<td width="50%" valign="top">
                                    <table>
                                        <form action="fram_prodestoq0.php" method="post" name="form1">
                                        <input name="aba" type="hidden" value="P" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Produtos Sem Estoque</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todos os produtos cadastrados que não possuem estoque.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><option value="0">Todas</option><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Tipo: </strong></td><td><select name="tipo"><option value="0">Todos</option><?php echo $str_tipos; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Status: </strong></td><td><select name="status"><option value="A">Ativos</option><option value="I">Inativos</option></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Ordenação: </strong></td><td><select name="ordem"><option value="0">Descrição do Produto</option><option value="1">Valor</option></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table>
                                </td>
                                <td width="50%" valign="top">
                                	<table>
                                        <form action="fram_prodvendas.php" method="post" name="form2">
                                        <input name="aba" type="hidden" value="P" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Produtos Vendidos</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todos os produtos vendidos por período.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><option value="0">Todas</option><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Tipo: </strong></td><td><select name="tipo"><option value="0">Todos</option><?php echo $str_tipos; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Inicial: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:cal1.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Final: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" /> <a href="javascript:cal2.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Ordenação: </strong></td><td><select name="ordem"><option value="0">Mais Vendidos</option><option value="1">Menos Vendidos</option><option value="2">Descrição do Produto</option></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Categoria: </strong></td><td><select name="categ"><option value="0">Todas</option><?php echo $strcat; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Tamanho: </strong></td><td><select name="tamanh"><option value="0">Todos</option><?php echo $tamprod; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Frete: </strong></td><td><select name="frete"><option value="0">Todos</option><option value="1">Com frete</option><option value="2">Sem frete</option></select></td></tr>                                        
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                        <script language="JavaScript">
										<!--
										var cal1 = new calendar1(document.forms['form2'].elements['dataini']);
										cal1.year_scroll = false;
										cal1.time_comp = true;
										
										var cal2 = new calendar1(document.forms['form2'].elements['datafim']);
										cal2.year_scroll = false;
										cal2.time_comp = true;
										-->
										</script>
                                    </table>
                                </td>
                            </tr>
                            <tr bgcolor="#F7F7F7"><td colspan="2">&nbsp;</td></tr>
                            <tr>
                            	<td width="50%" valign="top">
                                   <table>
                                        <form action="fram_prodtam.php" method="post" name="form3">
                                        <input name="aba" type="hidden" value="P" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Produtos Por Tamanhos</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todos os produtos cadastros de acordo com os tamanhos desejados e as respectivas quantidades em estoque.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><option value="0">Todas</option><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Tipo: </strong></td><td><select name="tipo"><option value="0">Todos</option><?php echo $str_tipos; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Tamanho: </strong></td><td><select name="taman"><option value="0">Todos</option><?php echo $str_tam; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Ordenação: </strong></td><td><select name="ordem"><option value="0">Tamanho</option><option value="1">Quantidade</option><option value="2">Descrição do Produto</option></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table>
                                </td>
                                <td width="50%" valign="top">
                                	&nbsp;
                                </td>
                            </tr>
                            <tr><td colspan="2">&nbsp;</td></tr>
                            <tr><td colspan="2">&nbsp;</td></tr>
                        </table>
                    </div>
                    
                    <div id="comercio">
                    	<table width="885">
                        	<tr>
                            	<td width="50%" valign="top">
                                    <table>
                                        <form action="fram_vendasper.php" method="post" name="form4">
                                        <input name="aba" type="hidden" value="C" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Vendas por Período</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todos as vendas realizadas em um período determinado.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <!--<tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>-->
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Inicial: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:cal3.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Final: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" /> <a href="javascript:cal4.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Estado: </strong></td><td>
                                            <select name="estado" class="input" id="estado" style="width:170px;"/>
                                                <option value="Todos" selected="selected">Todos</option> 
                                                <option value="AC">Acre</option> 
                                                <option value="AL">Alagoas</option> 
                                                <option value="AP">Amapá</option> 
                                                <option value="AM">Amazonas</option> 
                                                <option value="BA">Bahia</option> 
                                                <option value="CE">Ceará</option> 
                                                <option value="DF">Distrito Federal</option> 
                                                <option value="ES">Espírito Santo</option> 
                                                <option value="GO">Goiás</option> 
                                                <option value="MA">Maranhão</option> 
                                                <option value="MT">Mato Grosso</option> 
                                                <option value="MS">Mato Grosso do Sul</option> 
                                                <option value="MG">Minas Gerais</option> 
                                                <option value="PA">Pará</option> 
                                                <option value="PB">Paraíba</option> 
                                                <option value="PR">Paraná</option> 
                                                <option value="PE">Pernambuco</option> 
                                                <option value="PI">Piauí</option> 
                                                <option value="RJ">Rio de Janeiro</option> 
                                                <option value="RN">Rio Grande do Norte</option> 
                                                <option value="RS">Rio Grande do Sul</option> 
                                                <option value="RO">Rondônia</option> 
                                                <option value="RR">Roraima</option> 
                                                <option value="SC">Santa Catarina</option> 
                                                <option value="SP">São Paulo</option> 
                                                <option value="SE">Sergipe</option> 
                                                <option value="TO">Tocantins</option> 
                                            </select>	
                                        </td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Forma de Pagamento: </strong></td><td><select name="forma"><option value="0">Todas</option><option value="1">Boleto</option><option value="2">Visa</option><option value="3">Master</option><option value="4">Depósito</option></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Status: </strong></td><td><select name="sta"><option value="0">Todas</option><option value="E">Pagas</option><option value="C">Canceladas</option><option value="A">Em Aberto</option></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Ordenação: </strong></td><td><select name="ordem"><option value="0">Data</option><option value="1">Maior Compra</option><option value="2">Menor Compra</option><option value="3">Nome</option></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                        <script language="JavaScript">
                                        <!--
                                        var cal3 = new calendar1(document.forms['form4'].elements['dataini']);
                                        cal3.year_scroll = false;
                                        cal3.time_comp = true;
                                        
                                        var cal4 = new calendar1(document.forms['form4'].elements['datafim']);
                                        cal4.year_scroll = false;
                                        cal4.time_comp = true;
                                        -->
                                        </script>
                                    </table><BR />
                                </td>
                                <td width="50%" valign="top">
                                    <table>
                                        <form action="fram_vendasestado.php" method="post" name="form5">
                                        <input name="aba" type="hidden" value="C" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Vendas por Estados</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista a quantidade de produtos vendidos por estados.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <!--<tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>-->
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Inicial: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:cal5.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Final: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" /> <a href="javascript:cal6.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Tipo: </strong></td><td><select name="tipo"><option value="0">Todos</option><?php echo $str_tipos; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                        <script language="JavaScript">
                                        <!--
                                        var cal5 = new calendar1(document.forms['form5'].elements['dataini']);
                                        cal5.year_scroll = false;
                                        cal5.time_comp = true;
                                        
                                        var cal6 = new calendar1(document.forms['form5'].elements['datafim']);
                                        cal6.year_scroll = false;
                                        cal6.time_comp = true;
                                        -->
                                        </script>
                                    </table><BR />
                                 </td>
                             </tr>
                             <tr>
                             	<td width="50%" valign="top">
                                    <table>
                                        <form action="fram_vendascategoria.php" method="post" name="formcat1">
                                        <input name="aba" type="hidden" value="C" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Vendas por Categoria/Tamanho</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todas a vendas realizadas por categoria/tamanho.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <!--<tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>-->
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Inicial: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:calcat.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Final: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" /> <a href="javascript:calcat2.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Categoria: </strong></td><td><select name="categ"><option value="0">Todos</option><?php echo $strcat; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Tamanho: </strong></td><td><select name="tampp"><option value="0">Todos</option><?php echo $tamprod; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                        <script language="JavaScript">
                                        <!--
                                        var calcat = new calendar1(document.forms['formcat1'].elements['dataini']);
                                        calcat.year_scroll = false;
                                        calcat.time_comp = true;
                                        
                                        var calcat2 = new calendar1(document.forms['formcat1'].elements['datafim']);
                                        calcat2.year_scroll = false;
                                        calcat2.time_comp = true;
                                        -->
                                        </script>
                                    </table><BR />
                                 </td>
                                 
                                 <td width="50%" valign="top">
                                    <table>
                                        <form action="fram_vendascliente.php" method="post" name="formcli">
                                        <input name="aba" type="hidden" value="C" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Vendas por Cliente</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista a quantidade de produtos vendidos por Cliente.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <!--<tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>-->
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Inicial: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:calcli.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Final: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" /> <a href="javascript:calcli2.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Cliente: </strong></td><td><select name="tipo"><option value="0">Todos</option><?php echo $str_cliente; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                        <script language="JavaScript">
                                        <!--
                                        var calcli = new calendar1(document.forms['formcli'].elements['dataini']);
                                        calcli.year_scroll = false;
                                        calcli.time_comp = true;
                                        
                                        var calcli2 = new calendar1(document.forms['formcli'].elements['datafim']);
                                        calcli2.year_scroll = false;
                                        calcli2.time_comp = true;
                                        -->
                                        </script>
                                    </table><BR />
                                 </td>
                                 
                             </tr>
                        </table>
                    </div>
<!-- //***** ABA CONTAS ADM                   -->
                   <div id="adm">
                    	<table width="885">
                        
                        <tr>
                            	<td width="50%" valign="top">
                                    <table>
                                        <form action="fram_movdia.php" method="post" name="formdia">
                                        <input name="aba" type="hidden" value="A" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Movimento do dia</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todas as contas a pagar e recebidas por vencimento, e as compras pagas por data do status em determinado dia por loja.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Dia: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:caldia.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                        <script language="JavaScript">
                                        <!--
                                        var caldia = new calendar1(document.forms['formdia'].elements['dataini']);
                                        caldia.year_scroll = false;
                                        caldia.time_comp = true;
                                        
                                        -->
                                        </script>
                                    </table><BR />
                                </td>
                                <td width="50%" valign="top">
                                    <table>
                                        <form action="fram_movmes.php" method="post" name="formmes">
                                        <input name="aba" type="hidden" value="A" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Movimento Mensal</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todas as contas a pagar e recebidas por vencimento, e as compras pagas por data do status em determinado mês por loja.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Mês: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:calmes.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                        <script language="JavaScript">
                                        <!--
                                        var calmes = new calendar1(document.forms['formmes'].elements['dataini']);
                                        calmes.year_scroll = false;
                                        calmes.time_comp = true;
                                        
                                        
                                        -->
                                        </script>
                                    </table><BR />
                                 </td>
                             </tr>
                        
                        	<tr>
                            	<td width="50%" valign="top">
                                    <table>
                                        <form action="fram_contaspagar.php" method="post" name="form6">
                                        <input name="aba" type="hidden" value="A" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Contas a Pagar</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todas as contas a pagar por loja em um período determinado por vencimento.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Inicial: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:cal7.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Final: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" /> <a href="javascript:cal8.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                        <script language="JavaScript">
                                        <!--
                                        var cal7 = new calendar1(document.forms['form6'].elements['dataini']);
                                        cal7.year_scroll = false;
                                        cal7.time_comp = true;
                                        
                                        var cal8 = new calendar1(document.forms['form6'].elements['datafim']);
                                        cal8.year_scroll = false;
                                        cal8.time_comp = true;
                                        -->
                                        </script>
                                    </table><BR />
                                </td>
                                <td width="50%" valign="top">
                                    <table>
                                        <form action="fram_contasreceber.php" method="post" name="form7">
                                        <input name="aba" type="hidden" value="A" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Contas a Receber</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todas as contas a receber por loja em um período determinado.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Inicial: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:cal9.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Final: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" /> <a href="javascript:cal10.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                        <script language="JavaScript">
                                        <!--
                                        var cal9 = new calendar1(document.forms['form7'].elements['dataini']);
                                        cal9.year_scroll = false;
                                        cal9.time_comp = true;
                                        
                                        var cal10 = new calendar1(document.forms['form7'].elements['datafim']);
                                        cal10.year_scroll = false;
                                        cal10.time_comp = true;
                                        -->
                                        </script>
                                    </table><BR />
                                 </td>
                             </tr>
                             
                             
                             <tr>
                            	<td width="50%" valign="top">
                                    <table>
                                        <form action="fram_contaspagas.php" method="post" name="formp">
                                        <input name="aba" type="hidden" value="A" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Contas Pagas</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todas as contas Pagas por loja em um período determinado por vencimento.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Inicial: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:calp1.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Final: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" /> <a href="javascript:calp2.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                        <script language="JavaScript">
                                        <!--
                                        var calp1 = new calendar1(document.forms['formp'].elements['dataini']);
                                        calp1.year_scroll = false;
                                        calp1.time_comp = true;
                                        
                                        var calp2 = new calendar1(document.forms['formp'].elements['datafim']);
                                        calp2.year_scroll = false;
                                        calp2.time_comp = true;
                                        -->
                                        </script>
                                    </table><BR />
                                </td>
                                <td width="50%" valign="top">
                                    <table>
                                        <form action="fram_contasrecebidas.php" method="post" name="formr">
                                        <input name="aba" type="hidden" value="A" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Contas Recebidas</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todas as contas Recebidas por loja em um período determinado.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Inicial: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:calr1.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Final: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" /> <a href="javascript:calr2.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                        <script language="JavaScript">
                                        <!--
                                        var calr1 = new calendar1(document.forms['formr'].elements['dataini']);
                                        calr1.year_scroll = false;
                                        calr1.time_comp = true;
                                        
                                        var calr2 = new calendar1(document.forms['formr'].elements['datafim']);
                                        calr2.year_scroll = false;
                                        calr2.time_comp = true;
                                        -->
                                        </script>
                                    </table><BR />
                                 </td>
                             </tr>
                             
                             
                             <tr>
                            	<td width="50%" valign="top">
                                    <table>
                                        <form action="fram_contasunificadas.php" method="post" name="form8">
                                        <input name="aba" type="hidden" value="A" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Contas a Unificadas</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todas as contas unificadas por loja em um período determinado.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Inicial: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:cal11.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Final: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" /> <a href="javascript:cal12.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                        <script language="JavaScript">
                                        <!--
                                        var cal11 = new calendar1(document.forms['form8'].elements['dataini']);
                                        cal11.year_scroll = false;
                                        cal11.time_comp = true;
                                        
                                        var cal12 = new calendar1(document.forms['form8'].elements['datafim']);
                                        cal12.year_scroll = false;
                                        cal12.time_comp = true;
                                        -->
                                        </script>
                                    </table><BR />
                                </td>
                                <td width="50%" valign="top">
                                    <table>
                                        <form action="fram_contasespecificas.php" method="post" name="form9">
                                        <input name="aba" type="hidden" value="A" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Contas Específicas</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todas as contas específicas por loja em um período determinado.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Inicial: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:calA.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Final: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" /> <a href="javascript:calB.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Específica: </strong></td><td><select name="categoria"><?php echo $contascat; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                        <script language="JavaScript">
                                        <!--
                                        var calA = new calendar1(document.forms['form9'].elements['dataini']);
                                        calA.year_scroll = false;
                                        calA.time_comp = true;
                                        
                                        var calB = new calendar1(document.forms['form9'].elements['datafim']);
                                        calB.year_scroll = false;
                                        calB.time_comp = true;
                                        -->
                                        </script>
                                    </table><BR />
                                </td>
                             </tr>
                             <tr>
                             	<td width="50%" valign="top">
                                    <table>
                                        <form action="fram_contassubcontas.php" method="post" name="form10">
                                        <input name="aba" type="hidden" value="A" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Subcontas Específicas</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todas as subcontas específicas por loja em um período determinado.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Inicial: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="dataini" value="<?php echo $dataini; ?>" /> <a href="javascript:calc.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Final: </strong></td><td><input style="width:100px;height:14px;text-align:center;" class="frm_pesq" type="text" name="datafim" value="<?php echo $datafim; ?>" /> <a href="javascript:cald.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Clique aqui para escolher a data" align="absmiddle"></a></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Específica: </strong></td><td><select name="subcategoria"><?php echo $contassubcat; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                        <script language="JavaScript">
                                        <!--
                                        var calc = new calendar1(document.forms['form10'].elements['dataini']);
                                        calc.year_scroll = false;
                                        calc.time_comp = true;
                                        
                                        var cald = new calendar1(document.forms['form10'].elements['datafim']);
                                        cald.year_scroll = false;
                                        cald.time_comp = true;
                                        -->
                                        </script>
                                    </table><BR />
                                </td>
                                <td width="50%" valign="top">
                                    <table>
                                        <form action="fram_pontos.php" method="post" name="form11">
                                        <input name="aba" type="hidden" value="A" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Pontos de clientes </strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todos os clientes com a quantidade de pontos.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table><BR />
                                </td>
                             </tr>
                             
                            <tr>
                             	<td width="50%" valign="top">
                                    &nbsp;
                                </td>
                             </tr>                              
                        </table>
                    </div>
<!-- //***** FIM ABA CONTAS ADM                   -->

                    <div id="marketing">
                        <table width="885">
                        	<tr>
                            	<td width="50%" valign="top">
                                    <table>
                                        <form action="fram_vendasgenero.php" method="post" name="form13">
                                        <input name="aba" type="hidden" value="M" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Vendas por Sexo</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista todos as vendas realizadas em um período determinado de cada sexo.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Loja: </strong></td><td><select name="loja"><?php echo $str_lojas; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Inicial: </strong></td><td><input style="width:140px;height:14px;text-align:center;" class="frm_pesq" name="dataini" value="<?php echo $dataini; ?>" /></td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Data Final: </strong></td><td><input style="width:140px;height:14px;text-align:center;" class="frm_pesq" name="datafim" value="<?php echo $datafim; ?>" /></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table><br />
                                    
                                </td>
                                <td width="50%" valign="top">
                                    <table>
                                        <form action="clientes_maiores_comp.php" method="post" name="form14">
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Maiores Compradores</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista os maiores compradores do site até a presente data.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Lista dos Maiores Compradores" /></td></tr>
                                        </form>
                                    </table><br />
                                    <table>
                                        <form action="clientes_maiores_band.php" method="post" name="form14">
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Maiores Compradores Tshirts Banda</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista os maiores compradores de tshirts de Bandas do site até a presente data.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Lista dos Maiores Compradores Bandas" /></td></tr>
                                        </form>
                                    </table><br />
                                </td>
                             </tr>
                             <tr>
                             	<td width="50%" valign="top">
                                    <table>
                                        <form action="clientes_nunca_comp_m.php" method="post" name="form14">
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Homens que nunca Compraram (<?php echo $totcadsM ?>)</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista os cadastros masculinos que nunca realizaram compras.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Lista" /></td></tr>
                                        </form>
                                    </table><br />
                                    <table>
                                        <form action="clientes_nunca_comp_f.php" method="post" name="form14">
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Mulheres que nunca Compraram (<?php echo $totcadsF ?>)</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista os cadastros femininos que nunca realizaram compras.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Lista" /></td></tr>
                                        </form>
                                    </table><br />
                                 </td>
                                 
                                 <td width="50%" valign="top">
                                     <table>
                                        <form action="clientes_nao_comp1ano_m.php" method="post" name="form14">
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Homens que não compram a 1 ano (<?php echo $totcadsM1 ?>)</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista os cadastros masculinos que não realizam compras a 1 ano.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Lista" /></td></tr>
                                        </form>
                                    </table><br />
                                    <table>
                                        <form action="clientes_nao_comp1ano_f.php" method="post" name="form14">
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Mulheres que não compram a 1 ano (<?php echo $totcadsF1 ?>)</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista os cadastros femininos que não realizam compras a 1 ano.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Lista" /></td></tr>
                                        </form>
                                    </table><br />
                                 </td>
                                 
                             </tr>
                             <tr>
                             	<td width="50%" valign="top">
                                  <table>
                                        <form action="clientes_compras6meses_f.php" method="post" name="form14">
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Mulheres que que realizaram compras a 6 meses (<?php echo $totcadsF6 ?>)</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista os cadastros femininos que realizaram compras a 6 meses.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Lista" /></td></tr>
                                        </form>
                                    </table><br />
                                    <table>
                                        <form action="clientes_compras6meses_m.php" method="post" name="form14">
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Homens que que realizaram compras a 6 meses (<?php echo $totcadsM6 ?>)</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista os cadastros masculinos que realizaram compras a 6 meses.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Lista" /></td></tr>
                                        </form>
                                    </table><br />
                                 </td>
                                 
                                 <td width="50%" valign="top">
                                    <table>
                                        <form action="clientes_maiores_comp_estado.php" method="post" name="form14">
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Maiores Compradores</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Lista os 5 maiores compradores do site de cada estado (fora lojistas).</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Lista dos 5 Maiores Compradores" /></td></tr>
                                        </form>
                                    </table><br />
                                    <table>
                                        <form action="fram_novoscadastros.php" method="post" name="form13">
                                        <input name="aba" type="hidden" value="M" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Novos Cadastros</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Mostra a quantidade de cadastros realizados no mês por sexo.</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Mês/Ano: </strong></td><td>
                                            <input style="width:30px;height:14px;text-align:center;" class="frm_pesq" type="text" name="mes" value="<?php echo date("m");?>" />
                                            <input style="width:40px;height:14px;text-align:center;" class="frm_pesq" type="text" name="ano" value="<?php echo date("Y");?>" />
                                            </td></tr>
                                        <tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table>
                                 </td>
                                 
                             </tr>
                             <tr>
                             	<td width="50%" valign="top">
                                   <table>
                                        <form action="fram_maisvendidos.php" method="post" name="form13">
                                        <input name="aba" type="hidden" value="M" />
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2"><strong>Produtos Mais Vendidos</strong></td></tr>
                                        <tr><td width="30">&nbsp;</td><td colspan="2">Mostra uma listagem com os produtos mais vendidos</td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                        <tr><td width="30">&nbsp;</td><td><strong>Tipo do produto: </strong></td><td><select name="tipo"><option value="0">Todos</option><?php echo $str_tipos; ?></select></td></tr>
                                        <tr><td width="30">&nbsp;</td><td>&nbsp;</td><td><input class="frm_pesq" type="submit" value="Exibir Relat&oacute;rio" /></td></tr>
                                        </form>
                                    </table><br />
                                 </td>
                                 
                                 <td width="50%" valign="top">
                                    &nbsp;<br />
                                 </td>
                                 
                             </tr>
                        </table>
                    </div>            
                    
                    <script>
                      defineAba("abaVend","vendas");
					  defineAba("abaProd","produtos");
                      defineAba("abaCome","comercio");
					  defineAba("abaAdm","adm");
                      defineAba("abaMkt","marketing");
					  <?php
					  switch($aba){
					  	case "V":
							echo "defineAbaAtiva(\"abaVend\");";
							break;
                        case "P":
							echo "defineAbaAtiva(\"abaProd\");";
							break;
						case "C":
							echo "defineAbaAtiva(\"abaCome\");";
							break;
						case "A":
							echo "defineAbaAtiva(\"abaAdm\");";
							break;
                        case "M":
							echo "defineAbaAtiva(\"abaMkt\");";
							break;
					  }
					  ?>
                    </script>
                </div>
              	
				</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>
<script>
   $(":date").dateinput({ format: 'dd/mm/yyyy' });
</script>
<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>
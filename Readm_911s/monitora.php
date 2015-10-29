<?php
include 'auth.php';
include 'lib.php';
?>
<?php include 'topo.php'; ?>
<script type='text/javascript' src='scripts/autocomplete/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='scripts/autocomplete/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='scripts/autocomplete/thickbox-compressed.js'></script>
<script type='text/javascript' src='scripts/autocomplete/jquery.autocomplete.js'></script>
<script type='text/javascript' src='scripts/autocomplete/jquery.functions-monit.js'></script>
<link rel="stylesheet" type="text/css" href="scripts/autocomplete/jquery.autocomplete.css" />
<script language="JavaScript" src="calendar1.js"></script>
<style>
   #cesta {
        width: 700px;
        float: left;
        font-family: Verdana;
        font-size: 12px;
    }
  
    
    .form_pedido {
	width:80px; height:20px;
	border:1px solid #dad7cf;
	font:13px Verdana, Helvetica, sans-serif;
	padding:4px;
	}
</style>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Monitoramento</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">PRODUTOS</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <form autocomplete="off" style="padding: 10px;" name="form1" id="form1" action="monitora_inc.php" method="post">
                    <input type="hidden" name="cestaitens" id="cestaitens" value="" />
                    <div id="Ver">
                    
                    <div style="width: 1100px;">
                    
                    <div id="cesta" style="clear: both; margin-bottom: 30px;">
                    
                    <p>
            			Escolha o Produto:<br />
            			<input type="text" id='imageSearch' name='imageSearch' class="form_pedido" style="width: 370px;" />
            			<input type="submit" value="Adicionar" class="form_pedido" style="margin: 0; height: 35px; vertical-align: middle;" />
            		</p>
                    
                    </div>
                    
                    <div style="clear: both; margin-top: 30px;">
                        <table style="width: 900px;" class="prodmon">
                            <tr>
                                <td><strong>Img</strong></td>
                                <td style="text-align: left;"><strong>Produto</strong></td>
                                <td><strong>Estoque</strong></td>
                                <td><strong>Visitas Tot</strong></td>
                                <td><strong>Visitas Mon</strong></td>
                                <td><strong>Vendas 30d</strong></td>
                                <td><strong>Vendas Mês</strong></td>
                                <td><strong>Vendas Hoje</strong></td>
                                <td><strong>Remover</strong></td>
                            </tr>
                            <?php
                            $sql = "select NR_SEQ_PRODUTO_PRRC, DS_CATEGORIA_PTRC, VL_PRODUTO_PRRC,
					  				 DS_PRODUTO2_PRRC, DS_EXT_PRRC, VL_PROMO_PRRC, DS_CATEGORIA_PCRC, NR_VISITAS_PRRC, NR_VISITASINI_MOPR
                                        from produtos, produtos_tipo, produtos_categoria, produtos_monitora
									 WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC
                                     AND NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_MOPR order by DS_PRODUTO2_PRRC";
                            $st = mysql_query($sql);
                            if (mysql_num_rows($st) > 0) {
						  	   while($row = mysql_fetch_row($st)) {
    							 $id_prod	   = $row[0];
    							 $ds_tipo	   = $row[1];
    							 $vl_prod	   = $row[2];
    							 $ds_prod	   = $row[3];
    							 $ext		   = $row[4];
    							 $vlrpromo	   = $row[5];
                                 $ds_categ	   = $row[6];
                                 $visitas	   = $row[7];
                                 $visitasini   = $row[8];
                                 if (!$visitas) $visitas = 0;
                                 if (!$visitasini) $visitasini = 0;
                                 
                                 $sql2 = "SELECT sum(NR_QTDE_ESRC) from estoque WHERE NR_SEQ_PRODUTO_ESRC = $id_prod";
    							 $st2 = mysql_query($sql2);
    							 if (mysql_num_rows($st2) > 0) {
    							 	$row2 = mysql_fetch_row($st2);
    								$estoq = $row2[0];
    								if (!$estoq) $estoq = 0;
    							 }else{
    							 	$estoq = 0;
    							 }
                                 
                                 $sql2 = "SELECT SUM(NR_QTDE_CESO) FROM compras, cestas WHERE NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                                          AND NR_SEQ_LOJA_COSO = 1 AND ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A' AND YEAR(DT_COMPRA_COSO) = YEAR(SYSDATE())
                                          AND MONTH(DT_COMPRA_COSO) = MONTH(SYSDATE()) AND DAY(DT_COMPRA_COSO) = DAY(SYSDATE())
                                          AND NR_SEQ_PRODUTO_CESO = $id_prod AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)";
    							 $st2 = mysql_query($sql2);
    							 if (mysql_num_rows($st2) > 0) {
    							 	$row2 = mysql_fetch_row($st2);
    								$vendashj = $row2[0];
    								if (!$vendashj) $vendashj = 0;
    							 }else{
    							 	$vendashj = 0;
    							 }
                                 $sql2 = "SELECT SUM(NR_QTDE_CESO) FROM compras, cestas WHERE NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                                          AND NR_SEQ_LOJA_COSO = 1 AND ST_COMPRA_COSO = 'A' AND YEAR(DT_COMPRA_COSO) = YEAR(SYSDATE())
                                          AND MONTH(DT_COMPRA_COSO) = MONTH(SYSDATE()) AND DAY(DT_COMPRA_COSO) = DAY(SYSDATE())
                                          AND NR_SEQ_PRODUTO_CESO = $id_prod AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)";
    							 $st2 = mysql_query($sql2);
    							 if (mysql_num_rows($st2) > 0) {
    							 	$row2 = mysql_fetch_row($st2);
    								$vendashj2 = $row2[0];
    								if (!$vendashj2) $vendashj2 = 0;
    							 }else{
    							 	$vendashj2 = 0;
    							 }
                                 
                                 $sql2 = "SELECT SUM(NR_QTDE_CESO) FROM compras, cestas WHERE NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                                          AND NR_SEQ_LOJA_COSO = 1 AND ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A' AND YEAR(DT_COMPRA_COSO) = YEAR(SYSDATE())
                                          AND MONTH(DT_COMPRA_COSO) = MONTH(SYSDATE())
                                          AND NR_SEQ_PRODUTO_CESO = $id_prod AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)";
    							 $st2 = mysql_query($sql2);
    							 if (mysql_num_rows($st2) > 0) {
    							 	$row2 = mysql_fetch_row($st2);
    								$vendasmes = $row2[0];
    								if (!$vendasmes) $vendasmes = 0;
    							 }else{
    							 	$vendasmes = 0;
    							 }
                                 $sql2 = "SELECT SUM(NR_QTDE_CESO) FROM compras, cestas WHERE NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                                          AND NR_SEQ_LOJA_COSO = 1 AND ST_COMPRA_COSO = 'A' AND YEAR(DT_COMPRA_COSO) = YEAR(SYSDATE())
                                          AND MONTH(DT_COMPRA_COSO) = MONTH(SYSDATE())
                                          AND NR_SEQ_PRODUTO_CESO = $id_prod AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)";
    							 $st2 = mysql_query($sql2);
    							 if (mysql_num_rows($st2) > 0) {
    							 	$row2 = mysql_fetch_row($st2);
    								$vendasmes2 = $row2[0];
    								if (!$vendasmes2) $vendasmes2 = 0;
    							 }else{
    							 	$vendasmes2 = 0;
    							 }
                                 
                                 $sql2 = "SELECT SUM(NR_QTDE_CESO) FROM compras, cestas WHERE NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                                          AND NR_SEQ_LOJA_COSO = 1 AND ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A'
                                          AND DT_COMPRA_COSO > DATE_SUB(SYSDATE(), INTERVAL 30 DAY)
                                          AND NR_SEQ_PRODUTO_CESO = $id_prod AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)";
    							 $st2 = mysql_query($sql2);
    							 if (mysql_num_rows($st2) > 0) {
    							 	$row2 = mysql_fetch_row($st2);
    								$vendas30 = $row2[0];
    								if (!$vendas30) $vendas30 = 0;
    							 }else{
    							 	$vendas30 = 0;
    							 }
                                 $sql2 = "SELECT SUM(NR_QTDE_CESO) FROM compras, cestas WHERE NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                                          AND NR_SEQ_LOJA_COSO = 1 AND ST_COMPRA_COSO = 'A'
                                          AND DT_COMPRA_COSO > DATE_SUB(SYSDATE(), INTERVAL 30 DAY)
                                          AND NR_SEQ_PRODUTO_CESO = $id_prod AND NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)";
    							 $st2 = mysql_query($sql2);
    							 if (mysql_num_rows($st2) > 0) {
    							 	$row2 = mysql_fetch_row($st2);
    								$vendas302 = $row2[0];
    								if (!$vendas302) $vendas302 = 0;
    							 }else{
    							 	$vendas302 = 0;
    							 }
                            ?>
                            <tr>
                                <td>
                                    <?php if ($ext == "swf") {?>
                                      <object data="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ext; ?>" type="application/x-shockwave-flash" width="31" height="36">
                                        <param name="quality" value="high" />
                                        <param name="flashvars" value="URLname=<?php echo $id_prod; ?>" />
                                        <param name="movie" value="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ext; ?>" />
                                        <param name="wmode" value="opaque" />
                                      </object>
                                    <?php }else{ ?>
                                	<img src="..../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ext; ?>" width="31" height="36" border="0" />
                                	<?php } ?>
                                </td>
                                <td style="text-align: left;"><?php echo $ds_tipo; ?>/<?php echo $ds_categ; ?>/<?php echo $ds_prod; ?></td>
                                <td><strong><?php echo $estoq; ?></strong></td>
                                <td><?php echo $visitas; ?></td>
                                <td><?php echo ($visitas-$visitasini); ?></td>
                                <td><strong><?php echo $vendas30; ?><?php if ($vendas302 > 0) echo " ($vendas302)";?></strong></td>
                                <td><strong><?php echo $vendasmes; ?><?php if ($vendasmes2 > 0) echo " ($vendasmes2)";?></strong></td>
                                <td><strong><?php echo $vendashj; ?><?php if ($vendashj2 > 0) echo " ($vendashj2)";?></strong></td>
                                <td style="width: 25px;"><a href="monitora_del.php?p=<?php echo $id_prod; ?>" title="Excluir Monitoramento"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
                    
                    </div> <!-- /ver -->
                    
                    </form>
                  
					<script>
					  defineAba("abaVer","Ver");
                      defineAba("abaCriar","Criar");
					  <?php
					  switch($aba){
					  	  case 1:
						  	  echo "defineAbaAtiva(\"abaCriar\");";
							  break;
						  case 2:
						  	  echo "defineAbaAtiva(\"abaVer\");";
							  break;
						  default:
						  	  echo "defineAbaAtiva(\"abaVer\");";
							  break;
					   }
					  ?>
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>
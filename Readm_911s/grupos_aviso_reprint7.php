<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$aba = request("aba");

$PHP_SELF = "grupos_aviso_reprint7.php";

$html = "";
?>
<?php include 'topo.php'; ?>
<link href="../css/shopmenu.css" rel="stylesheet" type="text/css" />
<link href="../css/shop_new.css" rel="stylesheet" type="text/css" />
<style>

#shop .produto {
	width:120px;
	float:left;
	height:171px;
	background:#FFFFFF;
	border: solid 1px #6b4922;
	padding: 4px;
	margin: 0 0 10px 0;
}

	#shop .produto img {
		margin:0;
		padding:0;
	}

#shop .preco-produto {
	float:left;
	width:30px;
	margin:10px 0 0 0;
	padding:0;
}

#shop .desc-produto {
	float:left;
	margin: 10px 0 0 10px;
	padding:0;
}
</style>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" onMouseOver="trataMouseAba(this);" class="abaativa">Avise-me Reprint</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li style="width: 120px;" id="menuDepo2" onMouseOver="trataMouseAba(this);" class="abainativa" onclick="document.location.href='grupos_aviso_reprint.php'">Tees Bandas</li>
                      <li style="width: 120px;" id="menuDepo3" onMouseOver="trataMouseAba(this);" class="abainativa" onclick="document.location.href='grupos_aviso_reprint2.php'">Inverno</li>
                      <li style="width: 120px;" id="menuDepo1" onMouseOver="trataMouseAba(this);" class="abainativa" onclick="document.location.href='grupos_aviso_reprint3.php'">Podrinhas</li>
                      <li style="width: 120px;" id="menuDepo4" onMouseOver="trataMouseAba(this);" class="abainativa" onclick="document.location.href='grupos_aviso_reprint4.php'">Chinelos</li>
                      <li style="width: 120px;" id="menuDepo5" onMouseOver="trataMouseAba(this);" class="abainativa" onclick="document.location.href='grupos_aviso_reprint5.php'">Canecas</li>
                      <li style="width: 120px;" id="menuDepo6" onMouseOver="trataMouseAba(this);" class="abainativa" onclick="document.location.href='grupos_aviso_reprint6.php'">Almofadas</li>
                      <li style="width: 120px;" id="menuDepo7" onMouseOver="trataMouseAba(this);" class="abaativa">Eco Bags</li>
                      <li style="width: 120px;" id="menuDepo8" onMouseOver="trataMouseAba(this);" class="abainativa" onclick="document.location.href='grupos_aviso_reprint8.php'">S&eacute;ries</li>
                    </ul>
                </td>
            </tr>
        </table>
                
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
            <tr>
            	<td align="left" colspan="2">
                <table width="880">
                        	<tr>
                            	<?php 
								$desc = request("desc");
								
								?>
                            	<form action="grupos_aviso_reprint2.php" method="post" name="frm">
                                <td height="20" align="right" valign="middle">
                                    <strong>Procurar por:</strong>
                                    <input style="width:120px;height:14px;" class="frm_pesq" type="text" name="desc" id="desc" value="<?php echo $desc; ?>" />
                                    <input name="Pesquisar" type="image" src="img/ico_search.gif" alt="Pesquisar" align="absmiddle" />
                                </td></form>
                            </tr>
                        </table>
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                <div id="Ver">
                <div id="shop" style="background-color: white;">
                <div id="listaprodutos" style="width: 990px;">
                
							<?php
                            $num_por_pagina = 1000;
                            if (!$pagina) {
                               $pagina = 1;
                            }
                            $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
                                  
                            $sql = "select NR_SEQ_PRODUTO_PRRC, VL_PRODUTO_PRRC, DS_PRODUTO2_PRRC, DS_EXT_PRRC, TP_DESTAQUE_PRRC, DS_FRETEGRATIS_PRRC, VL_PROMO_PRRC, count(*) as total, DS_CATEGORIA_PTRC 
                            from aviseme, produtos, produtos_tipo where NR_SEQ_PRODUTO_AVRC = NR_SEQ_PRODUTO_PRRC and NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
                            and (NR_SEQ_TIPO_PRRC = 60) AND ST_JACOMPROU_AVRC = 'N' and NR_SEQ_LOJAS_PRRC = $SS_loja ";
                            if ($desc) $sql .= " AND DS_PRODUTO2_PRRC LIKE '%".$desc."%' ";
                            $sql .= " GROUP BY NR_SEQ_PRODUTO_AVRC order by total desc";
      
                            $st = mysql_query($sql);
                            if (mysql_num_rows($st) > 0) {
                                $marg_es = 10;
                                $marg_to = 0;
                                $totp = 0;
                                $qtde_total = 0;
                                while($row = mysql_fetch_row($st)) {
                                    $id_prod	   = $row[0];
                                    $vl_prod	   = Valor_Produto($row[0],$SS_logado);
                                    $ds_prod	   = $row[2];
                                    $ds_ext		   = $row[3];
                                    $destaque	   = $row[4];
                                    $fretegratis   = $row[5];
                                    $vlrpromo	   = $row[6];
                                    $qtde_estoq    = $row[7];
                                    $ds_categoria  = $row[8];
                                    
                                    $qtde_total += $qtde_estoq;
                                    
                                    switch ($destaque) {
                                        case 0:
                                            $destaque = "";
                                            break;
                                        case 1:
                                            $destaque = "n";
                                            break;
                                        case 2:
                                            $destaque = "s";
                                            break;
                                        case 3:
                                            $destaque = "r";
                                            break;
                                    }
                                    
                                    if ($vlrpromo > 0){
                                        $vl_prod = $vlrpromo;
                                    }
                                    
                                    $est = "select sum(NR_QTDE_ESRC) from estoque where NR_SEQ_PRODUTO_ESRC = $id_prod";
                                    $stes = mysql_query($est);
                                    $rowes = mysql_fetch_row($stes);
                                    $totalest = 0;
                                    $totalest = $rowes[0];
                                    
                                    $strtmanahos = "";
                                    $est = "select DS_SIGLA_TARC, count(*), DS_TAMANHO_TARC from aviseme, tamanhos where 
                                            NR_SEQ_TAMANHO_AVRC = NR_SEQ_TAMANHO_TARC and NR_SEQ_PRODUTO_AVRC = $id_prod  AND ST_JACOMPROU_AVRC = 'N'
                                            group by NR_SEQ_TAMANHO_AVRC";
                                    $stes = mysql_query($est);
                                    if (mysql_num_rows($stes) > 0) {
                                        while($rowes = mysql_fetch_row($stes)) {
                                            $tam = $rowes[0];
                                            $tamtot = $rowes[1];
                                            $dstam = $rowes[2];
                                            $strtmanahos .= "<strong>".$dstam[0]."</strong>".$tam."(".$tamtot.") ";
                                        }
                                    }
                                    ?>
                                    <div class="produto"  style="margin: 0 0 7px 6px;position: relative; z-index:1; height: 265px;">
                                    <div style="text-align: center; clear: both; width: 100%;"><strong><?php echo $qtde_estoq ?> (<?php echo $totalest ?>)</strong></div>
                                    <div style="text-align: center; clear: both; width: 100%; font-size: 11px;"><?php echo $strtmanahos ?></div>
                                  	  <?php if ($ds_ext == "swf") {?>
                                      <object data="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ds_ext; ?>" type="application/x-shockwave-flash" width="180" height="210">
                                        <param name="quality" value="high" />
                                        <param name="flashvars" value="URLname=<?php echo $id_prod; ?>" />
                                        <param name="movie" value="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ds_ext; ?>" />
                                        <param name="wmode" value="opaque" />
                                    </object>
                                      <?php }else{ 
                                      $ds_categoria = str_replace("&","e;",$ds_categoria);
                                      $ds_prod_url = str_replace("&","e;",$ds_prod);
                                      ?>
                                      <a href="grupos_aviso3.php?ch=1&palavra=<?php echo $ds_prod_url; ?>"><img src="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ds_ext; ?>" border="0" alt="<?php echo $ds_prod; ?>" width="120" /></a>
                                      <?php } ?>
                                      <div class="preco-produto" style="margin: 3px 0 0 0;">
                                         
                                      </div>
                                      <div class="desc-produto" style="margin: 3px 0 0 5px;">
                                        <p><a href="grupos_aviso3.php?ch=1&palavra=<?php echo $ds_prod_url; ?>" target="_blank"><?php echo $ds_prod; ?></a>
                                        <?php if ($fretegratis == "S") echo "<span class=\"promocao\" style=\"margin:0;padding:0\"><strong>FRETE GRÁTIS</strong></span>"; ?>
                                        </p>
                                      </div>
                                      <div style="text-align: center; width: 100%; vertical-align: bottom; clear: both;"><strong>R$ <?php echo number_format($qtde_estoq*$vl_prod,2,",","."); ?></strong></div>
                                  </div>
                                  
                                  <?php
                                    //$totp += 1;
                                    //$marg_es += 195;
                                   // if ($totp == 5 || $totp == 10 || $totp == 15 || $totp == 20 || $totp == 25 || $totp == 30 || $totp == 35 || $totp == 40 || $totp == 45) {
                                   //     $marg_es = 10;
                                   //     $marg_to += 280;
                                   // }
                                }
                            }?>           
                       </div>
                     </div> 
      
                </div> <!-- /ver -->
                
					<script>
					  defineAba("abaVer","Ver");
                    </script>
                    
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                
                <br />
                </td>
            </tr>
        </table>

<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>
<?php 
include '../Readm_911s/lib.php';
include '../Readm_911s/auth.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reverbcity - Shop</title>
<script type="text/javascript" src="../scripts/jquery.js"></script>

<link href="../css/geral.css" rel="stylesheet" type="text/css" />
<link href="../css/shopmenu.css" rel="stylesheet" type="text/css" />
<link href="../css/shop_new.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
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
</head>

<body style="background: none;">
<?php 
$tip = 4;
$cat = request("cat");
$tam = request("tam");
$mus = request("mus");
$tam2 = request("tam2");

if ($tam2){ $tip ="";
			$cat = "";
			$tam="";
			$mus="";
}
?>
	<div id="geral" style="background-color: white;">
      
        <div id="corpo" style="background-color: white;">
        
        <table width="100%" cellpadding="0" cellspacing="0">
        	<tr>
                <td valign="top">
                	<div id="shop" style="background-color: white;">
                    	
                        <div id="listaprodutos" style="width: 990px;">
                
							<?php
                            $num_por_pagina = 1000;
                            if (!$pagina) {
                               $pagina = 1;
                            }
                            $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
                                  
                            $sql = "select NR_SEQ_PRODUTO_PRRC, VL_PRODUTO_PRRC, DS_PRODUTO2_PRRC, DS_EXT_PRRC,
                            TP_DESTAQUE_PRRC, DS_FRETEGRATIS_PRRC, VL_PROMO_PRRC, SUM(NR_QTDE_CESO) as total, DT_CADASTRO_PRRC 
                            from compras, cestas, produtos where 
                            NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO AND
                            NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND
                            NR_SEQ_CADASTRO_COSO <> 8074 and 
                            NR_SEQ_CADASTRO_COSO <> 22364 and 
                            NR_SEQ_CADASTRO_COSO <> 6605 AND 
                            ST_COMPRA_COSO <> 'C' AND
                            NR_SEQ_LOJAS_PRRC = 1 AND
                            NR_SEQ_TIPO_PRRC = 52 and NR_SEQ_CATEGORIA_PRRC = 57
                            GROUP BY NR_SEQ_PRODUTO_CESO ORDER by total desc";
      
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
                                    $dt_cad        = $row[8];
                                    
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
                                    ?>
                                    <div class="produto"  style="margin: 0 0 7px 6px;position: relative; z-index:1; height: 200px;">
                                    <div style="text-align: center;"><strong><?php echo $qtde_estoq ?></strong></div>
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
                                      <a href="/produto/<?php echo $ds_categoria ?>/<?php echo urlencode($ds_prod_url); ?>"><img src="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ds_ext; ?>" border="0" alt="<?php echo $ds_prod; ?>" width="120" /></a>
                                      <?php } ?>
                                      <div style="margin: 3px 0 0 5px;">
                                        <p><a href="/produto/<?php echo $ds_categoria ?>/<?php echo urlencode($ds_prod_url); ?>"><?php echo $ds_prod; ?></a>
                                        <?php if ($fretegratis == "S") echo "<span class=\"promocao\" style=\"margin:0;padding:0\"><strong>FRETE GRÁTIS</strong></span>"; ?>
                                        </p>
                                      </div>
                                      <p style="text-align: center;"><?php echo date("d/m/Y",strtotime($dt_cad)); ?></p>
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
                </td>
            </tr>
        </table>
          Quantidade Total: <?php echo $qtde_total ?>
        </div>
      
      <!-- Rodapé -->
      
</div>
</body>
</html>
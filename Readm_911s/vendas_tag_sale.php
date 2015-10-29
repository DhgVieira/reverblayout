<?php 
include 'lib.php';
include 'auth.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vendas TAG SALE - 29-08-2014</title>
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
body{
    font-family: verdana;
}
#shop .produto {
    width:120px;
    float:left;
    height:285px;
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
                            $totalest = 0;
                            
                            $num_por_pagina = 1000;
                            if (!$pagina) {
                               $pagina = 1;
                            }
                            $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
                                    
                             $sql = "SELECT NR_SEQ_PRODUTO_PRRC, VL_PRODUTO_PRRC, DS_PRODUTO2_PRRC, DS_EXT_PRRC, TP_DESTAQUE_PRRC, 
                                     DS_FRETEGRATIS_PRRC, VL_PROMO_PRRC, DS_CATEGORIA_PTRC, SUM(NR_QTDE_CESO) as total 
                                     from compras, cestas, produtos, produtos_tipo where 
                                     NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO AND
                                     NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC AND
                                     NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND                                    
                                     NR_SEQ_CADASTRO_COSO not in (8074, 22364, 32609) and NR_SEQ_LOJA_COSO = 1 AND
                                    ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A'   
                                    and ((DT_INCLUSAO_CESO > '2014-08-28 08:00:00'
                                            and DT_INCLUSAO_CESO < '2014-81-29 08:00:00'))

                                    GROUP BY NR_SEQ_PRODUTO_CESO ORDER by total desc";
       
                            
                            $st = mysql_query($sql);
                            if (mysql_num_rows($st) > 0) {
                                $marg_es = 10;
                                $marg_to = 0;
                                $totp = 0;
                                $qtde_total = 0;
                                while($row = mysql_fetch_row($st)) {
                                    $id_prod       = $row[0];
                                    $vl_prod       = Valor_Produto($row[0],$SS_logado);
                                    $ds_prod       = $row[2];
                                    $ds_ext        = $row[3];
                                    $destaque      = $row[4];
                                    $fretegratis   = $row[5];
                                    $vlrpromo      = $row[6];
                                    $ds_categoria  = $row[7];
                                    $qtde_estoq    = $row[8];
                                  
                                    
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
                                    <div class="produto"  style="margin: 0 0 7px 6px;position: relative; z-index:1; height: 315px;width: 160px;text-align: center;">
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
                                     
                                      <div>                                        <p><a href="/produto/<?php echo $ds_categoria ?>/<?php echo urlencode($ds_prod_url); ?>"><?php echo $ds_prod; ?></a>
                                        <?php if ($fretegratis == "S") echo "<span class=\"promocao\" style=\"margin:0;padding:0\"><strong>FRETE GRÁTIS</strong></span>"; ?>
                                        </p>
                                      </div>
                                      <div style="clear: both;">
                      <?php 
                      
                      if ($tipo != "4") { ?>
                        <ul style="clear: both; z-index: 5; margin: 5px 0 0 0; padding: 0; width: 160px; text-align: center;">
                        <?php
                        $bla = false;
                        $totalparc = 0;
                        for ($f=1;$f<=5;$f++){
                            $sqltam = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC FROM estoque, tamanhos
                                        WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_SEQ_PRODUTO_ESRC = $id_prod
                                        AND NR_SEQ_TAMANHO_ESRC = $f";
                            $sttam = mysql_query($sqltam);
                            if (mysql_num_rows($sttam) > 0) {
                                $rowtam = mysql_fetch_row($sttam);
                                $idprod = $rowtam[0];
                                $idesto = $rowtam[1];
                                $dstama = $rowtam[2];
                                $qtesto = $rowtam[3];
                                
                                $totalparc += $qtesto;
                                $totalest += $qtesto;
                                if ($qtesto > 0) {
                                if (!$bla){
                                    echo "Masculino.:<br />";
                                    $bla = true;
                                }
                                $compab = ComprasEmAberto($id_prod,$f);
                                if ($compab > 0) {
                                    $compab = "<font color=red>+<strong>".$compab."</strong></font>";
                                }else{
                                    $compab = "";
                                }
                                echo $dstama."(".$qtesto."$compab)";
                                }
                                //else if ($qtesto <= 0){
                                //$semestoque .= "Masculino ".$dstama."|".$f.";";
                                //echo "<li style=\"padding:0; margin: 0 0 0 0; width: 25px;\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                //}
                            }
                        }
                        
                        //XGL masculino
                        $f = 33;
                        $sqltam = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC FROM estoque, tamanhos
                                    WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_SEQ_PRODUTO_ESRC = $id_prod
                                    AND NR_SEQ_TAMANHO_ESRC = $f";
                        $sttam = mysql_query($sqltam);
                        if (mysql_num_rows($sttam) > 0) {
                            $rowtam = mysql_fetch_row($sttam);
                            $idprod = $rowtam[0];
                            $idesto = $rowtam[1];
                            $dstama = $rowtam[2];
                            $qtesto = $rowtam[3];
                            $totalest += $qtesto;
                            $totalparc += $qtesto;
                            if ($qtesto > 0) {
                                $compab = ComprasEmAberto($id_prod,$f);
                                if ($compab > 0) {
                                    $compab = "<font color=red>+<strong>".$compab."</strong></font>";
                                }else{
                                    $compab = "";
                                }
                            
                            echo $dstama."(".$qtesto."$compab)";
                        
                            }
                            //else if ($qtesto <= 0){
                            //$semestoque .= "Masculino ".$dstama."|".$f.";";
                            //echo "<li style=\"padding:0; margin: 0 0 0 0; width: 25px;\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                            //}
                        }
                        
                        
                        ?>
                        </ul>
                        
                        <ul style="clear: both; z-index: 5; margin: 0; padding: 0; width: 160px; text-align: center;">
                        <?php
               
                        $bla = false;
                        for ($f=6;$f<=10;$f++){
                            $sqltam = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC FROM estoque, tamanhos
                                        WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_SEQ_PRODUTO_ESRC = $id_prod
                                        AND NR_SEQ_TAMANHO_ESRC = $f";
                            $sttam = mysql_query($sqltam);
                            if (mysql_num_rows($sttam) > 0) {
                                $rowtam = mysql_fetch_row($sttam);
                                $idprod = $rowtam[0];
                                $idesto = $rowtam[1];
                                $dstama = $rowtam[2];
                                $qtesto = $rowtam[3];
                                $totalest += $qtesto;
                                $totalparc += $qtesto;
                                if ($qtesto > 0) {
                                    
                                if (!$bla){
                                    echo "Feminino.:<br />";
                                    $bla = true;
                                }
                                $compab = ComprasEmAberto($id_prod,$f);
                                if ($compab > 0) {
                                    $compab = "<font color=red>+<strong>".$compab."</strong></font>";
                                }else{
                                    $compab = "";
                                }
                                echo $dstama."(".$qtesto."$compab)";
                                    }
                                    //else if ($qtesto <= 0){
                                    //$semestoque .= "Feminino ".$dstama."|".$f.";";
                                    //echo "<li style=\"padding:0; margin: 0 0 0 0; width: 25px;\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                    //}
                                }
                        }
       
                        ?>                       
                        </ul>
                        
                        
                        <ul style="clear: both; z-index: 6; margin: 0; padding: 0; width: 160px; text-align: center;">
                        <?php
             
                        for ($f=13;$f<=26;$f++){
                            $sqltam = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC FROM estoque, tamanhos
                                        WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_SEQ_PRODUTO_ESRC = $id_prod
                                        AND NR_SEQ_TAMANHO_ESRC = $f";
                            $sttam = mysql_query($sqltam);
                            if (mysql_num_rows($sttam) > 0) {
                                $rowtam = mysql_fetch_row($sttam);
                                $idprod = $rowtam[0];
                                $idesto = $rowtam[1];
                                $dstama = $rowtam[2];
                                $qtesto = $rowtam[3];
                                $totalest += $qtesto;
                                $totalparc += $qtesto;
                                if ($qtesto > 0) {
                                    $compab = ComprasEmAberto($id_prod,$f);
                                    if ($compab > 0) {
                                        $compab = "<font color=red>+<strong>".$compab."</strong></font>";
                                    }else{
                                        $compab = "";
                                    }
                                echo $dstama."(".$qtesto."$compab)";
                                    }
                                    //else if ($qtesto <= 0){
                                    //$semestoque .= "Tamanho ".$dstama."|".$f.";";
                                    //echo "<li style=\"padding:0; margin: 0 0 0 0; width: 25px;\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                    //}
                                }
                        }
          
                        ?>                       
                        </ul>
                        
                         <?} ?>
                        
                        <ul style="clear: both; z-index: 7; margin: 0; padding: 0; width: 160px; text-align: center;">
                        <?php
              
                        $xx = 1;
                        for ($f=27;$f<=32;$f++){
                            $sqltam = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC FROM estoque, tamanhos
                                        WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_SEQ_PRODUTO_ESRC = $id_prod
                                        AND NR_SEQ_TAMANHO_ESRC = $f";
                            $sttam = mysql_query($sqltam);
                            
                            if (mysql_num_rows($sttam) > 0) {
                                $rowtam = mysql_fetch_row($sttam);
                                $idprod = $rowtam[0];
                                $idesto = $rowtam[1];
                                $dstama = $rowtam[2];
                                $qtesto = $rowtam[3];
                                $totalest += $qtesto;
                                $totalparc += $qtesto;
                                if ($qtesto > 0) {
                                    $compab = ComprasEmAberto($id_prod,$f);
                                    if ($compab > 0) {
                                        $compab = "<font color=red>+<strong>".$compab."</strong></font>";
                                    }else{
                                        $compab = "";
                                    }
                                echo $dstama."(".$qtesto."$compab)";
                                }
                                //else if ($qtesto <= 0){
                                //    $semestoque .= "Tamanho ".$dstama."|".$f.";";
                                //    echo "<li style=\"padding:0; width: 56px;\"><img src=\"/images/soldout2.gif\" align=\"absmiddle\"></li>";
                                //}
                                $xx++;
                            }
                        }
             
                        ?>                       
                        </ul>
                        
                       <ul style="clear: both; z-index: 8; margin: 0; padding: 0; width: 160px; text-align: center;">
                        <?php
                 
                        $sqltam = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC FROM estoque, tamanhos
                                    WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_QTDE_ESRC > 0 AND NR_SEQ_PRODUTO_ESRC = $id_prod
                                    AND NR_SEQ_TAMANHO_ESRC = 11";
                        $sttam = mysql_query($sqltam);
                        if (mysql_num_rows($sttam) > 0) {
                            while($rowtam = mysql_fetch_row($sttam)) {
                                $idprod = $rowtam[0];
                                $idesto = $rowtam[1];
                                $dstama = $rowtam[2];
                                $qtesto = $rowtam[3];
                                $totalest += $qtesto;
                                $totalparc += $qtesto;
                                if ($qtesto > 0) {
                                    $compab = ComprasEmAberto($id_prod,11);
                                    if ($compab > 0) {
                                        $compab = "<font color=red>+<strong>".$compab."</strong></font>";
                                    }else{
                                        $compab = "";
                                    }
                                echo $dstama."(".$qtesto."$compab)";
                                }
                            }
                        }
                        echo "<br />Estoq Tot: <strong>$totalparc</strong>";   
                        ?>                       
                        </ul>
                             <br />         
                           </div>
                                  </div>
                                  
                                  <?php
                                    //$totp += 1;
                                    //$marg_es += 195;
                                   // if ($totp == 5 || $totp == 10 || $totp == 15 || $totp == 20 || $totp == 25 || $totp == 30 || $totp == 35 || $totp == 40 || $totp == 45) {
                                   //     $marg_es = 10;
                                   //     $marg_to += 280;
                                   // }
                                }
                                
                            }
                         
                            ?>           
                       </div> 
                        
                    </div>
                </td>
            </tr>
        </table>
            
        <?php $sql_total = "SELECT 
                                SUM(VL_TOTAL_COSO) as total, SUM(VL_FRETE_COSO) as vl_frete
                            FROM
                                compras
                            WHERE
                                                   
                                     NR_SEQ_CADASTRO_COSO not in (8074, 22364, 32609)
                                    and NR_SEQ_LOJA_COSO = 1
                                 
                                     and ((DT_COMPRA_COSO > '2014-08-28 08:00:00'
                                            and DT_COMPRA_COSO < '2014-81-29 08:00:00'))";

        $st_valor = mysql_query($sql_total);

        if (mysql_num_rows($st_valor) > 0) {
            $rowvl = mysql_fetch_row($st_valor);
            
            $valor_total = $rowvl[0];
            $valor_frete = $rowvl[1];

            $total_soma = $valor_total + $valor_frete;


        }

        $sql_efetivo = "SELECT 
                                SUM(VL_TOTAL_COSO) as total
                            FROM
                                compras
                            WHERE
                                                     
                                     NR_SEQ_CADASTRO_COSO not in (8074, 22364, 32609)
                                     AND

                                  NR_SEQ_LOJA_COSO = 1
                                    AND ST_COMPRA_COSO <> 'A'
                                    AND ST_COMPRA_COSO <> 'C'
                                   and ((DT_COMPRA_COSO > '2014-08-28 08:00:00'
                                            and DT_COMPRA_COSO < '2014-81-29 08:00:00'))";

        $st_efetivo = mysql_query($sql_efetivo);

        if (mysql_num_rows($st_efetivo) > 0) {
            $rowefetivo = mysql_fetch_row($st_efetivo);
            
            $valor_pago = $rowefetivo[0];
        }
         

         $sql_aberto = "SELECT 
                                SUM(VL_TOTAL_COSO) as total
                            FROM
                                compras
                            WHERE
                           
                                  NR_SEQ_LOJA_COSO = 1
                                  AND                                    
                                     NR_SEQ_CADASTRO_COSO not in (8074, 22364, 32609)
                                    AND ST_COMPRA_COSO = 'A'
                                  
                                    and ((DT_COMPRA_COSO > '2014-08-28 08:00:00'
                                            and DT_COMPRA_COSO < '2014-81-29 08:00:00'))";

        $st_aberto = mysql_query($sql_aberto);

        if (mysql_num_rows($st_aberto) > 0) {
            $rowaberto = mysql_fetch_row($st_aberto);
            
            $valor_aberto = $rowaberto[0];
        }   
      
       $sql_pagos = "SELECT 
                                SUM(VL_TOTAL_COSO) as total
                            FROM
                                compras
                            WHERE
                            
                                     NR_SEQ_CADASTRO_COSO not in (8074, 22364, 32609) AND
                                  NR_SEQ_LOJA_COSO = 1
                                    AND ST_COMPRA_COSO = 'P'
                                  
                                     and ((DT_COMPRA_COSO > '2014-08-28 08:00:00'
                                            and DT_COMPRA_COSO < '2014-81-29 08:00:00'))";

        $st_pagos = mysql_query($sql_pagos);

        if (mysql_num_rows($st_pagos) > 0) {
            $rowpagos = mysql_fetch_row($st_pagos);
            
            $valor_pagos = $rowpagos[0];
        }   

        $sql_enviados = "SELECT 
                                SUM(VL_TOTAL_COSO) as total
                            FROM
                                compras
                            WHERE
                                                               
                                     NR_SEQ_CADASTRO_COSO not in (8074, 22364, 32609)
                                     AND
                                  NR_SEQ_LOJA_COSO = 1
                                    AND ST_COMPRA_COSO = 'V'
                                  
                                     and ((DT_COMPRA_COSO > '2014-08-28 08:00:00'
                                            and DT_COMPRA_COSO < '2014-81-29 08:00:00'))";

        $st_enviados = mysql_query($sql_enviados);

        if (mysql_num_rows($st_enviados) > 0) {
            $rowenviados = mysql_fetch_row($st_enviados);
            
            $valor_enviados= $rowenviados[0];
        }   

        $sql_entregues = "SELECT 
                                SUM(VL_TOTAL_COSO) as total
                            FROM
                                compras
                            WHERE
                                                            
                                     NR_SEQ_CADASTRO_COSO not in (8074, 22364, 32609)
                                      AND
                                  NR_SEQ_LOJA_COSO = 1
                                    AND ST_COMPRA_COSO = 'E'
                                  
                                     and ((DT_COMPRA_COSO > '2014-08-28 08:00:00'
                                            and DT_COMPRA_COSO < '2014-81-29 08:00:00'))";

        $st_entregues = mysql_query($sql_entregues);

        if (mysql_num_rows($st_entregues) > 0) {
            $rowentregues = mysql_fetch_row($st_entregues);
            
            $valor_entregues= $rowentregues[0];
        }   

         $sql_cancelados = "SELECT 
                                SUM(VL_TOTAL_COSO) as total
                            FROM
                                compras
                            WHERE
                                                        
                                     NR_SEQ_CADASTRO_COSO not in (8074, 22364, 32609)
                                      AND
                                  NR_SEQ_LOJA_COSO = 1
                                    AND ST_COMPRA_COSO = 'C'
                                  
                                   and ((DT_COMPRA_COSO > '2014-08-28 08:00:00'
                                            and DT_COMPRA_COSO < '2014-81-29 08:00:00'))";

        $st_cancelados = mysql_query($sql_cancelados);

        if (mysql_num_rows($st_cancelados) > 0) {
            $rowcancelados= mysql_fetch_row($st_cancelados);
            
            $valor_cancelados = $rowcancelados[0];
        }   
?>


        <?php if($qtde_total <= 0){
            echo "Não foram efetuadas vendas até o momento";
        }else{ ?>
  <!--        <b> Quantidade Total Vendida:</b> <?php echo $qtde_total ?><br /><br />
         <b> Total em Estoque Das Unidades Vendidas :</b> <?php echo $totalest ?></br><br />
         <b> Valor Total Pedidos :</b> R$ <?php echo number_format($valor_total, 2, ",", ".")?></br><br />
         <b> Valor Total Pago :</b> R$ <?php echo number_format($valor_pago, 2, ",", ".")?></br><br />
         <b> Valor Total Frete :</b> R$ <?php echo number_format($valor_frete, 2, ",", ".")?></br><br />
         <b> Pedidos + Frete :</b> R$ <?php echo number_format($total_soma, 2, ",", ".")?></br><br /> -->

        <center> <hr color="black" width="300px" height="3px"></center>
         <b> Valor Total Em Aberto :</b> R$ <?php echo number_format($valor_aberto, 2, ",", ".")?></br><br />
         <b> Valor Total Pago :</b> R$ <?php echo number_format($valor_pagos, 2, ",", ".")?></br><br />
         <b> Valor Total Enviado :</b> R$ <?php echo number_format($valor_enviados, 2, ",", ".")?></br><br />
         <b> Valor Total Entregue :</b> R$ <?php echo number_format($valor_entregues, 2, ",", ".")?></br><br />
         <b> Valor Total Cancelados :</b> R$ <?php echo number_format($valor_cancelados, 2, ",", ".")?></br><br />
         <center> <hr color="black" width="300px" height="3px"></center>
        <?php } ?>
        </div>
      
      <!-- Rodapé -->
      
</div>
</body>
</html>
<?php 
function ComprasEmAberto($prod, $taman){
    $sqlmin = "SELECT sum(NR_QTDE_CESO) FROM compras, cestas WHERE NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and
               NR_SEQ_PRODUTO_CESO = $prod and NR_SEQ_TAMANHO_CESO = $taman and ST_COMPRA_COSO = 'A'";
    $stmin = mysql_query($sqlmin);
    $retqtde = "";
    if (mysql_num_rows($stmin) > 0) {
        $rowmin = mysql_fetch_row($stmin);
        $retqtde = $rowmin[0];
    }
    return $retqtde;
}
mysql_close($con); ?>
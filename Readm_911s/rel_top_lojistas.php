<?php 
include '../Readm_911s/lib.php';
include '../Readm_911s/auth.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" />
        <meta charset="UTF-8">
        <title>Top Camisetas Lojistas</title>
        <style>
            body {
                font-family:Calibri, Helvetica, sans-serif;
                font-size: 14px;
            }
        </style>
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
    <body>
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
                <td valign="top" align="center">
                    <div id="shop" style="background-color: white;">
                        
                        <div id="listaprodutos" style="width: 990px;">
                            <h2><?php echo date('d/m/Y', strtotime('-2 year', strtotime(date('Y-m-d')))) ?> - <?php echo date('d/m/Y') ?></h2>
                            <?php
                            $totalest = 0;
                            
                            $num_por_pagina = 1000;
                            if (!$pagina) {
                               $pagina = 1;
                            }
                            $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
                                    
                             $sql = "SELECT 
                                        NR_SEQ_PRODUTO_PRRC,
                                        VL_PRODUTO_PRRC,
                                        DS_PRODUTO2_PRRC,
                                        DS_EXT_PRRC,
                                        TP_DESTAQUE_PRRC,
                                        DS_FRETEGRATIS_PRRC,
                                        VL_PROMO_PRRC,
                                        DS_CATEGORIA_PTRC,
                                        SUM(NR_QTDE_CESO) AS total
                                    FROM
                                        compras inner join
                                        cestas on NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
                                        inner join produtos on NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
                                        inner join produtos_tipo on NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
                                        inner join cadastros on nr_seq_cadastro_caso = nr_seq_cadastro_coso
                                    WHERE
                                        
                                            NR_SEQ_LOJA_COSO = 1
                                            AND ST_COMPRA_COSO <> 'C'
                                            AND ST_COMPRA_COSO <> 'A'
                                            AND DT_COMPRA_COSO >= date_sub(now(), interval 2 year)
                                            and ds_tipo_caso = 'PJ'
                                    GROUP BY NR_SEQ_PRODUTO_CESO
                                    having total > 30
                                    ORDER BY total DESC";
                                    //and DT_COMPRA_COSO < '2014-10-27 08:20:00'))
                                    //
                            
                            $st = mysql_query($sql);
                            if (mysql_num_rows($st) > 0) {
                                $marg_es = 10;
                                $marg_to = 0;
                                $totp = 0;
                                $qtde_total = 0;
                                $idsProduto = array();
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

                                    $idsProduto[] = $id_prod;
                                    
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

                                    $select_fotos = "SELECT
                                              NR_SEQ_FOTO_FORC,
                                              NR_SEQ_PRODUTO_FORC,
                                              DS_EXT_FORC
                                      FROM
                                         fotos
                                      WHERE
                                         NR_SEQ_PRODUTO_FORC = ". $id_prod ."
                                      ORDER BY
                                              NR_ORDEM_FORC ASC
                                      LIMIT 2";
                                      $stFoto = mysql_query($select_fotos);
                                      $fotoRow = mysql_fetch_row($stFoto);
                                    ?>
                                    <div class="produto"  style="margin: 0 0 7px 6px;position: relative; z-index:1; height: 545px;width: 160px;text-align: center;">
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
                                      <a href="/produto/<?php echo $ds_categoria ?>/<?php echo urlencode($ds_prod_url); ?>"><img src="/thumb/fotosprodutos/1/120/120/<?php echo $fotoRow[0]; ?>.<?php echo $fotoRow[2]; ?>" border="0" alt="<?php echo $ds_prod; ?>" width="120" /></a>
                                      <?php } ?>
                                     
                                      <div>                                        <p><a href="/produto/<?php echo $ds_categoria ?>/<?php echo urlencode($ds_prod_url); ?>"><?php echo utf8_encode($ds_prod); ?></a>
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
                                echo $dstama."(".$qtesto."$compab)<br />";
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
                            
                            echo $dstama."(".$qtesto."$compab)<br />";
                        
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
                                echo $dstama."(".$qtesto."$compab)<br />";
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
                                echo $dstama."(".$qtesto."$compab)<br />";
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
                            $sqltam = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC, NR_SEQ_PRODUTO_PRRC, NR_SEQ_CATEGORIA_PRRC FROM estoque, tamanhos, produtos
                                        WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_SEQ_PRODUTO_ESRC = $id_prod AND NR_SEQ_CATEGORIA_PRRC = 184
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
                                echo $dstama."(".$qtesto."$compab)<br />";
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
                 
                        $sqltam = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC, NR_SEQ_PRODUTO_PRRC, NR_SEQ_CATEGORIA_PRRC FROM estoque, tamanhos, produtos
                                    WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_QTDE_ESRC > 0 AND NR_SEQ_PRODUTO_ESRC = $id_prod AND NR_SEQ_CATEGORIA_PRRC = 184
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
                                echo $dstama."(".$qtesto."$compab)<br />";
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
      
      <!-- Rodapé -->
      
</div>

        <table align="center">
            <tr>
                <td align="center" colspan="3"><strong style="font-size: 25px;">Top Camisetas Lojistas</strong></td>
            </tr>
        <?php

            $str = "SELECT 
                        COUNT(*) AS quantidade_total,
                        SUM(cestas.VL_PRODUTO_CESO) AS valor_total,
                        compras.DS_FORMAPGTO_COSO
                    FROM
                        compras
                        INNER JOIN cestas on NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO
                        INNER JOIN produtos on NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_CESO
                        inner join cadastros on nr_seq_cadastro_caso = nr_seq_cadastro_coso
                    WHERE
                        DT_COMPRA_COSO >= date_sub(now(), interval 2 year)
                        and ds_tipo_caso = 'PJ'
                        and nr_seq_produto_ceso in (". implode(', ', $idsProduto) .")
                            AND compras.ST_COMPRA_COSO <> 'C'
                    GROUP BY compras.DS_FORMAPGTO_COSO";

            $st = mysql_query($str);
            if (mysql_num_rows($st) > 0) {

                $vlrCartao = 0;
                $qtdCartao = 0;
                $qtdBoleto = 0;
                $vlrBoleto = 0;

                while($row = mysql_fetch_row($st)) {
                    $qtdTotal      = $row[0];
                    $vlrTotal      = $row[1];
                    $formaPgto     = $row[2];

                    if($formaPgto != 'boleto' && $formaPgto != 'dinheiro'){
                        $vlrCartao = $vlrCartao + $vlrTotal;
                        $qtdCartao = $qtdCartao + $qtdTotal;
                    }else{
                        $vlrBoleto = $vlrBoleto + $vlrTotal;
                        $qtdBoleto = $qtdBoleto + $qtdTotal;
                    }
                }
            }
        ?>

        <tr style="height: 20px;">
            <td colspan="3" align="center"><strong style="font-size: 20px;">Total parcial</strong></td>
        </tr>
        <tr bgcolor="#DFDFDF">
            <td align="left"><strong>Cartão: </strong></td>
            <td align="left"><?php echo $qtdCartao; ?> produtos</td>
            <td align="left">R$ <?php echo number_format($vlrCartao, 2, ",", "."); ?></td>
        </tr>
        <tr bgcolor="#DFDFDF">
            <td align="left"><strong>Boleto: </strong></td>
            <td align="left"><?php echo $qtdBoleto; ?> produtos</td>
            <td align="left">R$ <?php echo number_format($vlrBoleto, 2, ",", "."); ?></td>
        </tr>
        <?php

            $str = "SELECT 
                        COUNT(*) AS quantidade_total,
                        SUM(VL_PRODUTO_CESO) AS valor_total
                    FROM
                        compras
                        INNER JOIN cestas on NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO
                        INNER JOIN produtos on NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_CESO
                        inner join cadastros on nr_seq_cadastro_caso = nr_seq_cadastro_coso
                    WHERE
                         DT_COMPRA_COSO >= date_sub(now(), interval 2 year)
                        and ds_tipo_caso = 'PJ'
                        and nr_seq_produto_ceso in (". implode(', ', $idsProduto) .")
                        and DS_FORMAPGTO_COSO = 'boleto'
                            AND compras.ST_COMPRA_COSO NOT IN ('A', 'C')";

            $st = mysql_query($str);
            if (mysql_num_rows($st) > 0) {
                $row = mysql_fetch_row($st);

                $qtdBoletoPago = $row[0];
                $vlrBoletoPago = $row[1];

                $qtdTotal      = $row[0];
                $vlrTotal      = $row[1];

                ?>

                    <tr bgcolor="#DFDFDF">
                        <td align="left"><strong>Boleto Pago:</strong></td>
                        <td align="left"><?php echo $qtdTotal; ?> produtos</td>
                        <td align="left">R$ <?php echo number_format($vlrTotal, 2, ",", "."); ?></td>
                    </tr>
                <?php
            }
        ?>

        <?php

            $str = "SELECT 
                        COUNT(*) AS quantidade_total,
                        SUM(VL_PRODUTO_CESO) AS valor_total
                    FROM
                        compras
                        INNER JOIN cestas on NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO
                        INNER JOIN produtos on NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_CESO
                        inner join cadastros on nr_seq_cadastro_caso = nr_seq_cadastro_coso
                    WHERE
                         DT_COMPRA_COSO >= date_sub(now(), interval 2 year)
                        and ds_tipo_caso = 'PJ'
                        and nr_seq_produto_ceso in (". implode(', ', $idsProduto) .")
                            AND compras.ST_COMPRA_COSO = 'A'";

            $st = mysql_query($str);
            if (mysql_num_rows($st) > 0) {
                $row = mysql_fetch_row($st);

                $qtdTotal      = $row[0];
                $vlrTotal      = $row[1];

                ?>

                    <tr bgcolor="#DFDFDF">
                        <td align="left"><strong>Boleto Aberto:</strong></td>
                        <td align="left"><?php echo $qtdTotal; ?> produtos</td>
                        <td align="left">R$ <?php echo number_format($vlrTotal, 2, ",", "."); ?></td>
                    </tr>
                <?php
            }
        ?>

        <tr style="height: 20px;">
            <td colspan="3" align="center"><strong style="font-size: 20px;">Total</strong></td>
        </tr>
        <tr bgcolor="#DFDFDF">
            <td align="left"><?php echo $qtdCartao + $qtdBoleto + $qtdBoletoPago; ?> produtos</td>
            <td align="center" colspan="2">R$ <?php echo number_format($vlrCartao + $vlrBoleto + $vlrBoletoPago, 2, ",", "."); ?></td>
        </tr>
        </table>

        <br><br><br>

        <table align="center">
            <tr>
                <td colspan="4"><strong style="font-size: 25px;">Total Camisetas Por Tamanho / Sexo</strong></td>
            </tr>
            <tr bgcolor="silver">
                <td>Sexo</td>
                <td>Tamanho</td>
                <td>Quantidade</td>
                <td>Valor</td>
            </tr>   
            <?php 


            $str_total = "SELECT 
                            SUM(NR_QTDE_CESO) AS total_tamanho,
                            DS_SIGLA_TARC,
                            nr_seq_tamanho_tarc,
                            SUM(nr_qtde_ceso * vl_produto_ceso) AS valor_total
                        FROM
                            compras
                                INNER JOIN
                            cestas ON nr_seq_compra_ceso = nr_seq_compra_coso
                                INNER JOIN
                            tamanhos ON nr_seq_tamanho_ceso = nr_seq_tamanho_tarc
                            inner join cadastros on nr_seq_cadastro_caso = nr_seq_cadastro_coso
                        WHERE
                            nr_seq_produto_ceso in (". implode(', ', $idsProduto) .")
                            AND DT_COMPRA_COSO >= date_sub(now(), interval 2 year)
                            and ds_tipo_caso = 'PJ'
                            AND compras.ST_COMPRA_COSO <> 'C'
                        GROUP BY nr_seq_tamanho_tarc
                        ORDER BY NR_ORDEM_TARC ASC";
                        
            $st_tamanho = mysql_query($str_total);
            if (mysql_num_rows($st_tamanho) > 0) {

                $qtdMasc = 0;
                $qtdFem = 0;
                $vlrMasc = 0;
                $vlrFem = 0;

                while($row_t = mysql_fetch_row($st_tamanho)) {
                        $total = $row_t[0];
                        $sigla   = $row_t[1];
                        $idtamanho = $row_t[2];
                        $valor = $row_t[3];
                      
                        ?>
                            <tr bgcolor="#DFDFDF">
                              <?php  if(($idtamanho >= 1 AND $idtamanho <= 5) or $idtamanho == 33){
                                $qtdMasc+=$total;
                                $vlrMasc+=$valor;
                                ?>
                                    <td><b>MASC</b></td>
                                    <td><?php echo $sigla; ?></td>
                                    <td><?php echo $total; ?></td>
                                    <td>R$ <?php echo number_format($valor, 2, ",", "."); ?></td>
                                <?php
                                }else{
                                    if($sigla != 'Comprar'){
                                        $qtdFem+=$total;
                                        $vlrFem+=$valor;
                                ?>
                                    <td><b>FEM</b></td>
                                    <td><?php echo $sigla; ?></td>
                                    <td><?php echo $total; ?></td>
                                    <td>R$ <?php echo number_format($valor, 2, ",", "."); ?></td>
                                <?php
                                    }else{
                                        ?>
                                            <td><b>Único</b></td>
                                            <td> - </td>
                                            <td><?php echo $total; ?></td>
                                            <td>R$ <?php echo number_format($valor, 2, ",", "."); ?></td>
                                        <?php
                                    }
                                } ?>
                            </tr>
                        <?php

                }

            }

        ?>
        </table>

        <br><br><br>

        <table align="center">
            <tr>
                <td colspan="4"><strong style="font-size: 25px;">Vendas por sexo</strong></td>
            </tr>
            <tr bgcolor="silver">
                <td>Sexo</td>
                <td>Quantidade</td>
                <!-- <td>Valor</td> -->
            </tr>   
            <?php
                $total = $qtdFem + $qtdMasc;
                $porFem = (($qtdFem / $total) * 100);
                $porMasc = (($qtdMasc / $total) * 100);
            ?>
            <tr bgcolor="#DFDFDF">
                <td>Feminino</td>
                <td><?php echo number_format($porFem, 2, ",", "."); ?>%</td>
                <!-- <td>R$ <?php echo number_format($vlrFem, 2, ",", "."); ?></td> -->
            </tr>
            <tr bgcolor="#DFDFDF">
                <td>Masculino</td>
                <td><?php echo number_format($porMasc, 2, ",", "."); ?>%</td>
                <!-- <td>R$ <?php echo number_format($vlrMasc, 2, ",", "."); ?></td> -->
            </tr>
        </table>

        <br><br><br>
    </body>
</html>
<?php mysql_close($con); ?>
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
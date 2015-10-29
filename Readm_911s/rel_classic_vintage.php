<?php 
include '../Readm_911s/lib.php';
include '../Readm_911s/auth.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" />
        <meta charset="UTF-8">
        <title>Classic Vintage</title>
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
        <h2 style="text-align: center;">Classic Vintage - 21/10/2009 até <?php echo date('d/m/Y') ?></h2>
        <table align="center" cellpadding="0" cellspacing="0">
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
                                     NR_SEQ_LOJA_COSO = 1 AND
                                    ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A' 
                                    AND (NR_SEQ_CATEGORIA_PRRC = 190)
                                    AND NR_SEQ_PRODUTO_PRRC not in(5504,207,2265,339,2265,496,5230,286,361,5308,646,227)
                                    

                                    GROUP BY NR_SEQ_PRODUTO_CESO ORDER by total desc";
                                    //and DT_COMPRA_COSO < '2014-10-27 08:20:00'))
                            
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
                <td align="center" colspan="3"><strong style="font-size: 25px;">Vendas</strong></td>
            </tr>
            <tr bgcolor="silver">
                <td align="left"><strong>Forma de pagamento</strong></td>
                <td align="left"><strong>Quantidade de compras</strong></td>
                <td align="left"><strong>Valor</strong></td>
            </tr>
        <?php

            $str = "SELECT 
                        COUNT(*) AS quantidade_total,
                        SUM(nr_qtde_ceso * cestas.VL_PRODUTO_CESO) AS valor_total,
                        compras.DS_FORMAPGTO_COSO
                    FROM
                        compras
                        INNER JOIN 
                            cestas ON NR_SEQ_COMPRA_COSO = NR_SEQ_PRODUTO_CESO
                        INNER JOIN 
                            produtos ON NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
                    WHERE
                        (NR_SEQ_CATEGORIA_PRRC = 190)
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

                    if($formaPgto != 'boleto'){
                        $vlrCartao = $vlrCartao + $vlrTotal;
                        $qtdCartao = $qtdCartao + $qtdTotal;
                    }else{
                        $vlrBoleto = $vlrBoleto + $vlrTotal;
                        $qtdBoleto = $qtdBoleto + $qtdTotal;
                    }

                    ?>

                        <tr bgcolor="#DFDFDF">
                            <td align="left"><?php echo ucfirst($formaPgto); ?></td>
                            <td align="left"><?php echo $qtdTotal; ?></td>
                            <td align="left">R$ <?php echo number_format($vlrTotal, 2, ",", "."); ?></td>
                        </tr>
                    <?php
                }
            }
        ?>

        <tr style="height: 20px;">
            <td colspan="3" align="center"><strong style="font-size: 20px;">Total parcial</strong></td>
        </tr>
        <tr bgcolor="#DFDFDF">
            <td align="left"><strong>Cartão: </strong></td>
            <td align="left"><?php echo $qtdCartao; ?> compras</td>
            <td align="left">R$ <?php echo number_format($vlrCartao, 2, ",", "."); ?></td>
        </tr>
        <tr bgcolor="#DFDFDF">
            <td align="left"><strong>Boleto: </strong></td>
            <td align="left"><?php echo $qtdBoleto; ?> compras</td>
            <td align="left">R$ <?php echo number_format($vlrBoleto, 2, ",", "."); ?></td>
        </tr>
        <?php

            $str = "SELECT 
                        COUNT(*) AS quantidade_total,
                        SUM(nr_qtde_ceso *  cestas.VL_PRODUTO_CESO) AS valor_total
                    FROM
                        compras
                        INNER JOIN 
                            cestas ON NR_SEQ_COMPRA_COSO = NR_SEQ_PRODUTO_CESO
                        INNER JOIN 
                            produtos ON NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC
                    WHERE
                        (NR_SEQ_CATEGORIA_PRRC = 190)
                            AND compras.ST_COMPRA_COSO = 'A'";

            $st = mysql_query($str);
            if (mysql_num_rows($st) > 0) {
                $row = mysql_fetch_row($st);

                $qtdBoletoPago = abs($row[0] - $qtdBoleto);
                $vlrBoletoPago = abs($row[1] - $vlrBoleto);

                $qtdTotal      = $row[0];
                $vlrTotal      = $row[1];

                ?>

                    <tr bgcolor="#DFDFDF">
                        <td align="left"><strong>Boleto Aberto:</strong></td>
                        <td align="left"><?php echo $qtdTotal; ?> compras</td>
                        <td align="left">R$ <?php echo number_format($vlrTotal, 2, ",", "."); ?></td>
                    </tr>
                <?php
            }
        ?>

        <tr bgcolor="#DFDFDF">
            <td align="left"><strong>Boleto Pago:</strong></td>
            <td align="left"><?php echo $qtdBoletoPago; ?> compras</td>
            <td align="left">R$ <?php echo number_format($vlrBoletoPago, 2, ",", "."); ?></td>
        </tr>

        <tr style="height: 20px;">
            <td colspan="3" align="center"><strong style="font-size: 20px;">Total</strong></td>
        </tr>
        <tr bgcolor="#DFDFDF">
            <td align="left"><?php echo $qtdCartao + $qtdBoleto; ?> compras</td>
            <td align="center" colspan="2">R$ <?php echo number_format($vlrCartao + $vlrBoleto, 2, ",", "."); ?></td>
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
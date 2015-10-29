<?php
  include 'lib.php';
  $data = request('data');
  $semana = request('semana');

  if($semana == 1){
    $interval = '7 DAY';
  }else{
    $interval = '1 MONTH';
  }
?>
<html>
<head>
  <title></title>
  <link rel="stylesheet" href="../css/thickbox.css" type="text/css" media="screen" />
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
  <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
    <tr>
      <td align="left" colspan="2">
          <table width="99%" align="center" cellpadding="0" cellspacing="0">
            <?php
                      $sqlDatas = "SELECT 
                                  DATE_FORMAT(DT_SOLICITACAO_AVRC, '%Y-%m-%d') AS data
                              FROM
                                  aviseme,
                                  produtos,
                                  produtos_tipo
                              WHERE
                                  NR_SEQ_PRODUTO_AVRC = NR_SEQ_PRODUTO_PRRC
                                      AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
                                      AND NR_SEQ_TIPO_PRRC = 6
                                      AND NR_SEQ_CATEGORIA_PRRC IN (7 , 8, 11, 10)
                                      AND ST_JACOMPROU_AVRC = 'N'
                                      AND NR_SEQ_PRODUTO_PRRC NOT IN (2030 , 5105,
                                      2173,
                                      381,
                                      4626,
                                      2047,
                                      836,
                                      1533,
                                      2041,
                                      376,
                                      2043,
                                      4631,
                                      1527,
                                      541,
                                      1502,
                                      2029,
                                      1524,
                                      1529,
                                      2042,
                                      2025)
                                      AND DATE_FORMAT(DT_SOLICITACAO_AVRC, '%Y-%m-%d') >= DATE_FORMAT(DATE_SUB('".$data."', INTERVAL ".$interval."),
                                          '%Y-%m-%d')
                                      AND DATE_FORMAT(DT_SOLICITACAO_AVRC, '%Y-%m-%d') <= '".$data."'
                              GROUP BY DATE_FORMAT(DT_SOLICITACAO_AVRC, '%Y-%m-%d')
                              ORDER BY data";
                              
                      $stDatas = mysql_query($sqlDatas);
                      if(mysql_num_rows($stDatas) > 0){
                        $totalGeral = 0;
                        $valorGeral = 0;
                        while($rowData = mysql_fetch_row($stDatas)){
                          $totalDia = 0;
                          $valorDia = 0;
                          ?>
                            <tr><td bgcolor="#FFFFFF">
                              <div id="abas">
                                <div id="Ver">
                                  <div id="shop" style="background-color: white; margin-left: auto; margin-right: auto;">
                              <div id="listaprodutos" style="width: 990px; margin-left: auto; margin-right: auto;">
                                <h2 style="text-align: center;"><?php echo date('d/m/Y', strtotime($rowData[0])) ?></h2>
                                  <?php

                                 $sql = "select NR_SEQ_PRODUTO_PRRC, VL_PRODUTO_PRRC, DS_PRODUTO2_PRRC, DS_EXT_PRRC, TP_DESTAQUE_PRRC, DS_FRETEGRATIS_PRRC, VL_PROMO_PRRC, count(*) as total, DS_CATEGORIA_PTRC, date_format(DT_SOLICITACAO_AVRC, '%Y-%m-%d')
                                 from aviseme, produtos, produtos_tipo where NR_SEQ_PRODUTO_AVRC = NR_SEQ_PRODUTO_PRRC and NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
                                 and NR_SEQ_TIPO_PRRC = 6 and NR_SEQ_CATEGORIA_PRRC in (7,8,11,10) AND ST_JACOMPROU_AVRC = 'N' 
                                 AND NR_SEQ_PRODUTO_PRRC not in (2030, 5105, 2173, 381, 4626, 2047, 836, 1533, 2041, 376, 2043, 4631, 1527, 541, 1502, 2029, 1524, 1529, 2042, 2025)
                                 AND DATE_FORMAT(DT_SOLICITACAO_AVRC, '%Y-%m-%d') = '".$rowData[0]."'";

                                 $sql .= " GROUP BY NR_SEQ_PRODUTO_AVRC order by total desc";
                                 $st = mysql_query($sql);
                                 if (mysql_num_rows($st) > 0) {
                                  $marg_es = 10;
                                  $marg_to = 0;
                                  $totp = 0;
                                  $qtde_total = 0;
                                  while($row = mysql_fetch_row($st)) {
                                    $id_prod     = $row[0];
                                    $vl_prod     = Valor_Produto($row[0],$SS_logado);
                                    $ds_prod     = $row[2];
                                    $ds_ext      = $row[3];
                                    $destaque    = $row[4];
                                    $fretegratis   = $row[5];
                                    $vlrpromo    = $row[6];
                                    $qtde_estoq    = $row[7];
                                    $ds_categoria  = $row[8];

                                    if ($vlrpromo > 0){
                                      $vl_prod = $vlrpromo;
                                    }

                                    $totalDia += $qtde_estoq;
                                    $valorDia += ($qtde_estoq*$vl_prod);

                                    $totalGeral += $qtde_estoq;
                                    $valorGeral += ($qtde_estoq*$vl_prod);

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

                                    $est = "select sum(NR_QTDE_ESRC) from estoque where NR_SEQ_PRODUTO_ESRC = $id_prod";
                                    $stes = mysql_query($est);
                                    $rowes = mysql_fetch_row($stes);
                                    $totalest = 0;
                                    $totalest = $rowes[0];

                                    $strtmanahos = "";
                                    $est = "select DS_SIGLA_TARC, count(*), DS_TAMANHO_TARC from aviseme, tamanhos where 
                                    NR_SEQ_TAMANHO_AVRC = NR_SEQ_TAMANHO_TARC and NR_SEQ_PRODUTO_AVRC = $id_prod  AND ST_JACOMPROU_AVRC = 'N'
                                    AND DATE_FORMAT(DT_SOLICITACAO_AVRC, '%Y-%m-%d') >= DATE_FORMAT(DATE_SUB('".$data."', INTERVAL ".$interval."), '%Y-%m-%d')
                                 AND DATE_FORMAT(DT_SOLICITACAO_AVRC, '%Y-%m-%d') <= '".$data."'
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
                                    <div idproduto="<?php echo $id_prod; ?>" class="produto"  style="margin: 0 0 7px 6px;position: relative; z-index:1; height: 295px;">
                                      <div style="text-align: center; clear: both; width: 100%;"><strong style="font-size: 14px;"><?php echo $qtde_estoq ?> (<?php echo $totalest ?>)</strong></div>
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
                                        LIMIT 1 OFFSET 2";
                                        $stFoto = mysql_query($select_fotos);
                                        $fotoRow = mysql_fetch_row($stFoto);

                                        if (file_exists("../arquivos/uploads/fotosprodutos/".$fotoRow[0].".".$fotoRow[2]) && $fotoRow[0] != ''){
                                          ?>
                                          <img src="/thumb/fotosprodutos/1/129/150/<?php echo $fotoRow[0]; ?>.<?php echo $fotoRow[2]; ?>" border="0" alt="<?php echo $ds_prod; ?>" width="120" />
                                          <?php
                                        }else{

                                          ?>
                                          <img src="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ds_ext; ?>" border="0" alt="<?php echo $ds_prod; ?>" width="120" />
                                          <?php 
                                        }
                                      } ?>
                                      <div class="preco-produto" style="margin: 3px 0 0 0;">

                                      </div>
                                      <div class="desc-produto" style="margin: 3px 0 0 5px;">
                                        <p style="font-size: 12px;"><?php echo $ds_prod; ?></p>
                                      </div>
                                      <div style="text-align: center; width: 100%; vertical-align: bottom; clear: both; font-size: 12px; position: absolute; bottom: 0;"><strong style="font-size: 14px;">R$ <?php echo number_format($qtde_estoq*$vl_prod,2,",","."); ?></strong></div>
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
                                <table style="clear: both; margin: 0px auto;">
                                  <tr>
                                    <td colspan="2" style="text-align: center; font-size: 14px;"><h2>Total do dia</h2></td>
                                  </tr>
                                  <tr bgcolor="silver">
                                    <td>Quantidade</td>
                                    <td>Valor</td>
                                  </tr>
                                  <tr bgcolor="#DFDFDF">
                                    <td><?php echo $totalDia ?></td>
                                    <td>R$ <?php echo number_format($valorDia,2,",",".") ?></td>
                                  </tr>
                                </table>        
                              </div> <!-- /lista produtos -->
                              <br /><br />
                          <?php
                        }
                    ?>
                    <table style="clear: both; margin: 0px auto;">
                      <tr>
                        <td colspan="2" style="text-align: center; font-size: 14px;"><h2>Total geral</h2></td>
                      </tr>
                      <tr bgcolor="silver">
                        <td>Quantidade</td>
                        <td>Valor</td>
                      </tr>
                      <tr bgcolor="#DFDFDF">
                        <td><?php echo $totalGeral ?></td>
                        <td>R$ <?php echo number_format($valorGeral,2,",",".") ?></td>
                      </tr>
                    </table>   
                </div> <!-- /shop -->

              </div> <!-- /ver -->
              
            </div>   <!-- /abas -->
          </td></tr>
          <?php } ?>
        </table>

        <br />
      </td>
    </tr>
  </table>
</body>
</html>
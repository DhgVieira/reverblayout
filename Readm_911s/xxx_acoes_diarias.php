<?php
//error_reporting(E_ALL ^ E_DEPRECATED);
//ini_set('display_errors', 1);

include 'lib.php';
include 'RVBMemcached.php';
$memcached = new RVBMemcached();

$dia = date("d");
$mes = date("m");
$ano = date("Y");

//procuro o produto do dia ativo
$sql_produto_dia = "SELECT 
                      NR_SEQ_AGENDAMENTO_BARC, 
                      NR_SEQ_PRODUTO_BARC,
                      VL_PROMOATUAL_BARC,
                      DS_FRETEGRATUAL_BARC
                    FROM 
                      banners_agendados
                    WHERE 
                      ST_ATUAL_BARC = 'S'
                    ORDER BY 
                      DT_PUBLICACAO_BARC DESC
                    LIMIT 1";

$st_pdia = mysql_query($sql_produto_dia);
//se tiver resultado
if (mysql_num_rows($st_pdia) > 0) {

    $row = mysql_fetch_row($st_pdia);

    $codigo_agendamento  = $row[0];
    $codigo_produto      = $row[1];
    $vl_promo_antigo     = $row[2];
    $st_frete_gratis     = $row[3];

    if($vl_promo_antigo == 0){
        $vl_promo_antigo = "NULL";
    }

    //atualizo a tabela do produto antiga
    $sql_atualiza_produto = "UPDATE 
                                produtos
                              SET 
                                VL_PROMO_PRRC = $vl_promo_antigo,
                                DS_FRETEGRATIS_PRRC = '$st_frete_gratis'
                              WHERE 
                                NR_SEQ_PRODUTO_PRRC = $codigo_produto";

    //executo a query
    $st_up_old = mysql_query($sql_atualiza_produto);
    //agora atualizo a tabela dos banners agendados
    $str_agendado = "UPDATE 
                      banners_agendados 
                      SET 
                        ST_ATUAL_BARC = 'N'
                      WHERE 
                      NR_SEQ_AGENDAMENTO_BARC = $codigo_agendamento";

    //executo a query
    $st_volta_banner = mysql_query($str_agendado);
}
//procuro o produto do dia que será ativo
$sql_produto_dia_novo = "SELECT 
                      NR_SEQ_AGENDAMENTO_BARC, 
                      NR_SEQ_PRODUTO_BARC,
                      VL_NOVOVALOR_BARC,
                      DS_FRETEGRATIS_BARC
                    FROM 
                      banners_agendados
                    WHERE 
                      ST_ATUAL_BARC = 'N'
                    AND 
                      DAY(DT_PUBLICACAO_BARC) = $dia
                    AND 
                      MONTH(DT_PUBLICACAO_BARC) = $mes
                    AND 
                      YEAR(DT_PUBLICACAO_BARC) = $ano
                    ORDER BY 
                      DT_PUBLICACAO_BARC DESC
                    LIMIT 1";


$st_pdia_novo = mysql_query($sql_produto_dia_novo);
//se tiver resultado
if (mysql_num_rows($st_pdia_novo) > 0) {
    $row_new = mysql_fetch_row($st_pdia_novo);

    $codigo_agendamento_new  = $row_new[0];
    $codigo_produto_new      = $row_new[1];
    $novo_valor              = $row_new[2];
    $st_frete                = $row_new[3];
    //atualizo a tabela do produto antiga
    $sql_atualiza_produto_new = "UPDATE 
                                produtos
                              SET 
                                VL_PROMO_PRRC = $novo_valor,
                                DS_FRETEGRATIS_PRRC = '$st_frete'
                              WHERE 
                                NR_SEQ_PRODUTO_PRRC = $codigo_produto_new";


    //executo a query
    $st_up_new = mysql_query($sql_atualiza_produto_new);
    //agora atualizo a tabela dos banners agendados
    $str_agendado_new = "UPDATE 
                      banners_agendados 
                      SET 
                        ST_ATUAL_BARC = 'S'
                      WHERE 
                      NR_SEQ_AGENDAMENTO_BARC = $codigo_agendamento_new";

    //executo a query
    $st_volta_banner_new = mysql_query($str_agendado_new);
}

$memcached->flushCache();
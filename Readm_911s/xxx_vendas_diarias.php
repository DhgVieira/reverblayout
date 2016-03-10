<?php

include 'lib.php';

$dia = date("d");
$mes = date("m");
$ano = date("Y");

$ontem = $ano . "-" . $mes . "-" . $dia;

$data_inicio = $ontem . ' 00:00:01';
$data_fim = $ontem . ' 23:59:00';

// $data_inicio = date('Y-m-d H:i:s', strtotime($ontem $hora_inicio));
// $data_fim = date("Y-m-d H:i:s", strtotime("$ontem $hora_fim"));


$data_formatada = date("d/m/Y");

$sql_pagas = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	ST_COMPRA_COSO <> 'C'
            AND 
            	ST_COMPRA_COSO <> 'A'
            AND 
            	DS_FORMAPGTO_COSO LIKE '%visa%'
            AND
            	((DT_PAGAMENTO_COSO > '$data_inicio' 
            AND 
            	DT_PAGAMENTO_COSO < '$data_fim'));";

$st_pagas = mysql_query($sql_pagas);

if (mysql_num_rows($st_pagas) > 0) {
    $rowpago = mysql_fetch_row($st_pagas);

    $valor_pago = $rowpago[0];
    $total_pagas = $rowpago[1];
}

$sql_abertas = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	DS_FORMAPGTO_COSO LIKE '%visa%'
            AND 
            	ST_COMPRA_COSO = 'A'
            AND
            	((DT_COMPRA_COSO > '$data_inicio' 
            AND 
            	DT_COMPRA_COSO < '$data_fim'));";


$st_abertas = mysql_query($sql_abertas);

if (mysql_num_rows($st_abertas) > 0) {
    $rowaberto = mysql_fetch_row($st_abertas);

    $valor_aberto = $rowaberto[0];
    $total_aberto = $rowaberto[1];
}

//compras norte
$sql_norte = "SELECT 
    SUM(VL_TOTAL_COSO) as total,
    COUNT(NR_SEQ_COMPRA_COSO) as compras
FROM
    compras
        LEFT JOIN
    cadastros ON NR_SEQ_CADASTRO_COSO = cadastros.NR_SEQ_CADASTRO_CASO
WHERE
    NR_SEQ_LOJA_COSO = 1
            AND 
            	ST_COMPRA_COSO <> 'C'
            AND 
            	ST_COMPRA_COSO <> 'A'
        AND cadastros.DS_UF_CASO IN ( 'AM', 'RR', 'AP', 'PA', 'TO', 'RO', 'AC' )
            	AND ((DT_COMPRA_COSO > '$data_inicio' 
            AND 
            	DT_COMPRA_COSO < '$data_fim'));";

$compras_norte = mysql_query($sql_norte);

if (mysql_num_rows($compras_norte) > 0) {
    $rownorte = mysql_fetch_row($compras_norte);

    $valor_norte = $rownorte[0];
    $total_norte = $rownorte[1];
}

//compras nordeste
$sql_nordeste = "SELECT 
    SUM(VL_TOTAL_COSO) as total,
    COUNT(NR_SEQ_COMPRA_COSO) as compras
FROM
    compras
        LEFT JOIN
    cadastros ON NR_SEQ_CADASTRO_COSO = cadastros.NR_SEQ_CADASTRO_CASO
WHERE
    NR_SEQ_LOJA_COSO = 1
            AND 
            	ST_COMPRA_COSO <> 'C'
            AND 
            	ST_COMPRA_COSO <> 'A'
        AND cadastros.DS_UF_CASO IN ( 'MA', 'PI', 'CE', 'RN', 'PE', 'PB', 'SE', 'AL', 'BA' )
            	AND ((DT_COMPRA_COSO > '$data_inicio' 
            AND 
            	DT_COMPRA_COSO < '$data_fim'));";

$compras_nordeste = mysql_query($sql_nordeste);

if (mysql_num_rows($compras_nordeste) > 0) {
    $rownordeste = mysql_fetch_row($compras_nordeste);

    $valor_nordeste = $rownordeste[0];
    $total_nordeste = $rownordeste[1];
}


$sql_cancelados = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	ST_COMPRA_COSO = 'C'
            AND 
            	DS_FORMAPGTO_COSO LIKE '%visa%'
            AND
            	((DT_COMPRA_COSO > '$data_inicio' 
            AND 
            	DT_COMPRA_COSO < '$data_fim'));";


$st_cancelado = mysql_query($sql_cancelados);

if (mysql_num_rows($st_cancelado) > 0) {
    $rowcancelado = mysql_fetch_row($st_cancelado);

    $valor_cancelado = $rowcancelado[0];
    $total_cancelado = $rowcancelado[1];
}





$sql_pagas_master = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	ST_COMPRA_COSO <> 'C'
            AND 
            	ST_COMPRA_COSO <> 'A'
            AND 
            	DS_FORMAPGTO_COSO LIKE '%mastercard%'
            AND
            	((DT_PAGAMENTO_COSO > '$data_inicio' 
            AND 
            	DT_PAGAMENTO_COSO < '$data_fim'));";


$st_pagas_master = mysql_query($sql_pagas_master);

if (mysql_num_rows($st_pagas_master) > 0) {
    $rowpago_master = mysql_fetch_row($st_pagas_master);

    $valor_pago_master = $rowpago_master[0];
    $total_pagas_master = $rowpago_master[1];
}


$sql_abertas_master = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	DS_FORMAPGTO_COSO LIKE '%mastercard%'
            AND 
            	ST_COMPRA_COSO = 'A'
            AND
            	((DT_COMPRA_COSO > '$data_inicio' 
            AND 
            	DT_COMPRA_COSO < '$data_fim'));";


$st_abertas_master = mysql_query($sql_abertas_master);

if (mysql_num_rows($st_abertas_master) > 0) {
    $rowaberto_master = mysql_fetch_row($st_abertas_master);

    $valor_aberto_master = $rowaberto_master[0];
    $total_aberto_master = $rowaberto_master[1];
}


$sql_cancelados_master = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	ST_COMPRA_COSO = 'C'
            AND 
            	DS_FORMAPGTO_COSO LIKE '%mastercard%'
            AND
            	((DT_COMPRA_COSO > '$data_inicio' 
            AND 
            	DT_COMPRA_COSO < '$data_fim'));";


$st_cancelado_master = mysql_query($sql_cancelados_master);

if (mysql_num_rows($st_cancelado) > 0) {
    $rowcancelado_master = mysql_fetch_row($st_cancelado_master);

    $valor_cancelado_master = $rowcancelado_master[0];
    $total_cancelado_master = $rowcancelado_master[1];
}


$sql_pagas_diners = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	ST_COMPRA_COSO <> 'C'
            AND 
            	ST_COMPRA_COSO <> 'A'
            AND 
            	DS_FORMAPGTO_COSO LIKE '%diners%'
            AND
            	((DT_PAGAMENTO_COSO > '$data_inicio' 
            AND 
            	DT_PAGAMENTO_COSO < '$data_fim'));";


$st_pagas_diners = mysql_query($sql_pagas_diners);

if (mysql_num_rows($st_pagas_diners) > 0) {
    $rowpago_diners = mysql_fetch_row($st_pagas_diners);

    $valor_pago_diners = $rowpago_diners[0];
    $total_pagas_diners = $rowpago_diners[1];
}


$sql_aberta_diners = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	DS_FORMAPGTO_COSO LIKE '%diners%'
            AND 
            	ST_COMPRA_COSO = 'A'
            AND
            	((DT_COMPRA_COSO > '$data_inicio' 
            AND 
            	DT_COMPRA_COSO < '$data_fim'));";


$st_abertas_diners = mysql_query($sql_aberta_diners);

if (mysql_num_rows($st_abertas_diners) > 0) {
    $rowaberto_diners = mysql_fetch_row($st_abertas_diners);

    $valor_aberto_diners = $rowaberto_diners[0];
    $total_aberto_diners = $rowaberto_diners[1];
}


$sql_cancelados_diners = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	ST_COMPRA_COSO = 'C'
            AND 
            	DS_FORMAPGTO_COSO LIKE '%diners%'
            AND
            	((DT_COMPRA_COSO > '$data_inicio' 
            AND 
            	DT_COMPRA_COSO < '$data_fim'));";


$st_cancelado_diners = mysql_query($sql_cancelados_diners);

if (mysql_num_rows($st_cancelado_diners) > 0) {
    $rowcancelado_diners = mysql_fetch_row($st_cancelado_diners);

    $valor_cancelado_diners = $rowcancelado_diners[0];
    $total_cancelado_diners = $rowcancelado_diners[1];
}


$sql_pagas_amex = "SELECT 
                SUM(VL_TOTAL_COSO) as total,
                COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
                compras
            WHERE
                NR_SEQ_LOJA_COSO = 1
            AND 
                ST_COMPRA_COSO <> 'C'
            AND 
                ST_COMPRA_COSO <> 'A'
            AND 
                DS_FORMAPGTO_COSO LIKE '%amex%'
            AND
                ((DT_PAGAMENTO_COSO > '$data_inicio' 
            AND 
                DT_PAGAMENTO_COSO < '$data_fim'));";


$st_pagas_amex = mysql_query($sql_pagas_amex);

if (mysql_num_rows($st_pagas_amex) > 0) {
    $rowpago_amex = mysql_fetch_row($st_pagas_amex);

    $valor_pago_amex = $rowpago_amex[0];
    $total_pagas_amex = $rowpago_amex[1];
}

$sql_aberta_amex = "SELECT 
                SUM(VL_TOTAL_COSO) as total,
                COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
                compras
            WHERE
                NR_SEQ_LOJA_COSO = 1
            AND 
                DS_FORMAPGTO_COSO LIKE '%amex%'
            AND 
                ST_COMPRA_COSO = 'A'
            AND
                ((DT_COMPRA_COSO > '$data_inicio' 
            AND 
                DT_COMPRA_COSO < '$data_fim'));";


$st_abertas_amex = mysql_query($sql_aberta_amex);

if (mysql_num_rows($st_abertas_amex) > 0) {
    $rowaberto_amex = mysql_fetch_row($st_abertas_amex);

    $valor_aberto_amex = $rowaberto_amex[0];
    $total_aberto_amex = $rowaberto_amex[1];
}

$sql_cancelados_amex = "SELECT 
                SUM(VL_TOTAL_COSO) as total,
                COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
                compras
            WHERE
                NR_SEQ_LOJA_COSO = 1
            AND 
                ST_COMPRA_COSO = 'C'
            AND 
                DS_FORMAPGTO_COSO LIKE '%amex%'
            AND
                ((DT_COMPRA_COSO > '$data_inicio' 
            AND 
                DT_COMPRA_COSO < '$data_fim'));";


$st_cancelado_amex = mysql_query($sql_cancelados_amex);

if (mysql_num_rows($st_cancelado_amex) > 0) {
    $rowcancelado_amex = mysql_fetch_row($st_cancelado_amex);

    $valor_cancelado_amex = $rowcancelado_amex[0];
    $total_cancelado_amex = $rowcancelado_amex[1];
}


$sql_pagas_boleto = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	ST_COMPRA_COSO <> 'C'
            AND 
            	ST_COMPRA_COSO <> 'A'
            AND 
            	DS_FORMAPGTO_COSO LIKE '%boleto%'
            AND
            	((DT_PAGAMENTO_COSO > '$data_inicio' 
            AND 
            	DT_PAGAMENTO_COSO < '$data_fim'));";


$st_pagas_boleto = mysql_query($sql_pagas_boleto);

if (mysql_num_rows($st_pagas_boleto) > 0) {
    $rowpago_boleto = mysql_fetch_row($st_pagas_boleto);

    $valor_pago_boleto = $rowpago_boleto[0];
    $total_pagas_boleto = $rowpago_boleto[1];
}


$sql_aberta_boleto = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	DS_FORMAPGTO_COSO LIKE '%boleto%'
            AND 
            	ST_COMPRA_COSO = 'A'
            AND
            	((DT_COMPRA_COSO > '$data_inicio' 
            AND 
            	DT_COMPRA_COSO < '$data_fim'));";


$st_abertas_boleto = mysql_query($sql_aberta_boleto);

if (mysql_num_rows($st_abertas_boleto) > 0) {
    $rowaberto_boleto = mysql_fetch_row($st_abertas_boleto);

    $valor_aberto_boleto = $rowaberto_boleto[0];
    $total_aberto_boleto = $rowaberto_boleto[1];
}


$sql_cancelados_boleto = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	ST_COMPRA_COSO = 'C'
            AND 
            	DS_FORMAPGTO_COSO LIKE '%boleto%'
            AND
            	((DT_COMPRA_COSO > '$data_inicio' 
            AND 
            	DT_COMPRA_COSO < '$data_fim'));";


$st_cancelado_boleto = mysql_query($sql_cancelados_boleto);

if (mysql_num_rows($st_cancelado_boleto) > 0) {
    $rowcancelado_boleto = mysql_fetch_row($st_cancelado_boleto);

    $valor_cancelado_boleto = $rowcancelado_boleto[0];
    $total_cancelado_boleto = $rowcancelado_boleto[1];
}


$sql_pagas_geral = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	ST_COMPRA_COSO <> 'C'
            AND 
            	ST_COMPRA_COSO <> 'A'
            AND
            	((DT_PAGAMENTO_COSO > '$data_inicio' 
            AND 
            	DT_PAGAMENTO_COSO < '$data_fim'));";


$st_pagas_geral = mysql_query($sql_pagas_geral);


if (mysql_num_rows($st_pagas_geral) > 0) {
    $rowpago_geral = mysql_fetch_row($st_pagas_geral);

    $valor_pago_geral = $rowpago_geral[0];
    $total_pago_geral = $rowpago_geral[1];
}


$sql_aberta_geral = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	ST_COMPRA_COSO = 'A'
            AND
            	((DT_COMPRA_COSO > '$data_inicio' 
            AND 
            	DT_COMPRA_COSO < '$data_fim'));";


$st_abertas_geral = mysql_query($sql_aberta_geral);

if (mysql_num_rows($st_abertas_geral) > 0) {
    $rowaberto_geral = mysql_fetch_row($st_abertas_geral);

    $valor_aberto_geral = $rowaberto_geral[0];
    $total_aberto_geral = $rowaberto_geral[1];
}


$sql_cancelados_geral = "SELECT 
              	SUM(VL_TOTAL_COSO) as total,
              	COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
            	compras
            WHERE
            	NR_SEQ_LOJA_COSO = 1
            AND 
            	ST_COMPRA_COSO = 'C'
            AND
            	((DT_COMPRA_COSO > '$data_inicio' 
            AND 
            	DT_COMPRA_COSO < '$data_fim'));";


$st_cancelado_geral = mysql_query($sql_cancelados_geral);

if (mysql_num_rows($st_cancelado_geral) > 0) {
    $rowcancelado_geral = mysql_fetch_row($st_cancelado_geral);

    $valor_cancelado_geral = $rowcancelado_geral[0];
    $total_cancelado_geral = $rowcancelado_geral[1];
}


$sql_aniver = "SELECT 
                SUM(VL_TOTAL_COSO) as total,
                COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
                compras
            where
                ST_COMPROU_NIVER = '1'
            AND 
                ST_COMPRA_COSO <> 'C'
            AND
                ((DT_COMPRA_COSO > '$data_inicio' 
            AND 
                DT_COMPRA_COSO < '$data_fim'));";


$st_niver = mysql_query($sql_aniver);

if (mysql_num_rows($st_niver) > 0) {
    $rowniver = mysql_fetch_row($st_niver);

    $valor_niver = $rowniver[0];
    $total_niver = $rowniver[1];

    if ($valor_niver == "") {
        $valor_niver = 0;
    }
}

$sql_primeira = "SELECT 
                SUM(VL_TOTAL_COSO) as total,
                COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
                compras
            where
                DS_DESCPROMO_COSO LIKE '% de desconto para serem usando em uma pr%'
            AND 
                ST_COMPRA_COSO <> 'C'
            AND
                ((DT_COMPRA_COSO > '$data_inicio' 
            AND 
                DT_COMPRA_COSO < '$data_fim'));";


$st_primeira = mysql_query($sql_primeira);

if (mysql_num_rows($st_primeira) > 0) {
    $rowprimeira = mysql_fetch_row($st_primeira);

    $valor_primeira = $rowprimeira[0];
    $total_primeira = $rowprimeira[1];

    if ($valor_primeira == "") {
        $valor_primeira = 0;
    }
}

$sql_parana = "SELECT 
                SUM(VL_TOTAL_COSO) as total,
                COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
                compras
            INNER JOIN 
                cadastros ON nr_seq_cadastro_caso = nr_seq_cadastro_coso
            where
                ST_COMPRA_COSO <> 'C'
            AND
                DS_UF_CASO = 'PR'
            AND
                ((DT_COMPRA_COSO > '$data_inicio' 
            AND 
                DT_COMPRA_COSO < '$data_fim'));";


$st_parana = mysql_query($sql_parana);

if (mysql_num_rows($st_parana) > 0) {
    $rowparana = mysql_fetch_row($st_parana);

    $valor_parana = $rowparana[0];
    $total_parana = $rowparana[1];

    if ($valor_parana == "") {
        $valor_parana = 0;
    }
}


$sql_local = "SELECT 
                SUM(VL_TOTAL_COSO) as total,
                COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
                compras
            INNER JOIN 
                cadastros ON nr_seq_cadastro_caso = nr_seq_cadastro_coso
            where
                ST_COMPRA_COSO <> 'C'
            AND
                DS_CIDADE_CASO = 'Londrina'
            AND
                ((DT_COMPRA_COSO > '$data_inicio' 
            AND 
                DT_COMPRA_COSO < '$data_fim'));";


$st_local = mysql_query($sql_local);

if (mysql_num_rows($st_local) > 0) {
    $rowlocal = mysql_fetch_row($st_local);

    $valor_local = $rowlocal[0];
    $total_local = $rowlocal[1];

    if ($valor_local == "") {
        $valor_local = 0;
    }
}

$sql_rio = "SELECT 
                SUM(VL_TOTAL_COSO) as total,
                COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
                compras
            INNER JOIN 
                cadastros ON nr_seq_cadastro_caso = nr_seq_cadastro_coso
            where
                ST_COMPRA_COSO <> 'C'
            AND
                DS_UF_CASO = 'RJ'
            AND
                ((DT_COMPRA_COSO > '$data_inicio' 
            AND 
                DT_COMPRA_COSO < '$data_fim'));";


$st_rio = mysql_query($sql_rio);

if (mysql_num_rows($st_rio) > 0) {
    $rowrio = mysql_fetch_row($st_rio);

    $valor_rio = $rowrio[0];
    $total_rio = $rowrio[1];

    if ($valor_rio == "") {
        $valor_rio = 0;
    }
}

$sql_sp = "SELECT 
                SUM(VL_TOTAL_COSO) as total,
                COUNT(NR_SEQ_COMPRA_COSO) as compras
            FROM
                compras
            INNER JOIN 
                cadastros ON nr_seq_cadastro_caso = nr_seq_cadastro_coso
            where
                ST_COMPRA_COSO <> 'C'
            AND
                DS_UF_CASO = 'SP'
            AND
                ((DT_COMPRA_COSO > '$data_inicio' 
            AND 
                DT_COMPRA_COSO < '$data_fim'));";


$st_sp = mysql_query($sql_sp);

if (mysql_num_rows($st_sp) > 0) {
    $rowsp = mysql_fetch_row($st_sp);

    $valor_sp = $rowsp[0];
    $total_sp = $rowsp[1];

    if ($valor_sp == "") {
        $valor_sp = 0;
    }
}

$sql_produto_dia = "SELECT 
                      NR_SEQ_PRODUTO_BARC
                    FROM 
                      banners_agendados
                    WHERE 
                      ST_ATUAL_BARC = 'S'
                    ORDER BY 
                      DT_PUBLICACAO_BARC DESC
                    LIMIT 1";
$st_pdia = mysql_query($sql_produto_dia);
$row = mysql_fetch_row($st_pdia);

$sql_produto_dia = "SELECT 
                                sum(vl_produto_ceso * nr_qtde_ceso),
                                COUNT(NR_SEQ_COMPRA_COSO) AS compras
                            FROM
                                compras
                                    INNER JOIN
                                cestas ON nr_seq_compra_coso = nr_seq_compra_ceso
                            WHERE
                                nr_seq_produto_ceso = '$row[0]'
                                AND
                                    ((DT_COMPRA_COSO > '$data_inicio' 
                                AND 
                                    DT_COMPRA_COSO < '$data_fim'));";
$st_prdia = mysql_query($sql_produto_dia);
$row_dia = mysql_fetch_row($st_prdia);

$sql_sale = "SELECT 
                SUM(nr_qtde_ceso * VL_PRODUTO_CESO) AS total,
                COUNT(NR_SEQ_COMPRA_COSO) AS compras
            FROM
                compras
                    INNER JOIN
                cestas ON nr_seq_compra_ceso = nr_seq_compra_coso
                    INNER JOIN
                produtos ON nr_seq_produto_prrc = nr_seq_produto_ceso
            WHERE
                NR_SEQ_LOJA_COSO = 1
                    AND ST_COMPRA_COSO <> 'C'
                    AND ST_COMPRA_COSO <> 'A'
                    AND tp_destaque_prrc = 2
            AND
                ((DT_COMPRA_COSO > '$data_inicio' 
            AND 
                DT_COMPRA_COSO < '$data_fim'));";


$st_sale = mysql_query($sql_sale);
$row_sale = mysql_fetch_row($st_sale);
?>

<?php

$topo = '<table align="center"><tr><td>
	<table width="632" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2" height="4"><img src="http://www.reverbcity.com/imgrast/line1.gif" width="632" height="4" /></td>
		</tr>
		<tr>
			<td align="left" height="75"><a href="http://www.reverbcity.com">
				<img border="0" src="http://www.reverbcity.com/imgrast/logo.gif" width="235" height="75" /></a>
			</td>
			<td align="right" height="75">
				<table width="150" cellpadding="0" cellspacing="0" height="25" border="0">
					<tr>
					    <td><a href="https://open.spotify.com/user/reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/spotify.png" height="25" /></a></td>
						<td><a href="http://instagram.com/reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/rss.gif" width="26" height="25" /></a></td>
						<td><a href="https://www.facebook.com/Reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/fb.gif" width="26" height="25" /></a></td>
						<td><a href="https://twitter.com/reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/twi.gif" width="26" height="25" /></a></td>
						<td><a href="http://pinterest.com/reverbcity/pins/"><img border="0" src="http://www.reverbcity.com/imgrast/pin.gif" width="26" height="25" /></a></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" height="5">
				<img src="http://www.reverbcity.com/imgrast/line2.gif" width="632" height="5" /></td>
			</tr>
		</table>
		<table width="632" border="0" cellpadding="0" cellspacing="0">
			<tr><td>
				<div width="632" style="background-color: #646464; padding: 8px 15px 8px 15px; font-family:Verdana;font-size:12px;color: #c2c3c4; margin-top: 15px;">
					'.$assunto.'
				</div>
			</td></tr>
			<tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="632" height="40" /></td></tr>
		</table>
		<table id="Table_01" width="532" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td colspan="11" width="632" bgcolor="#646464" height="30" style="padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4">
					<b><p style="text-decoration:none; font-size:12pz; color:#c2c3c4;">PEDIDOS EM GERAL</p></b>
				</td>
			</tr>
			<tr>
				<td colspan="11" bgcolor="#dcddde" width="632" height="28" style="padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464">
					<b><p style="width: 602px; text-decoration:none; font-size:12pz; color:#646464;">Pedidos Pagos</p></b>
				</td>
			</tr>
			<tr>
				<td colspan="11" width="632" height="30" style="padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464">
					<b> Quantidade de pedidos pagos : </b> '.$total_pago_geral.' </br>
				</td>
			</tr>
		</table>';

$mensagem = "</center>
			<table id='Table_01' width='530' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'>
						<b><p style='text-decoration:none; font-size:12pz; color:#c2c3c4;'>PEDIDOS EM GERAL</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Pagos</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos pagos : </b> $total_pago_geral </br>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total Pago :</b> R$ " . number_format($valor_pago_geral, 2, ",", ".") . "
					</td>
				</tr>

				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos em Aberto</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos abertos : </b> $total_aberto_geral
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total em Aberto :</b> R$ " . number_format($valor_aberto_geral, 2, ",", ".") . "
					</td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Cancelados</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos cancelados : </b> $total_cancelado_geral </br>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total Cancelado :</b> R$ " . number_format($valor_cancelado_geral, 2, ",", ".") . "</br>
					</td>
				</tr>


                                <tr>
                                    <td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#c2c3c4;'>PEDIDOS PRIMEIRA COMPRA</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Pagos</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b> Quantidade de pedidos pagos : </b> $total_primeira </br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                          <b>Valor Total Pago :</b> R$ " . number_format($valor_primeira, 2, ",", ".") . "
                                    </td>
                                </tr>


                                <tr>
                                    <td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#c2c3c4;'>PEDIDOS ANIVERSARIANTES</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Pagos</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b> Quantidade de pedidos pagos : </b> $total_niver </br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                          <b>Valor Total Pago :</b> R$ " . number_format($valor_niver, 2, ",", ".") . "
                                    </td>
                                </tr>

				<tr>
					<td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'>
						<b><p style='text-decoration:none; font-size:12pz; color:#c2c3c4;'>VISA</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Pagos</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos pagos : </b> $total_pagas </br>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total Pago :</b> R$ " . number_format($valor_pago, 2, ",", ".") . "
					</td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos em Aberto</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos abertos : </b> $total_aberto
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total em Aberto :</b> R$ " . number_format($valor_aberto, 2, ",", ".") . "
					</td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Cancelados</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos cancelados : </b> $total_cancelado </br>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total Cancelado :</b> R$ " . number_format($valor_cancelado, 2, ",", ".") . "</br>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'> 
						" . utf8_decode('<b>MASTER CARD </b>') . "
					</td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Pagos</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos pagos : </b> $total_pagas_master </br>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total Pago :</b> R$ " . number_format($valor_pago_master, 2, ",", ".") . "
					</td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos em Aberto</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos abertos : </b> $total_aberto_master
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total em Aberto :</b> R$ " . number_format($valor_aberto_master, 2, ",", ".") . "
					</td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Cancelados</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos cancelados : </b> $total_cancelado_master </br>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total Cancelado :</b> R$ " . number_format($valor_cancelado_master, 2, ",", ".") . "</br>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'> 
						" . utf8_decode('<b>DINNERS </b>') . "
					</td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Pagos</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos pagos : </b> $total_pagas_diners </br>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total Pago :</b> R$ " . number_format($valor_pago_diners, 2, ",", ".") . "
					</td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos em Aberto</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos abertos : </b> $total_aberto_diners
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total em Aberto :</b> R$ " . number_format($valor_aberto_diners, 2, ",", ".") . "
					</td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Cancelados</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos cancelados : </b> $total_cancelado_diners </br>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total Cancelado :</b> R$ " . number_format($valor_cancelado_diners, 2, ",", ".") . "</br>
					</td>
				</tr>
                                <tr>
                                    <td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'> 
                                        " . utf8_decode('<b>AMEX </b>') . "
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Pagos</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b> Quantidade de pedidos pagos : </b> $total_pagas_amex </br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                          <b>Valor Total Pago :</b> R$ " . number_format($valor_pago_amex, 2, ",", ".") . "
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos em Aberto</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b> Quantidade de pedidos abertos : </b> $total_aberto_amex
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                          <b>Valor Total em Aberto :</b> R$ " . number_format($valor_aberto_amex, 2, ",", ".") . "
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Cancelados</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b> Quantidade de pedidos cancelados : </b> $total_cancelado_amex </br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                          <b>Valor Total Cancelado :</b> R$ " . number_format($valor_cancelado_amex, 2, ",", ".") . "</br>
                                    </td>
                                </tr>
				<tr>
					<td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'> 
						" . utf8_decode('<b>BOLETO</b>') . "
					</td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Pagos</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos pagos : </b> $total_pagas_boleto </br>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total Pago :</b> R$ " . number_format($valor_pago_boleto, 2, ",", ".") . "
					</td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos em Aberto</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos abertos : </b> $total_aberto_boleto
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total em Aberto :</b> R$ " . number_format($valor_aberto_boleto, 2, ",", ".") . "
					</td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Cancelados</p></b>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						<b> Quantidade de pedidos cancelados : </b> $total_cancelado_boleto </br>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						  <b>Valor Total Cancelado :</b> R$ " . number_format($valor_cancelado_boleto, 2, ",", ".") . "</br>
					</td>
				</tr>
                                <tr>
                                    <td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'> 
                                        " . utf8_decode('<b>PRODUTO DO DIA </b>') . "
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b> Quantidade de pedidos : </b> " . $row_dia[1] . " </br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                          <b>Valor Total :</b> R$ " . number_format($row_dia[0], 2, ",", ".") . "</br>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'> 
                                        " . utf8_decode('<b>VENDAS SALE</b>') . "
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b> Quantidade de pedidos : </b> " . $row_sale[1] . " </br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                          <b>Valor Total :</b> R$ " . number_format($row_sale[0], 2, ",", ".") . "</br>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#c2c3c4;'>PEDIDOS LONDRINA</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Pagos</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b> Quantidade de pedidos pagos : </b> $total_local </br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                          <b>Valor Total Pago :</b> R$ " . number_format($valor_local, 2, ",", ".") . "
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#c2c3c4;'>PEDIDOS PARAN&Aacute;</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Pagos</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b> Quantidade de pedidos pagos : </b> $total_parana </br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                          <b>Valor Total Pago :</b> R$ " . number_format($valor_parana, 2, ",", ".") . "
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#c2c3c4;'>PEDIDOS S&Atilde;O PAULO</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Pagos</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b> Quantidade de pedidos pagos : </b> $total_sp </br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                          <b>Valor Total Pago :</b> R$ " . number_format($valor_sp, 2, ",", ".") . "
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#c2c3c4;'>PEDIDOS RIO DE JANEIRO</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' bgcolor='#dcddde' width='530' height='28' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b><p style='text-decoration:none; font-size:12pz; color:#646464;'>Pedidos Pagos</p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b> Quantidade de pedidos pagos : </b> $total_rio </br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                          <b>Valor Total Pago :</b> R$ " . number_format($valor_rio, 2, ",", ".") . "
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'> 
                                        " . utf8_decode('<b>VENDAS NORTE: AM, RR, AP, PA, TO, RO, AC</b>') . "
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b> Quantidade de pedidos : </b> " . $rownorte[1] . " </br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                          <b>Valor Total :</b> R$ " . number_format($rownorte[0], 2, ",", ".") . "</br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' bgcolor='#646464' height='30' style='padding-left: 30px; font-family:Verdana; font-size:12px; color:#c2c3c4'> 
                                        " . utf8_decode('<b>VENDAS NORDESTE: MA, PI, CE, RN, PE, PB, SE, AL, BA</b>') . "
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                        <b> Quantidade de pedidos : </b> " . $rownordeste[1] . " </br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='11' width='530' height='30' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
                                          <b>Valor Total :</b> R$ " . number_format($rownordeste[0], 2, ",", ".") . "</br>
                                    </td>
                                </tr>                

				<tr>
					<td colspan='11'>
						<img src='http://www.reverbcity.com/Readm_911s/images/0---mail_padrao_22.jpg' width='530' height='35' alt=''></td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='85' style='padding-left: 32px; font-family:Verdana; font-size:12px; color:#646464'>
						Abraços,</br>
						Equipe Reverbcity</br>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' bgcolor='#646464' height='28' style='padding-left: 496px; font-family:Verdana; font-size:8px; color:#b9bbbd; '>
						<a href='http://www.reverbcity.com' style='text-decoration:none; color:#b9bbbd;'>REVERBCITY.COM</a>
					</td>
				</tr>
				<tr>
					<td colspan='11' width='530' height='48' style='padding-left: 5px; font-family:Verdana; font-size:10px; color:#cdcecf;'>
					 <b><a href='http://www.reverbcity.com' style='text-decoration:none; font-size:10px; color:#cdcecf;'>www.reverbcity.com</a></b></br>
			          " . utf8_decode('Para garantir que você sempre receba as nossas mensagens</br>
			            adicione o e-mail atendimento@reverbcity.com em sua lista de contatos.') . "
					</td>
				</tr>
				<tr>
					<td colspan='13'>
						<img src='http://www.reverbcity.com/Readm_911s/images/0---mail_padrao_26.jpg' width='632' height='29' alt=''></td>
				</tr>
			</table>
		</center>";

$rodape = '<table  border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="3"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_19.png" width="632" height="104" alt=""></td>
					</tr>
					<tr>
						<td><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="210.6666666666667" height="28" alt=""></td>
						<td><a href="mailto:atendimento@reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="210.6666666666667" height="28" alt=""></a></td>
						<td><a href="http://www.reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="210.6666666666667" height="28" alt=""></a></td>
					</tr>
				</table>';

$corpo = $topo.$mensagem.$rodape;

$contatos = array(
    'tony' => "contato@reverbcity.com",
    'gabi' => "marketing@reverbcity.com",
    'rose' => "financeiro@reverbcity.com",
    'miri' => "atendimento@reverbcity.com",
    'devreverb' => "desenvolvimento@reverbcity.com",
    'alecio' => "bittencourtal@gmail.com");

foreach ($contatos as $key => $contato) {
//    $corpo = IncluiPapelCarta("sistema", $mensagem, "Vendas Diarias $data_formatada");
    EnviaEmailNovo("atendimento@reverbcity.com", "Reverbcity", $contato, "", "", "Vendas Diarias - Reverbcity - $data_formatada", $corpo);
}
?>
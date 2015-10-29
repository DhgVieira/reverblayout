<?php

include '../Readm_911s/lib.php';
include '../Readm_911s/auth.php';

$sql_sets = "
SET @tipo = '';
SET @marca = 'ReverbCity';
SET @doc = '08345875000137';
SET @ean_unit = 'PC';
SET @ean_amount = '1';
SET @hierarchy = '';
SET @additional = '';
SET @delivery_time = '';
SET @cost = '';
SET @ipi = '';
SET @icms = '';
SET @ncm = '';
SET @mva = '';
SET @fonte = '';
SET @ean = '';
SET @ean_length = '29';
SET @ean_width = '27';
SET @ean_height = '2.5';
SET @dun = '';
SET @dun_length = '';
SET @dun_width = '';
SET @dun_height = '';
SET @dun_amout = '';
SET @dun_weight = '';
SET @warranty_time = '';
SET @ppb_ordinance = '';
SET @ppb_date = '';
SET @pms1 = '';
SET @pms2 = '';
SET @pms_date_ini = '';
SET @pms_date_final = '';
SET @pmd1 = '';
SET @pmd2 = '';
SET @pmd_date_ini = '';
SET @pmd_date_final = '';
SET @st = '';
SET @youtube_id = '';
SET @included = '';
SET @sku_id = '';
SET @variation = '';
SET @images = '';
";

$st = mysql_query($sql_sets);

$sql = "

SELECT 
    (select @tipo) as type,
    (select @doc) as doc,
    p.NR_SEQ_PRODUTO_PRRC as prod_id,
    p.DS_PRODUTO_PRRC as prod_name,
    pt.DS_CATEGORIA_PTRC as model,
    (select @marca) as brand,
    c.cor AS color,
    p.DS_INFORMACOES_PRRC as spec,
    (select @hierarchy) as hierarchy,
    (select @additional) as additional,
    (select @additional) as delivery_time,
    p.VL_PRODUTO_PRRC as price_from,
    p.VL_PRODUTO_PRRC as price_to,
    (select @cost) as cost,
    (select @ipi) as ipi,
    (select @icms) as icms,
    (select @ncm) as ncm,
    (select @mva) as mva,
    (select @fonte) as source,
    (select @ean) as ean,
    (select @ean_length) as ean_length,
    (select @ean_width) as ean_width,
    (select @ean_height) as ean_height,
    e.NR_QTDE_ESRC as ean_amount,
    (select @ean_amount) as ean_amount,
    p.NR_PESOGRAMAS_PRRC as ean_weight,
    (select @dun) as ean,
    (select @dun_length) as dun_length,
    (select @dun_width) as dun_width,
    (select @dun_height) as dun_height,
    (select @dun_amount) as dun_amount,
    (select @dun_weight) as dun_weight,
    (select @warranty_time) as warranty_time,
    (select @ppb_ordinance) as ppb_ordinance,
    (select @ppb_date) as ppb_date,
    (select @pms1) as pms1,
    (select @pms2) as pms2,
    (select @pms_date_ini) as pms_date_ini,
    (select @pms_date_final) as pms_date_final,
    (select @pmd1) as pmd1,
    (select @pmd2) as pmd2,
    (select @pmd_date_ini) as pmd_date_ini,
    (select @st) as st,
    (select @youtube_id) as youtube_id,
    (select @included) as included,
    (select @sku_id) as sku_id,
    (select @variation) as variation,
    (select @images) as images,
    p.ST_PRODUTOS_PRRC as status
FROM
    produtos as p
        left join
    estoque as e ON e.NR_SEQ_PRODUTO_ESRC = p.NR_SEQ_PRODUTO_PRRC
        left join
    tamanhos as t ON t.NR_SEQ_TAMANHO_TARC = e.NR_SEQ_TAMANHO_ESRC
        left join
    produtos_tipo as pt ON pt.NR_SEQ_CATEGPRO_PTRC = p.NR_SEQ_TIPO_PRRC
        left join
    cores as c ON c.idcor = p.NR_SEQ_COR_PRRC
where
    p.NR_SEQ_TIPO_PRRC = 6
        and p.NR_SEQ_PRODUTO_PRRC = 5699
limit 1;";

$st = mysql_query($sql);
$conteudotxt = '';
$x = 0;
while ($array = mysql_fetch_assoc($st)) {
    if ($x == 0) {
        //monta o cabeçalho
        foreach($array as $key => $value) {
            $conteudotxt .= "\"$key\";";
        }
        $conteudotxt = substr($conteudotxt, 0, -1);
        $conteudotxt = $conteudotxt . '\n';
    }
    foreach ($array as $key => $value) {
        $value = htmlspecialchars_decode($value);
        if ($key == 'prod_name' || $key == 'model') {
            if ($key == 'prod_name') {
                $conteudotxt .= '"Camiseta ' . $value . '";';
                $model = explode("-", $value);
            }
            if ($key == 'model') {
                $conteudotxt .= '"' . $model[0] . '";';
            }
        } else {
            $conteudotxt .= '"' . $value . '";';
        }
        if($key == 53){
            $conteudotxt = $conteudotxt . '\n';
        }
    }
    $x = 1;
}

$txt = fopen("produtomundomax.txt", "a");
$escreve = fwrite($txt, $conteudotxt);
fclose($txt);




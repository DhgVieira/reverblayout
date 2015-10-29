<?php
include 'auth.php';
include 'lib.php';

$id_prod = request("prod");

$sql = "select NR_QTDE_ECRC, DS_PRODUTO2_PRRC, DT_ACAO_ECRC, DT_CADASTRO_PRRC from estoque_controle, produtos where NR_SEQ_PRODUTO_ECRC = NR_SEQ_PRODUTO_PRRC and
        NR_SEQ_TAMANHO_ECRC = 3 and NR_QTDE_ECRC > 0 and NR_SEQ_LOJAS_PRRC = 1 and NR_SEQ_PRODUTO_ECRC = $id_prod
        order by DT_ACAO_ECRC";
$st = mysql_query($sql);

$dt_entrada = "";

if (mysql_num_rows($st) > 0) {
    $qtdemaior = 0;
    $mostrou = false;
    while($row = mysql_fetch_row($st)) {
        $qtde       = $row[0];
        $ds_produto = $row[1];
        $dt_acao    = $row[2];
        $dt_cad_prod= $row[3];
        
        if ($qtde >= 8 && $qtdemaior > 0){
            //echo "Nova entrada de Estoque - Data: $dt_acao - Qtde: $qtde<br />";
            $dt_entrada = $dt_acao;
            $mostrou = true;
        }
        
        if ($qtdemaior < $qtde && $qtde >= 8){
            //echo "Produto: $ds_produto - Data de Entrada: $dt_acao - Qtde: $qtde<br />";
            $qtdemaior = $qtde;
            $dt_entrada = $dt_acao;
            $mostrou = true;
        }
    }
}

if (!$mostrou){
    $sql2 = "select DT_CADASTRO_PRRC, DS_PRODUTO2_PRRC from produtos where NR_SEQ_PRODUTO_PRRC = $id_prod";
    $st2 = mysql_query($sql2);
    if (mysql_num_rows($st2) > 0) {
        $row2 = mysql_fetch_row($st2);
        $dt_cad = $row2[0];
        $ds_produto = $row2[1];
        $dt_acao = $dt_cad;
        $dt_entrada = $dt_acao;
        //echo "Produto Cadastrado - Data: $dt_cad<br />";
    }
}

echo "Fechamento Produto: $ds_produto\n";
echo "Data de Entrada no Estoque: $dt_entrada\n";
echo "Data de Fechamento: ".date("Y-m-d G:i")."\n\n";

$str_tamanhos = "";
//tamanhos vendidos
$sql = "SELECT DS_TAMANHO_TARC, count(*) from compras, cestas, tamanhos
where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and NR_SEQ_TAMANHO_CESO = NR_SEQ_TAMANHO_TARC
and ST_COMPRA_COSO IN ('E','V','P') AND NR_SEQ_PRODUTO_CESO = $id_prod AND NR_SEQ_LOJA_COSO = 1 
and (DT_COMPRA_COSO BETWEEN '$dt_entrada' and sysdate())
and NR_SEQ_CADASTRO_COSO not in (6605, 8074) GROUP BY NR_SEQ_TAMANHO_CESO order by DS_TAMANHO_TARC";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)){
        $ds_tam = $row[0];
        $qtde   = $row[1];
        $str_tamanhos .= $ds_tam." - ".$qtde."\n";
    }    
}

echo $str_tamanhos."\n";

$str_sexo = "";   
//quantidade de homens q compraram
$sql = "SELECT count(*) from cadastros, compras, cestas
where NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO and NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
and ST_COMPRA_COSO IN ('E','V','P') AND NR_SEQ_PRODUTO_CESO = $id_prod AND NR_SEQ_LOJA_COSO = 1 
and (DT_COMPRA_COSO BETWEEN '$dt_entrada' and sysdate()) and DS_SEXO_CACH in ('Masculino','M')
and NR_SEQ_CADASTRO_COSO not in (6605, 8074);";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_row($st);
    $str_sexo = "Compradores Homens: ".$row[0]."\n";
}

//quantidade de mulheres q compraram
$sql = "SELECT count(*) from cadastros, compras, cestas
where NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO and NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
and ST_COMPRA_COSO IN ('E','V','P') AND NR_SEQ_PRODUTO_CESO = $id_prod AND NR_SEQ_LOJA_COSO = 1 
and (DT_COMPRA_COSO BETWEEN '$dt_entrada' and sysdate()) and DS_SEXO_CACH not in ('Masculino','M')
and NR_SEQ_CADASTRO_COSO not in (6605, 8074);";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_row($st);
    $str_sexo .= "Compradores Mulheres: ".$row[0]."\n";
} 

echo $str_sexo."\n";

$str_compras = "";
//compradores desde a ultima data encontrada de entrada em estoque
$sql = "SELECT NR_SEQ_CADASTRO_CASO, DS_NOME_CASO, DS_CIDADE_CASO, DS_UF_CASO, 
DS_EMAIL_CASO, sum(NR_QTDE_CESO), VL_PRODUTO_CESO, NR_SEQ_COMPRA_COSO, DS_OBS_COSO from cadastros, compras, cestas
where NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO and NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
and ST_COMPRA_COSO IN ('E','V','P') AND NR_SEQ_PRODUTO_CESO = $id_prod AND NR_SEQ_LOJA_COSO = 1 
and (DT_COMPRA_COSO BETWEEN '$dt_entrada' and sysdate())
and NR_SEQ_CADASTRO_COSO not in (6605, 8074) GROUP BY NR_SEQ_CADASTRO_CASO order by DS_NOME_CASO";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)){
        $id_cad     = $row[0];
        $ds_nome    = $row[1];
        $ds_cidade  = $row[2];
        $ds_uf      = $row[3];
        $ds_email   = $row[4];
        $qtde       = $row[5];
        $vl_prod    = $row[6];
        $id_compra  = $row[7];
        $ds_obs     = $row[8];
        
        $ds_obs = str_replace("\t","",$ds_obs);
        
        $str_compras .= $id_cad." - ".$ds_nome." - ".$ds_cidade."/".$ds_uf." - ".$ds_email." - ".$qtde." - R$ ".number_format($vl_prod,2,",",".")." - ".$id_compra." - ".$ds_obs."\n";
    }    
} 

echo $str_compras."\n";

mysql_close($con);
?>
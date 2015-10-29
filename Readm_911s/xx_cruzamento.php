<?php
include 'lib.php';
include 'auth.php';

$dataini = request("ini");
$datafim = request("fim");

echo "$dataini<br />";
echo "$datafim<br />";
echo "<br />";

echo "Total de Cadastros: ";

$sql = "select count(*) from cadastros where DT_CADASTRO_CASO >= '$dataini'
        and DT_CADASTRO_CASO <= '$datafim'";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_array($st);
    echo $row[0];
}else{
    echo "0";
}

echo "<br />";
echo "Total de Vendas: ";

$sql = "select count(*) from compras where DT_COMPRA_COSO >= '$dataini'
and DT_COMPRA_COSO <= '$datafim'
and NR_SEQ_CADASTRO_COSO <> 8074
and NR_SEQ_CADASTRO_COSO <> 6605";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_array($st);
    echo $row[0];
}else{
    echo "0";
}

echo "<br />";
echo "Total de Vendas Confirmadas: ";

$sql = "select count(*) from compras where DT_COMPRA_COSO >= '$dataini'
and DT_COMPRA_COSO <= '$datafim'
and ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A'
and NR_SEQ_CADASTRO_COSO <> 8074
and NR_SEQ_CADASTRO_COSO <> 6605";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_array($st);
    echo $row[0];
}else{
    echo "0";
}

echo "<br />";
echo "Total de Vendas de Homens: ";

$sql = "select count(*) from compras where ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A'
and DT_COMPRA_COSO >= '$dataini'
and DT_COMPRA_COSO <= '$datafim'
and NR_SEQ_CADASTRO_COSO <> 8074
and NR_SEQ_CADASTRO_COSO <> 6605
and NR_SEQ_CADASTRO_COSO in (select NR_SEQ_CADASTRO_CASO from cadastros where DS_SEXO_CACH in ('M','Masculino'))";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_array($st);
    echo $row[0];
}else{
    echo "0";
}

echo "<br />";
echo "Valor Bruto: ";

$sql = "select sum(VL_TOTAL_COSO) from compras where ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A'
and DT_COMPRA_COSO >= '$dataini'
and DT_COMPRA_COSO <= '$datafim'
and NR_SEQ_CADASTRO_COSO <> 8074
and NR_SEQ_CADASTRO_COSO <> 6605";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_array($st);
    echo number_format($row[0],2,",","");
}else{
    echo "0";
}

echo "<br />";
echo "Valor Liquido: ";

$tot = 0;

$sql = "select DS_FORMAPGTO_COSO, NR_PARCELAS_COSO, VL_TOTAL_COSO, 
VL_FRETE_COSO, VL_FRETECUSTO_COSO from compras where ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A'
and DT_COMPRA_COSO >= '$dataini'
and DT_COMPRA_COSO <= '$datafim'
and NR_SEQ_CADASTRO_COSO <> 8074
and NR_SEQ_CADASTRO_COSO <> 6605";

$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_array($st)){
        $vltotal   	= $row["VL_TOTAL_COSO"];
		$frete		= $row["VL_FRETE_COSO"];
        $forma		= $row["DS_FORMAPGTO_COSO"];
        $parcelas	= $row["NR_PARCELAS_COSO"];
        $fretereal	= $row["VL_FRETECUSTO_COSO"];
        $nome   	= $row["DS_NOME_CASO"];
        $custo      = CalculaCusto($vltotal,$forma,$parcelas,$loja=1);
        if ($fretereal > 0) {
            $frete = $fretereal;
        }
        $vlrliquid  = ($vltotal - $frete - $custo);
        $tot += $vlrliquid;
    }
    echo number_format($tot,2,",","");
    
}else{
    echo "0";
}

echo "<br />";
echo "Custo dos Produtos: ";

$sql = "select sum(if(VL_PRODUTO2_PRRC>0,(VL_PRODUTO2_PRRC*NR_QTDE_CESO),(VL_PRODUTO_PRRC*40/100)*NR_QTDE_CESO))
from compras, cestas, produtos where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO AND
NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC and ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A'
and DT_COMPRA_COSO >= '$dataini'
and DT_COMPRA_COSO <= '$datafim'
and NR_SEQ_CADASTRO_COSO <> 8074
and NR_SEQ_CADASTRO_COSO <> 6605";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_array($st);
    echo number_format($row[0],2,",","");
}else{
    echo "0";
}

mysql_close($con);
?>
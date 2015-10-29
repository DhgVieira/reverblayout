<?php
exit();
include 'auth.php';
include 'lib.php';

$idp 	= request("idp");

$arrayprod = array();

$x=0;
$sql = "select NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC from estoque where NR_SEQ_PRODUTO_ESRC = $idp";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)){
        $arrayprod[$x][0] = $row[0];
        $arrayprod[$x][1] = $row[1];
        $x++;
    }
}

$str = "delete from estoque where NR_SEQ_PRODUTO_ESRC = $idp";
$st = mysql_query($str);

$str = "delete from estoque_controle where NR_SEQ_PRODUTO_ECRC = $idp";
$st = mysql_query($str);

for ($f=0;$f<$x;$f++) {
    $str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC)
        VALUES (1, $idp, ".$arrayprod[$f][0].", ".$arrayprod[$f][1].")";
    $st = mysql_query($str);
    //echo $str."<br>";
    $dsacao = "Adicionou ".$arrayprod[$f][1]." unidades";
    $obs = "Entrada de Estoque Inicial";
    GravaLogEstoque(11,$idp,$arrayprod[$f][0],$dsacao,$obs,$arrayprod[$f][1]);
}

Header("Location: estoque.php?idp=$idp");
exit();
?>
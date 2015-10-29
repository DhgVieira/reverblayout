<?php
include 'auth.php';
include 'lib.php';
$idp 	= request("idp");
$tam	= request("tam");
$acao 	= request("acao");
$obs 	= request("obs");
$qtde 	= request("qtde");
$doform	= request("doform");

$sql = "select NR_ORDEM_TARC from tamanhos, estoque where NR_SEQ_TAMANHO_TARC = NR_SEQ_TAMANHO_ESRC AND NR_SEQ_TAMANHO_ESRC = $tam";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $row = mysql_fetch_row($st);
    $posicao = $row[0];
}


if ($doform == "S" && $qtde < 1) {
    Header("Location: estoque.php?idp=$idp");
    exit();
}

if (!$qtde) {
    ?>
    <!--
    <script>
        alert('Funcao desabilitada temporariamente. Use o formulario ao lado (observacao nunca eh demais, use a vontade)');
        document.location.href='estoque.php?idp=<?php echo $idp; ?>';
    </script>
    -->
    <?php
    //exit();
    $qtde = 1;
}

$dsplu = "";
if ($qtde > 1) $dsplu = "s";

if ($acao){
    $sql = "select NR_SEQ_ESTOQUE_ESRC, NR_QTDE_ESRC from estoque where NR_SEQ_PRODUTO_ESRC = $idp and NR_SEQ_TAMANHO_ESRC = $tam";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
        $row = mysql_fetch_row($st);
        $idestoque = $row[0];
        $qtestoque = $row[1];
        if ($acao == "I"){
            $str = "update estoque set NR_QTDE_ESRC = NR_QTDE_ESRC + $qtde WHERE NR_SEQ_ESTOQUE_ESRC = $idestoque";
            $dsacao = "Adicionou $qtde unidade$dsplu";
            GravaLogEstoque($SS_logadm,$idp,$tam,$dsacao,$obs,$qtde);
        }else{
            if ($qtestoque == 0){
                $dsacao = "Deixou sem Sold Out";
                $str = "delete from estoque where NR_SEQ_ESTOQUE_ESRC = $idestoque";
                GravaLogEstoque($SS_logadm,$idp,$tam,$dsacao,$obs,0);
            }else{
                $dsacao = "Removeu $qtde unidade$dsplu";
                $str = "update estoque set NR_QTDE_ESRC = NR_QTDE_ESRC - $qtde WHERE NR_SEQ_ESTOQUE_ESRC = $idestoque";
                GravaLogEstoque($SS_logadm,$idp,$tam,$dsacao,$obs,$qtde*-1);
            }
        }
        $posicao++;
        $st = mysql_query($str);   
    }else{
        if ($qtde > 0){
            $dsacao = "Adicionou $qtde nova$dsplu unidade$dsplu";
            $str = "INSERT INTO estoque (NR_SEQ_LOJA_ESRC, NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC)
                    VALUES (1, $idp, $tam, $qtde)";
            $st = mysql_query($str);
            GravaLogEstoque($SS_logadm,$idp,$tam,$dsacao,$obs,$qtde);
            $posicao++;
        }
    }
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Alterou Estoque $idp");

mysql_close($con);

Header("Location: estoque.php?idp=$idp&pos=$posicao");
exit();
?>
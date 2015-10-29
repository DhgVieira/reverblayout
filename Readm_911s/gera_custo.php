<?php
include 'auth.php';
include 'lib.php';

$compras = $_POST['etiq'];

if (!$compras) {
	Header("Location: compras.php");
	exit();
}

$result = "";
foreach ($compras as $idc) {
    $str = "select VL_TOTAL_COSO, VL_FRETE_COSO, DS_FORMAPGTO_COSO, NR_SEQ_COMPRA_COSO, NR_PARCELAS_COSO, VL_FRETECUSTO_COSO,
            DS_NOME_CASO from compras, cadastros where NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and NR_SEQ_COMPRA_COSO = $idc";
    $st = mysql_query($str);
    if (mysql_num_rows($st) > 0) {
    	while($row = mysql_fetch_array($st)) {
    		$vltotal   	= $row["VL_TOTAL_COSO"];
    		$frete		= $row["VL_FRETE_COSO"];
            $forma		= $row["DS_FORMAPGTO_COSO"];
            $nrcompra	= $row["NR_SEQ_COMPRA_COSO"];
            $parcelas	= $row["NR_PARCELAS_COSO"];
            $fretereal	= $row["VL_FRETECUSTO_COSO"];
            $nome   	= $row["DS_NOME_CASO"];
            $custo      = CalculaCusto($vltotal,$forma,$parcelas,$loja=0);
            $vlrliquid  = ($vltotal - $fretereal - $custo);
            $result .= $nrcompra.";".number_format($vltotal,2,",","").";".number_format($custo,2,",","").";".number_format($fretereal,2,",","").";".number_format($vlrliquid,2,",","").";".$nome."<br />";
      }
    }
}

echo $result;
?>
<?php
include 'auth.php';
include 'lib.php';
error_reporting(0);

$compras = $_POST['etiq'];

if (!$compras) {
	Header("Location: compras.php");
	exit();
}

$nfe = $_POST['nfe'];

foreach ($compras as $idc) {
	$sql = "select * from compras, cadastros where NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and NR_SEQ_COMPRA_COSO = $idc";
	$st = mysql_query($sql);
    $dados = mysql_fetch_array($st);
	  
    $nome = strtoupper(RemoveAcentos($dados["DS_NOME_CASO"]));
	$ende = strtoupper(RemoveAcentos($dados["DS_ENDERECO_CASO"]));
    $numer = RemoveAcentos($dados["DS_NUMERO_CASO"]);
	$bairro = strtoupper(RemoveAcentos($dados["DS_BAIRRO_CASO"]));
	$complem = strtoupper(RemoveAcentos($dados["DS_COMPLEMENTO_CASO"]));
	$estado = strtoupper($dados["DS_UF_CASO"]);
	$cida = $dados["DS_CIDADE_CASO"];
	$cep = $dados["DS_CEP_CASO"];
    $cpfcnpj = $dados["DS_CPFCNPJ_CASO"];
    $foneddd = $dados["DS_DDDFONE_CASO"];
    $fone = $dados["DS_FONE_CASO"];
    
    $parcelas = $dados["NR_PARCELAS_COSO"];
    if (!$parcelas) $parcelas = 0;
    if ($parcelas <= 1) {
        $parcelas = 0;
    }else{
        $parcelas = 1;
    }
    
    $strnf = "INSERT INTO notas_fiscais (NR_SEQ_USUARIO_NFRC, NR_SEQ_CLIENTE_NFRC, NR_SEQ_COMPRA_NFRC, DT_EMISSAO_NFRC, NR_SEQNF_NFRC) 
              VALUES ($SS_logadm, ".$dados["NR_SEQ_CADASTRO_COSO"].", $idc, sysdate(), $nfe)";
    $stNF = mysql_query($strnf);
    
    $dataat = date("Y-m-d");
    
    $sqlIBGE = "select Municipio from DTB_05_05_2009n where DS_UF = '$estado' and Municipio_Nome like '%$cida%'";
    $stibge = mysql_query($sqlIBGE);
    $dadosibge = mysql_fetch_array($stibge);
    
    $codibge = $dadosibge[0];
    
    $arq = 'nfe/geradas/nfe_'.$dataat.'_'.$nfe.'.txt';
    $handle = fopen($arq,"w+");
    
    fwrite($handle,"NOTA FISCAL|1\r\n");
    fwrite($handle,"A|1.10|NFe\r\n");
    fwrite($handle,"B|41||VENDA|$parcelas|55|1|$nfe|$dataat|$dataat|1|4113700|1|1||1|1|3|1.4.3\r\n");
    fwrite($handle,"C|ANTONIO M DIAS CONFECCOES|REVERBCITY|9038567770|||\r\n");
    fwrite($handle,"C02|08345875000137\r\n");
    fwrite($handle,"C05|RUA BENJAMIM CONSTANT|1715|S304|CENTRO|4113700|Londrina|PR|86020320|||433228852\r\n");
    fwrite($handle,"E|$nome||\r\n");
    fwrite($handle,"E03|$cpfcnpj\r\n");
    fwrite($handle,"E05|$ende|$numer|$complem|$bairro|$codibge|".strtoupper(RemoveAcentos($cida))."|$estado|$cep|1058|BRASIL|\r\n");
    
    $sqlces = "select * from compras, cestas, produtos, produtos_tipo where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
            and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC and NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and NR_SEQ_COMPRA_COSO = $idc";
	$stces = mysql_query($sqlces);
    
    if ($estado == "PR"){
        $coduf = 5101;
    }else{
        $coduf = 6101;
    }
    
    $sqlprodtot = "select SUM(NR_QTDE_CESO*VL_PRODUTO_CESO) from compras, cestas, produtos, produtos_tipo where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
            and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC and NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and NR_SEQ_COMPRA_COSO = $idc";
    $stpt = mysql_query($sqlprodtot);
    $total_prods = 0;
    if (mysql_num_rows($stpt) > 0) {
        $rowpt = mysql_fetch_row($stpt);
        $total_prods = $rowpt[0];
    }
    
    $vlr_frete = $dados["VL_FRETE_COSO"];
    $vlr_total = $dados["VL_TOTAL_COSO"];
    
    $x = 1;
    $val_desc = false;
    $freteum = "";
    $descontoum = "";
    while($dadoscesta = mysql_fetch_array($stces)){
        fwrite($handle,"H|$x|".strtoupper(RemoveAcentos($dadoscesta["DS_CATEGORIA_PTRC"]))."\r\n");
        if (!$val_desc){
            //if ($dadoscesta["VL_PRODUTO_CESO"] > $vlr_frete){
                if ($vlr_frete > 0){
                    $freteum = number_format($vlr_frete,2,".","");
                }else{
                    $freteum = "";
                }
                
                //verifica se tem desconto
                if ( $total_prods > ($vlr_total - $vlr_frete) ){
                    $vlr_desc = $total_prods - ($vlr_total - $vlr_frete);
                    $descontoum = number_format($vlr_desc,2,".","");
                    if ($descontoum <= 0) $descontoum = "";
                }else{
                    $descontoum = "";
                }
                
                fwrite($handle,"I|".$dadoscesta["NR_SEQ_PRODUTO_CESO"]."||".strtoupper(RemoveAcentos($dadoscesta["DS_PRODUTO2_PRRC"]))."||||$coduf|UN|".$dadoscesta["NR_QTDE_CESO"]."|".number_format($dadoscesta["VL_PRODUTO_CESO"],4,".","")."|".number_format(($dadoscesta["VL_PRODUTO_CESO"]*$dadoscesta["NR_QTDE_CESO"]),2,".","")."||0|0|0|".$freteum."||".$descontoum."\r\n");
                $val_desc = true;   
            //}
        }else{
            fwrite($handle,"I|".$dadoscesta["NR_SEQ_PRODUTO_CESO"]."||".strtoupper(RemoveAcentos($dadoscesta["DS_PRODUTO2_PRRC"]))."||||$coduf|UN|".$dadoscesta["NR_QTDE_CESO"]."|".number_format($dadoscesta["VL_PRODUTO_CESO"],4,".","")."|".number_format(($dadoscesta["VL_PRODUTO_CESO"]*$dadoscesta["NR_QTDE_CESO"]),2,".","")."||0|0|0|||\r\n");
        }
        fwrite($handle,"M\r\n");
        fwrite($handle,"N\r\n");
        fwrite($handle,"N02|0|00|3|0|0|0\r\n");
        fwrite($handle,"Q\r\n");
        fwrite($handle,"Q04|06\r\n");
        fwrite($handle,"S\r\n");
        fwrite($handle,"S04|06\r\n");
        $x++;
    }
    
    fwrite($handle,"W\r\n");
    fwrite($handle,"W02|0|0|0|0|".number_format(($dados["VL_TOTAL_COSO"]-$dados["VL_FRETE_COSO"]),2,".","")."|".number_format($dados["VL_FRETE_COSO"],2,".","")."|0|0|0|0|0|0|0|".number_format($dados["VL_TOTAL_COSO"],2,".","")."\r\n");
    fwrite($handle,"X|0\r\n");
    fwrite($handle,"X03|CORREIOS||||\r\n");
    
    fclose($handle);
    
    $notas .= "<a href=\"$arq\">".$arq."</a><br />";
    
    $nfe++;
}

Header("Location: compras_nfe2.php?exibe=$notas");
exit();
?>
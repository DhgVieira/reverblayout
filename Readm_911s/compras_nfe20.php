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

$zip = new ZipArchive();
$zip_name = "nfe/geradas/nfe_".date("Y-m-d")."-".date("H:i:s").".zip";

if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE){
    $error .= "* Erro ao criar zip";
}

foreach ($compras as $idc) {
	$sql = "select * from compras, cadastros where NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and NR_SEQ_COMPRA_COSO = $idc";
	$st = mysql_query($sql);
    $dados = mysql_fetch_array($st);
	  
    $nome = strtoupper(RemoveAcentos(utf8_encode($dados["DS_NOME_CASO"])));
	$ende = strtoupper(RemoveAcentos(utf8_encode($dados["DS_ENDERECO_CASO"])));
    $numer = $dados["DS_NUMERO_CASO"];
	$bairro = strtoupper(RemoveAcentos(utf8_encode($dados["DS_BAIRRO_CASO"])));
	$complem = strtoupper(RemoveAcentos(utf8_encode($dados["DS_COMPLEMENTO_CASO"])));
	$estado = strtoupper(RemoveAcentos(utf8_encode($dados["DS_UF_CASO"])));
	$cida = $dados["DS_CIDADE_CASO"];
	$cep = $dados["DS_CEP_CASO"];
    $cpfcnpj = $dados["DS_CPFCNPJ_CASO"];
    $foneddd = $dados["DS_DDDFONE_CASO"];
    $fone = $dados["DS_FONE_CASO"];
    
    $sqlen = "select * from enderecos where NR_SEQ_COMPRA_ENRC = $idc";
    $sten = mysql_query($sqlen);
    $total_prods = 0;
    if (mysql_num_rows($sten) > 0) {
        $rowen = mysql_fetch_array($sten);
        $cpfnovo = $rowen["DS_CPF_ENRC"];
        if (strlen($cpfnovo) >= 11){
            $nome = strtoupper(RemoveAcentos(utf8_encode($rowen["DS_DESTINATARIO_ENRC"])));
        	$ende = strtoupper(RemoveAcentos(utf8_encode($rowen["DS_ENDERECO_ENRC"])));
            $numer = $rowen["DS_NUMERO_ENRC"];
        	$bairro = strtoupper(RemoveAcentos(utf8_encode($rowen["DS_BAIRRO_ENRC"])));
        	$complem = strtoupper(RemoveAcentos(utf8_encode($rowen["DS_COMPLEMENTO_ENRC"])));
        	$estado = strtoupper(RemoveAcentos(utf8_encode($rowen["DS_UF_ENRC"])));
        	$cida = $rowen["DS_CIDADE_ENRC"];
        	$cep = $rowen["DS_CEP_ENRC"];
            $cpfcnpj = $rowen["DS_CPF_ENRC"];
        }
    }

    if ($estado == "PR"){
        $coduf = 5101;
        $idDest = 1;
    }else{
        $coduf = 6101;
        $idDest = 2;
    }
    
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
    
    //date_default_timezone_set("UTC");
    date_default_timezone_set('America/Sao_Paulo');
    $dataat = date("Y-m-d\TH:i:s") . "-03:00";
    //$dataat = date("Y-m-d");
    $hora = date("H:i:s");
    
    $sqlIBGE = "select Municipio from DTB_05_05_2009n where DS_UF = '$estado' and (Municipio_Nome = '$cida' or Municipio_Nome = '".utf8_decode($cida)."')";
    $stibge = mysql_query($sqlIBGE);
    $dadosibge = mysql_fetch_array($stibge);
    
    $codibge = $dadosibge[0];
    
    $arq = 'nfe/geradas/nfe_'.$dataat.'_'.$nfe.'.txt';
    $handle = fopen($arq,"w+");

    $fd = fopen($file, 'r');
    stream_filter_append($fd, 'convert.iconv.UTF-8/OLD-ENCODING');
    stream_copy_to_stream($fd, fopen($output, 'w'));

//IE ST informada: verificar o DV da IE do Substituto Tributário informada.

    $ieEST = '';

    switch ($estado) {
        case 'SP':
            $ieEST = '816014030110';
            break;
        case 'DF':
            $ieEST = '0774742000174';
            break;
		case 'RJ':
            $ieEST = '92032523';
            break;
    }
    
    fwrite($handle,"NOTA FISCAL|1\r\n");
    fwrite($handle,"A|3.10|NFe|\r\n");
    fwrite($handle,"B|41||VENDA|$parcelas|55|1|$nfe|$dataat|$dataat|1|$idDest|4113700|1|1||1|1|1|2|||\r\n");
    fwrite($handle,"C|ANTONIO M DIAS CONFECCOES|REVERBCITY|9038567770|" . $ieEST . "|||1|\r\n");
    fwrite($handle,"C02|08345875000137\r\n");
    fwrite($handle,"C05|RUA IBIPORA|995||JARDIM AURORA|4113700|Londrina|PR|86060510|1058|BRASIL|433228852|\r\n");
    //indIEDest = 9=Não Contribuinte
    fwrite($handle,"E|$nome|9|||\r\n");
    if (strlen($cpfcnpj) > 11){
        fwrite($handle,"E02|$cpfcnpj\r\n");
    }else{
        fwrite($handle,"E03|$cpfcnpj\r\n");
    }
    fwrite($handle,"E05|$ende|$numer|$complem|$bairro|$codibge|".strtoupper(RemoveAcentos($cida))."|$estado|$cep|1058|BRASIL||\r\n");
    
    $sqlces = "select * from compras, cestas, produtos, produtos_tipo, produtos_categoria where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
            and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC and NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC 
            and NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC and NR_SEQ_COMPRA_COSO = $idc";
	$stces = mysql_query($sqlces);
    
    $sqlprodtot = "select SUM(NR_QTDE_CESO*VL_PRODUTO_CESO) from compras, cestas, produtos, produtos_tipo, produtos_categoria
                   where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC and
                   NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and NR_SEQ_CATEGORIA_PRRC = NR_SEQ_CATEGPRO_PCRC and
                   NR_SEQ_COMPRA_COSO = $idc";
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

    //UF ICMS para a UF de destino
    //AC-AP-AM-PA-RR                                        = 17% + 7% SEM FCP
    //AL-BA-CE-DF-ES-GO-MA-MT-MS-PB-PE-PI-RN-RO-SE-TO       = 17% + 7% + FCP
    //SC                                                    = 17% + 12% sem FCP
    //RS                                                    = 17% + 12% + FCP
    //MG-SP                                                 = 18% + 12% + FCP
    //RJ                                                    = 19% + 12% + FCP
//NA|vBCUFDest|pFCPUFDest|pICMSUFDest|pICMSInter|pICMSInterPart|vFCPUFDest|vICMSUFDest|vICMSUFRemet
//NA|44.84|2|18.00|12.00|40|0.90|1.08|1.61

    $arrUfsICMSDestino = array(
        'AC'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'AP'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'AM'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '',
            'pICMSUFDest' => '18.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'PA'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'RR'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'AL'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'BA'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'CE'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'DF'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '18.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0,
            'inscEstadual' => 0774742000174,
        ),
        'ES'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'GO'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'MA'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'MT'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'MS'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'PB'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '18.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'PE'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '18.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'PI'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'RN'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '18.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'RO'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'SE'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '18.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'TO'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '18.00',
            'pICMSInter' => '7.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'SC'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '',
            'pICMSUFDest' => '17.00',
            'pICMSInter' => '12.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'RS'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '18.00',
            'pICMSInter' => '12.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'MG'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '18.00',
            'pICMSInter' => '12.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0
        ),
        'SP'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '18.00',
            'pICMSInter' => '12.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0,
            'inscEstadual' => 816014030110,
        ),
        'RJ'=> array(//
            'vBCUFDest' => '',
            'pFCPUFDest' => '2',
            'pICMSUFDest' => '19.00',
            'pICMSInter' => '12.00',
            'pICMSInterPart' => '40',
            'vFCPUFDest' => 0,
            'vICMSUFDest' => 0,
            'vICMSUFRemet' => 0,
            'inscEstadual' => 92032523
        ),
//        'PR'=> array(
//            'vBCUFDest' => '',
//            'pFCPUFDest' => '',
//            'pICMSUFDest' => '19.00',
//            'pICMSInter' => '12.00',
//            'pICMSInterPart' => '40',
//            'vFCPUFDest' => 0,
//            'vICMSUFDest' => 0,
//            'vICMSUFRemet' => 0
//        ),
    );
    
    try{
        while($dadoscesta = mysql_fetch_array($stces)){
            $NCM = "";
            $NCM = strtoupper(RemoveAcentos($dadoscesta["DS_NCM_PTRC"]));
            
            if (!$NCM) $NCM = strtoupper(RemoveAcentos($dadoscesta["DS_NCM_PCRC"]));
            
            $ncmprod = strtoupper(RemoveAcentos($dadoscesta["DS_NCM_PRRC"]));

            if ($ncmprod) $NCM = $ncmprod;
            
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
                    $vlr_prod = ($descontoum)? $dadoscesta["VL_PRODUTO_CESO"] - $descontoum + $vlr_frete : $dadoscesta["VL_PRODUTO_CESO"] + $vlr_frete;
                    // I|cProd|cEAN|xProd|NCM|EXTIPI|CFOP|uCom|qCom|vUnCom|vProd|cEANTrib|uTrib|qTrib|vUnTrib|vFrete|vSeg|vDesc|vOutro|indTot|xPed|nItemPed|nFCI| 
                    fwrite($handle,"I|".$dadoscesta["NR_SEQ_PRODUTO_CESO"]."||".strtoupper(RemoveAcentos($dadoscesta["DS_PRODUTO2_PRRC"]))."|$NCM||{$coduf}|UN|".number_format($dadoscesta["NR_QTDE_CESO"],4,".","")."|".number_format($dadoscesta["VL_PRODUTO_CESO"],10,".","")."|".number_format($dadoscesta["VL_PRODUTO_CESO"],2,".","")."||UN|".number_format($dadoscesta["NR_QTDE_CESO"],4,".","")."|".number_format($dadoscesta["VL_PRODUTO_CESO"],2,".","")."|".$freteum."||".$descontoum."||1|\r\n");
                    $val_desc = true;
                //}
            }else{
                fwrite($handle,"I|".$dadoscesta["NR_SEQ_PRODUTO_CESO"]."||".strtoupper(RemoveAcentos($dadoscesta["DS_PRODUTO2_PRRC"]))."|$NCM||{$coduf}|UN|".number_format($dadoscesta["NR_QTDE_CESO"],4,".","")."|".number_format($dadoscesta["VL_PRODUTO_CESO"],10,".","")."|".number_format(($dadoscesta["VL_PRODUTO_CESO"]*$dadoscesta["NR_QTDE_CESO"]),2,".","")."||UN|".number_format($dadoscesta["NR_QTDE_CESO"],4,".","")."|".number_format($dadoscesta["VL_PRODUTO_CESO"],10,".","")."|||||1|\r\n");
            }
            fwrite($handle,"M|\r\n");
            fwrite($handle,"N|\r\n");
            //fwrite($handle,"N10c|0|101|500|0|0\r\n");
            fwrite($handle,"N10d|0|102|500|0|0\r\n");
            fwrite($handle,"Q|\r\n");
            fwrite($handle,"Q04|06\r\n");
            fwrite($handle,"S|\r\n");
            fwrite($handle,"S04|06\r\n");
            //NA|vBCUFDest|pFCPUFDest|pICMSUFDest|pICMSInter|pICMSInterPart|vFCPUFDest|vICMSUFDest|vICMSUFRemet
            //NA|44.84|2|18.00|12.00|40|0.90|1.08|1.61
            if (array_key_exists($estado, $arrUfsICMSDestino)) {

                if(!empty($vlr_prod)) {
                    $vlProduto = $vlr_prod;
                    unset($vlr_prod);
                } else {
                    $vlProduto = number_format(($dadoscesta["VL_PRODUTO_CESO"]),2,".","");
                }

                $pFCPUFDest = $arrUfsICMSDestino[$estado]['pFCPUFDest'];
                $pICMSUFDest = $arrUfsICMSDestino[$estado]['pICMSUFDest'];
                $pICMSInter = $arrUfsICMSDestino[$estado]['pICMSInter'];
                $pICMSInterPart = $arrUfsICMSDestino[$estado]['pICMSInterPart'];

                $valBaseAlInt = ($pICMSInter / 100) * $vlProduto;
                $vlrBaseAlDest = ($pICMSUFDest / 100) * $vlProduto;

                $vlrDeducao = $vlrBaseAlDest - $valBaseAlInt;

                $vlrIcmRemetente = (60 / 100) * $vlrDeducao;
                $vlrIcmDest = (40 / 100) * $vlrDeducao;
                $vlrFCP = ($pFCPUFDest / 100) * $vlProduto;

                $vlrIcmRemetente    = (empty($vlrIcmRemetente))? "0.00" : number_format($vlrIcmRemetente,2,".","");
                $vlrIcmDest         = (empty($vlrIcmDest))? "0.00" : number_format($vlrIcmDest,2,".","");
                $vlrFCP             = (empty($vlrFCP))? "0.00" : number_format($vlrFCP,2,".","");
                $pFCPUFDest         = (empty($pFCPUFDest))? "0.00" : number_format($pFCPUFDest,2,".","");

                fwrite($handle,"NA|" . number_format($vlProduto,2,".","") . "|" . $pFCPUFDest . "|" . $pICMSUFDest . "|" . $pICMSInter . "|" . $pICMSInterPart . "|" . $vlrFCP . "|" . $vlrIcmDest . "|" . $vlrIcmRemetente . "\r\n");

            }
            $x++;
        }

        fwrite($handle,"W|\r\n");
        fwrite($handle,"W02|0.00|0.00|0.00|0.00|".number_format(($dados["VL_TOTAL_COSO"]-$dados["VL_FRETE_COSO"]),2,".","")."|".number_format($dados["VL_FRETE_COSO"],2,".","")."|0.00|0.00|0.00|0.00|0.00|0.00|0.00|".number_format($dados["VL_TOTAL_COSO"],2,".","")."\r\n");
        fwrite($handle,"X|0|\r\n");
        fwrite($handle,"X03|CORREIOS||||\r\n");
        
        fclose($handle);
        
        $zip->addFile($arq);
        
        $notas .= "<a href=\"$arq\">".$arq."</a><br />";
        
        $nfe++;
    }catch( Exception $e){
        die($e->getMessage());
    }
}
try{
    $zip->close();

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    header('Content-type: application/zip');
    header('Content-Disposition: attachment; filename="'.$zip_name.'"');
    readfile($zip_name);

    unlink($zip_name);
}catch(Exception $e){
    die($e->getMessage());
}
    //Header("Location: compras_nfe2.php?exibe=$notas");
exit();
?>
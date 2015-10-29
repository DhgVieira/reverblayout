<?php
include 'auth.php';
include 'lib.php';

$dados = request("cestaitens");

$subtotal   = TrataValor(request("subtotal"));
$desconto   = TrataValor(request("desconto"));
$frete      = TrataValor(request("frete"));
$total      = TrataValor(request("total"));
$forma      = TrataInt(request("forma"));
$vlrpago    = TrataValor(request("vlrpago"));
$troco      = TrataValor(request("troco"));
$tipovisa   = TrataInt(request("tipovisa"));
$tipomaster = TrataInt(request("tipomaster"));
$nrbanco    = TrataStr(request("nrbanco"));
$nragencia  = TrataStr(request("nragencia"));
$contacorr  = TrataStr(request("contacorr"));
$tipocheque = TrataStr(request("tipocheque"));
$cheque1    = TrataStr(request("cheque1"));
$cheque2    = TrataStr(request("cheque2"));
$cheque3    = TrataStr(request("cheque3"));
$vlrcheq1   = TrataValor(request("vlrcheq1"));
$vlrcheq2   = TrataValor(request("vlrcheq2"));
$vlrcheq3   = TrataValor(request("vlrcheq3"));
$data1      = request("data1");
$data2      = request("data2");
$data3      = request("data3");
$docto      = TrataStr(request("docto"));
$email      = TrataStr(request("email"));
$nome       = TrataStr(request("nome"));
$endereco   = TrataStr(request("endereco"));
$numero     = TrataStr(request("numero"));
$complem    = TrataStr(request("complem"));
$bairro     = TrataStr(request("bairro"));
$cidade     = TrataStr(request("cidade"));
$estado     = TrataStr(request("estado"));
$cep        = TrataStr(request("cep"));
$sexo       = request("sexo");

$ddd        = TrataStr(request("ddd"));
$fone       = TrataStr(request("fone"));
$twitter    = TrataStr(request("twitter"));

$twitter = str_replace("http://www.twitter.com/","",$twitter);
$twitter = str_replace("http://twitter.com/","",$twitter);
$twitter = str_replace("https://www.twitter.com/","",$twitter);
$twitter = str_replace("https://twitter.com/","",$twitter);
$twitter = str_replace("http://www;twitter.com/","",$twitter);
$twitter = str_replace("http://www;twitter;com/","",$twitter);
$twitter = str_replace("http://www.twitter;com/","",$twitter);
$twitter = str_replace("www.twitter.com/","",$twitter);
$twitter = str_replace("twitter.com/","",$twitter);
$twitter = str_replace("twitter/","",$twitter);
$twitter = str_replace("-","",$twitter);
$twitter = str_replace("@","",$twitter);
$twitter = str_replace("https","",$twitter);
$twitter = str_replace("http","",$twitter);
$twitter = str_replace(":","",$twitter);
$twitter = trim(str_replace("/","",$twitter));

$idcli      = request("idcli");

$vendedor   = request("vendedor");

if (!$data1){
	$data1 = "null";
}else{
    $data1 = "'".FormataDataMysql($data1)."'";
}
if (!$data2){
	$data2 = "null";
}else{
    $data2 = "'".FormataDataMysql($data2)."'";
}
if (!$data3){
	$data3 = "null";
}else{
    $data3 = "'".FormataDataMysql($data3)."'";
}

if (!$frete) $frete = 0;

$dados = substr($dados,0,strlen($dados)-1);

if (!$idcli){
    if (!$email || $email=="''" || $email=="null"){
        $idcli = 9701;
    }else{
        if (strlen(request("nome")) > 15) {
            $login = substr(request("nome"),0,15);
        }else{
            $login = request("nome");
        }
        
		$CaracteresAceitos = '0123456789';
		$max = strlen($CaracteresAceitos)-1;
		$password = "";
		for($i=0; $i < 6; $i++) {
		   $password .= $CaracteresAceitos{mt_rand(0, $max)};
		}
        
        $cep = str_replace(".","",$cep);
        $cep = str_replace("-","",$cep);
        $cep = str_replace("/","",$cep);
        $cep = str_replace(" ","",$cep);

        $docto = str_replace(".","",$docto);
        $docto = str_replace("-","",$docto);
        $docto = str_replace("/","",$docto);
        $docto = str_replace(" ","",$docto);
        
        $str = "INSERT INTO cadastros (
                DS_LOGIN_CASO,
                DS_SENHA_CASO,
                DS_NOME_CASO,
                DS_ENDERECO_CASO,
                DS_NUMERO_CASO,
                DS_COMPLEMENTO_CASO,
                DS_BAIRRO_CASO,
                DS_CIDADE_CASO,
                DS_UF_CASO,
                DS_CEP_CASO,
                DS_EMAIL_CASO,
                DS_CPFCNPJ_CASO,
                DS_SEXO_CACH,
                DS_DDDFONE_CASO,
                DS_FONE_CASO,
                DS_TWITTER_CACH,
                DT_CADASTRO_CASO, NR_NIVELSEG_CASO, ST_ENVIO_CASO, DS_OBS_CACH, ST_CADASTRO_CASO, NR_SEQ_LOJA_CASO)
			    VALUES (
                '$login',
                '$password',
                $nome,
                $endereco,
                $numero,
                $complem,
                $bairro,
                $cidade,
                $estado,
                $cep,
                $email,
                $docto,
                '$sexo',
                $ddd,
                $fone,
                $twitter,
                sysdate(), 0, 'S', 'Cadastro Loja', 'A', $SS_loja)";
        $st = mysql_query($str);
        $idcli = mysql_insert_id();
        GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Novo vadastro Venda Loja - Cliente $idcli - $nome");
    }
}else{
        $cep = str_replace(".","",$cep);
        $cep = str_replace("-","",$cep);
        $cep = str_replace("/","",$cep);
        $cep = str_replace(" ","",$cep);

        $docto = str_replace(".","",$docto);
        $docto = str_replace("-","",$docto);
        $docto = str_replace("/","",$docto);
        $docto = str_replace(" ","",$docto);
        
        $str = "UPDATE cadastros SET
                DS_NOME_CASO = $nome,
                DS_ENDERECO_CASO = $endereco,
                DS_NUMERO_CASO = $numero,
                DS_COMPLEMENTO_CASO =  $complem,
                DS_BAIRRO_CASO = $bairro,
                DS_CIDADE_CASO = $cidade,
                DS_UF_CASO = $estado,
                DS_CEP_CASO = $cep,
                DS_EMAIL_CASO = $email,
                DS_CPFCNPJ_CASO = $docto,
                DS_SEXO_CACH = '$sexo',
                DS_DDDFONE_CASO = $ddd,
                DS_FONE_CASO = $fone,
                DS_TWITTER_CACH = $twitter
                where NR_SEQ_CADASTRO_CASO = $idcli";
        // $st = mysql_query($str);
        
        //GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Venda Loja - Atualizou cadastro $idcli - $nome");
}

$splitcesta = explode("|", $dados);

foreach ($splitcesta as $cesta){
    $itens = explode(";", $cesta);
    $idprod = $itens[0];
    $qtprod = $itens[3];
    $tmprod = $itens[4];
        
    $sql2 = "SELECT NR_SEQ_ESTOQUE_ESRC, NR_QTDE_ESRC FROM estoque WHERE NR_SEQ_PRODUTO_ESRC = ".$idprod." AND
            NR_SEQ_TAMANHO_ESRC = ".$tmprod;
	$st2 = mysql_query($sql2); 
	if (mysql_num_rows($st2) > 0) {
		$row2 = mysql_fetch_row($st2);
		$nrseqest = $row2[0];
		$to_est = $row2[1];
        
        $to_est = $to_est - $qtprod;
        
        if ($to_est < 0){
            $dsproduto = PegaNomeProduto($idprod);
            ?>
    		<script language="JavaScript">
    		   alert('O produto: <?php echo $dsproduto ?> nao possui <?php echo $qtprod ?> unidades no estoque');
    		   top.window.location.href=('pedidos.php');
    		</script>
    		<?php
    		exit();
        }
    }else{
        $dsproduto = PegaNomeProduto($idprod);
        ?>
		<script language="JavaScript">
		   alert('Nao existe mais estoque cadastrado para o produto: <?php echo $dsproduto ?>');
		   top.window.location.href=('pedidos.php');
		</script>
		<?php
		exit();
    }
}
$nr_parc_aut = 0;

if ($forma == "1") {
    $formapg = "dinheiro";
}else if ($forma == "2") {
    $formapg = "visa";
    $nr_parc_aut = $tipovisa;
    if ($nr_parc_aut == 0){
        $formapg = "debitovisa";
        $nr_parc_aut = 0;
    }
}else if ($forma == "3") {
    $formapg = "mastercard";
    $nr_parc_aut = $tipomaster;
    if ($nr_parc_aut == 0){
        $formapg = "debitomaster";
        $nr_parc_aut = 0;
    }
}else if ($forma == "4") {
    $formapg = "cheque";
    $nr_parc_aut = $tipocheque;
}else if ($forma == "5") {
    $formapg = "transf.SP";
    $nr_parc_aut = 0;
}else if ($forma == "6") {
    $formapg = "publicidade";
    $nr_parc_aut = 0;
}else if ($forma == "7") {
    $formapg = "diners";
    $nr_parc_aut = $tipodiners;
}else if ($forma == "8") {
    $formapg = "amex";
    $nr_parc_aut = $tipoamex;
}

$valorcusto = TrataValor(CalculaCusto($total,$formapg,$nr_parc_aut,1));

$str = "INSERT INTO compras (
        NR_SEQ_CADASTRO_COSO, 
        DT_COMPRA_COSO, 
        ST_COMPRA_COSO, 
        VL_TOTAL_COSO, 
        DS_FORMAPGTO_COSO, 
        VL_FRETE_COSO, 
        NR_PARCELAS_COSO,
        VL_FRETECUSTO_COSO,
        VL_CUSTOPGTO_COSO,
        DT_PAGAMENTO_COSO,
        VL_DESCONTO_COSO,
        VL_PAGO_COSO,
        VL_TROCO_COSO,
        DS_NRBANCO_COSO,
        DS_AGENCIA_COSO,
        DS_CONTACORR_COSO,
        DS_CHEQUE1_COSO,
        DS_CHEQUE2_COSO,
        DS_CHEQUE3_COSO,
        VL_CHEQUE1_COSO,
        VL_CHEQUE2_COSO,
        VL_CHEQUE3_COSO,
        DT_CHEQUE1_COSO,
        DT_CHEQUE2_COSO,
        DT_CHEQUE3_COSO,
        DT_STATUS_COSO,
        NR_SEQ_LOJA_COSO,
        NR_SEQ_VENDEDOR_COSO
        ) VALUES (
        $idcli, 
        sysdate(), 
        'E', 
        ".str_replace(",",".",$total).", 
        '$formapg', 
        ".str_replace(",",".",$frete).",  
        $nr_parc_aut, 
        0,
        $valorcusto,
        sysdate(), 
        $desconto,
        $vlrpago,
        $troco,
        $nrbanco,
        $nragencia,
        $contacorr,
        $cheque1,
        $cheque2,
        $cheque3,
        $vlrcheq1,
        $vlrcheq2,
        $vlrcheq3,
        $data1,
        $data2,
        $data3,
        sysdate(),
        $SS_loja,
        $vendedor)";
$st = mysql_query($str);
$nr_pedido = mysql_insert_id();

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Venda Loja $nr_pedido");

//if ($idcli != 9701){
//	$pontos = number_format($total*4/100,0,".","");
//	$strpt = "INSERT INTO pontos (NR_SEQ_CADASTRO_PORC, NR_SEQ_REFERENCIA_PORC, NR_SEQ_COMPRA_PORC, NR_QTDE_PORC, DT_INCLUSAO_PORC, ST_PONTOS_PORC)
//			VALUES ($idcli, 1, $nr_pedido, $pontos, sysdate(), 'E')";
//	$st = mysql_query($strpt);
//}

foreach ($splitcesta as $cesta){
    $itens = explode(";",$cesta);
    $idprod = $itens[0];
    $exprod = $itens[1];
    $vlprod = $itens[2];
    $qtprod = $itens[3];
    $tmprod = $itens[4];
    
    $str4 = "UPDATE estoque SET NR_QTDE_ESRC = NR_QTDE_ESRC - ".$qtprod." WHERE NR_SEQ_PRODUTO_ESRC = ".$idprod." AND
            NR_SEQ_TAMANHO_ESRC = ".$tmprod;
    $st4 = mysql_query($str4);
    
    //verifica se eh transf para SP
    if ($forma == "5") {
        //captura os dados de cada produto
        $sqlprod = "select DS_PRODUTO2_PRRC, NR_SEQ_TIPO_PRRC, NR_SEQ_CATEGORIA_PRRC, DS_REFERENCIA_PRRC from produtos WHERE NR_SEQ_PRODUTO_PRRC = $idprod";
        $stprod = mysql_query($sqlprod);

    	if (mysql_num_rows($stprod) > 0) {
    		$retprod = mysql_fetch_row($stprod);
            $prod_nome = $retprod[0];
            $prod_tipo = $retprod[1];
            $prod_cate = $retprod[2];
            $prod_refe = $retprod[3];
        }
        
        //consulta para ver se o produto existe em SP
        $sqlprod = "select NR_SEQ_PRODUTO_PRRC from produtos WHERE
                    DS_PRODUTO2_PRRC = '$prod_nome' and
                    NR_SEQ_TIPO_PRRC = $prod_tipo and
                    NR_SEQ_CATEGORIA_PRRC = $prod_cate and 
                    DS_REFERENCIA_PRRC = '$prod_refe' and
                    NR_SEQ_LOJAS_PRRC = 2";
        
        $stprod = mysql_query($sqlprod);
    	if (mysql_num_rows($stprod) > 0) {
    	    //caso exista, pega o codigo
    		$retprod = mysql_fetch_row($stprod);
            $prod_codigo = $retprod[0];
            
            //consulta o estoque para ver se já existe do mesmo tamanho
            $sqlest = "select NR_SEQ_PRODUTO_ESRC from estoque WHERE NR_SEQ_PRODUTO_ESRC = $prod_codigo and NR_SEQ_TAMANHO_ESRC = $tmprod";
            $stesto = mysql_query($sqlest);
        	if (mysql_num_rows($stesto) > 0) {
        	    //caso exista no estoque, apenas aumenta a quantidade
    	        $str4 = "UPDATE estoque SET NR_QTDE_ESRC = NR_QTDE_ESRC + ".$qtprod." WHERE NR_SEQ_PRODUTO_ESRC = ".$prod_codigo." AND
                        NR_SEQ_TAMANHO_ESRC = ".$tmprod;
                $st4 = mysql_query($str4);
                GravaLogEstoque($SS_logadm,$prod_codigo,$tmprod,"Adicionou $qtprod","Transf. Londrina($nr_pedido)",$qtprod);
            }else{
                //caso nao exista, insere uma nova quantidade no estoque
                $str4 = "INSERT INTO estoque (NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) values
                         ($prod_codigo, $tmprod, $qtprod)";
                $st4 = mysql_query($str4);
                GravaLogEstoque($SS_logadm,$prod_codigo,$tmprod,"Adicionou $qtprod","Transf. Londrina($nr_pedido)",$qtprod);
            }
        }else{
            //caso não exista, duplica o produto para SP
            
            $sqldupl = "select * from produtos, estoque WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC
                     AND NR_SEQ_PRODUTO_PRRC = $idprod";
            $stdup = mysql_query($sqldupl);
            if (mysql_num_rows($stdup) > 0) {
                $rowdup = mysql_fetch_array($stdup);
                $strdup = "INSERT INTO produtos (
                        NR_SEQ_LOJAS_PRRC,
                        NR_SEQ_TIPO_PRRC,
                        NR_SEQ_CATEGORIA_PRRC,
                        NR_SEQ_ESTILO_PRRC,
                        NR_SEQ_MUSICA_PRRC,
                        DS_REFERENCIA_PRRC,
                        DS_PRODUTO2_PRRC,
                        VL_PRODUTO_PRRC,
                        DT_CADASTRO_PRRC,
                        NR_VISITAS_PRRC,
                        NR_PESOGRAMAS_PRRC,
                        DS_GARANTIA_PRRC,
                        DS_EXT_PRRC,
                        DS_EXTTAM_PRRC,
                        DS_CLASSIC_PRRC,
                        DS_INFORMACOES_PRRC,
                        TP_DESTAQUE_PRRC,
                        DS_FRETEGRATIS_PRRC,
                        VL_PROMO_PRRC,
                        ST_PRODUTOS_PRRC,
                        DT_CRIACAO_PRRC,
                        DS_IMMEM_PRRC,
                        VL_PRODUTO2_PRRC) values (
                        2,
                        ".formataCampo($rowdup["NR_SEQ_TIPO_PRRC"]).",
                        ".formataCampo($rowdup["NR_SEQ_CATEGORIA_PRRC"]).",
                        ".formataCampo($rowdup["NR_SEQ_ESTILO_PRRC"]).",
                        ".formataCampo($rowdup["NR_SEQ_MUSICA_PRRC"]).",
                        '".$rowdup["DS_REFERENCIA_PRRC"]."',
                        '".$rowdup["DS_PRODUTO2_PRRC"]."',
                        ".formataCampo($rowdup["VL_PRODUTO_PRRC"]).",
                        '".$rowdup["DT_CADASTRO_PRRC"]."',
                        ".formataCampo($rowdup["NR_VISITAS_PRRC"]).",
                        ".formataCampo($rowdup["NR_PESOGRAMAS_PRRC"]).",
                        '".$rowdup["DS_GARANTIA_PRRC"]."',
                        '".$rowdup["DS_EXT_PRRC"]."',
                        '".$rowdup["DS_EXTTAM_PRRC"]."',
                        '".$rowdup["DS_CLASSIC_PRRC"]."',
                        '".$rowdup["DS_INFORMACOES_PRRC"]."',
                        ".formataCampo($rowdup["TP_DESTAQUE_PRRC"]).",
                        '".$rowdup["DS_FRETEGRATIS_PRRC"]."',
                        ".formataCampo($rowdup["VL_PROMO_PRRC"]).",
                        'A',
                        '".$rowdup["DT_CRIACAO_PRRC"]."',
                        '".$rowdup["DS_IMMEM_PRRC"]."',
                        ".formataCampo($rowdup["VL_PRODUTO2_PRRC"]).")";
                $stdupp = mysql_query($strdup);
                $iddupp = mysql_insert_id();
                
                $str4 = "INSERT INTO estoque (NR_SEQ_PRODUTO_ESRC, NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC) values
                         ($iddupp, $tmprod, $qtprod)";
                $st4 = mysql_query($str4);
                GravaLogEstoque($SS_logadm,$iddupp,$tmprod,"Adicionou $qtprod","Transf. Londrina($nr_pedido)",$qtprod);
                
                $newfile1 = $iddupp.".".$rowdup["DS_EXT_PRRC"];
                $newfile2 = $iddupp."p.".$rowdup["DS_EXT_PRRC"];
                
                $file1 = $rowdup["NR_SEQ_PRODUTO_PRRC"].".".$rowdup["DS_EXT_PRRC"];
                $file2 = $rowdup["NR_SEQ_PRODUTO_PRRC"]."p.".$rowdup["DS_EXT_PRRC"];
                if (file_exists("../arquivos/uploads/produtos/".$file1)) copy("../arquivos/uploads/produtos/".$file1, "../arquivos/uploads/produtos/".$newfile1);
                if (file_exists("../arquivos/uploads/produtos/".$file2)) copy("../arquivos/uploads/produtos/".$file2, "../arquivos/uploads/produtos/".$newfile2);
                
                $sql3 = "SELECT NR_SEQ_FOTO_FORC, DS_EXT_FORC, DS_LEGENDA_FORC, ZOOM_FORC FROM fotos WHERE NR_SEQ_PRODUTO_FORC = ".$rowdup["NR_SEQ_PRODUTO_PRRC"]." order by NR_ORDEM_FORC, NR_SEQ_FOTO_FORC";
                $st3 = mysql_query($sql3);
                if (mysql_num_rows($st3) > 0) {
                	while($row3 = mysql_fetch_array($st3)) {
                		$str2ft = "INSERT INTO fotos (NR_SEQ_PRODUTO_FORC, DS_EXT_FORC, DS_LEGENDA_FORC, NR_ORDEM_FORC, ZOOM_FORC)
                                VALUES (
                                ".$iddupp.",
                                '".$row3["DS_EXT_FORC"]."',
                                '".$row3["DS_LEGENDA_FORC"]."',
                                ".formataCampo($row3["NR_ORDEM_FORC"]).",
                                ".formataCampo($row3["ZOOM_FORC"]).")";
                        $st4 = mysql_query($str2ft);
                        $idfoto = mysql_insert_id();
                         
                        $file1 = $row3["NR_SEQ_FOTO_FORC"].".".$row3["DS_EXT_FORC"];
                        $file2 = $row3["NR_SEQ_FOTO_FORC"]."g.".$row3["DS_EXT_FORC"];
                        $file3 = $row3["NR_SEQ_FOTO_FORC"]."p.".$row3["DS_EXT_FORC"];
                        
                        $newfile1 = $idfoto.".".$row3["DS_EXT_FORC"];
                        $newfile2 = $idfoto."g.".$row3["DS_EXT_FORC"];
                        $newfile3 = $idfoto."p.".$row3["DS_EXT_FORC"];
                                    
                        if (file_exists("../arquivos/uploads/fotosprodutos/".$file1)) copy("../arquivos/uploads/fotosprodutos/".$file1, "../arquivos/uploads/fotosprodutos/".$newfile1);
                        if (file_exists("../arquivos/uploads/fotosprodutos/".$file2)) copy("../arquivos/uploads/fotosprodutos/".$file2, "../arquivos/uploads/fotosprodutos/".$newfile2);
                        if (file_exists("../arquivos/uploads/fotosprodutos/".$file3)) copy("../arquivos/uploads/fotosprodutos/".$file3, "../arquivos/uploads/fotosprodutos/".$newfile3);
                   }
                }
            }

            
        }
    }
    
    GravaLogEstoque($SS_logadm,$idprod,$tmprod,"Removeu $qtprod","Venda Nr $nr_pedido",$qtprod*-1);
    
    $str = "INSERT INTO cestas (NR_SEQ_CADASTRO_CESO, NR_SEQ_COMPRA_CESO, NR_SEQ_PRODUTO_CESO, NR_SEQ_TAMANHO_CESO, NR_QTDE_CESO, VL_PRODUTO_CESO, DT_INCLUSAO_CESO)
    	   VALUES ($idcli, $nr_pedido, ".$idprod.", $tmprod, ".$qtprod.", ".str_replace(",",".",$vlprod).", sysdate())";
    $st = mysql_query($str);
}

if ($SS_loja == 1){
    Header("Location: pedidos_conf.php?idp=$nr_pedido");
    exit();
}else if ($SS_loja == 2){
    Header("Location: compras_newsp.php?idc=$nr_pedido");
    exit();   
}

function PegaNomeProduto($produto){
	$sqlmin = "SELECT DS_PRODUTO2_PRRC FROM produtos WHERE NR_SEQ_PRODUTO_PRRC = $produto";
	$stmin = mysql_query($sqlmin);
	$retnome = "";
	if (mysql_num_rows($stmin) > 0) {
		$rowmin = mysql_fetch_row($stmin);
		$retnome = $rowmin[0];
	}
	return $retnome;
}

mysql_close($con);

function TrataStr($texto1){
    if (!$texto1){
    	$texto1 = "null";
    }else{
        $texto1 = "'".$texto1."'";
    }
    return $texto1;
}
function TrataInt($texto2){
    if (!$texto2){
    	$texto2 = "null";
    }else{
        $texto2 = $texto2;
    }
    return $texto2;
}
function TrataValor($vlrr){
    if (!$vlrr){
    	$vlrr = "null";
    }else{
        $vlrr = str_replace(",",".",$vlrr);
    }
    return $vlrr;
}

function formataCampo($campo){
    $retorno = "null";
    if (!$campo){
        $retorno = "null";
    }else{
        $retorno = $campo;
    }
    return $retorno;
}
?>
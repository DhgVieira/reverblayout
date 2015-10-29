<?php
include 'auth.php';
include 'lib.php';

$dados = request("cestaitens");

$vencimento = request("vencimento");

if (!$vencimento){
    $vencimento = "null";
}else{
    $datebr = explode("/",$vencimento);
    $vencimento = $datebr[2]."-".$datebr[1]."-".$datebr[0];
    $vencimento = "'".$vencimento."'";
}

$total      = TrataValor(request("total"));
$forma      = "boleto";
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
        GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Novo vadastro Pedido Avulso - Cliente $idcli - $nome");
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

$nr_parc_aut = 0;
$formapg = "boleto";

$valorcusto = TrataValor(CalculaCusto($total,$formapg,$nr_parc_aut,1));

$str = "INSERT INTO compras (
        NR_SEQ_CADASTRO_COSO, 
        DT_COMPRA_COSO, 
        ST_COMPRA_COSO, 
        VL_TOTAL_COSO, 
        DS_FORMAPGTO_COSO, 
        VL_FRETE_COSO, 
        NR_PARCELAS_COSO,
        VL_CUSTOPGTO_COSO,
        DT_STATUS_COSO,
        NR_SEQ_LOJA_COSO,
        NR_SEQ_VENDEDOR_COSO,
        DT_VCTOBOLETO_COSO
        ) VALUES (
        $idcli, 
        sysdate(), 
        'A', 
        ".str_replace(",",".",$total).", 
        '$formapg', 
        0, 
        $nr_parc_aut, 
        $valorcusto,
        sysdate(),
        $SS_loja,
        $vendedor,
        $vencimento)";
$st = mysql_query($str);
$nr_pedido = mysql_insert_id();

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Venda avulsa $nr_pedido");

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
        
    $str = "INSERT INTO cestas (NR_SEQ_CADASTRO_CESO, NR_SEQ_COMPRA_CESO, NR_SEQ_PRODUTO_CESO, NR_SEQ_TAMANHO_CESO, NR_QTDE_CESO, VL_PRODUTO_CESO, DT_INCLUSAO_CESO)
    	   VALUES ($idcli, $nr_pedido, ".$idprod.", 11, ".$qtprod.", ".str_replace(",",".",$vlprod).", sysdate())";
    $st = mysql_query($str);
}

Header("Location: pedidos_boleto3.php?idc=$nr_pedido");
exit();

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
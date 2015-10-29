<?php
if (!isset( $_SESSION )) { 
   	session_start(); 
}
$pagatual = "shop_carrinho.php";
$tit_debug = "";
$SS_logado = (isset($_SESSION["SS_logado"])) ? $_SESSION["SS_logado"] : "";
$SS_xx1 = (isset($_SESSION["8792hgaq3"])) ? $_SESSION["8792hgaq3"] : 0;
$SS_parceiro = (isset($_SESSION["SS_parceiro"])) ? $_SESSION["SS_parceiro"] : "";
$SS_twnome = (isset($_SESSION["hude78wsxa3a"])) ? $_SESSION["hude78wsxa3a"] : "";
$xcab = (isset($_SESSION["huvcbw892b"])) ? $_SESSION["huvcbw892b"] : "";
$SS_aniver = (isset($_SESSION["uoc8321ndniv"])) ? $_SESSION["uoc8321ndniv"] : "";

if (!$SS_xx1) $SS_xx1 = 0;

$SS_posicao = session_id();
$SS_nomepg = "shop";

include '../adm/lib.php';

$atc = request("atc");

if ($atc == "S"){
    $continuac = "lojista.php";
}else{
    $continuac = "produtos2_all.php";
}

if ($xcab == 1){
    $continuac = "lojista.php";
}

$SS_cesta = @$HTTP_COOKIE_VARS["rcityrwixav"];
$frete = @$HTTP_COOKIE_VARS["fhferedtexs"];
$freteok = true;
if (!$frete) {
	$frete = 0;
	$freteok = false;
}else{
	$frete = str_replace(",",".",$frete);
}

if($SS_logado){
    //faço a query para trazer todos os dados do usuário cadastrado para verificar se aplicamos 10% de desconto
    $sql_user = "SELECT
                    DS_NOME_CASO,
                    DS_SEXO_CACH,
                    DT_NASCIMENTO_CASO,
                    DS_CPFCNPJ_CASO,
                    DS_ENDERECO_CASO,
                    DS_NUMERO_CASO,
                    DS_COMPLEMENTO_CASO,
                    DS_BAIRRO_CASO,
                    DS_CEP_CASO,
                    DS_UF_CASO,
                    DS_CIDADE_CASO,
                    DS_PAIS_CACH,
                    DS_DDDCOM_CASO,
                    DS_FONECOM_CASO,
                    DS_DDDFONE_CASO,
                    DS_FONE_CASO,
                    DS_DDDCEL_CASO,
                    DS_CELULAR_CASO,
                    DS_OPERADORA_CACH,
                    DS_OCUPACAO_CACH,
                    DS_IMS_CACH,
                    DS_PLAYLIST_CACH,
                    DS_IMEEM_CACH,
                    DS_FAZENDO_CACH,
                    DS_ORKUT_CACH,
                    DS_TWITTER_CACH,
                    DS_FACEBOOK_CACH,
                    DS_INSTAGRAM_CASO,
                    DT_CADASTROCOMPLETO_CASO,
                    DS_COMPROUPROMO_CASO
                FROM
                    cadastros
                WHERE
                NR_SEQ_CADASTRO_CASO = $SS_logado";
             

     $st_user = mysql_query($sql_user);

        if (mysql_num_rows($st_user) > 0) {
            $row = mysql_fetch_row($st_user);

            $nome             = $row[0];
            $sexo             = $row[1];
            $data_nascimento  = $row[2];
            $cpf              = $row[3];
            $endereco         = $row[4];
            $numero           = $row[5];
            $complemento      = $row[6];
            $bairro           = $row[7];
            $cep              = $row[8];
            $uf               = $row[9];
            $cidade           = $row[10];
            $pais             = $row[11];
            $dddcom           = $row[12];
            $fonecom          = $row[13];
            $dddfone          = $row[14];
            $fone             = $row[15];
            $dddcel           = $row[16];
            $celular          = $row[17];
            $operadora        = $row[18];
            $ocupacao         = $row[19];
            $ims              = $row[20];
            $playlist         = $row[21];
            $imeem            = $row[22];
            $fazendo          = $row[23];
            $orkut            = $row[24];
            $twitter          = $row[25];
            $facebook         = $row[26];
            $instagram        = $row[27];
            $data_completo    = $row[28];
            $comproupromo     = $row[29];
        }
}





if ($xcab != 1){
    $sql = "select ST_FRETEGRATIS_GESA, VL_FRETEGRATIS_GESA from config_gerais where NR_SEQ_CONFIG_GESA = 1";
    $st = mysql_query($sql); 
    if (mysql_num_rows($st) > 0) {
    	$row = mysql_fetch_row($st);
    	$stfreteg  = $row[0];
    	$vlfreteg  = $row[1];
    }
}

$bannerlondrina = false;

$mostrabanesp = false;
if ($SS_logado){
    $sqltipo = "SELECT TP_CADASTRO_CACH, DS_CIDADE_CASO from cadastros where NR_SEQ_CADASTRO_CASO = $SS_logado";
    $sttipo = mysql_query($sqltipo); 
    if (mysql_num_rows($sttipo) > 0) {
        $rowtipo = mysql_fetch_row($sttipo);
        $xcab = $rowtipo[0];
        $cidade = $rowtipo[1];
        $_SESSION["huvcbw892b"] = $xcab;
        if ($cidade == 'londrina' || $cidade == 'Londrina' || $cidade == 'LONDRINA' || $cidade == 'LOndrina'){
            $bannerlondrina = true;   
        }
	}
}
$pr1 = (isset($_SESSION["2cfl2hda2"])) ? $_SESSION["2cfl2hda2"] : 0;
if (!$pr1) $pr1 = 0;
$checaprod = false;

$arraycesta = explode(';', $SS_cesta);
$i = 0;
$vl_geral = 0;
$ct_total = 0;
$pesotot = 0;
$sohvale = true;
$itens = "";
$temgratis = false;
$str_cesta = "";
$sohbuttons = true;
$umnapromo = false;
$sohposters = true;
$totalforadepromo = 0;
$xxb = 0;
$xxc = 0;
$cadastro_completo = false;
$tem_promo = falso;
//Destativa promo de aniversario
//if ($SS_aniver == "N" && $xcab == 0) {
if ($SS_aniver == "S" && $xcab == 0) {
    $SS_dspromo = "Presente Reverb! No mês do seu aniversário vc compra 1 camiseta (fora de promo) e ganha outra <b>de igual ou menor valor a escolhida. Para Londrina essa promo não é cumulativa com a de frete grátis.</b>";
    $_SESSION["promo"] = $SS_dspromo;
}else{
    if ($SS_dspromo == "Presente Reverb! No mês do seu aniversário vc compra 1 camiseta (fora de promo) e ganha outra de igual ou menor valor a escolhida. Para Londrina essa promo não é cumulativa com a de frete grátis."){
        $SS_dspromo = "";
        $_SESSION["promo"] = "";
        $_SESSION["8792hgaq3"] = "";
        setcookie("fhferedtexs", "");
        Header("Location: $pagatual");
        exit();
    }
}


$checa = false;
// if($SS_aniver != "S"){
//     $checa = true;
//     $SS_dspromo = "PROMO DE NATAL | Faça uma compra a partir de R$150 (em produtos fora de promoção) e ganhe +1 camiseta de sua escolha (disponível em estoque) de presente de Natal!";
//     $_SESSION["promo"] = $SS_dspromo;
//     $freteok = true;
   
// }
if ($SS_logado && $xcab == 0){
    $sqlprim = "SELECT NR_SEQ_CADASTRO_COSO from compras, cadastros WHERE NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO and
                ST_COMPRA_COSO <> 'C' and NR_SEQ_CADASTRO_CASO = $SS_logado";
    $stprim = mysql_query($sqlprim); 
    if (mysql_num_rows($stprim) > 0) {
        $checa = false;
        $SS_dspromo = (isset($_SESSION["promo"])) ? $_SESSION["promo"] : "";
        if ($SS_dspromo == "Camiseta grátis em sua compra de produtos fora de promo a partir de R$ 150,00! Escolha já a sua <a href=http://www.reverbcity.com/shop/produtos2.php?tip=6>clicando aqui</a>!"){
            $SS_dspromo = "";
            $_SESSION["promo"] = "";
            $_SESSION["8792hgaq3"] = "";
            setcookie("fhferedtexs", "");
           Header("Location: $pagatual");
            exit();
        }
    }else{
        $sqlprim = "SELECT DATEDIFF(SYSDATE(),DT_CADASTRO_CASO) from cadastros WHERE NR_SEQ_CADASTRO_CASO = $SS_logado";
        $stprimd = mysql_query($sqlprim);
        if (mysql_num_rows($stprimd) > 0) {
            $rowprimd = mysql_fetch_row($stprimd);
            if ($rowprimd[0] <= 30){
                $checa = true;        
                $_SESSION["promo"] = "Camiseta grátis em sua compra de produtos fora de promo a partir de R$ 150,00! Escolha já a sua <a href=http://www.reverbcity.com/shop/produtos2.php?tip=6>clicando aqui</a>!";
            }
        }
    }
} 
//desabilita a promo de primeira compra
// $checa = false;
$teesk8 = 0;
$xxz = 0;
$vlxze = 0;
$temgravadora = false;
$tembuttonfree = false;
$diminuiu = false;

for ($i = 0; $i < count($arraycesta); $i++) {
	$arraygrupos = explode('|', $arraycesta[$i]);
    
	$sql = "SELECT VL_PROMO_PRRC, NR_SEQ_TIPO_PRRC, NR_SEQ_CATEGORIA_PRRC, ST_PART_PROMO_PRRC
			from produtos WHERE NR_SEQ_PRODUTO_PRRC = ".$arraygrupos[0];
	$st = mysql_query($sql);
    
    $prod_fora_promo = false;
    $prodcomvlrpro = false;
	
	if (mysql_num_rows($st) > 0) {
		$row = mysql_fetch_row($st);
        
        if ($arraygrupos[2] != 1){
            $sql2 = "SELECT NR_SEQ_TAMANHO_TARC FROM tamanhos, estoque WHERE NR_SEQ_TAMANHO_TARC = NR_SEQ_TAMANHO_ESRC AND NR_SEQ_ESTOQUE_ESRC = ".$arraygrupos[2];
    		$st2 = mysql_query($sql2); 
    		if (mysql_num_rows($st2) > 0) {
    			$row2 = mysql_fetch_row($st2);
                $nr_tam = $row2[0];
    		}
        }
        
        $vl_prod	   = Valor_Produto($arraygrupos[0],$SS_logado,$nr_tam);
        $vlrpromo	   = $row[0];
        $tipppo        = $row[1];
        $categ_pr	   = $row[2];
        $st_promo_prd  = $row[3];
      
        if ($st_promo_prd == "N"){
            $prod_fora_promo = true;
        }
        if ($vlrpromo > 0) {
		    if ($vlrpromo < $vl_prod){
		       $vl_prod = $vlrpromo;
               $prodcomvlrpro = true;
		    }
        }
        
        if ($xxb > 0 && $tipppo == 6 && $SS_aniver == "S" && $vl_prod <= $xxb && $pr1 == 0 && $xcab == 0){
            $pr1 = $arraygrupos[0];
            $_SESSION["2cfl2hda2"] = $pr1;
            if (!$prodcomvlrpro) $xxz -= $vl_prod;
        }
        
        if ($SS_aniver == "S" && $tipppo == 6 && $pr1 == 0 && $xcab == 0 && !$prodcomvlrpro){
            $xxb = $vl_prod;
        }
        
        if ($xxz >= 150 && ($SS_aniver != "S" && $checa) && $arraygrupos[1] == 1 && $pr1 == 0 && $xcab == 0){
            if ($tipppo == 6 && !$prod_fora_promo){
                $pr1 = $arraygrupos[0];
                $_SESSION["2cfl2hda2"] = $pr1;
                if (!$prodcomvlrpro) $xxz -= $vl_prod;
            }

        //ativo a promo de natal
        }
        // else if ($xxz >= 150){
        //     if ($tipppo == 6 && !$prod_fora_promo){
        //         $pr1 = $arraygrupos[0];
        //         $_SESSION["2cfl2hda2"] = $pr1;
        //         $_SESSION["promo"] = "PROMO DE NATAL | Faça uma compra a partir de R$150 (em produtos fora de promoção) e ganhe +1 camiseta de sua escolha (disponível em estoque) de presente de Natal!";
        //         if (!$prodcomvlrpro) $xxz -= $vl_prod;
        //     }
        // }


        // else if ($xxz >= 260 && $arraygrupos[1] == 1 && $pr1 == 0 && $xcab == 0 && $SS_aniver != "S"){
        //     if ($tipppo == 6 && !$prod_fora_promo){
        //         $pr1 = $arraygrupos[0];
        //         $_SESSION["2cfl2hda2"] = $pr1;
        //         $_SESSION["promo"] = "Camiseta grátis em sua compra acima de R$ 260,00!";
        //         if (!$prodcomvlrpro) $xxz -= $vl_prod;
        //     }
        // }
        
        if (!$prodcomvlrpro && $xcab == 0){
            $xxz += $vl_prod*number_format($arraygrupos[1],0);
        }
                
        if ($arraygrupos[0] == $pr1 && $arraygrupos[1] == 1) {
            $vlxze = $vl_prod;
            $vl_prod = 0;            
        }
        
        if ($tipppo == 6) $xxc += $vl_prod;

       
    }
}



// Aqui vou fazer o calculo da data de quando o cliente fez o cadastro até o presente momento para verificar se já tem mais de 30 dias
// Define os valores a serem usados
$data_final = date("Y-m-d");

// Usa a função strtotime() e pega o timestamp das duas datas:
$time_inicial = strtotime($data_completo);
$time_final = strtotime($data_final);

// Calcula a diferença de segundos entre as duas datas:
$diferenca = $time_final - $time_inicial;

// Calcula a diferença de dias
$dias = (int)floor( $diferenca / (60 * 60 * 24)); 

//Aqui faço a condição de dar 10% de desconto
if ($nome != "" and $sexo != "" and $data_nascimento != "" and $cpf != "" and $endereco != "" and $numero != "" and $complemento != "" and $bairro != "" and $cep != "" and $uf != "" and $cidade != "" and $pais != "" and $dddcom != "" and $fonecom != "" and $dddfone != "" and $fone != "" and $dddcel != "" and $celular != "" and $operadora != "" and $ocupacao != "" and $ims != "" and $playlist != "" and $imeem  != "" and $fazendo != "" and $orkut != "" and $facebook != "" and $twitter != "" and $instagram != ""){
   
    if ($dias <= 30 and $comproupromo == 0){
        $cadastro_completo = true;
        $SS_dspromo = "Você acaba de ganhar um desconto especial de 10% por estar com seu cadastro completo na Reverbcity.";
        $_SESSION["promo"] = $SS_dspromo;
    }else{
         $cadastro_completo = false;
         $SS_dspromo = "";
         $_SESSION["promo"] = $SS_dspromo;
    }
}
                                                                                                                                                                                                                                           

if ($pr1 > 0 && $SS_aniver == "S" && ($xxc < $xxb)){
    $_SESSION["2cfl2hda2"] = "";
    $pr1 = 0;
    Header("Location: shop_carrinho.php");
    exit();
}

if ($xxz  < 150 && $pr1 > 0 && ($SS_aniver != "S" && $checa)){
    $_SESSION["2cfl2hda2"] = "";
    $pr1 = 0;
    Header("Location: shop_carrinho.php");
    exit();
}

else if ($xxz < 260 && $pr1 > 0 && $SS_aniver != "S" && !$checa){
    $_SESSION["2cfl2hda2"] = "";
    $pr1 = 0;
    Header("Location: shop_carrinho.php");
    exit();
}

for ($i = 0; $i < count($arraycesta); $i++) {
	$arraygrupos = explode('|', $arraycesta[$i]);

	$sql = "SELECT DS_PRODUTO2_PRRC, VL_PRODUTO_PRRC, DS_EXT_PRRC, DS_CATEGORIA_PTRC, NR_SEQ_CATEGORIA_PRRC, NR_SEQ_MUSICA_PRRC,
			NR_PESOGRAMAS_PRRC, NR_SEQ_TIPO_PRRC, VL_PROMO_PRRC, NR_SEQ_PRODUTO_PRRC, DS_FRETEGRATIS_PRRC, TP_DESTAQUE_PRRC 
			from produtos, produtos_tipo WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
			and NR_SEQ_PRODUTO_PRRC = ".$arraygrupos[0];
	$st = mysql_query($sql); 
	$x = 0;
	$vl_total = 0;
	if (mysql_num_rows($st) > 0) {
		$row = mysql_fetch_row($st);
        
        if ($arraygrupos[2] != 1){
            $sql2 = "SELECT DS_TAMANHO_TARC, DS_SIGLA_TARC, NR_QTDE_ESRC, NR_SEQ_TAMANHO_TARC FROM tamanhos, estoque WHERE NR_SEQ_TAMANHO_TARC = NR_SEQ_TAMANHO_ESRC AND NR_SEQ_ESTOQUE_ESRC = ".$arraygrupos[2];
    		$st2 = mysql_query($sql2); 
    		if (mysql_num_rows($st2) > 0) {
    			$row2 = mysql_fetch_row($st2);
    			$ds_tam = $row2[0];
    			$ds_sig = $row2[1];
    			$to_est = $row2[2];
                $nr_tam = $row2[3];
    		}
        }else{
            $to_est = 10;
        }
		
		$cotasdisp = $to_est;
        
		$ds_prod	   = $row[0];
		$vl_prod	   = Valor_Produto($arraygrupos[0],$SS_logado,$nr_tam);
		$ex_prod	   = $row[2];
		$ds_tipo	   = $row[3];
		$nr_cate	   = $row[4];
		$nr_musi	   = $row[5];
		$peso		   = $row[6];
		$tipo		   = $row[7];
		$vlrpromo	   = $row[8];
		$id			   = $row[9];
        $fretegratis   = $row[10];
        $tipodestaque  = $row[11];        
		if ($fretegratis == "S" && !$temgratis) {
		    $temgratis = true;
		}
		$itens .= $id.",";
		if ($tipo != 9) $sohvale = false;
        if ($tipo != 4) $sohbuttons = false;
        if ($nr_cate != 173) $sohposters = false;
        
        $temdescontoniver = false;
        $descontoniver = 0;
        $vl_prod_cheio = 0;
		       
        if ($vlrpromo > 0) {
		    if ($vlrpromo < $vl_prod){
		       $vl_prod_cheio = $vl_prod;
               $vl_prod = $vlrpromo;
		    }else{
		       $vl_prod_cheio = $vlrpromo;
		    }
        }
        if ($arraygrupos[0] == $pr1 && !$umnapromo && $arraygrupos[1]==1) {
            $checaprod = true;
            $vl_prod_cheio = $vl_prod;
            $vl_prod = 0;
        }
        
		$vl_total += (number_format($vl_prod,2)*number_format($arraygrupos[1],0));
		$vl_geral += $vl_total;
        
        if ($tipo == 6){
		  $ct_total += number_format($arraygrupos[1],0);
        }
		
        $pesotot += number_format($peso,0,".","")*number_format($arraygrupos[1],0);

		$str_cesta .= "<table width=\"700\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" bgcolor=\"#e5d6c5\" style=\"margin: 10px 0 10px 0\">\n";
		$str_cesta .= "<tr>\n";
		$str_cesta .= "  <td width=\"3\">&nbsp;</td>\n";
		$str_cesta .= "  <td width=\"65\">\n";
        if ($ex_prod == "swf") {
        $str_cesta .= "          <object data=\"../arquivos/uploads/produtos/".$arraygrupos[0].".".$ex_prod."\" type=\"application/x-shockwave-flash\" width=\"54\" height=\"62\">\n";
        $str_cesta .= "            <param name=\"quality\" value=\"high\" />\n";
        $str_cesta .= "            <param name=\"flashvars\" value=\"URLname=$id_prod\" />\n";
        $str_cesta .= "            <param name=\"movie\" value=\"../arquivos/uploads/produtos/".$arraygrupos[0].".".$ex_prod."\" />\n";
        $str_cesta .= "            <param name=\"wmode\" value=\"opaque\" />\n";
        $str_cesta .= "          </object>\n";
        }else{
        $str_cesta .= "        <img src=\"../arquivos/uploads/produtos/".$arraygrupos[0].".".$ex_prod."\" width=\"54\" height=\"62\" style=\"padding:4px; border: 1px solid #6b4922; background:#FFFFFF\"/>\n";
        }
        $str_cesta .= "  </td>\n";
		$str_cesta .= "  <td width=\"106\" class=\"textoDestaque\"><div align=\"left\">".$ds_prod."</div></td>\n";
		$str_cesta .= "  <td width=\"91\"><div align=\"left\">".$ds_tipo."<br />\n";
		$str_cesta .= $ds_tam."<br /></div></td>\n";
        if ($vl_prod_cheio > 0){
            $str_cesta .= "  <td width=\"70\" class=\"textoDestaque\"><div align=\"left\">De <span style=\"text-decoration:line-through;\">R$ ".number_format($vl_prod_cheio,2,",","")."</span><br />Por R$ ".number_format($vl_prod,2,",","")."</div></td>\n";
        }else{
            $str_cesta .= "  <td width=\"70\" class=\"textoDestaque\"><div align=\"left\">R$ ".number_format($vl_prod,2,",","")."</div></td>\n";   
        }
		$str_cesta .= "  <td width=\"31\"><div align=\"center\" class=\"textoDestaque\">X</div></td>\n";
		$str_cesta .= "  <td width=\"76\"><div align=\"center\">\n";
        if (!$umnapromo && $checaprod){
            $str_cesta .= "<strong>1</strong>";
        }else{
        $str_cesta .= "	<label>\n";
		$str_cesta .= "	<select style=\"margin: 0; padding:0; width:55px; text-align:right;\" name=\"qtdecesta".$i."\" class=\"input\" id=\"qtdecesta".$i."\" onChange=\"Recalcula(".$i.");\">\n";
            if ($cotasdisp > 10) $cotasdisp = 10;
			for ($f=0;$f<=$cotasdisp;$f++){
				$comple = "";
				if ($f == $arraygrupos[1]) $comple = " selected";
				$str_cesta .= "<option value='$f'$comple>$f</option>";
			}

	    $str_cesta .= "   </select>\n";
        $str_cesta .= "	</label>\n";
        }
    	$str_cesta .= "  </div></td>\n";
    	$str_cesta .= "  <td width=\"44\"><div align=\"center\" class=\"textoDestaque\">=</div></td>\n";
        if (!$umnapromo && $checaprod){
    	$str_cesta .= "  <td width=\"77\" class=\"textoDestaque\"><div align=\"left\">GRÁTIS</div></td>\n";
        }else{
        $str_cesta .= "  <td width=\"77\" class=\"textoDestaque\"><div align=\"left\">R$ ".number_format($vl_total,2,",","")."</div></td>\n";
        }
        if (!$umnapromo && $checaprod){
          $str_cesta .= "  <td width=\"15\"><div align=\"center\">&nbsp;</div></td>\n";
        }else{
          $str_cesta .= "  <td width=\"15\"><div align=\"center\"><a href=\"#\" onClick=\"Remove($i);\" title=\"Remover item do carrinho!\"><img src=\"../images/cancel.png\" border=\"0\"/></a></div></td>\n";   
        }
        $str_cesta .= "  </tr>\n";
        if ($tipodestaque == 4){
            $str_cesta .= "<tr><td width=\"3\">&nbsp;</td><td>&nbsp;</td><td colspan=8><strong>Produto em Pré-Venda: Envio após a quantidade mínima estabelecida atingida e a finalização da produção</strong></td></tr>";
        }
        $str_cesta .= "</table>\n";
        
        if (!$umnapromo && $checaprod && $arraygrupos[0] != 2015){
            $umnapromo = true;
        }
	 }
}

if (!$temgratis){
    if ($_SESSION["promo"] == "Frete grátis para SP - Promo reprint"){
        $SS_dspromo = "";
        $_SESSION["promo"] = "";
    }
}

if ($xcab != 1){
    if ($temgratis || $sohvale) {
        $frete = 0;
        $freteok = true;
        setcookie("fhferedtexs", "0,00");
    }    
}

if ($xcab == 1 && $ct_total >= 100){
    $frete = 0;
    $freteok = true;
    setcookie("fhferedtexs", "0,00");    
}

if ($SS_logado){
    $sqlprim = "SELECT * FROM beneficios WHERE NR_SEQ_CADASTRO_CTRC = $SS_logado AND ST_BENEFICIO_CTRC = 'A'";
    $stprim = mysql_query($sqlprim); 
    if (mysql_num_rows($stprim) > 0) { 
        $rowprim = mysql_fetch_array($stprim);
        
        $valendo = true;
        
        if ($rowprim["ST_PROGRAMADA_CTRC"] == "S"){
            $data_ini = $rowprim["DT_INICIO_CTRC"];
            $data_fim = $rowprim["DT_FIM_CTRC"];
            
            $data1 = date("Y/m/d G:i",strtotime($data_ini));
            $data2 = date("Y/m/d G:i",strtotime($data_fim));
            
            if ($dataatual >= $data1 && $dataatual <= $data2){
                $valendo = true;
            }else{
                $valendo = false;
            }
        }
        
        if ($valendo){
            $ds_beneficio = $rowprim["DS_PROMO_CTRC"];
            
            if ($rowprim["ST_FRETEGRATIS_CTRC"] == "S" && $rowprim["VL_MINIMODECOMPRA_CTRC"] == 0 && $rowprim["ST_FRETEGRATISUM_CTRC"] == "N"){
                $frete = 0;
                $freteok = true;
                setcookie("fhferedtexs", "0,00");
                if ($ds_beneficio) $_SESSION["promo"] = $ds_beneficio;
            }else{
                if ($rowprim["ST_FRETEGRATIS_CTRC"] == "S" && $rowprim["VL_MINIMODECOMPRA_CTRC"] > 0 && $rowprim["ST_FRETEGRATISUM_CTRC"] == "N"){
                    $valor_min = $rowprim["VL_MINIMODECOMPRA_CTRC"];
                    if ($vl_geral >= $valor_min){
                        $frete = 0;
                        $freteok = true;
                        setcookie("fhferedtexs", "0,00");
                        if ($ds_beneficio) $_SESSION["promo"] = $ds_beneficio;
                    }
                }
            } 
            
            if ($rowprim["ST_FRETEGRATISUM_CTRC"] == "S") {
                $sqlcomprames = "SELECT NR_SEQ_CADASTRO_COSO from compras WHERE ST_COMPRA_COSO IN ('P','V','E','A') and
                        NR_SEQ_CADASTRO_COSO = $SS_logado and (MONTH(DT_COMPRA_COSO) = MONTH(SYSDATE()) and YEAR(DT_COMPRA_COSO) = YEAR(SYSDATE()))";
                $stcompm = mysql_query($sqlcomprames); 
                if (mysql_num_rows($stcompm) <= 0) {
                    $valor_min = $rowprim["VL_MINIMODECOMPRA_CTRC"];
                    if ($vl_geral >= $valor_min){
                        $frete = 0;
                        $freteok = true;
                        setcookie("fhferedtexs", "0,00");
                        if ($ds_beneficio) $_SESSION["promo"] = $ds_beneficio;
                    }
                }
            }
            
            $valor_bonus = $rowprim["VL_BONUS_CTRC"];
            if (!$valor_bonus) $valor_bonus = 0;
            if ($valor_bonus > 0){
                $_SESSION["8792hgaq3"] = number_format($valor_bonus,2); 
                if ($ds_beneficio) $_SESSION["promo"] = $ds_beneficio;
            }
        }
    }   
}

$SS_xx1 = (isset($_SESSION["8792hgaq3"])) ? $_SESSION["8792hgaq3"] : 0;
if (!$SS_xx1) $SS_xx1 = 0;

if ($pesotot == 0) $pesotot = 370;
$pesotot = number_format($pesotot/1000,2,",","");

$SS_dspromo = (isset($_SESSION["promo"])) ? $_SESSION["promo"] : "";

$mostra = true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reverbcity - Carrinho de Compras <?php echo $tit_debug; ?></title>
<script type="text/javascript" src="../scripts/jquery-1.4.2.min.js"></script>
<link rel="shortcut icon" href="/default/favicon.ico" />
<link rel="icon" type="image/gif" href="/default/animated_favicon1.gif" />
<link href="../css/geral.css" rel="stylesheet" type="text/css" />
<link href="../css/carrinho.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style2 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
}
-->
</style>
<script language="javascript">
function Recalcula(pos) {
	  var sel = document.getElementById("qtdecesta"+pos);
      var qtde = sel.options[sel.selectedIndex].value;
      document.location.href='recalcula.php?pos='+pos+'&qtde='+qtde;
}
function Remove(pos) {
	  var sel = document.getElementById("qtdecesta"+pos);
      var qtde = 0;
      document.location.href='recalcula.php?pos='+pos+'&qtde='+qtde;
}
</script>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>

</head>

<body oncontextmenu="return false">

	<div id="geral">
      <?php include '../includes/topo.html'; ?>
        
        <div id="corpo-interno">
        
        <?php
        if ($bannerlondrina){ ?>
            <div style="background: #ffffff url(/images/frete65.gif); width:199px; height: 294px; float: right; margin: 79px 0 0 0; cursor: pointer;" onclick="document.location.href='http://www.reverbcity.com/shop/produtos2_new.php'"><!--<p style="vertical-align: bottom; margin-top: 302px;">* R$65 em produtos fora de promoção</p>--></div>
        <?php }else{
            if ($SS_aniver == "S" && $xcab == 0) {
                //if ($SS_twnome){  //BANNER ESPECIAL DE PROMO
            ?>
    
                <!--<div style="background: #ffffff url(/images/Bday_carrinho2.gif); width:199px; height: 294px; float: right; margin: 79px 0 0 0; cursor: pointer;" onclick="document.location.href='http://www.reverbcity.com/blog/blog.php?idb=2840'"></div>-->
    
            <?php 
                 
            } else { 
            
            if ($freteok && $frete == 0){
                //nada
            }else{
                if ($vl_geral < 260 && !$mostrabanesp && $xcab == 0 && !$sohposters) {
            ?>
            
            <div style="background: #ffffff url(/images/fretegratis1_car2.gif); width:199px; height: 294px; float: right; margin: 79px 0 0 0; cursor: pointer;"></div>
            
            <?php }else if ($vl_geral > 190 && $vl_geral < 250 && !$mostrabanesp && $xcab == 0 && !$sohposters) { ?>
            
            </a><div style="background: #ffffff url(/images/fretegratis1_car2.gif); width:199px; height: 294px; float: right; margin: 79px 0 0 0; cursor: pointer;"></div>
          
            <?php }else if ($mostrabanesp && $xcab == 0 && !$sohposters){ ?>
            
        <!--<div style="background: #ffffff url(/images/fretegratis1_car2.gif); width:199px; height: 294px; float: right; margin: 79px 0 0 0; cursor: pointer;"></div>-->
                
            <?php
                }
            }
            }

        }?>
              
          <p><img src="../images/img_carrinho_cabecalho.jpg" alt="Carrinho de Compras" width="245" height="69" /></p>
          <form action="<?php echo $pagatual; ?>" method="post" name="form1">
          <table width="700" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="700" border="0" cellpadding="3" cellspacing="0" class="barra_marrom" style="width:700PX; float:none; margin: 0">
                <tr>
                  <td width="10">&nbsp;</td>
                  <td width="189">Produto</td>
                  <td width="102">Descrição</td>
                  <td width="111">Preço</td>
                  <td width="130"><div align="left">Quantidade</div></td>
                  <td width="139">TOTAL</td>
                  <td width="7">&nbsp;</td>
                </tr>
              </table>
               <?php
                echo $str_cesta;
			   ?>
               </form>
               <?php
               if ($SS_xx1 > 0) {?>
               <table width="700" border="0" cellpadding="3" cellspacing="0" bgcolor="#e5d6c5" style="margin: 10px 0 10px 0">
                  <tr>
                    <td width="2">&nbsp;</td>
                    <td width="191" colspan="2"><p><strong style="color: #f15525;"><?php if ($xcab == 0) echo $SS_dspromo; ?></strong></p></td>
                    <td width="79" class="textoDestaque"><br />
                    <p class="textoDestaque">Desconto Promocional<br />
                    </p></td>
                    <td width="44"><div align="center" class="textoDestaque">   <br />                   
                      <p class="textoDestaque">=<br />
                      </p>
                    </div></td>
                    <td width="76" class="textoDestaque"><div align="left"><br />
                      <p class="textoDestaque">- R$ <?php echo number_format($SS_xx1,2,",","."); ?><br />
                      </p>
                    </div></td>
                    <td width="75">&nbsp;</td>
                  </tr>
                </table>
               <?php 
			    $vl_geral = $vl_geral - $SS_xx1; 
                if ($vl_geral < 0) $vl_geral = 0;
			   }else{
			     if ($SS_dspromo){
			         ?>
                     <table width="700" border="0" cellpadding="3" cellspacing="0" bgcolor="#e5d6c5" style="margin: 10px 0 10px 0">
                      <tr>
                        <td width="2">&nbsp;</td>
                        <td width="191" colspan="5"><p><font style="color: #f15525; font-size: 11px;"><?php echo $SS_dspromo ?></font></p></td>
                        <td width="75">&nbsp;</td>
                      </tr>
                    </table>
                     <?php
			     }
			   }
               
               if (!$sohvale) {?>
                <table width="700" border="0" cellpadding="3" cellspacing="0" bgcolor="#e5d6c5" style="margin: 10px 0 10px 0">
                  <tr>
                    <td width="2">&nbsp;</td>
                    <td width="191"><p>&nbsp;</p>
                    <p><span class="textoDestaque">Calcule o Frete. </span>Insira seu CEP:</p>
                    <p>&nbsp;</p></td><form action="frete.php" method="post">
					<input type="hidden" name="peso" value="<?php echo $pesotot; ?>">
                    <td width="191"><p>&nbsp;</p><p><input type="text" name="cep" id="textfield" style="width:65px;" maxlength="10" />
                    <?php if ($freteok){?>
                      <button type="button" onClick="submit();return false;" class="btlaranja" style="width:70px;height:19px; margin: 0 10px 0 10px;text-align:center;">Alterar</button>
                    <?php } else { ?>
                    	<button type="button" onClick="submit();return false;" class="btlaranja" style="width:70px;height:19px; margin: 0 10px 0 10px;text-align:center;">Calcule</button>
                    <?php } ?>
                    </p>
                    <p>&nbsp;</p></td></form>
                    <td width="79" class="textoDestaque"><p class="textoDestaque"><br />
                      Subtotal</p>
                    <p class="textoDestaque">Frete<br />
                    </p></td>
                    <td width="44"><div align="center" class="textoDestaque">
                      <p class="textoDestaque"><br />
                      =</p>
                      <p class="textoDestaque">=<br />
                      </p>
                    </div></td>
                    <td width="86" class="textoDestaque"><div align="left">
                      <p class="textoDestaque"><br />
                      R$ <?php echo number_format($vl_geral,2,",","."); ?></p>
                      <?php if ($freteok && $frete == 0) { ?>
                      <p>FRETE GRÁTIS</p>
                      <?php }else{ ?>
                      <p class="textoDestaque">R$ <?php echo number_format($frete,2,",","."); ?><br />
                      </p>
                      <?php } ?>
                    </div></td>
                    <td width="75">&nbsp;</td>
                  </tr>
                </table>
                <?php 
				}
				$total_fim = $vl_geral + $frete; ?>
                <?php 
               $saldocred = 0;
               if ($SS_logado){
                   $sqlcred = "select sum(VL_LANCAMENTO_CRSA) from contacorrente WHERE NR_SEQ_CADASTRO_CRSA = $SS_logado";
    			   $stcred = mysql_query($sqlcred);
    			   
                   if (mysql_num_rows($stcred) > 0) {
    			      $rowcred = mysql_fetch_row($stcred);
                      $saldocred = $rowcred[0];
                   }
               }
               if ($saldocred > 0) {
                $saldo_temp = $total_fim - $saldocred;
                $valoradeb = 0;
                if ($saldo_temp < 0){
                    $valoradeb = $total_fim;
                }else{
                    $valoradeb = $saldocred;
                }
               ?>
               <table width="700" border="0" cellpadding="3" cellspacing="0" bgcolor="#e5d6c5" style="margin: 10px 0 10px 0">
                  <tr>
                    <td width="2">&nbsp;</td>
                    <td width="270" colspan="3" align="right">
                    <p class="textoDestaque"><br /> <strong>Subtotal:</strong></p></td>
                    <td width="44"><div align="center" class="textoDestaque">   <br />                   
                      <p class="textoDestaque">=<br />
                      </p>
                    </div></td>
                    <td width="76" class="textoDestaque"><div align="left"><br />

                        
                         <p class="textoDestaque"> R$ <?php echo number_format($total_fim,2,",","."); ?><br />
                      </p>
                    </div></td>
                    <td width="75">&nbsp;</td>
                  </tr>
               </table>
               <table width="700" border="0" cellpadding="3" cellspacing="0" bgcolor="#e5d6c5" style="margin: 10px 0 10px 0">
                  <tr>
                    <td width="2">&nbsp;</td>
                    <td width="270" colspan="3">
                    <p class="textoDestaque"><br />Você possui <strong>R$<?php echo number_format($saldocred,2,",","");?></strong> em Créditos Reverbcity<br />
                    </p></td>
                    <td width="44"><div align="center" class="textoDestaque">   <br />                   
                      <p class="textoDestaque">=<br />
                      </p>
                    </div></td>
                    <td width="76" class="textoDestaque"><div align="left"><br />
                      <p class="textoDestaque">- R$ <?php echo number_format($valoradeb,2,",","."); ?><br />
                      </p>
                    </div></td>
                    <td width="75">&nbsp;</td>
                  </tr>
               </table>
               <?php
               $total_fim = $total_fim - $valoradeb; 
               }
               ?>
                <table width="700" border="0" cellpadding="3" cellspacing="0" bgcolor="#e5d6c5" style="margin: 10px 0 10px 0">
                  <tr>
                    <td width="2">&nbsp;</td>
                    <td width="383" colspan="2">
                    <?php if ($sohbuttons) { ?>
                            <p align="left" class="textoDestaque" style="color: #f23900;"><strong>Compras de até 15 buttons o valor do frete fica em R$ 7,00</strong>!</p>
                    <?php }?>
                    <?php if ($sohposters) {?>
                            <p align="left" class="textoDestaque"><strong style="color: #f23900; text-transform: uppercase;">O Frete é Grátis para essa compra!!</strong>
                            <br />Informe o seu CEP para validarmos seu endereço.</p>
                    <?php }?>
                    <?php if ($stfreteg == "A" && !$temgratis && !$sohvale && !$sohposters) {
							if ($vl_geral < $vlfreteg && $xcab == 0 ) {
                                if(!$bannerlondrina){
                                    // if($prodcomvlrpro == false){
					?>
                    		      <p align="left" class="textoDestaque"><strong>Faltam R$ <?php echo number_format($vlfreteg-$vl_geral,2,",",".") ?> para o Frete Grátis</strong>!</p>
                    <?php 
                                    // }
                                }
							}else{
								if ($xcab == 0 ) echo "<p align=\"left\" class=\"textoDestaque\"><strong style=\"color: #f23900; text-transform: uppercase;\">Para essa compra o Frete é GRÁTIS</strong><br />Informe o seu CEP para validarmos seu endereço.</p>";
							}
						}else{?>
                    <p>&nbsp;</p>
                    <?php }?>
                    </td>
                    <td width="78" class="textoDestaque"><p align="left" class="textoDestaque"><br />
                      Valor Total<br />
                      </p>
                    </td>
                    <td width="44"><div align="center" class="textoDestaque">
                        <p class="textoDestaque">                          <br />
                      =</p>
                      </div></td>
                    <td width="76" class="textoDestaque"><div align="left">

                        <?php if ($cadastro_completo == 1){
                         //se tiver cadastro completo da 10% de desconto
                                $percentual = 10 / 100;
                                $total_fim = $total_fim - ($percentual * $total_fim); ?>
                                <p style="color: red; font-size: 2"> 10% OFF</p><p class="textoDestaque"> R$ <?php echo number_format($total_fim,2,",","."); ?></p><br />
                        <?php }else{ ?>
                                <p class="textoDestaque"> R$ <?php echo number_format($total_fim,2,",","."); ?><br />
                        <?php } ?>
                    
                      </div></td>
                    <td width="75">&nbsp;</td>
                  </tr>
                </table>
                </td>
            </tr>
          </table>
          <table width="680" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="454"><div align="right">
                <?php if ($freteok && $frete == 0) { ?>
                <button type="button" class="btbege" style="width: 230px" onClick="document.location.href='<?php echo $continuac ?>';return false;">&lt;&lt;&lt; Continuar Comprando com Frete Grátis</button>
                <?php } else { ?>
                <button type="button" class="btbege" style="width: 150px" onClick="document.location.href='<?php echo $continuac ?>';return false;">&lt;&lt;&lt; Continuar Comprando</button>
                <?php } ?>
              </div></td>
              <td width="96"><button type="button" class="btmarrom" style="width: 130px" onClick="document.location.href='cancela.php';return false;">X  Limpar Carrinho</button></td>
              <td width="100">
			  <?php if ($freteok || $sohvale || $temgratis){?>
              <button type="button" class="btlaranja" style="width: 130px" onClick="document.location.href='shop_login.php?ret=finalizando.php';return false;">Concluir a Compra</button>
              <?php }?>
              </td>
            </tr>
          </table>
          <div style="width: 850px; float:left; margin: 20px 0 0 0">
          	<h3 class="barra_marrom">Sugestões da Reverbcity</h3>
            <p>&nbsp;</p>
            
            <?php 
			if (substr($itens,strlen($itens)-1,1) == ",") $itens = substr($itens,0,strlen($itens)-1);
	
			$ids = "";
            $sql = "SELECT distinct DS_PRODUTO2_PRRC, VL_PRODUTO_PRRC, DS_EXT_PRRC, NR_SEQ_PRODUTO_PRRC, VL_PROMO_PRRC, DS_CATEGORIA_PTRC
					from produtos, estoque, produtos_tipo 
					WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC 
                    AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
                    and NR_QTDE_ESRC > 0 and 
					ST_PRODUTOS_PRRC = 'A' and
					DS_CLASSIC_PRRC = 'N' and NR_SEQ_PRODUTO_PRRC in (5307,5306,5305,5304,5303,5302,5301,53005509,5508,5507,5506)
                    order by rand() limit 1";
			$st = mysql_query($sql); 
			$x = 0;
			if (mysql_num_rows($st) > 0) {
				while($row = mysql_fetch_row($st)) {
				$ds_prod	   = $row[0];
				$vl_prod	   = Valor_Produto($row[3],$SS_logado);
				$ex_prod	   = $row[2];
				$id_prod	   = $row[3];
				$vlrpromo	   = $row[4];
                $ds_categoria  = $row[5];
                
                if ($vlrpromo > 0) {
        		    if ($vlrpromo < $vl_prod){
        		       $vl_prod_cheio = $vl_prod;
                       $vl_prod = $vlrpromo;
        		    }else{
        		       $vl_prod_cheio = $vlrpromo;
        		    }
                }
                                            
                $ds_categoria = str_replace("&","e;",$ds_categoria);
                $ds_prod_url = str_replace("&","e;",$ds_prod);
                                            
				$ids .= $id_prod.",";		
			?>         
            <div class="produto" style="margin: 0 7px;width:180px;height:265px;">
                        <?php if ($ex_prod == "swf") {?>
                          <object data="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" type="application/x-shockwave-flash" width="180" height="210">
                            <param name="quality" value="high" />
                            <param name="flashvars" value="URLname=<?php echo $id_prod; ?>" />
                            <param name="movie" value="../arquivos/uploads/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" />
                            <param name="wmode" value="opaque" />
                          </object>
                        <?php }else{ ?>
                        <a href="/produto/<?php echo $ds_categoria ?>/<?php echo urlencode($ds_prod_url); ?>"><img src="../images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" border="0" /></a>
                        <?php } ?>
                        <div class="preco-produto">
                       <?php if ($vlrpromo > 0) { ?>
                            <p class="promocao"><span class="preco" style="text-decoration:line-through">R$ <?php echo number_format($vl_prod_cheio,2,",",""); ?></span><br />
                            <span class="promocao" style="text-decoration:none">R$ <?php echo number_format($vl_prod,2,",",""); ?></span></p>
                            <?php } else { ?>
                            <p class="promocao">R$ <?php echo number_format($vl_prod,2,",",""); ?></p>
                            <?php } ?>
                        </div>
                        <div class="desc-produto">
                            <p><?php echo $ds_prod; ?><br />
                            </p>
                        </div>
            </div>
            
            <?php
				$x++;
				}
            }
			
			if (substr($ids,strlen($ids)-1,1) == ",") $ids = substr($ids,0,strlen($ids)-1);
			
			if ($x < 4) {
				$totreg = 4 - $x;
				
                $sql = "SELECT distinct DS_PRODUTO2_PRRC, VL_PRODUTO_PRRC, DS_EXT_PRRC, NR_SEQ_PRODUTO_PRRC,VL_PROMO_PRRC, DS_CATEGORIA_PTRC
						from produtos, estoque, produtos_tipo
						WHERE
						 NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC
                         AND NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and 
						 NR_QTDE_ESRC > 0 and 
						 ST_PRODUTOS_PRRC = 'A' and 
						 DS_CLASSIC_PRRC = 'N' and NR_SEQ_PRODUTO_PRRC in (5307,5306,5305,5304,5303,5302,5301,5300,5509,5508,5507,5506)
						";
                         
                         	
						 
						 // if ($itens) $sql .= "and NR_SEQ_PRODUTO_PRRC not in ($itens) ";
						 // if ($ids) $sql .= "and NR_SEQ_PRODUTO_PRRC not in ($ids) ";
						 
						 $sql .= "order by rand() limit $totreg";
				$st = mysql_query($sql); 

				if (mysql_num_rows($st) > 0) {
					while($row = mysql_fetch_row($st)) {
					$ds_prod	   = $row[0];
					$vl_prod	   = Valor_Produto($row[3],$SS_logado);
					$ex_prod	   = $row[2];
					$id_prod	   = $row[3];
					$vlrpromo	   = $row[4];
                    $ds_categoria  = $row[5];
                    
                    if ($vlrpromo > 0) {
            		    if ($vlrpromo < $vl_prod){
            		       $vl_prod_cheio = $vl_prod;
                           $vl_prod = $vlrpromo;
            		    }else{
            		       $vl_prod_cheio = $vlrpromo;
            		    }
                    }
                                            
                    $ds_categoria = str_replace("&","e;",$ds_categoria);
                    $ds_prod_url = str_replace("&","e;",$ds_prod);
					$ids .= $id_prod.",";
				?>
				
				<div class="produto" style="margin: 0 7px;width:180px;height:265px;">
							<?php if ($ex_prod == "swf") {?>
                              <object data="../images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" type="application/x-shockwave-flash" width="180" height="210">
                                <param name="quality" value="high" />
                                <param name="flashvars" value="URLname=<?php echo $id_prod; ?>" />
                                <param name="movie" value="../images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" />
                                <param name="wmode" value="opaque" />
                              </object>
                            <?php }else{ ?>
                            <a href="/produto/<?php echo $ds_categoria ?>/<?php echo urlencode($ds_prod_url); ?>"><img src="../images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" border="0" /></a>
                            <?php } ?>
							<div class="preco-produto">
									<?php if ($vlrpromo > 0) { ?>
                            <p class="promocao"><span class="preco" style="text-decoration:line-through">R$ <?php echo number_format($vl_prod_cheio,2,",",""); ?></span><br />
                            <span class="promocao" style="text-decoration:none">R$ <?php echo number_format($vl_prod,2,",",""); ?></span></p>
                            <?php } else { ?>
                            <p class="promocao">R$ <?php echo number_format($vl_prod,2,",",""); ?></p>
                            <?php } ?>
							</div>
							<div class="desc-produto">
								<p><?php echo $ds_prod; ?><br />
								</p>
							</div>
				</div>
				
				<?php
					$x++;
					}
				}
            }
			
			if (substr($ids,strlen($ids)-1,1) == ",") $ids = substr($ids,0,strlen($ids)-1);
			
			if ($x < 4) {
				$totreg = 4 - $x;
				
        $sql = "SELECT distinct DS_PRODUTO2_PRRC, VL_PRODUTO_PRRC, DS_EXT_PRRC, NR_SEQ_PRODUTO_PRRC,VL_PROMO_PRRC, DS_CATEGORIA_PTRC
						from produtos, estoque, produtos_tipo
						WHERE
				 		  NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC and 
                          NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and 
						  NR_QTDE_ESRC > 0 and 
						  ST_PRODUTOS_PRRC = 'A' and
						  DS_CLASSIC_PRRC = 'N' and NR_SEQ_PRODUTO_PRRC in (5307,5306,5305,5304,5303,5302,5301,5300)";
						  
						  if ($itens) $sql .= "and NR_SEQ_PRODUTO_PRRC not in ($itens) ";
						  if ($ids) $sql .= "and NR_SEQ_PRODUTO_PRRC not in ($ids) ";
						 
						  $sql .= "order by rand() limit $totreg";
				$st = mysql_query($sql); 

				if (mysql_num_rows($st) > 0) {
					while($row = mysql_fetch_row($st)) {
					$ds_prod	   = $row[0];
					$vl_prod	   = Valor_Produto($row[3],$SS_logado);
					$ex_prod	   = $row[2];
					$id_prod	   = $row[3];
					$vlrpromo	   = $row[4];
                    $ds_categoria  = $row[5];
                    
                    if ($vlrpromo > 0) {
            		    if ($vlrpromo < $vl_prod){
            		       $vl_prod_cheio = $vl_prod;
                           $vl_prod = $vlrpromo;
            		    }else{
            		       $vl_prod_cheio = $vlrpromo;
            		    }
                    }
                                            
                    $ds_categoria = str_replace("&","e;",$ds_categoria);
                    $ds_prod_url = str_replace("&","e;",$ds_prod);
				?>				
				<div class="produto" style="margin: 0 7px;width:180px;height:265px;">
							<?php if ($ex_prod == "swf") {?>
                              <object data="../images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" type="application/x-shockwave-flash" width="180" height="210">
                                <param name="quality" value="high" />
                                <param name="flashvars" value="URLname=<?php echo $id_prod; ?>" />
                                <param name="movie" value="../images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" />
                                <param name="wmode" value="opaque" />
                              </object>
                            <?php }else{ ?>
                            <a href="/produto/<?php echo $ds_categoria ?>/<?php echo urlencode($ds_prod_url); ?>"><img src="../images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" border="0" /></a>
                            <?php } ?>
							<div class="preco-produto">
							<?php if ($vlrpromo > 0) { ?>
                            <p class="promocao"><span class="preco" style="text-decoration:line-through">R$ <?php echo number_format($vl_prod_cheio,2,",",""); ?></span><br />
                            <span class="promocao" style="text-decoration:none">R$ <?php echo number_format($vl_prod,2,",",""); ?></span></p>
                            <?php } else { ?>
                            <p class="promocao">R$ <?php echo number_format($vl_prod,2,",",""); ?></p>
                            <?php } ?>
							</div>
							<div class="desc-produto">
								<p><?php echo $ds_prod; ?><br />
								</p>
							</div>
				</div>
				
				<?php
					$x++;
					}
				}
            }
			?>
          </div>
            <p>&nbsp;</p>
        </div>
      
       <?php include '../includes/rodape.html'; ?>
</div>
<?php include '../includes/ultimo.php'; ?>
</body>
</html>
<?php mysql_close($con); ?>
<?php
require("phpmailer/class.phpmailer.php");
date_default_timezone_set('America/Sao_Paulo');
//error_reporting(0);
$con = mysql_connect("reverbcity1.cp48hix4ktfm.sa-east-1.rds.amazonaws.com","reverb","reverbserver2014") or die("Conexão Falhou!");
mysql_select_db("reverb_amazon",$con) or die("Database Inválido");

//$con = mysql_connect("localhost","root","") or die("Conexão Falhou!");
//mysql_select_db("reverbcity22",$con) or die("Database Inválido");

//if (request("cp")){
//    $SS_campanha = request("cp");
//    setcookie("SS_campanha", $SS_campanha, time()+60*60*24*7, "/");
//}else{
//    $SS_campanha  = @$HTTP_COOKIE_VARS["SS_campanha"];
//}
$SS_logadm = (isset($_SESSION["SS_logadm"])) ? $_SESSION["SS_logadm"] : "";
if ($SS_logadm){
    $sqll = "select ST_STATUS_USRC, NR_SEQ_FUNC_USRC from usuarios WHERE NR_SEQ_USUARIO_USRC  = $SS_logadm";
    $stl = mysql_query($sqll);
    $nrfunc = 0;
    if (mysql_num_rows($stl) > 0) {
      	$rowl = mysql_fetch_row($stl);
        $stlog = $rowl[0];
        $nrfunc = $rowl[1];
        if ($stlog != 'A'){
            $_SESSION["SS_sessao"] = "";
            $_SESSION["SS_logadm"] = "";
            $_SESSION["SS_login"] = "";
            $_SESSION["SS_acesso"] = "";
            $_SESSION["SS_nivel"] = "";
            $_SESSION["SS_loja"] = "";
            
            setcookie("ck_sessao", "", time() - 3600, "/");
            setcookie("ck_logadm", "", time() - 3600, "/");
            setcookie("ck_login", "", time() - 3600, "/");
            setcookie("ck_nivel", "", time() - 3600, "/");
            setcookie("ck_acesso", "", time() - 3600, "/");
            setcookie("ck_loja", "", time() - 3600, "/");
            
            Header("Location: login.php");
            exit();
        }
    }
}

function request($var) {
    $return = (isset($_REQUEST[$var])) ? $_REQUEST[$var] : "";
	$return = antiSQL($return);
	$return = trim($return);
    return $return;
}

function antiSQL($string) {
	$string = str_replace("'", "", $string);
	$string = str_replace("`", "", $string);
    //$string = str_replace("--", "", $string);
	$string = str_replace("DROP ", "", $string);
	$string = str_replace("drop ", "", $string);
	$string = str_replace("SELECT ", "", $string);
	$string = str_replace("select ", "", $string);
	$string = str_replace("delete from ", "", $string);
	$string = str_replace("DELETE FROM ", "", $string);
	$string = str_replace("UPDATE ", "", $string);
	$string = str_replace("update ", "", $string);
    $string = str_replace("or 1=1", "", $string);
    $string = str_replace("or  1=1", "", $string);
    $string = str_replace("CHAR(", "", $string);
    $string = str_replace("BIN(", "", $string);
    $string = str_replace("%27", "", $string);
    $string = str_replace("convert(int", "", $string);
    $string = str_replace("CONCAT(", "", $string);
    $string = str_replace("CREATE TABLE", "", $string);
    $string = str_replace("CONV(", "", $string);
    $string = str_replace("HEX(", "", $string);
    $string = str_replace("INSTR(", "", $string);
    $string = str_replace("LOAD_FILE(", "", $string);
    
    //$string = str_replace("", "", $string);
    //$string = str_replace("", "", $string);
    //$string = str_replace("", "", $string);
    //$string = str_replace("", "", $string);
    
	return $string;
}

function FormataDataMysql($dttext) {
	if (strlen($dttext) > 10) {
		$dttext  = substr($dttext,6,4)."-".substr($dttext,3,2)."-".substr($dttext,0,2)." ".substr($dttext,11,strlen($dttext)-11); 
	}else{
		$dttext  = substr($dttext,6,4)."-".substr($dttext,3,2)."-".substr($dttext,0,2);
	}
	return $dttext;
}

function GravaLogEstoque($iduser,$nrprod,$nrtam,$dsacao,$dsobs,$qtde){
	if (!$dsobs){
        $dsobs = "null";
    }else{
        $dsobs = "'".$dsobs."'";
    }
    $strloge = "INSERT INTO estoque_controle (NR_SEQ_USUARIO_ECRC, NR_SEQ_PRODUTO_ECRC, NR_SEQ_TAMANHO_ECRC, DS_ACAO_ECRC, DS_OBS_ECRC, DT_ACAO_ECRC, NR_QTDE_ECRC)
               values ($iduser, $nrprod, $nrtam, '$dsacao', $dsobs, sysdate(), $qtde)";
	$stloge = mysql_query($strloge);

    $sqlUser = "SELECT DS_LOGIN_USRC FROM usuarios WHERE NR_SEQ_USUARIO_USRC = ".addslashes($iduser);
    $queryUser = mysql_query($sqlUser);
    $rowUser = mysql_fetch_row($queryUser);

    $sqlProduto = "SELECT DS_PRODUTO2_PRRC FROM produtos WHERE NR_SEQ_PRODUTO_PRRC = ".addslashes($nrprod);
    $queryProduto = mysql_query($sqlProduto);
    $rowProduto = mysql_fetch_row($queryProduto);

    $sqlTamanho = "SELECT DS_TAMANHO_TARC FROM tamanhos WHERE NR_SEQ_TAMANHO_TARC = ".addslashes($nrtam);
    $queryTamanho = mysql_query($sqlTamanho);
    $rowTamanho = mysql_fetch_row($queryTamanho);

    $mensagemEmail = "<table>
                        <tr>
                            <td width='600' style='font-family: Verdana; font-size: 12px;'>
                                O usuario <b>" . $rowUser[0] . "</b> " . $dsacao . " ao estoque do produto <b>" . $rowProduto[0] . "</b> do tamanho <b>" . $rowTamanho[0] . "</b>
                            </td>
                        </tr>
                    </table>";

    $contatos = array(
                  'miri' =>"atendimento@reverbcity.com",
                  'jana' => 'janaina@reverbcity.com');

    foreach ($contatos as $key => $contato) {
        $corpo = IncluiPapelCarta('sistema',$mensagemEmail,'Altera&ccedil;&atilde;o de estoque');
        EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$contato,"","",utf8_encode('Alteração de estoque'), $corpo);
    }
}

function GravaLog($nrseqlo,$dsscript,$dsacao){
	$ip_user = $_SERVER["REMOTE_ADDR"];

	$strlog = "INSERT INTO logs_adm (NR_SEQ_LOGIN_LOSO, DT_ACESSO_LOSO, DS_SCRIPT_LOSO, DS_ACAO_LOSO, DS_IP_LOSO) values ($nrseqlo, sysdate(), '$dsscript', '$dsacao', '$ip_user')";
	$stlog = mysql_query($strlog);
}

function PosRankingForum($idcad){
	$sqlran = "SELECT NR_SEQ_CADASTRO_MESO FROM ranking_forum";
	$stran = mysql_query($sqlran);
	$retran = 0;
	if (mysql_num_rows($stran) > 0) {
		while($rowran = mysql_fetch_row($stran)){
            $retran++;
            if ($rowran[0]==$idcad){
                break;
            }
		}
	}
	return $retran;
}

function Qtdeminima($loginm){
	$sqlmin = "SELECT NR_QTDEMINIMA_CACH FROM cadastros WHERE NR_SEQ_CADASTRO_CASO = $loginm";
	$stmin = mysql_query($sqlmin);
	$retmin = 0;
	if (mysql_num_rows($stmin) > 0) {
		$rowmin = mysql_fetch_row($stmin);
		$retmin = $rowmin[0];
	}
	return $retmin;
}
function QtdeminimaButtons($loginm){
	$sqlminb = "SELECT NR_QTDEMINBUTTONS_CACH FROM cadastros WHERE NR_SEQ_CADASTRO_CASO = $loginm";
	$stminb = mysql_query($sqlminb);
	$retminb = 0;
	if (mysql_num_rows($stminb) > 0) {
		$rowminb = mysql_fetch_row($stminb);
		$retminb = $rowminb[0];
	}
	return $retminb;
}

function PegaNome($loginm){
	$sqlmin = "SELECT DS_NOME_CASO FROM cadastros WHERE NR_SEQ_CADASTRO_CASO = $loginm";
	$stmin = mysql_query($sqlmin);
	$retnome = "";
	if (mysql_num_rows($stmin) > 0) {
		$rowmin = mysql_fetch_row($stmin);
		$retnome = $rowmin[0];
	}
	return $retnome;
}

function PegaUser($iduser){
    $sqlmin = "SELECT DS_LOGIN_USRC FROM usuarios WHERE NR_SEQ_USUARIO_USRC = $iduser";
	$stmin = mysql_query($sqlmin);
	$retuser = "";
	if (mysql_num_rows($stmin) > 0) {
		$rowmin = mysql_fetch_row($stmin);
		$retuser = $rowmin[0];
	}else{
	    $retuser = "Excluido($iduser)";
	}
	return $retuser;
}

function ChecaClub($nrcadc){
	$sqlclub = "SELECT NR_SEQ_CADASTRO_TCRC FROM tshirtclub WHERE NR_SEQ_CADASTRO_TCRC = $nrcadc and ST_CADASTRO_TCRC = 'A'";
	$stclub = mysql_query($sqlclub);
	$retclub = false;
	if (mysql_num_rows($stclub) > 0) {
		$retclub = true;
	}
	return $retclub;
}

function ChecaClubStyle($nrcadc,$dsnome){
	$sqlclub = "SELECT NR_SEQ_CADASTRO_TCRC FROM tshirtclub, cadastros WHERE NR_SEQ_CADASTRO_TCRC = NR_SEQ_CADASTRO_CASO AND NR_SEQ_CADASTRO_TCRC = $nrcadc and ST_CADASTRO_TCRC = 'A'";
	$stclub = mysql_query($sqlclub);
	$retclub = $dsnome;
	if (mysql_num_rows($stclub) > 0) {
		$retclub = "<font style=\"color: #f15626; font-size:11px; font-weight:bold;\"><img src=\"img/1staryellow.png\" title=\"Membro do Tshirt Club\" alt=\"Membro do Tshirt Club\" border=\"0\" /> $dsnome</font>";
	}
	return $retclub;
}

function Valor_Produto($iddprod, $loginc, $nrtam = 0){
    $strvlprod = "SELECT VL_PRODUTO_PRRC, NR_SEQ_TIPO_PRRC, TP_DESTAQUE_PRRC, VL_PROMO_PRRC, NR_SEQ_CATEGORIA_PRRC, ST_DESCONTO_LOJA_PRRC
                 FROM produtos WHERE NR_SEQ_PRODUTO_PRRC = $iddprod";
	$stvlp = mysql_query($strvlprod);
	$volp = 0;
	if (mysql_num_rows($stvlp) > 0) {
		$rowpr = mysql_fetch_row($stvlp);
		$vlprod = $rowpr[0];
		$protip = $rowpr[1];
        $prodes = $rowpr[2];
        $vlprom = $rowpr[3];
        $procat = $rowpr[4];
        $stdesc = $rowpr[5];
        if (!$vlprom) $vlprom = 0;
		$volp = $vlprod;
        
        //desconto para lojistas - somente para camisetas E BUTTONS por enquanto q nao estejam em promoção
		
        //$sqlvl = "SELECT NR_SEQ_TIPO_TARC FROM atacado_tipos WHERE NR_SEQ_TIPO_TARC = $protip";
        //$stvl = mysql_query($sqlvl);
        
        //aplicando desconto somente no q esta fora de promo
        //if (mysql_num_rows($stvl) > 0 && $vlprom <= 0 && $loginc) {
        if ($loginc && $stdesc == 'S') {
        //if ($loginc && ($protip == 6 || $protip == 4) && $vlprom <= 0) {
            $sqclpr = "select VL_DESCONTO_CACH from cadastros WHERE TP_CADASTRO_CACH = 1 AND NR_SEQ_CADASTRO_CASO = $loginc";
			$stclpr = mysql_query($sqclpr);
			if (mysql_num_rows($stclpr) > 0) {
				$rowclpr = mysql_fetch_row($stclpr);
			    if ($vlprom > 0){
                    $valornovo = 0;
                    $valornovo = $vlprod - ($vlprod*$rowclpr[0]/100);
			        
                    if ($valornovo < $vlprom){
                        $volp = $valornovo;
                    }else{
                        $volp = $vlprom;
                    }
			    }else{
			        $volp = $vlprod - ($vlprod*$rowclpr[0]/100);
			    }
			}
		}
        
        //aplicando desconto mesmo em cima de valor promocional
        //if (mysql_num_rows($stvl) > 0 && $loginc && $stdesc == 'S') {
//			$sqclpr = "select VL_DESCONTO_CACH from cadastros WHERE TP_CADASTRO_CACH = 1 AND NR_SEQ_CADASTRO_CASO = $loginc";
//			$stclpr = mysql_query($sqclpr);
//			if (mysql_num_rows($stclpr) > 0) {
//				$rowclpr = mysql_fetch_row($stclpr);
//				if ($vlprom > 0){
//				    $volp = $vlprom;
//				}
//                $volp = $volp - ($volp*$rowclpr[0]/100);
//			}
//		}
        
        //if ( ($loginc == 1) && $vlprom <= 0 && $protip != 9) {
//			$volp = $volp - ($volp*40/100);
//		}
        
        // fixa um valor para tamanho PP
        //if ($nrtam > 0) {
        //   if ($nrtam == 6 && $protip == 6){
        //      $volp = 14.9;
        //   }   
        //}
        
        //valor especial para um categoria especifica (para lojistas)
        //if ($loginc){
//            $sqclpr = "select TP_CADASTRO_CACH from cadastros WHERE NR_SEQ_CADASTRO_CASO = $loginc";
//			$stclpr = mysql_query($sqclpr);
//			if (mysql_num_rows($stclpr) > 0) {
//				$rowclpr = mysql_fetch_row($stclpr);
//				$tipoc = $rowclpr[0];
//                
//                //valor especifico pra tees de skate!
//                if ($procat == 112 && $protip == 6 && $tipoc == 1){
//                   $volp = 25;
//                }
//			}
//        }
	}else{
		$volp = 0;
	}
    if ($volp == 0) $volp = 9999;
	return $volp;
}

function createthumb($name,$filename,$new_w,$new_h)
{
	$system=explode(".",$name);
	if (preg_match("/jpg|jpeg|JPG|JPEG/",$system[1])){$src_img=imagecreatefromjpeg($name);}
	if (preg_match("/png|PNG/",$system[1])){$src_img=imagecreatefrompng($name);}
	if (preg_match("/gif|GIF/",$system[1])){$src_img=imagecreatefromgif($name);}
	$old_x=imageSX($src_img);
	$old_y=imageSY($src_img);
	if ($old_x > $old_y) 
	{
		$thumb_w=$new_w;
		$thumb_h=$old_y*($new_h/$old_x);
	}
	if ($old_x < $old_y) 
	{
		$thumb_w=$old_x*($new_w/$old_y);
		$thumb_h=$new_h;
	}
	if ($old_x == $old_y) 
	{
		$thumb_w=$new_w;
		$thumb_h=$new_h;
	}
	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
	if (preg_match("/png|PNG/",$system[1]))
	{
		imagepng($dst_img,$filename); 
	} else if (preg_match("/jpg|jpeg|JPG|JPEG/",$system[1])) {
		imagejpeg($dst_img,$filename,100); 
	} else {
		imagegif($dst_img,$filename); 
	}
	imagedestroy($dst_img); 
	imagedestroy($src_img); 
}

function CalculaCusto($valor,$frmpg,$parc,$loja=0){
    $retvl = 0;
    if ($valor > 0){
        if ($loja > 0){
            switch($frmpg){
                case "debitovisa":
                    $retvl = number_format($valor*2.45/100,2,".","");
                    break;
                case "debitomaster":
                    $retvl = number_format($valor*2.45/100,2,".","");
                    break;
                case "boleto":
                    $retvl = 1.9;
                    break;
                case "visa":
                    switch($parc){
                        case 1:
                            $retvl = number_format($valor*3.6/100,2,".","");
                            break;
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                            $retvl = number_format($valor*4.6/100,2,".","");
                            break;
                    }
                    break;
                case "master":
                    switch($parc){
                        case 1:
                            $retvl = number_format($valor*3.6/100,2,".","");
                            break;
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                            $retvl = number_format($valor*4.6/100,2,".","");
                            break;
                    }
                    break;
                case "mastercard":
                    switch($parc){
                        case 1:
                            $retvl = number_format($valor*3.6/100,2,".","");
                            break;
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                            $retvl = number_format($valor*4.6/100,2,".","");
                            break;
                    }
                    break;
            }
        }else{
            switch($frmpg){
                case "boleto":
                    $retvl = 1.9;
                    break;
                case "visa":
                    switch($parc){
                        case 1:
                            $retvl = number_format($valor*3.6/100,2,".","");
                            break;
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                            $retvl = number_format($valor*4.6/100,2,".","");
                            break;
                    }
                    break;
                case "mastercard":
                    switch($parc){
                        case 1:
                            $retvl = number_format($valor*3.6/100,2,".","");
                            break;
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                            $retvl = number_format($valor*4.6/100,2,".","");
                            break;
                    }
                    break;
                case "master":
                    switch($parc){
                        case 1:
                            $retvl = number_format($valor*3.6/100,2,".","");
                            break;
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                            $retvl = number_format($valor*4.6/100,2,".","");
                            break;
                    }
                    break;
                case "diners":
                    switch($parc){
                        case 1:
                            $retvl = number_format($valor*3.6/100,2,".","");
                            break;
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                            $retvl = number_format($valor*4.6/100,2,".","");
                            break;
                    }
                    break;
            }
        }
    }
    return $retvl;
}

Function Diferenca($data1, $data2="",$tipo=""){
    if($data2==""){
    $data2 = date("d/m/Y H:i:s");
    }
    
    if (strlen($data2) < 17){
        $data2 = $data2.":00";
    }
    
    if (strlen($data1) < 17){
        $data1 = $data1.":00";
    }
    
    if($tipo==""){
    $tipo = "h";
    }
    
    for($i=1;$i<=2;$i++){
    ${"dia".$i} = substr(${"data".$i},0,2);
    ${"mes".$i} = substr(${"data".$i},3,2);
    ${"ano".$i} = substr(${"data".$i},6,4);
    ${"horas".$i} = substr(${"data".$i},11,2);
    ${"minutos".$i} = substr(${"data".$i},14,2);
    ${"segundos".$i} = substr(${"data".$i},17,2);
    }
    
    $segundos = mktime($horas2,$minutos2,$segundos2,$mes2,$dia2,$ano2) - mktime($horas1,$minutos1,$segundos1,$mes1,$dia1,$ano1);
    
    switch($tipo){
        
     case "s": $difere = $segundos;    break;
     case "m": $difere = $segundos/60;    break;
     case "H": $difere = $segundos/3600;    break;
     case "h": $difere = round($segundos/3600);    break;
     case "D": $difere = $segundos/86400;    break;
     case "d": $difere = round($segundos/86400);    break;
    }
    
    return $difere;
}

function get_ip()
{
    $variables = array('REMOTE_ADDR',
                       'HTTP_X_FORWARDED_FOR',
                       'HTTP_X_FORWARDED',
                       'HTTP_FORWARDED_FOR',
                       'HTTP_FORWARDED',
                       'HTTP_X_COMING_FROM',
                       'HTTP_COMING_FROM',
                       'HTTP_CLIENT_IP');
    $return = 'Unknown';
    foreach ($variables as $variable)
    {
        if (isset($_SERVER[$variable]))
        {
            $return = $_SERVER[$variable];
            break;
        }
    }
    return $return;
}

function pegalojaadm($usuario){
    $sqlmin = "SELECT NR_SEQ_LOJA_USRC FROM usuarios WHERE NR_SEQ_USUARIO_USRC = $usuario";
	$stmin = mysql_query($sqlmin);
	$retusu = "";
	if (mysql_num_rows($stmin) > 0) {
		$rowmin = mysql_fetch_row($stmin);
		$retusu = $rowmin[0];
	}
	return $retusu;
}

function RemoveAcentos($str, $enc = "UTF-8"){
    $acentos = array(
    'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
    'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
    'C' => '/&Ccedil;/',
    'c' => '/&ccedil;/',
    'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
    'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
    'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
    'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
    'N' => '/&Ntilde;/',
    'n' => '/&ntilde;/',
    'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
    'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
    'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
    'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
    'Y' => '/&Yacute;/',
    'y' => '/&yacute;|&yuml;/',
    'a.' => '/&ordf;/',
    'o.' => '/&ordm;/',
    '' => '/&quot;|&euro;|&lt;|&gt;|&nbsp;|&acute;|&AElig;|&aelig;|&brvbar;|&cedil;|&cent;|&circ;|&copy;|&curren;|&not;/',
    '' => '/&rarr;|&larr;|&phi;|&Phi;|&piv;|&Sigma;|&sigmaf;|&infin;|&raquo;|&dagger;|&Dagger;|&Delta;|&empty;|&sect;/',
    '' => '/&frac12;|&frac14;|&frac34;|&reg;|&tilde;|&micro;|&Oslash;|&para;|&laquo;|&yen;|&Psi;|&Omega;|&omega;|&Chi;/');
    
       return preg_replace($acentos,
                           array_keys($acentos),
                           htmlentities($str,ENT_NOQUOTES, $enc));
}

function EnviaEmail($de, $para, $assunto, $conteudo){
    $sql = "select ST_BLOQUEIOMAIL_CACH from cadastros where DS_EMAIL_CASO = '$para'";
    $st2 = mysql_query($sql);
    if (mysql_num_rows($st2) > 0) {
        $row = mysql_fetch_row($st2);
        $status = $row[0];
    
        if ($status != "S"){
            if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
            elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
            else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
                           
            $headers = "MIME-Version: 1.1".$quebra_linha;
            $headers .= 'Content-Type: text/html; charset=utf-8'.$quebra_linha;
            $headers .= "From: $de".$quebra_linha;
            $headers .= "Return-Path: $de" . $quebra_linha;
            $headers .= "Reply-To: $de".$quebra_linha;
        
        	@mail($para, $assunto, $conteudo, $headers);
        }
    }
}

function EnviaEmailNovo($de, $denome, $para, $cc, $cco, $assunto, $conteudo){
    $sql = "select ST_BLOQUEIOMAIL_CACH from cadastros where DS_EMAIL_CASO = '$para'";
    $st2 = mysql_query($sql);
    if (mysql_num_rows($st2) > 0) {
        $row = mysql_fetch_row($st2);
        $status = $row[0];
    
        if ($status != "S"){
            /* Medida preventiva para evitar que outros domínios sejam remetente da sua mensagem. */
            $emailsender=$de; // Substitua essa linha pelo seu e-mail@seudominio
            
            /* Verifica qual éo sistema operacional do servidor para ajustar o cabeçalho de forma correta.  */
            if(PATH_SEPARATOR == ";") $quebra_linha = "\r\n"; //Se for Windows
            else $quebra_linha = "\n"; //Se "nÃ£o for Windows"
             
            // Passando os dados obtidos pelo formulário para as variáveis abaixo
            $nomeremetente     = $denome;

            $emailremetente    = $de;

            $emaildestinatario = $para;

            $comcopia          = $cc;
            $comcopiaoculta    = $cco;
            $assunto           = $assunto;

            $mensagem          = $conteudo;
              
            /* Montando o cabeÃ§alho da mensagem */
            $headers = "MIME-Version: 1.1" .$quebra_linha;
            $headers .= 'Content-Type: text/html; charset=utf-8' .$quebra_linha;
            // Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
            $headers .= "From: " . $emailsender.$quebra_linha;
            $headers .= "Cc: " . $comcopia . $quebra_linha;
            $headers .= "Bcc: " . $comcopiaoculta . $quebra_linha;
            $headers .= "Reply-To: " . $emailremetente . $quebra_linha;
            // Note que o e-mail do remetente será usado no campo Reply-To (Responder Para)

            $mail = new PHPMailer();
     
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
            $mail->Username = 'atendimento@reverbcity.com'; // Usuário do servidor SMTP
            $mail->Password = 'ramones@334';
            $mail->SMTPSecure = "ssl";

            $mail->Port = 465;

            $mail->From = $de; // Seu e-mail
            $mail->Sender = $de; // Seu e-mail
            $mail->FromName = $denome; //seu nome


            $mail->AddAddress($para, $paranome);
            
            if ($cc){
                $mail->AddAddress($cc);
            }
            
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8'; 
            $mail->Subject  = $assunto;
            $mail->Body = $conteudo;

            

    
              // Envia o e-mail
            $enviado = $mail->Send();
            // Limpa os destinatários e os anexos
            $mail->ClearAllRecipients();
            $mail->ClearAttachments();
             
            /* Enviando a mensagem */
            
            //É obrigatório o uso do parâmetro -r (concatenação do "From na linha de envio"), aqui na Locaweb:
            
            // if(!mail($emaildestinatario, $assunto, $mensagem, $headers ,$emailsender)){ // Se for Postfix
            //     $headers .= "Return-Path: " . $emailsender . $quebra_linha; // Se "não for Postfix"
            //     mail($emaildestinatario, $assunto, $mensagem, $headers );
            // }
        }
    }
}

function EnviaMailer($de, $denome, $para, $paranome, $cc, $assunto, $conteudo){
    $sql = "select ST_BLOQUEIOMAIL_CACH from cadastros where DS_EMAIL_CASO = '$para'";
    $st2 = mysql_query($sql);
    if (mysql_num_rows($st2) > 0) {
        $row = mysql_fetch_row($st2);
        $status = $row[0];
    
        if ($status != "S"){
            $mail = new PHPMailer();
     
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
            $mail->Username = 'desenvolvimento@reverbcity.com'; // Usuário do servidor SMTP
            $mail->Password = 'sebadoh90';
            $mail->SMTPSecure = "ssl";
            $mail->AddReplyTo('atedimento@reverbcity.com', 'Atendimento Reverbcity');

            $mail->Port = 465;

            $mail->From = $de; // Seu e-mail
            $mail->Sender = $de; // Seu e-mail
            $mail->FromName = $denome; //seu nome

            $mail->AddAddress($para, $paranome);
            
            if ($cc){
                $mail->AddAddress($cc);
            }
            
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8'; 
            $mail->Subject  = $assunto;
            $mail->Body = $conteudo;

            

    
              // Envia o e-mail
            $enviado = $mail->Send();
            // Limpa os destinatários e os anexos
            $mail->ClearAllRecipients();
            $mail->ClearAttachments();
        }
    }
}

function EnviaSMS($logadm,$idcad,$celular,$msg){
    //$UserID = "1272f816-5d88-46d2-b940-f180d0e1f4e8";
    //$Token = "52842487";
    
    // $sqlsmss = "select ST_ENVIOSMS_CACH from cadastros where NR_SEQ_CADASTRO_CASO = $idcad";
    // $st2smsss = mysql_query($sqlsmss);
    // if (mysql_num_rows($st2smsss) > 0) {
    //     $rowsmss = mysql_fetch_row($st2smsss);
    //     $statussmss = $rowsmss[0];
    
    //     if ($statussmss == "S"){
            if (substr($celular,0,2) == "11" && strlen($celular)==10){
                $celular = substr($celular,0,2)."9".substr($celular,2,strlen($celular)-2);
            }
        
            //$url = "http://www.misterpostman.com.br/gateway.aspx";
            
            $msg = str_replace("&","e",$msg);
            
            $str = "INSERT INTO sms_envios (NR_SEQ_USUARIO_SMRC, NR_SEQ_CLIENTE_SMRC, DS_CELULAR_SMRC, DS_MSG_SMRC, DT_ENVIO_SMRC)
                    values ($logadm, $idcad, '$celular', '$msg', sysdate())";
            $st = mysql_query($str);
            
            $msgid = mysql_insert_id();
            
            $url = "http://193.105.74.59/api/sendsms/plain?user=rbcity&password=rbcity123&sender=Reverbcity&GSM=55$celular&SMStext=".urlencode($msg);
            
            $ch = curl_init();
            
            $msg = URLEncode($msg); 
            curl_setopt($ch, CURLOPT_URL,$url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            //curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, "UserID=".$UserID."&Token=".$Token."&NroDestino=".$celular."&Mensagem=".$msg."&Remetente=Reverbcity");
            curl_setopt($ch, CURLOPT_FAILONERROR, 0);
            
            $resultbusca = curl_exec($ch);
            curl_close($ch);
            
            $resultbusca = trim($resultbusca);
            
            $str = "UPDATE sms_envios SET DS_RETORNO_SMRC = '$resultbusca' where NR_SEQ_SMSENVIO_SMRC = $msgid";
            $st = mysql_query($str);
            
            if (trim($resultbusca) > 0){
            //if (trim($resultbusca) == "OK"){
                $strsms = "INSERT INTO sms_controle (NR_SEQ_SMS_CSRC, DS_DESCRICAO_CSRC, NR_QTDE_CSRC, DT_LANCTO_CRSC) 
                        VALUES (".$msgid.", 'Envio de SMS', -1, sysdate())";
                $stsmss = mysql_query($strsms);
            }
    //     }
    // }
}

function DateAdd($interval) {

 $curdate = getdate();
 $cday = $curdate['mday']+$interval;
 $cmonth = $curdate['mon'];
 $cyear = $curdate['year'];

  if ($cday > 30){
    $cmonth = $cmonth + 1;
    $cday = $cday - 30;

  if ($cmonth == 13){
     $cyear = $cyear + 1;
     $cmonth = 1;
  }

 }

  $ourDate = array($cyear,$cmonth,$cday);

  return $ourDate;

}

function dateAdd_dias($data_,$dias_){
	if(strstr($data_, "/")){
		$vetData 	=	explode ("/", $data_);
		$dataFinal	=	mktime(0,0,0,$vetData[1],$vetData[0]+$dias_,$vetData[2]);
		return date("d/m/Y", $dataFinal);
	}else{
		return $data_;
	}
}

function validaCPF($cpf)
{	// Verifiva se o número digitado contém todos os digitos
    $cpf = str_pad(preg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
	
	// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
	{
	return false;
    }
	else
	{   // Calcula os números para verificar se o CPF é verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }
}

function formatCPFCNPJ ($string)
{
	$output = preg_replace("[' '-./ t]", '', $string);
	$size = (strlen($output) -2);
	if ($size != 9 && $size != 12) return false;
	$mask = ($size == 9) 
		? '###.###.###-##' 
		: '##.###.###/####-##'; 
	$index = -1;
	for ($i=0; $i < strlen($mask); $i++):
		if ($mask[$i]=='#') $mask[$i] = $output[++$index];
	endfor;
	return $mask;
}

function verificaCNPJ($cnpj) { 
    if (strlen($cnpj) <> 18) return 0; 
    $soma1 = ($cnpj[0] * 5) + 

    ($cnpj[1] * 4) + 
    ($cnpj[3] * 3) + 
    ($cnpj[4] * 2) + 
    ($cnpj[5] * 9) + 
    ($cnpj[7] * 8) + 
    ($cnpj[8] * 7) + 
    ($cnpj[9] * 6) + 
    ($cnpj[11] * 5) + 
    ($cnpj[12] * 4) + 
    ($cnpj[13] * 3) + 
    ($cnpj[14] * 2); 
    $resto = $soma1 % 11; 
    $digito1 = $resto < 2 ? 0 : 11 - $resto; 
    $soma2 = ($cnpj[0] * 6) + 

    ($cnpj[1] * 5) + 
    ($cnpj[3] * 4) + 
    ($cnpj[4] * 3) + 
    ($cnpj[5] * 2) + 
    ($cnpj[7] * 9) + 
    ($cnpj[8] * 8) + 
    ($cnpj[9] * 7) + 
    ($cnpj[11] * 6) + 
    ($cnpj[12] * 5) + 
    ($cnpj[13] * 4) + 
    ($cnpj[14] * 3) + 
    ($cnpj[16] * 2); 
    $resto = $soma2 % 11; 
    $digito2 = $resto < 2 ? 0 : 11 - $resto; 
    return (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2)); 
}

function trataup($palavs){
    $palavs = strtr($palavs, "áàãâéêíóôõúüç","ÁÀÃÂÉÊÍÓÔÕÚÜÇ");
    return $palavs;
}

function VerificaExtraAnt($func){
    $retorna = array();
    $dia1 = 86400;
    $achou = false;
    $xyx = 1;
    while(!$achou && $xyx<=5){
        $str = "select DS_FUNCIONARIO_FURC, NR_HORAS_SEG_FURC, NR_HORAS_TER_FURC, NR_HORAS_QUA_FURC, 
                       NR_HORAS_QUI_FURC, NR_HORAS_SEX_FURC, NR_HORAS_SAB_FURC, NR_HORAS_DOM_FURC, VL_SALARIO_FURC,
                       HR_ENTRADA1_FURC, HR_SAIDA1_FURC, HR_ENTRADA2_FURC, HR_SAIDA2_FURC
                from funcionarios WHERE NR_SEQ_FUNCIONARIO_FURC = $func";
        $st = mysql_query($str);
        if (mysql_num_rows($st) > 0) {
        	$row = mysql_fetch_row($st);
        	$nome	   	= $row[0];
            $horas_seg  = $row[1];
            $horas_ter  = $row[2];
            $horas_qua  = $row[3];
            $horas_qui  = $row[4];
            $horas_sex  = $row[5];
            $horas_sab  = $row[6];
            $horas_dom  = $row[7];
            $salario    = $row[8];
            $hr_entr1   = $row[9]; 
            $hr_said1   = $row[10];
            $hr_entr2   = $row[11];
            $hr_said2   = $row[12];
        }else{
            exit();
        }
        
        $temexcecao = false;
        
        $ano = date("Y", time() - $dia1);
        $mes = date("m", time() - $dia1);
        $f = date("d", time() - $dia1);
        
        $saldototal = 0;
        $saldototalcarga = 0;
        $mk_total_atr = 0;
        $mk_total_ext = 0;
        $mk_total = 0;
        
        $sql3 = "SELECT DS_TEMPO_PERC, NR_TIPO_OCORR_PERC from funcionarios_ponto_exc WHERE NR_SEQ_FUNCIONARIO_PERC = $func AND DT_EXCESSAO_PERC = '".$ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($f,2,"0",STR_PAD_LEFT)."'";
        $st3 = mysql_query($sql3);
        if (mysql_num_rows($st3) > 0) {
            $temexcecao = true;
            $row3 = mysql_fetch_row($st3);
            $horas  = $row3[0];
            $tipoex  = $row3[1];
        }
        
        $str = "select DT_REGISTRO_FRRC from funcionarios_ponto WHERE NR_SEQ_FUNCIONARIO_FRRC = $func
                AND (DAY(DT_REGISTRO_FRRC) = $f AND MONTH(DT_REGISTRO_FRRC) = $mes and YEAR(DT_REGISTRO_FRRC) = $ano) order by DT_REGISTRO_FRRC";
        $st = mysql_query($str);
        if (mysql_num_rows($st) > 0) {
            $x = 0;
            $soma = 0;
            $str_batidas = "";
            $saldo1 = 0;
            $saldo2 = 0;
            $calc_tole = 0;
            $mk_extras = 0;
            $mk_atrasos = 0;                                                                                                            
        	while($row = mysql_fetch_row($st)) {
        	    $batida	   	= $row[0];
                
                switch($x){
                    case 0:
                        $batida1 = $batida;
                        $hr = date("H",strtotime($batida));
                        $mi = date("i",strtotime($batida));
                        $se = date("s",strtotime($batida));
                        $mkbatida = mktime($hr,$mi,$se);
                        
                        $hr = date("H",strtotime($hr_entr1));
                        $mi = date("i",strtotime($hr_entr1));
                        $se = date("s",strtotime($hr_entr1));
                        $mkponto = mktime($hr,$mi,$se);
                                                                                                                                                                                                                                                                                                                                                                        
                        $calc_tole = $mkponto - $mkbatida;
                        if ($calc_tole >= 0){
                            $mk_extras += $calc_tole;
                        }else{
                            $mk_atrasos += $calc_tole;
                        }                                                   
                                                                      
                        break;
                    case 1:
                        $batida2 = $batida;
                        $saldo1 = Diferenca($batida1,$batida2,"s");
                        
                        $hr = date("H",strtotime($batida));
                        $mi = date("i",strtotime($batida));
                        $se = date("s",strtotime($batida));
                        $mkbatida = mktime($hr,$mi,$se);
                        
                        $hr = date("H",strtotime($hr_said1));
                        $mi = date("i",strtotime($hr_said1));
                        $se = date("s",strtotime($hr_said1));
                        $mkponto = mktime($hr,$mi,$se);
                                                                                                                                                                                                                                                                                                                                                                        
                        $calc_tole = $mkbatida - $mkponto;
                        if ($calc_tole >= 0){
                            $mk_extras += $calc_tole;
                        }else{
                            $mk_atrasos += $calc_tole;
                        }
                        
                        break;
                    case 2:
                        $batida3 = $batida;
                        $hr = date("H",strtotime($batida));
                        $mi = date("i",strtotime($batida));
                        $se = date("s",strtotime($batida));
                        $mkbatida = mktime($hr,$mi,$se);
                        
                        $hr = date("H",strtotime($hr_entr2));
                        $mi = date("i",strtotime($hr_entr2));
                        $se = date("s",strtotime($hr_entr2));
                        $mkponto = mktime($hr,$mi,$se);
                                                                                                                                                                                                                                                                                                                                                                        
                        $calc_tole = $mkponto - $mkbatida;
                        if ($calc_tole >= 0){
                            $mk_extras += $calc_tole;
                        }else{
                            $mk_atrasos += $calc_tole;
                        }
                        
                        break;
                    case 3:
                        $batida4 = $batida;
                        $saldo2 = Diferenca($batida3,$batida4,"s");
                        
                        $hr = date("H",strtotime($batida));
                        $mi = date("i",strtotime($batida));
                        $se = date("s",strtotime($batida));
                        $mkbatida = mktime($hr,$mi,$se);
                        
                        $hr = date("H",strtotime($hr_said2));
                        $mi = date("i",strtotime($hr_said2));
                        $se = date("s",strtotime($hr_said2));
                        $mkponto = mktime($hr,$mi,$se);
                                                                                                                                                                                                                                                                                                                                                                        
                        $calc_tole = $mkbatida - $mkponto;
                        if ($calc_tole >= 0){
                            $mk_extras += $calc_tole;
                        }else{
                            $mk_atrasos += $calc_tole;
                        }
                        break;
                }
                $x++;
        	}
            
            $saldototal += ($saldo1+$saldo2);
            
            $saldoextra = 0;
            $exibecarga = "";
            switch(date('w',strtotime($batida))){
                case 0:
                    $exibecarga = $horas_dom;
                    break;
                case 1:
                    $exibecarga = $horas_seg;
                    break;
                case 2:
                    $exibecarga = $horas_ter;
                    break;
                case 3:
                    $exibecarga = $horas_qua;
                    break;
                case 4:
                    $exibecarga = $horas_qui;
                    break;
                case 5:
                    $exibecarga = $horas_sex;
                    break;
                case 6:
                    $exibecarga = $horas_sab;
                    break;
            }
            
            if ($x == 2){
                $mk_extras = 0;
                $mk_atrasos = 0;
                
                $horasdevidas = time_to_sec($exibecarga);
                $horasfeitas = $saldo1+$saldo2;
                
                if ($horasfeitas > $horasdevidas){
                    $mk_extras += ($horasfeitas-$horasdevidas);
                }else{
                    $mk_atrasos += ($horasdevidas-$horasfeitas)*-1;
                }   
            }
            
            $exibe_mk = 0;
            $mk_atrasos_inv = $mk_atrasos*-1;
            if ($mk_extras > 600 && $mk_atrasos_inv > 600 && $exibecarga){
                $mk_total = $mk_total + ($mk_extras-$mk_atrasos_inv);
                $exibe_mk = $exibe_mk + ($mk_extras-$mk_atrasos_inv);
                if ($mk_extras-$mk_atrasos_inv >= 0){
                    $mk_total_ext += $mk_extras-$mk_atrasos_inv;
                }else{
                    $mk_total_atr += $mk_atrasos_inv - $mk_extras;
                }
            }else if ($mk_extras > 600 && $mk_atrasos_inv <= 600 && $exibecarga){
                $mk_total = $mk_total + $mk_extras;
                $exibe_mk = $exibe_mk + $mk_extras;
                $mk_total_ext += $mk_extras;
            }else if ($mk_extras <= 600 && $mk_atrasos_inv > 600 && $exibecarga){
                $mk_total = $mk_total - $mk_atrasos_inv;
                $exibe_mk = $exibe_mk - $mk_atrasos_inv;
                $mk_total_atr += $mk_atrasos_inv;
            }
            
            if (!$exibecarga){
                $mk_total += ($saldo1+$saldo2);  
                $mk_total_ext += ($saldo1+$saldo2);
            }
            
            if ($exibecarga){
                $mk_atrasos = sec_to_time($mk_atrasos*-1);
                $mk_extras  = sec_to_time($mk_extras);
            }
            
            $horasdevidas = time_to_sec($exibecarga);
            if ($temexcecao){
                $horastot = time_to_sec($horas);                                            
                $horasdevidas = $horasdevidas - $horastot;
            }
            $saldototalcarga += $horasdevidas;
            $horasfeitas = $saldo1+$saldo2;
            if ($horasfeitas > $horasdevidas){
                $sql3 = "SELECT * from funcionarios_ponto_aut WHERE NR_SEQ_FUNCIONARIO_EARC = $func AND DT_AUTORIZADA_EARC = '".$ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($f,2,"0",STR_PAD_LEFT)."'";
                $st3 = mysql_query($sql3);
                if (mysql_num_rows($st3) <= 0) {
                    $saldototal -= ($horasfeitas - $horasdevidas);
                }
            }
        }else{
            $montabatida = $ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($f,2,"0",STR_PAD_LEFT);
            switch(date('w',strtotime($montabatida))){
                case 0:
                    $exibecarga = $horas_dom;
                    break;
                case 1:
                    $exibecarga = $horas_seg;
                    break;
                case 2:
                    $exibecarga = $horas_ter;
                    break;
                case 3:
                    $exibecarga = $horas_qua;
                    break;
                case 4:
                    $exibecarga = $horas_qui;
                    break;
                case 5:
                    $exibecarga = $horas_sex;
                    break;
                case 6:
                    $exibecarga = $horas_sab;
                    break;
            }
            if ($exibecarga){
                $mk_total -= time_to_sec($exibecarga);       
                $mk_total_atr += time_to_sec($exibecarga);
                
                $horasdevidas = time_to_sec($exibecarga);
                if ($temexcecao && $tipoex == 0){
                    $horastot = time_to_sec($horas);                                                                  
                    $horasdevidas = $horasdevidas - $horastot;
                }
                
                if ($tipoex == 0) {
                    $saldototalcarga += $horasdevidas;
                }      
            }
        }
        
        if ($temexcecao && $tipoex == 0){
            $mk_total += $horastot;
            $mk_total_ext += $horastot;
        }
        
        $retorna[1] = "";
        $retorna[2] = "";
        
        if (!$saldo1 && !$saldo2){
            //echo "sem batida";
        }else{
            if ($mk_total_ext > 0){
                //echo "$f/$mes/$ano - <font color=blue>".sec_to_time($mk_total_ext)."</font>";
                $retorna[0] = true;
                $retorna[1] = "$ano-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($f,2,"0",STR_PAD_LEFT);
                $retorna[2] = $mk_total_ext;
            }else{
                $retorna[0] = false;
            }
            $achou = true;
        }
        $dia1 = $dia1 + 86400;
        $xyx++;
    }
    
    return $retorna;
}

function time_to_sec($time) {
    if (strlen($time)==5) $time.=":00";
    $hours = substr($time, 0, -6);
    $minutes = substr($time, -5, 2);
    $seconds = substr($time, -2);
    
    return $hours * 3600 + $minutes * 60 + $seconds;
}

function sec_to_time($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor($seconds % 3600 / 60);
    $seconds = $seconds % 60;
    
    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
}

function m2h($minutos) {
    $seconds = $minutos;

    $hours = floor($seconds / 3600);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    
    if (strlen($hours)==1) $hours = "0".$hours;
    if (strlen($minutes)==1) $minutes = "0".$minutes;
    if (strlen($seconds)==1) $seconds = "0".$seconds;
 
    return "$hours:$minutes:$seconds";
} 

function IncluiPapelCarta($tipo, $texto, $assunto=""){
     $topomail='<table align="center"><tr><td>
            <table width="600" border="0" cellpadding="0" cellspacing="0">
                <tr><td colspan="2" height="4"><img src="http://www.reverbcity.com/imgrast/line1.gif" width="600" height="4" /></td></tr>
                <tr>
                    <td align="left" height="75"><a href="http://www.reverbcity.com"><img border="0" src="http://www.reverbcity.com/imgrast/logo.gif" width="235" height="75" /></a></td>
                    <td align="right" height="75">
                        <table width="150" cellpadding="0" cellspacing="0" height="25" border="0">
                            <tr>
                                <td><a href="http://instagram.com/reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/rss.gif" width="26" height="25" /></a></td>
                                <td><a href="https://www.facebook.com/Reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/fb.gif" width="26" height="25" /></a></td>
                                <td><a href="https://twitter.com/reverbcity"><img border="0" src="http://www.reverbcity.com/imgrast/twi.gif" width="26" height="25" /></a></td>
                                <td><a href="http://pinterest.com/reverbcity/pins/"><img border="0" src="http://www.reverbcity.com/imgrast/pin.gif" width="26" height="25" /></a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td colspan="2" height="5"><img src="http://www.reverbcity.com/imgrast/line2.gif" width="600" height="5" /></td></tr>
            </table>';
     switch($tipo){
         case "rast":
            $cpomail='
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr><td>
                    <div style="background-color: #646464; padding: 8px 15px 8px 15px; font-family:Verdana;font-size:12px;color: #c2c3c4; width: 570px; margin-top: 15px;">
                            '.utf8_encode("A MÚSICA QUE VESTE ESTÁ CHEGANDO NA SUA CASA").'
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                '.$texto.'
                <table  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_19.png" width="598" height="104" alt=""></td>
                    </tr>
                    <tr>
                        <td><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="170" height="28" alt=""></td>
                        <td><a href="mailto:atendimento@reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="271" height="28" alt=""></a></td>
                        <td><a href="http://www.reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="159" height="28" alt=""></a></td>
                    </tr>
                </table>';
            break;
         case "niver":
            $cpomail='
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr><td>
                    <div style="background-color: #646464; padding: 8px 15px 8px 15px; font-family:Verdana;font-size:12px;color: #c2c3c4; width: 570px; margin-top: 15px;">
                            '.utf8_encode("PRESENTE DE ANIVERSÁRIO DA REVERBCITY!").'
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                '.$texto.'
                <table  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_19.png" width="598" height="104" alt=""></td>
                    </tr>
                    <tr>
                        <td><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="170" height="28" alt=""></td>
                        <td><a href="mailto:atendimento@reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="271" height="28" alt=""></a></td>
                        <td><a href="http://www.reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="159" height="28" alt=""></a></td>
                    </tr>
                </table>';
            break;
         case "novocad":
            $cpomail='
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr><td>
                    <div style="background-color: #646464; padding: 8px 15px 8px 15px; font-family:Verdana;font-size:12px;color: #c2c3c4; width: 570px; margin-top: 15px;">
                            UM PRESENTE DE BOAS-VINDAS!
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                '.$texto.'
                <a href="mailto:atendimento@reverbcity.com"><img src="http://www.reverbcity.com/imgrast/rodape_padrao.gif" border="0" /></a>
                </td></tr></table>';
            break;
         case "ultdias":
            $cpomail='
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr><td>
                    <div style="background-color: #646464; padding: 8px 15px 8px 15px; font-family:Verdana;font-size:12px;color: #c2c3c4; width: 570px; margin-top: 15px;">
                            UM PRESENTE DE BOAS-VINDAS!
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                '.$texto.'
                <table  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_19.png" width="598" height="104" alt=""></td>
                    </tr>
                    <tr>
                        <td><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="170" height="28" alt=""></td>
                        <td><a href="mailto:atendimento@reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="271" height="28" alt=""></a></td>
                        <td><a href="http://www.reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="159" height="28" alt=""></a></td>
                    </tr>
                </table>';
            break;
         case "confpgto":
            $cpomail='
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr><td>
                    <div style="background-color: #646464; padding: 8px 15px 8px 15px; font-family:Verdana;font-size:12px;color: #c2c3c4; width: 570px; margin-top: 15px;">
                            '.utf8_encode("CONFIRMAÇÃO DE PAGAMENTO REVERBCITY").'
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                '.$texto.'
                <table  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_19.png" width="598" height="104" alt=""></td>
                    </tr>
                    <tr>
                        <td><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="170" height="28" alt=""></td>
                        <td><a href="mailto:atendimento@reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="271" height="28" alt=""></a></td>
                        <td><a href="http://www.reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="159" height="28" alt=""></a></td>
                    </tr>
                </table>';
            break;
         case "codigorast":
            $cpomail='
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr><td>
                    <div style="background-color: #646464; padding: 8px 15px 8px 15px; font-family:Verdana;font-size:12px;color: #c2c3c4; width: 570px; margin-top: 15px;">
                            '.utf8_encode("CONFIRMAÇÃO DE ENVIO").'
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                '.$texto.'
                <table  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_19.png" width="598" height="104" alt=""></td>
                    </tr>
                    <tr>
                        <td><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="170" height="28" alt=""></td>
                        <td><a href="mailto:atendimento@reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="271" height="28" alt=""></a></td>
                        <td><a href="http://www.reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="159" height="28" alt=""></a></td>
                    </tr>
                </table>';
            break;
         case "compranao":
            $cpomail='
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr><td>
                    <div style="background-color: #646464; padding: 8px 15px 8px 15px; font-family:Verdana;font-size:12px;color: #c2c3c4; width: 570px; margin-top: 15px;">
                                NOVO PRAZO PARA PAGAMENTO
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                '.$texto.'
                <table  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_19.png" width="598" height="104" alt=""></td>
                    </tr>
                    <tr>
                        <td><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="170" height="28" alt=""></td>
                        <td><a href="mailto:atendimento@reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="271" height="28" alt=""></a></td>
                        <td><a href="http://www.reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="159" height="28" alt=""></a></td>
                    </tr>
                </table>';
            break;
         case "valepres":
            $cpomail='
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr><td>
                    <div style="background-color: #646464; padding: 8px 15px 8px 15px; font-family:Verdana;font-size:12px;color: #c2c3c4; width: 570px; margin-top: 15px;">
                         '.utf8_encode("VOCÊ ACABA DE GANHAR UM VALE PRESENTE NA REVERBCITY!").'
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                '.$texto.'
                <table  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_19.png" width="598" height="104" alt=""></td>
                    </tr>
                    <tr>
                        <td><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="170" height="28" alt=""></td>
                        <td><a href="mailto:atendimento@reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="271" height="28" alt=""></a></td>
                        <td><a href="http://www.reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="159" height="28" alt=""></a></td>
                    </tr>
                </table>';
            break;
         case "padrao":
            $cpomail='
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr><td>
                    <div style="background-color: #646464; padding: 8px 15px 8px 15px; font-family:Verdana;font-size:12px;color: #c2c3c4; width: 570px; margin-top: 15px;">
                         '.$assunto.'
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                '.$texto.'
                <table  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_19.png" width="598" height="104" alt=""></td>
                    </tr>
                    <tr>
                        <td><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="170" height="28" alt=""></td>
                        <td><a href="mailto:atendimento@reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="271" height="28" alt=""></a></td>
                        <td><a href="http://www.reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="159" height="28" alt=""></a></td>
                    </tr>
                </table>';
            break;
         case "sistema":
            $cpomail='
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr><td>
                    <div style="background-color: #646464; padding: 8px 15px 8px 15px; font-family:Verdana;font-size:12px;color: #c2c3c4; width: 570px; margin-top: 15px;">
                         '.$assunto.'
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                '.$texto.'
                <table  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_19.png" width="598" height="104" alt=""></td>
                    </tr>
                    <tr>
                        <td><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="170" height="28" alt=""></td>
                        <td><a href="mailto:atendimento@reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="271" height="28" alt=""></a></td>
                        <td><a href="http://www.reverbcity.com"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="159" height="28" alt=""></a></td>
                    </tr>
                </table>';
            break;
         case "aviseme":
            $cpomail='
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr><td>
                    <div style="background-color: #646464; padding: 8px 15px 8px 15px; font-family:Verdana;font-size:12px;color: #c2c3c4; width: 570px; margin-top: 15px;">
                         VOCE PEDIU E OLHA QUEM VOLTOU
                    </div>
                    </td></tr>
                    <tr><td><img src="http://www.reverbcity.com/imgrast/div.gif" width="598" height="40" /></td></tr>
                </table>
                '.$texto.'
                <table  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3"><img src="http://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_19.png" width="598" height="104" alt=""></td>
                    </tr>
                    <tr>
                        <td><img src="https://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_20.png" width="170" height="28" alt=""></td>
                        <td><a href="mailto:atendimento@reverbcity.com"><img src="https://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_21.png" width="271" height="28" alt=""></a></td>
                        <td><a href="https://www.reverbcity.com"><img src="https://reverbcity.com/arquivos/emails/indicacao/12---mail_avise-me-2_22.png" width="159" height="28" alt=""></a></td>
                    </tr>
                </table>';
            break;
     }
     
     return $topomail.$cpomail;                          
}
?>
<?php include 'auth.php'; ?>
<?php include 'lib.php'; ?>
<?php
$id_spam = request("id_spam");
$nome    = request("nome");

$msg = "Enviando Mailing";

if (!request("total")){
	$total = 0;
}else{
	$total = request("total");
}

$sql = "select IdAssinante, Email, 'A' from Assinante where ST_SPAM_CACH = 'E' union select NR_SEQ_CADASTRO_CASO, DS_EMAIL_CASO, 'C' from cadastros where ST_SPAM_CACH = 'E'";
$st = mysql_query($sql);

if (mysql_num_rows($st) == 0) {
	Header("Location: adminSpam_env3.php?msg=$msg&id_spam=$id_spam");
	exit();
}else{
	$sql2 = "select ds_descricao, ds_conteudo from spam where id_spam = $id_spam";
	$st2 = mysql_query($sql2);
	
	$row2 = mysql_fetch_row($st2);
	$ds_descricao  = $row2[0];
	$ds_conteudo   = $row2[1];
    
    if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
    elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
    else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
     
    $nomeremetente     = "Reverbcity";
    $emailremetente    = "atendimento@reverbcity.com";
    $emaildestinatario = $email;
    
    $subject  = "$ds_descricao";
    $headers = "MIME-Version: 1.1".$quebra_linha;
    $headers .= "Content-type: text/html; charset=utf-8".$quebra_linha;
    $headers .= "From: ".$emailremetente.$quebra_linha;
    $headers .= "Return-Path: " . $emailremetente . $quebra_linha;
    $headers .= "Reply-To: ".$emailremetente.$quebra_linha;
	
	$msgemail = $ds_conteudo;
	$msgemail = str_replace("\r","",$msgemail);
	$msgemail = str_replace("\n","",$msgemail);
	
	$x = 0;
    $emails = "";
	while($row = mysql_fetch_row($st)) {
		$nrseqcad	   = $row[0];
		$dsemail	   = strtolower($row[1]);
		$tipo		   = $row[2];
        
        $emails .= $dsemail."<br />";
        
        EnviaMailer("atendimento@reverbcity.com","Reverbcity",$dsemail,$dsemail,"",$subject,$msgemail);
		//@mail($dsemail, $subject, $msgemail, $headers);
		if ($tipo == "C") {
			$str3 = "update cadastros set ST_SPAM_CACH = 'S' where NR_SEQ_CADASTRO_CASO = $nrseqcad";
			$st3 = mysql_query($str3);
		}else{
			$str3 = "update Assinante set ST_SPAM_CACH = 'S' where IdAssinante = $nrseqcad";
			$st3 = mysql_query($str3);
		}
		
		$x++;
		if ($x == 120) break;
		
	}
	$total += $x;
	
	if ($x < 120){
		$msg = str_replace(" ","%20",$msg);
		Header("Location: adminSpam_env3.php?msg=$msg&id_spam=$id_spam");
		exit();
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="300;url=adminSpam_env2.php?id_spam=<?php echo $id_spam;?>&nome=<?php echo $nome;?>&total=<?php echo $total;?>">

<title>Reverb City Adm</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #FFFFFF;
}
-->
</style>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="scripts/abas.js"></script>
<link href="css/aba.css" media="all" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript" src="scripts/scriptaculous.js?load=effects"></script>

<link rel="stylesheet" type="text/css" href="scripts/prototip/prototip.css" />
<script type="text/javascript" src="scripts/prototip/prototip.js"></script>

<link rel="stylesheet" type="text/css" href="scripts/lightview/css/lightview.css" />
<script type="text/javascript" src="scripts/lightview/js/lightview2.js"></script>
</head>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#361a0f"><img src="img/logo.gif" /></td>
  </tr>
  <tr>
    <td height="70">
    	<?php include 'menu_princ.php'; ?>
    </td>
  </tr>
  <tr>
  	<td>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Newsletter</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaCriar" class="abaativa">Enviando Newsletter</li>
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='newsletter.php'">Newsletters Cadastrados</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">

                    <div id="Criar">
                    	 
                     <table align="center" class="corpo">
                        <tr>
                            <td align="center"><b><font color="#FF0000"><b>DISPARANDO NEWSLETTER - <?php echo $nome;?></font></b><br><br></td>
                        </tr>
                        <tr>
                            <td align="center"><?php echo $msg;?></td>
                        </tr>
                        <tr>
                            <td align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="titulo_categoria_red" align="center"><b>TOTAL JA ENVIADOS: <?php echo $total;?></b></td>
                        </tr>
                    </table>
                    <center>
                    <br>
                    <font class="corpo">
                    <b>ATENCAO:</b> Serao enviados 120 emails a cada 5 minutos. Aguarde a mensagem<br>
                    de Aviso de Finalizacao do envio para fechar o navegador!! Este processo existe para nao<br>
                    sobrecarregar os servidores de e-mails do provedor.
                    <br>
                    <br>
                    <a href="newsletter.php">Clique Aqui para Cancelar o Envio</a>
                    <br />
                    <br />
                    Enviado para:<br />
                    <?php echo $emails ?>
                    </font>
                    </center>
                    <br>
                    
                    </div> <!-- /criar -->

                    <script>
                      defineAba("abaCriar","Criar");
					  defineAbaAtiva("abaCriar");
                    </script>
                                    
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>
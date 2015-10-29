<?php
include '../adm/lib.php';

$idp = request("idp");
$assunto = request("titulo");
$corpo = request("FCKeditor1");

$corpo = str_replace("src=\"/images/","src=\"http://www.reverbcity.com/images/",$corpo);
$corpo = str_replace("src=/images/","src=http://www.reverbcity.com/images/",$corpo);

$emailsender='contato@reverbcity.com'; // Substitua essa linha pelo seu e-mail@seudominio

if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
 
$nomeremetente     = "Reverbcity";
$emailremetente    = "contato@reverbcity.com";
$emaildestinatario = $email;

$headers = "MIME-Version: 1.1".$quebra_linha;
$headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
$headers .= "From: ".$emailsender.$quebra_linha;
$headers .= "Return-Path: " . $emailsender . $quebra_linha;
$headers .= "Reply-To: ".$emailremetente.$quebra_linha;

$sql = "SELECT DS_EMAIL_CASO from cadastros, compras, cestas
     where NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO and NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
     and ST_COMPRA_COSO IN ('E','V','P') AND NR_SEQ_PRODUTO_CESO = $idp GROUP BY NR_SEQ_CADASTRO_CASO
     order by DS_NOME_CASO";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $ds_email = $row[0];                            
        @mail($ds_email, $assunto, $corpo, $headers);
    }
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou emails para compradores do produto $idp");
?>
<script language="JavaScript">
   alert('Emails enviados com Sucesso!');
   window.location.href=('clientes_produto.php?idp=<?php echo $idp ?>');
</script>
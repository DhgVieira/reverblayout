<?php
include 'auth.php';
include 'lib.php';

$assunto = request("titulo");
$corpo = request("FCKeditor1");

$corpo = str_replace("src=\"/images/","src=\"http://www.reverbcity.com/images/",$corpo);
$corpo = str_replace("src=/images/","src=http://www.reverbcity.com/images/",$corpo);

$emailsender='desenvolvimento@reverbcity.com'; // Substitua essa linha pelo seu e-mail@seudominio

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

$sql = "select DS_EMAIL_CASO, DS_NOME_CASO, ST_BLOQUEIOMAIL_CACH, (SELECT 
                                                DATE_FORMAT(MAX(dt_compra_coso), '%Y-%m-%d')
                                            FROM
                                                compras c
                                            WHERE
                                                c.NR_SEQ_CADASTRO_COSO = cadastros.NR_SEQ_CADASTRO_CASO
                                                    AND c.ST_COMPRA_COSO <> 'C') as ultima_compra from cadastros WHERE NR_SEQ_LOJA_CASO = $SS_loja AND day(sysdate()) = day(DT_NASCIMENTO_CASO) and month(sysdate()) = month(DT_NASCIMENTO_CASO) and TP_CADASTRO_CACH <> 1 having date_format(ultima_compra, '%Y-%m') < date_format(now(), '%Y-%m') order by DS_NOME_CASO";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $ds_email = $row[0];
        $ds_nome = $row[1];
        $stbloq  = $row[2];
        if (strpos($ds_nome," ") > 0){
        	$ds_nome = substr($ds_nome,0,strpos($ds_nome," "));
        }
        $corpo2 = str_replace("##nome##",$ds_nome,$corpo); 
        //echo $corpo2."<br />";                   
        if ($stbloq == "N") @mail($ds_email, $assunto, $corpo2, $headers);
    }
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou emails para todos aniversariantes do dia");
?>
<script language="JavaScript">
   alert('Emails enviados com Sucesso!');
   window.location.href=('index.php');
</script>
<?php
include 'auth.php';
include 'lib.php';

$assunto = request("titulo");
$corpo = request("FCKeditor1");

$dataini = request("dataini");
$datafim = request("datafim");


$dataini = FormataDataMysql($dataini);
$datafim = FormataDataMysql($datafim);

$corpo = str_replace("src=\"/images/","src=\"http://www.reverbcity.com/images/",$corpo);
$corpo = str_replace("src=/images/","src=http://www.reverbcity.com/images/",$corpo);

$emailsender='atendimento@reverbcity.com'; // Substitua essa linha pelo seu e-mail@seudominio

// if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
// elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
// else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
$quebra_linha = "\n";
 
$nomeremetente     = "Reverbcity";
$emailremetente    = "contato@reverbcity.com";
$emaildestinatario = $email;

$headers = "MIME-Version: 1.1".$quebra_linha;
$headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
$headers .= "From: ".$emailsender.$quebra_linha;
$headers .= "Return-Path: " . $emailsender . $quebra_linha;
$headers .= "Reply-To: ".$emailremetente.$quebra_linha;

$do_dia = str_pad(date("d",strtotime($dataini)),2,"0",STR_PAD_LEFT);
$do_mes = str_pad(date("m",strtotime($dataini)),2,"0",STR_PAD_LEFT);

// até ...
$ate_dia = str_pad(date("d",strtotime($datafim)),2,"0",STR_PAD_LEFT);
$ate_mes = str_pad(date("m",strtotime($datafim)),2,"0",STR_PAD_LEFT);

$mesatual = date("m");
$anoatual = date("Y");

//$sql = "select DS_EMAIL_CASO, DS_NOME_CASO from cadastros WHERE NR_SEQ_LOJA_CASO = $SS_loja AND 
//        date_format(DT_NASCIMENTO_CASO, '%m-%d') BETWEEN date_format('0000-$do_mes-$do_dia', '%m-%d')
//        AND date_format('0000-$ate_mes-$ate_dia', '%m-%d') order by DS_NOME_CASO";

$sql = "select DS_EMAIL_CASO, DS_NOME_CASO, DS_UF_CASO, ST_BLOQUEIOMAIL_CACH from cadastros WHERE NR_SEQ_LOJA_CASO = $SS_loja AND
        date_format(DT_NASCIMENTO_CASO, '%m-%d') BETWEEN date_format('0000-$do_mes-$do_dia', '%m-%d')
        AND date_format('0000-$ate_mes-$ate_dia', '%m-%d')
        and NR_SEQ_CADASTRO_CASO not in (select NR_SEQ_CADASTRO_COSO from compras where NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
        and MONTH(DT_COMPRA_COSO) = $mesatual and YEAR(DT_COMPRA_COSO) = $anoatual and ST_COMPRA_COSO <> 'C')
        and ST_ENVIO_CASO = 'S' and TP_CADASTRO_CACH <> 1       
        order by DS_NOME_CASO";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $ds_email = $row[0];
        $ds_nome = $row[1];
        $estado = $row[2];
        $stbloq  = $row[3];
        
        if (strpos($ds_nome," ") > 0){
        	$ds_nome = substr($ds_nome,0,strpos($ds_nome," "));
        }
        
        $corpo2 = str_replace("##nome##",$ds_nome,$corpo); 
        

                 
        if ($stbloq == "N") EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$ds_email,"","",$assunto, $corpo2);
    }
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou emails para todos aniversariantes do dia");
?>
<script language="JavaScript">
   alert('Emails enviados com Sucesso!');
   window.location.href=('index.php');
</script>
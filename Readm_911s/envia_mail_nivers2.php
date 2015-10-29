<?php
include 'lib.php';
try{
    $mes = request("mes");
    $assunto = request("titulo");
    $corpo = request("FCKeditor1");

    $corpo = str_replace("src=\"/images/","src=\"http://www.reverbcity.com/images/",$corpo);
    $corpo = str_replace("src=/images/","src=http://www.reverbcity.com/images/",$corpo);

    $emailsender='contato@reverbcity.com'; // Substitua essa linha pelo seu e-mail@seudominio

    // if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
    // elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
    // else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
     
    $nomeremetente     = "Reverbcity";
    $emailremetente    = "contato@reverbcity.com";
    $emaildestinatario = $email;

    $headers = "MIME-Version: 1.1".$quebra_linha;
    $headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
    $headers .= "From: ".$emailsender.$quebra_linha;
    $headers .= "Return-Path: " . $emailsender . $quebra_linha;
    $headers .= "Reply-To: ".$emailremetente.$quebra_linha;

    $sql = "select DS_EMAIL_CASO, DS_NOME_CASO, ST_BLOQUEIOMAIL_CACH from cadastros WHERE month(DT_NASCIMENTO_CASO) = '$mes' order by DS_NOME_CASO";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
        while($row = mysql_fetch_row($st)) {
            $ds_email = $row[0];
            $ds_nome = $row[1];
            $stbloq  = $row[2];
            if (strpos($ds_nome," ") > 0){
                $ds_nome = substr($ds_nome,0,strpos($ds_nome," "));
            }
            $corpo = str_replace("##nome##",$ds_nome,$corpo);                    
            if ($stbloq == "N"){
                EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$ds_email,"","",$assunto, $corpo);
            }

        }
    }

    GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou emails para todos aniversariantes");
}catch (Exception $e){
    die($e->getMessage());
}
?>
<script language="JavaScript">
   alert('Emails enviados com Sucesso!');
   window.location.href=('clientes_nivers.php?mes=<?php echo $mes ?>');
</script>
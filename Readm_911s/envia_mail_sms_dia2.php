<?php
include 'auth.php';
include 'lib.php';

$texto = request("msg");

$sql = "select DS_DDDCEL_CASO, DS_CELULAR_CASO, NR_SEQ_CADASTRO_CASO, ST_ENVIOSMS_CACH, ST_BLOQUEIOMAIL_CACH from 
        cadastros WHERE NR_SEQ_LOJA_CASO = $SS_loja AND 
        day(sysdate()) = day(DT_NASCIMENTO_CASO) and month(sysdate()) = month(DT_NASCIMENTO_CASO) 
        and TP_CADASTRO_CACH <> 1 order by DS_NOME_CASO";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $celddd  = $row[0];
        $celular = $row[1];
        $idc     = $row[2];
        $enviar  = $row[3];
        $stbloq  = $row[4];
        
        if ($enviar == "S" && $stbloq == "N"){
            $celddd = str_replace("(","",$celddd);
            $celddd = str_replace(")","",$celddd);
            $celddd = str_replace(" ","",$celddd);
            
            $celular = str_replace("-","",$celular);
            $celular = str_replace(".","",$celular);
            $celular = str_replace("/","",$celular);
            $celular = str_replace("=","",$celular);
            $celular = str_replace(" ","",$celular);
            
            $celularcomp = $celddd.$celular;
    
            if (substr($celularcomp,0,1) == "0"){
                $celularcomp = substr($celularcomp,1,strlen($celularcomp));
            }
            
            if (strlen($celularcomp)==10){
                //echo $SS_logadm." | ".$idc." | ".$celularcomp." | ".$texto."<br />";
                EnviaSMS($SS_logadm,$idc,$celularcomp,$texto);
            }
        }
    }
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou SMS para todos aniversariantes do dia");
?>
<script language="JavaScript">
   alert('SMSs enviados com Sucesso!');
   window.location.href=('index.php');
</script>
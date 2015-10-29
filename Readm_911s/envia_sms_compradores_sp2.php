<?php
include 'auth.php';
include 'lib.php';

$texto = request("msg");

$sql = "select DS_DDDCEL_CASO, DS_CELULAR_CASO, NR_SEQ_CADASTRO_CASO, ST_ENVIOSMS_CACH, ST_BLOQUEIOMAIL_CACH
        from cadastros, compras, cestas WHERE
        NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO AND
    	NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO
    and ST_COMPRA_COSO <> 'C' and ST_COMPRA_COSO <> 'A' ";
$sql .= "AND (NR_SEQ_LOJA_CASO = 2 or DS_CIDADE_CASO like '%SAO PAULO%' or DS_CIDADE_CASO like '%são paulo%' or DS_CIDADE_CASO like '%sÃ£o paulo%' or DS_CIDADE_CASO like '%sao paulo%' or DS_CIDADE_CASO like '%saopaulo%')";
$sql .= " group by NR_SEQ_CADASTRO_CASO";
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
               
            if (strlen($celularcomp)==10 || strlen($celularcomp)==11){
                //echo $SS_logadm." | ".$idc." | ".$celularcomp." | ".$texto."<br />";
                EnviaSMS($SS_logadm,$idc,$celularcomp,$texto);
            }
        }
    }
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou SMS para compradores $tipo - $cat");
?>
<script language="JavaScript">
   alert('SMSs enviados com Sucesso!');
   window.location.href=('index.php');
</script>
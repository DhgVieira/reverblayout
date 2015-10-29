<?php
exit();
include 'auth.php';
include 'lib.php';

$texto = "Feliz dia, sualinda! Comprando uma camiseta podrinha vc GANHA de presente uma do Mumford And Sons http://rvb.la/DiaMulher";

$sql = "select DS_DDDCEL_CASO, DS_CELULAR_CASO, NR_SEQ_CADASTRO_CASO, ST_ENVIOSMS_CACH, ST_BLOQUEIOMAIL_CACH
        from cadastros
        where DS_SEXO_CACH = 'feminino' and ST_CADASTRO_CASO = 'A' limit 9723,300 ";
$x=0;
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
                echo $SS_logadm." | ".$idc." | ".$celularcomp." | ".$texto."<br />";
                EnviaSMS($SS_logadm,$idc,$celularcomp,$texto);
                $x++;
            }
        }
    }
}

echo "TOTAL: $x";
//GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou SMS para compradores $tipo - $cat");
?>
<script language="JavaScript">
   //alert('SMSs enviados com Sucesso!');
   //window.location.href=('index.php');
</script>
<?php
include 'auth.php';
include 'lib.php';

$texto = request("msg");
$todos = request("todos");

$sql = "select DS_DDDCEL_CASO, DS_CELULAR_CASO, NR_SEQ_CADASTRO_CASO, ST_ENVIOSMS_CACH from cadastros where 
         DAY(DT_CADASTRO_CASO) = DAY(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) AND
         MONTH(DT_CADASTRO_CASO) = MONTH(DATE_SUB(SYSDATE(), INTERVAL 1 DAY)) AND
         YEAR(DT_CADASTRO_CASO) = YEAR(DATE_SUB(SYSDATE(), INTERVAL 1 DAY))";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $celddd  = $row[0];
        $celular = $row[1];
        $idc     = $row[2];
        $enviar  = $row[3];
        
        if ($enviar == "S"){
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
                if ($todos == "S"){
                    //echo $SS_logadm." | ".$idc." | ".$celularcomp." | ".$texto."<br />";
                    EnviaSMS($SS_logadm,$idc,$celularcomp,$texto);
                }else{
                    $sqlniv = "select VL_TOTAL_COSO from compras WHERE NR_SEQ_CADASTRO_COSO = $idc AND ST_COMPRA_COSO <> 'C'";
        			$stniv = mysql_query($sqlniv);
        			if (mysql_num_rows($stniv) <= 0) {
        			 	//echo $SS_logadm." | ".$idc." | ".$celularcomp." | ".$texto."<br />";
                        EnviaSMS($SS_logadm,$idc,$celularcomp,$texto);
                    }
                }
            }
        }
    }
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou SMS para todos cadastros do dia anterior");
?>
<script language="JavaScript">
   alert('SMSs enviados com Sucesso!');
   window.location.href=('index.php');
</script>
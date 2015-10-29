<?php
include 'auth.php';
include 'lib.php';

$texto = request("msg");

$avisemes = $_POST['selec'];

if ($avisemes){
    foreach ($avisemes as $idav) {
        $sql3 = "select DS_EMAIL_AVRC, NR_SEQ_AVISEME_AVRC, NR_SEQ_PRODUTO_AVRC, DS_TELEFONE_AVRC from aviseme where NR_SEQ_AVISEME_AVRC = $idav";
        $st3 = mysql_query($sql3);
        if (mysql_num_rows($st3) > 0) {
           while($row3 = mysql_fetch_array($st3)) {
               $sql2 = "SELECT DS_PRODUTO2_PRRC from produtos WHERE NR_SEQ_PRODUTO_PRRC = ".$row3["NR_SEQ_PRODUTO_AVRC"];
               $st2 = mysql_query($sql2); 
               if (mysql_num_rows($st2) > 0) {
                    $row2 = mysql_fetch_row($st2);
                    $ds_prod	   = $row2[0];
               }
               
               $textosms = str_replace("#PROD#",$ds_prod,$texto);
               
               $sqlcad = "select DS_DDDCEL_CASO, DS_CELULAR_CASO, NR_SEQ_CADASTRO_CASO from cadastros where DS_EMAIL_CASO = '".$row3["DS_EMAIL_AVRC"]."'";
               $stcad = mysql_query($sqlcad);
               
               if (mysql_num_rows($stcad) > 0) {
                   $rowcad = mysql_fetch_row($stcad);
                   $celddd  = $rowcad[0];
                   $celular = $rowcad[1];
                   $idc     = $rowcad[2];
                   
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
                      EnviaSMS($SS_logadm,$idc,$celularcomp,$textosms);
                   }
               }else{
                  $celular      = $row3["DS_TELEFONE_AVRC"];
                                      
                  $celular = str_replace("(","",$celular);
                  $celular = str_replace(")","",$celular);
                  $celular = str_replace("-","",$celular);
                  $celular = str_replace(".","",$celular);
                  $celular = str_replace("/","",$celular);
                  $celular = str_replace("=","",$celular);
                  $celular = str_replace(" ","",$celular);
                  
                  if (substr($celular,0,1) == "0"){
                    $celular = substr($celular,1,strlen($celular));
                  }
                  
                  $ehcelular = false;
                  
                  if (substr($celular,2,1) == "9" || substr($celular,2,1) == "8" || substr($celular,2,1) == "7"){
                    $ehcelular = true;
                  }
                  
                  if (strlen($celular)==10 && $ehcelular) {
                     EnviaSMS($SS_logadm,"0",$celular,$textosms);
                  }
               }
          }
        }
    }
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou SMS avise-me para todos (ja avisados)");

mysql_close($con);
?>
<script language="JavaScript">
   alert('SMS de aviso enviado para TODOS com Sucesso!');
   window.location.href=('grupos_aviso2.php');
</script>

<?php
include 'auth.php';
include 'lib.php';

$texto = request("msg");

$sql = "select NR_SEQ_PRODUTO_PRRC, NR_SEQ_TAMANHO_AVRC, DS_PRODUTO2_PRRC
    	 from produtos, produtos_tipo, lojas, aviseme, tamanhos, estoque 
    	 WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND NR_SEQ_LOJAS_PRRC = $SS_loja AND
    	 NR_SEQ_LOJAS_PRRC = NR_SEQ_LOJA_LJRC AND NR_SEQ_PRODUTO_PRRC =  NR_SEQ_PRODUTO_AVRC
    	 and NR_SEQ_TAMANHO_AVRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND ST_AVISO_AVRC = 'N' and
         NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_AVRC and NR_QTDE_ESRC > 0
    	 GROUP BY NR_SEQ_PRODUTO_PRRC, NR_SEQ_TAMANHO_AVRC";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $id_prod	   = $row[0];
        $idtamanho	   = $row[1];
        $ds_prod	   = $row[2];
        
        $sql3 = "select NR_SEQ_AVISEME_AVRC, DS_EMAIL_AVRC, DS_TELEFONE_AVRC from aviseme where NR_SEQ_PRODUTO_AVRC = $id_prod and NR_SEQ_TAMANHO_AVRC = $idtamanho AND ST_AVISO_AVRC = 'N'";
        $st3 = mysql_query($sql3);
        if (mysql_num_rows($st3) > 0) {
	  	   while($row3 = mysql_fetch_array($st3)) {
               $idav = $row3["NR_SEQ_AVISEME_AVRC"];
               
               if (strpos($row3["DS_EMAIL_AVRC"],"@") > 0){
                    $tiralista = 0; 
               }else{
                    $tiralista = $idav;
               }
               
               $textosms = str_replace("#PROD#",$ds_prod,$texto);
               
               $sqlcad = "select DS_DDDCEL_CASO, DS_CELULAR_CASO, NR_SEQ_CADASTRO_CASO, ST_ENVIOSMS_CACH from cadastros where DS_EMAIL_CASO = '".$row3["DS_EMAIL_AVRC"]."'";
               $stcad = mysql_query($sqlcad);
               if (mysql_num_rows($stcad) > 0) {
                   $rowcad = mysql_fetch_row($stcad);
                   $celddd  = $rowcad[0];
                   $celular = $rowcad[1];
                   $idc     = $rowcad[2];
                   $enviar  = $row[3];
                   
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
                    
                   if (strlen($celularcomp)==10 && $enviar == "S"){
                       EnviaSMS($SS_logadm,$idc,$celularcomp,$textosms);
                       if ($tiralista > 0){
                           $str = "update aviseme set ST_AVISO_AVRC = 'S' where NR_SEQ_AVISEME_AVRC = $tiralista";
                           $st4 = mysql_query($str);
                       }
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
                    if ($tiralista > 0){
                       $str = "update aviseme set ST_AVISO_AVRC = 'S' where NR_SEQ_AVISEME_AVRC = $tiralista";
                       $st4 = mysql_query($str);
                    }
                  }
               }
          }
       }
    }
}
GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou SMS de avise-me para todos");

mysql_close($con);
?>
<script language="JavaScript">
   alert('SMS de aviso enviado para TODOS com Sucesso!');
   window.location.href=('grupos_aviso.php');
</script>

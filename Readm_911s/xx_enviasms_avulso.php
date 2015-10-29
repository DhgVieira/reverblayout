<?php
set_time_limit(900);
include 'auth.php';
include 'lib.php';

// $texto = utf8_encode("Quem é do PR tem FRETE GRÁTIS este fds em compras a partir de R$69 (em itens fora de promo) http://rvb.la/FreteSMS");
$texto = utf8_decode("3 novas camisetas do Arctic Monkeys na Reverbcity: I Wanna Be Yours, Knee Socks e One For The Road   http://rvb.la/SMSAM");


// $sql = "SELECT 
//             DS_DDDCEL_CASO,
//             DS_CELULAR_CASO,
//             NR_SEQ_CADASTRO_CASO,
//             ST_ENVIOSMS_CACH,
//             ST_BLOQUEIOMAIL_CACH
//         from
//             cadastros, cestas, produtos
//         where
//         NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_CESO
// AND NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_CESO
//                 AND DS_DDDCEL_CASO <> '-'
//                 AND DS_DDDCEL_CASO <> ''
//                 AND DS_CELULAR_CASO <> '-'
//                 AND DS_CELULAR_CASO <> ''
//                 AND ST_ENVIOSMS_CACH = 'S'
//                 AND ST_BLOQUEIOMAIL_CACH = 'N'
//                 AND NR_SEQ_CATEGORIA_PRRC in (49,60,143,61,63,187,64,93)

               
//         group by NR_SEQ_CADASTRO_CASO";

$sql = "SELECT 
            DS_DDDCEL_CASO,
            DS_CELULAR_CASO,
            NR_SEQ_CADASTRO_CASO,
            ST_ENVIOSMS_CACH,
            ST_BLOQUEIOMAIL_CACH
        from
            cadastros, cestas
        where
        NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_CESO
                AND DS_DDDCEL_CASO <> '-'
                AND DS_DDDCEL_CASO <> ''
                AND DS_CELULAR_CASO <> '-'
                AND DS_CELULAR_CASO <> ''
                AND ST_ENVIOSMS_CACH = 'S'
                AND ST_BLOQUEIOMAIL_CACH = 'N'
                AND NR_SEQ_PRODUTO_CESO in (5394, 5395, 5683, 5684, 30, 153,497,558,871,1516,1565,1752,1753,2394,2395, 4652,5107)
               
        group by NR_SEQ_CADASTRO_CASO"; 


$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    $x=0;
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
                EnviaSMS($SS_logadm,$idc,$celularcomp,$texto);
                //echo $SS_logadm." | ".$idc." | ".$celularcomp." | ".$texto."<br />";   
                $x++;
                //exit();
            }
        }
    }
}

echo "Enviado para $x pessoas";

//GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Enviou SMS para compradores Avulso");
?>
<script language="JavaScript">
   //alert('SMSs enviados com Sucesso!');
   //window.location.href=('index.php');
</script>
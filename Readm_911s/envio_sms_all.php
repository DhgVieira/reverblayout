<?php
exit();
include 'auth.php';
include 'lib.php';

// envio para maiores compradores
$compra = "select NR_SEQ_CADASTRO_CASO, DS_DDDCEL_CASO, DS_CELULAR_CASO, SUM(NR_QTDE_CESO) as qtde,
 SUM(NR_QTDE_CESO*VL_PRODUTO_CESO) as valor, DS_NOME_CASO from compras, cestas, produtos, cadastros
where NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and NR_SEQ_PRODUTO_CESO = NR_SEQ_PRODUTO_PRRC and NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and
NR_SEQ_CADASTRO_COSO not in (8074, 6605, 4160, 2, 3, 9701)
AND (ST_COMPRA_COSO = 'P' or ST_COMPRA_COSO = 'V' or ST_COMPRA_COSO = 'E') 
and DS_CELULAR_CASO is not null and DS_CELULAR_CASO <> '-' and DS_CELULAR_CASO <> ''
GROUP BY NR_SEQ_CADASTRO_COSO ORDER BY valor desc limit 200;";

// envio para compras em aberto
$compra = "select NR_SEQ_CADASTRO_CASO, DS_DDDCEL_CASO, DS_CELULAR_CASO, NR_SEQ_COMPRA_COSO
from compras, cadastros where
NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO and NR_SEQ_LOJA_COSO = 1
and ST_COMPRA_COSO = 'A' 
and DT_COMPRA_COSO > '2011-09-22 00:00:00' 
and DT_COMPRA_COSO < '2011-09-26 23:59:59'
and DS_FORMAPGTO_COSO <> 'boleto'
and DS_CELULAR_CASO is not null and DS_CELULAR_CASO <> '-' and DS_CELULAR_CASO <> ''
GROUP BY NR_SEQ_CADASTRO_CASO order by DT_COMPRA_COSO;";


$compraST = mysql_query($compra);
if (mysql_num_rows($compraST) > 0) { 
    $mos = true;
    $x = 1;
    $envia = false;
    while($row = mysql_fetch_row($compraST)) {
        //$nome = utf8_decode($row[2]);
        $idcad      = $row[0];
        $celddd     = $row[1];
        $celular    = $row[2];
        $compra     = $row[3];
        
        $celddd = str_replace("(","",$celddd);
        $celddd = str_replace(")","",$celddd);
        $celddd = str_replace(" ","",$celddd);
        $celddd = str_replace("-","",$celddd);
        
        if (substr($celddd,0,1) == "0" && strlen($celddd)==3){
            $celddd = substr($celddd,1,2);
        }                

        $celular = str_replace("-","",$celular);
        $celular = str_replace(".","",$celular);
        $celular = str_replace("/","",$celular);
        $celular = str_replace("=","",$celular);
        $celular = str_replace(" ","",$celular);
        
        $celularcomp = $celddd.$celular;
        
        $msgsms = "Ola, nao recebemos confirmacao do seu pgto. Entre em contato no compras@reverbcity.com e garanta o seu pedido $compra o quanto antes";

        //if (strlen($celular)==8 && $envia) {
        if (strlen($celular)==8) {
            //echo $msgsms."<br />";
            echo $x." - $nome(".$idcad.") - ".$celularcomp." - Compra: ".$compra."<br /><br />";
            EnviaSMS(1,$idcad,$celularcomp,$msgsms);
        }
        
        //if ($idcad == 8056) $envia = true;
        $x++;
    } // FIM WHILE
}

mysql_close($con);
?>
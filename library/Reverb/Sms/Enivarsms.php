<?php 

function EnviaSMS($logadm,$idcad,$celular,$msg){
    //$UserID = "1272f816-5d88-46d2-b940-f180d0e1f4e8";
    //$Token = "52842487";
    
    $sqlsmss = "select ST_ENVIOSMS_CACH from cadastros where NR_SEQ_CADASTRO_CASO = $idcad";
    
    $st2smsss = mysql_query($sqlsmss);
    if (mysql_num_rows($st2smsss) > 0) {
        $rowsmss = mysql_fetch_row($st2smsss);
        $statussmss = $rowsmss[0];
    
        if ($statussmss == "S"){
            if (substr($celular,0,2) == "11" && strlen($celular)==10){
                $celular = substr($celular,0,2)."9".substr($celular,2,strlen($celular)-2);
            }
        
            //$url = "http://www.misterpostman.com.br/gateway.aspx";
            
            $msg = str_replace("&","e",$msg);
            
            $str = "INSERT INTO sms_envios (NR_SEQ_USUARIO_SMRC, NR_SEQ_CLIENTE_SMRC, DS_CELULAR_SMRC, DS_MSG_SMRC, DT_ENVIO_SMRC)
                    values ($logadm, $idcad, '$celular', '$msg', sysdate())";
            $st = mysql_query($str);
            
            $msgid = mysql_insert_id();
            
            $url = "http://193.105.74.59/api/sendsms/plain?user=rbcity&password=rbcity123&sender=Reverbcity&GSM=55$celular&SMStext=".urlencode($msg);
            
            $ch = curl_init();
            
            $msg = URLEncode($msg); 
            curl_setopt($ch, CURLOPT_URL,$url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            //curl_setopt($ch, CURLOPT_POST, 1);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, "UserID=".$UserID."&Token=".$Token."&NroDestino=".$celular."&Mensagem=".$msg."&Remetente=Reverbcity");
            curl_setopt($ch, CURLOPT_FAILONERROR, 0);
            
            $resultbusca = curl_exec($ch);
            curl_close($ch);
            
            $resultbusca = trim($resultbusca);
            
            $str = "UPDATE sms_envios SET DS_RETORNO_SMRC = '$resultbusca' where NR_SEQ_SMSENVIO_SMRC = $msgid";
            $st = mysql_query($str);
            
            if (trim($resultbusca) > 0){
            //if (trim($resultbusca) == "OK"){
                $strsms = "INSERT INTO sms_controle (NR_SEQ_SMS_CSRC, DS_DESCRICAO_CSRC, NR_QTDE_CSRC, DT_LANCTO_CRSC) 
                        VALUES (".$msgid.", 'Envio de SMS', -1, sysdate())";
                $stsmss = mysql_query($strsms);
            }
        }
    }
}
?>
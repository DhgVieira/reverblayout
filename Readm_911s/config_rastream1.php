<?php
$logacoes = "";
$logerros = "";
$logenviado = "";
$url = "";

$dia = $_POST["dia"];
$mes = $_POST["mes"];
$ano = $_POST["ano"];

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookiefile");
curl_setopt($ch, CURLOPT_COOKIEJAR, "cookiefile");
curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

$data = 'txtusuario=prjc00446&txtsenha=625953';

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

curl_setopt($ch, CURLOPT_URL, 'http://pr.postal.net.br/postalnet/logon.php');
curl_exec($ch);

curl_setopt($ch, CURLOPT_URL, 'http://pr.postal.net.br/postalnet/usuario/movimento/htmlect.php?row=0&datai='.$dia.'/'.$mes.'/'.$ano.'&dataf='.$dia.'/'.$mes.'/'.$ano.'&hrini=00:00&hrfim=23:59&r=2&ordem=&descri=&opcao=&tipo=&prod=');
$result2 = curl_exec($ch);

$url = 'http://pr.postal.net.br/postalnet/usuario/movimento/htmlect.php?row=0&datai='.$dia.'/'.$mes.'/'.$ano.'&dataf='.$dia.'/'.$mes.'/'.$ano.'&hrini=00:00&hrfim=23:59&r=2&ordem=&descri=&opcao=&tipo=&prod='; 

$lines = explode("\n", $result2);



$get = false;
$result = "";

$pegou = false;

foreach ($lines as $line) {
    if (strpos($line, '<table width="100%">') !== false) {
        $get = true;
    }
    if ($get) {
        $result .= $line;
    }
}

$result = str_replace("</td>","|",$result);
$result = str_replace("</tr>","\n",$result);
$result = str_replace("&nbsp;","",$result);
$result = strip_tags($result);
$lines = explode("\n", $result);

$totalpag = 1;
$total = 0;
$totalerro = 0;

include 'lib.php';

foreach ($lines as $line) {
    $splitlinha = explode("|",$line);
    if (count($splitlinha)==16){
        if ($splitlinha[7]!="Registro" && $splitlinha[7]){
            $cep = $splitlinha[2];
            $cep = str_replace("-","",$cep);
            $uf = $splitlinha[3];
            $compra = $splitlinha[11];
            $compra2 = $splitlinha[12];

// if (!$compra){
// $compra = $compra2;
// }

            $codrastreamento = $splitlinha[7]."BR";
            $vlrfrete = str_replace(",",".",$splitlinha[14]);
            if ($compra){
                $sqlnf = "SELECT ST_COMPRA_COSO, DS_RASTREAMENTO_COSO, DS_NOME_CASO, DS_EMAIL_CASO from compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND NR_SEQ_COMPRA_COSO = ".$compra;
                $stnf = mysql_query($sqlnf);
                    if (mysql_num_rows($stnf) > 0) {
                        $rownf = mysql_fetch_row($stnf);
                        $stcompra = $rownf[0];
                        $codrast = $rownf[1];
                        $nome = $rownf[2];
                        $emaildest = $rownf[3];

                        if ($stcompra == 'A'){
                            $logerros .= "Rast.: $codrastreamento - Nome: ".$splitlinha[1]." - Vlr.Frete: R$ ".number_format($vlrfrete,2,",","")." - Cep: ".$cep." - Compra: <a href=http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=".$compra." target=_blank>$compra</a><br />";
                            $logerros .= "<font color=red>A compra informada ainda está em aberta!!</font><br /><br />";
                            $totalerro++;
                        }else if ($stcompra == 'P'){
                            if ($codrast){
                                $logerros .= "Rast.: $codrastreamento - Nome: ".$splitlinha[1]." - Vlr.Frete: R$ ".number_format($vlrfrete,2,",","")." - Cep: ".$cep." - Compra: <a href=http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=".$compra." target=_blank>$compra</a><br />";
                                $logerros .= "<font color=red>A compra informada Já possui um código de rastreamento!!</font><br /><br />";
                                $totalerro++;
                        }else{
                            $logacoes .= "Rast.: $codrastreamento - Nome: ".$splitlinha[1]." - Vlr.Frete: R$ ".number_format($vlrfrete,2,",","")." - Cep: ".$cep." - Compra: <a href=http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=".$compra." target=_blank>$compra</a><br />";
                            $str = "update compras set DS_RASTREAMENTO_COSO = '$codrastreamento', VL_FRETECUSTO_COSO = $vlrfrete, ST_COMPRA_COSO = 'V' WHERE NR_SEQ_COMPRA_COSO = ".$compra;
                            $st = mysql_query($str);

                            $subject  = utf8_encode("ReverbCity - Confirmação de Envio (Rastreamento)!");

                            $texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 25px 25px; width: 550px;">
                            Pronto para o Rock and Roll, <strong>'.utf8_decode($nome).'</strong>?
                            <br /><br />
                            A turnê da sua camiseta vai começar! Segue abaixo o código de rastreamento da sua compra número <strong>'.$idc.'</strong>
                            </div>    
                            <div style="background-color: #dcddde; padding: 25px; font-family:Verdana;font-size:12px;color: #313131; width: 550px;">
                            Código: <strong>'.$codrastreamento.'</strong>
                            </div>
                            <p style="font-family:Verdana;font-size:11px;color: #555555;padding: 0 25px 0 25px;">
                            Para consultar o status do envio acesse o nosso site clicando no link <strong>Rastreamento</strong> no<br/ >rodapé e informe o código acima.
                            <br /><br /></p>
                            ';
                            $corpo = IncluiPapelCarta("rast",$texto,"ReverbCity RASTREAMENTO");

                            EnviaMailer("atendimento@reverbcity.com","Reverbcity",$emaildest,$nome,"",$subject,$corpo);

                            $logacoes .= "Dados atualizados com sucesso.<br />";
                            $total++;
                        }
                    }else if ($stcompra == 'E'){
                        $logerros .= "Rast.: $codrastreamento - Nome: ".$splitlinha[1]." - Vlr.Frete: R$ ".number_format($vlrfrete,2,",","")." - Cep: ".$cep." - Compra: <a href=http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=".$compra." target=_blank>$compra</a><br />";
                        $logerros .= "<font color=red>A compra informada já está setada como entregue!!</font><br /><br />";
                        $totalerro++;
                    }else{
                        $logenviado .= "$codrastreamento - Frete: R$ ".number_format($vlrfrete,2,",","")." - Compra: <a href=http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=".$compra." target=_blank>$compra</a> - ST: $stcompra<br />";
                    }
                }
            }else{
                $logerros .= "Rast.: $codrastreamento - Nome: ".$splitlinha[1]." - Vlr.Frete: R$ ".number_format($vlrfrete,2,",","")." - Cep: ".$cep." - Compra: <a href=http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=".$compra." target=_blank>$compra</a><br />";
                $logerros .= "<font color=red>Rastreamento sem número de compra!!</font><br /><br />";
                $totalerro++;
            }
        }
    }

    if (strpos($line,"pg 1 de ") === false){

    }else{
        $totalpag = substr($line,strpos($line,"pg 1 de ")+8,1);
    }
}

if ($totalpag > 1){
    for ($f=1;$f<$totalpag;$f++){        
        curl_setopt($ch, CURLOPT_URL, 'http://pr.postal.net.br/postalnet/usuario/movimento/htmlect.php?row='.$f.'&datai='.$dia.'/'.$mes.'/'.$ano.'&dataf='.$dia.'/'.$mes.'/'.$ano.'&hrini=00:00&hrfim=23:59&r=2&ordem=&descri=&opcao=&tipo=&prod=');
        $result2 = curl_exec($ch);

        $lines = explode("\n", $result2);

        $get = false;
        $result = "";

        $pegou = false; 
            foreach ($lines as $line) {
                if (strpos($line, '<table width="100%">') !== false) {
                    $get = true;
                }
                if ($get) {
                    $result .= $line;
                }
            }

            $result = str_replace("</td>","|",$result);
            $result = str_replace("</tr>","\n",$result);
            $result = str_replace("&nbsp;","",$result);
            $result = strip_tags($result);

            $lines = explode("\n", $result);

            $con2 =  mysql_connect("reverbcity1.cp48hix4ktfm.sa-east-1.rds.amazonaws.com","reverb","reverbserver2014") or die("Conexão Falhou!");
            
            mysql_select_db("reverb_amazon",$con) or die("Database Inválido");

            foreach ($lines as $line) {
                $splitlinha = explode("|",$line);
                if (count($splitlinha)==17){
                    if ($splitlinha[7]!="Registro" && $splitlinha[7]){
                        $cep = $splitlinha[2];
                        $cep = str_replace("-","",$cep);
                        $uf = $splitlinha[3];
                        $compra = $splitlinha[10];
                        $compra2 = $splitlinha[12];

                        if (!$compra){
                            $compra = $compra2;
                        }

                        $codrastreamento = $splitlinha[7]."BR";
                        $vlrfrete = str_replace(",",".",$splitlinha[15]);

                        if ($compra){
                            $sqlnf = "SELECT ST_COMPRA_COSO, DS_RASTREAMENTO_COSO, DS_NOME_CASO, DS_EMAIL_CASO, DS_RASTREAMENTO_COSO from compras, cadastros WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND NR_SEQ_COMPRA_COSO = ".$compra;
                            $stnf = mysql_query($sqlnf);
                            if (mysql_num_rows($stnf) > 0) {
                                $rownf = mysql_fetch_row($stnf);
                                $stcompra = $rownf[0];
                                $codrast = $rownf[1];
                                $nome = $rownf[2];
                                $emaildest = $rownf[3];
                                $rastreamento = $rownf[4];

                                if ($stcompra == 'A'){
                                    $logerros .= "Rast.: $codrastreamento - Nome: ".$splitlinha[1]." - Vlr.Frete: R$ ".number_format($vlrfrete,2,",","")." - Cep: ".$cep." - Compra: <a href=http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=".$compra." target=_blank>$compra</a><br />";
                                    $logerros .= "<font color=red>A compra informada ainda está em aberta!!</font><br /><br />";
                                    $totalerro++;
                                }else if ($stcompra == 'P'){
                                    if ($codrast){
                                        $logerros .= "Rast.: $codrastreamento - Nome: ".$splitlinha[1]." - Vlr.Frete: R$ ".number_format($vlrfrete,2,",","")." - Cep: ".$cep." - Compra: <a href=http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=".$compra." target=_blank>$compra</a><br />";
                                        $logerros .= "<font color=red>A compra informada Já possui um código de rastreamento!!</font><br /><br />";
                                        $totalerro++;
                                }else{
                                    $str = "UPDATE compras set DS_RASTREAMENTO_COSO = '$codrastreamento', VL_FRETECUSTO_COSO = $vlrfrete, ST_COMPRA_COSO = 'V' WHERE NR_SEQ_COMPRA_COSO = ".$compra;

                                    $st = mysql_query($str);

                                    $subject  = utf8_encode("ReverbCity - Confirmação de Envio (Rastreamento)!");

                                    $texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 25px 25px; width: 550px;">
                                    Pronto para o Rock and Roll, <strong>'.utf8_decode($nome).'</strong>?
                                    <br /><br />
                                    A turnê da sua camiseta vai começar! Segue abaixo o código de rastreamento da sua compra número <strong>'.$idc.'</strong>
                                    </div>    
                                    <div style="background-color: #dcddde; padding: 25px; font-family:Verdana;font-size:12px;color: #313131; width: 550px;">
                                    Código: <strong>'.$codrastreamento.'</strong>
                                    </div>
                                    <p style="font-family:Verdana;font-size:11px;color: #555555;padding: 0 25px 0 25px;">
                                    Para consultar o status do envio acesse o nosso site clicando no link <strong>Rastreamento</strong> no<br/ >rodapé e informe o código acima.
                                    <br /><br /></p>
                                    ';
                                    $corpo = IncluiPapelCarta("rast",$texto,"ReverbCity RASTREAMENTO");

                                    EnviaMailer("atendimento@reverbcity.com","Reverbcity",$emaildest,$nome,"",$subject,$corpo);


                                    $logacoes .= "Rast.: $codrastreamento - Nome: ".$splitlinha[1]." - Vlr.Frete: R$ ".number_format($vlrfrete,2,",","")." - Cep: ".$cep." - Compra: <a href=http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=".$compra." target=_blank>$compra</a><br />";
                                    $logacoes .= "Dados atualizados com sucesso.<br />";
                                    $total++;
                                }
                            }else if ($stcompra == 'E'){
                                $logerros .= "Rast.: $codrastreamento - Nome: ".$splitlinha[1]." - Vlr.Frete: R$ ".number_format($vlrfrete,2,",","")." - Cep: ".$cep." - Compra: <a href=http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=".$compra." target=_blank>$compra</a><br />";
                                $logerros .= "<font color=red>A compra informada já está setada como entregue!!</font><br /><br />";
                                $totalerro++;
                            }
                        }
                    }else{
                        $logerros .= "Rast.: $codrastreamento - Nome: ".$splitlinha[1]." - Vlr.Frete: R$ ".number_format($vlrfrete,2,",","")." - Cep: ".$cep." - Compra: <a href=http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=".$compra." target=_blank>$compra</a><br />";
                        $logerros .= "<font color=red>Rastreamento sem número de compra!!</font><br /><br />";
                        $totalerro++;
                    }

                }
            }
        }
        mysql_close($con2);
    }  
}

curl_close($ch);

if (($totalerro > 0) || ($total > 0)){
    $texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
    <p>Período processado: <strong>'.$dia.'/'.$mes.'/'.$ano.' 00:00 a '.$dia.'/'.$mes.'/'.$ano.' 23:59</strong><br /><br /></p> 

    <p><strong>'.$totalerro.' erros para Verificação Manual:</p>
    </div>';
if ($totalerro > 0){    
    $texto .= '<div style="background-color: #dcddde; padding: 15px 10px 15px 25px; font-family:Verdana;font-size:11px;color: #646464; width: 565px; margin: 25px 0 25px 0;">
    '.$logerros.'
    </div>';
}         
    $texto .= '<p style="font-family:Verdana;font-size:11px;color: #555555;padding: 0 25px 0 25px;">
    '.$total.' Processados com Sucesso:</p>';
if ($total > 0){    
    $texto .= '<div style="background-color: #dcddde; padding: 15px 10px 15px 25px; font-family:Verdana;font-size:11px;color: #646464; width: 565px; margin: 25px 0 25px 0;">
    '.$logacoes.'
    </div>';
}  
$texto .= '<br /><br />';

$corpo = IncluiPapelCarta("sistema",$texto,"IMPORTAÇÃO DOS CÓDIGOS DE RASTREAMENTO");

EnviaMailer("atendimento@reverbcity.com","Reverbcity","contato@reverbcity.com","Tony","",utf8_encode("Importação dos códigos de rastreamento processada!"),utf8_encode($corpo));
EnviaMailer("atendimento@reverbcity.com","Reverbcity","atendimento@reverbcity.com","Miria","",utf8_encode("Importação dos códigos de rastreamento processada!"),utf8_encode($corpo));                           
$msgfim = "Captura realizada com sucesso!\n $totalerro erros para Verificacao Manual \n $total processados com Sucesso.";
}else{
EnviaMailer("atendimento@reverbcity.com","Reverbcity","desenvolvimento@reverbcity.com","Daniel","",utf8_encode("Importação dos códigos de rastreamento processada!"),"<strong>Rodou mas nao achou registros - paginas: $totalpag</strong><br />$url<br />$logenviado");
$msgfim = "Captura realizada porem nao achou registros para importar";
}
mysql_close($con);
?>
<script language="JavaScript">
   alert('<?php echo $msgfim; ?>');
   top.window.location.href=('config.php');
</script>
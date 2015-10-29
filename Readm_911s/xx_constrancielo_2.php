<?php
include 'lib.php';
ini_set('allow_url_fopen', 1); // Ativa a diretiva 'allow_url_fopen'
date_default_timezone_set('America/Sao_Paulo');
//crio a data de hoje
$data_hoje = date("Y-m-d H:i:s");
$sql = "select DS_TID_COSO from compras where ST_COMPRA_COSO = 'A' AND DS_TID_COSO IS NOT NULL 
and DS_FORMAPGTO_COSO in ('mastercard','visa','diners', 'elo')";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $tidcom = $row[0];

        $XMLtransacao = GetURL($tidcom,"Consulta");

        $arrayresult = array();
        $arrayresult = GetResult($XMLtransacao);

        if ($arrayresult[0][0] == '') {

            if ($arrayresult[33][1] == 4 || $arrayresult[33][1] == 6){

                if ($arrayresult[33][1] == 4) {
                    $XMLtransacao = GetURL($tidcom,"Captura");
                    $arrayresult2 = array();
                    $arrayresult2 = GetResult($XMLtransacao);
                }else{
                    $arrayresult2 = $arrayresult;
                }


                if ($arrayresult2[33][1] == 6){
                    $idgrp = $arrayresult[4][1];


                    $str2 = "UPDATE compras SET DT_PAGAMENTO_COSO = '$data_hoje' WHERE NR_SEQ_COMPRA_COSO = $idgrp";
                    $st2 = mysql_query($str2);

                    $sql3 = "SELECT NR_SEQ_CADASTRO_CASO, VL_TOTAL_COSO, VL_FRETE_COSO, TP_CADASTRO_CACH, DS_TWITTER_CACH, DS_NOME_CASO, DS_EMAIL_CASO,
DS_DDDCEL_CASO, DS_CELULAR_CASO, ST_ENVIOSMS_CACH
FROM cadastros, compras WHERE NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO AND NR_SEQ_COMPRA_COSO = $idgrp";
                    $st3 = mysql_query($sql3);
                    if (mysql_num_rows($st3) > 0) {
                        $row3 = mysql_fetch_row($st3);
                        $nrcad = $row3[0];
                        $vlcom = $row3[1];
                        $frete = $row3[2];
                        $tipocli = $row3[3];
                        $dstwitter = trim($row3[4]);
                        $nomet  = utf8_decode($row3[5]);
                        $email = $row3[6];

                        $celddd  = $row3[7];
                        $celular = $row3[8];
                        $enviar  = $row3[9];

                        $loginspl = explode(" ", $nomet);
                        $nome = $loginspl[0];
                    }

                    $tem5169 = false;

                    $sqlV = "select sum(VL_PRODUTO_CESO), sum(NR_QTDE_CESO) FROM cestas WHERE NR_SEQ_COMPRA_CESO = $idgrp AND NR_SEQ_PRODUTO_CESO = 5169";
                    $stV = mysql_query($sqlV);
                    if (mysql_num_rows($stV) > 0) {
                        $rowV = mysql_fetch_row($stV);
                        $totpago = $rowV[0];
                        $qtdetotal = $rowV[1];
                        $tem5169 = true;

                        $strpt = "INSERT INTO vale_camisetas (NR_SEQ_COMPRA_VLRC, NR_SEQ_CADASTRO_VLRC, NR_SEQ_PROMO_VLRC, VL_TOTALPAGO_VLRC, NR_QTDEVALE_VLRC, DT_PGTO_VLRC, ST_UTILIZADO_VLRC, ST_FRETEGRATIS_VLRC)
  VALUES ($idgrp, $nrcad, 1, $totpago, $qtdetotal, sysdate(), 'A', 'S')";
                        $stv = mysql_query($strpt);

                        $valorcred = $qtdetotal*75;
                        $strinsertc = "Vale Reverbcity - Compra: <a href=compras_ver.php?idc=$idgrp>$idgrp</a>";

                        $str = "INSERT INTO contacorrente (NR_SEQ_CADASTRO_CRSA, VL_LANCAMENTO_CRSA, TP_LANCAMENTO_CRSA, DT_LANCAMENTO_CRSA, DS_OBSERVACAO_CRSA, DT_VENCIMENTO_CRSA)
VALUES ($nrcad, $valorcred, 'C', sysdate(), '$strinsertc', '2013-12-31 23:59:59')";
                        $stv = mysql_query($str);

                        GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Confirmou pgto compra $idgrp e creditou para $nrcad R$ $valorcred");
                    }


                    if (!$tem5169){
                        $sql4 = "SELECT DS_BILHETE_BIRC, DS_NOME_CASO, DS_EMAIL_CASO, NR_SEQ_BILHETES_BIRC from bilhetes, cadastros where NR_SEQ_CADCRIADOR_BIRC = NR_SEQ_CADASTRO_CASO and NR_SEQ_COMPRA_BIRC = $idgrp AND ST_STATUS_BIRC = 'A'";
                        $st4 = mysql_query($sql4);
                        if (mysql_num_rows($st4) > 0) {
                            $row4 = mysql_fetch_row($st4);
                            $bilhete = $row4[0];
                            $nomebi  = utf8_decode($row4[1]);
                            $emailbi = $row4[2];
                            $nrbilhe = $row4[3];
                            $subject  = "ReverbCity - Vale Presente";

                            $texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
    <p>Ol� <strong>'.$nomebi.'</strong>!</p>

    <p>O vale-presente s� poder� ser usado integralmente em uma �nica compra. Caso sua compra exceda o valor do vale, voc� poder� pagar a diferen�a.</p>
                                        
    <p>O c�digo do Vale Presente que voc� dever� usar no nosso site:  <strong>'.$bilhete.'</strong></p>
    
    <p><strong><a href="http://www.reverbcity.com/valepresente/valepresente_1.php">Clique aqui</a></strong> para enviar o vale-presente para algu�m.</p>
</div>';

                            $corpo = IncluiPapelCarta("valepres",$texto);

                            EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$emailbi,"","",$subject, $corpo);

                            $str5 = "UPDATE bilhetes SET ST_STATUS_BIRC = 'L' WHERE NR_SEQ_BILHETES_BIRC = $nrbilhe";
                            $st5 = mysql_query($str5);
                        }
                    }

                    $texto = utf8_encode('<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
    <p>Ol� <strong>'.$nome.'</strong>,</p>

    <p>O seu pagamento referente ao pedido <a href="http://reverbcity.com/reverbme/minhascompras"><strong>'.$idgrp.'</strong></a> foi confirmado com sucesso e j� estamos separando sua compra aqui na Reverbcity!</p> 

    <p>Assim que seu pedido for enviado, voc� receber� no seu email o c�digo de rastreamento e atualiza��es sobre o percurso do sua encomenda.</p>
    
    <p>Qualquer d�vida basta entrar em contato: <strong><a href=mailto:atendimento@reverbcity.com>atendimento@reverbcity.com</a></strong></p>
</div>    
<div style="background-color: #dcddde; padding: 15px 10px 15px 15px; font-family:Verdana;font-size:11px;color: #646464; width: 575px; margin: 25px 0 25px 0;">
     <b>Prazo para a postagem:</b>
                                Pedidos com o pagamento confirmado at� as 13:00 de um dia �til ser�o postados no mesmo dia, ap�s este hor�rio a postagem se dar� no pr�ximo dia �til.

                                Prazo para a entrega:
                                Os prazos de entregam dependem da forma de envio escolhida durante a compra.

                                Os envios por E-sedex, Sedex e TAM levam em m�dia tr�s dias �teis ap�s a postagem.

                                Os envios por PAC podem levar at� 23 dias �teis, dependendo da regi�o do pa�s. Veja abaixo o prazo m�dio para sua regi�o:
                                1 a 2 dias �teis para as capitais PR, SC, SP, RJ e MG
                                3 a 7 dias �teis para demais cidades do interior e os estados RS, DF, ES, GO, MS, BA, MT, SE e TO
                                7 a 12 dias �teis para os estados e capitais de AL, AC, AP, CE, MA, PA, PB, PE, PI, RN, RO e RR
                                at� 23 dias �teis para AM
</div>');

                    $corpo = IncluiPapelCarta("confpgto",$texto);


                    EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$email,"","","ReverbCity - Confirma��o de Pagamento!", $corpo);

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

                        if (strlen($celularcomp)==10 || strlen($celularcomp)==11){
                            $textosms = "Pagamento Confirmado! Sua compra de numero $idgrp foi paga com sucesso, obrigado! Logo estaremos enviando o seu pedido Reverbcity";
                            EnviaSMS(0,$nrcad,$celularcomp,$textosms);
                        }
                    }

                    $str6 = "UPDATE compras SET ST_COMPRA_COSO = 'P', DT_STATUS_COSO = sysdate(), ST_NOVOPGTO_COSO = null WHERE NR_SEQ_COMPRA_COSO = $idgrp";
                    $st6 = mysql_query($str6);

                    GravaLog(0,end(explode("/", $_SERVER['PHP_SELF'])),"Compra Capturada e Status alterado pelo sistema - $idgrp ST P");
                }
            }else if ($arrayresult[33][1] == 9){
                $envia = RecriaCompra($arrayresult[4][1]);
            }else if ($arrayresult[33][1] == 3){
                $envia = RecriaCompra($arrayresult[4][1]);
            }else if ($arrayresult[33][1] == 5){
                $envia = RecriaCompra($arrayresult[4][1]);
            }

        } else {
//
        }
    }
}

function RecriaCompra($idc){
    $sqlnome = "select DS_NOME_CASO, DS_EMAIL_CASO, TP_CADASTRO_CACH, VL_TOTAL_COSO, VL_DESCPROMO_COSO from compras, cadastros where NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO
and NR_SEQ_COMPRA_COSO = $idc";
    $stnome = mysql_query($sqlnome);
    if (mysql_num_rows($stnome) > 0) {
        $rownome = mysql_fetch_row($stnome);
        $nome = utf8_decode($rownome[0]);
        $email = $rownome[1];
        $tipocad = $rownome[2];
        $vlr_compra_at = $rownome[3];
        $vlr_desconto_at = $rownome[4];
    }

    if ($tipocad != 1){
        $str = "INSERT INTO compras (
NR_SEQ_LOJA_COSO, NR_SEQ_CADASTRO_COSO, NR_SEQ_BILHETE_COSO, DT_COMPRA_COSO, DT_STATUS_COSO,
DS_IP_COSO, VL_TOTAL_COSO, VL_FRETE_COSO, ST_COMPRA_COSO, DS_OBS_COSO,
TP_ENDERECO_COSO, VL_FRETECUSTO_COSO, VL_CUSTOPGTO_COSO, DS_RASTREAMENTO_COSO, 
VL_DESCONTO_COSO, VL_PAGO_COSO, VL_TROCO_COSO, DS_FORMACARTAO_COSO, DS_NRBANCO_COSO, DS_AGENCIA_COSO, DS_CONTACORR_COSO,
DS_CHEQUE1_COSO, DS_CHEQUE2_COSO, DS_CHEQUE3_COSO, VL_CHEQUE1_COSO, VL_CHEQUE2_COSO, VL_CHEQUE3_COSO, DT_CHEQUE1_COSO,
DT_CHEQUE2_COSO, DT_CHEQUE3_COSO, VL_DESCPROMO_COSO, DS_DESCPROMO_COSO, NR_SEQ_VENDEDOR_COSO, ST_NOVOPGTO_COSO, NR_SEQ_PROMO_COSO) 
SELECT 
NR_SEQ_LOJA_COSO, NR_SEQ_CADASTRO_COSO, NR_SEQ_BILHETE_COSO, sysdate(), DT_STATUS_COSO,
DS_IP_COSO, VL_TOTAL_COSO, VL_FRETE_COSO, ST_COMPRA_COSO, DS_OBS_COSO,
TP_ENDERECO_COSO, VL_FRETECUSTO_COSO, VL_CUSTOPGTO_COSO, DS_RASTREAMENTO_COSO, 
VL_DESCONTO_COSO, VL_PAGO_COSO, VL_TROCO_COSO, DS_FORMACARTAO_COSO, DS_NRBANCO_COSO, DS_AGENCIA_COSO, DS_CONTACORR_COSO,
DS_CHEQUE1_COSO, DS_CHEQUE2_COSO, DS_CHEQUE3_COSO, VL_CHEQUE1_COSO, VL_CHEQUE2_COSO, VL_CHEQUE3_COSO, DT_CHEQUE1_COSO,
DT_CHEQUE2_COSO, DT_CHEQUE3_COSO, VL_DESCPROMO_COSO, DS_DESCPROMO_COSO, NR_SEQ_VENDEDOR_COSO, 'S', NR_SEQ_PROMO_COSO FROM compras 
WHERE NR_SEQ_COMPRA_COSO = $idc;";
    }else{
        $vlr_compra_at = $vlr_compra_at + $vlr_desconto_at;
        $str = "INSERT INTO compras (
NR_SEQ_LOJA_COSO, NR_SEQ_CADASTRO_COSO, NR_SEQ_BILHETE_COSO, DT_COMPRA_COSO, DT_STATUS_COSO,
DS_IP_COSO, VL_TOTAL_COSO, VL_FRETE_COSO, ST_COMPRA_COSO, DS_OBS_COSO,
TP_ENDERECO_COSO, VL_FRETECUSTO_COSO, VL_CUSTOPGTO_COSO, DS_RASTREAMENTO_COSO, 
VL_DESCONTO_COSO, VL_PAGO_COSO, VL_TROCO_COSO, DS_FORMACARTAO_COSO, DS_NRBANCO_COSO, DS_AGENCIA_COSO, DS_CONTACORR_COSO,
DS_CHEQUE1_COSO, DS_CHEQUE2_COSO, DS_CHEQUE3_COSO, VL_CHEQUE1_COSO, VL_CHEQUE2_COSO, VL_CHEQUE3_COSO, DT_CHEQUE1_COSO,
DT_CHEQUE2_COSO, DT_CHEQUE3_COSO, VL_DESCPROMO_COSO, DS_DESCPROMO_COSO, NR_SEQ_VENDEDOR_COSO, ST_NOVOPGTO_COSO) 
SELECT 
NR_SEQ_LOJA_COSO, NR_SEQ_CADASTRO_COSO, NR_SEQ_BILHETE_COSO, sysdate(), DT_STATUS_COSO,
DS_IP_COSO, $vlr_compra_at, VL_FRETE_COSO, ST_COMPRA_COSO, DS_OBS_COSO,
TP_ENDERECO_COSO, VL_FRETECUSTO_COSO, VL_CUSTOPGTO_COSO, DS_RASTREAMENTO_COSO, 
VL_DESCONTO_COSO, VL_PAGO_COSO, VL_TROCO_COSO, DS_FORMACARTAO_COSO, DS_NRBANCO_COSO, DS_AGENCIA_COSO, DS_CONTACORR_COSO,
DS_CHEQUE1_COSO, DS_CHEQUE2_COSO, DS_CHEQUE3_COSO, VL_CHEQUE1_COSO, VL_CHEQUE2_COSO, VL_CHEQUE3_COSO, DT_CHEQUE1_COSO,
DT_CHEQUE2_COSO, DT_CHEQUE3_COSO, null, null, NR_SEQ_VENDEDOR_COSO, 'S' FROM compras 
WHERE NR_SEQ_COMPRA_COSO = $idc;";
    }
    $st = mysql_query($str);
    $id_compra = mysql_insert_id();

    $sql = "select NR_SEQ_ENDERECO_ENRC from enderecos where NR_SEQ_COMPRA_ENRC = $idc";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
        $row = mysql_fetch_row($st);
        $nrend = $row[0];

        $str = "INSERT INTO enderecos (NR_SEQ_COMPRA_ENRC, DS_DESTINATARIO_ENRC, DS_ENDERECO_ENRC, DS_NUMERO_ENRC, DS_COMPLEMENTO_ENRC,
DS_BAIRRO_ENRC, DS_CEP_ENRC, DS_CIDADE_ENRC, DS_UF_ENRC, DS_PAIS_ENRC, DS_FONE_ENRC, DT_CADASTRO_ENRC)
SELECT
$id_compra, DS_DESTINATARIO_ENRC, DS_ENDERECO_ENRC, DS_NUMERO_ENRC, DS_COMPLEMENTO_ENRC,
DS_BAIRRO_ENRC, DS_CEP_ENRC, DS_CIDADE_ENRC, DS_UF_ENRC, DS_PAIS_ENRC, DS_FONE_ENRC, DT_CADASTRO_ENRC FROM enderecos
WHERE NR_SEQ_ENDERECO_ENRC = $nrend";
        $st = mysql_query($str);
    }

    $str = "update compras set ST_COMPRA_COSO = 'C', DS_OBS_COSO = 'Compra cancelada e recriada para novo pagamento. Compra nova: $id_compra' WHERE NR_SEQ_COMPRA_COSO = $idc";
    $st = mysql_query($str);

    $str = "update compras set DS_OBS_COSO = 'Compra recriada a partir da compra $idc' WHERE NR_SEQ_COMPRA_COSO = $id_compra";
    $st = mysql_query($str);

    $sql = "select NR_SEQ_CESTA_CESO from cestas where NR_SEQ_COMPRA_CESO = $idc";
    $st = mysql_query($sql);
    if (mysql_num_rows($st) > 0) {
        while($row = mysql_fetch_row($st)) {
            $id_cesta = $row[0];
            $str = "INSERT INTO cestas (
NR_SEQ_CADASTRO_CESO, NR_SEQ_COMPRA_CESO, NR_SEQ_PRODUTO_CESO, NR_SEQ_ESTOQUE_CESO, NR_SEQ_TAMANHO_CESO,
NR_QTDE_CESO, VL_PRODUTO_CESO, DT_INCLUSAO_CESO, DS_OBS_CESO, VL_PRODUTOCHEIO_CESO)
SELECT
NR_SEQ_CADASTRO_CESO, $id_compra, NR_SEQ_PRODUTO_CESO, NR_SEQ_ESTOQUE_CESO, NR_SEQ_TAMANHO_CESO,
NR_QTDE_CESO, VL_PRODUTO_CESO, DT_INCLUSAO_CESO, DS_OBS_CESO, VL_PRODUTOCHEIO_CESO FROM cestas
WHERE NR_SEQ_CESTA_CESO = $id_cesta";
            $stincc = mysql_query($str);
        }
    }

    $testa = true;
    while($testa){
        $CaracteresAceitos = 'ABCDEFGHIJKLMNOPQRSTUVXYZ0123456789';
        $max = strlen($CaracteresAceitos)-1;
        $codigo = "";
        for($i=0; $i < 20; $i++) {
            $codigo .= $CaracteresAceitos{mt_rand(0, $max)};
        }
        $testa = false;
    }

    $str = "INSERT INTO controle_novo_pgto (NR_SEQ_COMPRA_NPRC, DT_CRIACAO_NPRC, ST_USO_NPRC, DS_CODIGO_NPRC, DT_VALIDADE_NPRC) VALUES (
$id_compra, '$data_hoje', 'A', '$codigo', DATE_ADD(SYSDATE(), INTERVAL 2 DAY))";
    $st = mysql_query($str);

    $link = "http://reverbcity.com/reverbme/reabrircompra/idcompra/$idc";
    $link2 = "http://www.reverbcity.com/shop/pgtoc.php?ch=$codigo";

    if (strpos($nome," ") > 0){
        $nome = substr($nome,0,strpos($nome," "));
    }

    $texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
<p>Ol&aacute; <strong>'.$nome.'</strong>,</p>

<p>Sua compra <strong>n&atilde;o</strong> foi aprovada pela administradora do seu cart&atilde;o de cr&eacute;dito e seu pedido <strong>'.$idc.'</strong> ainda n&atilde;o foi finalizado.</p>	

<p>Voc&ecirc; pode <strong><a href="'.$link.'">Clicar Aqui</a></strong> e escolher outra forma de pagamento. Vamos reservar o seu pedido por mais dois dias.</p>

<p>Qualquer d&uacute;vida basta entrar em contato: <strong>atendimento@reverbcity.com</strong></p>


<br />
</div>';
    $corpo = IncluiPapelCarta("compranao",$texto);

    EnviaEmailNovo("atendimento@reverbcity.com","Reverbcity",$email,"","","Reverbcity - Compra n&atilde;o aprovada", $corpo);
}

function getURL($tid,$op){
    $identificacao = '1511341';
    $modulo = 'CIELO';
    $operacao = $op;
    $ambiente = 'PRODUCAO';

    $request = 'identificacao=' . $identificacao;
    $request .= '&modulo=' . $modulo;
    $request .= '&operacao=' . $operacao;
    $request .= '&ambiente=' . $ambiente;

    $request .= '&tid=' . $tid;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://comercio.locaweb.com.br/comercio.comp');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function GetResult($xmlresult){
    $objDom = new DomDocument();
    $loadDom = $objDom->loadXML($xmlresult);

    $resultado = array();

    $nodeErro = $objDom->getElementsByTagName('erro')->item(0);
    if ($nodeErro != '') {
        $nodeCodigoErro = $nodeErro->getElementsByTagName('codigo')->item(0);
        $retorno_codigo_erro = $nodeCodigoErro->nodeValue;
        $resultado[0][0] = $retorno_codigo_erro;
        $resultado[0][1] = $retorno_codigo_erro;

        $nodeMensagemErro = $nodeErro->getElementsByTagName('mensagem')->item(0);
        $retorno_mensagem_erro = $nodeMensagemErro->nodeValue;
        $resultado[1][0] = $retorno_mensagem_erro;
        $resultado[1][1] = $retorno_mensagem_erro;
    }

    $nodeTransacao = $objDom->getElementsByTagName('transacao')->item(0);
    if ($nodeTransacao != '') {
        $nodeTID = $nodeTransacao->getElementsByTagName('tid')->item(0);
        $retorno_tid = $nodeTID->nodeValue;
        $resultado[2][0] = $retorno_tid;
        $resultado[2][1] = $retorno_tid;

        $nodePAN = $nodeTransacao->getElementsByTagName('pan')->item(0);
        $retorno_pan = $nodePAN->nodeValue;
        $resultado[3][0] = $retorno_pan;
        $resultado[3][1] = $retorno_pan;

        $nodeDadosPedido = $nodeTransacao->getElementsByTagName('dados-pedido')->item(0);
        if ($nodeTransacao != '') {
            $nodeNumero = $nodeDadosPedido->getElementsByTagName('numero')->item(0);
            $retorno_pedido = $nodeNumero->nodeValue;
            $resultado[4][0] = $retorno_pedido;
            $resultado[4][1] = $retorno_pedido;

            $nodeValor = $nodeDadosPedido->getElementsByTagName('valor')->item(0);
            $retorno_valor = $nodeValor->nodeValue;
            $resultado[5][0] = $retorno_valor;
            $resultado[5][1] = $retorno_valor;

            $nodeMoeda = $nodeDadosPedido->getElementsByTagName('moeda')->item(0);
            $retorno_moeda = $nodeMoeda->nodeValue;
            $resultado[6][0] = $retorno_moeda;
            $resultado[6][1] = $retorno_moeda;

            $nodeDataHora = $nodeDadosPedido->getElementsByTagName('data-hora')->item(0);
            $retorno_data_hora = $nodeDataHora->nodeValue;
            $resultado[7][0] = $retorno_data_hora;
            $resultado[7][1] = $retorno_data_hora;

            $nodeDescricao = $nodeDadosPedido->getElementsByTagName('descricao')->item(0);
            $retorno_descricao = $nodeDescricao->nodeValue;
            $resultado[8][0] = $retorno_descricao;
            $resultado[8][1] = $retorno_descricao;

            $nodeIdioma = $nodeDadosPedido->getElementsByTagName('idioma')->item(0);
            $retorno_idioma = $nodeIdioma->nodeValue;
            $resultado[9][0] = $retorno_idioma;
            $resultado[9][1] = $retorno_idioma;
        }

        $nodeFormaPagamento = $nodeTransacao->getElementsByTagName('forma-pagamento')->item(0);
        if ($nodeFormaPagamento != '') {
            $nodeBandeira = $nodeFormaPagamento->getElementsByTagName('bandeira')->item(0);
            $retorno_bandeira = $nodeBandeira->nodeValue;
            $resultado[10][0] = $retorno_bandeira;
            $resultado[10][1] = $retorno_bandeira;

            $nodeProduto = $nodeFormaPagamento->getElementsByTagName('produto')->item(0);
            $retorno_produto = $nodeProduto->nodeValue;
            $resultado[11][0] = $retorno_produto;
            $resultado[11][1] = $retorno_produto;

            $nodeParcelas = $nodeFormaPagamento->getElementsByTagName('parcelas')->item(0);
            $retorno_parcelas = $nodeParcelas->nodeValue;
            $resultado[12][0] = $retorno_parcelas;
            $resultado[12][1] = $retorno_parcelas;
        }

        $nodeStatus = $nodeTransacao->getElementsByTagName('status')->item(0);
        $retorno_status = $nodeStatus->nodeValue;
        $resultado[33][0] = $retorno_status;
        $resultado[33][1] = $retorno_status;

        $nodeAutenticacao = $nodeTransacao->getElementsByTagName('autenticacao')->item(0);
        if ($nodeAutenticacao != '') {
            $nodeCodigoAutenticacao = $nodeAutenticacao->getElementsByTagName('codigo')->item(0);
            $retorno_codigo_autenticacao = $nodeCodigoAutenticacao->nodeValue;
            $resultado[13][0] = $retorno_codigo_autenticacao;
            $resultado[13][1] = $retorno_codigo_autenticacao;

            $nodeMensagemAutenticacao = $nodeAutenticacao->getElementsByTagName('mensagem')->item(0);
            $retorno_mensagem_autenticacao = $nodeMensagemAutenticacao->nodeValue;
            $resultado[14][0] = $retorno_mensagem_autenticacao;
            $resultado[14][1] = $retorno_mensagem_autenticacao;

            $nodeDataHoraAutenticacao = $nodeAutenticacao->getElementsByTagName('data-hora')->item(0);
            $retorno_data_hora_autenticacao = $nodeDataHoraAutenticacao->nodeValue;
            $resultado[15][0] = $retorno_data_hora_autenticacao;
            $resultado[15][1] = $retorno_data_hora_autenticacao;

            $nodeValorAutenticacao = $nodeAutenticacao->getElementsByTagName('valor')->item(0);
            $retorno_valor_autenticacao = $nodeValorAutenticacao->nodeValue;
            $resultado[16][0] = $retorno_valor_autenticacao;
            $resultado[16][1] = $retorno_valor_autenticacao;

            $nodeECIAutenticacao = $nodeAutenticacao->getElementsByTagName('eci')->item(0);
            $retorno_eci_autenticacao = $nodeECIAutenticacao->nodeValue;
            $resultado[17][0] = $retorno_eci_autenticacao;
            $resultado[17][1] = $retorno_eci_autenticacao;
        }

        $nodeAutorizacao = $nodeTransacao->getElementsByTagName('autorizacao')->item(0);
        if ($nodeAutorizacao != '') {
            $nodeCodigoAutorizacao = $nodeAutorizacao->getElementsByTagName('codigo')->item(0);
            $retorno_codigo_autorizacao = $nodeCodigoAutorizacao->nodeValue;
            $resultado[18][0] = $retorno_codigo_autorizacao;
            $resultado[18][1] = $retorno_codigo_autorizacao;

            $nodeMensagemAutorizacao = $nodeAutorizacao->getElementsByTagName('mensagem')->item(0);
            $retorno_mensagem_autorizacao = $nodeMensagemAutorizacao->nodeValue;
            $resultado[19][0] = $retorno_mensagem_autorizacao;
            $resultado[19][1] = $retorno_mensagem_autorizacao;

            $nodeDataHoraAutorizacao = $nodeAutorizacao->getElementsByTagName('data-hora')->item(0);
            $retorno_data_hora_autorizacao = $nodeDataHoraAutorizacao->nodeValue;
            $resultado[20][0] = $retorno_data_hora_autorizacao;
            $resultado[20][1] = $retorno_data_hora_autorizacao;

            $nodeValorAutorizacao = $nodeAutorizacao->getElementsByTagName('valor')->item(0);
            $retorno_valor_autorizacao = $nodeValorAutorizacao->nodeValue;
            $resultado[21][0] = $retorno_valor_autorizacao;
            $resultado[21][1] = $retorno_valor_autorizacao;

            $nodeLRAutorizacao = $nodeAutorizacao->getElementsByTagName('lr')->item(0);
            $retorno_lr_autorizacao = $nodeLRAutorizacao->nodeValue;
            $resultado[22][0] = $retorno_lr_autorizacao;
            $resultado[22][1] = $retorno_lr_autorizacao;

            $nodeARPAutorizacao = $nodeAutorizacao->getElementsByTagName('arp')->item(0);
            $retorno_arp_autorizacao = $nodeARPAutorizacao->nodeValue;
            $resultado[23][0] = $retorno_arp_autorizacao;
            $resultado[23][1] = $retorno_arp_autorizacao;
        }

        $nodeCancelamento = $nodeTransacao->getElementsByTagName('cancelamento')->item(0);
        if ($nodeCancelamento != '') {
            $nodeCodigoCancelamento = $nodeCancelamento->getElementsByTagName('codigo')->item(0);
            $retorno_codigo_cancelamento = $nodeCodigoCancelamento->nodeValue;
            $resultado[24][0] = $retorno_codigo_cancelamento;
            $resultado[24][1] = $retorno_codigo_cancelamento;

            $nodeMensagemCancelamento = $nodeCancelamento->getElementsByTagName('mensagem')->item(0);
            $retorno_mensagem_cancelamento = $nodeMensagemCancelamento->nodeValue;
            $resultado[25][0] = $retorno_mensagem_cancelamento;
            $resultado[25][1] = $retorno_mensagem_cancelamento;

            $nodeDataHoraCancelamento = $nodeCancelamento->getElementsByTagName('data-hora')->item(0);
            $retorno_data_hora_cancelamento = $nodeDataHoraCancelamento->nodeValue;
            $resultado[26][0] = $retorno_data_hora_cancelamento;
            $resultado[26][1] = $retorno_data_hora_cancelamento;

            $nodeValorCancelamento = $nodeCancelamento->getElementsByTagName('valor')->item(0);
            $retorno_valor_cancelamento = $nodeValorCancelamento->nodeValue;
            $resultado[27][0] = $retorno_valor_cancelamento;
            $resultado[27][1] = $retorno_valor_cancelamento;
        }

        $nodeCaptura = $nodeTransacao->getElementsByTagName('captura')->item(0);
        if ($nodeCaptura != '') {
            $nodeCodigoCaptura = $nodeCaptura->getElementsByTagName('codigo')->item(0);
            $retorno_codigo_captura = $nodeCodigoCaptura->nodeValue;
            $resultado[28][0] = $retorno_codigo_captura;
            $resultado[28][1] = $retorno_codigo_captura;

            $nodeMensagemCaptura = $nodeCaptura->getElementsByTagName('mensagem')->item(0);
            $retorno_mensagem_captura = $nodeMensagemCaptura->nodeValue;
            $resultado[29][0] = $retorno_mensagem_captura;
            $resultado[29][1] = $retorno_mensagem_captura;

            $nodeDataHoraCaptura = $nodeCaptura->getElementsByTagName('data-hora')->item(0);
            $retorno_data_hora_captura = $nodeDataHoraCaptura->nodeValue;
            $resultado[30][0] = $retorno_data_hora_captura;
            $resultado[30][1] = $retorno_data_hora_captura;

            $nodeValorCaptura = $nodeCaptura->getElementsByTagName('valor')->item(0);
            $retorno_valor_captura = $nodeValorCaptura->nodeValue;
            $resultado[31][0] = $retorno_valor_captura;
            $resultado[31][1] = $retorno_valor_captura;
        }

        $nodeURLAutenticacao = $nodeTransacao->getElementsByTagName('url-autenticacao')->item(0);
        $retorno_url_autenticacao = $nodeURLAutenticacao->nodeValue;
        $resultado[32][0] = $retorno_url_autenticacao;
        $resultado[32][1] = $retorno_url_autenticacao;
    }

    return $resultado;
}
mysql_close($con);
?>
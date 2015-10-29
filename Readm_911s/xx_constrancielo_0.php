<?php
include 'lib.php';
ini_set('allow_url_fopen', 1); // Ativa a diretiva 'allow_url_fopen'

$sql = "select DS_TID_COSO from compras where ST_COMPRA_COSO = 'A' AND DS_TID_COSO IS NOT NULL 
        and DS_FORMAPGTO_COSO in ('mastercard','visa','diners')";
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
    while($row = mysql_fetch_row($st)) {
        $tidcom = $row[0];
                
        $XMLtransacao = GetURL($tidcom,"Consulta");
        
        $arrayresult = array();
        
        $arrayresult = GetResult($XMLtransacao);
        
        print_r($arrayresult);
        
        if ($arrayresult[0][0] == '') {
            echo "Compra: ".$arrayresult[4][1]."<br />";
             
            if ($arrayresult[33][1] == 4){
                //autorizada
                echo "Status: ".$arrayresult[33][1]."<br />";
                echo "Mensagem: ".utf8_decode($arrayresult[19][1])."<br /><br />";               
            }else if ($arrayresult[33][1] == 9){
                //cancelada
                echo "Status: ".$arrayresult[33][1]."<br />";
                echo "Cancelada<br /><br />";
            }else if ($arrayresult[33][1] == 3){
                //cancelada
                echo "Status: ".$arrayresult[33][1]."<br />";
                echo "Não Autorizada<br /><br />";
            }else{
                //outro status
                echo "TID: ".$arrayresult[2][1]."<br />";
                echo "Status: ".$arrayresult[33][1]."<br />";
                echo "Mensagem: ".utf8_decode($arrayresult[14][1])."<br /><br />";    
            }
            
        } else {
            echo '<b>Erro: </b>' . $arrayresult[0][0] . '<br />';
            echo '<b>Mensagem: </b>' . $arrayresult[1][1] . '<br />';
        }
        
        echo "<br /><br />";
    }
}

//$XMLtransacao = GetURL($tidcom,"Captura");

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
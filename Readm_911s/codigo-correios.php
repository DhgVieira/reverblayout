<?php

/**
 * Classe para Capturar e processar codigos de Rastreamento
 */

date_default_timezone_set('america/sao_paulo');

class CodigoCorreios
{

    private $stdCompras = array('PAGA' => 'P', 'ABERTO' => 'A', 'EXPEDIDA' => 'S', 'V' => 'ENVIADA', 'E' => 'ENTREGUE', 'CANCELADA' => 'C');

    private $strMsgError;
    private $strMsgAction;
    private $strMsgSend;
    private $intTotalErrors = 0;
    private $intTotalOk = 0;
    private $intTotalPages = 0;
    private $strMsgResult;

    private $strURL = 'http://pr.postal.net.br/postalnet/logon.php';
    private $strUserPass = 'txtusuario=prjc00446&txtsenha=625953';
    private $strCookieLog = '../../postalnet-cookie.txt';
    private $strUrlPesquisa;

    private $servername = "reverbcity1.cp48hix4ktfm.sa-east-1.rds.amazonaws.com";
    private $username = "reverb";
    private $password = "reverbserver2014";
    private $dbname = "reverb_amazon";

    public $dia;
    public $mes;
    public $ano;

    /**
     * Connect DB
     */
    private function dbConnect()
    {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    public function __construct()
    {
        include_once 'lib.php';
    }

    /**
     * @param $strDate
     * @return mixed|void
     */
    private function cURLConn($strDate)
    {
        if (empty($strDate))
            return;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->strURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->strUserPass);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->strCookieLog);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $store = curl_exec($ch);
        $this->strUrlPesquisa = 'http://pr.postal.net.br/postalnet/usuario/movimento/htmlect.php?datai=' . $strDate . '&dataf=' . $strDate . '&hrini=00:00&hrfim=23:59&r=2&desanexar=0&sx=';
        curl_setopt($ch, CURLOPT_URL, $this->strUrlPesquisa);
        $content = curl_exec($ch);

        curl_close($ch);

        return $content;

    }

    private function getRastCorreios($strDate)
    {
        $objContent = $this->cURLConn($strDate);
        $strHtml = $objContent;
        $objDom = new DOMDocument;
        @$objDom->loadHTML($strHtml);

        $objTables = $objDom->getElementsByTagName('table');

        $intCounter = 0;
        $intSubcounter = 0;

        $arrOrder = array();

        foreach ($objTables as $objTable) {
            if ($intCounter == 2) {
                if ($objTable->getElementsByTagName('table')->length > 0) {
                    foreach ($objTable->getElementsByTagName('table') as $objSubtable) {
                        if ($intSubcounter == 2) {
                            if (substr($objSubtable->nodeValue, 0, 5) == "SEDEX" || substr($objSubtable->nodeValue, 0, 9) == "ENCOMENDA") {
                                foreach ($objSubtable->getElementsByTagName('tr') as $objLine) {
                                    $objColumns = $objLine->getElementsByTagName('td');

                                    if (trim($objColumns->item(1)->textContent, " \n\r\t\0\xC2\xA0") != ""
                                        && $objColumns->item(1)->nodeValue != "Destinatário"
                                        && substr($objColumns->item(1)->nodeValue, 0, 5) != "SEDEX"
                                        && substr($objColumns->item(1)->nodeValue, 0, 9) != "ENCOMENDA"
                                    ) {
                                        $strCodCorreio = trim($objColumns->item(7)->textContent, " \n\r\t\0\xC2\xA0") . "BR";
                                        $intOrderCode = trim($objColumns->item(11)->textContent, " \n\r\t\0\xC2\xA0");
                                        $vlrOrderFrete = trim($objColumns->item(14)->textContent, " \n\r\t\0\xC2\xA0");
                                        $intOrderCep = trim($objColumns->item(2)->textContent, " \n\r\t\0\xC2\xA0");
                                        $arrOrder[$intOrderCode]['codCorreio'] = $strCodCorreio;
                                        $arrOrder[$intOrderCode]['vlrFrete'] = $vlrOrderFrete;
                                        $arrOrder[$intOrderCode]['intCep'] = $intOrderCep;
                                    }
                                }
                            }
                        }
                        $intSubcounter++;
                    }
                }
            }
            $intCounter++;
        }

        return $arrOrder;
    }

    /**
     *
     */
    public function innitOrders($boolManual = false)
    {
        $strDate = $this->dia . '/' . $this->mes . '/' . $this->ano;

        $objDB = $this->dbConnect();

        $arrRastCorreios = $this->getRastCorreios($strDate);

        foreach ($arrRastCorreios as $intCodOrder => $strCodRastCorreio) {
            $objGetOrder = $this->getOrders($intCodOrder, $objDB);
            if ($objGetOrder) {
                $objOrder = new stdClass();
                $objOrder->orderStatus = $objGetOrder->ST_COMPRA_COSO;
                $objOrder->orderNome = $objGetOrder->DS_NOME_CASO;
                $objOrder->orderMail = $objGetOrder->DS_EMAIL_CASO;
                $objOrder->orderCep = $strCodRastCorreio['intCep'];
                $objOrder->orderCodRastDB = $objGetOrder->DS_RASTREAMENTO_COSO;
                $objOrder->orderCodCorreio = $strCodRastCorreio['codCorreio'];
                $objOrder->orderFreteVlr = str_replace(",", ".", $strCodRastCorreio['vlrFrete']);
                $objOrder->orderCod = $intCodOrder;

                $this->execOrders($objOrder, $objDB);

            }
        }

        if ((count($this->intTotalErrors)) || (count($this->intTotalOk)))
            $objEmailResult = $this->sendMailResult();
        else
            $objEmailResult = $this->sendMailResult(true);

        return $this->strMsgResult;

    }

    /**
     * @return string
     */
    private function htmlResult() {
        return "<script language='JavaScript>alert(" . $this->strMsgResult . ");top.window.location.href = ('config.php');</script>";
    }

    /**
     * @param integer Código da Compra
     * @return resource|void
     */
    private function getOrders($codCompra, $objDB)
    {

        $strQuery = "
				SELECT
					ST_COMPRA_COSO,
					DS_RASTREAMENTO_COSO,
					DS_NOME_CASO,
					DS_EMAIL_CASO
				FROM compras, cadastros
				WHERE NR_SEQ_CADASTRO_COSO = NR_SEQ_CADASTRO_CASO AND NR_SEQ_COMPRA_COSO = " . $codCompra;

        if ($result = $objDB->query($strQuery)) {
            return $result->fetch_object();
            $result->close();
        }

        return;
    }

    /**
     * @param $objOrder
     * @param $objDB
     * @return bool
     */
    private function setOrder($objOrder, $objDB)
    {

        $strSql = "UPDATE compras SET DS_RASTREAMENTO_COSO ='$objOrder->orderCodCorreio', VL_FRETECUSTO_COSO = $objOrder->orderFreteVlr, ST_COMPRA_COSO = 'V' WHERE NR_SEQ_COMPRA_COSO = " . $objOrder->orderCod;
        //$strSql = "UPDATE teste_orders SET DS_RASTREAMENTO_COSO ='$objOrder->orderCodCorreio', VL_FRETECUSTO_COSO = $objOrder->orderFreteVlr, ST_COMPRA_COSO = 'V' WHERE NR_SEQ_COMPRA_COSO = 1";

        if ($objDB->query($strSql) === TRUE)
            return true;
    }


    /**
     * @param $objOrder
     * @param $objDB
     */
    private function execOrders($objOrder, $objDB)
    {

        $strMsgRast = "Rast.: $objOrder->orderCodCorreio - Nome: " . $objOrder->orderNome . " - Vlr.Frete: R$ " . number_format($objOrder->orderFreteVlr, 2, ",", "") . " - Cep: " . $objOrder->orderCep . " - Compra: <a href=http://www.reverbcity.com/Readm_911s/compras_ver.php?idc=" . $objOrder->orderCod . " target=_blank>$objOrder->orderCod</a><br />";

        switch ($objOrder->orderStatus) {
            case 'A':
                $this->logErrors($strMsgRast . "<font color=red>A compra informada ainda está em aberta!!</font><br /><br />");
                $this->intTotalErrors++;
                break;
            case 'P':
                if ($objOrder->orderCodRastDB) {
                    $this->logErrors($strMsgRast . "<font color=red>A compra informada Já possui um código de rastreamento!!</font><br /><br />");
                    $this->intTotalErrors++;
                } else {
                    $this->logAction($strMsgRast);
                    $boolSetOrder = $this->setOrder($objOrder, $objDB);
                    if (count($boolSetOrder)) {
                        $strSubject = utf8_encode("ReverbCity - Confirmação de Envio (Rastreamento)!");

                        $strTexto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 25px 25px; width: 550px;">
							Pronto para o Rock and Roll, <strong>' . utf8_decode($objOrder->orderNome) . '</strong>?
							<br /><br />
							A turnê da sua camiseta vai começar! Segue abaixo o código de rastreamento da sua compra número <strong>' . $objOrder->orderCod . '</strong>
							</div>
							<div style="background-color: #dcddde; padding: 25px; font-family:Verdana;font-size:12px;color: #313131; width: 550px;">
							Código: <strong>' . $objOrder->orderCodCorreio . '</strong>
							</div>
							<p style="font-family:Verdana;font-size:11px;color: #555555;padding: 0 25px 0 25px;">
							Para consultar o status do envio acesse o nosso site clicando no link <strong>Rastreamento</strong> no<br/ >rodapé e informe o código acima.
							<br /><br /></p>
							';

                        $objMailCorpo = IncluiPapelCarta("rast", $strTexto, "ReverbCity RASTREAMENTO");

                        EnviaMailer("atendimento@reverbcity.com", "Reverbcity", $objOrder->orderMail, $objOrder->orderNome, "", $strSubject, $objMailCorpo);

                        $this->logAction("Dados atualizados com sucesso.<br />");
                        $this->intTotalOk++;

                    } else {
                        $this->logErrors($strMsgRast . "<font color=red>Erro ao atualizar compra no banco</font><br /><br />");
                        $this->intTotalErrors++;
                    }
                }
                break;
            case 'E':
                $this->logErrors($strMsgRast . "<font color=red>A compra informada já está setada como entregue!!</font><br /><br />");
                $this->intTotalErrors++;
                break;
            default;
                $this->logSend($strMsgRast . " - ST: $objOrder->orderStatus<br />");
                break;
        }
    }

    /**
     *
     */
    private function sendMailResult($boolTotalZero = false)
    {

        if(empty($boolTotalZero)) {

            $strTexto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                    <p>Período processado: <strong>' . $this->dia . '/' . $this->mes . '/' . $this->ano . ' 00:00 a ' . $this->dia . '/' . $this->mes . '/' . $this->ano . ' 23:59</strong><br /><br /></p>

                    <p><strong>' . $this->intTotalErrors . ' erros para Verificação Manual:</p>
                    </div>';
            if (count($this->intTotalErrors)) {
                $strTexto .= '<div style="background-color: #dcddde; padding: 15px 10px 15px 25px; font-family:Verdana;font-size:11px;color: #646464; width: 565px; margin: 25px 0 25px 0;">
            ' . $this->strMsgError . '
            </div>';
            }
            $strTexto .= '<p style="font-family:Verdana;font-size:11px;color: #555555;padding: 0 25px 0 25px;">
        ' . $this->intTotalOk . ' Processados com Sucesso:</p>';
            if (count($this->intTotalOk)) {
                $strTexto .= '<div style="background-color: #dcddde; padding: 15px 10px 15px 25px; font-family:Verdana;font-size:11px;color: #646464; width: 565px; margin: 25px 0 25px 0;">
            ' . $this->strMsgAction . '
            </div>';
            }
            $strTexto .= '<br /><br />';

            $strCorpo = IncluiPapelCarta("sistema", utf8_decode($strTexto), utf8_decode("IMPORTAÇÃO DOS CÓDIGOS DE RASTREAMENTO"));

            EnviaMailer("atendimento@reverbcity.com", "Reverbcity", "contato@reverbcity.com", "Tony", "", "Importação dos códigos de rastreamento processada!", utf8_encode($strCorpo));
            EnviaMailer("atendimento@reverbcity.com", "Reverbcity", "atendimento@reverbcity.com", "Miria", "", "Importação dos códigos de rastreamento processada!", utf8_encode($strCorpo));
            EnviaMailer("atendimento@reverbcity.com", "Reverbcity", "desenvolvimento@reverbcity.com", "DEV - RVB", "", "Importação dos códigos de rastreamento processada!", utf8_encode($strCorpo));
            $this->strMsgResult = "'Captura realizada com sucesso!\\n " . $this->intTotalErrors . "erros para Verificacao Manual\\n " . $this->intTotalOk . " processados com Sucesso.'";
        } else {
            EnviaMailer("atendimento@reverbcity.com", "Reverbcity", "desenvolvimento@reverbcity.com", "DEV - RVB", "", "Importação dos códigos de rastreamento processada!", "<strong>Rodou mas nao achou registros - paginas: $this->intTotalPages</strong><br />$this->strUrlPesquisa<br />$this->strMsgSend");
            $this->strMsgResult = "'Captura realizada porem nao achou registros para importar'";
        }

        return $strCorpo;
    }

    /**
     * @param $strMsg
     */
    private function logErrors($strMsg)
    {
        $this->strMsgError .= $strMsg;
    }

    /**
     * @param $strMsg
     */
    private function logAction($strMsg)
    {
        $this->strMsgAction .= $strMsg;
    }

    /**
     * @param $strMsg
     */
    private function logSend($strMsg)
    {
        $this->strMsgSend .= $strMsg;
    }
}
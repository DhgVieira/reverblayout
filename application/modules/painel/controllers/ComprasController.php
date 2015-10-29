<?php

/**
 *
 */
class Painel_ComprasController extends Reverb_Controller_Action {
    /**
     *
     */
    public function init() {
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
        date_default_timezone_set('America/Sao_Paulo');
    }

    /**
     *
     */
    public function indexAction() {
        $modelCompras = new Default_Model_Compras();

        $selectCompras = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->join(array('ca' => 'cadastros'), 'ca.NR_SEQ_CADASTRO_CASO = c.NR_SEQ_CADASTRO_COSO', array())
            ->columns(array(
                'c.NR_SEQ_COMPRA_COSO',
                'c.DT_COMPRA_COSO',
                'ca.NR_SEQ_CADASTRO_CASO',
                'ca.DS_NOME_CASO',
                'c.DS_FORMAPGTO_COSO',
                'c.VL_TOTAL_COSO',
                'c.ST_COMPRA_COSO',
                'ca.DS_DDDCEL_CASO',
                'ca.DS_CELULAR_CASO'
            ))
            ->where('c.ST_COMPRA_COSO = "A"')
            ->order('c.NR_SEQ_COMPRA_COSO DESC')
            ->setIntegrityCheck(FALSE);

        $current_page = $this->_request->getParam("page", 1);
        $dadosCompras = new Reverb_Paginator($selectCompras);
        $dadosCompras->setItemCountPerPage(10)
            ->setCurrentPageNumber($current_page)
            ->setPageRange(5)
            ->assign();

        $modelNotaFiscal = new Default_Model_Notafiscal();
        $dadosNotaFiscal = $modelNotaFiscal->fetchRow(null, array('DT_EMISSAO_NFRC desc', 'NR_SEQ_NFE_NFRC desc'));

        $this->view->dadosNotaFiscal = $dadosNotaFiscal;
        $this->view->dadosCompras = $dadosCompras;
    }

    public function printAction(){
        $this->_helper->layout->disableLayout();

        $id = $this->_request->getParam('id');

        $modelCompras = new Default_Model_Compras();
        $modelCesta = new Default_Model_Cestas();

        $selectCompras = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->join(array('cd' => 'cadastros'), 'cd.NR_SEQ_CADASTRO_CASO = c.NR_SEQ_CADASTRO_COSO', array())
            ->joinLeft(array('et' => 'enderecos'), 'et.NR_SEQ_COMPRA_ENRC = c.NR_SEQ_COMPRA_COSO', array())
            ->columns(array(
                'c.NR_SEQ_COMPRA_COSO',
                'c.DT_COMPRA_COSO',
                'c.VL_TOTAL_COSO',
                'c.VL_FRETE_COSO',
                'c.DS_IP_COSO',
                'c.ST_COMPRA_COSO',
                'c.DS_FORMAPGTO_COSO',
                'c.DT_STATUS_COSO',
                'c.NR_PARCELAS_COSO',
                'c.DS_RASTREAMENTO_COSO',
                'c.DS_TID_COSO',
                'c.DS_FORMAENVIO_COSO',
                'cd.NR_SEQ_CADASTRO_CASO',
                'cd.DS_NOME_CASO',
                'cd.DS_ENDERECO_CASO',
                'cd.DS_NUMERO_CASO',
                'cd.DS_CIDADE_CASO',
                'cd.DS_UF_CASO',
                'cd.DS_CEP_CASO',
                'cd.DS_COMPLEMENTO_CASO',
                'cd.DT_NASCIMENTO_CASO',
                'cd.DS_CPFCNPJ_CASO',
                'cd.DS_EMAIL_CASO',
                'cd.DS_DDDFONE_CASO',
                'cd.DS_FONE_CASO',
                'cd.DS_BAIRRO_CASO',
                'et.DS_DESTINATARIO_ENRC',
                'et.DS_ENDERECO_ENRC',
                'et.DS_NUMERO_ENRC',
                'et.DS_COMPLEMENTO_ENRC',
                'et.DS_BAIRRO_ENRC',
                'et.DS_CEP_ENRC',
                'et.DS_CIDADE_ENRC',
                'et.DS_UF_ENRC',
                'et.DS_FONE_ENRC'
            ))
            ->where('c.NR_SEQ_COMPRA_COSO = ?', $id)
            ->setIntegrityCheck(FALSE);
        $dadosCompra = $modelCompras->fetchRow($selectCompras);

        $selectCesta = $modelCesta->select()
            ->from(array('ce' => 'cestas'), array())
            ->join(array('p' => 'produtos'), 'p.NR_SEQ_PRODUTO_PRRC = ce.NR_SEQ_PRODUTO_CESO', array())
            ->join(array('t' => 'tamanhos'), 't.NR_SEQ_TAMANHO_TARC = ce.NR_SEQ_TAMANHO_CESO', array())
            ->columns(array(
                'ce.VL_PRODUTO_CESO',
                'ce.VL_COM_DESCONTO',
                'ce.NR_QTDE_CESO',
                'p.NR_SEQ_PRODUTO_PRRC',
                'p.DS_PRODUTO2_PRRC',
                'p.DS_REFERENCIA_PRRC',
                't.DS_TAMANHO_TARC'
            ))
            ->where('ce.NR_SEQ_COMPRA_CESO = ?', $id)
            ->setIntegrityCheck(FALSE);
        $dadosCesta = $modelCesta->fetchAll($selectCesta);

        $this->view->dadosCompra = $dadosCompra;
        $this->view->dadosCesta = $dadosCesta;
    }

    public function semComprasAction(){
        
    }

    public function comprasPagasAction(){
        $modelCompras = new Default_Model_Compras();

        $selectCompras = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->join(array('ca' => 'cadastros'), 'ca.NR_SEQ_CADASTRO_CASO = c.NR_SEQ_CADASTRO_COSO', array())
            ->columns(array(
                'c.NR_SEQ_COMPRA_COSO',
                'c.DT_COMPRA_COSO',
                'ca.NR_SEQ_CADASTRO_CASO',
                'ca.DS_NOME_CASO',
                'c.DS_FORMAPGTO_COSO',
                'c.VL_TOTAL_COSO',
                'c.ST_COMPRA_COSO',
                'ca.DS_DDDCEL_CASO',
                'ca.DS_CELULAR_CASO'
            ))
            ->where('c.ST_COMPRA_COSO = "P"')
            ->where('c.ST_SEPARADO_COSO IS NULL')
            ->order('c.NR_SEQ_COMPRA_COSO DESC')
            ->setIntegrityCheck(FALSE);

        $current_page = $this->_request->getParam("page", 1);
        $dadosCompras = new Reverb_Paginator($selectCompras);
        $dadosCompras->setItemCountPerPage(10)
            ->setCurrentPageNumber($current_page)
            ->setPageRange(5)
            ->assign();

        $modelNotaFiscal = new Default_Model_Notafiscal();
        $dadosNotaFiscal = $modelNotaFiscal->fetchRow(null, array('DT_EMISSAO_NFRC desc', 'NR_SEQ_NFE_NFRC desc'));

        $this->view->dadosNotaFiscal = $dadosNotaFiscal;
        $this->view->dadosCompras = $dadosCompras;
    }

    public function comprasExpedidasAction(){
        $modelCompras = new Default_Model_Compras();

        $selectCompras = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->join(array('ca' => 'cadastros'), 'ca.NR_SEQ_CADASTRO_CASO = c.NR_SEQ_CADASTRO_COSO', array())
            ->columns(array(
                'c.NR_SEQ_COMPRA_COSO',
                'c.DT_COMPRA_COSO',
                'ca.DS_NOME_CASO',
                'c.DS_FORMAPGTO_COSO',
                'c.VL_TOTAL_COSO',
                'c.ST_COMPRA_COSO',
                'ca.NR_SEQ_CADASTRO_CASO',
                'ca.DS_DDDCEL_CASO',
                'ca.DS_CELULAR_CASO'
            ))
            ->where('c.ST_COMPRA_COSO = "P"')
            ->where('c.ST_SEPARADO_COSO = "S"')
            ->order('c.NR_SEQ_COMPRA_COSO DESC')
            ->setIntegrityCheck(FALSE);

        $current_page = $this->_request->getParam("page", 1);
        $dadosCompras = new Reverb_Paginator($selectCompras);
        $dadosCompras->setItemCountPerPage(10)
            ->setCurrentPageNumber($current_page)
            ->setPageRange(5)
            ->assign();

        $modelNotaFiscal = new Default_Model_Notafiscal();
        $dadosNotaFiscal = $modelNotaFiscal->fetchRow(null, array('DT_EMISSAO_NFRC desc', 'NR_SEQ_NFE_NFRC desc'));

        $this->view->dadosNotaFiscal = $dadosNotaFiscal;
        $this->view->dadosCompras = $dadosCompras;
    }

    public function comprasEnviadasAction(){
        $modelCompras = new Default_Model_Compras();

        $selectCompras = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->join(array('ca' => 'cadastros'), 'ca.NR_SEQ_CADASTRO_CASO = c.NR_SEQ_CADASTRO_COSO', array())
            ->columns(array(
                'c.NR_SEQ_COMPRA_COSO',
                'c.DT_COMPRA_COSO',
                'ca.DS_NOME_CASO',
                'c.DS_FORMAPGTO_COSO',
                'c.VL_TOTAL_COSO',
                'c.ST_COMPRA_COSO',
                'ca.NR_SEQ_CADASTRO_CASO',
                'ca.DS_DDDCEL_CASO',
                'ca.DS_CELULAR_CASO'
            ))
            ->where('c.ST_COMPRA_COSO = "V"')
            ->order('c.NR_SEQ_COMPRA_COSO DESC')
            ->setIntegrityCheck(FALSE);

        $current_page = $this->_request->getParam("page", 1);
        $dadosCompras = new Reverb_Paginator($selectCompras);
        $dadosCompras->setItemCountPerPage(10)
            ->setCurrentPageNumber($current_page)
            ->setPageRange(5)
            ->assign();

        $modelNotaFiscal = new Default_Model_Notafiscal();
        $dadosNotaFiscal = $modelNotaFiscal->fetchRow(null, array('DT_EMISSAO_NFRC desc', 'NR_SEQ_NFE_NFRC desc'));

        $this->view->dadosNotaFiscal = $dadosNotaFiscal;
        $this->view->dadosCompras = $dadosCompras;
    }

    public function comprasEntreguesAction(){
        $modelCompras = new Default_Model_Compras();

        $selectCompras = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->join(array('ca' => 'cadastros'), 'ca.NR_SEQ_CADASTRO_CASO = c.NR_SEQ_CADASTRO_COSO', array())
            ->columns(array(
                'c.NR_SEQ_COMPRA_COSO',
                'c.DT_COMPRA_COSO',
                'ca.DS_NOME_CASO',
                'c.DS_FORMAPGTO_COSO',
                'c.VL_TOTAL_COSO',
                'c.ST_COMPRA_COSO',
                'ca.NR_SEQ_CADASTRO_CASO',
                'ca.DS_DDDCEL_CASO',
                'ca.DS_CELULAR_CASO'
            ))
            ->where('c.ST_COMPRA_COSO = "E"')
            ->order('c.NR_SEQ_COMPRA_COSO DESC')
            ->setIntegrityCheck(FALSE);

        $current_page = $this->_request->getParam("page", 1);
        $dadosCompras = new Reverb_Paginator($selectCompras);
        $dadosCompras->setItemCountPerPage(10)
            ->setCurrentPageNumber($current_page)
            ->setPageRange(5)
            ->assign();

        $modelNotaFiscal = new Default_Model_Notafiscal();
        $dadosNotaFiscal = $modelNotaFiscal->fetchRow(null, array('DT_EMISSAO_NFRC desc', 'NR_SEQ_NFE_NFRC desc'));

        $this->view->dadosNotaFiscal = $dadosNotaFiscal;
        $this->view->dadosCompras = $dadosCompras;
    }

    public function comprasCanceladasAction(){
        $modelCompras = new Default_Model_Compras();

        $selectCompras = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->join(array('ca' => 'cadastros'), 'ca.NR_SEQ_CADASTRO_CASO = c.NR_SEQ_CADASTRO_COSO', array())
            ->columns(array(
                'c.NR_SEQ_COMPRA_COSO',
                'c.DT_COMPRA_COSO',
                'ca.DS_NOME_CASO',
                'c.DS_FORMAPGTO_COSO',
                'c.VL_TOTAL_COSO',
                'c.ST_COMPRA_COSO',
                'ca.NR_SEQ_CADASTRO_CASO',
                'ca.DS_DDDCEL_CASO',
                'ca.DS_CELULAR_CASO'
            ))
            ->where('c.ST_COMPRA_COSO = "C"')
            ->order('c.NR_SEQ_COMPRA_COSO DESC')
            ->setIntegrityCheck(FALSE);

        $current_page = $this->_request->getParam("page", 1);
        $dadosCompras = new Reverb_Paginator($selectCompras);
        $dadosCompras->setItemCountPerPage(10)
            ->setCurrentPageNumber($current_page)
            ->setPageRange(5)
            ->assign();

        $this->view->dadosCompras = $dadosCompras;
    }

    public function buscaAction(){
        if($this->_request->isPost()){
            $termo = $this->_request->getParam('termo');

            if(!empty($termo)){
                $this->_redirect('/painel/compras/busca/busca/' . $termo);
            }else{
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        }

        $modelCompras = new Default_Model_Compras();

        $selectCompras = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->join(array('ca' => 'cadastros'), 'ca.NR_SEQ_CADASTRO_CASO = c.NR_SEQ_CADASTRO_COSO', array())
            ->columns(array(
                'c.NR_SEQ_COMPRA_COSO',
                'c.DT_COMPRA_COSO',
                'ca.DS_NOME_CASO',
                'c.DS_FORMAPGTO_COSO',
                'c.VL_TOTAL_COSO',
                'c.ST_COMPRA_COSO'
            ))
            ->order('c.NR_SEQ_COMPRA_COSO DESC')
            ->setIntegrityCheck(FALSE);

        $busca = $this->_request->getParam('busca');

        if(!empty($busca)){
            $selectCompras->where('NR_SEQ_COMPRA_COSO = ?', $busca)
                ->orWhere('DS_NOME_CASO LIKE ?',  '%' . $busca . '%')
                ->orWhere('DS_EMAIL_CASO LIKE ?', '%' . $busca . '%');

            $this->view->busca = $busca;
        }

        $current_page = $this->_request->getParam("page", 1);
        $dadosCompras = new Reverb_Paginator($selectCompras);
        $dadosCompras->setItemCountPerPage(10)
            ->setCurrentPageNumber($current_page)
            ->setPageRange(5)
            ->assign();

        $this->view->dadosCompras = $dadosCompras;
    }

    public function resumoAction(){
        $this->_helper->layout()->disableLayout();

        $id = $this->_request->getParam('id');

        $modelCompras = new Default_Model_Compras();
        $modelCesta = new Default_Model_Cestas();

        $selectCompras = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->join(array('cd' => 'cadastros'), 'NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO', array())
            ->columns(array(
                'c.NR_SEQ_COMPRA_COSO',
                'c.DT_COMPRA_COSO',
                'c.VL_TOTAL_COSO',
                'c.VL_FRETE_COSO',
                'c.ST_COMPRA_COSO',
                'c.DS_FORMAPGTO_COSO',
                'c.DS_IP_COSO',
                'c.DT_STATUS_COSO',
                'c.NR_PARCELAS_COSO',
                'c.DS_RASTREAMENTO_COSO',
                'c.DS_TID_COSO',
                'cd.NR_SEQ_CADASTRO_CASO',
                'cd.DS_NOME_CASO',
                'cd.DS_ENDERECO_CASO',
                'cd.DS_NUMERO_CASO',
                'cd.DS_CIDADE_CASO',
                'cd.DS_UF_CASO',
                'cd.DS_CEP_CASO',
                'cd.DS_COMPLEMENTO_CASO',
                'cd.DT_NASCIMENTO_CASO',
                'cd.DS_CPFCNPJ_CASO',
                'cd.DS_EMAIL_CASO',
                'cd.DS_DDDFONE_CASO',
                'cd.DS_FONE_CASO'
            ))
            ->where('c.NR_SEQ_COMPRA_COSO = ?', $id)
            ->setIntegrityCheck(FALSE);
        $dadosCompra = $modelCompras->fetchRow($selectCompras);

        $selectCesta = $modelCesta->select()
            ->from(array('ce' => 'cestas'), array())
            ->join(array('p' => 'produtos'), 'p.NR_SEQ_PRODUTO_PRRC = ce.NR_SEQ_PRODUTO_CESO', array())
            ->join(array('t' => 'tamanhos'), 't.NR_SEQ_TAMANHO_TARC = ce.NR_SEQ_TAMANHO_CESO', array())
            ->columns(array(
                'ce.VL_PRODUTO_CESO',
                'ce.VL_COM_DESCONTO',
                'ce.NR_QTDE_CESO',
                'p.NR_SEQ_PRODUTO_PRRC',
                'p.DS_PRODUTO2_PRRC',
                'p.DS_REFERENCIA_PRRC',
                't.DS_TAMANHO_TARC'
            ))
            ->where('ce.NR_SEQ_COMPRA_CESO = ?', $id)
            ->setIntegrityCheck(FALSE);
        $dadosCesta = $modelCesta->fetchAll($selectCesta);

        $selectUltimasCompras = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->columns(array(
                'c.NR_SEQ_COMPRA_COSO',
                'c.DT_COMPRA_COSO',
                'c.DS_FORMAPGTO_COSO',
                'c.VL_TOTAL_COSO',
                'c.ST_COMPRA_COSO',
                'total_item' => "(SELECT SUM(NR_QTDE_CESO) FROM cestas WHERE NR_SEQ_CESTA_CESO = c.NR_SEQ_COMPRA_COSO)"
            ))
            ->limit(5)
            ->where('c.NR_SEQ_CADASTRO_COSO = ?', $dadosCompra->NR_SEQ_CADASTRO_CASO)
            ->order('c.NR_SEQ_COMPRA_COSO DESC');
        $dadosUltimasCompras = $modelCompras->fetchAll($selectUltimasCompras);

        $this->view->dadosCompra = $dadosCompra;
        $this->view->dadosCesta = $dadosCesta;
        $this->view->dadosUltimasCompras = $dadosUltimasCompras;
    }

    public function cancelarAction(){
        $id = $this->_request->getParam('id');

        $messages = new Zend_Session_Namespace("messages");
        $session = new Zend_Session_Namespace("login");

        $modelCompras = new Default_Model_Compras();

        $dadosCompra = $modelCompras->fetchRow(array('NR_SEQ_COMPRA_COSO = ?' => $id));

        if($dadosCompra->ST_COMPRA_COSO == 'C'){
            $messages->error = 'Esta compra já está cancelada.';
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }else{
            $modelCesta = new Default_Model_Cestas();
            $dadosCesta = $modelCesta->fetchAll(array('NR_SEQ_COMPRA_CESO = ?' => $id));

            $modelEstoque = new Default_Model_Estoque();
            $modelEstoqueControle = new Default_Model_Estoquecontrole();

            foreach($dadosCesta as $cesta){
                $dadosEstoque = $modelEstoque->fetchRow(array(
                    'NR_SEQ_PRODUTO_ESRC = ?' => $cesta->NR_SEQ_PRODUTO_CESO,
                    'NR_SEQ_TAMANHO_ESRC = ?' => $cesta->NR_SEQ_TAMANHO_CESO
                ));

                $modelEstoque->update(array(
                    'NR_QTDE_ESRC' => $dadosEstoque->NR_QTDE_ESRC + $cesta->NR_QTDE_CESO
                ), array(
                    'NR_SEQ_TAMANHO_ESRC = ?' => $cesta->NR_SEQ_TAMANHO_CESO,
                    'NR_SEQ_PRODUTO_ESRC = ?' => $cesta->NR_SEQ_PRODUTO_CESO
                ));

                $modelEstoqueControle->insert(array(
                    'NR_SEQ_PRODUTO_ECRC' => $cesta->NR_SEQ_PRODUTO_CESO,
                    'NR_SEQ_USUARIO_ECRC' => $session->logged_usuario['NR_SEQ_USUARIO_USRC'],
                    'NR_SEQ_TAMANHO_ECRC' => $cesta->NR_SEQ_TAMANHO_CESO,
                    'DS_ACAO_ECRC' => 'Adicionou ' . $cesta->NR_QTDE_CESO,
                    'DS_OBS_ECRC' => 'Cancelamento compra ' . $id,
                    'DT_ACAO_ECRC' => date("Y-m-d H:i:s"),
                    'NR_QTDE_ECRC' => $cesta->NR_QTDE_CESO
                ));
            }

            $modelCompras->update(array(
                'ST_COMPRA_COSO' => 'C'
            ), array('NR_SEQ_COMPRA_COSO = ?' => $id));

            $messages->success = 'Compra cancelada com sucesso.';
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function confirmarPagamentoAction(){
        $id = $this->_request->getParam('id');

        $messages = new Zend_Session_Namespace("messages");

        $modelCompras = new Default_Model_Compras();

        $selectCompra = $modelCompras->select()
            ->from(array('c' => 'compras'))
            ->join(array('cd' => 'cadastros'), 'cd.NR_SEQ_CADASTRO_CASO = c.NR_SEQ_CADASTRO_COSO')
            ->where('c.NR_SEQ_COMPRA_COSO = ?', $id)
            ->setIntegrityCheck(false);

        $dadosCompra = $modelCompras->fetchRow($selectCompra);

        if($dadosCompra->ST_COMPRA_COSO == 'C'){
            $messages->error = 'Você não pode confirmar uma compra cancelada.';
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }else{
            $modelCompras->update(array(
                'DT_PAGAMENTO_COSO' => date("Y-m-d H:i:s"),
                'DT_STATUS_COSO' => date("Y-m-d H:i:s"),
                'ST_COMPRA_COSO' => 'P'
            ), array('NR_SEQ_COMPRA_COSO = ?' => $id));

            $emailPlugin = new Reverb_Controller_Plugin_Email();

            $texto = '<div style="font-family:Verdana;font-size:11px;color: #555555; padding: 0 25px 0 25px; width: 550px;">
                        <p>Olá <strong>'.$dadosCompra->DS_NOME_CASO.'</strong>,</p>

                        <p>O seu pagamento referente ao pedido <a href="http://reverbcity.com/reverbme/minhascompras"><strong>'.$id.'</strong></a> foi confirmado com sucesso e já estamos separando sua compra aqui na Reverbcity!</p>
                        <p>Assim que seu pedido for enviado, você receberá no seu email o código de rastreamento e atualizações sobre o percurso do sua encomenda.</p>

                            <p>Qualquer dúvida basta entrar em contato: <strong><a href=mailto:atendimento@reverbcity.com>atendimento@reverbcity.com</a></strong></p>
                        </div>
                        <div style="background-color: #dcddde; padding: 15px 10px 15px 15px; font-family:Verdana;font-size:11px;color: #646464; width: 575px; margin: 25px 0 25px 0;">
                             <b>Prazo para a postagem:</b>
                                                    Pedidos com o pagamento confirmado até as 13:00 de um dia útil serão postados no mesmo dia, após este horário a postagem se dará no próximo dia útil.

                                                    Prazo para a entrega:
                                                    Os prazos de entregam dependem da forma de envio escolhida durante a compra.

                                                    Os envios por E-sedex, Sedex e TAM levam em média três dias úteis após a postagem.

                                                    Os envios por PAC podem levar até 23 dias úteis, dependendo da região do país. Veja abaixo o prazo médio para sua região:
                                                    1 a 2 dias úteis para as capitais PR, SC, SP, RJ e MG
                                                    3 a 7 dias úteis para demais cidades do interior e os estados RS, DF, ES, GO, MS, BA, MT, SE e TO
                                                    7 a 12 dias úteis para os estados e capitais de AL, AC, AP, CE, MA, PA, PB, PE, PI, RN, RO e RR
                                                    até 23 dias úteis para AM
                        </div>';

            $htmlBody = $emailPlugin->papelCarta('ReverbCity - Confirmação de Pagamento!', $texto);

            $config = array(
                'auth' => 'login',
                'username' => "atendimento@reverbcity.com",
                'password' => "ramones@334",
                'ssl' => "ssl",
                'port' => "465"
            );
            $mailTransport = new Zend_Mail_Transport_Smtp("smtp.gmail.com", $config);

            $emailAdm = "atendimento@reverbcity.com";
            $mail = new Zend_Mail('UTF-8');
            $mail->setBodyHtml($htmlBody);
            $mail->addTo($dadosCompra->DS_EMAIL_CASO, $dadosCompra->DS_NOME_CASO);
            $mail->setFrom($emailAdm, "Reverbcity");
            $mail->setReturnPath($emailAdm);
            $mail->setSubject("ReverbCity - Confirmação de Pagamento!");
            $mail->send($mailTransport);

            $messages->success = 'Pagamento confirmado com sucesso.';
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function enviarExpedidaAction(){

        $id = $this->_request->getParam('id');

        $messages = new Zend_Session_Namespace("messages");

        if(!empty($id)){
            $modelCompras = new Default_Model_Compras();

            $dadosCompra = $modelCompras->fetchRow(array('NR_SEQ_COMPRA_COSO = ?' => $id));

            if($dadosCompra->ST_SEPARADO_COSO != 'S'){
                $modelCompras->update(array('ST_SEPARADO_COSO' => 'S'), array('NR_SEQ_COMPRA_COSO = ?' => $id));
                $messages->success = 'Compra expedida com sucesso.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }else{
                $messages->error = 'Essa compra já foi expedida.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $messages->error = 'Erro ao enviar compra para expedidas.';
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function enviarSmsAction(){
        $this->_helper->layout()->disableLayout();

        if($this->_request->isPost()){
            $dados = $this->_request->getParams();

            $messages = new Zend_Session_Namespace("messages");

            if(!empty($dados['celular']) && !empty($dados['mensagem'])){
                $sms = new Reverb_Controller_Plugin_Sms();
                $sms->enviarSms($dados['celular'], $dados['mensagem']);

                $messages->success = "SMS enviado com sucesso.";
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }else{
                $messages->error = "Erro ao enviar SMS.";
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $id = $this->_request->getParam('id');

            $modelCompras = new Default_Model_Compras();

            $selectCompra = $modelCompras->select()
                ->from(array('c' => 'compras'), array())
                ->join(array('cd' => 'cadastros'), 'cd.NR_SEQ_CADASTRO_CASO = c.NR_SEQ_CADASTRO_COSO', array())
                ->columns(array(
                    'cd.DS_NOME_CASO',
                    'DS_DDDCEL_CASO' => "IF(LEFT(cd.DS_DDDCEL_CASO, 1) = 0, SUBSTRING(cd.DS_DDDCEL_CASO, 2), cd.DS_DDDCEL_CASO)",
                    'cd.DS_CELULAR_CASO'
                ))
                ->where('c.NR_SEQ_COMPRA_COSO = ?', $id)
                ->setIntegrityCheck(FALSE);
            $dadosCompra = $modelCompras->fetchRow($selectCompra);

            $this->view->dadosCompra = $dadosCompra;
        }
    }

    public function valorFreteAction(){
        $id     = $this->_request->getParam('id');
        $valor  = $this->_request->getParam('valor');

        if(!empty($id) && !empty($valor)){

            $modelCompras = new Default_Model_Compras();

            $valor = str_replace(',','.', $valor);

            $modelCompras->update(array(
                'VL_FRETE_COSO' => $valor
            ), array('NR_SEQ_COMPRA_COSO = ?' => $id));
        }

        $valor = number_format($valor, 2, ',', '');

        $this->_helper->json($valor);
    }

    public function codigoRastreamentoAction(){
        $id     = $this->_request->getParam('id');
        $codigo = $this->_request->getParam('codigo');

        if(!empty($id) && !empty($codigo)){

            $modelCompras = new Default_Model_Compras();

            $modelCompras->update(array(
                'DS_RASTREAMENTO_COSO' => $codigo
            ), array('NR_SEQ_COMPRA_COSO = ?' => $id));
        }

        $this->_helper->json($codigo);
    }

    public function gerarBoletoAction(){
        $id = $this->_request->getParam('id');

        require APPLICATION_PATH . '/../library/Reverb/Library/pagarme/Pagarme.php';
        Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

        $modelCompras = new Default_Model_Compras();

        $selectCompra = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->join(array('cd' => 'cadastros'), 'cd.NR_SEQ_CADASTRO_CASO = c.NR_SEQ_CADASTRO_COSO', array())
            ->columns(array(
                'cd.DS_NOME_CASO',
                'cd.DS_CPFCNPJ_CASO',
                'cd.DS_EMAIL_CASO',
                'c.VL_TOTAL_COSO'
            ))
            ->where('c.NR_SEQ_COMPRA_COSO = ?', $id)
            ->setIntegrityCheck(FALSE);
        $dadosCompra = $modelCompras->fetchRow($selectCompra);

        $valor_final = number_format((float) $dadosCompra->VL_TOTAL_COSO, 2, '', '');

        $vencimentoBoleto = date(DATE_ISO8601, strtotime("+3 days"));

        try{
            $transaction = new PagarMe_Transaction(array(
                'payment_method' => 'boleto',
                'amount' => $valor_final,
                'postback_url' => 'https://www.reverbcity.com/checkout2/status-boleto',
                'boleto_expiration_date' => $vencimentoBoleto,
                'customer' => array(
                    'name' => $dadosCompra->DS_NOME_CASO,
                    'document_number' => $dadosCompra->DS_CPFCNPJ_CASO,
                    'email' => $dadosCompra->DS_EMAIL_CASO
                ),
                'metadata' => array('id_pedido' => $id)
            ));

            $transaction->charge();
            $urlBoleto = $transaction->getBoletoUrl();

            $data = array(
                'DS_TID_COSO' => $transaction->id
            );
            $modelCompras->update($data, array('NR_SEQ_COMPRA_COSO = ?' => $id));

        }catch (Exception $e){
            die($e->getMessage());
        }

        die($urlBoleto);

    }

    public function segundaViaBoletoAction(){
        $id = $this->_request->getParam('id');

        require APPLICATION_PATH . '/../library/Reverb/Library/pagarme/Pagarme.php';
        Pagarme::setApiKey("ak_live_oFTsUUkB2uBBJboQqhvyzcF2m9TnKl");

        $modelCompras = new Default_Model_Compras();
        $dadosCompra = $modelCompras->fetchRow(array('NR_SEQ_COMPRA_COSO = ?' => $id));

        if(!empty($dadosCompra->DS_TID_COSO)){
            $transaction = PagarMe_Transaction::findById($dadosCompra->DS_TID_COSO);
            $urlBoleto = $transaction->getBoletoUrl();
        }

        die($urlBoleto);
    }

    public function gerarEtiquetaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        require APPLICATION_PATH . '/../library/Reverb/Library/pdf/fpdf.php';
        define('FPDF_FONTPATH', APPLICATION_PATH . '/../library/Reverb/Library/pdf/font/');

        $pos_ini = $this->_request->getParam('posicao');

        $mesq = "6"; // Margem Esquerda (mm)
        $mdir = "5"; // Margem Direita (mm)
        $msup = "19"; // Margem Superior (mm)
        $leti = "72"; // Largura da Etiqueta (mm)
        $aeti = "25.4"; // Altura da Etiqueta (mm)
        $ehet = "2"; // Espaço horizontal entre as Etiquetas (mm)

        $pdf=new FPDF('P','mm','Letter'); // Cria um arquivo novo com tamanho tipo carta
        $pdf->Open(); // inicia documento
        $pdf->AddPage(); // adiciona a primeira pagina
        $pdf->SetMargins('5','12,7'); // Define as margens do documento
        $pdf->SetAuthor("ReverbCity"); // Define o autor
        $pdf->SetFont('Arial','',9); // Define a fonte

        $coluna = 0;
        $linha = 0;

        if ($pos_ini > 1){
            for ($f=1;$f<=$pos_ini;$f++){
                if($coluna == "3") { // Se for a terceira coluna
                    $coluna = 0; // $coluna volta para o valor inicial
                    $linha = $linha +1; // $linha é igual ela mesma +1
                }

                if($linha == "10") { // Se for a última linha da página
                    $pdf->AddPage(); // Adiciona uma nova página
                    $linha = 0; // $linha volta ao seu valor inicial
                }
                $coluna = $coluna+1;
            }
        }

        $compras = $this->_request->getParam('compras');
        $compras = implode(", ", $compras);

        $modelCompra = new Default_Model_Compras();
        $selectCompra = $modelCompra->select()
            ->from(array('c' => 'compras'), array())
            ->join(array('cd' => 'cadastros'), 'cd.NR_SEQ_CADASTRO_CASO = c.NR_SEQ_CADASTRO_COSO', array())
            ->joinLeft(array('e' => 'enderecos'), 'NR_SEQ_COMPRA_ENRC = NR_SEQ_COMPRA_COSO', array())
            ->columns(array(
                'c.NR_SEQ_COMPRA_COSO',
                'DS_NOME_CASO'          => 'CONVERT(cd.DS_NOME_CASO USING BINARY)',
                'DS_ENDERECO_CASO'      => 'CONVERT(cd.DS_ENDERECO_CASO USING BINARY)',
                'DS_NUMERO_CASO'        => 'CONVERT(cd.DS_NUMERO_CASO USING BINARY)',
                'DS_BAIRRO_CASO'        => 'CONVERT(cd.DS_BAIRRO_CASO USING BINARY)',
                'DS_COMPLEMENTO_CASO'   => 'CONVERT(cd.DS_COMPLEMENTO_CASO USING BINARY)',
                'DS_UF_CASO'            => 'CONVERT(cd.DS_UF_CASO USING BINARY)',
                'DS_CIDADE_CASO'        => 'CONVERT(cd.DS_CIDADE_CASO USING BINARY)',
                'DS_CEP_CASO'           => 'CONVERT(cd.DS_CEP_CASO USING BINARY)',
                'DS_DESTINATARIO_ENRC'  => 'CONVERT(e.DS_DESTINATARIO_ENRC USING BINARY)',
                'DS_ENDERECO_ENRC'      => 'CONVERT(e.DS_ENDERECO_ENRC USING BINARY)',
                'DS_NUMERO_ENRC'        => 'CONVERT(e.DS_NUMERO_ENRC USING BINARY)',
                'DS_BAIRRO_ENRC'        => 'CONVERT(e.DS_BAIRRO_ENRC USING BINARY)',
                'DS_COMPLEMENTO_ENRC'   => 'CONVERT(e.DS_COMPLEMENTO_ENRC USING BINARY)',
                'DS_UF_ENRC'            => 'CONVERT(e.DS_UF_ENRC USING BINARY)',
                'DS_CIDADE_ENRC'        => 'CONVERT(e.DS_CIDADE_ENRC USING BINARY)',
                'DS_CEP_ENRC'           => 'CONVERT(e.DS_CEP_ENRC USING BINARY)',
                'e.NR_SEQ_ENDERECO_ENRC'
            ))
            ->where('c.NR_SEQ_COMPRA_COSO IN ('. $compras .')')
            ->setIntegrityCheck(FALSE);
        $dadosCompra = $modelCompra->fetchAll($selectCompra);

        foreach($dadosCompra as $compra){
            $idc = $compra->NR_SEQ_COMPRA_COSO;

            if(is_null($compra->NR_SEQ_ENDERECO_ENRC)){
                $nome = ucwords(strtolower($compra->DS_NOME_CASO));
                $ende = ucwords(strtolower($compra->DS_ENDERECO_CASO)).",".$compra->DS_NUMERO_CASO;
                $bairro = "Bairro: ".ucwords(strtolower($compra->DS_BAIRRO_CASO));
                $complem = ucwords(strtolower($compra->DS_COMPLEMENTO_CASO));
                $estado = $compra->DS_UF_CASO;
                $cida = $compra->DS_CIDADE_CASO;
                $cep = "CEP: " . $compra->DS_CEP_CASO;
                $local = ucwords(strtolower($cida)) . "/" . $estado . "-" . $cep;
            }else{
                $nome = ucwords(strtolower($compra->DS_DESTINATARIO_ENRC));
                $ende = ucwords(strtolower($compra->DS_ENDERECO_ENRC)).",".$compra->DS_NUMERO_ENRC;
                $bairro = "Bairro: ".ucwords(strtolower($compra->DS_BAIRRO_ENRC));
                $complem = ucwords(strtolower($compra->DS_COMPLEMENTO_ENRC));
                $estado = $compra->DS_UF_ENRC;
                $cida = $compra->DS_CIDADE_ENRC;
                $cep = "CEP: " . $compra->DS_CEP_ENRC;
                $local = ucwords(strtolower($cida)) . "/" . $estado . "-" . $cep;
            }

            if($coluna == "3") { // Se for a terceira coluna
                $coluna = 0; // $coluna volta para o valor inicial
                $linha = $linha +1; // $linha é igual ela mesma +1
            }

            if($linha == "10") { // Se for a última linha da página
                $pdf->AddPage(); // Adiciona uma nova página
                $linha = 0; // $linha volta ao seu valor inicial
            }

            $posicaoV = $linha*$aeti;
            $posicaoH = $coluna*$leti;

            if($coluna == "0") { // Se a coluna for 0
                $somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
            } else { // Senão
                $somaH = $mesq+$posicaoH; // Soma Horizontal é a margem inicial mais a posiçãoH
            }

            if($linha =="0") { // Se a linha for 0
                $somaV = $msup; // Soma Vertical é apenas a margem superior inicial
            } else { // Senão
                $somaV = $msup+$posicaoV; // Soma Vertical é a margem superior inicial mais a posiçãoV
            }

            $mais = 0;
            $pdf->Text($somaH,$somaV,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
            $pdf->Text($somaH,$somaV+4,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
            if (trim($complem) != "" && trim($complem) != "-"){
                $pdf->Text($somaH,$somaV+8,$complem);
                $mais = 4;
            }
            if (trim($bairro) != "" && trim($bairro) != "-"){
                $pdf->Text($somaH,$somaV+8+$mais,$bairro." / Ped.: ".$idc);
                $mais += 4;
            }else{
                $pdf->Text($somaH,$somaV+8+$mais,"Ped.: ".$idc);
                $mais += 4;
            }
            $pdf->Text($somaH,$somaV+8+$mais,$local); // Imprime a localidade da pessoa de acordo com as coordenadas
            //$pdf->Text($somaH,$somaV+12+$mais,$cep); // Imprime o cep da pessoa de acordo com as coordenadas

            $coluna = $coluna+1;
        }

        $pdf->Output(); // encerra o arquivo PDF
    }

    public function gerarNfeAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $session = new Zend_Session_Namespace("login");

        $nfe = $this->_request->getParam('nfe');
        $compras = $this->_request->getParam('compras');
        $compras = implode(", ", $compras);

        $zip = new ZipArchive();
        $zip_name = APPLICATION_PATH . "/../Readm_911s/nfe/geradas/nfe_".date("Y-m-d")."-".date("H:i:s").".zip";

        if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE){
            $error .= "* Erro ao criar zip";
        }

        $modelNotaFiscal = new Default_Model_Notafiscal();

        $modelCompra = new Default_Model_Compras();
        $selectCompra = $modelCompra->select()
            ->from(array('c' => 'compras'), array())
            ->join(array('cd' => 'cadastros'), 'cd.NR_SEQ_CADASTRO_CASO = c.NR_SEQ_CADASTRO_COSO', array())
            ->joinLeft(array('e' => 'enderecos'), 'NR_SEQ_COMPRA_ENRC = NR_SEQ_COMPRA_COSO', array())
            ->columns(array(
                'c.NR_SEQ_COMPRA_COSO',
                'c.VL_TOTAL_COSO',
                'c.VL_FRETE_COSO',
                'c.NR_PARCELAS_COSO',
                'cd.DS_NOME_CASO',
                'cd.DS_ENDERECO_CASO',
                'cd.DS_NUMERO_CASO',
                'cd.DS_BAIRRO_CASO',
                'cd.DS_COMPLEMENTO_CASO',
                'cd.DS_UF_CASO',
                'cd.DS_CIDADE_CASO',
                'cd.DS_CEP_CASO',
                'cd.DS_CPFCNPJ_CASO',
                'cd.DS_DDDFONE_CASO',
                'cd.DS_FONE_CASO',
                'cd.NR_SEQ_CADASTRO_CASO',
                'e.DS_DESTINATARIO_ENRC',
                'e.DS_ENDERECO_ENRC',
                'e.DS_NUMERO_ENRC',
                'e.DS_BAIRRO_ENRC',
                'e.DS_COMPLEMENTO_ENRC',
                'e.DS_UF_ENRC',
                'e.DS_CIDADE_ENRC',
                'e.DS_CEP_ENRC',
                'e.NR_SEQ_ENDERECO_ENRC'
            ))
            ->where('c.NR_SEQ_COMPRA_COSO IN ('. $compras .')')
            ->setIntegrityCheck(FALSE);
        $dadosCompra = $modelCompra->fetchAll($selectCompra);

        foreach($dadosCompra as $compra){
            if(is_null($compra->NR_SEQ_ENDERECO_ENRC)){
                $nome       = strtoupper($compra->DS_NOME_CASO);
                $ende       = strtoupper($compra->DS_ENDERECO_CASO);
                $numer      = $compra->DS_NUMERO_CASO;
                $bairro     = strtoupper($compra->DS_BAIRRO_CASO);
                $complem    = strtoupper($compra->DS_COMPLEMENTO_CASO);
                $estado     = strtoupper($compra->DS_UF_CASO);
                $cida       = $compra->DS_CIDADE_CASO;
                $cep        = $compra->DS_CEP_CASO;
                $cpfcnpj    = $compra->DS_CPFCNPJ_CASO;
                $foneddd    = $compra->DS_DDDFONE_CASO;
                $fone       = $compra->DS_FONE_CASO;
                $parcelas   = $compra->NR_PARCELAS_COSO;
            }else{
                $nome       = strtoupper($compra->DS_DESTINATARIO_ENRC);
                $ende       = strtoupper($compra->DS_ENDERECO_ENRC);
                $numer      = $compra->DS_NUMERO_ENRC;
                $bairro     = strtoupper($compra->DS_BAIRRO_ENRC);
                $complem    = strtoupper($compra->DS_COMPLEMENTO_ENRC);
                $estado     = strtoupper($compra->DS_UF_ENRC);
                $cida       = $compra->DS_CIDADE_ENRC;
                $cep        = $compra->DS_CEP_ENRC;
                $cpfcnpj    = $compra->DS_CPFCNPJ_CASO;
                $foneddd    = $compra->DS_DDDFONE_CASO;
                $fone       = $compra->DS_FONE_CASO;
                $parcelas   = $compra->NR_PARCELAS_COSO;
            }

            if (!$parcelas) $parcelas = 0;
            if ($parcelas <= 1) {
                $parcelas = 0;
            }else{
                $parcelas = 1;
            }

            $dataNota = array(
                'NR_SEQ_USUARIO_NFRC' => $session->logged_usuario['NR_SEQ_USUARIO_USRC'],
                'NR_SEQ_CLIENTE_NFRC' => $compra->NR_SEQ_CADASTRO_CASO,
                'NR_SEQ_COMPRA_NFRC' => $compra->NR_SEQ_COMPRA_COSO,
                'DT_EMISSAO_NFRC' => date("Y-m-d H:i:s"),
                'NR_SEQNF_NFRC' => $nfe
            );
            $modelNotaFiscal->insert($dataNota);

            $dataat = date("Y-m-d");
            $hora = date("H:i:s");

            $db = Zend_Db_Table::getDefaultAdapter();
            $sqlIBGE = "select Municipio from DTB_05_05_2009n where DS_UF = '$estado' and (Municipio_Nome = '$cida' or Municipio_Nome = '".utf8_decode($cida)."')";
            $queryIbge = $db->query($sqlIBGE);
            $rowIbge = $queryIbge->fetch();
            $codibge = $rowIbge['Municipio'];

            $arq = APPLICATION_PATH . '/../Readm_911s/nfe/geradas/nfe_'.$dataat.'_'.$nfe.'.txt';
            $handle = fopen($arq,"w+");

            fwrite($handle,"NOTA FISCAL|1\r\n");
            fwrite($handle,"A|2.00|NFe|\r\n");
            fwrite($handle,"B|41||VENDA|$parcelas|55|1|$nfe|$dataat|$dataat|$hora|1|4113700|1|1||1|1|3|2.0.8|||\r\n");
            fwrite($handle,"C|ANTONIO M DIAS CONFECCOES|REVERBCITY|9038567770||||1|\r\n");
            fwrite($handle,"C02|08345875000137\r\n");
            fwrite($handle,"C05|RUA IBIPORA|995||JARDIM AURORA|4113700|Londrina|PR|86060510|1058|BRASIL|433228852|\r\n");
            fwrite($handle,"E|$nome||||\r\n");
            if (strlen($cpfcnpj) > 11){
                fwrite($handle,"E02|$cpfcnpj\r\n");
            }else{
                fwrite($handle,"E03|$cpfcnpj\r\n");
            }
            fwrite($handle,"E05|$ende|$numer|$complem|$bairro|$codibge|".strtoupper($this->RemoveAcentos($cida))."|$estado|$cep|1058|BRASIL||\r\n");

            $selectCompraDetalhe = $modelCompra->select()
                ->from(array('c' => 'compras'))
                ->join(array('ce' => 'cestas'), 'ce.NR_SEQ_COMPRA_CESO = c.NR_SEQ_COMPRA_COSO')
                ->join(array('p' => 'produtos'), 'p.NR_SEQ_PRODUTO_PRRC = ce.NR_SEQ_PRODUTO_CESO')
                ->join(array('pt' => 'produtos_tipo'), 'pt.NR_SEQ_CATEGPRO_PTRC = p.NR_SEQ_TIPO_PRRC')
                ->join(array('pc' => 'produtos_categoria'), 'pc.NR_SEQ_CATEGPRO_PCRC = p.NR_SEQ_CATEGORIA_PRRC')
                ->where('c.NR_SEQ_COMPRA_COSO = ?', $compra->NR_SEQ_COMPRA_COSO)
                ->setIntegrityCheck(FALSE);
            $dadosCompraDetalhe = $modelCompra->fetchAll($selectCompraDetalhe)->toArray();

            if ($estado == "PR"){
                $coduf = 5101;
            }else{
                $coduf = 6101;
            }

            $selectCompraTotal = $modelCompra->select()
                ->from(array('c' => 'compras'), array())
                ->join(array('ce' => 'cestas'), 'ce.NR_SEQ_COMPRA_CESO = c.NR_SEQ_COMPRA_COSO', array())
                ->columns(array(
                    'total' => 'SUM(NR_QTDE_CESO*VL_PRODUTO_CESO)'
                ))
                ->where('c.NR_SEQ_COMPRA_COSO = ?', $compra->NR_SEQ_COMPRA_COSO)
                ->setIntegrityCheck(FALSE);
            $dadosCompraTotal = $modelCompra->fetchRow($selectCompraTotal)->toArray();

            $total_prods = $dadosCompraTotal['total'];

            $vlr_frete = $compra->VL_FRETE_COSO;
            $vlr_total = $compra->VL_TOTAL_COSO;

            $x = 1;
            $val_desc = false;
            $freteum = "";
            $descontoum = "";

            foreach($dadosCompraDetalhe as $dadoscesta){
                $NCM = "";
                $NCM = $dadoscesta["DS_NCM_PTRC"];

                if (!$NCM) $NCM = $dadoscesta["DS_NCM_PCRC"];

                $ncmprod = $dadoscesta["DS_NCM_PRRC"];

                if ($ncmprod) $NCM = $ncmprod;

                fwrite($handle,"H|$x|".strtoupper($this->RemoveAcentos($dadoscesta["DS_CATEGORIA_PTRC"]))."\r\n");
                if (!$val_desc){
                    //if ($dadoscesta["VL_PRODUTO_CESO"] > $vlr_frete){
                    if ($vlr_frete > 0){
                        $freteum = number_format($vlr_frete,2,".","");
                    }else{
                        $freteum = "";
                    }

                    //verifica se tem desconto
                    if ( $total_prods > ($vlr_total - $vlr_frete) ){
                        $vlr_desc = $total_prods - ($vlr_total - $vlr_frete);
                        $descontoum = number_format($vlr_desc,2,".","");
                        if ($descontoum <= 0) $descontoum = "";
                    }else{
                        $descontoum = "";
                    }
                    fwrite($handle,"I|".$dadoscesta["NR_SEQ_PRODUTO_CESO"]."||".strtoupper($this->RemoveAcentos($dadoscesta["DS_PRODUTO2_PRRC"]))."|$NCM||$coduf|UN|".number_format($dadoscesta["NR_QTDE_CESO"],4,".","")."|".number_format($dadoscesta["VL_PRODUTO_CESO"],10,".","")."|".number_format(($dadoscesta["VL_PRODUTO_CESO"]*$dadoscesta["NR_QTDE_CESO"]),2,".","")."||UN|".number_format($dadoscesta["NR_QTDE_CESO"],4,".","")."|".number_format($dadoscesta["VL_PRODUTO_CESO"],2,".","")."|".$freteum."||".$descontoum."||1|\r\n");
                    $val_desc = true;
                    //}
                }else{
                    fwrite($handle,"I|".$dadoscesta["NR_SEQ_PRODUTO_CESO"]."||".strtoupper($this->RemoveAcentos($dadoscesta["DS_PRODUTO2_PRRC"]))."|$NCM||$coduf|UN|".number_format($dadoscesta["NR_QTDE_CESO"],4,".","")."|".number_format($dadoscesta["VL_PRODUTO_CESO"],10,".","")."|".number_format(($dadoscesta["VL_PRODUTO_CESO"]*$dadoscesta["NR_QTDE_CESO"]),2,".","")."||UN|".number_format($dadoscesta["NR_QTDE_CESO"],4,".","")."|".number_format($dadoscesta["VL_PRODUTO_CESO"],10,".","")."|||||1|\r\n");
                }
                fwrite($handle,"M|\r\n");
                fwrite($handle,"N|\r\n");
                fwrite($handle,"N10c|0|101|500|0|0\r\n");
                fwrite($handle,"Q|\r\n");
                fwrite($handle,"Q04|06\r\n");
                fwrite($handle,"S|\r\n");
                fwrite($handle,"S04|06\r\n");
                $x++;
            }

            fwrite($handle,"W|\r\n");
            fwrite($handle,"W02|0.00|0.00|0.00|0.00|".number_format(($compra->VL_TOTAL_COSO-$compra->VL_FRETE_COSO),2,".","")."|".number_format($compra->VL_FRETE_COSO,2,".","")."|0.00|0.00|0.00|0.00|0.00|0.00|0.00|".number_format($compra->VL_TOTAL_COSO,2,".","")."\r\n");
            fwrite($handle,"X|0|\r\n");
            fwrite($handle,"X03|CORREIOS||||\r\n");

            fclose($handle);

            $new_filename = substr($arq,strrpos($arq,'/') + 1);
            $zip->addFile($arq, 'nfes/'.$new_filename);

            $nfe++;
        }
        try{
            $zip->close();

            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
            header('Content-type: application/zip');
            header('Content-Disposition: attachment; filename="nfe_"'.date("Y-m-d").'-'.date("H:i:s").'.zip');
            readfile($zip_name);

            unlink($zip_name);
        }catch (Exception $e){
            die($e->getMessage());
        }

    }

    public function RemoveAcentos($str, $enc = "UTF-8"){
        $acentos = array(
            'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
            'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
            'C' => '/&Ccedil;/',
            'c' => '/&ccedil;/',
            'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
            'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
            'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
            'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
            'N' => '/&Ntilde;/',
            'n' => '/&ntilde;/',
            'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
            'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
            'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
            'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
            'Y' => '/&Yacute;/',
            'y' => '/&yacute;|&yuml;/',
            'a.' => '/&ordf;/',
            'o.' => '/&ordm;/',
            '' => '/&quot;|&euro;|&lt;|&gt;|&nbsp;|&acute;|&AElig;|&aelig;|&brvbar;|&cedil;|&cent;|&circ;|&copy;|&curren;|&not;/',
            '' => '/&rarr;|&larr;|&phi;|&Phi;|&piv;|&Sigma;|&sigmaf;|&infin;|&raquo;|&dagger;|&Dagger;|&Delta;|&empty;|&sect;/',
            '' => '/&frac12;|&frac14;|&frac34;|&reg;|&tilde;|&micro;|&Oslash;|&para;|&laquo;|&yen;|&Psi;|&Omega;|&omega;|&Chi;/');

        return preg_replace($acentos,
            array_keys($acentos),
            htmlentities($str,ENT_NOQUOTES, $enc));
    }
}


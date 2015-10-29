<?php

/**
 *
 */
class Painel_IndexController extends Reverb_Controller_Action {
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
//        $pedidosDatas = array();
//        $cadastrosDatas = array();
//        $st = rand(1, 5);
//        for($i = 1; $i <= 7; $i++){
//            $a = rand(300, 600);
//            $b = rand($a, $a + 100);
//            $c = rand($a, $b);
//
//            $d = rand(300, 2000);
//            $e = rand(300, 2000);
//
//            $cadastrosDatas[] = array(
//                'data' => "01/" . str_pad($st, 2,  '0', STR_PAD_LEFT),
//                'mon' => str_pad($st, 2,  '0', STR_PAD_LEFT),
//                'cadastrados' => $b,
//                'compras' => $a
//            );
//
//            $pedidosDatas[] = array(
//                'data' => "01/" . str_pad($st, 2,  '0', STR_PAD_LEFT),
//                'mon' => str_pad($st, 2,  '0', STR_PAD_LEFT),
//                'pedidos' => $c
//            );
//
//            $acessoDatas['mobile'][] = array(
//                'data' => "01/" . str_pad($st, 2,  '0', STR_PAD_LEFT),
//                'mon' => str_pad($st, 2,  '0', STR_PAD_LEFT),
//                'acessos' => $d
//            );
//
//            $acessoDatas['desktop'][] = array(
//                'data' => "01/" . str_pad($st, 2,  '0', STR_PAD_LEFT),
//                'mon' => str_pad($st, 2,  '0', STR_PAD_LEFT),
//                'acessos' => $e
//            );
//            $st++;
//        }

        // Dados para o gráfico de pedidos
        $idCache = 'index_pedidos';
        $dadosCompras = Zend_Registry::get("cache")->load($idCache);
        if(!$dadosCompras){
            $modelCompras = new Default_Model_Compras();
            $selectCompras = $modelCompras->select()
                ->from(array('c' => 'compras'), array())
                ->columns(array(
                    'data' => 'DATE_FORMAT(c.DT_COMPRA_COSO, "%d/%m/%Y")',
                    'mon' => 'DATE_FORMAT(c.DT_COMPRA_COSO, "%m")',
                    'pedidos' => 'COUNT(*)'
                ))
                ->group('DATE_FORMAT(c.DT_COMPRA_COSO, "%Y-%m-%d")')
                ->where('DATE_FORMAT(c.DT_COMPRA_COSO, "%Y-%m-%d") >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 30 DAY), "%Y-%m-%d")');
            $dadosCompras = $modelCompras->fetchAll($selectCompras)->toArray();

            Zend_Registry::get("cache")->save($dadosCompras, $idCache);
        }

        // Dados para os detalhes abaixo do gráfico de pedidos
        $idCache = 'index_pedidos_detalhe';
        $dadosComprasDetalhe = Zend_Registry::get("cache")->load($idCache);
        if(!$dadosComprasDetalhe){
            $modelCompras = new Default_Model_Compras();
            $selectComprasDetalhe = $modelCompras->select()
                ->from(array('c' => 'compras'), array())
                ->columns(array(
                    'total' => 'COUNT(*)',
                    'confirmados' => '(SELECT COUNT(*) FROM compras WHERE DATE_FORMAT(DT_COMPRA_COSO, "%Y-%m-%d") >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 30 DAY), "%Y-%m-%d") AND ST_COMPRA_COSO NOT IN ("C", "A"))',
                    'cancelados' => '(SELECT COUNT(*) FROM compras WHERE DATE_FORMAT(DT_COMPRA_COSO, "%Y-%m-%d") >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 30 DAY), "%Y-%m-%d") AND ST_COMPRA_COSO = "C")',
                    'ticket_medio' => 'SUM(VL_TOTAL_COSO) / COUNT(*)',
                    'item_medio' => '(SELECT SUM(NR_QTDE_CESO) FROM cestas INNER JOIN compras ON compras.NR_SEQ_COMPRA_COSO = cestas.NR_SEQ_COMPRA_CESO WHERE DATE_FORMAT(compras.DT_COMPRA_COSO, "%Y-%m-%d") >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 30 DAY), "%Y-%m-%d"))/COUNT(*)'
                ))
                ->where('DATE_FORMAT(c.DT_COMPRA_COSO, "%Y-%m-%d") >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 30 DAY), "%Y-%m-%d")');
            $dadosComprasDetalhe = $modelCompras->fetchRow($selectComprasDetalhe)->toArray();

            Zend_Registry::get("cache")->save($dadosComprasDetalhe, $idCache);
        }

        // Dados para os cadastros
        $idCache = 'index_cadastros';
        $dadosCadastros = Zend_Registry::get("cache")->load($idCache);
        if(!$dadosCadastros){
            $modelCadastros = new Default_Model_Reverbme();
            $selectCadastros = $modelCadastros->select()
                ->from(array('c' => 'cadastros'), array())
                ->joinLeft(array('co' => 'compras'), 'NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_COSO', array())
                ->columns(array(
                    'cadastrados' => 'COUNT(*)',
                    'compras' => 'COUNT(NR_SEQ_COMPRA_COSO)',
                    'mon' => 'DATE_FORMAT(c.DT_CADASTRO_CASO, "%m")',
                    'data' => 'DATE_FORMAT(c.DT_CADASTRO_CASO, "%d/%m/%Y")'
                ))
                ->where('DATE_FORMAT(c.DT_CADASTRO_CASO, "%Y-%m-%d") >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 12 MONTH), "%Y-%m-%d")')
                ->group('DATE_FORMAT(c.DT_CADASTRO_CASO, "%Y-%m")');
            $dadosCadastros = $modelCadastros->fetchAll($selectCadastros);

            Zend_Registry::get("cache")->save($dadosCadastros, $idCache);
        }

        // Busca dados para os acessos
        $idCache = 'google_analytics';
        $acessoDatas = Zend_Registry::get("cache")->load($idCache);
        if (!$acessoDatas) {
            require_once(APPLICATION_PATH . '/../library/Reverb/Library/gapi/gapi.class.php');
            $ga = new gapi('reverbcity@gmail.com', 'owfjqqheka4oh');
            $inicio = date('Y-m-d', strtotime('-10 day'));
            $fim = date('Y-m-d');
            $ga->requestReportData(69377124, array('isMobile', 'date'), array('sessions', 'visits'), array('date'), null, $inicio, $fim);

            foreach ($ga->getResults() as $dados) {
                if($dados->getIsMobile() == 'Yes'){
                    $data = $dados->getDate();
                    $acessos = $dados->getSessions();

                    $acessoDatas['mobile']['total'] += $acessos;

                    $acessoDatas['mobile'][] = array(
                        'data' => date('d/m/Y', strtotime($data)),
                        'mon' => date('m', strtotime($data)),
                        'acessos' => $acessos
                    );
                }else{
                    $data = $dados->getDate();
                    $acessos = $dados->getSessions();

                    $acessoDatas['desktop']['total'] += $acessos;

                    $acessoDatas['desktop'][] = array(
                        'data' => date('d/m/Y', strtotime($data)),
                        'mon' => date('m', strtotime($data)),
                        'acessos' => $acessos
                    );
                }
            }
            Zend_Registry::get("cache")->save($acessoDatas, $idCache);
        }

        $sessionTotal = $acessoDatas['mobile']['total'] + $acessoDatas['desktop']['total'];
        $porMobile = round(($acessoDatas['mobile']['total'] / $sessionTotal) * 100);
        $porPc = round(($acessoDatas['desktop']['total'] / $sessionTotal) * 100);

        // Busca dados para as mais vendidas
        $idCache = 'index_mais_vendidas';
        $dadosCestas = Zend_Registry::get("cache")->load($idCache);
        if(!$dadosCestas){
            $modelCestas = new Default_Model_Cestas();
            $selectCestas = $modelCestas->select()
                ->from(array('c' => 'cestas'), array())
                ->joinInner(array('co' => 'compras'), 'c.NR_SEQ_COMPRA_CESO = co.NR_SEQ_COMPRA_COSO', array())
                ->joinInner(array('p' => 'produtos'), 'p.NR_SEQ_PRODUTO_PRRC = c.NR_SEQ_PRODUTO_CESO', array())
                ->columns(array(
                    'total' => 'COUNT(*)',
                    'nome_produto' => 'p.DS_PRODUTO_PRRC'
                ))
                ->where('DATE_FORMAT(co.DT_COMPRA_COSO, "%Y-%m-%d") >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 30 DAY), "%Y-%m-%d")')
                ->where('c.NR_SEQ_PRODUTO_CESO NOT IN(4679)')
                ->group('c.NR_SEQ_PRODUTO_CESO')
                ->order('COUNT(*) DESC')
                ->limit(5)
                ->setIntegrityCheck(FALSE);
            $dadosCestas = $modelCestas->fetchAll($selectCestas)->toArray();

            Zend_Registry::get("cache")->save($dadosCestas, $idCache);
        }

        // Busca dados dos aniversariantes
        $idCache = 'index_aniversariantes';
        $dadosAniversariantes = Zend_Registry::get("cache")->load($idCache);
        if(!$dadosAniversariantes){
            $modelCadastros = new Default_Model_Reverbme();
            $selectCadastros = $modelCadastros->select()
                ->from(array('c' => 'cadastros'), array())
                ->columns(array(
                    'total' => 'COUNT(*)',
                    'compras' => '(SELECT COUNT(*) FROM compras WHERE ST_COMPROU_NIVER = 1 AND DATE_FORMAT(DT_COMPRA_COSO, "%m") = DATE_FORMAT(NOW(), "%m"))',
                    'compras_total' => '(SELECT COALESCE(SUM(VL_TOTAL_COSO), 0) FROM compras WHERE ST_COMPROU_NIVER = 1 AND DATE_FORMAT(DT_COMPRA_COSO, "%m") = DATE_FORMAT(NOW(), "%m"))'
                ))
                ->where('DATE_FORMAT(c.DT_NASCIMENTO_CASO, "%m") = DATE_FORMAT(NOW(), "%m")');

            $dadosAniversariantes = $modelCadastros->fetchRow($selectCadastros)->toArray();

            $dadosAniversariantes['porcentagem'] = round(($dadosAniversariantes['compras'] / $dadosAniversariantes['total']) * 100);

            Zend_Registry::get("cache")->save($dadosAniversariantes, $idCache);
        }

        switch(date('m')){
            case 1:
                $nomeMes = 'Janeiro';
                break;
            case 2:
                $nomeMes = 'Fevereiro';
                break;
            case 3:
                $nomeMes = 'Março';
                break;
            case 4:
                $nomeMes = 'Abril';
                break;
            case 5:
                $nomeMes = 'Maio';
                break;
            case 6:
                $nomeMes = 'Junho';
                break;
            case 7:
                $nomeMes = 'Julho';
                break;
            case 8:
                $nomeMes = 'Agosto';
                break;
            case 9:
                $nomeMes = 'Setembro';
                break;
            case 10:
                $nomeMes = 'Outubro';
                break;
            case 11:
                $nomeMes = 'Novembro';
                break;
            case 12:
                $nomeMes = 'Dezembro';
                break;
        }

        $this->view->nomeMes = $nomeMes;
        $this->view->dadosAniversariantes = $dadosAniversariantes;
        $this->view->dadosCestas = $dadosCestas;
        $this->view->porMobile = $porMobile;
        $this->view->porPc = $porPc;
        $this->view->dadosAcessos = $acessoDatas;
        $this->view->dadosPedidos = $dadosCompras;
        $this->view->dadosPedidosDetalhe = $dadosComprasDetalhe;
        $this->view->dadosCadastrados = $dadosCadastros;
	}

	/**
	 *
	 */
	public function dashAction() {

	}

	/**
	 *
	 */
	public function widgetAction() {
	}

	/**
	 *
	 */
	public function widget2Action() {
	}

	/**
	 *
	 */
	public function widget3Action() {
	}


	/**
	 * Action para atualizar o perfil ?
	 */
	public function configuracaoAction() {
        $session = new Zend_Session_Namespace("login");
        $messages = new Zend_Session_Namespace('messages');
        $modelUsuarios = new Default_Model_Usuarios();

        if($this->_request->isPost()){
            try{
                $dados = $this->_request->getParams();

                unset($dados['module']);
                unset($dados['controller']);
                unset($dados['action']);

                $modelUsuarios->update($dados, array('NR_SEQ_USUARIO_USRC = ?' => $session->logged_usuario['NR_SEQ_USUARIO_USRC']));

                $messages->success = 'Dados alterados com sucesso.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }catch (Exception $e){
                $messages->error = 'Houve um problema ao editar os dados.';
                $this->_redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $selectUsuarios = $modelUsuarios->select()
                ->from(array('u' => 'usuarios'), array(
                    'DS_LOGIN_USRC',
                    'DS_SENHA_USRC',
                    'DS_EMAIL_USRC'
                ))
                ->where('NR_SEQ_USUARIO_USRC = ?', $session->logged_usuario['NR_SEQ_USUARIO_USRC']);
            $dadosUsuario = $modelUsuarios->fetchRow($selectUsuarios);

            $this->view->dadosUsuario = $dadosUsuario;
        }
	}

	/**
	 * Action para atualizar o perfil ?
	 */
	public function indicacoesAction() {

	}

}


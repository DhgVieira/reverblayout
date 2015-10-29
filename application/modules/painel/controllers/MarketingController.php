<?php

/**
 *
 */
class Painel_MarketingController extends Reverb_Controller_Action {
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
		if($this->_request->isPost()){
			$termo = $this->_request->getParam('termo');
			if(!empty($termo)){
				$this->_redirect('/painel/marketing/index/busca/' . $termo);
			}else{
				$this->_redirect('/painel/marketing');
			}
		}

		$modelSpam = new Default_Model_Spam();
		$selectSpam = $modelSpam->select()
			->from(array('s' => 'spam'), array())
			->columns(array(
				'id_spam',
				'ds_descricao'
			))
			->order('dt_inclusao DESC');

		$busca = $this->_request->getParam('busca');
		if(!empty($busca)){
			$selectSpam->where("ds_descricao LIKE '%".addslashes($busca)."%'");

			$this->view->busca = $busca;
		}

		$current_page = $this->_request->getParam("page", 1);
		$dadosSpam = new Reverb_Paginator($selectSpam);
		$dadosSpam->setItemCountPerPage(15)
			->setCurrentPageNumber($current_page)
			->setPageRange(5)
			->assign();

		$this->view->dadosSpam = $dadosSpam;
	}

	/**
	 *
	 */
	public function cadastrarNewsletterAction() {
		if($this->_request->isPost()){
			$dadosPost = $this->_request->getParams();
			$message = new Zend_Session_Namespace('messages');

			unset($dadosPost['module']);
			unset($dadosPost['controller']);
			unset($dadosPost['action']);

			$dadosPost['dt_inclusao'] = date('Y-m-d h:i:s');
			$dadosPost['st_status'] = 'A';

			try{
				$modelSpam = new Default_Model_Spam();
				$modelSpam->insert($dadosPost);

				$message->success = 'Newsletter cadastrada com sucesso.';
			}catch (Exception $e){
				$message->error = 'Ocorreu um erro ao cadastrar a newsletter.';
			}

			$this->_redirect('/painel/marketing');
		}
	}

	/**
	 *
	 */
	public function editarNewsletterAction() {
		if($this->_request->isPost()){
			$dadosPost = $this->_request->getParams();
			$message = new Zend_Session_Namespace('messages');

			$id = $this->_request->getParam('id');

			unset($dadosPost['module']);
			unset($dadosPost['controller']);
			unset($dadosPost['action']);
			unset($dadosPost['id']);

			try{
				$modelSpam = new Default_Model_Spam();
				$modelSpam->update($dadosPost, array('id_spam = ?' => $id));

				$message->success = 'Newsletter cadastrada com sucesso.';
			}catch (Exception $e){
				$message->error = 'Ocorreu um erro ao cadastrar a newsletter.';
			}

			$this->_redirect('/painel/marketing');
		}else{
			$id = $this->_request->getParam('id');

			$modelSpam = new Default_Model_Spam();
			$dadosSpam = $modelSpam->fetchRow(array('id_spam = ?' => $id));

			$this->view->dadosSpam = $dadosSpam;
		}
	}

	public function verNewsletterAction(){
		$this->_helper->layout->disableLayout();

		$id = $this->_request->getParam('id');
		$modelSpam = new Default_Model_Spam();
		$dadosSpam = $modelSpam->fetchRow(array('id_spam = ?' => $id));

		$this->view->dadosSpam = $dadosSpam;
	}

	/**
	 *
	 */
	public function listaCampanhaAction(){
		$modelCampanha = new Default_Model_Campanha();
		$selectCampanha = $modelCampanha->select()
			->from(array('c' => 'campanhas'), array())
			->columns(array(
				'NR_SEQ_CAMPANHA_CARC',
				'DS_CAMPANHA_CARC',
				'DT_CRIACAO_CARC',
				'total_concretizadas' => "(SELECT COUNT(*) FROM campanhas_hist INNER JOIN compras ON NR_SEQ_COMPRA_COSO = DS_OBS_ACRC WHERE NR_SEQ_CAMPANHA_ACRC = NR_SEQ_CAMPANHA_CARC AND NR_SEQ_CADASTRO_COSO NOT IN (8074 , 6605, 22364) AND ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A')",
				'valor_concretizadas' => "(SELECT SUM(VL_TOTAL_COSO) FROM campanhas_hist INNER JOIN compras ON NR_SEQ_COMPRA_COSO = DS_OBS_ACRC WHERE NR_SEQ_CAMPANHA_ACRC = NR_SEQ_CAMPANHA_CARC AND NR_SEQ_CADASTRO_COSO NOT IN (8074 , 6605, 22364) AND ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A')",
				'total_7_concretizadas' => "(SELECT COUNT(*) FROM campanhas_hist INNER JOIN compras ON NR_SEQ_COMPRA_COSO = DS_OBS_ACRC WHERE NR_SEQ_CAMPANHA_ACRC = NR_SEQ_CAMPANHA_CARC AND NR_SEQ_CADASTRO_COSO NOT IN (8074 , 6605, 22364) AND ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A' AND DT_COMPRA_COSO > DATE_SUB(SYSDATE(), INTERVAL 7 DAY))",
				'valor_7_concretizadas' => "(SELECT SUM(VL_TOTAL_COSO) FROM campanhas_hist INNER JOIN compras ON NR_SEQ_COMPRA_COSO = DS_OBS_ACRC WHERE NR_SEQ_CAMPANHA_ACRC = NR_SEQ_CAMPANHA_CARC AND NR_SEQ_CADASTRO_COSO NOT IN (8074 , 6605, 22364) AND ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A' AND DT_COMPRA_COSO > DATE_SUB(SYSDATE(), INTERVAL 7 DAY))",
				'total_30_concretizadas' => "(SELECT COUNT(*) FROM campanhas_hist INNER JOIN compras ON NR_SEQ_COMPRA_COSO = DS_OBS_ACRC WHERE NR_SEQ_CAMPANHA_ACRC = NR_SEQ_CAMPANHA_CARC AND NR_SEQ_CADASTRO_COSO NOT IN (8074 , 6605, 22364) AND ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A' AND DT_COMPRA_COSO > DATE_SUB(SYSDATE(), INTERVAL 30 DAY))",
				'valor_30_concretizadas' => "(SELECT SUM(VL_TOTAL_COSO) FROM campanhas_hist INNER JOIN compras ON NR_SEQ_COMPRA_COSO = DS_OBS_ACRC WHERE NR_SEQ_CAMPANHA_ACRC = NR_SEQ_CAMPANHA_CARC AND NR_SEQ_CADASTRO_COSO NOT IN (8074 , 6605, 22364) AND ST_COMPRA_COSO <> 'C' AND ST_COMPRA_COSO <> 'A' AND DT_COMPRA_COSO > DATE_SUB(SYSDATE(), INTERVAL 30 DAY))"
			))
			->order('DT_CRIACAO_CARC DESC');

		$current_page = $this->_request->getParam("page", 1);
		$dadosCampanha = new Reverb_Paginator($selectCampanha);
		$dadosCampanha->setItemCountPerPage(15)
			->setCurrentPageNumber($current_page)
			->setPageRange(5)
			->assign();

		$this->view->dadosCampanha = $dadosCampanha;
	}

	/**
	 *
	 */
	public function cadastrarCampanhaAction() {
		if($this->_request->isPost()){
			$modelCampanha = new Default_Model_Campanha();

			$message = new Zend_Session_Namespace('messages');

			$dadosPost = $this->_request->getParams();

			unset($dadosPost['module']);
			unset($dadosPost['controller']);
			unset($dadosPost['action']);

			$dadosPost['DT_CRIACAO_CARC'] = date('Y-m-d H:i:s');

			try{
				$modelCampanha->insert($dadosPost);

				$message->success = 'Campanha cadastrada com sucesso.';
			}catch (Exception $e){
				$message->error = 'Ocorreu um erro ao cadastrar a campanha.';
			}

			$this->_redirect('/painel/marketing/lista-campanha');
		}
	}

	/**
	 *
	 */
	public function editarCampanhaAction(){

		$modelCampanha = new Default_Model_Campanha();

		$id = $this->_request->getParam('id');

		if($this->_request->isPost()){
			$dadosPost = $this->_request->getParams();

			$message = new Zend_Session_Namespace('messages');

			unset($dadosPost['module']);
			unset($dadosPost['controller']);
			unset($dadosPost['action']);
			unset($dadosPost['id']);

			try{
				$modelCampanha->update($dadosPost, array('NR_SEQ_CAMPANHA_CARC = ?' => $id));

				$message->success = 'Campanha alterada com sucesso.';
			}catch (Exception $e){
				$message->error = 'Ocorreu um erro ao alterar a campanha.';
			}

			$this->_redirect('/painel/marketing/lista-campanha');
		}else{
			$dadosCampanha = $modelCampanha->fetchRow(array('NR_SEQ_CAMPANHA_CARC = ?' => $id));

			$this->view->dadosCampanha = $dadosCampanha;
		}
	}

	/**
	 *
	 */
	public function apagarCampanhaAction(){
		$modelCampanha = new Default_Model_Campanha();

		$message = new Zend_Session_Namespace('messages');

		$id = $this->_request->getParam('id');

		if(!empty($id)){
			try{
				$modelCampanha->delete(array('NR_SEQ_CAMPANHA_CARC = ?' => $id));

				$message->success = 'Campanha deletada com sucesso.';
			}catch (Exception $e){
				$message->error = 'Ocorreu um erro ao deletar a campanha.';
			}
		}

		$this->_redirect($_SERVER['HTTP_REFERER']);
	}


	/**
	 *
	 */
	public function cadastrarAcoesAction() {
			$this->view->crumb = "Clientes &gt; Histórico de indicações";
			$this->view->pageName = "Banners Cadastrados";
	}

	/**
	 *
	 */
	public function monitoramentoVendasAction() {
		$modelProdutomonitora = new Default_Model_Produtomonitora();

		$selectProdutomonitora = $modelProdutomonitora->select()
			->from(array('pm' => 'produtos_monitora'), array())
			->joinInner(array('p' => 'produtos'), 'p.NR_SEQ_PRODUTO_PRRC = pm.NR_SEQ_PRODUTO_MOPR', array())
			->columns(array(
				'pm.NR_SEQ_MONITORA_MOPR',
				'p.DS_PRODUTO_PRRC',
				'p.NR_SEQ_PRODUTO_PRRC',
				'pm.VL_INVESTIDO_MOPR',
				'pm.DT_INICIO_MOPR',
				'pm.DT_FIM_MOPR',
				'pm.NR_QTDE_MOPR',
				'dias' => "abs(datediff(dt_inicio_mopr, dt_fim_mopr))",
				'vl_vendido' => "(SELECT SUM(ce.VL_PRODUTO_CESO) FROM compras c INNER JOIN cestas ce ON ce.NR_SEQ_COMPRA_CESO = c.NR_SEQ_COMPRA_COSO WHERE ce.NR_SEQ_PRODUTO_CESO = p.NR_SEQ_PRODUTO_PRRC AND c.ST_COMPRA_COSO NOT IN('A', 'C') AND DATE_FORMAT(c.DT_COMPRA_COSO, '%Y-%m-%d') >= pm.DT_INICIO_MOPR AND DATE_FORMAT(c.DT_COMPRA_COSO, '%Y-%m-%d') <= pm.DT_FIM_MOPR)",
				'qtd_vendido' => "(SELECT COUNT(*) FROM compras c INNER JOIN cestas ce ON ce.NR_SEQ_COMPRA_CESO = c.NR_SEQ_COMPRA_COSO WHERE ce.NR_SEQ_PRODUTO_CESO = p.NR_SEQ_PRODUTO_PRRC AND c.ST_COMPRA_COSO NOT IN('A', 'C') AND DATE_FORMAT(c.DT_COMPRA_COSO, '%Y-%m-%d') >= pm.DT_INICIO_MOPR AND DATE_FORMAT(c.DT_COMPRA_COSO, '%Y-%m-%d') <= pm.DT_FIM_MOPR)"
			))
			->having('dias > 0')
			->setIntegrityCheck(FALSE);

		$dadosProdutomonitora = $modelProdutomonitora->fetchAll($selectProdutomonitora);

		$this->view->dadosProdutomonitora = $dadosProdutomonitora;
	}

	/**
	 *
	 */
	public function cadastrarCamisetaMonitoramentoAction() {
		if($this->_request->isPost()){
			$dadosPost = $this->_request->getParams();

			$message = new Zend_Session_Namespace('messages');

			unset($dadosPost['module']);
			unset($dadosPost['controller']);
			unset($dadosPost['action']);

			$dadosPost['NR_SEQ_PRODUTO_MOPR'] = explode('/', $dadosPost['NR_SEQ_PRODUTO_MOPR']);
			$dadosPost['NR_SEQ_PRODUTO_MOPR'] = end($dadosPost['NR_SEQ_PRODUTO_MOPR']);

			$dadosPost['DT_INICIO_MOPR'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['DT_INICIO_MOPR'])));
			$dadosPost['DT_FIM_MOPR'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['DT_FIM_MOPR'])));

			try{
				$modelProdutomonitora = new Default_Model_Produtomonitora();
				$modelProdutomonitora->insert($dadosPost);

				$message->success = 'Monitoramento cadastrado com sucesso.';
			}catch (Exception $e){
				$message->error = 'Ocorreu um problema ao cadastrar o monitoramento.';
			}

			$this->_redirect('/painel/marketing/monitoramento-vendas');
		}
	}

	/**
	 *
	 */
	public function resumoMarketingAction() {
			$this->view->crumb = "Clientes &gt; Histórico de indicações";
			$this->view->pageName = "Banners Cadastrados";
	}


}


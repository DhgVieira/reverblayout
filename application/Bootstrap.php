<?php

/**
 * Classe de inicialização da aplicação
 *
 * @name Bootstrap
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	/**
	 * Armazena o view
	 *
	 * @name $_view
	 */
	protected $_view = NULL;

	/**
	 * Armazena a configuração
	 *
	 * @name $_config
	 */
	protected $_config = NULL;

	/**
	 * @var \Zend_Log
	 */
	protected $logger;

	/**
	 * Busca a configuração do INI
	 *
	 * @name _initConfig
	 */
	protected function _initConfig() {
		// Busca a configuração
		$this->_config = new Zend_Config($this->getOptions());

		// Registra o config na sessão
		Zend_Registry::set("config", $this->_config);

		// Inicia os loaders
		$this->bootstrap("autoloaders");


	}

	protected function _initLog() {
		if ($log = $this->getPluginResource('log')) {
			$this->logger = $log->getLog();
			Zend_Registry::set('logger', $this->logger);
		}
	}

	protected function _initCache() {
		$frontendOptions = array(
			'lifetime' => $this->_config->reverb->cache->time,
			'automatic_serialization' => TRUE
		);

		$cache = Zend_Cache::factory("Core", "APC", $frontendOptions, array());

		Zend_Registry::set("cache", $cache);
	}

	/**
	 * Inicializa as rotas
	 *
	 * @name _initRouter
	 */
	protected function _initRouter() {
		try {
			$this->bootstrap("frontController");
			$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/routes.ini", "routes");
			$router = $this->getResource("frontController")
				->getRouter()
				->addConfig($config, "routes");
			return $router;
		}
		catch(Exception $e) {
			$message = $e->getMessage() . ' --- ' . $e->getTraceAsString();
			$this->logger->log($message, Zend_Log::CRIT);
			return FALSE;
		}
	}

	/**
	 * Inicializa os loaders
	 *
	 * @name _initAutoloaders
	 */
	protected function _initAutoloaders() {
		$this->getApplication()->setAutoloaderNamespaces(array("Reverb_"));
	}

	/**
	 * Inicializa a conexão com o banco de dados
	 *
	 * @name _initConnection
	 */
	protected function _initConnection() {
		// Busca as opções de configuração
		$options = $this->getOption("resources");
		$enabled = $options['db']['enabled'];

		// Verifica se está habilitado
		if($enabled) {
		 	$db_adapter = $options['db']['adapter'];
		 	$params = $options['db']['params'];

		 	try {
		 		// Carrega a classe adaptadoda
		 		$db = Zend_Db::factory($db_adapter, $params);

		 		// Busca a conexão
		 		$db->getConnection();

		 		// Registra a conexão
		 		$registry = Zend_Registry::getInstance();
		 		$registry->set("db", $db);
				Zend_Db_Table_Abstract::setDefaultMetadataCache($registry->get('cache'));
		 	}
		 	catch(Exception $e) {
				echo '<div style="display:none">'. $e->getMessage() .'</div>';
		 		die("Estamos com problemas na conexao,  retorne em alguns instantes. Obrigado.");
		 	}
		 }
	}

	/**
	 * Inicializa o view
	 *
	 * @name _initView
	 */
	protected function _initView() {
		// Busca a sessão das mensagens
		$session = new Zend_Session_Namespace("messages");

		// Busca as configurações do smarty
		$options = $this->getOption("smarty");

		// Cria o objeto smarty
		$this->_view = new Reverb_View_Smarty($options);
		Zend_Registry::set("view", $this->_view);

		// Seta a codificação
		$this->_view->setEncoding("UTF-8");

		// Adiciona o renderer
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper("ViewRenderer");
		$viewRenderer->setView($this->_view)
			->setViewScriptPathSpec(APPLICATION_PATH . "/modules/:module/views/:controller/:action.:suffix")
			->setViewSuffix("tpl");

		$inflector = new Zend_Filter_Inflector(APPLICATION_PATH . "/layouts/:script.:suffix");
		$inflector->addRules(
		array(
			'script' => "layout",
			'suffix' => "tpl"
			)
		);

		Zend_Layout::startMvc(
			array(
			'view' => $this->_view,
			'inflector' => $inflector
			)
		);

		// Registra o viewer
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

		// Adiciona o basepath ao view
		$options = $this->getOption("Reverb");
		$basePath = $options['config']['basepath'];
		$this->_view->basePath = $basePath;
                
		//$this->_view->addHelperPath('Ze', 'Ze');

		Zend_Registry::set('config', $this->getOptions());

		// Verifica se houve erros
		$this->_view->error = $session->error;
                $this->_view->email_error = $session->email;
                unset($session->email);
                
		// verifica se houve sucessos
		$this->_view->success = $session->success;

	}

	/**
	 * Inicia os plugins e helpers
	 *
	 * @name _initPlugins
	 */
	protected function _initPlugins() {
	// Registra o view helper que cria a URL de forma facilitada
		$helper = new Reverb_View_Helper_CreateUrl();
		$this->_view->registerHelper($helper, "CreateUrl");

		// Registra o helper para criar bbcode
		$helper = new Reverb_View_Helper_Bbcode();
		$this->_view->registerHelper($helper, "bbcode");

		// Registra o helper para criar o tradutor
//		$helper = new Reverb_View_Helper_Translate();
//		$this->_view->registerHelper($helper, "translate");

		// Registra o helper para criar o tradutor
		$helper = new Reverb_View_Helper_Dateformat();
		$this->_view->registerHelper($helper, "dateformat");

		// Registra o helper para buscar as colunas
		$helper = new Reverb_View_Helper_GetColumnValue();
		$this->_view->registerHelper($helper, "GetColumnValue");

		// Registra o helper para criar o tradutor
		$helper = new Reverb_View_Helper_CreateSlug();
		$this->_view->registerHelper($helper, "createslug");

		// Registra o helper da existencia do produto em estoque
		$helper = new Reverb_View_Helper_Jsondecode();
		$this->_view->registerHelper($helper, "jsondecode");
                
                // Registra o helper da existencia do produto em estoque
		$helper = new Reverb_View_Helper_Utf8();
		$this->_view->registerHelper($helper, "utf8");
                
                $helper = new Reverb_View_Helper_Listacurtiram();
		$this->_view->registerHelper($helper, "listacurtiram");
                
                $helper = new Reverb_View_Helper_Fotoproduto();
		$this->_view->registerHelper($helper, "fotoproduto");

        $helper = new Reverb_View_Helper_Respostapeoplecoments();
        $this->_view->registerHelper($helper, "respostapeoplecoments");

        $helper = new Reverb_View_Helper_Respostacyclecoments();
        $this->_view->registerHelper($helper, "respostacyclecoments");

		$helper = new Reverb_View_Helper_Produtovendidodia();
		$this->_view->registerHelper($helper, "produtovendidodia");

		// Registra o plugin do arquivos
		$this->frontController->registerPlugin(new Reverb_Controller_Plugin_Arquivos);

		// Registra o plugin do custom css
		$this->frontController->registerPlugin(new Reverb_Controller_Plugin_Customcss);

		// Registra o plugin do custom js
		$this->frontController->registerPlugin(new Reverb_Controller_Plugin_Customjs);

		// Registra o plugin de navigation
		$this->frontController->registerPlugin(new Reverb_Controller_Plugin_Navigation);

		// Registra o plugin de verificação do usuario
		$this->frontController->registerPlugin(new Reverb_Controller_Plugin_Userverify);

		// Registra o plugin de adição das meta tags
		$this->frontController->registerPlugin(new Reverb_Controller_Plugin_Metas);

		// Registra o plugin para carregar informações para todo o site
		$this->frontController->registerPlugin(new Reverb_Controller_Plugin_Geral);
		$this->frontController->registerPlugin(new Reverb_Controller_Plugin_Cachepages());

        //$this->frontController->registerPlugin( new Reverb_Controller_Plugin_Ssl);


		// Verifica se utiliza um layout por modulo
		if(!$this->config->Reverb->layout->justone) {
			$plugin = new Reverb_View_ModularLayout();
			$this->frontController->registerPlugin($plugin);
		}
	}
}

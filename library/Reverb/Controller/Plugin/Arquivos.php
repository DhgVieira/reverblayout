<?php

/**
 * Cria o plugin do arquivos
 * 
 * @name Reverb_Controller_Plugin_arquivos
 */
class Reverb_Controller_Plugin_Arquivos extends Zend_Controller_Plugin_Abstract {
	/**
	 * Método da classe
	 * 
	 * @name includejs
	 */
	public function preDispatch (Zend_Controller_Request_Abstract $request) {
		// Busca o view renderer
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper("viewRenderer");
		$viewRenderer->initView();
		$view = $viewRenderer->view;
		
		// Busca o basepath
		$options = Zend_Registry::get("config");
		// $basePath = $options->Reverb->config->basepath;
		$basePath = $options['Reverb']['config']['basepath'];
		
		// Busca os arquivos css do arquivos
		$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/arquivos.ini", "css");
		
		// Percorre os arquivos
		$module = (string)$request->getModuleName();
		foreach($config->$module as $file) {
			if(strpos($file, "http://") === FALSE) {
				// Troca a palavra chave do modulo
				$file = str_replace(":module", $module, $file);
				
				// Adiciona o arquivo
				$view->headLink()->appendStylesheet($basePath . "/" . $file);
			}
			else {
				// Adiciona o arquivo
				$view->headLink()->appendStylesheet($file);
			}
		}
		
		// Busca os arquivos js do arquivos
		$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/arquivos.ini", "js");
		
		// Percorre os arquivos js
		$module = (string)$request->getModuleName();
		$fileJs = "";
		foreach($config->$module as $file) {
			if(strpos($file, "http://") === FALSE) {
				// Troca a palavra chave do modulo
				$file = str_replace(":module", $module, $file);
				$fileJs .= file_get_contents(APPLICATION_PATH . '/../' . $file);
				// Adiciona o arquivo
//				$view->headScript()->appendFile($basePath . "/" . $file);
			}
			else {
				// Adiciona o arquivo
				$view->headScript()->appendFile($file);
			}
		}

		if (!empty($fileJs)) {
			$view->headScript()->appendFile($fileJs);
		}

		// Busca os titulos do arquivos
		$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/arquivos.ini", "title");
		
		// Percorre os arquivos js
		$module = (string)$request->getModuleName();
		$view->headTitle($config->$module)->setSeparator(" :: ");
	}
}

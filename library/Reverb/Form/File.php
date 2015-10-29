<?php

/**
 * Elemento file do formulario
 *
 * @name Reverb_Form_File
 * @package Reverb
 * @subpackage Form
 */
class Reverb_Form_File extends Zend_Form_Element_File {
	/**
	 * Configura o elemento
	 * 
	 * @name init
	 */
	public function init() {
		parent::setAttrib("field-type", "file");
		parent::setAttrib("class", "file");
	}
}

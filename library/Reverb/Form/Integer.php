<?php

/**
 * Elemento numérico do formulario
 *
 * @name Reverb_Form_Integer
 * @package Reverb
 * @subpackage Form
 */
class Reverb_Form_Integer extends Zend_Form_Element_Text {
	/**
	 * Configura o elemento
	 * 
	 * @name init
	 */
	public function init() {
		parent::setAttrib("alt", "integer");
		parent::setAttrib("class", "integer");
		parent::setAttrib("field-type", "integer");
	}
}

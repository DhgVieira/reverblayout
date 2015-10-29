<?php

/**
 * Elemento de checagem do formulario
 *
 * @name Reverb_Form_Checkbox
 * @package Reverb
 * @subpackage Form
 */
class Reverb_Form_Checkbox extends Zend_Form_Element_Checkbox {
	/**
	 * Configura o elemento
	 * 
	 * @name init
	 */
	public function init() {
		parent::setAttrib("field-type", "checkbox");
	}
}

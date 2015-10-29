<?php

/**
 * Elemento textarea do formulario
 *
 * @name Reverb_Form_Textarea
 * @package Reverb
 * @subpackage Form
 */
class Reverb_Form_Textarea extends Zend_Form_Element_Textarea {
	/**
	 * Configura o elemento
	 * 
	 * @name init
	 */
	public function init() {
		parent::setAttrib("field-type", "textarea");
		parent::setAttrib("class", "string textarea");
	}
}

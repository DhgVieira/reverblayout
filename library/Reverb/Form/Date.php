<?php

/**
 * Elemento date do formulario
 *
 * @name Reverb_Form_Date
 * @package Reverb
 * @subpackage Form
 */
class Reverb_Form_Date extends Zend_Form_Element_Text {
	/**
	 * Configura o elemento
	 * 
	 * @name init
	 */
	public function init() {
		parent::setAttrib("field-type", "date");
		parent::setAttrib("class", "datepicker");
	}
}

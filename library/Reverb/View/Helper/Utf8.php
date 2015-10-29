<?php

/**
 * Cria o helper do utf8
 * 
 * @name Reverb_View_Helper_Utf8
 */
class Reverb_View_Helper_Utf8 extends Zend_View_Helper_Abstract {
    /**
     * Método da classe
     * 
     * @param string $string Texto para converter para translate
     */
    public function utf8($string) {
        if(strpos($string, 'Ã©')){
            $string = utf8_decode($string);
        }elseif(strpos($string, '£')){
            $string = utf8_decode($string);
        }elseif(strpos($string, '§')){
            $string = utf8_decode($string);
        }elseif(strpos($string, 'Ã¡')){
            $string = utf8_decode($string);
        }
        //©
        // Retorna a string formatada
        return $string;
    }
}
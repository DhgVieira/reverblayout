<?php
/**
 * Zend Experts HeadLink
 * @author Petrisor Cibian <petre@around25.com>
 * @version 1.0
 */

class Ze_HeadLink extends Zend_View_Helper_HeadLink
{
    /**
     * @var string $version
     */
    private $version = null;

    /**
     * Constructor method - get version from settings
     */
    public function __construct()
    {
        parent::__construct();

        if(Zend_Registry::isRegistered('config')){
            $config = Zend_Registry::get('config');
            if(isset($config['assets']['css']['version'])){
                $this->version = $config['assets']['css']['version'];
            }
        }
    }

    /**
     * Overloaded method - we add here version to href
     * @param stdClass $item
     * @return string
     */
    public function itemToString(stdClass $item)
    {
        if (!empty($item->href) && $this->version)
        {
            $item->href .= '?v='.$this->version;
        }

        return parent::itemToString($item);
    }
}

<?php
/**
 * Zend Experts HeadLink
 * @author Petrisor Cibian <petre@around25.com>
 * @version 1.0
 */
class Ze_HeadScript extends Zend_View_Helper_HeadScript
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
            if(isset($config['assets']['js']['version'])){
                $this->version = $config['assets']['js']['version'];
            }
        }
    }

    /**
     * Overloaded method - add version to $item
     * @param $item
     * @param int|string $indent
     * @param $escapeStart
     * @param $escapeEnd
     * @return string
     */
    public function itemToString($item, $indent, $escapeStart, $escapeEnd)
    {
        if (!empty($item->attributes['src']) && $this->version)
        {
            $item->attributes['src'] .= '?v='.$this->version;
        }

        return parent::itemToString($item, $indent, $escapeStart, $escapeEnd);
    }
}

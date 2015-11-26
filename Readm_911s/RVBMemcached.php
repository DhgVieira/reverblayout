<?php
/**
 * Created by PhpStorm.
 * User: alecio
 * Date: 25/11/15
 * Time: 00:11
 */
class RVBMemcached {

    public $domain = 'prod-reverbcity.ledcd6.cfg.sae1.cache.amazonaws.com';

    public function flushCache($delay = 0) {
        $m = new Memcached();
        $m->addServer($this->domain, 11211);

        $m->flush($delay);
    }
}
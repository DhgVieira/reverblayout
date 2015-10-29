<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 17:03:08
         compiled from "/Users/design/Reverbcity/site/reverbcity.com/application/layouts/share-buttons.tpl" */ ?>
<?php /*%%SmartyHeaderCode:986093957562d276c3605a5-95913595%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f693d1b4c63a28a0873ae3462b1733adf223d2d7' => 
    array (
      0 => '/Users/design/Reverbcity/site/reverbcity.com/application/layouts/share-buttons.tpl',
      1 => 1445396225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '986093957562d276c3605a5-95913595',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="share-buttons">
    <ul>
        <li class="fb-like-count-box">
      
            <div class="fb-like" data-href="<?php echo $_smarty_tpl->getVariable('_pagina_atual')->value;?>
" data-layout="button" data-action="like" data-show-faces="false" data-share="false" data-width="47"></div>
        </li>

        <li class="fb-share-count-box">
            <div class="fb-share-button" data-href="<?php echo $_smarty_tpl->getVariable('_pagina_atual')->value;?>
" data-type="button" data-width="40"></div>
        </li>

        <li class="pinit-box">
            <a href="//pinterest.com/pin/create/button/" data-pin-do="buttonBookmark">
            </a>
        </li>

        <li class="tweet-button">
            <a href="https://twitter.com/share" data-lang="en" class="twitter-share-button">Tweet</a>
            
            <script>
            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
            </script>
            
        </li>

        <li class="g-button">
            <div class="g-plusone" data-size="medium" data-annotation="none"></div>
        </li>

        <li class="email-button">
            <a href="#" data-modal="indique-lightbox" class="md-trigger">
            </a>
        </li>

    </ul>
</div>

<script async src="//platform.twitter.com/widgets.js"></script>
<script async src="https://assets.pinterest.com/js/pinit.js"></script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

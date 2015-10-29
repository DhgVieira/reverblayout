<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 16:59:18
         compiled from "/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/index/inicio.tpl" */ ?>
<?php /*%%SmartyHeaderCode:449623225562d2686bd9e31-84264772%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd423ad20f5356f79598a8d5d445dccc61632bc54' => 
    array (
      0 => '/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/index/inicio.tpl',
      1 => 1445396245,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '449623225562d2686bd9e31-84264772',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include '/Users/design/Reverbcity/site/reverbcity.com/library/Reverb/Library/Smarty/plugins/modifier.truncate.php';
?>    <div class="banners-advertisement cycle-slideshow"
    data-cycle-fx="fadeout"
    data-cycle-timeout="5000"
    data-cycle-slides="> a"
    data-cycle-log="true"
    data-cycle-pause-on-hover="true" style="margin-bottom:10px;">
        <?php  $_smarty_tpl->tpl_vars['banner'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('banners_topo')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['banner']->key => $_smarty_tpl->tpl_vars['banner']->value){
?>
        <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('banner')->value->NR_SEQ_BANNER_BARC), null, null);?>
        <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('banner')->value->DS_EXT_BARC), null, null);?>
        <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
            <a href="<?php echo $_smarty_tpl->getVariable('banner')->value->DS_LINK_BARC;?>
">
                <?php if (file_exists("arquivos/uploads/banners/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                    <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"banners",'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->getVariable('banner')->value->DS_DESCRICAO_BARC;?>
" />
                <?php }else{ ?>
                    <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->getVariable('banner')->value->DS_DESCRICAO_BARC;?>
" />
                <?php }?>
            </a>
        <?php }} ?>
    </div>

<section class="products">
    <div class="rvb-column left">
        <ul class="rvb-collection-of-products">
            <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
            <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('_produto_dia')->value->DS_EXT_PRRC), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_completa_dia"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
            
            <?php $_smarty_tpl->tpl_vars["fotos"] = new Smarty_variable($_smarty_tpl->getVariable('this')->value->fotoproduto($_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['NR_SEQ_FOTO_FORC']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['DS_EXT_FORC']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_completa_dia"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
            
            <?php if (!file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa_dia')->value))){?>
                <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[1]['NR_SEQ_FOTO_FORC']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[1]['DS_EXT_FORC']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["foto_completa_dia"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
            <?php }?>
            
            <li class="rvb-product-item highlight" style="height: auto;">
                <?php if ($_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_TIPO_PRRC==6){?>
                    <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('camiseta ', null, null);?>
                <?php }else{ ?>
                    <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('', null, null);?>
                <?php }?>

                <?php $_smarty_tpl->tpl_vars['ds_produto_prrc'] = new Smarty_variable(explode(' - ',$_smarty_tpl->getVariable('_produto_dia')->value->DS_PRODUTO_PRRC), null, null);?>
                <?php $_smarty_tpl->tpl_vars['slug'] = new Smarty_variable(($_smarty_tpl->getVariable('preTitle')->value).($_smarty_tpl->getVariable('ds_produto_prrc')->value[0]), null, null);?>

                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp2=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp1,"idproduto"=>$_tmp2),'produto',true);?>
" class="product-photo">
                    <?php if (file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa_dia')->value))){?>
                        <?php $_smarty_tpl->tpl_vars["foto_completa_dia"] = new Smarty_variable(($_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('_produto_dia')->value->DS_PRODUTO_PRRC))."-".($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="<?php echo utf8_decode($_smarty_tpl->getVariable('_produto_dia')->value->DS_PRODUTO_PRRC);?>
">
                            <?php if ($_smarty_tpl->getVariable('_isMobile')->value!=1){?>
                                <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>340,'altura'=>380,'imagem'=>$_smarty_tpl->getVariable('foto_completa_dia')->value),"imagem",true);?>
"></span>
                            <?php }else{ ?>
                                <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>220,'altura'=>250,'imagem'=>$_smarty_tpl->getVariable('foto_completa_dia')->value),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                                <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>280,'altura'=>315,'imagem'=>$_smarty_tpl->getVariable('foto_completa_dia')->value),"imagem",true);?>
" data-media="(max-width: 479px)"></span>
                                <!-- for hd displays -->
                                <span data-width="220" data-height="250" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>440,'altura'=>500,'imagem'=>$_smarty_tpl->getVariable('foto_completa_dia')->value),"imagem",true);?>
" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                                <span data-width="280" data-height="315" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>560,'altura'=>630,'imagem'=>$_smarty_tpl->getVariable('foto_completa_dia')->value),"imagem",true);?>
" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            <?php }?>

                            <noscript>
                                <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>340,'altura'=>380,'imagem'=>'not_found.jpg'),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->getVariable('_produto_dia')->value->DS_PRODUTO_PRRC;?>
">
                            </noscript>
                        </span>
                    <?php }else{ ?>
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="Produto Destaque">
                            <?php if ($_smarty_tpl->getVariable('_isMobile')->value!=1){?>
                                <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>340,'altura'=>380,'imagem'=>'not_found.jpg'),'imagem',true);?>
"></span>
                            <?php }else{ ?>
                                <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>220,'altura'=>250,'imagem'=>'not_found.jpg'),'imagem',true);?>
" data-media="(max-width: 767px)"></span>
                                <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>280,'altura'=>315,'imagem'=>'not_found.jpg'),'imagem',true);?>
" data-media="(max-width: 479px)"></span>
                                <!-- for hd displays -->
                                <span data-width="220" data-height="250" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>440,'altura'=>500,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                                <span data-width="280" data-height="315" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>560,'altura'=>630,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            <?php }?>

                            <noscript>
                                <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>340,'altura'=>380,'imagem'=>'not_found.jpg'),'imagem',true);?>
" alt="Imagem não encontrada - Reverbcity">
                            </noscript>
                        </span>
                    <?php }?>
                    <span class="rvb-tag new productday"></span>
                </a>
                <div class="product-details">
                    <h2 class="product-name">
                        <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp4=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp3,"idproduto"=>$_tmp4),'produto',true);?>
">
                            <?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('_produto_dia')->value->DS_PRODUTO_PRRC,29,"...",true);?>

                            <?php if ($_smarty_tpl->getVariable('_produto_dia')->value->DS_FRETEGRATIS_PRRC=='S'){?>
                                - Frete Grátis
                            <?php }?>
                        </a>
                    </h2>
                    <p class="price">
                        <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp5=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp6=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp5,"idproduto"=>$_tmp6),'produto',true);?>
">
                            <span class="old-price">R$ <?php echo number_format($_smarty_tpl->getVariable('_produto_dia')->value->VL_PRODUTO_PRRC,2,",",".");?>
</span>
                            por R$ <?php echo number_format($_smarty_tpl->getVariable('_produto_dia')->value->VL_PROMO_PRRC,2,",",".");?>

                        </a>
                    </p>
                </div>
            </li>
            <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('destaque')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
            <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('destaque')->value->DS_EXT_PRRC), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
            
            <?php $_smarty_tpl->tpl_vars["fotos"] = new Smarty_variable($_smarty_tpl->getVariable('this')->value->fotoproduto($_smarty_tpl->getVariable('destaque')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['NR_SEQ_FOTO_FORC']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['DS_EXT_FORC']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>

            <li class="rvb-product-item highlight" style="height: auto;">
            <?php if ($_smarty_tpl->getVariable('destaque')->value->NR_SEQ_TIPO_PRRC==6){?>
                <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('camiseta ', null, null);?>
            <?php }else{ ?>
                <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('', null, null);?>
            <?php }?>

            <?php $_smarty_tpl->tpl_vars['ds_produto_prrc'] = new Smarty_variable(explode(' - ',$_smarty_tpl->getVariable('destaque')->value->DS_PRODUTO_PRRC), null, null);?>
            <?php $_smarty_tpl->tpl_vars['slug'] = new Smarty_variable(($_smarty_tpl->getVariable('preTitle')->value).($_smarty_tpl->getVariable('ds_produto_prrc')->value[0]), null, null);?>

              <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp7=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('destaque')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp8=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp7,"idproduto"=>$_tmp8),'produto',true);?>
" class="product-photo">
            <?php if (file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                    <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('destaque')->value->DS_PRODUTO_PRRC))."-".($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="<?php echo $_smarty_tpl->getVariable('destaque')->value->DS_PRODUTO_PRRC;?>
" title="<?php echo $_smarty_tpl->getVariable('destaque')->value->DS_PRODUTO_PRRC;?>
">
                        <?php if ($_smarty_tpl->getVariable('_isMobile')->value!=1){?>
                            <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>340,'altura'=>380,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
"></span>
                        <?php }else{ ?>
                            <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>220,'altura'=>250,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                            <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>280,'altura'=>315,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 479px)"></span>
                            <!-- for hd displays -->
                            <span data-width="220" data-height="250" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>440,'altura'=>500,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            <span data-width="280" data-height="315" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>560,'altura'=>630,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                        <?php }?>

                        <noscript>
                            <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>340,'altura'=>380,'imagem'=>'not_found.jpg'),'imagem',true);?>
" alt="Imagem não encontrada - Reverbcity">
                        </noscript>
                    </span>
            <?php }else{ ?>
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="Produto Destaque">
                        <?php if ($_smarty_tpl->getVariable('_isMobile')->value!=1){?>
                            <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>340,'altura'=>380,'imagem'=>'not_found.jpg'),'imagem',true);?>
"></span>
                        <?php }else{ ?>
                            <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>220,'altura'=>250,'imagem'=>'not_found.jpg'),'imagem',true);?>
" data-media="(max-width: 767px)"></span>
                            <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>280,'altura'=>315,'imagem'=>'not_found.jpg'),'imagem',true);?>
" data-media="(max-width: 479px)"></span>
                            <!-- for hd displays -->
                            <span data-width="220" data-height="250" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>440,'altura'=>500,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            <span data-width="280" data-height="315" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>560,'altura'=>630,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                        <?php }?>
                        <noscript>
                            <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>340,'altura'=>380,'imagem'=>'not_found.jpg'),'imagem',true);?>
" alt="Imagem não encontrada - Reverbcity">
                        </noscript>
                    </span>
            <?php }?>
                    <span class="rvb-tag new big"></span>
                </a>
                <div class="product-details">
                    <h2 class="product-name">
                        <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp9=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('destaque')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp10=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp9,"idproduto"=>$_tmp10),'produto',true);?>
">
                            <?php echo utf8_decode($_smarty_tpl->getVariable('destaque')->value->DS_PRODUTO_PRRC);?>

                            <?php if ($_smarty_tpl->getVariable('destaque')->value->DS_FRETEGRATIS_PRRC=='S'){?>
                                    - Frete Grátis
                            <?php }?>
                        </a>
                    </h2>
                    <p class="price">
                    <?php if ($_smarty_tpl->getVariable('destaque')->value->VL_PROMO_PRRC!=0){?>
                        <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp11=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('destaque')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp12=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp11,"idproduto"=>$_tmp12),'produto',true);?>
">
                            <span class="old-price">R$ <?php echo number_format($_smarty_tpl->getVariable('destaque')->value->VL_PRODUTO_PRRC,2,",",".");?>
</span>
                            por R$ <?php echo number_format($_smarty_tpl->getVariable('destaque')->value->VL_PROMO_PRRC,2,",",".");?>

                        </a>
                    <?php }else{ ?>
                        <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp13=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('destaque')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp14=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp13,"idproduto"=>$_tmp14),'produto',true);?>
">
                            R$ <?php echo number_format($_smarty_tpl->getVariable('destaque')->value->VL_PRODUTO_PRRC,2,",",".");?>

                        </a>
                    <?php }?>
                    </p>
                </div>
            </li>
            <?php  $_smarty_tpl->tpl_vars['produto'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('contadores')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['produto']->key => $_smarty_tpl->tpl_vars['produto']->value){
?>
                <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->tpl_vars['produto']->value['NR_SEQ_PRODUTO_PRRC']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->tpl_vars['produto']->value['DS_EXT_PRRC']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
                
                <?php $_smarty_tpl->tpl_vars["fotos"] = new Smarty_variable($_smarty_tpl->getVariable('this')->value->fotoproduto($_smarty_tpl->tpl_vars['produto']->value['NR_SEQ_PRODUTO_PRRC']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['NR_SEQ_FOTO_FORC']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['DS_EXT_FORC']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
            <li class="rvb-product-item">
                <?php if ($_smarty_tpl->tpl_vars['produto']->value['NR_SEQ_TIPO_PRRC']==6){?>
                    <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('camiseta ', null, null);?>
                <?php }else{ ?>
                    <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('', null, null);?>
                <?php }?>

                <?php $_smarty_tpl->tpl_vars['ds_produto_prrc'] = new Smarty_variable(explode(' - ',$_smarty_tpl->tpl_vars['produto']->value['DS_PRODUTO_PRRC']), null, null);?>
                <?php $_smarty_tpl->tpl_vars['slug'] = new Smarty_variable(($_smarty_tpl->getVariable('preTitle')->value).($_smarty_tpl->getVariable('ds_produto_prrc')->value[0]), null, null);?>

                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp15=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['produto']->value['NR_SEQ_PRODUTO_PRRC'];?>
<?php $_tmp16=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp15,"idproduto"=>$_tmp16),'produto',true);?>
" class="product-photo">
                    <?php if (file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                        <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->tpl_vars['produto']->value['DS_PRODUTO_PRRC']))."-".($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="<?php echo $_smarty_tpl->tpl_vars['produto']->value['DS_PRODUTO_PRRC'];?>
" data-title="<?php echo $_smarty_tpl->tpl_vars['produto']->value['DS_PRODUTO_PRRC'];?>
">
                            <?php if ($_smarty_tpl->getVariable('_isMobile')->value!=1){?>
                                <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>160,'altura'=>185,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
"></span>
                            <?php }else{ ?>
                                <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>140,'altura'=>160,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                                <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>130,'altura'=>150,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 479px)"></span>
                                <!-- for hd displays -->
                                <span data-width="140" data-height="160" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>280,'altura'=>320,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                                <span data-width="130" data-height="150" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>260,'altura'=>300,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            <?php }?>

                            <noscript>
                                <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>160,'altura'=>185,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['produto']->value['DS_PRODUTO_PRRC'];?>
" width="160" height="185">
                            </noscript>
                        </span>
                    <?php }else{ ?>
                        <!-- Polyfill para imagens responsivas-->

                        <span data-picture data-alt="<?php echo $_smarty_tpl->tpl_vars['produto']->value['DS_PRODUTO_PRRC'];?>
" data-title="<?php echo $_smarty_tpl->tpl_vars['produto']->value['DS_PRODUTO_PRRC'];?>
">
                            <?php if ($_smarty_tpl->getVariable('_isMobile')->value!=1){?>
                                <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>160,'altura'=>185,'imagem'=>'not_found.jpg'),"imagem",true);?>
"></span>
                            <?php }else{ ?>
                                <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>140,'altura'=>160,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                                <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>130,'altura'=>150,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 479px)"></span>
                                <!-- for hd displays -->
                                <span data-width="140" data-height="160" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>280,'altura'=>320,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                                <span data-width="130" data-height="150" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>260,'altura'=>300,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            <?php }?>

                            <noscript>
                                <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>160,'altura'=>185,'imagem'=>'not_found.jpg'),"imagem",true);?>
" alt="Imagem não encontrada - Reverbcity" width="160" height="185">
                            </noscript>
                        </span>
                    <?php }?>
                    
                <?php if ($_smarty_tpl->tpl_vars['produto']->value['DS_FRETEGRATIS_PRRC']=='S'){?>
                    <span class="rvb-tag sale-frete"></span>                    
                <?php }elseif($_smarty_tpl->tpl_vars['produto']->value['TP_DESTAQUE_PRRC']==1&&$_smarty_tpl->tpl_vars['produto']->value['DS_FRETEGRATIS_PRRC']=='N'){?>
                    <span class="rvb-tag new"></span>
                <?php }elseif($_smarty_tpl->tpl_vars['produto']->value['TP_DESTAQUE_PRRC']==3){?>
                    <span class="rvb-tag reprint"></span>
                <?php }elseif($_smarty_tpl->tpl_vars['produto']->value['TP_DESTAQUE_PRRC']==2){?>
                    <span class="rvb-tag sale"></span>
                <?php }else{ ?>
                <?php }?>
                </a>
                <h2 class="product-name">
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp17=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['produto']->value['NR_SEQ_PRODUTO_PRRC'];?>
<?php $_tmp18=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp17,"idproduto"=>$_tmp18),'produto',true);?>
">
                        <?php if ($_smarty_tpl->tpl_vars['produto']->value['NR_SEQ_TIPO_PRRC']==6){?>camiseta <?php }?><?php echo $_smarty_tpl->tpl_vars['produto']->value['DS_PRODUTO_PRRC'];?>

                    </a>
                </h2>
               <p class="price">
                   <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp19=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['produto']->value['NR_SEQ_PRODUTO_PRRC'];?>
<?php $_tmp20=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp19,"idproduto"=>$_tmp20),'produto',true);?>
">
                    <?php if ($_smarty_tpl->tpl_vars['produto']->value['VL_PROMO_PRRC']>0){?>
                        <del>R$ <?php echo number_format($_smarty_tpl->tpl_vars['produto']->value['VL_PRODUTO_PRRC'],2,",",".");?>
</del>
                        Por R$ <?php echo number_format($_smarty_tpl->tpl_vars['produto']->value['VL_PROMO_PRRC'],2,",",".");?>

                    <?php }else{ ?>
                         R$ <?php echo number_format($_smarty_tpl->tpl_vars['produto']->value['VL_PRODUTO_PRRC'],2,",",".");?>
 
                    <?php }?>
                   </a>
                </p>

            </li>
            <?php }} ?>
        </ul>

        <ul class="pagination">
             <ul class="pagination">
            <?php if ($_smarty_tpl->getVariable('categoria_produto')->value!=''){?>

                <?php if ($_smarty_tpl->getVariable('pages')->value['previous']){?>
                    <li class="item">
                        <a rel="nofollow" title="Página Anterior" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('pages')->value['previous'];?>
<?php $_tmp21=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('categoria_produto')->value;?>
<?php $_tmp22=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("module"=>"default","controller"=>"index","action"=>"inicio","page"=>$_tmp21,"idcategoria"=>$_tmp22),"inicio",true);?>
">◄</a>
                    </li>
                <?php }?>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['name'] = 'page_loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start'] = (int)$_smarty_tpl->getVariable('this')->value->contadores->current_page-1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('this')->value->contadores->current_page+3) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['total']);
?>
                    <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['page_loop']['index']+1==$_smarty_tpl->getVariable('this')->value->contadores->current_page){?>
                        <li class="item">
                            <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('categoria_produto')->value;?>
<?php $_tmp23=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("module"=>"default","controller"=>"index","action"=>"inicio","page"=>$_smarty_tpl->getVariable('smarty')->value['section']['page_loop']['index']+1,"idcategoria"=>$_tmp23),'inicio',true);?>
" class="active">
                                <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['page_loop']['index']+1;?>

                            </a>
                        </li>
                    <?php }else{ ?>
                        <li class="item">
                            <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('categoria_produto')->value;?>
<?php $_tmp24=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("module"=>"default","controller"=>"index","action"=>"inicio","page"=>$_smarty_tpl->getVariable('smarty')->value['section']['page_loop']['index']+1,"idcategoria"=>$_tmp24),'inicio',true);?>
">
                                <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['page_loop']['index']+1;?>

                            </a>
                        </li>
                    <?php }?>
                <?php endfor; endif; ?>
                <?php if ($_smarty_tpl->getVariable('pages')->value['next']){?>
                    <li class="item">
                        <a rel="nofollow" title="Página Anterior" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('pages')->value['next'];?>
<?php $_tmp25=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('categoria_produto')->value;?>
<?php $_tmp26=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("module"=>"default","controller"=>"index","action"=>"inicio","page"=>$_tmp25,"idcategoria"=>$_tmp26),"inicio",true);?>
">►</a>
                    </li>
                <?php }?>

            <?php }else{ ?>

                <?php if ($_smarty_tpl->getVariable('pages')->value['previous']){?>
                    <li class="item">
                        <a rel="nofollow" title="Página Anterior" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('pages')->value['previous'];?>
<?php $_tmp27=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("module"=>"default","controller"=>"index","action"=>"inicio","page"=>$_tmp27),"inicio",true);?>
">◄</a>
                    </li>
                <?php }?>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['name'] = 'page_loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start'] = (int)$_smarty_tpl->getVariable('this')->value->contadores->current_page-1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('this')->value->contadores->current_page+3) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['page_loop']['total']);
?>
                    <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['page_loop']['index']+1==$_smarty_tpl->getVariable('this')->value->contadores->current_page){?>
                        <li class="item">
                            <a rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array("module"=>"default","controller"=>"index","action"=>"inicio","page"=>$_smarty_tpl->getVariable('smarty')->value['section']['page_loop']['index']+1),'inicio',true);?>
" class="active">
                                <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['page_loop']['index']+1;?>

                            </a>
                        </li>
                    <?php }else{ ?>
                        <?php if ($_smarty_tpl->getVariable('pages')->value['next']&&$_smarty_tpl->getVariable('pages')->value['last']>=$_smarty_tpl->getVariable('smarty')->value['section']['page_loop']['index']+1){?>
                        <li class="item">
                            <a rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array("module"=>"default","controller"=>"index","action"=>"inicio","page"=>$_smarty_tpl->getVariable('smarty')->value['section']['page_loop']['index']+1),'inicio',true);?>
">
                                <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['page_loop']['index']+1;?>

                            </a>
                        </li>
                        <?php }?>
                    <?php }?>
                <?php endfor; endif; ?>
                <?php if ($_smarty_tpl->getVariable('pages')->value['next']){?>
                    <li class="item">
                        <a rel="nofollow" title="Página Anterior" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('pages')->value['next'];?>
<?php $_tmp28=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("module"=>"default","controller"=>"index","action"=>"inicio","page"=>$_tmp28),"inicio",true);?>
">►</a>
                    </li>
                <?php }?>

            <?php }?>
        </ul>
    </div>

    <div class="rvb-column right">
      <?php $_template = new Smarty_Internal_Template("sidebar-default.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    </div>
</section>

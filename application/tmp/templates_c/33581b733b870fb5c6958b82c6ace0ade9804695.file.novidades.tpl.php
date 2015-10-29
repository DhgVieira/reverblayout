<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 19:32:55
         compiled from "/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/loja/novidades.tpl" */ ?>
<?php /*%%SmartyHeaderCode:964056127562d4a87ce33f5-42191299%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '33581b733b870fb5c6958b82c6ace0ade9804695' => 
    array (
      0 => '/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/loja/novidades.tpl',
      1 => 1445396247,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '964056127562d4a87ce33f5-42191299',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
    <?php $_smarty_tpl->tpl_vars["acaoAtual"] = new Smarty_variable(($_smarty_tpl->getVariable('currentAction')->value), null, null);?>

    <?php if ($_smarty_tpl->getVariable('acaoAtual')->value=="index"){?>
        <?php $_smarty_tpl->tpl_vars["acaoAtual"] = new Smarty_variable("loja", null, null);?>
    <?php }?>
<div class="banners-advertisement cycle-slideshow"
    data-cycle-fx="fadeout"
    data-cycle-timeout="5000"
    data-cycle-slides="> a"
    data-cycle-log="false"
    data-cycle-pause-on-hover="true" style="margin-bottom:10px;">
        <?php  $_smarty_tpl->tpl_vars['banner'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('banners_topo')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['banner']->key => $_smarty_tpl->tpl_vars['banner']->value){
?>
        <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('banner')->value->NR_SEQ_BANNER_BARC), null, null);?>
        <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('banner')->value->DS_EXT_BARC), null, null);?>
        <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
            <a rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('banner')->value->DS_LINK_BARC;?>
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
    <h1 class="rvb-title">Reverb <span>Novidades</span></h1>
    <span class="breadcrumb">
        <div style="float: left;" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a itemprop="url" href="https://www.reverbcity.com/inicio">
                <span itemprop="title">Reverbcity</span>
            </a> >
            <div style="display: inline-block;" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                <a itemprop="url" itemprop="title" href="https://www.reverbcity.com/loja">
                    <span itemprop="title">Loja</span>
                </a> >
                <div style="display: inline-block;" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                    <a itemprop="url" itemprop="title" href="https://www.reverbcity.com/novidades">
                        <span itemprop="title"><b>Novidades</b></span>
                    </a>
                </div>
            </div>
        </div>
    </span>

<?php if (count($_smarty_tpl->getVariable('contadores')->value)>0){?>
    <div class="rvb-column left">
        <ul class="rvb-collection-of-products">
            <?php  $_smarty_tpl->tpl_vars['produto'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('contadores')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['produto']->key => $_smarty_tpl->tpl_vars['produto']->value){
?>
                <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
                <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('produto')->value->DS_EXT_PRRC), null, null);?>
                <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
                
                <?php $_smarty_tpl->tpl_vars["fotos"] = new Smarty_variable($_smarty_tpl->getVariable('this')->value->fotoproduto($_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
                <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['NR_SEQ_FOTO_FORC']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['DS_EXT_FORC']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>

                <?php if ($_smarty_tpl->getVariable('produto')->value->NR_SEQ_TIPO_PRRC==6){?>
                    <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('camiseta ', null, null);?>
                <?php }else{ ?>
                    <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('', null, null);?>
                <?php }?>

                <?php $_smarty_tpl->tpl_vars['ds_produto_prrc'] = new Smarty_variable(explode(' - ',$_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC), null, null);?>
                <?php $_smarty_tpl->tpl_vars['slug'] = new Smarty_variable(($_smarty_tpl->getVariable('preTitle')->value).($_smarty_tpl->getVariable('ds_produto_prrc')->value[0]), null, null);?>
                    
            <li class="rvb-product-item">
                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp2=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp1,"idproduto"=>$_tmp2),'produto',true);?>
" class="product-photo">
                    <?php if (file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                        <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC))."-".($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
" data-title="<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
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
" alt="<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
">
                            </noscript>
                        </span>
                    <?php }else{ ?>
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
" data-title="<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
">
                            <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>160,'altura'=>185,'imagem'=>'not_found.jpg'),"imagem",true);?>
"></span>
                            <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>140,'altura'=>160,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                            <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>130,'altura'=>150,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 479px)"></span>
                            <!-- for hd displays -->
                            <span data-width="140" data-height="160" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>280,'altura'=>320,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            <span data-width="130" data-height="150" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>260,'altura'=>300,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>

                            <noscript>
                                <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>160,'altura'=>185,'imagem'=>'not_found.jpg'),"imagem",true);?>
" alt="Imagem não encontrada - Reverbcity">
                            </noscript>
                        </span>
                    <?php }?>
                    
                    <?php if ($_smarty_tpl->getVariable('produto')->value->TP_DESTAQUE_PRRC==1||$_smarty_tpl->getVariable('produto')->value->TP_DESTAQUE_PRRC==6){?>
                    <span class="rvb-tag new"></span>
                    <?php }elseif($_smarty_tpl->getVariable('produto')->value->TP_DESTAQUE_PRRC==3){?>
                        <span class="rvb-tag reprint"></span>
                    <?php }elseif($_smarty_tpl->getVariable('produto')->value->TP_DESTAQUE_PRRC==2){?>
                        <span class="rvb-tag sale"></span>
                    <?php }elseif($_smarty_tpl->getVariable('produto')->value->DS_FRETEGRATIS_PRRC=='S'){?>
                        <span class="rvb-tag sale-frete"></span>
                    <?php }else{ ?>
                         <span class="rvb-tag"></span>
                    <?php }?>
                </a>
                <h2 class="product-name">
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp4=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp3,"idproduto"=>$_tmp4),'produto',true);?>
">
                        <?php if ($_smarty_tpl->getVariable('produto')->value->NR_SEQ_TIPO_PRRC==6){?>camiseta <?php }?><?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>

                    </a>
                </h2>
                <p class="price">
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp5=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp6=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp5,"idproduto"=>$_tmp6),'produto',true);?>
">
                        <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>0){?>
                            <del>R$ <?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC,2,",",".");?>
</del>
                            Por R$ <?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC,2,",",".");?>

                        <?php }else{ ?>
                             R$ <?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC,2,",",".");?>

                        <?php }?>
                    </a>
                </p>
            </li>
            <?php }} ?>
        </ul>
        
        <?php if (count($_smarty_tpl->getVariable('contadores')->value)>20){?>
            <ul class="pagination">
                <?php echo $_smarty_tpl->getVariable('this')->value->paginationControl($_smarty_tpl->getVariable('contadores')->value,null,'paginator_loja.tpl');?>

            </ul>
        <?php }?>
    </div>

    <?php }else{ ?>
        <div id="empty-result" style="display: block;width: 100%;">

            <img src="<?php echo $_smarty_tpl->getVariable('basePath')->value;?>
/arquivos/default/images/empty-result2.png" alt="Página não encontrada" style="max-width: 100%;height: auto;display: block;margin: 0 auto;" />

            <p class="visuallyhidden">
                Hey, não encontramos
                nada relacionado com a
                busca que você digitou... :(
                Tente novamente e tenha
                certeza que digitou
                tudo certo.. 
            </p>
        </div>
    <?php }?>
    <?php if (count($_smarty_tpl->getVariable('contadores')->value)>0){?>
        <div class="rvb-column right">
            <?php $_template = new Smarty_Internal_Template("sidebar-filters.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        </div>
    <?php }?>

</section>

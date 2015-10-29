<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 17:03:08
         compiled from "/Users/design/Reverbcity/site/reverbcity.com/application/layouts/suggestion-products.tpl" */ ?>
<?php /*%%SmartyHeaderCode:490709241562d276c421967-14255623%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09a9fecb930065f2a8be46fb19172afc318840db' => 
    array (
      0 => '/Users/design/Reverbcity/site/reverbcity.com/application/layouts/suggestion-products.tpl',
      1 => 1445396224,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '490709241562d276c421967-14255623',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php ob_start();?><?php echo count($_smarty_tpl->getVariable('_visitados')->value);?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars["max_visitados"] = new Smarty_variable($_tmp1, null, null);?>
<?php if ($_smarty_tpl->getVariable('max_visitados')->value<=0){?>
  <?php $_smarty_tpl->tpl_vars["max"] = new Smarty_variable("4", null, null);?>
  <?php $_smarty_tpl->tpl_vars["visitado"] = new Smarty_variable("0", null, null);?>
<?php }?>

<?php if ($_smarty_tpl->getVariable('max_visitados')->value==1){?>
  <?php $_smarty_tpl->tpl_vars["max"] = new Smarty_variable("3", null, null);?>
  <?php $_smarty_tpl->tpl_vars["visitado"] = new Smarty_variable("1", null, null);?>
<?php }?>

<?php if ($_smarty_tpl->getVariable('max_visitados')->value>=2){?>
  <?php $_smarty_tpl->tpl_vars["max"] = new Smarty_variable("2", null, null);?>
  <?php $_smarty_tpl->tpl_vars["visitado"] = new Smarty_variable("2", null, null);?>
<?php }?>

<?php if ($_smarty_tpl->getVariable('currentAction')->value=="produtolojista"){?>
  <?php $_smarty_tpl->tpl_vars["acao"] = new Smarty_variable("produtolojista", null, null);?>
<?php }else{ ?>
  <?php $_smarty_tpl->tpl_vars["acao"] = new Smarty_variable("produto", null, null);?>
<?php }?>

<div class="sidebar-bottom clearfix">
    <!-- Sugestoes -->
    <?php if (count($_smarty_tpl->getVariable('_sugestoes')->value)>0){?>
    <div class="category-item suggestions items-<?php echo $_smarty_tpl->getVariable('max')->value;?>
">
        <p class="title-category">Sugestões</p>
        <ul class="list-of-products">
          <?php  $_smarty_tpl->tpl_vars['sugestao'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('_sugestoes')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['sugestao']->iteration=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['sugestao']->key => $_smarty_tpl->tpl_vars['sugestao']->value){
 $_smarty_tpl->tpl_vars['sugestao']->iteration++;
?>
          <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('sugestao')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
          <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('sugestao')->value->DS_EXT_PRRC), null, null);?>
          <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
          
          <?php $_smarty_tpl->tpl_vars["fotos"] = new Smarty_variable($_smarty_tpl->getVariable('this')->value->fotoproduto($_smarty_tpl->getVariable('sugestao')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['NR_SEQ_FOTO_FORC']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['DS_EXT_FORC']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>

            <?php if ($_smarty_tpl->tpl_vars['sugestao']->iteration>$_smarty_tpl->getVariable('max')->value){?>
              <?php break 1?>
            <?php }?>

              <?php if ($_smarty_tpl->getVariable('sugestao')->value->NR_SEQ_TIPO_PRRC==6){?>
                  <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('camiseta ', null, null);?>
              <?php }else{ ?>
                  <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('', null, null);?>
              <?php }?>

              <?php $_smarty_tpl->tpl_vars['ds_produto_prrc'] = new Smarty_variable(explode(' - ',$_smarty_tpl->getVariable('sugestao')->value->DS_PRODUTO_PRRC), null, null);?>
              <?php $_smarty_tpl->tpl_vars['slug'] = new Smarty_variable(($_smarty_tpl->getVariable('preTitle')->value).($_smarty_tpl->getVariable('ds_produto_prrc')->value[0]), null, null);?>
            <li class="product-item">
                <a class="thumb" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('sugestao')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp4=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp2,"idproduto"=>$_tmp3),$_tmp4,true);?>
">
                  <?php if (file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="<?php echo $_smarty_tpl->getVariable('sugestao')->value->DS_PRODUTO_PRRC;?>
">
                        <!--imagem padrão-->
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>171,'altura'=>190,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
"></span>
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>164,'altura'=>181,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 979px)"></span>
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>138,'altura'=>154,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>138,'altura'=>154,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 479px)"></span>
                        <!-- for hd displays -->
                        <span data-width="138" data-height="154" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>276,'altura'=>308,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                        <span data-width="138" data-height="154" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>276,'altura'=>308,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 767px)"></span>

                        <noscript>
                          <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>171,'altura'=>190,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->getVariable('sugestao')->value->DS_PRODUTO_PRRC;?>
">
                        </noscript>
                    </span>
                  <?php }else{ ?>
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="<?php echo $_smarty_tpl->getVariable('sugestao')->value->DS_PRODUTO_PRRC;?>
">
                        <!--imagem padrão-->
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>171,'altura'=>190,'imagem'=>'not_found.jpg'),"imagem",true);?>
"></span>
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>164,'altura'=>181,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 979px)"></span>
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>138,'altura'=>154,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>138,'altura'=>154,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 479px)"></span>
                        <!-- for hd displays -->
                        <span data-width="138" data-height="154" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>276,'altura'=>308,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                        <span data-width="138" data-height="154" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>276,'altura'=>308,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px)"></span>

                        <noscript>
                          <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>171,'altura'=>190,'imagem'=>'not_found.jpg'),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->getVariable('sugestao')->value->DS_PRODUTO_PRRC;?>
">
                        </noscript>
                    </span>
                  <?php }?>

                </a>
                <p class="product-title">
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp5=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('sugestao')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp6=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp7=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp5,"idproduto"=>$_tmp6),$_tmp7,true);?>
"><?php echo $_smarty_tpl->getVariable('sugestao')->value->DS_PRODUTO_PRRC;?>
</a>
                </p>
                <p class="product-price">
                  <?php if ($_smarty_tpl->getVariable('sugestao')->value->VL_PROMO_PRRC!=0){?>
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp8=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('sugestao')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp9=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp10=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp8,"idproduto"=>$_tmp9),$_tmp10,true);?>
">R$ <?php echo number_format($_smarty_tpl->getVariable('sugestao')->value->VL_PROMO_PRRC,2,",",".");?>
</a>
                  <?php }else{ ?>
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp11=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('sugestao')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp12=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp13=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp11,"idproduto"=>$_tmp12),$_tmp13,true);?>
">R$ <?php echo number_format($_smarty_tpl->getVariable('sugestao')->value->VL_PRODUTO_PRRC,2,",",".");?>
</a>
                  <?php }?>
                </p>
            </li>
          <?php }} ?>
        </ul>
    </div>
    <?php }?>

    <?php if (count($_smarty_tpl->getVariable('_visitados')->value)>0){?>
    <div class="category-item visited items-<?php echo $_smarty_tpl->getVariable('visitado')->value;?>
">
        <p class="title-category">Produtos vistos</p>
        <ul class="list-of-products">
            <?php ob_start(); ?><?php echo shuffle($_smarty_tpl->getVariable('_visitados')->value);?>
<?php  Smarty::$_smarty_vars['capture']['default']=ob_get_clean();?>

            <?php  $_smarty_tpl->tpl_vars['visitado'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('_visitados')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['visitado']->iteration=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['visitado']->key => $_smarty_tpl->tpl_vars['visitado']->value){
 $_smarty_tpl->tpl_vars['visitado']->iteration++;
?>

            <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->tpl_vars['visitado']->value['codigo']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->tpl_vars['visitado']->value['path']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
            <?php $_smarty_tpl->tpl_vars["max"] = new Smarty_variable("2", null, null);?>
            
            <?php $_smarty_tpl->tpl_vars["fotos"] = new Smarty_variable($_smarty_tpl->getVariable('this')->value->fotoproduto($_smarty_tpl->tpl_vars['visitado']->value['codigo']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['NR_SEQ_FOTO_FORC']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['DS_EXT_FORC']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>

            <?php if ($_smarty_tpl->tpl_vars['visitado']->iteration>$_smarty_tpl->getVariable('max')->value){?>
              <?php break 1?>
            <?php }?>

                <?php if ($_smarty_tpl->tpl_vars['visitado']->value['tipo']==6){?>
                    <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('camiseta ', null, null);?>
                <?php }else{ ?>
                    <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('', null, null);?>
                <?php }?>

                <?php $_smarty_tpl->tpl_vars['ds_produto_prrc'] = new Smarty_variable(explode(' - ',$_smarty_tpl->tpl_vars['visitado']->value['nome']), null, null);?>
                <?php $_smarty_tpl->tpl_vars['slug'] = new Smarty_variable(($_smarty_tpl->getVariable('preTitle')->value).($_smarty_tpl->getVariable('ds_produto_prrc')->value[0]), null, null);?>
            <li class="product-item">
                <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp14=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['visitado']->value['codigo'];?>
<?php $_tmp15=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp16=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp14,"idproduto"=>$_tmp15),$_tmp16,true);?>
" class="thumb">
                  <?php if (file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                      <!-- Polyfill para imagens responsivas-->
                      <span data-picture data-alt="<?php echo $_smarty_tpl->tpl_vars['visitado']->value['nome'];?>
">
                          <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>171,'altura'=>190,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
"></span>
                          <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>164,'altura'=>181,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 979px)"></span>
                          <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>138,'altura'=>154,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                          <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>138,'altura'=>154,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 479px)"></span>
                          <!-- for hd displays -->
                          <span data-width="138" data-height="154" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>276,'altura'=>308,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                          <span data-width="138" data-height="154" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>276,'altura'=>308,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" data-media="(max-width: 767px)"></span>

                          <noscript>
                            <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>171,'altura'=>190,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['visitado']->value['nome'];?>
">
                          </noscript>
                      </span>
                  <?php }else{ ?>
                      <!-- Polyfill para imagens responsivas-->
                      <span data-picture data-alt="<?php echo $_smarty_tpl->tpl_vars['visitado']->value['nome'];?>
">
                          <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>171,'altura'=>190,'imagem'=>'not_found.jpg'),"imagem",true);?>
"></span>
                          <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>164,'altura'=>181,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 979px)"></span>
                          <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>138,'altura'=>154,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                          <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>138,'altura'=>154,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 479px)"></span>
                          <!-- for hd displays -->
                          <span data-width="138" data-height="154" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>276,'altura'=>308,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                          <span data-width="138" data-height="154" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>276,'altura'=>308,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px)"></span>

                          <noscript>
                            <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>171,'altura'=>190,'imagem'=>'not_found.jpg'),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['visitado']->value['nome'];?>
">
                          </noscript>
                      </span>
                  <?php }?>
                </a>
                <p class="product-title">
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp17=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['visitado']->value['codigo'];?>
<?php $_tmp18=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp19=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp17,"idproduto"=>$_tmp18),$_tmp19,true);?>
"><?php echo utf8_decode($_smarty_tpl->tpl_vars['visitado']->value['nome']);?>
</a>
                </p>
                <p class="product-price">
                  <?php if ($_smarty_tpl->tpl_vars['visitado']->value['promo']!=0){?>
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp20=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['visitado']->value['codigo'];?>
<?php $_tmp21=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp22=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp20,"idproduto"=>$_tmp21),$_tmp22,true);?>
">R$ <?php echo number_format($_smarty_tpl->tpl_vars['visitado']->value['promo'],2,",",".");?>
</a>
                  <?php }else{ ?>
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp23=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['visitado']->value['codigo'];?>
<?php $_tmp24=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp25=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp23,"idproduto"=>$_tmp24),$_tmp25,true);?>
">R$ <?php echo number_format($_smarty_tpl->tpl_vars['visitado']->value['valor'],2,",",".");?>
</a>
                  <?php }?>
                </p>
            </li>
            <?php }} ?>
        </ul>
    </div>
    <?php }?>

    <div class="category-item day">
        <p class="title-category black">Produto do dia</p>
        <ul class="list-of-products">
           <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
           <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('_produto_dia')->value->DS_EXT_PRRC), null, null);?>
           <?php $_smarty_tpl->tpl_vars["foto_completa_dia"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
           
            <?php $_smarty_tpl->tpl_vars["fotos"] = new Smarty_variable($_smarty_tpl->getVariable('this')->value->fotoproduto($_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['NR_SEQ_FOTO_FORC']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['DS_EXT_FORC']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_completa_dia"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>

            <?php if ($_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_TIPO_PRRC==6){?>
                <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('Camiseta ', null, null);?>
            <?php }else{ ?>
                <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('', null, null);?>
            <?php }?>
            <?php $_smarty_tpl->tpl_vars['ds_produto_prrc'] = new Smarty_variable(explode(' - ',$_smarty_tpl->getVariable('_produto_dia')->value->DS_PRODUTO_PRRC), null, null);?>
            <?php $_smarty_tpl->tpl_vars['slug'] = new Smarty_variable(($_smarty_tpl->getVariable('preTitle')->value).($_smarty_tpl->getVariable('ds_produto_prrc')->value[0]), null, null);?>

            <li class="product-item last">
                <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp26=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp27=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp28=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp26,"idproduto"=>$_tmp27),$_tmp28,true);?>
" class="thumb">
                  <?php if (file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa_dia')->value))){?>
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="<?php echo utf8_decode($_smarty_tpl->getVariable('_produto_dia')->value->DS_PRODUTO_PRRC);?>
">
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>171,'altura'=>190,'imagem'=>$_smarty_tpl->getVariable('foto_completa_dia')->value),"imagem",true);?>
"></span>
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>164,'altura'=>182,'imagem'=>$_smarty_tpl->getVariable('foto_completa_dia')->value),"imagem",true);?>
" data-media="(max-width: 979px)"></span>
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>138,'altura'=>154,'imagem'=>$_smarty_tpl->getVariable('foto_completa_dia')->value),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>138,'altura'=>154,'imagem'=>$_smarty_tpl->getVariable('foto_completa_dia')->value),"imagem",true);?>
" data-media="(max-width: 479px)"></span>
                        <!-- for hd displays -->
                        <span data-width="138" data-height="154" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>276,'altura'=>308,'imagem'=>$_smarty_tpl->getVariable('foto_completa_dia')->value),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                        <span data-width="138" data-height="154" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>276,'altura'=>308,'imagem'=>$_smarty_tpl->getVariable('foto_completa_dia')->value),"imagem",true);?>
" data-media="(max-width: 767px)"></span>

                        <noscript>
                          <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>171,'altura'=>190,'imagem'=>$_smarty_tpl->getVariable('foto_completa_dia')->value),"imagem",true);?>
" alt="<?php echo utf8_decode($_smarty_tpl->getVariable('_produto_dia')->value->DS_PRODUTO_PRRC);?>
">
                        </noscript>
                    </span>
                  <?php }else{ ?>
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="<?php echo utf8_decode($_smarty_tpl->getVariable('_produto_dia')->value->DS_PRODUTO_PRRC);?>
">
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>171,'altura'=>190,'imagem'=>'not_found.jpg'),"imagem",true);?>
"></span>
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>164,'altura'=>182,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 979px)"></span>
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>138,'altura'=>154,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                        <span data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>138,'altura'=>154,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 479px)"></span>
                        <!-- for hd displays -->
                        <span data-width="138" data-height="154" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>276,'altura'=>308,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px)"></span>
                        <span data-width="138" data-height="154" data-src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>276,'altura'=>308,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-media="(max-width: 767px)"></span>

                        <noscript>
                          <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>171,'altura'=>190,'imagem'=>'not_found.jpg'),"imagem",true);?>
" alt="<?php echo utf8_decode($_smarty_tpl->getVariable('_produto_dia')->value->DS_PRODUTO_PRRC);?>
">
                        </noscript>
                    </span>
                  <?php }?>
                </a>
                <p class="product-title">
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp29=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp30=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp31=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp29,"idproduto"=>$_tmp30),$_tmp31,true);?>
"><?php echo utf8_decode($_smarty_tpl->getVariable('_produto_dia')->value->DS_PRODUTO_PRRC);?>
</a>
                </p>
                <p class="product-price">
                    <?php if ($_smarty_tpl->getVariable('_produto_dia')->value->VL_PROMO_PRRC!=0){?>
                        <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp32=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp33=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp34=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp32,"idproduto"=>$_tmp33),$_tmp34,true);?>
">R$ <?php echo number_format($_smarty_tpl->getVariable('_produto_dia')->value->VL_PROMO_PRRC,2,",",".");?>
</a>
                    <?php }else{ ?>
                        <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp35=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp36=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp37=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp35,"idproduto"=>$_tmp36),$_tmp37,true);?>
">R$ <?php echo number_format($_smarty_tpl->getVariable('_produto_dia')->value->VL_PRODUTO_PRRC,2,",",".");?>
</a>
                    <?php }?>
                </p>
            </li>
        </ul>
    </div>
</div>

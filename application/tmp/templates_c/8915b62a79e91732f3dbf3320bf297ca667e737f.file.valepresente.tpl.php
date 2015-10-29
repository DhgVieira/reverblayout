<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 19:34:55
         compiled from "/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/loja/valepresente.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1410330932562d4aff9706f4-68608683%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8915b62a79e91732f3dbf3320bf297ca667e737f' => 
    array (
      0 => '/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/loja/valepresente.tpl',
      1 => 1445396246,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1410330932562d4aff9706f4-68608683',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include '/Users/design/Reverbcity/site/reverbcity.com/library/Reverb/Library/Smarty/plugins/modifier.truncate.php';
?>
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
  <h1 class="rvb-title">Vale <span>presente</span></h1>
<section class="products">
  <div class="rvb-column left">
    <p>
      Nada mais chato do que presentear alguém e a pessoa ficar com aquela cara de "ah, legal",
      não é mesmo? Então deixe ela mesmo escolher, dando o vale-presente da Reverbcity!
    </p>
    <ul class="gift-cards-collection">
      <?php  $_smarty_tpl->tpl_vars['vale'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('vale_presentes')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vale']->key => $_smarty_tpl->tpl_vars['vale']->value){
?>
        <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('vale')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
        <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('vale')->value->DS_EXT_PRRC), null, null);?>
        <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
        
        <li class="gift-item">
            <?php if (file_exists("arquivos/uploads/produtos/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
             <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"produtos",'crop'=>2,'largura'=>189,'altura'=>168,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->getVariable('vale')->value->DS_PRODUTO_PRRC;?>
" width="189" height="168">
            <?php }else{ ?>
             <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>2,'largura'=>189,'altura'=>168,'imagem'=>'not_found.jpg'),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->getVariable('vale')->value->DS_PRODUTO_PRRC;?>
" width="189" height="168">
            <?php }?>
            <div class="gift-price">
              <span class="small">R$</span>
              <?php echo number_format($_smarty_tpl->getVariable('vale')->value->VL_PRODUTO_PRRC,2,",",".");?>

            </div>
            <div class="send-button">
                <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('vale')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp1=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idproduto"=>$_tmp1),'adicionarcarrinho',true);?>
" class="btn">Comprar</a>
            </div>
        </li>
      <?php }} ?>
    </ul>
  </div>

  <div class="rvb-column right">
    <div class="sidebar-ui">

      <div class="fundo-verde">
          <form id="form-login-reverbme" method="post" action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'login',true);?>
">
              <p class="legend">Reverbme</p>
              <div class="input-txt">
                  <input class="input-box" type="text"     name="email" placeholder="E-mail" required>
              </div>
              <div class="input-txt">
                  <input class="input-box" type="password" name="senha" placeholder="Senha" required>
              </div>
              <div class="send-button">
                  <button type="submit" class="btn">Login</button>
                  <a class="btn" href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'reverbme',true);?>
">Cadastre-se</a>
                  <label for="staylogged">
                      <input id="staylogged" type="checkbox"> Permanecer logado
                  </label>
              </div>
          </form>

          <ul class="reverb-people">
              <?php  $_smarty_tpl->tpl_vars['foto'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('fotos')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['foto']->key => $_smarty_tpl->tpl_vars['foto']->value){
?>
                  <?php $_smarty_tpl->tpl_vars["foto_people"] = new Smarty_variable(($_smarty_tpl->tpl_vars['foto']->value['NR_SEQ_FOTO_FORC']), null, null);?>
                  <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->tpl_vars['foto']->value['DS_EXT_FORC']), null, null);?>
                  <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_people')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
                  <li>
                    <?php if (file_exists("arquivos/uploads/people/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                      <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"people",'crop'=>1,'largura'=>45,'altura'=>45,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
"  alt="<?php echo $_smarty_tpl->getVariable('foto')->value->DS_NOME_FORC;?>
" width="45" height="45" />
                    <?php }else{ ?>
                      <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>45,'altura'=>45,'imagem'=>'not_found.jpg'),"imagem",true);?>
"  alt="<?php echo $_smarty_tpl->getVariable('foto')->value->DS_NOME_FORC;?>
" width="45" height="45" />
                    <?php }?>
                  </li>
              <?php }} ?>
          </ul>
      </div>

      <div class="blog-post clearfix">
          <?php $_smarty_tpl->tpl_vars["foto_blog"] = new Smarty_variable(($_smarty_tpl->getVariable('post')->value['NR_SEQ_BLOG_BLRC']), null, null);?>
          <?php $_smarty_tpl->tpl_vars["extensao_blog"] = new Smarty_variable(($_smarty_tpl->getVariable('post')->value['DS_EXT_BLRC']), null, null);?>
          <?php $_smarty_tpl->tpl_vars["foto_completa_blog"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_people')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
          <p class="cover-title ir">Blog</p>
          <a class="blog-image" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('post')->value->DS_TITULO_BLRC);?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('post')->value->NR_SEQ_BLOG_BLRC;?>
<?php $_tmp3=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp2,"idpost"=>$_tmp3),'post',true);?>
">
              <?php if (file_exists("arquivos/uploads/produtos/".($_smarty_tpl->getVariable('foto_completa_blog')->value))){?>
                <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"produtos",'crop'=>1,'largura'=>220,'altura'=>110,'imagem'=>$_smarty_tpl->getVariable('foto_completa_blog')->value),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->getVariable('post')->value->DS_TITULO_BLRC;?>
"/>
              <?php }else{ ?>
                <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>220,'altura'=>110,'imagem'=>'not_found.jpg'),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->getVariable('post')->value->DS_TITULO_BLRC;?>
"/>
              <?php }?>
          </a>
          <p class="blog-title">
              <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('post')->value->DS_TITULO_BLRC);?>
<?php $_tmp4=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('post')->value->NR_SEQ_BLOG_BLRC;?>
<?php $_tmp5=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp4,"idpost"=>$_tmp5),'post',true);?>
"><?php echo preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('post')->value->DS_TITULO_BLRC);?>
</a>
          </p>
          <p class="authoring">
            <!-- <span class="period">Tem que trazer o post aqui ás 14h</span> -->
            Por: <strong>Reverbcity</strong>
          </p>
          <p class="tiny-post"><?php echo utf8_decode(smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('post')->value->DS_TEXTO_BLRC),130,"...",true));?>
</p>
          <div class="full-post clearfix">
              <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('post')->value->DS_TITULO_BLRC);?>
<?php $_tmp6=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('post')->value->NR_SEQ_BLOG_BLRC;?>
<?php $_tmp7=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp6,"idpost"=>$_tmp7),'post',true);?>
">Ler post completo</a>
          </div>
      </div>
    </div>
  </div>
</section>

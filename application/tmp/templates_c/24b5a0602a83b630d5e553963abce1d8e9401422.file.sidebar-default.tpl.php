<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 16:59:20
         compiled from "/Users/design/Reverbcity/site/reverbcity.com/application/layouts/sidebar-default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1600681465562d2688993d36-45315278%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24b5a0602a83b630d5e553963abce1d8e9401422' => 
    array (
      0 => '/Users/design/Reverbcity/site/reverbcity.com/application/layouts/sidebar-default.tpl',
      1 => 1445396225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1600681465562d2688993d36-45315278',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/Users/design/Reverbcity/site/reverbcity.com/library/Reverb/Library/Smarty/plugins/modifier.date_format.php';
if (!is_callable('smarty_modifier_truncate')) include '/Users/design/Reverbcity/site/reverbcity.com/library/Reverb/Library/Smarty/plugins/modifier.truncate.php';
?><div class="sidebar-ui">
    
        <!-- <a href="#" class="chat-button ir">Atendimento Lojista On-Line</a> -->
        <div style="text-align:center;width:219px;">
</div>

    <div class="fundo-verde">
        <?php if ($_smarty_tpl->getVariable('_logado')->value==1){?>
        <div class="ja-logado">
           <a rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'reverbmedetalhe');?>
">Você já está logado!</br> Ir para o seu perfil.</a>
        </div>
        <?php }else{ ?>
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
                        <input id="staylogged" type="checkbox" name="manter_logado" value="1"> Permanecer logado
                    </label>
                </div>
            </form>
        <?php }?>

        <ul class="reverb-people">
            <?php  $_smarty_tpl->tpl_vars['foto'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('fotosme')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['foto']->key => $_smarty_tpl->tpl_vars['foto']->value){
?>
                <?php $_smarty_tpl->tpl_vars["foto_people"] = new Smarty_variable(($_smarty_tpl->tpl_vars['foto']->value['NR_SEQ_CADASTRO_CASO']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->tpl_vars['foto']->value['DS_EXT_CACH']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_people')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
                <li><img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"reverbme",'crop'=>1,'largura'=>45,'altura'=>45,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
"  alt="<?php echo $_smarty_tpl->tpl_vars['foto']->value['DS_NOME_CASO'];?>
" width="43" height="45" /></li>
            <?php }} ?>
        </ul>
    </div>

    <div class="blog-post clearfix">
        <?php $_smarty_tpl->tpl_vars["foto_blog"] = new Smarty_variable(($_smarty_tpl->getVariable('post')->value->NR_SEQ_BLOG_BLRC), null, null);?>
        <?php $_smarty_tpl->tpl_vars["extensao_blog"] = new Smarty_variable(($_smarty_tpl->getVariable('post')->value->DS_EXT_BLRC), null, null);?>
        <?php $_smarty_tpl->tpl_vars["foto_completa_blog"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_blog')->value).".".($_smarty_tpl->getVariable('extensao_blog')->value), null, null);?>
        <p class="cover-title ir">Blog</p>
        <a class="blog-image" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('post')->value->DS_TITULO_BLRC);?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('post')->value->NR_SEQ_BLOG_BLRC;?>
<?php $_tmp2=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp1,"idpost"=>$_tmp2),'post',true);?>
">
            <?php if (file_exists("arquivos/uploads/blog/".($_smarty_tpl->getVariable('foto_completa_blog')->value))){?>
                <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"blog",'crop'=>1,'largura'=>220,'altura'=>110,'imagem'=>$_smarty_tpl->getVariable('foto_completa_blog')->value),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->getVariable('post')->value->DS_TITULO_BLRC;?>
"/>
            <?php }else{ ?>
                <img src="..\arquivos\default\images\sem_foto_blog.jpg" alt="<?php echo $_smarty_tpl->getVariable('post')->value->DS_TITULO_BLRC;?>
" title="<?php echo $_smarty_tpl->getVariable('post')->value->DS_TITULO_BLRC;?>
" width="220" height="110"/>
            <?php }?>
        </a>
        <p class="blog-title 1">
            <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('post')->value->DS_TITULO_BLRC);?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('post')->value->NR_SEQ_BLOG_BLRC;?>
<?php $_tmp4=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp3,"idpost"=>$_tmp4),'post',true);?>
"><?php echo preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('post')->value->DS_TITULO_BLRC);?>
</a>
        </p>
        <p class="authoring">
          <span class="period"><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('post')->value->DT_PUBLICACAO_BLRC,'%Y/%m/%d');?>
 ás <?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('post')->value->DT_PUBLICACAO_BLRC,"%H:%M");?>
h</span>
          Por: <strong>Reverbcity</strong>
        </p>
        <p class="tiny-post"><?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('post')->value->DS_TEXTO_BLRC),130,"...",true);?>
</p>
        <div class="full-post clearfix">
            <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('post')->value->DS_TITULO_BLRC);?>
<?php $_tmp5=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('post')->value->NR_SEQ_BLOG_BLRC;?>
<?php $_tmp6=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp5,"idpost"=>$_tmp6),'post',true);?>
">Ler post completo</a>
        </div>
    </div>

    <p class="full-strip forum">Fórum</p>
    <ul class="collection-posts">
        <?php  $_smarty_tpl->tpl_vars['forum'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('foruns')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['forum']->key => $_smarty_tpl->tpl_vars['forum']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['forum']->key;
?>
            <?php if ($_smarty_tpl->getVariable('_logado')->value!=1&&$_smarty_tpl->tpl_vars['key']->value==16){?>
                <?php break 1?>
            <?php }?>
            <li class="post-item">
                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('forum')->value->DS_TOPICO_TOSO);?>
<?php $_tmp7=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('forum')->value->NR_SEQ_TOPICO_TOSO;?>
<?php $_tmp8=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp7,"idforum"=>$_tmp8),'detalheforum',true);?>
" class="post-link">
                    <span class="period"><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('forum')->value->DT_CADASTRO_TOSO,'%d/%m');?>
 | </span>
                    <span class="title"><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('forum')->value->DS_TOPICO_TOSO,25,"...",true);?>
</span>
                </a>
            </li>
        <?php }} ?>
    </ul>

    <div class="banners-sidebar cycle-slideshow"
         data-cycle-fx="fadeout"
         data-cycle-timeout="5000"
         data-cycle-slides="> a"
         data-cycle-log="false"
         data-cycle-pause-on-hover="true">
            <?php  $_smarty_tpl->tpl_vars['banner'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('banners')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['banner']->key => $_smarty_tpl->tpl_vars['banner']->value){
?>
            <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->tpl_vars['banner']->value['NR_SEQ_BANNER_BARC']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->tpl_vars['banner']->value['DS_EXT_BARC']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
              <a rel="nofollow" href="<?php echo $_smarty_tpl->tpl_vars['banner']->value['DS_LINK_BARC'];?>
">
                <?php if (file_exists("arquivos/uploads/banners/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                  <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"banners",'crop'=>1,'largura'=>220,'altura'=>280,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['banner']->value['DS_DESCRICAO_BARC'];?>
"
                  />
                <?php }else{ ?>
                  <img class="profile" src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>220,'altura'=>280,'imagem'=>'not_found.jpg'),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['banner']->value['DS_DESCRICAO_BARC'];?>
">
                <?php }?>
              </a>
          <?php }} ?>
    </div>
</div>



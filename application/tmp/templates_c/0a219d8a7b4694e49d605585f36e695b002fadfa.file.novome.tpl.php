<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 16:58:37
         compiled from "/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/reverbme/novome.tpl" */ ?>
<?php /*%%SmartyHeaderCode:209609281562d265d7f2082-19123891%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0a219d8a7b4694e49d605585f36e695b002fadfa' => 
    array (
      0 => '/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/reverbme/novome.tpl',
      1 => 1445396250,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '209609281562d265d7f2082-19123891',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include '/Users/design/Reverbcity/site/reverbcity.com/library/Reverb/Library/Smarty/plugins/modifier.truncate.php';
if (!is_callable('smarty_modifier_date_format')) include '/Users/design/Reverbcity/site/reverbcity.com/library/Reverb/Library/Smarty/plugins/modifier.date_format.php';
if (!is_callable('smarty_modifier_escape')) include '/Users/design/Reverbcity/site/reverbcity.com/library/Reverb/Library/Smarty/plugins/modifier.escape.php';
if (!is_callable('smarty_modifier_regex_replace')) include '/Users/design/Reverbcity/site/reverbcity.com/library/Reverb/Library/Smarty/plugins/modifier.regex_replace.php';
?><div class="banners-advertisement cycle-slideshow"
     data-cycle-fx="fadeout"
     data-cycle-timeout="5000"
     data-cycle-slides="> a"
     data-cycle-log="false"
     data-cycle-pause-on-hover="true">
    <?php  $_smarty_tpl->tpl_vars['banner'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('banners_topo')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['banner']->key => $_smarty_tpl->tpl_vars['banner']->value){
?>
        <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->tpl_vars['banner']->value['NR_SEQ_BANNER_BARC']), null, null);?>
        <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->tpl_vars['banner']->value['DS_EXT_BARC']), null, null);?>
        <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['banner']->value['DS_LINK_BARC'];?>
">
            <?php if (file_exists("arquivos/uploads/banners/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
              <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"banners",'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['banner']->value['DS_DESCRICAO_BARC'];?>
"/>
            <?php }else{ ?>
              <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['banner']->value['DS_DESCRICAO_BARC'];?>
"/>
            <?php }?>
        </a>
    <?php }} ?>
</div>

<h1 class="rvb-title">
    Reverb <span>Me</span>
</h1>

<div id="texto-reverbme">
    <p>Facebook? Instragram? Tinder? A Reverbcity também tem a sua rede social, o ReverbME. Todo mundo que faz um cadastro no site, automaticamente também já ganha um profile na nossa rede. Nele você pode adicionar novos amigos, conversar com a equipe da Reverb e receber informações de promos, lançamentos, sobre o seu pedido e também ter um blog todinho seu hospedado no nosso site.</p>
</div>

<div class="clearfix"></div>


<div class="rvb-column left">
    <div class="rvb-header-item">
        <p>
           <?php echo $_smarty_tpl->getVariable('_nome_usuario')->value;?>

        </p>
        <a href="#" class="rvb-content-button edit-info" style="right: 70px;">Alterar dados</a>
        <a href="#" class="rvb-content-button btn-indique md-trigger" style="background-color: #e85238;" data-modal="indicar-lightbox">Indique!</a>
    </div>
    <div class="rvb-content-item user clearfix">
        <div class="rvb-me-details user-image">
            <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('perfil')->value->NR_SEQ_CADASTRO_CASO), null, null);?>
            <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('perfil')->value->DS_EXT_CACH), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
            <!--<img class="profile" src="/reverbcity/arquivos/default/images/reverb-profile.gif" alt="Avatar do ReverbMe de TONY STRAUSS">-->
            <?php if (file_exists("arquivos/uploads/reverbme/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                <img class="profile" src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"reverbme",'crop'=>1,'largura'=>260,'altura'=>306,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),'imagem',true);?>
" width="130" height="152" alt="Avatar do ReverbMe de <?php echo $_smarty_tpl->getVariable('perfil')->value->DS_NOME_CASO;?>
">
            <?php }else{ ?>
                <img class="profile" src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>260,'altura'=>306,'imagem'=>'not_found_bkp.jpg'),'imagem',true);?>
" width="130" height="152" alt="Avatar Padrão Rerverbcity">
            <?php }?>

            <div class="btn-detail">
                Alterar imagem
                <form action="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('NR_SEQ_CADASTRO_CASO')->value;?>
<?php $_tmp1=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idperfil"=>$_tmp1),"alterarfoto",true);?>
" method="post" enctype="multipart/form-data">
                    <input type="file" class="file-field" name="imagem_perfil" id="imagem_perfil">
                </form>
            </div>
            <a href="#" class="btn-detail md-trigger modal-info" data-modal="lightbox-alterar-dados">Dados cadastrais</a>
        </div>
        <div class="rvb-me-details user-profile">
            <form action="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('perfil')->value->NR_SEQ_CADASTRO_CASO;?>
<?php $_tmp2=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idperfil"=>$_tmp2),'alterardados',true);?>
" method="post" id="reverbme-profile">
                <div class="lines">
                    <label for="nome" class="legend-user">Nome:</label> <input type="text" class="input-user" id="nome" value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_NOME_CASO;?>
" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="ocupacao" class="legend-user">Ocupação:</label> <input type="text" class="input-user" id="ocupacao" value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_OCUPACAO_CACH;?>
" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="idade" class="legend-user">Idade:</label> <input type="text" class="input-user" id="idade" value="<?php echo $_smarty_tpl->getVariable('idade')->value;?>
" data-readable="true" readonly disabled>
                </div>
                <div class="lines">
                    <label for="cidade" class="legend-user">Cidade:</label> <input type="text" class="input-user" id="cidade" value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_CIDADE_CASO;?>
" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="bandas" class="legend-user">Bandas:</label> <input type="text" class="input-user" id="bandas" value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_PLAYLIST_CACH;?>
" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="twitter" class="legend-user">Twitter:</label> <input type="text" class="input-user" id="twitter" value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_TWITTER_CACH;?>
" data-readable="true" readonly>
                </div>
                <div class="lines">
                    <label for="facebook" class="legend-user">Facebook:</label> <input type="text" class="input-user" id="facebook" value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_FACEBOOK_CACH;?>
" data-readable="true" readonly>
                </div>
            </form>
        </div>
    </div>
    <div class="rvb-footer-item">
        <p>
            Pontos de experiência
        </p>
        <div class="xp-bar">
            <div class="current-value">
                <?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('experiencia_user')->value,4,'',true);?>
%
            </div>
            <div class="loading-bar">
                <div class="progress" data-value="<?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('experiencia_user')->value,4,true);?>
%"></div>
            </div>
        </div>
    </div>
    <div class="rvb-content-item user-and-order-details">
        <div class="rvb-my-orders">
            <span>Minhas compras:</span> <a href="#" class="btn-detail">Consultar</a>
            <div class="reverb-flyout">
                <div class="flyout-header"></div>
                <div class="flyout-container">
                    <p class="flyout-title">
                        Minhas compras:
                    </p>
                    <ul class="flyout-list">
                        <?php  $_smarty_tpl->tpl_vars['cesta'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('cestas')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['cesta']->key => $_smarty_tpl->tpl_vars['cesta']->value){
?>
                            <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('cesta')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
                            <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('cesta')->value->DS_EXT_PRRC), null, null);?>
                            <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
                            <li class="flyout-item">

                                <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"produtos",'crop'=>1,'largura'=>38,'altura'=>34,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->getVariable('cesta')->value->DS_PRODUTO_PRRC;?>
" class="thumb"> <span class="order-product-name"><?php echo $_smarty_tpl->getVariable('cesta')->value->DS_PRODUTO_PRRC;?>
</span> <span class="order-date"><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('cesta')->value->DT_INCLUSAO_CESO,"%d/%m/%Y");?>
</span>
                            </li>
                        <?php }} ?>

                    </ul><a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),"minhascompras",true);?>
" class="flyout-button see-more">Ver mais</a>
                </div>
                <div class="flyout-footer"></div>
            </div>
        </div>
        <div class="rvb-privacy">
            <span>Privacidade perfil:</span>
                <?php if ($_smarty_tpl->getVariable('perfil')->value->DS_PRIVADO_CASO==1){?>
                    <a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array("tipo"=>"1"),"alterarprivacidade",true);?>
" class="btn-detail" title="Tornar o perfil visível somente para os amigos">Amigos</a>
                <?php }else{ ?>
                    <a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array("tipo"=>"1"),"alterarprivacidade",true);?>
" class="btn-detail inactive" title="Tornar o perfil visível somente para os amigos">Amigos</a>
                <?php }?>
                <?php if ($_smarty_tpl->getVariable('perfil')->value->DS_PRIVADO_CASO==0){?>
                    <a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array("tipo"=>"0"),"alterarprivacidade",true);?>
" class="btn-detail" title="Tornar o perfil visível para todos">Público</a>
                <?php }else{ ?>
                    <a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array("tipo"=>"0"),"alterarprivacidade",true);?>
" class="btn-detail inactive" title="Tornar o perfil visível para todos">Público</a>
                <?php }?>
        </div>
        <div class="rvb-my-social-share">
            <span>Redes sociais:</span>
            <ul class="my-social-networks">
                <?php if ($_smarty_tpl->getVariable('perfil')->value->DS_TWITTER_CACH!=''){?>
                    <li class="social-network-item">
                        <a href="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_TWITTER_CACH;?>
" class="ir icon twitter" target="_blank">Twitter</a>
                    </li>
                <?php }?>
                <?php if ($_smarty_tpl->getVariable('perfil')->value->DS_FACEBOOK_CACH!=''){?>
                    <li class="social-network-item">
                        <a href="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_FACEBOOK_CACH;?>
" class="ir icon facebook" target="_blank">Facebook</a>
                    </li>
                <?php }?>
                <?php if ($_smarty_tpl->getVariable('perfil')->value->DS_FACEBOOK_CACH!=''){?>
                    <li class="social-network-item">
                        <a href="#" class="ir icon tumblr" target="_blank">Tumblr</a>
                    </li>
                <?php }?>
                <li class="social-network-item">
                    <a href="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_INSTAGRAM_CASO;?>
" class="ir icon instagram" target="_blank">Instagram</a>
                </li>
                <li class="social-network-item">
                    <a href="#" class="ir icon pinterest" target="_blank">Pinterest</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="rvb-header-item">
        <h2>
            Galeria de Fotos
        </h2>
        <a href="#" class="md-trigger rvb-content-button insert-photo" data-modal="people-lightbox">Incluir fotos</a>
    </div>
    <div class="rvb-content-item clearfix">
        <p class="centered">
            <?php if (count($_smarty_tpl->getVariable('fotos')->value)<=0){?>
                Mostre que você fica ainda mais gatinha(o)<br>
                quando usa Reverbcity. Mande suas fotos para nossa galeria!
            <?php }else{ ?>
            </p>
            <ul class="rvb-list rvb-list-of-photos clearfix" id="gallery-list">
                <?php  $_smarty_tpl->tpl_vars['me'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('fotos')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['me']->key => $_smarty_tpl->tpl_vars['me']->value){
?>
                    <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('me')->value->NR_SEQ_FOTO_FORC), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('me')->value->DS_EXT_FORC), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
                    <li class="rvb-photo-item">
                        <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('me')->value->DS_NOME_FORC);?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('me')->value->NR_SEQ_FOTO_FORC;?>
<?php $_tmp4=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("nome"=>$_tmp3,"idfoto"=>$_tmp4),'peopledetalhe',true);?>
" class="photo-thumb">
                            <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"people",'crop'=>1,'largura'=>140,'altura'=>110,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->getVariable('me')->value->DS_NOME_FORC;?>
">
                        </a>
                        <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('me')->value->DS_NOME_FORC);?>
<?php $_tmp5=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('me')->value->NR_SEQ_FOTO_FORC;?>
<?php $_tmp6=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("nome"=>$_tmp5,"idfoto"=>$_tmp6),'peopledetalhe',true);?>
" class="photo-link"><?php echo $_smarty_tpl->getVariable('me')->value->DS_NOME_FORC;?>
</a>
                        <span class="comments">Comentários: <?php echo $_smarty_tpl->getVariable('me')->value->total_coments;?>
</span>
                        <span class="views">Views: <?php echo $_smarty_tpl->getVariable('me')->value->NR_VIEWS_FORC;?>
</span>
                        <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('me')->value->NR_SEQ_FOTO_FORC;?>
<?php $_tmp7=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idfoto"=>$_tmp7),"removerfoto",true);?>
" data-foto-id="<?php echo $_smarty_tpl->getVariable('me')->value->NR_SEQ_FOTO_FORC;?>
" class="me-remove" title="Excluir foto">Excluir</a>
                        <ul class="social-share-small">
                            <li class="social-item">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('me')->value->DS_NOME_FORC);?>
<?php $_tmp8=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('me')->value->NR_SEQ_FOTO_FORC;?>
<?php $_tmp9=ob_get_clean();?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('this')->value->url(array("nome"=>$_tmp8,"idfoto"=>$_tmp9),'peopledetalhe',true),'url');?>
" class="social-link ir facebook" target="_blank">Facebook</a>
                            </li>
                            <li class="social-item">
                                <a href="http://twitter.com/home?status=<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('me')->value->DS_NOME_FORC);?>
<?php $_tmp10=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('me')->value->NR_SEQ_FOTO_FORC;?>
<?php $_tmp11=ob_get_clean();?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('this')->value->url(array("nome"=>$_tmp10,"idfoto"=>$_tmp11),'peopledetalhe',true),'url');?>
" class="social-link ir twitter" target="_blank">Twitter</a>
                            </li>
                            <li class="social-item">
                                <a href="http://tumblr.com/share?s=&v=3&t=<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('me')->value->DS_NOME_FORC);?>
<?php $_tmp12=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('me')->value->NR_SEQ_FOTO_FORC;?>
<?php $_tmp13=ob_get_clean();?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('this')->value->url(array("nome"=>$_tmp12,"idfoto"=>$_tmp13),'peopledetalhe',true),'url');?>
" class="social-link ir tumblr" target="_blank">Tumblr</a>
                            </li>
                            <li class="social-item">
                                <a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>
                            </li>
                        </ul>
                    </li>
                <?php }} ?>
            </ul>
        <?php }?>
        <div id="gallery-pagination" data-lastpage="<?php echo $_smarty_tpl->getVariable('paginas_fotos')->value;?>
" data-size="9">
            <ul class="pagination">
                <?php if ($_smarty_tpl->getVariable('paginas_fotos')->value<=1){?>

                <?php }elseif($_smarty_tpl->getVariable('paginas_fotos')->value>8){?>

                    <li>
                        <a href="#" class="prev disabled">◀</a>
                    </li>
                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<=5){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=5; $_smarty_tpl->tpl_vars['i']->value++){
?>
                        <?php if ($_smarty_tpl->tpl_vars['i']->value==1){?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page current"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }else{ ?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }?>
                    <?php }} ?>
                    <li>
                        <a class="dots">...</a>
                    </li>
                    <li>
                        <a href="#" data-page="<?php echo $_smarty_tpl->getVariable('paginas_fotos')->value;?>
" class="page"><?php echo $_smarty_tpl->getVariable('paginas_fotos')->value;?>
</a>
                    </li>
                    <li>
                        <a href="#" class="next">▶</a>
                    </li>
                <?php }elseif($_smarty_tpl->getVariable('paginas_fotos')->value<=9){?>

                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<=$_smarty_tpl->getVariable('paginas_fotos')->value){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=$_smarty_tpl->getVariable('paginas_fotos')->value; $_smarty_tpl->tpl_vars['i']->value++){
?>

                        <?php if ($_smarty_tpl->tpl_vars['i']->value==1){?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page current"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }else{ ?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }?>

                    <?php }} ?>

                <?php }?>
            </ul>
        </div>
    </div>
    <div class="rvb-header-item">
        <h2>
            Top Music Videos
        </h2><a href="#" class="rvb-content-button md-trigger" data-modal="insert-url-video-lightbox">Incluir vídeo</a>
    </div>
    <div class="rvb-content-item clearfix">
        <ul class="rvb-list rvb-list-of-videos" id="videos-list">
            <?php  $_smarty_tpl->tpl_vars['video'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('videos')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['video']->key => $_smarty_tpl->tpl_vars['video']->value){
?>
            <?php $_smarty_tpl->tpl_vars['img_youtube'] = new Smarty_variable(explode("/",$_smarty_tpl->getVariable('video')->value->DS_YOUTUBE_VIRC), null, null);?>
            <?php $_smarty_tpl->tpl_vars['idyoutube'] = new Smarty_variable(explode('&',$_smarty_tpl->getVariable('img_youtube')->value[4]), null, null);?>

            <?php if ($_smarty_tpl->getVariable('idyoutube')->value[0]!=''){?>


                <li class="rvb-video-item">
                    <a href="<?php echo $_smarty_tpl->getVariable('video')->value->DS_YOUTUBE_VIRC;?>
" class="video-thumb">
                        <img src="http://img.youtube.com/vi/<?php echo $_smarty_tpl->getVariable('idyoutube')->value[0];?>
/hqdefault.jpg" alt="<?php echo $_smarty_tpl->getVariable('video')->value->DS_NOME_VIRC;?>
">
                    </a>
                    <a href="<?php echo $_smarty_tpl->getVariable('video')->value->DS_YOUTUBE_VIRC;?>
" title="<?php echo $_smarty_tpl->getVariable('video')->value->DS_NOME_VIRC;?>
" class="video-link" target="_blank"><?php echo $_smarty_tpl->getVariable('video')->value->DS_NOME_VIRC;?>
</a>
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('video')->value->NR_SEQ_VIDEO_VIRC;?>
<?php $_tmp14=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idvideo"=>$_tmp14),"removervideo",true);?>
" data-video-id="<?php echo $_smarty_tpl->getVariable('video')->value->NR_SEQ_VIDEO_VIRC;?>
" class="me-remove" title="Excluir vídeo">Excluir</a>
                    <ul class="social-share-small">
                        <li class="social-item">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('video')->value->DS_YOUTUBE_VIRC,'url');?>
" class="social-link ir facebook" target="_blank">Facebook</a>
                        </li>
                        <li class="social-item">
                            <a href="http://twitter.com/home?status=<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('video')->value->DS_YOUTUBE_VIRC,'url');?>
" class="social-link ir twitter" target="_blank">Twitter</a>
                        </li>
                        <li class="social-item">
                            <a href="http://tumblr.com/share?s=&v=3&t=<?php echo smarty_modifier_escape(smarty_modifier_escape($_smarty_tpl->getVariable('video')->value->DS_YOUTUBE_VIRC,'url'),'url');?>
" class="social-link ir tumblr" target="_blank">Tumblr</a>
                        </li>
                        <li class="social-item">
                            <a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>
                        </li>
                    </ul>
                </li>
            <?php }else{ ?>
            <?php $_smarty_tpl->tpl_vars['idyoutube2'] = new Smarty_variable(explode("v=",$_smarty_tpl->getVariable('img_youtube')->value[3]), null, null);?>
                <li class="rvb-video-item">
                    <a href="<?php echo $_smarty_tpl->getVariable('video')->value->DS_YOUTUBE_VIRC;?>
" class="video-thumb">
                        <img src="http://img.youtube.com/vi/<?php echo $_smarty_tpl->getVariable('idyoutube2')->value[1];?>
/hqdefault.jpg" alt="<?php echo $_smarty_tpl->getVariable('video')->value->DS_NOME_VIRC;?>
">
                    </a>
                    <a href="<?php echo $_smarty_tpl->getVariable('video')->value->DS_YOUTUBE_VIRC;?>
" title="<?php echo $_smarty_tpl->getVariable('video')->value->DS_NOME_VIRC;?>
" class="video-link" target="_blank"><?php echo $_smarty_tpl->getVariable('video')->value->DS_NOME_VIRC;?>
</a>
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('video')->value->NR_SEQ_VIDEO_VIRC;?>
<?php $_tmp15=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idvideo"=>$_tmp15),"removervideo",true);?>
" data-video-id="<?php echo $_smarty_tpl->getVariable('video')->value->NR_SEQ_VIDEO_VIRC;?>
" class="me-remove" title="Excluir vídeo">Excluir</a>
                    <ul class="social-share-small">
                        <li class="social-item">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('video')->value->DS_YOUTUBE_VIRC,'url');?>
" class="social-link ir facebook" target="_blank">Facebook</a>
                        </li>
                        <li class="social-item">
                            <a href="http://twitter.com/home?status=<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('video')->value->DS_YOUTUBE_VIRC,'url');?>
" class="social-link ir twitter" target="_blank">Twitter</a>
                        </li>
                        <li class="social-item">
                            <a href="http://tumblr.com/share?s=&v=3&t=<?php echo smarty_modifier_escape(smarty_modifier_escape($_smarty_tpl->getVariable('video')->value->DS_YOUTUBE_VIRC,'url'),'url');?>
" class="social-link ir tumblr" target="_blank">Tumblr</a>
                        </li>
                        <li class="social-item">
                            <a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>
                        </li>
                    </ul>
                </li>
            <?php }?>
            <?php }} ?>
        </ul>
        <div id="videos-pagination" data-lastpage="<?php echo $_smarty_tpl->getVariable('paginas_videos')->value;?>
" data-size="4">
            <ul class="pagination">
                <?php if ($_smarty_tpl->getVariable('paginas_videos')->value<=1){?>

                <?php }elseif($_smarty_tpl->getVariable('paginas_videos')->value>8){?>

                    <li>
                        <a href="#" class="prev disabled">◀</a>
                    </li>
                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<=5){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=5; $_smarty_tpl->tpl_vars['i']->value++){
?>
                        <?php if ($_smarty_tpl->tpl_vars['i']->value==1){?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page current"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }else{ ?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }?>
                    <?php }} ?>
                    <li>
                        <a class="prev">...</a>
                    </li>
                    <li>
                        <a href="#" data-page="<?php echo $_smarty_tpl->getVariable('paginas_videos')->value;?>
" class="page"><?php echo $_smarty_tpl->getVariable('paginas_videos')->value;?>
</a>
                    </li>
                    <li>
                        <a href="#" class="next">▶</a>
                    </li>
                <?php }elseif($_smarty_tpl->getVariable('paginas_videos')->value<=9){?>

                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<=$_smarty_tpl->getVariable('paginas_videos')->value){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=$_smarty_tpl->getVariable('paginas_videos')->value; $_smarty_tpl->tpl_vars['i']->value++){
?>

                        <?php if ($_smarty_tpl->tpl_vars['i']->value==1){?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page current"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }else{ ?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }?>

                    <?php }} ?>

                <?php }?>
            </ul>
        </div>
    </div>
    <div class="rvb-header-item">
        <h2>
            Blog
        </h2>
    </div>
    <div class="rvb-content-item clearfix">
        <form action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),"publicarblog",true);?>
" method="post" enctype="multipart/form-data">
          <input name="titulo" type="text" class="title-of-post" placeholder="Insira o título do seu post">
          <div class="blogme-img">
              <span>Escolha a imagem</span>
              <input type="file" name="imagem" />
          </div>
          <textarea name="post" id="full-post" cols="30" rows="10" class="message-box full-post"></textarea>
          <button type="submit" class="rvb-send-button publish">Publicar</button>
        </form>
    </div>
    <div class="rvb-header-item">
        <h2>
            Últimos posts
        </h2>
    </div>
    <div class="rvb-content-item clearfix">

        <div class="rvb-list rvb-list-of-posts" id="latest-posts-list">
            <?php  $_smarty_tpl->tpl_vars['post'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('posts')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['post']->key => $_smarty_tpl->tpl_vars['post']->value){
?>
                <div class="latest-post">
                        <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('post')->value->idme_blog;?>
<?php $_tmp16=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idpost"=>$_tmp16),"blogme",true);?>
" class="post-thumb">
                            <?php if (file_exists("arquivos/upload/blogme/".($_smarty_tpl->getVariable('imagem_path')->value))){?>
                                <img src="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('post')->value->imagem_path;?>
<?php $_tmp17=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"blogme",'crop'=>1,'largura'=>120,'altura'=>143,'imagem'=>$_tmp17),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->getVariable('post')->value->titulo;?>
"/>
                            <?php }else{ ?>
                                <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>120,'altura'=>143,'imagem'=>'not_found.jpg'),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->getVariable('post')->value->titulo;?>
"/>
                            <?php }?>
                        </a>
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('post')->value->idme_blog;?>
<?php $_tmp18=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idpost"=>$_tmp18),"blogme",true);?>
" class="post-title"><?php echo $_smarty_tpl->getVariable('post')->value->titulo;?>
</a>
                    <p class="post-date">
                        <?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('post')->value->data_publicacao,"%d/%m/%Y");?>
 ás  <?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('post')->value->data_publicacao,"%H:%M");?>
 Por: <span class="post-author"><?php echo $_smarty_tpl->getVariable('_nome_usuario')->value;?>
</span>
                    </p>
                    <p class="post-tiny-description"></p>
                    <p class="post-text-truncate">
                        <?php echo smarty_modifier_truncate(smarty_modifier_regex_replace($_smarty_tpl->getVariable('post')->value->post,"/\<[^>]*\>/"," "),230,"...",true);?>

                    </p>
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('post')->value->idme_blog;?>
<?php $_tmp19=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idpost"=>$_tmp19),"blogme",true);?>
" class="button comments">0 comentários</a>
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('post')->value->idme_blog;?>
<?php $_tmp20=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idblog"=>$_tmp20),"removerblog",true);?>
" data-post-id="<?php echo $_smarty_tpl->getVariable('post')->value->idme_blog;?>
" class="me-remove post-remove" title="Remover post">Excluir</a>
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('post')->value->idme_blog;?>
<?php $_tmp21=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idpost"=>$_tmp21),"blogme",true);?>
" class="button read-post">Ler post completo | </a>
                </div>
            <?php }} ?>
        </div>
        <div id="latest-posts-pagination" data-lastpage="<?php echo $_smarty_tpl->getVariable('paginas_post')->value;?>
" data-size="3">
            <ul class="pagination">
                <?php if ($_smarty_tpl->getVariable('paginas_post')->value<=1){?>

                <?php }elseif($_smarty_tpl->getVariable('paginas_post')->value>8){?>

                    <li>
                        <a href="#" class="prev disabled">◀</a>
                    </li>
                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<=5){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=5; $_smarty_tpl->tpl_vars['i']->value++){
?>
                        <?php if ($_smarty_tpl->tpl_vars['i']->value==1){?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page current"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }else{ ?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }?>
                    <?php }} ?>
                    <li>
                        <a class="prev">...</a>
                    </li>
                    <li>
                        <a href="#" data-page="<?php echo $_smarty_tpl->getVariable('paginas_post')->value;?>
" class="page"><?php echo $_smarty_tpl->getVariable('paginas_post')->value;?>
</a>
                    </li>
                    <li>
                        <a href="#" class="next">▶</a>
                    </li>
                <?php }elseif($_smarty_tpl->getVariable('paginas_post')->value<=9){?>

                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<=$_smarty_tpl->getVariable('paginas_post')->value){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=$_smarty_tpl->getVariable('paginas_post')->value; $_smarty_tpl->tpl_vars['i']->value++){
?>

                        <?php if ($_smarty_tpl->tpl_vars['i']->value==1){?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page current"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }else{ ?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }?>

                    <?php }} ?>

                <?php }?>
            </ul>
        </div>
    </div><a href="#" class="rvb-button back">Voltar</a>
</div>
<div class="rvb-column right">
    <form method="POST">
        <div class="rvb-header-item" id="rvb-header-friends">
            <h2>
                Amigos
            </h2>
            <input type="text" id="searchFriendInput" class="search-friend" placeholder="Digite o nome para buscar" name="filter">
            <button type="submit" id="searchFriendButton" class="rvb-content-button">Buscar</button>
        </div>
    </form>
    <div class="rvb-content-item friends">
        <ul class="rvb-list rvb-list-of-friends" id="friends-list">
            <?php  $_smarty_tpl->tpl_vars["amigo"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('amigos')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["amigo"]->key => $_smarty_tpl->tpl_vars["amigo"]->value){
?>
                <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('amigo')->value['NR_SEQ_AMIGO_FRRC']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('amigo')->value['DS_EXT_CACH']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
                <li>
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('amigo')->value['DS_NOME_CASO']);?>
<?php $_tmp22=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('amigo')->value['NR_SEQ_AMIGO_FRRC'];?>
<?php $_tmp23=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("nome"=>$_tmp22,"idperfil"=>$_tmp23),"perfil",true);?>
" class="profile-thumb">
                        <?php if (file_exists("arquivos/uploads/reverbme/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                            <?php if ($_smarty_tpl->getVariable('aniversariante')->value==1){?>
                                <div class="bday"></div>
                            <?php }?>
                            <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"reverbme",'crop'=>1,'largura'=>103,'altura'=>90,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),'imagem',true);?>
">
                        <?php }else{ ?>
                            <?php if ($_smarty_tpl->getVariable('aniversariante')->value==1){?>
                                <div class="bday"></div>
                            <?php }?>
                            <img src="<?php echo $_smarty_tpl->getVariable('basePath')->value;?>
/arquivos/default/images/sem_foto.jpg" alt="<?php echo $_smarty_tpl->getVariable('amigo')->value['DS_NOME_CASO'];?>
" title="<?php echo $_smarty_tpl->getVariable('amigo')->value['DS_NOME_CASO'];?>
"/>
                        <?php }?>
                    </a>
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('amigo')->value['DS_NOME_CASO']);?>
<?php $_tmp24=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('amigo')->value['NR_SEQ_AMIGO_FRRC'];?>
<?php $_tmp25=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("nome"=>$_tmp24,"idperfil"=>$_tmp25),"perfil",true);?>
" title="Visualizar perfil de <?php echo $_smarty_tpl->getVariable('amigo')->value->NR_SEQ_AMIGO_FRRC;?>
" class="profile-link"><?php echo $_smarty_tpl->getVariable('amigo')->value['DS_NOME_CASO'];?>
</a>
                </li>
            <?php }} ?>
        </ul>
        <div id="friends-pagination" data-lastpage="<?php echo $_smarty_tpl->getVariable('paginas_amigos')->value;?>
" data-size="8">
            <ul class="pagination">
                <?php if ($_smarty_tpl->getVariable('paginas_amigos')->value<=1){?>

                <?php }elseif($_smarty_tpl->getVariable('paginas_amigos')->value>8){?>

                    <li>
                        <a href="#" class="prev disabled">◀</a>
                    </li>
                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<=5){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=5; $_smarty_tpl->tpl_vars['i']->value++){
?>
                        <?php if ($_smarty_tpl->tpl_vars['i']->value==1){?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page current"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }else{ ?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }?>
                    <?php }} ?>
                    <li>
                        <a class="prev">...</a>
                    </li>
                    <li>
                        <a href="#" data-page="<?php echo $_smarty_tpl->getVariable('paginas_amigos')->value;?>
" class="page"><?php echo $_smarty_tpl->getVariable('paginas_amigos')->value;?>
</a>
                    </li>
                    <li>
                        <a href="#" class="next">▶</a>
                    </li>
                <?php }elseif($_smarty_tpl->getVariable('paginas_amigos')->value<=9){?>

                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<=$_smarty_tpl->getVariable('paginas_amigos')->value){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=$_smarty_tpl->getVariable('paginas_amigos')->value; $_smarty_tpl->tpl_vars['i']->value++){
?>

                        <?php if ($_smarty_tpl->tpl_vars['i']->value==1){?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page current"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }else{ ?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }?>

                    <?php }} ?>

                <?php }?>
            </ul>
        </div>
    </div>
    <form method="post" action="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('NR_SEQ_CADASTRO_CASO')->value;?>
<?php $_tmp26=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idperfil"=>$_tmp26),"enviarmensagem",true);?>
">
        <div class="rvb-header-item">
            <h2>
                Mensagens
            </h2><label class="label-checkbox" for="sendByMail">
            <input type="checkbox" name="sendByMail" id="sendByMail" value="1"> Avisar por e-mail</label>
        </div>
        <div class="rvb-content-item read-scraps clearfix">
            <p class="user-login-name">
               <?php echo $_smarty_tpl->getVariable('_nome_usuario')->value;?>

            </p>
            <textarea class="message-box mb" name="reverbme-mensagem" placeholder="Escreva aqui sua mensagem..."></textarea>

            <label class="label-checkbox" for="isPrivate">
                <input type="checkbox" name="isPrivate" id="isPrivate" value="1"> Mensagem privada
            </label>

            <input type="submit" class="rvb-send-button" value="Enviar">

            <div class="clearfix"></div>

            <div class="horizontal-line"></div>

            <div class="rvb-list list-of-scraps" id="scraps-list">
                <?php  $_smarty_tpl->tpl_vars['recado'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('recados')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['recado']->key => $_smarty_tpl->tpl_vars['recado']->value){
?>
                    <div class="rvb-comment-box">
                        <!-- <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('recado')->value->NR_SEQ_SCRAP_SBRC;?>
<?php $_tmp27=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idrecado"=>$_tmp27),"deletarrecado",true);?>
" data-message-id="<?php echo $_smarty_tpl->getVariable('recado')->value->NR_SEQ_SCRAP_SBRC;?>
" class="md-close ir" title="Remover mensagem">Excluir</a> -->
                        <p class="rvb-comment-author-name">
                            <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('recado')->value->DS_NOME_CASO);?>
<?php $_tmp28=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('recado')->value->NR_SEQ_CADASTRO_CASO;?>
<?php $_tmp29=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("nome"=>$_tmp28,"idperfil"=>$_tmp29),"perfil",true);?>
">
                                <?php echo $_smarty_tpl->getVariable('recado')->value->DS_NOME_CASO;?>

                            </a>
                        </p>
                        <p class="rvb-comment-date">
                            <?php $_smarty_tpl->tpl_vars["datarecado"] = new Smarty_variable(($_smarty_tpl->getVariable('recado')->value->DT_POST_SBRC).(" -3 hour"), null, null);?>
                            <?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('datarecado')->value,"%Y-%m-%d %H:%M:%S");?>

                        </p>
                        <div class="rvb-comment-message">
                            <?php echo $_smarty_tpl->getVariable('recado')->value->DS_POST_SBRC;?>

                        </div>
                        <div class="rvb-comment-buttons">
                            <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('recado')->value->DS_NOME_CASO);?>
<?php $_tmp30=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('recado')->value->NR_SEQ_CADASTRO_CASO;?>
<?php $_tmp31=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("nome"=>$_tmp30,"idperfil"=>$_tmp31),"perfil",true);?>
" class="button">Responder |</a>
                            <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('recado')->value->NR_SEQ_SCRAP_SBRC;?>
<?php $_tmp32=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idrecado"=>$_tmp32),"deletarrecado",true);?>
" class="button">Excluir</a>
                        </div>
                    </div>
                <?php }} ?>
            </div>
            <div id="scraps-pagination" data-lastpage="<?php echo $_smarty_tpl->getVariable('paginas_recados')->value;?>
" data-size="5">
                 <ul class="pagination">
                        <?php if ($_smarty_tpl->getVariable('paginas_recados')->value<=1){?>

                        <?php }elseif($_smarty_tpl->getVariable('paginas_recados')->value>8){?>

                            <li>
                                <a href="#" class="prev disabled">◀</a>
                            </li>
                            <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<=5){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=5; $_smarty_tpl->tpl_vars['i']->value++){
?>
                                <?php if ($_smarty_tpl->tpl_vars['i']->value==1){?>
                                    <li>
                                        <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page current"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                                    </li>
                                <?php }else{ ?>
                                    <li>
                                        <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                                    </li>
                                <?php }?>
                            <?php }} ?>
                            <li>
                                <a class="prev">...</a>
                            </li>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->getVariable('paginas_recados')->value;?>
" class="page"><?php echo $_smarty_tpl->getVariable('paginas_recados')->value;?>
</a>
                            </li>
                            <li>
                                <a href="#" class="next">▶</a>
                            </li>
                        <?php }elseif($_smarty_tpl->getVariable('paginas_recados')->value<=9){?>

                            <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<=$_smarty_tpl->getVariable('paginas_recados')->value){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=$_smarty_tpl->getVariable('paginas_recados')->value; $_smarty_tpl->tpl_vars['i']->value++){
?>

                                <?php if ($_smarty_tpl->tpl_vars['i']->value==1){?>
                                    <li>
                                        <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page current"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                                    </li>
                                <?php }else{ ?>
                                    <li>
                                        <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                                    </li>
                                <?php }?>

                            <?php }} ?>

                        <?php }?>
                    </ul>
            </div>
        </div>
    </form>
    <div class="rvb-header-item">
        <h2>
            Wishlist Reverbcity
        </h2>
    </div>
    <div class="rvb-content-item clearfix">
        <?php if (count($_smarty_tpl->getVariable('wishlists')->value)<=0){?>
            <p class="centered">
                Todo mundo tem desejos e você não precisa<br>
                esconder os seus, coloque sua peça desejada no "whishlist".
            </p>
        <?php }else{ ?>
            <ul class="rvb-list rvb-list-of-wishlist clearfix" id="wishlist-list">
                <?php  $_smarty_tpl->tpl_vars['wish'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('wishlists')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['wish']->key => $_smarty_tpl->tpl_vars['wish']->value){
?>
                    <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('wish')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('wish')->value->DS_EXT_PRRC), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>

                    <?php $_smarty_tpl->tpl_vars["fotos"] = new Smarty_variable($_smarty_tpl->getVariable('this')->value->fotoproduto($_smarty_tpl->getVariable('wish')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['NR_SEQ_FOTO_FORC']), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['DS_EXT_FORC']), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
                <li class="rvb-photo-item">
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('wish')->value->DS_PRODUTO_PRRC);?>
<?php $_tmp33=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('wish')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp34=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp33,"idproduto"=>$_tmp34),"produto",true);?>
" class="photo-thumb">
                        <?php if (file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                            <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>140,'altura'=>110,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->getVariable('wish')->value->DS_PRODUTO_PRRC;?>
"></a>
                        <?php }else{ ?>
                            <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>140,'altura'=>110,'imagem'=>'not_found.jpg'),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->getVariable('wish')->value->DS_PRODUTO_PRRC;?>
"></a>
                        <?php }?>
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('wish')->value->DS_PRODUTO_PRRC);?>
<?php $_tmp35=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('wish')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp36=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp35,"idproduto"=>$_tmp36),"produto",true);?>
" class="photo-link">
                        <?php echo $_smarty_tpl->getVariable('wish')->value->DS_PRODUTO_PRRC;?>

                    </a>
                    <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('wish')->value->NR_SEQ_WISHLIST_WLRC;?>
<?php $_tmp37=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idwishlist"=>$_tmp37),"removerwishlist",true);?>
" class="me-remove" title="Excluir este produto da minha wishlist">Excluir</a>
                    <ul class="social-share-small">
                        <li class="social-item">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('wish')->value->DS_PRODUTO_PRRC);?>
<?php $_tmp38=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('wish')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp39=ob_get_clean();?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp38,"idproduto"=>$_tmp39),"produto",true),'url');?>
" class="social-link ir facebook" target="_blank">Facebook</a>
                        </li>
                        <li class="social-item">
                            <a href="http://twitter.com/home?status=<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('wish')->value->DS_PRODUTO_PRRC);?>
<?php $_tmp40=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('wish')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp41=ob_get_clean();?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp40,"idproduto"=>$_tmp41),"produto",true),'url');?>
" class="social-link ir twitter" target="_blank">Twitter</a>
                        </li>
                        <li class="social-item">
                            <a href="http://tumblr.com/share?s=&v=3&t=<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('wish')->value->DS_PRODUTO_PRRC);?>
<?php $_tmp42=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('wish')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp43=ob_get_clean();?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp42,"idproduto"=>$_tmp43),"produto",true),'url');?>
" class="social-link ir tumblr" target="_blank">Tumblr</a>
                        </li>
                        <li class="social-item">
                            <a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>
                        </li>
                    </ul>
                </li>
                <?php }} ?>
            </ul>
        <?php }?>
        <div id="wishlist-pagination" data-lastpage="<?php echo $_smarty_tpl->getVariable('paginas_wishlist')->value;?>
" data-size="6">
          <ul class="pagination">
                <?php if ($_smarty_tpl->getVariable('paginas_wishlist')->value<=1){?>

                <?php }elseif($_smarty_tpl->getVariable('paginas_wishlist')->value>8){?>

                    <li>
                        <a href="#" class="prev disabled">◀</a>
                    </li>
                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<=5){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=5; $_smarty_tpl->tpl_vars['i']->value++){
?>
                       <?php if ($_smarty_tpl->tpl_vars['i']->value==1){?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page current"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }else{ ?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }?>
                    <?php }} ?>
                    <li>
                        <a class="prev">...</a>
                    </li>
                    <li>
                        <a href="#" data-page="<?php echo $_smarty_tpl->getVariable('paginas_wishlist')->value;?>
" class="page"><?php echo $_smarty_tpl->getVariable('paginas_wishlist')->value;?>
</a>
                    </li>
                    <li>
                        <a href="#" class="next">▶</a>
                    </li>
                <?php }elseif($_smarty_tpl->getVariable('paginas_wishlist')->value<=9){?>

                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<=$_smarty_tpl->getVariable('paginas_wishlist')->value){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=$_smarty_tpl->getVariable('paginas_wishlist')->value; $_smarty_tpl->tpl_vars['i']->value++){
?>

                        <?php if ($_smarty_tpl->tpl_vars['i']->value==1){?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page current"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }else{ ?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }?>

                    <?php }} ?>

                <?php }?>
            </ul>
        </div>
    </div>
    <div class="rvb-header-item">
        <h2>
            Reverbcycle
        </h2>
    </div>
    <div class="rvb-content-item clearfix">
        <?php if (count($_smarty_tpl->getVariable('cycles')->value)<=0){?>
            <p class="centered">
                Tudo aquilo que você já se cansou pode ser<br>
                interessante para outra pessoa. Entre no escambo do Reverbcycle!
            </p>
        <?php }else{ ?>
            <ul class="rvb-list rvb-list-of-photos-cycle clearfix" id="cycle-list">
                <?php  $_smarty_tpl->tpl_vars['cycle'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('cycles')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['cycle']->key => $_smarty_tpl->tpl_vars['cycle']->value){
?>
                    <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('cycle')->value->NR_SEQ_REVERBCYCLE_RCRC), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('cycle')->value->DS_EXT_RCRC), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
                    <li class="rvb-photo-item">
                        <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('cycle')->value->DS_OBJETO_RCRC);?>
<?php $_tmp44=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cycle')->value->NR_SEQ_REVERBCYCLE_RCRC;?>
<?php $_tmp45=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp44,"idcycle"=>$_tmp45),"cycledetalhe",true);?>
" class="photo-thumb">
                            <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"reverbcycle",'crop'=>1,'largura'=>140,'altura'=>110,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->getVariable('cycle')->value->DS_OBJETO_RCRC;?>
">
                        </a>
                        <a  href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('cycle')->value->DS_OBJETO_RCRC);?>
<?php $_tmp46=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cycle')->value->NR_SEQ_REVERBCYCLE_RCRC;?>
<?php $_tmp47=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp46,"idcycle"=>$_tmp47),"cycledetalhe",true);?>
" class="photo-link">
                            <?php echo $_smarty_tpl->getVariable('cycle')->value->DS_OBJETO_RCRC;?>

                        </a>
                        <span class="comments">
                            Comentários: <?php echo $_smarty_tpl->getVariable('cycle')->value->total_comentarios;?>

                        </span>
                        <span class="views">
                            Views: <?php echo $_smarty_tpl->getVariable('cycle')->value->NR_VIEWS_RCRC;?>

                        </span>
                        <ul class="social-share-small">
                            <li class="social-item">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('cycle')->value->DS_OBJETO_RCRC);?>
<?php $_tmp48=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cycle')->value->NR_SEQ_REVERBCYCLE_RCRC;?>
<?php $_tmp49=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp48,"idcycle"=>$_tmp49),"cycledetalhe",true);?>
" class="social-link ir facebook" target="_blank">Facebook</a>
                            </li>
                            <li class="social-item">
                                <a href="http://twitter.com/home?status=<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('cycle')->value->DS_OBJETO_RCRC);?>
<?php $_tmp50=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cycle')->value->NR_SEQ_REVERBCYCLE_RCRC;?>
<?php $_tmp51=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp50,"idcycle"=>$_tmp51),"cycledetalhe",true);?>
" class="social-link ir twitter" target="_blank">Twitter</a>
                            </li>
                            <li class="social-item">
                                <a href="http://tumblr.com/share?s=&v=3&t=<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('cycle')->value->DS_OBJETO_RCRC);?>
<?php $_tmp52=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cycle')->value->NR_SEQ_REVERBCYCLE_RCRC;?>
<?php $_tmp53=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp52,"idcycle"=>$_tmp53),"cycledetalhe",true);?>
" class="social-link ir tumblr" target="_blank">Tumblr</a>
                            </li>
                            <li class="social-item">
                                <a href="#" class="social-link ir pinterest" target="_blank">Pinterest</a>
                            </li>
                        </ul>
                    </li>
                <?php }} ?>

            </ul>
        <?php }?>
        <div id="cycle-pagination" data-lastpage="<?php echo $_smarty_tpl->getVariable('paginas_cycle')->value;?>
" data-size="6">
            <ul class="pagination">
                <?php if ($_smarty_tpl->getVariable('paginas_cycle')->value<=1){?>

                <?php }elseif($_smarty_tpl->getVariable('paginas_cycle')->value>8){?>

                    <li>
                        <a href="#" class="prev disabled">◀</a>
                    </li>
                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<=5){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=5; $_smarty_tpl->tpl_vars['i']->value++){
?>
                        <?php if ($_smarty_tpl->tpl_vars['i']->value==1){?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page current"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }else{ ?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }?>
                    <?php }} ?>
                    <li>
                        <a class="prev">...</a>
                    </li>
                    <li>
                        <a href="#" data-page="<?php echo $_smarty_tpl->getVariable('paginas_cycle')->value;?>
" class="page"><?php echo $_smarty_tpl->getVariable('paginas_cycle')->value;?>
</a>
                    </li>
                    <li>
                        <a href="#" class="next">▶</a>
                    </li>
                <?php }elseif($_smarty_tpl->getVariable('paginas_cycle')->value<=9){?>

                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<=$_smarty_tpl->getVariable('paginas_cycle')->value){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=$_smarty_tpl->getVariable('paginas_cycle')->value; $_smarty_tpl->tpl_vars['i']->value++){
?>

                        <?php if ($_smarty_tpl->tpl_vars['i']->value==1){?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page current"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }else{ ?>
                            <li>
                                <a href="#" data-page="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="page"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a>
                            </li>
                        <?php }?>

                    <?php }} ?>

                <?php }?>
            </ul>
        </div>
    </div>
    <?php  $_smarty_tpl->tpl_vars['banner'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('banners')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['banner']->key => $_smarty_tpl->tpl_vars['banner']->value){
?>
        <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('banner')->value->NR_SEQ_BANNER_BARC), null, null);?>
        <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('banner')->value->DS_EXT_BARC), null, null);?>
        <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
          <a class="rvb-banners-bottom" href="<?php echo $_smarty_tpl->getVariable('banner')->value->DS_LINK_BARC;?>
">
            <?php if (file_exists("arquivos/uploads/banners/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
              <img class="profile reverbme-ads" src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"banners",'crop'=>1,'largura'=>460,'altura'=>180,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->getVariable('banner')->value->DS_DESCRICAO_BARC;?>
"
              />
            <?php }else{ ?>
              <img class="profile reverbme-ads" src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>460,'altura'=>180,'imagem'=>'not_found.jpg'),'imagem',true);?>
" alt="<?php echo $_smarty_tpl->getVariable('banner')->value->DS_DESCRICAO_BARC;?>
">
            <?php }?>
          </a>
    <?php }} ?>
</div>

<!-- lightbox para adicionar fotos -->
<div class="md-modal md-effect-1" id="people-lightbox">
    <div class="md-content">
        <p class="md-title">Reverbpeople</p>
        <div class="mg-bg">
            <button class="md-close ir">Fechar</button>
            <form id="form-people" action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'cadastrarpeople',true);?>
" method="POST" enctype="multipart/form-data">
                <div class="fields-people">
                    <label for="Imagem" class="title">imagem</label>
                    <div class="fakeimg">
                        <span>Clique e selecione a imagem</span>
                        <input type="file" name="imagem" id="imagem">
                    </div>
                </div>

                <div class="description-people">
                    <p>
                        Itens inapropriados que não se qualificam como objetos pertencentes ao universo musical e seu estilo de vida, que tenham cunho pornográfico, criminoso, racista, ofensivo serão deletados sem aviso prévio.Itens postados que não tenham sido apagados por seus donos após já terem sido trocados ou aqueles que estejam no ar há 12 meses serão automaticamente deletados pela equipe Reverbcity. <br>
                        A Reverbcity não se responsabilizará pela logística das trocas feitas via Reverbcycle ou qualquer necessidade e/ou problema decorrente no seu processo.
                    </p>
                </div>
                <div class="send-button">
                    <button type="submit" class="btn">Aceitar e Enviar</button>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
                
<!-- lightbox para indicar -->
<div class="md-modal md-effect-1" id="indicar-lightbox">
    <div class="md-content">
        <p class="md-title">
            INDIQUE!
        </p>
        <button class="md-close ir">Fechar</button>
        <div>
            <form action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),"indiqueamigo2",true);?>
" method="post" id="form-url-video" class="rvb-form">

                <label class="rvb-label" for="NomeAmigo">Nome:</label>
                <input class="rvb-input-txt" name="NomeAmigo" type="text" required="">

                <label class="rvb-label" for="EmailAmigo">Email:</label>
                <input class="rvb-input-txt" name="EmailAmigo" type="email" required=""><br>

                <div class="send-button">
                    <button type="submit" class="btn">Enviar</button>
                </div>

                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>

<div class="md-modal md-effect-1" id="insert-url-video-lightbox">
    <div class="md-content">
        <p class="md-title">
            Inclusão de novo vídeo - Reverb me
        </p>
        <button class="md-close ir">Fechar</button>
        <div>
            <form action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),"cadastrarvideo",true);?>
" method="post" id="form-url-video" class="rvb-form">

                <label class="rvb-label" for="url-video">Insira a URL do vídeo:</label>
                <input class="rvb-input-txt" name="url-video" id="url-video" type="text" required="">

                <label class="rvb-label" for="titulo-video">Insira nome do vídeo:</label>
                <input class="rvb-input-txt" name="titulo-video" id="url-video2" type="text" required=""><br>

                <div class="send-button">
                    <button type="submit" class="btn">Enviar</button>
                </div>

                <div class="clearfix"></div>
            </form>
            <p>
                Pode não parecer, mas somos comportadinhos. Portando, nada de vídeos XxX no seu ReverbMe! A Reverbcity não se responsabilizar pelo conteúdo publicado nesta área do site.
            </p>
        </div>
    </div>
</div>

<div class="md-modal md-effect-1" id="lightbox-alterar-dados">
    <div class="md-content">
    <button class="md-close ir">Fechar</button>
        <form class="lighten" id="reverbme-form-cadastro" action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),"alterardados",true);?>
" method="post">
            <div class="alterar-dados-box">
                <?php if ($_smarty_tpl->getVariable('incompleto')->value==1){?>
                    <p class="full-strip" style="color: #f05626; background-color:transparent; text-align: center; font-size: 13px;">Complete seu cadastro para continuar a compra.</p>
                <?php }?>
                <p class="full-strip">Dados</p>
                <input type="hidden" name="cadastro_completo" value="1" />

                <div class="rvb-field">
                  <label for="nomecompleto" class="arrowed">Nome</label>
                  <input id="nomecompleto" name="nomecompleto" type="text" class="input-txt full" value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_NOME_CASO;?>
"required>
                </div>

                <div class="rvb-field">
                  <div class="select-form middle1">
                    <label for="sexo" class="arrowed">Sexo</label>
                    <span class="select-fake"><?php echo $_smarty_tpl->getVariable('perfil')->value->DS_SEXO_CACH;?>
</span>
                    <select name="sexo" id="sexo" class="select-box" required>
                        <option selected value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_SEXO_CACH;?>
"><?php echo $_smarty_tpl->getVariable('perfil')->value->DS_SEXO_CACH;?>
</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                    </select>
                  </div>
                </div>
                <?php if ($_smarty_tpl->getVariable('perfil')->value->ST_CADASTROCOMPLETO_CASO!=1){?>
                    <div class="rvb-field">
                      <label class="arrowed">Nascimento</label>
                      <input id="cadastro-dia" name="dia_nascimento" type="text" class="input-txt min day" placeholder="DIA" maxlength="2" required>
                      <input id="cadastro-mes" name="mes_nascimento" type="text" class="input-txt min month" placeholder="MÊS" maxlength="2" required>
                      <input id="cadastro-ano" name="ano_nascimento" type="text" class="input-txt min year" placeholder="ANO" maxlength="4" required>
                    </div>
                <?php }?>

                <div class="rvb-field">
                  <label for="cadastro-cpf" class="arrowed">CPF</label>
                  <input id="cadastro-cpf" name="cpf" type="text" class="input-txt middle1" maxlength="11" required value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_CPFCNPJ_CASO;?>
">
                  <span class="legend">Preencha sem traços e pontos</span>
                </div>

                <div class="rvb-field">
                  <label for="cep" class="arrowed">CEP</label>
                  <input id="cadastro-cep" name="cep" type="text" class="input-txt middle2" required value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_CEP_CASO;?>
">
                  <button id="buscarCep" type="button">Pesquisar</button>
                  <span class="legend">Digite sem traços e pontos</span>
                </div>

                <div class="rvb-field">
                  <label for="endereco" class="arrowed">Endereço</label>
                  <input id="endereco" name="endereco" type="text" class="input-txt middle2" required value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_ENDERECO_CASO;?>
">
                </div>

                <div class="rvb-field">
                  <label for="numero" class="arrowed">Número</label>
                  <input id="numero" name="numero" type="text" class="input-txt middle3" required value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_NUMERO_CASO;?>
">
                </div>

                <div class="rvb-field">
                  <label for="complemento" class="arrowed">Compl.</label>
                  <input id="complemento" name="complemento" type="text" class="input-txt middle2" value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_COMPLEMENTO_CASO;?>
">
                </div>

                <div class="rvb-field">
                  <label for="bairro1" class="arrowed">Bairro</label>
                  <input id="bairro" name="bairro1" type="text" class="input-txt middle3" required value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_BAIRRO_CASO;?>
">
                </div>

                <div class="rvb-field">
                  <div class="select-form middle3">
                    <label for="estado1" class="arrowed">Estado</label>
                    <span class="select-fake"><?php if ($_smarty_tpl->getVariable('perfil')->value->DS_UF_CASO){?><?php echo $_smarty_tpl->getVariable('perfil')->value->DS_UF_CASO;?>
<?php }else{ ?>Selecione o estado<?php }?></span>
                    <select name="estado1" id="alterar_estado" class="select-box" value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_UF_CASO;?>
">
                    </select>
                  </div>
                </div>

                <div class="rvb-field">
                  <div class="select-form middle2">
                    <label for="cidade1" class="arrowed">Cidade</label>
                    <span class="select-fake"><?php if ($_smarty_tpl->getVariable('perfil')->value->DS_CIDADE_CASO){?><?php echo $_smarty_tpl->getVariable('perfil')->value->DS_CIDADE_CASO;?>
<?php }else{ ?>Selecione<?php }?></span>
                    <select name="cidade1" id="alterar_cidade" class="select-box" required value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_CIDADE_CASO;?>
">
                    </select>
                  </div>
                </div>

                <div class="rvb-field">
                  <div class="select-form middle3">
                    <label for="pais" class="arrowed">País</label>
                    <span class="select-fake">Brasil</span>
                    <select name="pais" id="pais" class="select-box">
                        <option selected value="Brasil">Brasil</option>
                        <option value="Outro">Outro</option>
                    </select>
                    <span id="international-purchase" class="legend md-trigger" data-modal="international-purchases-lightbox">International purchase (click here)</span>
                  </div>
                </div>
                <?php $_smarty_tpl->tpl_vars["telefone"] = new Smarty_variable(($_smarty_tpl->getVariable('perfil')->value->DS_DDDFONE_CASO).".".($_smarty_tpl->getVariable('perfil')->value->DS_FONE_CASO), null, null);?>
                <div class="rvb-field">
                  <label for="telefone11" class="arrowed">Fone</label>
                  <input id="telefone11" name="telefone11" type="text" class="input-txt middle2 phonemask" value="<?php echo $_smarty_tpl->getVariable('telefone')->value;?>
">
                </div>
                 <?php $_smarty_tpl->tpl_vars["celular"] = new Smarty_variable(($_smarty_tpl->getVariable('perfil')->value->DS_DDDCEL_CASO).".".($_smarty_tpl->getVariable('perfil')->value->DS_CELULAR_CASO), null, null);?>
                <div class="rvb-field">
                  <label for="telefone21" class="arrowed">Cel</label>
                  <input id="telefone21" name="telefone21" type="text" class="input-txt middle3 phonemask" value="<?php echo $_smarty_tpl->getVariable('celular')->value;?>
">
                </div>
            </div>

            <div class="alterar-dados-box">
                <p class="full-strip">Dados para login</p>

                <div class="rvb-field">
                  <label for="usuarioemail" class="arrowed">E-mail</label>
                  <input id="usuarioemail" name="usuarioemail" type="email" class="input-txt full" required value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_EMAIL_CASO;?>
">
                </div>

                <div class="rvb-field">
                  <label for="usuarioemail2" class="arrowed">Confirme</label>
                  <input id="usuarioemail2" name="usuarioemail2" type="email" class="input-txt full" required>
                </div>

                <div class="rvb-field">
                  <label for="usuariosenha" class="arrowed">Senha</label>
                  <input id="usuariosenha" name="usuariosenha" type="password" class="input-txt middle4" value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_SENHA_CASO;?>
">
                  <span class="legend">Mínimo de 4 caracteres</span>
                </div>

                <div class="rvb-field">
                  <label for="usuariosenha2" class="arrowed">Confirme</label>
                  <input id="usuariosenha2" name="usuariosenha2" type="password" class="input-txt full">
                </div>
            </div>

            <div class="alterar-dados-box last">
                <p class="full-strip">Redes sociais</p>

                <div class="rvb-field">
                  <label for="facebook" class="arrowed">Facebook</label>
                  <input id="facebook" name="facebook" type="text" class="input-txt full" value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_FACEBOOK_CACH;?>
">
                </div>

                <div class="rvb-field">
                  <label for="twitter" class="arrowed">Twitter</label>
                  <input id="twitter" name="twitter" type="text" class="input-txt full" value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_TWITTER_CACH;?>
">
                </div>

                <div class="rvb-field">
                  <label for="instagram" class="arrowed">Instagram</label>
                  <input id="instagram" name="instagram" type="text" class="input-txt full" value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_INSTAGRAM_CASO;?>
">
                </div>

                <div class="rvb-field margin-b">
                  <label for="pinterest" class="arrowed">Pinterest</label>
                  <input id="pinterest" name="pinterest" type="text" class="input-txt full" value="<?php echo $_smarty_tpl->getVariable('perfil')->value->DS_PINTEREST_CASO;?>
">
                </div>

                <div class="checkbox-dif <?php if ($_smarty_tpl->getVariable('perfil')->value->ST_ENVIO_CASO=='S'){?>checked<?php }?>">
                  <label class="checkbox" for="mailing">
                    <input type="checkbox" id="mailing" name="mailing" <?php if ($_smarty_tpl->getVariable('perfil')->value->ST_ENVIO_CASO=='S'){?>checked<?php }?> value="S">
                    Quero receber o reverbmailing
                  </label>
                </div>

                <div class="checkbox-dif <?php if ($_smarty_tpl->getVariable('perfil')->value->ST_ENVIOSMS_CACH=='S'){?>checked<?php }?>">
                  <label class="checkbox" for="sms">
                    <input type="checkbox" id="sms" name="sms" <?php if ($_smarty_tpl->getVariable('perfil')->value->ST_ENVIOSMS_CACH=='S'){?>checked<?php }?> value="S">
                    Autorizo o recebimento de SMS (Mensagens de texto no celular)
                  </label>
                </div>

                <div class="back-button">
                  <a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),"desativarconta",true);?>
" class="btn">Desativar Conta</a>
                </div>
                <div class="send-button">
                  <button type="submit" class="btn">Alterar</button>
                </div>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
</div>


<div class="md-overlay"></div>
<?php if ($_smarty_tpl->getVariable('incompleto')->value==1){?>
    <script type="text/javascript" src="/arquivos/default/js/libs/jquery.min.js?v=1"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(function() {
                  $('.modal-info').click();
            }, 1000);
        })
    </script>
<?php }?>
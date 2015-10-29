<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 17:03:07
         compiled from "/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/people/peopledetalhe.tpl" */ ?>
<?php /*%%SmartyHeaderCode:753750257562d276bd21899-80713266%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6061b690b7d4bb5341762025ed9dee561fef5e96' => 
    array (
      0 => '/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/people/peopledetalhe.tpl',
      1 => 1445396249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '753750257562d276bd21899-80713266',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/Users/design/Reverbcity/site/reverbcity.com/library/Reverb/Library/Smarty/plugins/modifier.date_format.php';
?>    <section id="detalhepeople">
        <h1 class="rvb-title">Reverb <span>people</span></h1>
                <?php $_smarty_tpl->tpl_vars["foto_me"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value->NR_SEQ_FOTO_FORC), null, null);?>
                <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value->DS_EXT_FORC), null, null);?>
                <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_me')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
        <div class="top-details">
            <div id="texto-people">
                <p>Foi pro rolê usando uma de nossa camisetas? Que tal mostrar para todo mundo que você se veste de música e quais são as suas camisetas preferidas? Para isso, basta enviar sua foto para a nossa galeria e deixar a música ser fotografada.</p>
            </div>
            <form action="" id="form-busca">
                <input type="text" id="busca-p"><a href="#" id="buscar"></a>
            </form>
        </div>
        <div class="row">
            <div class="span8 foto">
                <div class="people-product-photo">
                    <?php if (file_exists("arquivos/uploads/people/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                        <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"people",'crop'=>1,'largura'=>460,'altura'=>640,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->getVariable('foto')->value->DS_NOME_CASO;?>
" />
                    <?php }else{ ?>
                        <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>460,'altura'=>640,'imagem'=>'not_found.jpg'),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->getVariable('foto')->value->DS_NOME_CASO;?>
" />
                    <?php }?>
                </div>

                <div class="send-button left no-margin">
                    <a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'people',true);?>
" class="btn">Voltar</a>
                </div>
                <?php $_template = new Smarty_Internal_Template("share-buttons.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
            </div>


            <div class="span8 comentarios">
                <div class="data-title"><span><?php echo $_smarty_tpl->getVariable('foto')->value['DS_NOME_CASO'];?>
 - <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('foto')->value['DS_NOME_CASO']);?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('foto')->value['NR_SEQ_CADASTRO_CASO'];?>
<?php $_tmp2=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("nome"=>$_tmp1,"idperfil"=>$_tmp2),'perfil',true);?>
">Ver perfil</a></span></div>

                <div class="data-content contact">
                    <form method="post" action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'comentarpeople',true);?>
">

                        <span class="label-content nomeusuario"><?php echo $_smarty_tpl->getVariable('_nome_usuario')->value;?>
</span>
                        <input type="hidden" name="idpeople" value="<?php echo $_smarty_tpl->getVariable('idpeople')->value;?>
">
                        <textarea name="mensagem" id="mensagem" name="mensagem" placeholder="Escreva aqui seu comentário..."></textarea>

                        <div class="send-button">
                            <button type="submit" class="btn">Enviar</button>
                        </div>
                    </form>
                </div>

                <div class="topo-comentarios"><span>Comentários</span></div>

                <?php  $_smarty_tpl->tpl_vars['comentario'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('comentarios')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['comentario']->key => $_smarty_tpl->tpl_vars['comentario']->value){
?>
                <div class="data-content commentary" style="background-color: #FFFFFF; border-bottom: 2px solid #f2f2f2;">

                    <span class="nome-comentario"><a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->tpl_vars['comentario']->value['DS_NOME_CASO']);?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['comentario']->value['NR_SEQ_CADASTRO_CASO'];?>
<?php $_tmp4=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("nome"=>$_tmp3,"idperfil"=>$_tmp4),'perfil',true);?>
"><?php echo $_smarty_tpl->tpl_vars['comentario']->value['DS_NOME_CASO'];?>
</a></span>

                    <span class="data-comentario">
                        <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['comentario']->value['DT_CADASTRO_MCRC'],"%d/%m/%Y");?>
 
                        <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['comentario']->value['DT_CADASTRO_MCRC'],"%H:%M");?>
h
                        <?php if ($_smarty_tpl->getVariable('_idperfil')->value==2||$_smarty_tpl->getVariable('_idperfil')->value==4162||$_smarty_tpl->getVariable('_idperfil')->value==22652){?>
                            <a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array('idcomentario'=>$_smarty_tpl->tpl_vars['comentario']->value['NR_SEQ_COMENTARIO_MCRC']),'apagarcomentariome',true);?>
" class="remove">Remover</a>
                        <?php }?>
                    </span>

                    <span class="texto-comentario"><?php echo utf8_decode($_smarty_tpl->tpl_vars['comentario']->value['DS_TEXTO_MCRC']);?>
</span>
                    <span class="reply reply-comment-btn" style="float: right;">Responder</span>

                    <?php $_smarty_tpl->tpl_vars['respostas'] = new Smarty_variable($_smarty_tpl->getVariable('this')->value->respostapeoplecoments($_smarty_tpl->tpl_vars['comentario']->value['NR_SEQ_COMENTARIO_MCRC']), null, null);?>
                    <?php  $_smarty_tpl->tpl_vars['mensagem_filha'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('respostas')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['mensagem_filha']->key => $_smarty_tpl->tpl_vars['mensagem_filha']->value){
?>
                        <div class="replied-item" style="background-color: #E5E5E5;">
                            <p class="person-name"><?php echo $_smarty_tpl->tpl_vars['mensagem_filha']->value['DS_NOME_CASO'];?>
</p>
                            <ul class="status-comment">
                                <li class="status-item last">
                                    <time datetime="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['mensagem_filha']->value['DT_CADASTRO_MCRC'],'%d/%m/%Y');?>
" class="timestamp">
                                        <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['mensagem_filha']->value['DT_CADASTRO_MCRC'],'%d/%m/%Y');?>
 <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['mensagem_filha']->value['DT_CADASTRO_MCRC'],"%H:%M");?>
h
                                    </time>
                                </li>
                            </ul>
                            <p class="person-answer">
                                <?php echo $_smarty_tpl->getVariable('this')->value->utf8($_smarty_tpl->tpl_vars['mensagem_filha']->value['DS_TEXTO_MCRC']);?>

                            </p>
                        </div> <!-- replied-item -->
                    <?php }} ?>

                    <div class="user-reply-comment disabled">
                        <p class="person-name"><?php echo $_smarty_tpl->getVariable('_nome_usuario')->value;?>
</p>
                        <div class="clearfix"></div>
                        <form action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'comentarpeople',true);?>
" method="post">
                            <input type="hidden" name="idpeople" value="<?php echo $_smarty_tpl->getVariable('idpeople')->value;?>
">
                            <input type="hidden" name="idmensagem" value="<?php echo $_smarty_tpl->tpl_vars['comentario']->value['NR_SEQ_COMENTARIO_MCRC'];?>
">
                            <textarea name="mensagem" class="reply-txt tynemce-on" placeholder="Escreva aqui seu comentário..."></textarea>
                            <div class="send-button">
                                <button type="submit" class="btn">Responder comentário</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php }} ?>
            </div>
        </div>

        <div class="row other-products">
            <?php $_template = new Smarty_Internal_Template("suggestion-products.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        </div>
    </section>
</div>
<?php $_template = new Smarty_Internal_Template("lightbox-indique.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
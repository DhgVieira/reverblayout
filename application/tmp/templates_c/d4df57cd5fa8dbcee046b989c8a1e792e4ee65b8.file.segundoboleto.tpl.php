<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 23:08:47
         compiled from "/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/checkout2/segundoboleto.tpl" */ ?>
<?php /*%%SmartyHeaderCode:109658143562d7d1f69a350-37576786%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd4df57cd5fa8dbcee046b989c8a1e792e4ee65b8' => 
    array (
      0 => '/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/checkout2/segundoboleto.tpl',
      1 => 1445396240,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '109658143562d7d1f69a350-37576786',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
    <div class="banners-advertisement cycle-slideshow"
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

    <h1 class="rvb-title"> 2ª Via <span>Boleto</span></h1>
    Perdeu o boleto do pagamento da sua compra? Não se preocupe, basta clicar em “Gerar  2ª Via do Boleto” para emitir um novo e garantir as peças que estão reservadas para você.
    <div class="formulario">
            <form action="<?php echo $_smarty_tpl->getVariable('boleto_url')->value;?>
" method="get" name="pagamento" target="_blank">
                <button type="submit">
                    Gerar  2ª Via do Boleto
                </button>
            </form>
    </div>
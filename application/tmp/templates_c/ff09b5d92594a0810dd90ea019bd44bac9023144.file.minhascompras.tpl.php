<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 17:21:53
         compiled from "/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/reverbme/minhascompras.tpl" */ ?>
<?php /*%%SmartyHeaderCode:473516038562d2bd1b12ea6-74878265%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ff09b5d92594a0810dd90ea019bd44bac9023144' => 
    array (
      0 => '/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/reverbme/minhascompras.tpl',
      1 => 1445396249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '473516038562d2bd1b12ea6-74878265',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/Users/design/Reverbcity/site/reverbcity.com/library/Reverb/Library/Smarty/plugins/modifier.date_format.php';
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
    Minhas <span>Compras</span>
</h1>


<table id="minhas-compras" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><abbr title="Número do pedido">Nr</abbr></th>
            <th>Data do pedido</th>
            <th><abbr title="Quantidade de itens comprados">Quantidade</abbr></th>
            <th>Forma de pagamento</th>
            <th><abbr title="Valor Total">Valor</abbr></th>
            <th>Status</th>
            <th><abbr title="Código de Rastreamento">Cód. Rastreamento</abbr></th>
        </tr>
    </thead>
    <tbody>
        <?php  $_smarty_tpl->tpl_vars['compra'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('compras')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['compra']->key => $_smarty_tpl->tpl_vars['compra']->value){
?>
            <tr>
                <td><a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<?php $_tmp1=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcompra"=>$_tmp1),"detalhecompra",true);?>
"><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<a></td>
                <td><a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<?php $_tmp2=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcompra"=>$_tmp2),"detalhecompra",true);?>
"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['compra']->value['DT_COMPRA_COSO'],"%d/%m/%Y %H:%M");?>
</a></td>
                <td><a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<?php $_tmp3=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcompra"=>$_tmp3),"detalhecompra",true);?>
"><?php echo $_smarty_tpl->tpl_vars['compra']->value['total_itens'];?>
</a></td>
                <td><a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<?php $_tmp4=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcompra"=>$_tmp4),"detalhecompra",true);?>
"><?php echo $_smarty_tpl->tpl_vars['compra']->value['DS_FORMAPGTO_COSO'];?>
</a></td>
                <td><a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<?php $_tmp5=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcompra"=>$_tmp5),"detalhecompra",true);?>
">R$ <?php echo number_format($_smarty_tpl->tpl_vars['compra']->value['VL_TOTAL_COSO'],2,",",".");?>
</a></td>

                <?php if ($_smarty_tpl->tpl_vars['compra']->value['ST_COMPRA_COSO']=='V'){?>
                    <td><a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<?php $_tmp6=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcompra"=>$_tmp6),"detalhecompra",true);?>
">ENVIADA</a></td>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['compra']->value['ST_COMPRA_COSO']=='E'){?>
                    <td><a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<?php $_tmp7=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcompra"=>$_tmp7),"detalhecompra",true);?>
">ENTREGUE</a></td>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['compra']->value['ST_COMPRA_COSO']=='C'){?>
                    <td><a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<?php $_tmp8=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcompra"=>$_tmp8),"detalhecompra",true);?>
">CANCELADA</a></td>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['compra']->value['ST_COMPRA_COSO']=='P'){?>
                    <td><a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<?php $_tmp9=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcompra"=>$_tmp9),"detalhecompra",true);?>
">PAGA</a></td>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['compra']->value['ST_COMPRA_COSO']=='A'){?>
                    <td style=" font-weight: bold; " <?php if ($_smarty_tpl->getVariable('vencimentoBoleto')->value<smarty_modifier_date_format(time(),"%Y-%m-%d")){?> class="has-tooltip" <?php }?>>
                        <?php if ($_smarty_tpl->tpl_vars['compra']->value['DS_FORMAPGTO_COSO']=='boleto'){?>
                            <?php $_smarty_tpl->tpl_vars['vencimentoBoleto'] = new Smarty_variable(($_smarty_tpl->tpl_vars['compra']->value['DT_COMPRA_COSO']).("+3 days"), null, null);?>
                            <?php $_smarty_tpl->tpl_vars['vencimentoBoleto'] = new Smarty_variable(smarty_modifier_date_format($_smarty_tpl->getVariable('vencimentoBoleto')->value,"%Y-%m-%d"), null, null);?>

                            <?php if ($_smarty_tpl->getVariable('vencimentoBoleto')->value>=smarty_modifier_date_format(time(),"%Y-%m-%d")){?>
                                <a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<?php $_tmp10=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcompra"=>$_tmp10),"segundoboleto",true);?>
">2ª Via Boleto</a>
                            <?php }else{ ?>
                                <a class="novo-pagamento" href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<?php $_tmp11=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcompra"=>$_tmp11),"reabrircompra",true);?>
">NOVO PGTO.</a>
                            <?php }?>
                        <?php }else{ ?>
                            <a class="novo-pagamento" href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<?php $_tmp12=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcompra"=>$_tmp12),"reabrircompra",true);?>
">NOVO PGTO.</a>
                        <?php }?>
                        <?php if ($_smarty_tpl->getVariable('vencimentoBoleto')->value<smarty_modifier_date_format(time(),"%Y-%m-%d")){?>
                        <div class="tooltip">
                            Se você já pagou o boleto não prossiga com esta operação. <br/><br/>Aguarde o email de confirmação de pagamento e caso tenha qualquer dúvida mande email para o atendimento@reverbcity.com
                        </div>
                        <?php }?>
                    </td>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['compra']->value['DS_RASTREAMENTO_COSO']==''){?>
                    <td><a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<?php $_tmp13=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcompra"=>$_tmp13),"detalhecompra",true);?>
">AGUARDANDO CORREIOS</a></td>
                <?php }else{ ?>
                    <td><a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['compra']->value['NR_SEQ_COMPRA_COSO'];?>
<?php $_tmp14=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcompra"=>$_tmp14),"detalhecompra",true);?>
"><?php echo $_smarty_tpl->tpl_vars['compra']->value['DS_RASTREAMENTO_COSO'];?>
</a></td>
                <?php }?>
            </tr>
        <?php }} ?>
    </tbody>
</table>

<div class="send-button left no-margin">
    <a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'novome',true);?>
" class="btn">Voltar</a>
</div>
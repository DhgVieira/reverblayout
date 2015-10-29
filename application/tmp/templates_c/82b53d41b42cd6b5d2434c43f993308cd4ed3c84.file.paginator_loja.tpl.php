<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 19:32:10
         compiled from "/users/design/reverbcity/site/reverbcity.com/application/layouts/paginator_loja.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1042403820562d4a5a77dea0-35371047%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '82b53d41b42cd6b5d2434c43f993308cd4ed3c84' => 
    array (
      0 => '/users/design/reverbcity/site/reverbcity.com/application/layouts/paginator_loja.tpl',
      1 => 1445396225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1042403820562d4a5a77dea0-35371047',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('previous')->value){?>
    <li class="item">
        <a rel="nofollow" title="Página Anterior" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('previous')->value;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp4=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp5=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp6=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp7=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("module"=>"default",'slug'=>$_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('categoria_nome')->value),"controller"=>"loja","action"=>($_smarty_tpl->getVariable('acaoAtual')->value),"page"=>$_tmp1,"categoria"=>$_tmp2,"tamanho"=>$_tmp3,"genero"=>$_tmp4,"cor"=>$_tmp5,"tipo"=>$_tmp6,"valor"=>$_tmp7),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
">◄</a>
    </li>
<?php }?>
        
    <?php  $_smarty_tpl->tpl_vars['page'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('pagesInRange')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['page']->key => $_smarty_tpl->tpl_vars['page']->value){
?>
        <li class="item">
            <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp8=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp9=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp10=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp11=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp12=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp13=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("module"=>"default","controller"=>"loja",'slug'=>$_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('categoria_nome')->value),"action"=>($_smarty_tpl->getVariable('acaoAtual')->value),"page"=>$_smarty_tpl->tpl_vars['page']->value,"categoria"=>$_tmp8,"tamanho"=>$_tmp9,"genero"=>$_tmp10,"cor"=>$_tmp11,"tipo"=>$_tmp12,"valor"=>$_tmp13),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
"  <?php if ($_smarty_tpl->tpl_vars['page']->value==$_smarty_tpl->getVariable('this')->value->current){?> class="active" <?php }?>>
               
                <?php echo $_smarty_tpl->tpl_vars['page']->value;?>

            </a>
        </li>
    <?php }} ?>
<?php if ($_smarty_tpl->getVariable('next')->value){?>
    <li class="item">
        <a rel="nofollow" title="Página Anterior" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('next')->value;?>
<?php $_tmp14=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp15=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp16=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp17=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp18=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp19=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp20=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("module"=>"default",'slug'=>$_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('categoria_nome')->value),"controller"=>"loja","action"=>($_smarty_tpl->getVariable('acaoAtual')->value),"page"=>$_tmp14,"categoria"=>$_tmp15,"tamanho"=>$_tmp16,"genero"=>$_tmp17,"cor"=>$_tmp18,"tipo"=>$_tmp19,"valor"=>$_tmp20),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
">►</a>
    </li>
<?php }?>
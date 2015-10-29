<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 16:59:21
         compiled from "/users/design/reverbcity/site/reverbcity.com/application/layouts/paginator_loja_head.tpl" */ ?>
<?php /*%%SmartyHeaderCode:38191107562d26890d6519-20639030%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4cd65f9fc0408432a971707bc8589e776b245241' => 
    array (
      0 => '/users/design/reverbcity/site/reverbcity.com/application/layouts/paginator_loja_head.tpl',
      1 => 1445396225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '38191107562d26890d6519-20639030',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('previous')->value){?>
    <link rel="prev" href="https://www.reverbcity.com<?php ob_start();?><?php echo $_smarty_tpl->getVariable('previous')->value;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp4=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp5=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp6=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp7=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("module"=>"default",'slug'=>$_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('categoria_nome')->value),"controller"=>"loja","action"=>($_smarty_tpl->getVariable('acaoAtual')->value),"page"=>$_tmp1,"categoria"=>$_tmp2,"tamanho"=>$_tmp3,"genero"=>$_tmp4,"cor"=>$_tmp5,"tipo"=>$_tmp6,"valor"=>$_tmp7),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
"/>
<?php }?>
<?php if ($_smarty_tpl->getVariable('next')->value){?>
    <link rel="next" href="https://www.reverbcity.com<?php ob_start();?><?php echo $_smarty_tpl->getVariable('next')->value;?>
<?php $_tmp8=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp9=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp10=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp11=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp12=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp13=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp14=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("module"=>"default",'slug'=>$_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('categoria_nome')->value),"controller"=>"loja","action"=>($_smarty_tpl->getVariable('acaoAtual')->value),"page"=>$_tmp8,"categoria"=>$_tmp9,"tamanho"=>$_tmp10,"genero"=>$_tmp11,"cor"=>$_tmp12,"tipo"=>$_tmp13,"valor"=>$_tmp14),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
"/>
<?php }?>

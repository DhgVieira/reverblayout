<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 19:32:10
         compiled from "/Users/design/Reverbcity/site/reverbcity.com/application/layouts/sidebar-filters.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1338353501562d4a5aa6dcb1-11595112%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '35c455e542523760485335e54bef11e576bf6ab6' => 
    array (
      0 => '/Users/design/Reverbcity/site/reverbcity.com/application/layouts/sidebar-filters.tpl',
      1 => 1445396225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1338353501562d4a5aa6dcb1-11595112',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<!--     <?php $_smarty_tpl->tpl_vars["acaoAtual"] = new Smarty_variable("loja", null, null);?> -->
    <?php $_smarty_tpl->tpl_vars["acaoAtual"] = new Smarty_variable(($_smarty_tpl->getVariable('currentAction')->value), null, null);?>
    <?php $_smarty_tpl->tpl_vars["controllerAtual"] = new Smarty_variable(($_smarty_tpl->getVariable('currentController')->value), null, null);?>

    <?php if ($_smarty_tpl->getVariable('acaoAtual')->value=="index"&&$_smarty_tpl->getVariable('controllerAtual')->value=="loja"){?>
        <?php $_smarty_tpl->tpl_vars["acaoAtual"] = new Smarty_variable("loja", null, null);?>
    <?php }?>

    <?php if ($_smarty_tpl->getVariable('acaoAtual')->value=="index"&&$_smarty_tpl->getVariable('controllerAtual')->value=="atacado"){?>
        <?php $_smarty_tpl->tpl_vars["acaoAtual"] = new Smarty_variable("atacado", null, null);?>
    <?php }?>


<div class="sidebar-ui sidebar-filters right-aligned">
    <div style="text-align:center;width:219px;">

    <!-- <p class="full-strip">Filtros</p> -->

    <form action="#" id="form-busca-filtros" class="clearfix" method="POST">
        <input type="text" class="search-input" placeholder="Digite a busca" name="busca_produto" <?php if ($_smarty_tpl->getVariable('palavra_busca')->value!=''){?> value="<?php echo $_smarty_tpl->getVariable('palavra_busca')->value;?>
" <?php }?>>
        <!-- <div class="send-button search-icon">
            <button class="ir search-icon" type="submit">Buscar</button>
        </div> -->
    </form>

    <!-- filtro de valores -->
    <a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-values">
        <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <span class="menu-name">Valores</span>
        </div>
    </div>
    <ul class="sub-menu filter-by-values">
        <li class="sub-menu-item">
            <?php if ($_smarty_tpl->getVariable('valor_url')->value==19.90){?>
                <span class="sub-menu-link active">Até R$ 19,90</span>
            <?php }else{ ?>
                <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp4=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp5=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp1,"tamanho"=>$_tmp2,"genero"=>$_tmp3,"cor"=>$_tmp4,"tipo"=>$_tmp5,"valor"=>"19.90"),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link">
                    Até R$ 19,90
                </a>
            <?php }?>
        </li>
        <li class="sub-menu-item">
            <?php if ($_smarty_tpl->getVariable('valor_url')->value==29.90){?>
                <span class="sub-menu-link active">Até R$ 29,90 - (SALE)</span>
            <?php }else{ ?>
                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp6=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp7=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp8=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp9=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp10=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp6,"tamanho"=>$_tmp7,"genero"=>$_tmp8,"cor"=>$_tmp9,"tipo"=>$_tmp10,"valor"=>"29.90"),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link">
                    Até R$ 29,90
                </a>
            <?php }?>
        </li>
        <li class="sub-menu-item">
            <?php if ($_smarty_tpl->getVariable('valor_url')->value==30){?>
                <span class="sub-menu-link active">De R$ 30,00 A R$ 55,00</span>
            <?php }else{ ?>
                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp11=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp12=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp13=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp14=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp15=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp11,"tamanho"=>$_tmp12,"genero"=>$_tmp13,"cor"=>$_tmp14,"tipo"=>$_tmp15,"valor"=>"30"),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link">
                   De R$ 30,00 A R$ 55,00
                </a>
            <?php }?>
        </li>
        <li class="sub-menu-item">
            <?php if ($_smarty_tpl->getVariable('valor_url')->value==59){?>
                <span class="sub-menu-link active">De R$ 59,00</span>
            <?php }else{ ?>
                <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp16=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp17=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp18=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp19=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp20=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp16,"tamanho"=>$_tmp17,"genero"=>$_tmp18,"cor"=>$_tmp19,"tipo"=>$_tmp20,"valor"=>"59"),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link">
                    De R$ 59,00
                </a>
            <?php }?>
        </li>       
        <li class="sub-menu-item">
            <?php if ($_smarty_tpl->getVariable('valor_url')->value==61){?>
                <span class="sub-menu-link active">De R$ 61,00 A R$ 90,00</span>
            <?php }else{ ?>
                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp21=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp22=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp23=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp24=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp25=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp21,"tamanho"=>$_tmp22,"genero"=>$_tmp23,"cor"=>$_tmp24,"tipo"=>$_tmp25,"valor"=>"61"),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link">
                   De R$ 61,00 A R$ 89,90
                </a>
            <?php }?>
        </li>
        <li class="sub-menu-item">
           <?php if ($_smarty_tpl->getVariable('valor_url')->value==90){?>
                <span class="sub-menu-link active">A PARTIR DE R$ 90,00</span>
            <?php }else{ ?>
                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp26=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp27=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp28=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp29=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp30=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp26,"tamanho"=>$_tmp27,"genero"=>$_tmp28,"cor"=>$_tmp29,"tipo"=>$_tmp30,"valor"=>"90"),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link">
                   A PARTIR DE R$ 90,00
                </a>
            <?php }?>
        </li>
    </ul>

<?php if (count($_smarty_tpl->getVariable('tipos')->value)>0){?>
    <!-- filtro produtos -->
    <a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-products">
        <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <span class="menu-name">Produtos</span>
        </div>
    </div>
    <ul class="sub-menu filter-by-products">
        <li class="sub-menu-item">
            <h2><a rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'novidades',true);?>
" class="sub-menu-link" style="color: #5fbf98;">Novidades</a></h2>
        </li>
        <li class="sub-menu-item">
            <h2><a rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'sale',true);?>
" class="sub-menu-link c-orange">Sale</a></h2>
        </li>

        <?php  $_smarty_tpl->tpl_vars['tipo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('tipos')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['tipo']->key => $_smarty_tpl->tpl_vars['tipo']->value){
?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('tipo_url')->value==$_smarty_tpl->tpl_vars['tipo']->value['NR_SEQ_CATEGPRO_PTRC']){?>
                    <h2><span class="sub-menu-link active"><?php echo $_smarty_tpl->tpl_vars['tipo']->value['DS_CATEGORIA_PTRC'];?>
</span></h2>
                <?php }else{ ?>
                    <h2><a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp31=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp32=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp33=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp34=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['tipo']->value['NR_SEQ_CATEGPRO_PTRC'];?>
<?php $_tmp35=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp36=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp31,"tamanho"=>$_tmp32,"genero"=>$_tmp33,"cor"=>$_tmp34,"tipo"=>$_tmp35,"valor"=>$_tmp36),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link"><?php echo $_smarty_tpl->tpl_vars['tipo']->value['DS_CATEGORIA_PTRC'];?>
</a></h2>
                <?php }?>
            </li>
        <?php }} ?>
    </ul>
<?php }?>
<?php if ($_smarty_tpl->getVariable('acaoAtual')->value!="casa"){?>
    <!-- filtro gênero -->
    <a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-gender">
        <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <h2><span class="menu-name">Gênero</span></h2>
        </div>
    </div>
    <ul class="sub-menu filter-by-gender">
        <?php if ($_smarty_tpl->getVariable('acaoAtual')->value!='masculino'&&$_smarty_tpl->getVariable('acaoAtual')->value!='feminino'){?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('genero')->value=="masculino"){?>
                    <h2><span class="sub-menu-link active">Masculino</span></h2>
                <?php }else{ ?>
                    <h2><a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp37=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp38=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp39=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp40=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp41=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp37,"tamanho"=>$_tmp38,"genero"=>'masculino',"cor"=>$_tmp39,"tipo"=>$_tmp40,"valor"=>$_tmp41),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link">Masculino</a></h2>
                <?php }?>
            </li>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('genero')->value=="feminino"){?>
                    <h2><span class="sub-menu-link active">Feminino</span></h2>
                <?php }else{ ?>
                    <h2><a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp42=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp43=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp44=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp45=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp46=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp42,"tamanho"=>$_tmp43,"genero"=>'feminino',"cor"=>$_tmp44,"tipo"=>$_tmp45,"valor"=>$_tmp46),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link">Feminino</a></h2>
                <?php }?>
            </li>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('acaoAtual')->value=='masculino'){?>
            <li class="sub-menu-item">
                <h2><span class="sub-menu-link active">Masculino</span></h2>
            </li>
        <?php }elseif($_smarty_tpl->getVariable('acaoAtual')->value=='feminino'){?>
            <li class="sub-menu-item">
                <h2><span class="sub-menu-link active">Feminino</span></h2>
            </li>
        <?php }?>
    </ul>
<?php }?>
<?php if ($_smarty_tpl->getVariable('acaoAtual')->value!="casa"){?>
    <!-- filtro tamanhos -->
    <a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-sizes">
        <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <span class="menu-name">Tamanhos</span>
        </div>
    </div>
    <ul class="sub-menu filter-by-sizes">
        <li class="sub-menu-item">
            <?php if ($_smarty_tpl->getVariable('tamanho_url')->value=="pp"){?>
                <span class="sub-menu-link ui-button active">PP</span>
            <?php }else{ ?>
                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp47=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp48=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp49=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp50=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp51=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp47,"tamanho"=>'pp',"genero"=>$_tmp48,"cor"=>$_tmp49,"tipo"=>$_tmp50,"valor"=>$_tmp51),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">PP</a>
            <?php }?>
        </li>
        <li class="sub-menu-item">
            <?php if ($_smarty_tpl->getVariable('tamanho_url')->value=="p"){?>
                <span class="sub-menu-link ui-button active">P</span>
            <?php }else{ ?>
                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp52=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp53=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp54=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp55=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp56=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp52,"tamanho"=>'p',"genero"=>$_tmp53,"cor"=>$_tmp54,"tipo"=>$_tmp55,"valor"=>$_tmp56),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">P</a>
            <?php }?>
        </li>
        <li class="sub-menu-item">
            <?php if ($_smarty_tpl->getVariable('tamanho_url')->value=="m"){?>
                <span class="sub-menu-link ui-button active">M</span>
            <?php }else{ ?>
                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp57=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp58=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp59=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp60=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp61=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp57,"tamanho"=>'m',"genero"=>$_tmp58,"cor"=>$_tmp59,"tipo"=>$_tmp60,"valor"=>$_tmp61),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">M</a>
            <?php }?>
        </li>
        <li class="sub-menu-item">
            <?php if ($_smarty_tpl->getVariable('tamanho_url')->value=="g"){?>
                <span class="sub-menu-link ui-button active">G</span>
            <?php }else{ ?>
                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp62=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp63=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp64=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp65=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp66=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp62,"tamanho"=>'g',"genero"=>$_tmp63,"cor"=>$_tmp64,"tipo"=>$_tmp65,"valor"=>$_tmp66),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">G</a>
            <?php }?>
        </li>
        <li class="sub-menu-item">
            <?php if ($_smarty_tpl->getVariable('tamanho_url')->value=="gg"){?>
                <span class="sub-menu-link ui-button active">GG</span>
            <?php }else{ ?>
                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp67=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp68=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp69=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp70=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp71=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp67,"tamanho"=>'gg',"genero"=>$_tmp68,"cor"=>$_tmp69,"tipo"=>$_tmp70,"valor"=>$_tmp71),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">GG</a>
            <?php }?>
        </li>
        <li class="sub-menu-item">
            <?php if ($_smarty_tpl->getVariable('tamanho_url')->value=="xgg"){?>
                <span class="sub-menu-link ui-button active">XGG</span>
            <?php }else{ ?>
                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp72=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp73=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp74=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp75=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp76=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp72,"tamanho"=>'xgg',"genero"=>$_tmp73,"cor"=>$_tmp74,"tipo"=>$_tmp75,"valor"=>$_tmp76),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">XGG</a>
            <?php }?>
        </li>
    </ul>
<?php }?>
<?php if (count($_smarty_tpl->getVariable('cores')->value)>0){?>
    <!-- filtro cores -->
    <a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-colors">
        <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <span class="menu-name">Cores</span>
        </div>
    </div>
    <ul class="sub-menu filter-by-colors">
        <?php if ($_smarty_tpl->getVariable('tem_preto')->value==1){?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('cor_url')->value==1){?>
                    <span class="sub-menu-link ui-button active">
                        <span class="color ir black">Preto</span>
                    </span>
                <?php }else{ ?>
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp77=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp78=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp79=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp80=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp81=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp77,"tamanho"=>$_tmp78,"genero"=>$_tmp79,"cor"=>1,"tipo"=>$_tmp80,"valor"=>$_tmp81),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">
                        <span class="color ir black">Preto</span>
                    </a>
                <?php }?>
            </li>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('tem_cinza')->value==1){?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('cor_url')->value==2){?>
                    <span class="sub-menu-link ui-button active">
                        <span class="color ir gray">Cinza</span>
                    </span>
                <?php }else{ ?>
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp82=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp83=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp84=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp85=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp86=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp82,"tamanho"=>$_tmp83,"genero"=>$_tmp84,"cor"=>2,"tipo"=>$_tmp85,"valor"=>$_tmp86),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">
                        <span class="color ir gray">Cinza</span>
                    </a>
                <?php }?>
            </li>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('tem_branco')->value){?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('cor_url')->value==3){?>
                    <span class="sub-menu-link ui-button active">
                        <span class="color ir white">Branco</span>
                    </span>
                <?php }else{ ?>
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp87=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp88=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp89=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp90=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp91=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp87,"tamanho"=>$_tmp88,"genero"=>$_tmp89,"cor"=>3,"tipo"=>$_tmp90,"valor"=>$_tmp91),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">
                        <span class="color ir white">Branco</span>
                    </a>
                <?php }?>
            </li>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('tem_azul')->value==1){?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('cor_url')->value==7){?>
                    <span class="sub-menu-link ui-button active">
                        <span class="color ir light-blue">Azul Claro</span>
                    </span>
                <?php }else{ ?>
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp92=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp93=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp94=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp95=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp96=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp92,"tamanho"=>$_tmp93,"genero"=>$_tmp94,"cor"=>7,"tipo"=>$_tmp95,"valor"=>$_tmp96),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">
                        <span class="color ir light-blue">Azul claro</span>
                    </a>
                <?php }?>
            </li>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('tem_vermelho')->value==1){?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('cor_url')->value==4){?>
                    <span class="sub-menu-link ui-button active">
                        <span class="color ir red">Vermelho</span>
                    </span>
                <?php }else{ ?>
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp97=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp98=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp99=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp100=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp101=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp97,"tamanho"=>$_tmp98,"genero"=>$_tmp99,"cor"=>4,"tipo"=>$_tmp100,"valor"=>$_tmp101),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">
                        <span class="color ir red">Vermelho</span>
                    </a>
                <?php }?>
            </li>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('tem_amarelo')->value==1){?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('cor_url')->value==5){?>
                    <span class="sub-menu-link ui-button active">
                        <span class="color ir yellow">Amarelo</span>
                    </span>
                <?php }else{ ?>
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp102=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp103=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp104=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp105=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp106=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp102,"tamanho"=>$_tmp103,"genero"=>$_tmp104,"cor"=>5,"tipo"=>$_tmp105,"valor"=>$_tmp106),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">
                        <span class="color ir yellow">Amarelo</span>
                    </a>
                <?php }?>
            </li>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('tem_creme')->value==1){?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('cor_url')->value==11){?>
                    <span class="sub-menu-link ui-button active">
                        <span class="color ir cream">Creme</span>
                    </span>
                <?php }else{ ?>
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp107=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp108=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp109=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp110=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp111=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp107,"tamanho"=>$_tmp108,"genero"=>$_tmp109,"cor"=>11,"tipo"=>$_tmp110,"valor"=>$_tmp111),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">
                        <span class="color ir cream">Creme</span>
                    </a>
                <?php }?>
            </li>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('tem_laranja')->value==1){?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('cor_url')->value==6){?>
                    <span class="sub-menu-link ui-button active">
                        <span class="color ir green">Verde</span>
                    </span>
                <?php }else{ ?>
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp112=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp113=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp114=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp115=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp116=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp112,"tamanho"=>$_tmp113,"genero"=>$_tmp114,"cor"=>6,"tipo"=>$_tmp115,"valor"=>$_tmp116),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">
                        <span class="color ir green">Verde</span>
                    </a>
                <?php }?>
            </li>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('tem_marrom')->value==1){?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('cor_url')->value==8){?>
                    <span class="sub-menu-link ui-button active">
                        <span class="color ir brown">Marrom</span>
                    </span>
                <?php }else{ ?>
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp117=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp118=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp119=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp120=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp121=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp117,"tamanho"=>$_tmp118,"genero"=>$_tmp119,"cor"=>8,"tipo"=>$_tmp120,"valor"=>$_tmp121),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">
                        <span class="color ir brown">Marrom</span>
                    </a>
                <?php }?>
            </li>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('tem_laranja')->value==1){?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('cor_url')->value==10){?>
                    <span class="sub-menu-link ui-button active">
                        <span class="color ir orange">Laranja</span>
                    </span>
                <?php }else{ ?>
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp122=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp123=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp124=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp125=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp126=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp122,"tamanho"=>$_tmp123,"genero"=>$_tmp124,"cor"=>10,"tipo"=>$_tmp125,"valor"=>$_tmp126),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">
                        <span class="color ir orange">Azul Marinho</span>
                    </a>
                <?php }?>
            </li>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('tem_roxo')->value==1){?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('cor_url')->value==9){?>
                    <span class="sub-menu-link ui-button active">
                        <span class="color ir purple">Roxo</span>
                    </span>
                <?php }else{ ?>
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp127=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp128=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp129=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp130=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp131=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp127,"tamanho"=>$_tmp128,"genero"=>$_tmp129,"cor"=>9,"tipo"=>$_tmp130,"valor"=>$_tmp131),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">
                        <span class="color ir purple">Roxo</span>
                    </a>
                <?php }?>
            </li>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('tem_rosa')->value==1){?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('cor_url')->value==12){?>
                    <span class="sub-menu-link ui-button active">
                        <span class="color ir purplepink">Rosa</span>
                    </span>
                <?php }else{ ?>
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('cat_url')->value;?>
<?php $_tmp132=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp133=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp134=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp135=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp136=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp132,"tamanho"=>$_tmp133,"genero"=>$_tmp134,"cor"=>12,"tipo"=>$_tmp135,"valor"=>$_tmp136),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link ui-button">
                        <span class="color ir pink">Rosa</span>
                    </a>
                <?php }?>
            </li>
        <?php }?>
    </ul>
<?php }?>
    <!-- filtro temas -->
    <a rel="nofollow" class="arrow-menu open-sub-menu" href="#" data-menu="filter-by-themes">
        <span class="icon-arrow"></span>
    </a>
    <div class="menu-title">
        <div class="left-menu-item">
            <span class="menu-name">Temas</span>
        </div>
    </div>
    <ul class="sub-menu filter-by-themes">
        <?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('categorias')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value){
?>
            <li class="sub-menu-item">
                <?php if ($_smarty_tpl->getVariable('cat_url')->value==$_smarty_tpl->tpl_vars['cat']->value['NR_SEQ_CATEGPRO_PCRC']){?>
                    <h2><span class="sub-menu-link active"><?php echo $_smarty_tpl->tpl_vars['cat']->value['DS_CATEGORIA_PCRC'];?>
</span></h2>
                <?php }else{ ?>
                    <h2><a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['cat']->value['NR_SEQ_CATEGPRO_PCRC'];?>
<?php $_tmp137=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tamanho_url')->value;?>
<?php $_tmp138=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('genero')->value;?>
<?php $_tmp139=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor_url')->value;?>
<?php $_tmp140=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo_url')->value;?>
<?php $_tmp141=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('valor_url')->value;?>
<?php $_tmp142=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("categoria"=>$_tmp137,"tamanho"=>$_tmp138,"genero"=>$_tmp139,"cor"=>$_tmp140,"tipo"=>$_tmp141,"valor"=>$_tmp142),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
" class="sub-menu-link"><?php echo $_smarty_tpl->tpl_vars['cat']->value['DS_CATEGORIA_PCRC'];?>
</a></h2>
                <?php }?>
            </li>
        <?php }} ?>
    </ul>

    <!-- filtro modelagem -->

    <p class="full-strip"><a rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),($_smarty_tpl->getVariable('acaoAtual')->value),true);?>
">Limpar filtros</a></p>
</div>
</div>

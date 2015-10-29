<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 17:04:26
         compiled from "/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/loja/produto.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1683497188562d27ba481255-35853088%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '84e62e4cbc2d196218a41b4133424d23aa744957' => 
    array (
      0 => '/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/loja/produto.tpl',
      1 => 1445396247,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1683497188562d27ba481255-35853088',
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
 $_from = $_smarty_tpl->getVariable('banners')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['banner']->key => $_smarty_tpl->tpl_vars['banner']->value){
?>
        <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('banner')->value->NR_SEQ_BANNER_BARC), null, null);?>
        <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('banner')->value->DS_EXT_BARC), null, null);?>
        <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
        <a rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('banner')->value->DS_LINK_BARC;?>
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

<?php if ($_smarty_tpl->getVariable('produto')->value->NR_SEQ_TIPO_PRRC==6){?>
    <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('Camiseta ', null, null);?>
<?php }else{ ?>
    <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('', null, null);?>
<?php }?>
<?php $_smarty_tpl->tpl_vars['ds_produto_prrc'] = new Smarty_variable(explode(' - ',$_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC), null, null);?>

<div id="wrap-produtos">

    <div id="prod-detalhe">
        <header class="row-fluid">
            <h2 class="rvb-title">Reverb<strong>loja</strong></h2>

            <span class="breadcrumb">
                <div style="float: left;" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo')->value['NR_SEQ_CATEGPRO_PTRC'];?>
<?php $_tmp1=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("tipo"=>$_tmp1),'todos-produtos',true);?>
"><h2 itemprop="title" class="item-breadcumb"><?php echo $_smarty_tpl->getVariable('tipo')->value['DS_CATEGORIA_PTRC'];?>
</h2></a> ></div>
                <div style="float: left;" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" itemprop="title" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo')->value['NR_SEQ_CATEGPRO_PTRC'];?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('categoria')->value['NR_SEQ_CATEGPRO_PCRC'];?>
<?php $_tmp3=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("tipo"=>$_tmp2,"categoria"=>$_tmp3),'todos-produtos',true);?>
"><h2 itemprop="title" class="item-breadcumb"><?php echo $_smarty_tpl->getVariable('categoria')->value['DS_CATEGORIA_PCRC'];?>
</h2></a> > </div>
                        <?php if ($_smarty_tpl->getVariable('genero_produto')->value=='M'){?>
                    <div style="float: left;" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" itemprop="title" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo')->value['NR_SEQ_CATEGPRO_PTRC'];?>
<?php $_tmp4=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('categoria')->value['NR_SEQ_CATEGPRO_PCRC'];?>
<?php $_tmp5=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("tipo"=>$_tmp4,"categoria"=>$_tmp5,"genero"=>"masculino"),'todos-produtos',true);?>
"><h2 itemprop="title" class="item-breadcumb">Masculinas</h2></a> > </div>
                    <div style="float: left;" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a rel="nofollow" itemprop="url" itemprop="title" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo')->value['NR_SEQ_CATEGPRO_PTRC'];?>
<?php $_tmp6=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('categoria')->value['NR_SEQ_CATEGPRO_PCRC'];?>
<?php $_tmp7=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor')->value['idcor'];?>
<?php $_tmp8=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("tipo"=>$_tmp6,"categoria"=>$_tmp7,"genero"=>"masculino","cor"=>$_tmp8),'todos-produtos',true);?>
"><h2 itemprop="title" class="item-breadcumb"><?php echo $_smarty_tpl->getVariable('cor')->value['cor'];?>
</h2></a> ></div>
                        <?php }elseif($_smarty_tpl->getVariable('genero_produto')->value=="F"){?>
                    <div style="float: left;" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" itemprop="title" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo')->value['NR_SEQ_CATEGPRO_PTRC'];?>
<?php $_tmp9=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('categoria')->value['NR_SEQ_CATEGPRO_PCRC'];?>
<?php $_tmp10=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("tipo"=>$_tmp9,"categoria"=>$_tmp10,"genero"=>"feminino"),'todos-produtos',true);?>
"><h2 itemprop="title" class="item-breadcumb">Femininas</h2></a> > </div>
                    <div style="float: left;" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a rel="nofollow" itemprop="url" itemprop="title" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('tipo')->value['NR_SEQ_CATEGPRO_PTRC'];?>
<?php $_tmp11=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('categoria')->value['NR_SEQ_CATEGPRO_PCRC'];?>
<?php $_tmp12=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('cor')->value['idcor'];?>
<?php $_tmp13=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("tipo"=>$_tmp11,"categoria"=>$_tmp12,"genero"=>"feminino","cor"=>$_tmp13),'todos-produtos',true);?>
"><h2 itemprop="title" class="item-breadcumb"><?php echo $_smarty_tpl->getVariable('cor')->value['cor'];?>
</h2></a> ></div>
                        <?php }?>

                <b><?php echo $_smarty_tpl->getVariable('preTitle')->value;?>
<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>

                    <?php if ($_smarty_tpl->getVariable('produto')->value->DS_FRETEGRATIS_PRRC=='S'){?>
                        - Frete Grátis 
                    <?php }?>
                </b>
            </span>
        </header>

        <section class="row-fluid" id="detalhe-produto">

            <div class="span9 images">
                <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
                <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->getVariable('produto')->value->DS_EXT_PRRC), null, null);?>
                <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>

                <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['NR_SEQ_FOTO_FORC']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['DS_EXT_FORC']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>

                <?php if (!file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                    <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[1]['NR_SEQ_FOTO_FORC']), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[1]['DS_EXT_FORC']), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
                <?php }?>

                <div class="image span13">
                    <?php if (file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                        <img itemprop="image"  src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>443,'altura'=>494,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" id="zoom_01" data-zoom-image="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>886,'altura'=>988,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" title="<?php echo $_smarty_tpl->getVariable('preTitle')->value;?>
<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
" alt="<?php echo $_smarty_tpl->getVariable('preTitle')->value;?>
<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
" max-height="100%"/>
                    <?php }else{ ?>
                        <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>443,'altura'=>494,'imagem'=>'not_found.jpg'),"imagem",true);?>
" id="zoom_01" data-zoom-image="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"produtos",'crop'=>1,'largura'=>886,'altura'=>988,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
" max-height="100%"/>
                    <?php }?>
                </div>

                <div id="thumbnails-carousel" class="span3">

                    <a title="mostrar imagens anteriores" class="shifted-in ctrl-thumb-carousel" id="moveprev" rel="nofollow">
                        Exibir as imagens anteriores
                    </a>

                    <div id="hide-thumbnails" class="carousel">

                        <ul class="thumbnails" id="prod-thumbnails-list">


                            <?php  $_smarty_tpl->tpl_vars['foto'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('fotos')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['foto']->key => $_smarty_tpl->tpl_vars['foto']->value){
?>
                                <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->tpl_vars['foto']->value['NR_SEQ_FOTO_FORC']), null, null);?>
                                <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->tpl_vars['foto']->value['DS_EXT_FORC']), null, null);?>
                                <?php $_smarty_tpl->tpl_vars["foto_completa_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
                                <li class="prod-thumbnails-items">
                                    <?php if (file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa_produto')->value))){?>
                                        <?php $_smarty_tpl->tpl_vars["foto_completa_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC))."-".($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
                                        <a href="#" data-image="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>443,'altura'=>494,'imagem'=>$_smarty_tpl->getVariable('foto_completa_produto')->value),"imagem",true);?>
" data-zoom-image="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>886,'altura'=>988,'imagem'=>$_smarty_tpl->getVariable('foto_completa_produto')->value),"imagem",true);?>
" title="<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
" >
                                            <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>60,'altura'=>70,'imagem'=>$_smarty_tpl->getVariable('foto_completa_produto')->value),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->getVariable('preTitle')->value;?>
<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
" title="<?php echo $_smarty_tpl->getVariable('preTitle')->value;?>
<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
"/>
                                        </a>
                                    <?php }else{ ?>
                                        <a href="#" rel="nofollow" data-image="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>443,'altura'=>494,'imagem'=>'not_found.jpg'),"imagem",true);?>
" data-zoom-image="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>886,'altura'=>988,'imagem'=>'not_found.jpg'),"imagem",true);?>
" title="<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
" >
                                            <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>60,'altura'=>70,'imagem'=>'not_found.jpg'),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
" title="<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
"/>
                                        </a>
                                    <?php }?>
                                </li>
                            <?php }} ?>
                        </ul>
                    </div>

                    <a title="mostrar as proximas imagens" class="shifted-in ctrl-thumb-carousel" id="movenext" rel="nofollow">
                        Exibir as proximas imagens
                    </a>
                </div>

                <div class="btn-group btn-store show-768 shifted-out">
                    <!-- <button class="btn btn-large dropdown-toggle" data-toggle="dropdown">Reverb<span>loja</span></button>

                    <button class="btn btn-large dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>

                    <ul class="dropdown-menu">
                    <?php $_smarty_tpl->tpl_vars['dropitem'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['dropitem']->step = 1;$_smarty_tpl->tpl_vars['dropitem']->total = (int)ceil(($_smarty_tpl->tpl_vars['dropitem']->step > 0 ? 15+1 - (0) : 0-(15)+1)/abs($_smarty_tpl->tpl_vars['dropitem']->step));
if ($_smarty_tpl->tpl_vars['dropitem']->total > 0){
for ($_smarty_tpl->tpl_vars['dropitem']->value = 0, $_smarty_tpl->tpl_vars['dropitem']->iteration = 1;$_smarty_tpl->tpl_vars['dropitem']->iteration <= $_smarty_tpl->tpl_vars['dropitem']->total;$_smarty_tpl->tpl_vars['dropitem']->value += $_smarty_tpl->tpl_vars['dropitem']->step, $_smarty_tpl->tpl_vars['dropitem']->iteration++){
$_smarty_tpl->tpl_vars['dropitem']->first = $_smarty_tpl->tpl_vars['dropitem']->iteration == 1;$_smarty_tpl->tpl_vars['dropitem']->last = $_smarty_tpl->tpl_vars['dropitem']->iteration == $_smarty_tpl->tpl_vars['dropitem']->total;?>
                    <li>
                        <a href="#rotaParaCategoria<?php echo $_smarty_tpl->tpl_vars['dropitem']->value;?>
">Lorem ipsum dolor - <?php echo $_smarty_tpl->tpl_vars['dropitem']->value;?>
 </a>
                    </li>
                    <?php }} ?>
                </ul> -->
                </div>
            </div>

            <div class="span5 description"  itemscope itemtype="http://schema.org/Product">
                <meta itemprop="image" content="https://www.reverbcity.com<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>443,'altura'=>494,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" >

                <form action="#actionPraComprar" method="">

                    <div id="heading-details-product" class="heading-details-products">
                        <h1 itemprop="name"><?php echo $_smarty_tpl->getVariable('preTitle')->value;?>
 <?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
</h1>
                        <img itemprop="image" style="display:none;" src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>443,'altura'=>494,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" alt="<?php echo $_smarty_tpl->getVariable('produto')->value->DS_PRODUTO_PRRC;?>
"/>
                        <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" style="display: none;">
                            Rated <span itemprop="ratingValue"><?php if ($_smarty_tpl->getVariable('nota')->value['soma_notas']>=1){?><?php echo $_smarty_tpl->getVariable('nota')->value['soma_notas'];?>
<?php }else{ ?>5<?php }?></span>/<?php echo $_smarty_tpl->getVariable('nota')->value['total_voto']+23;?>
 based on <span itemprop="ratingCount"><?php echo $_smarty_tpl->getVariable('nota')->value['total_voto']+23;?>
</span> reviews
                        </div>
                        <?php if ($_smarty_tpl->getVariable('_logado')->value!=1){?>
                            <div id="score" data-logado="false" data-score="<?php echo $_smarty_tpl->getVariable('nota')->value['soma_notas'];?>
"></div>
                        <?php }else{ ?>
                            <div id="score" data-logado="true" data-idproduto="<?php echo $_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC;?>
" data-score="<?php echo $_smarty_tpl->getVariable('nota')->value['soma_notas'];?>
"></div>
                        <?php }?>

                        <div class="details-product-heading">
                            <p><?php echo utf8_decode(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('produto')->value->DS_INFORMACOES_PRRC));?>
</p>
                        </div>

                        <label id="trigger-detail" for="opendetail" title="clique para vizualizar o texto completo da descrição ">
                            [ + info sobre <?php echo ((mb_detect_encoding($_smarty_tpl->getVariable('preTitle')->value, 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtolower($_smarty_tpl->getVariable('preTitle')->value,SMARTY_RESOURCE_CHAR_SET) : strtolower($_smarty_tpl->getVariable('preTitle')->value));?>
<?php echo ((mb_detect_encoding($_smarty_tpl->getVariable('ds_produto_prrc')->value[0], 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtolower($_smarty_tpl->getVariable('ds_produto_prrc')->value[0],SMARTY_RESOURCE_CHAR_SET) : strtolower($_smarty_tpl->getVariable('ds_produto_prrc')->value[0]));?>
 ]
                        </label>
                    </div>

                    <div class="sizes">

                        <div class="content">
                            <span class="escolha-tamanho">CLIQUE NO TAMANHO PARA COMPRAR</span>
                            <?php if (count($_smarty_tpl->getVariable('estoques_geral')->value)>0){?>
                                <div class="both">
                                    <div class="title" itemscope itemprop="offers" itemtype="http://data-vocabulary.org/Offer">
                                        <span class="price heavy" style="font-size: 15px;">

                                            <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>0){?>
                                                <del>R$ <?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC,2,",",".");?>
</del>
                                                Por R$ <span itemprop="price"><?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC,2,",",".");?>
</span>
                                            <?php }else{ ?>
                                                R$ <span itemprop="price"><?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC,2,",",".");?>
</span>
                                            <?php }?>
                                        </span>

                                        <span style="font-size: 11px;">
                                            <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>0){?>
                                                <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>=50&&$_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC<100){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC/2, null, null);?>
                                                    <br/>Ou 2x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }elseif($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>=100&&$_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC<150){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC/3, null, null);?>
                                                    <br/>Ou 3x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }elseif($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>=150){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC/4, null, null);?>
                                                    <br/>Ou 4x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }?>
                                            <?php }else{ ?>
                                                <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC>=50&&$_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC<=100){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC/2, null, null);?>
                                                    Ou 2x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }elseif($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC>=100&&$_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC<150){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC/3, null, null);?>
                                                    Ou 3x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }elseif($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC>=150){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC/4, null, null);?>
                                                    Ou 4x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }?>
                                            <?php }?>
                                        </span>

                                        <meta itemprop="priceCurrency" content="BRL" />

                                    </div>
                                    <ul class="size-list unisex">
                                        <?php  $_smarty_tpl->tpl_vars['estoque'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('estoques_geral')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['estoque']->key => $_smarty_tpl->tpl_vars['estoque']->value){
?>
                                            <?php $_smarty_tpl->tpl_vars['tamanho'] = new Smarty_variable(explode("-",$_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC), null, null);?>

                                            <?php if ($_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_TARC==11){?>
                                                <li class="one-size">
                                                    <?php if ($_smarty_tpl->getVariable('estoque')->value->NR_QTDE_ESRC==1){?>
                                                        <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_PRODUTO_ESRC;?>
<?php $_tmp14=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_ESTOQUE_ESRC;?>
<?php $_tmp15=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC;?>
<?php $_tmp16=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idproduto"=>$_tmp14,"idestoque"=>$_tmp15,"tamanho"=>$_tmp16,"genero"=>"u"),'adicionarcarrinho',true);?>
" class="btn" title="Tamanho <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>
">
                                                            <?php echo $_smarty_tpl->getVariable('tamanho')->value[0];?>
 <?php echo $_smarty_tpl->getVariable('tamanho')->value[1];?>

                                                            <span class="resta">resta 1</span>
                                                        </a>

                                                    <?php }elseif($_smarty_tpl->getVariable('estoque')->value->NR_QTDE_ESRC==0){?>
                                                        <a rel="nofollow" href="#" title="Tamanho <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>
" data-modal="avise-lightbox" class="btn inactive md-trigger" data-idtamanho="<?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC;?>
">
                                                            <?php echo $_smarty_tpl->getVariable('tamanho')->value[0];?>
 <?php echo $_smarty_tpl->getVariable('tamanho')->value[1];?>

                                                            <span class="resta" >avise-me</span>
                                                        </a>
                                                    <?php }else{ ?>
                                                        <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_PRODUTO_ESRC;?>
<?php $_tmp17=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_ESTOQUE_ESRC;?>
<?php $_tmp18=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC;?>
<?php $_tmp19=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idproduto"=>$_tmp17,"idestoque"=>$_tmp18,"tamanho"=>$_tmp19,"genero"=>"u"),'adicionarcarrinho',true);?>
" class="btn" title="Tamanho <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>
">
                                                            <?php echo $_smarty_tpl->getVariable('tamanho')->value[0];?>
 <?php echo $_smarty_tpl->getVariable('tamanho')->value[1];?>

                                                        </a>
                                                    <?php }?>
                                                </li>
                                            <?php }else{ ?>
                                                <li>
                                                    <?php if ($_smarty_tpl->getVariable('estoque')->value->NR_QTDE_ESRC==1){?>
                                                        <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_PRODUTO_ESRC;?>
<?php $_tmp20=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_ESTOQUE_ESRC;?>
<?php $_tmp21=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC;?>
<?php $_tmp22=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idproduto"=>$_tmp20,"idestoque"=>$_tmp21,"tamanho"=>$_tmp22,"genero"=>"u"),'adicionarcarrinho',true);?>
" class="btn" title="Tamanho <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>
">
                                                            <?php echo $_smarty_tpl->getVariable('tamanho')->value[0];?>
 <?php echo $_smarty_tpl->getVariable('tamanho')->value[1];?>

                                                            <span class="resta">resta 1</span>
                                                        </a>

                                                    <?php }elseif($_smarty_tpl->getVariable('estoque')->value->NR_QTDE_ESRC<=0){?>
                                                        <a rel="nofollow" href="#" title="Tamanho <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>
" data-modal="avise-lightbox" class="btn inactive md-trigger" data-idtamanho="<?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC;?>
">
                                                            <?php echo $_smarty_tpl->getVariable('tamanho')->value[0];?>
 <?php echo $_smarty_tpl->getVariable('tamanho')->value[1];?>

                                                            <span class="resta" >avise-me</span>
                                                        </a>
                                                    <?php }else{ ?>
                                                        <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_PRODUTO_ESRC;?>
<?php $_tmp23=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_ESTOQUE_ESRC;?>
<?php $_tmp24=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC;?>
<?php $_tmp25=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idproduto"=>$_tmp23,"idestoque"=>$_tmp24,"tamanho"=>$_tmp25,"genero"=>"u"),'adicionarcarrinho',true);?>
" class="btn" title="Tamanho <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>
">
                                                            <?php echo $_smarty_tpl->getVariable('tamanho')->value[0];?>
 <?php echo $_smarty_tpl->getVariable('tamanho')->value[1];?>

                                                            <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_M_PRRC>0&&($_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC==3||$_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC==8)){?>
                                                                <span class="resta" >R$ <?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PROMO_M_PRRC,2,",",".");?>
</span>
                                                            <?php }?>

                                                            <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_XGL_PRRC>0&&($_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC==33||$_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC==47)){?>
                                                                <span class="resta" >R$ <?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PROMO_XGL_PRRC,2,",",".");?>
</span>
                                                            <?php }?>
                                                        </a>
                                                    <?php }?>
                                                </li>
                                            <?php }?>
                                        <?php }} ?>
                                    </ul>
                                </div>
                            <?php }?>
                            <?php if (count($_smarty_tpl->getVariable('estoques_masculino')->value)>0){?>
                                <div class="both" >
                                    <div class="title" itemscope itemprop="offers" itemtype="http://schema.org/Offer">
                                        <span class="price heavy" style="font-size:  15px;">
                                            <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>0){?>
                                                <del>R$ <?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC,2,",",".");?>
</del>
                                                Por R$ <span itemprop="price"><?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC,2,",",".");?>
</span>
                                            <?php }else{ ?>
                                                R$ <span itemprop="price"><?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC,2,",",".");?>
 </span>
                                            <?php }?></span>

                                        <span style="font-size: 11px;">
                                            <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>0){?>
                                                <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>=50&&$_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC<100){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC/2, null, null);?>
                                                    <br/>Ou 2x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }elseif($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>=100&&$_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC<150){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC/3, null, null);?>
                                                    <br/>Ou 3x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }elseif($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>=150){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC/4, null, null);?>
                                                    <br/>Ou 4x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }?>
                                            <?php }else{ ?>
                                                <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC>=50&&$_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC<=100){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC/2, null, null);?>
                                                    Ou 2x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }elseif($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC>=100&&$_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC<150){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC/3, null, null);?>
                                                    Ou 3x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }elseif($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC>=150){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC/4, null, null);?>
                                                    Ou 4x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }?>
                                            <?php }?>
                                        </span>

                                        <meta itemprop="priceCurrency" content="BRL" />
                                    </div>

                                    <span class="icon male"></span>

                                    <ul class="size-list">
                                        <?php  $_smarty_tpl->tpl_vars['estoque'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('estoques_masculino')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['estoque']->key => $_smarty_tpl->tpl_vars['estoque']->value){
?>
                                            <li>
                                                <?php if ($_smarty_tpl->getVariable('estoque')->value->NR_QTDE_ESRC==1){?>
                                                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_PRODUTO_ESRC;?>
<?php $_tmp26=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_ESTOQUE_ESRC;?>
<?php $_tmp27=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC;?>
<?php $_tmp28=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idproduto"=>$_tmp26,"idestoque"=>$_tmp27,"tamanho"=>$_tmp28,"genero"=>"m"),'adicionarcarrinho',true);?>
" class="btn" title="Tamanho <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>
">
                                                        <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>

                                                        <span class="resta">resta 1</span>
                                                    </a>
                                                <?php }elseif($_smarty_tpl->getVariable('estoque')->value->NR_QTDE_ESRC<=0){?>
                                                    <a rel="nofollow" href="#" class="btn inactive md-trigger" data-modal="avise-lightbox" title="Tamanho <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>
" data-idtamanho="<?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC;?>
">
                                                        <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>

                                                        <span class="resta" >avise-me</span>
                                                    </a>
                                                <?php }else{ ?>
                                                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_PRODUTO_ESRC;?>
<?php $_tmp29=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_ESTOQUE_ESRC;?>
<?php $_tmp30=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC;?>
<?php $_tmp31=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idproduto"=>$_tmp29,"idestoque"=>$_tmp30,"tamanho"=>$_tmp31,"genero"=>"m"),'adicionarcarrinho',true);?>
" class="btn" title="Tamanho <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>
">
                                                        <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>

                                                        <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_M_PRRC>0&&($_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC==3||$_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC==8)){?>
                                                            <span class="resta" >R$ <?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PROMO_M_PRRC,2,",",".");?>
</span>
                                                        <?php }?>

                                                        <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_XGL_PRRC>0&&($_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC==33||$_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC==47)){?>
                                                            <span class="resta" >R$ <?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PROMO_XGL_PRRC,2,",",".");?>
</span>
                                                        <?php }?>
                                                    </a>
                                                <?php }?>

                                            </li>
                                        <?php }} ?>
                                    </ul>
                                </div>
                            <?php }?>
                            <?php if (count($_smarty_tpl->getVariable('estoques_feminino')->value)>0){?>
                                <div class="both">
                                    <div class="title" itemscope="" itemprop="offers" itemtype="http://schema.org/Offer">
                                        <span class="price heavy" style="font-size: 15px;">
                                            <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>0){?>
                                                <del>R$ <?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC,2,",",".");?>
</del>
                                                Por R$ <span itemprop="price"><?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC,2,",",".");?>
</span>
                                            <?php }else{ ?>
                                                R$ <span itemprop="price"><?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC,2,",",".");?>
</span>
                                            <?php }?></span>

                                        <span style="font-size: 11px;">
                                            <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>0){?>
                                                <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>=50&&$_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC<100){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC/2, null, null);?>
                                                    <br />Ou 2x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }elseif($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>=100&&$_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC<150){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC/3, null, null);?>
                                                    <br />Ou 3x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }elseif($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC>=150){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PROMO_PRRC/4, null, null);?>
                                                    <br />Ou 4x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }?>
                                            <?php }else{ ?>
                                                <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC>=50&&$_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC<=100){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC/2, null, null);?>
                                                    Ou 2x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }elseif($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC>=100&&$_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC<150){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC/3, null, null);?>
                                                    Ou 3x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }elseif($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC>=150){?>
                                                    <?php $_smarty_tpl->tpl_vars['parcela'] = new Smarty_variable($_smarty_tpl->getVariable('produto')->value->VL_PRODUTO_PRRC/4, null, null);?>
                                                    Ou 4x de <span class="heavy">R$ <?php echo number_format($_smarty_tpl->getVariable('parcela')->value,2,",",".");?>
</span>
                                                <?php }?>
                                            <?php }?>
                                        </span>

                                        <meta itemprop="priceCurrency" content="BRL" />
                                    </div>

                                    <span class="icon female"></span>

                                    <ul class="size-list">
                                        <?php  $_smarty_tpl->tpl_vars['estoque'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('estoques_feminino')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['estoque']->key => $_smarty_tpl->tpl_vars['estoque']->value){
?>

                                            <li>
                                                <?php if ($_smarty_tpl->getVariable('estoque')->value->NR_QTDE_ESRC==1){?>
                                                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_PRODUTO_ESRC;?>
<?php $_tmp32=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_ESTOQUE_ESRC;?>
<?php $_tmp33=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC;?>
<?php $_tmp34=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idproduto"=>$_tmp32,"idestoque"=>$_tmp33,"tamanho"=>$_tmp34,"genero"=>"f"),'adicionarcarrinho',true);?>
" class="btn" title="Tamanho <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>
">
                                                        <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>

                                                        <span class="resta">resta 1</span>
                                                    </a>

                                                <?php }elseif($_smarty_tpl->getVariable('estoque')->value->NR_QTDE_ESRC<=0){?>
                                                    <a rel="nofollow" href="#" class="btn inactive md-trigger" data-modal="avise-lightbox" title="Tamanho <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>
" data-idtamanho="<?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC;?>
">
                                                        <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>

                                                        <span class="resta">avise-me</span>
                                                    </a>
                                                <?php }else{ ?>
                                                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_PRODUTO_ESRC;?>
<?php $_tmp35=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_ESTOQUE_ESRC;?>
<?php $_tmp36=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC;?>
<?php $_tmp37=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idproduto"=>$_tmp35,"idestoque"=>$_tmp36,"tamanho"=>$_tmp37,"genero"=>"f"),'adicionarcarrinho',true);?>
" class="btn" title="Tamanho <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>
">
                                                        <?php echo $_smarty_tpl->getVariable('estoque')->value->DS_SIGLA_TARC;?>

                                                        <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_M_PRRC>0&&($_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC==3||$_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC==8)){?>
                                                            <span class="resta" >R$ <?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PROMO_M_PRRC,2,",",".");?>
</span>
                                                        <?php }?>

                                                        <?php if ($_smarty_tpl->getVariable('produto')->value->VL_PROMO_XGL_PRRC>0&&($_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC==33||$_smarty_tpl->getVariable('estoque')->value->NR_SEQ_TAMANHO_ESRC==47)){?>
                                                            <span class="resta" >R$ <?php echo number_format($_smarty_tpl->getVariable('produto')->value->VL_PROMO_XGL_PRRC,2,",",".");?>
</span>
                                                        <?php }?>
                                                    </a>
                                                <?php }?>
                                            </li>
                                        <?php }} ?>
                                    </ul>
                                </div>
                            <?php }?>
                        </div>
                    </div>

                    <div class="btns">
                        <div class="left">
                            <?php if ($_smarty_tpl->getVariable('_logado')->value==1){?>
                                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp38=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idproduto"=>$_tmp38),"calculaindividual",true);?>
" data-logado="true" class="btn btn-block calcula-frete"><?php if ($_smarty_tpl->getVariable('frete')->value==''){?>Calcule o frete<?php }else{ ?><?php echo $_smarty_tpl->getVariable('frete')->value;?>
<?php }?></a>

                                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp39=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idproduto"=>$_tmp39),"calculaindividual",true);?>
" data-logado="true" class="btn btn-block calcula-prazo">Prazo de entrega</a>
                            <?php }else{ ?>
                                <a rel="nofollow" href="#" data-logado="false" class="btn btn-block calcula-frete">Calcule o frete</a>

                                <a rel="nofollow" href="#" data-logado="false" class="btn btn-block calcula-prazo">Prazo de entrega</a>
                            <?php }?>

                            <a rel="nofollow" href="#" id="troca-btn" class="btn btn-block">Trocas</a>

                            <div class="troca">

                                <p>

                                    A Reverbcity garante a troca de qualquer um de seus produtos, sem ônus para o cliente, caso seja constatado defeito na peça. Se o cliente quiser trocar uma peça (sem uso) por qualquer outro motivo, ele deverá cobrir despesas de frete.

                                </p>
                                <br>
                                <a rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),"contato",true);?>
" id="fale-conosco"><strong>Clique aqui</strong></a> em fale conosco.

                            </div>

                        </div>

                        <div class="right">
                            <a rel="nofollow" href="#" id="show-sizes" data-idproduto="<?php echo $_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC;?>
" data-modal="medidas-lightbox" class="md-trigger btn btn-primary btn-block btn-sizes"><!-- <span class="icon sizes"></span> -->
                                <span class="content">Tabela de Medidas</span>
                            </a>

                            <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp40=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("produto"=>$_tmp40),'adicionawishlist',true);?>
" class="btn btn-red btn-block btn-list"><!-- <span class="icon ok"></span>  --><span class="content">Adicionar a <br> lista de desejos</span></a>

                            <a rel="nofollow" href="" class="btn btn-block md-trigger" data-modal="avise-lightbox">AVISE-ME</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <div class="row other-products">
        <?php ob_start();?><?php echo count($_smarty_tpl->getVariable('_visitados')->value);?>
<?php $_tmp41=ob_get_clean();?><?php $_smarty_tpl->tpl_vars["max_visitados"] = new Smarty_variable($_tmp41, null, null);?>
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
            <?php if (count($_smarty_tpl->getVariable('sugestoes')->value)>0){?>
                <div class="category-item suggestions items-<?php echo $_smarty_tpl->getVariable('max')->value;?>
">
                    <p class="title-category">Sugestões</p>
                    <ul class="list-of-products">
                        <?php  $_smarty_tpl->tpl_vars['sugestao'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('sugestoes')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['sugestao']->iteration=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['sugestao']->key => $_smarty_tpl->tpl_vars['sugestao']->value){
 $_smarty_tpl->tpl_vars['sugestao']->iteration++;
?>
                            <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->tpl_vars['sugestao']->value['NR_SEQ_PRODUTO_PRRC']), null, null);?>
                            <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->tpl_vars['sugestao']->value['DS_EXT_PRRC']), null, null);?>
                            <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>

                            <?php $_smarty_tpl->tpl_vars["fotos"] = new Smarty_variable($_smarty_tpl->getVariable('this')->value->fotoproduto($_smarty_tpl->getVariable('sugestao')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
                            <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['NR_SEQ_FOTO_FORC']), null, null);?>
                            <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['DS_EXT_FORC']), null, null);?>
                            <?php $_smarty_tpl->tpl_vars["foto_completa_dia"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>

                            <?php if (!file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                                <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[1]['NR_SEQ_FOTO_FORC']), null, null);?>
                                <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[1]['DS_EXT_FORC']), null, null);?>
                                <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
                            <?php }?>

                            <?php if ($_smarty_tpl->getVariable('sugestao')->value->NR_SEQ_TIPO_PRRC==6){?>
                                <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('Camiseta ', null, null);?>
                            <?php }else{ ?>
                                <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('', null, null);?>
                            <?php }?>
                            <?php $_smarty_tpl->tpl_vars['ds_produto_prrc'] = new Smarty_variable(explode(' - ',$_smarty_tpl->getVariable('sugestao')->value->DS_PRODUTO_PRRC), null, null);?>
                            <?php $_smarty_tpl->tpl_vars['slug'] = new Smarty_variable(($_smarty_tpl->getVariable('preTitle')->value).($_smarty_tpl->getVariable('ds_produto_prrc')->value[0]), null, null);?>

                            <?php if ($_smarty_tpl->tpl_vars['sugestao']->iteration>$_smarty_tpl->getVariable('max')->value){?>
                                <?php break 1?>
                            <?php }?>
                            <li class="product-item">
                                <a rel="nofollow" class="thumb" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp42=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('sugestao')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp43=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp44=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp42,"idproduto"=>$_tmp43),$_tmp44,true);?>
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
<?php $_tmp45=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('sugestao')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp46=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp47=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp45,"idproduto"=>$_tmp46),$_tmp47,true);?>
"><?php echo $_smarty_tpl->getVariable('sugestao')->value->DS_PRODUTO_PRRC;?>
</a>
                                </p>
                                <p class="product-price">
                                    <?php if ($_smarty_tpl->getVariable('sugestao')->value->VL_PROMO_PRRC!=0){?>
                                        <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp48=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('sugestao')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp49=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp50=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp48,"idproduto"=>$_tmp49),$_tmp50,true);?>
">R$ <?php echo number_format($_smarty_tpl->getVariable('sugestao')->value->VL_PROMO_PRRC,2,",",".");?>
</a>
                                    <?php }else{ ?>
                                        <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp51=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('sugestao')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp52=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp53=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp51,"idproduto"=>$_tmp52),$_tmp53,true);?>
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
                        <?php $_smarty_tpl->tpl_vars["foto_completa_dia"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>

                        <?php if (!file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                            <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[1]['NR_SEQ_FOTO_FORC']), null, null);?>
                            <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[1]['DS_EXT_FORC']), null, null);?>
                            <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
                        <?php }?>

                        <?php if ($_smarty_tpl->tpl_vars['visitado']->value['tipo']==6){?>
                            <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('Camiseta ', null, null);?>
                        <?php }else{ ?>
                            <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('', null, null);?>
                        <?php }?>
                        <?php $_smarty_tpl->tpl_vars['ds_produto_prrc'] = new Smarty_variable(explode(' - ',$_smarty_tpl->tpl_vars['visitado']->value['nome']), null, null);?>
                        <?php $_smarty_tpl->tpl_vars['slug'] = new Smarty_variable(($_smarty_tpl->getVariable('preTitle')->value).($_smarty_tpl->getVariable('ds_produto_prrc')->value[0]), null, null);?>

                        <?php if ($_smarty_tpl->tpl_vars['visitado']->iteration>$_smarty_tpl->getVariable('max')->value){?>
                            <?php break 1?>
                        <?php }?>
                        <li class="product-item">
                            <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp54=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['visitado']->value['codigo'];?>
<?php $_tmp55=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp56=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp54,"idproduto"=>$_tmp55),$_tmp56,true);?>
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
<?php $_tmp57=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['visitado']->value['codigo'];?>
<?php $_tmp58=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp59=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp57,"idproduto"=>$_tmp58),$_tmp59,true);?>
"><?php echo utf8_decode($_smarty_tpl->tpl_vars['visitado']->value['nome']);?>
</a>
                            </p>
                            <p class="product-price">
                                <?php if ($_smarty_tpl->tpl_vars['visitado']->value['promo']!=0){?>
                                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp60=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['visitado']->value['codigo'];?>
<?php $_tmp61=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp62=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp60,"idproduto"=>$_tmp61),$_tmp62,true);?>
">R$ <?php echo number_format($_smarty_tpl->tpl_vars['visitado']->value['promo'],2,",",".");?>
</a>
                                <?php }else{ ?>
                                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp63=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['visitado']->value['codigo'];?>
<?php $_tmp64=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp65=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp63,"idproduto"=>$_tmp64),$_tmp65,true);?>
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

                <?php if (!file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                    <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[1]['NR_SEQ_FOTO_FORC']), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[1]['DS_EXT_FORC']), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
                <?php }?>

                <?php if ($_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_TIPO_PRRC==6){?>
                    <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('Camiseta ', null, null);?>
                <?php }else{ ?>
                    <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('', null, null);?>
                <?php }?>
                <?php $_smarty_tpl->tpl_vars['ds_produto_prrc'] = new Smarty_variable(explode(' - ',$_smarty_tpl->getVariable('_produto_dia')->value->DS_PRODUTO_PRRC), null, null);?>
                <?php $_smarty_tpl->tpl_vars['slug'] = new Smarty_variable(($_smarty_tpl->getVariable('preTitle')->value).($_smarty_tpl->getVariable('ds_produto_prrc')->value[0]), null, null);?>

                <li class="product-item last">
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp66=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp67=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp68=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp66,"idproduto"=>$_tmp67),$_tmp68,true);?>
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
<?php $_tmp69=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp70=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp71=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp69,"idproduto"=>$_tmp70),$_tmp71,true);?>
"><?php echo utf8_decode($_smarty_tpl->getVariable('_produto_dia')->value->DS_PRODUTO_PRRC);?>
</a>
                    </p>
                    <p class="product-price">
                        <?php if ($_smarty_tpl->getVariable('_produto_dia')->value->VL_PROMO_PRRC!=0){?>
                            <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp72=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp73=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp74=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp72,"idproduto"=>$_tmp73),$_tmp74,true);?>
">R$ <?php echo number_format($_smarty_tpl->getVariable('_produto_dia')->value->VL_PROMO_PRRC,2,",",".");?>
</a>
                        <?php }else{ ?>
                            <a  rel="nofollow"href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp75=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('_produto_dia')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp76=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp77=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp75,"idproduto"=>$_tmp76),$_tmp77,true);?>
">R$ <?php echo number_format($_smarty_tpl->getVariable('_produto_dia')->value->VL_PRODUTO_PRRC,2,",",".");?>
</a>
                        <?php }?>
                    </p>
                </li>
            </ul>
        </div>
        <!-- SALE APPLCIATIVA -->
        <div class="category-item ">
            <p class="title-category">Produtos sale</p>
            <ul class="list-of-products">
                <?php  $_smarty_tpl->tpl_vars['sale'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('sales')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['sale']->iteration=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['sale']->key => $_smarty_tpl->tpl_vars['sale']->value){
 $_smarty_tpl->tpl_vars['sale']->iteration++;
?>
                    <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->tpl_vars['sale']->value['NR_SEQ_PRODUTO_PRRC']), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->tpl_vars['sale']->value['DS_EXT_PRRC']), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>

                    <?php $_smarty_tpl->tpl_vars["fotos"] = new Smarty_variable($_smarty_tpl->getVariable('this')->value->fotoproduto($_smarty_tpl->getVariable('sale')->value->NR_SEQ_PRODUTO_PRRC), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['NR_SEQ_FOTO_FORC']), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['DS_EXT_FORC']), null, null);?>
                    <?php $_smarty_tpl->tpl_vars["foto_completa_dia"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>

                    <?php if (!file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                        <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[1]['NR_SEQ_FOTO_FORC']), null, null);?>
                        <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[1]['DS_EXT_FORC']), null, null);?>
                        <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>
                    <?php }?>

                    <?php if ($_smarty_tpl->getVariable('sale')->value->NR_SEQ_TIPO_PRRC==6){?>
                        <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('Camiseta ', null, null);?>
                    <?php }else{ ?>
                        <?php $_smarty_tpl->tpl_vars['preTitle'] = new Smarty_variable('', null, null);?>
                    <?php }?>
                    <?php $_smarty_tpl->tpl_vars['ds_produto_prrc'] = new Smarty_variable(explode(' - ',$_smarty_tpl->getVariable('sale')->value->DS_PRODUTO_PRRC), null, null);?>
                    <?php $_smarty_tpl->tpl_vars['slug'] = new Smarty_variable(($_smarty_tpl->getVariable('preTitle')->value).($_smarty_tpl->getVariable('ds_produto_prrc')->value[0]), null, null);?>

                    <?php if ($_smarty_tpl->tpl_vars['sale']->iteration>$_smarty_tpl->getVariable('max')->value){?>
                        <?php break 1?>
                    <?php }?>
                    <li class="product-item">
                        <a rel="nofollow" class="thumb" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp78=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('sale')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp79=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp80=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp78,"idproduto"=>$_tmp79),$_tmp80,true);?>
">
                            <?php if (file_exists("arquivos/uploads/fotosprodutos/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                                <!-- Polyfill para imagens responsivas-->
                                <span data-picture data-alt="<?php echo $_smarty_tpl->getVariable('sale')->value->DS_PRODUTO_PRRC;?>
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
" alt="<?php echo $_smarty_tpl->getVariable('sale')->value->DS_PRODUTO_PRRC;?>
">
                                    </noscript>
                                </span>
                            <?php }else{ ?>
                                <!-- Polyfill para imagens responsivas-->
                                <span data-picture data-alt="<?php echo $_smarty_tpl->getVariable('sale')->value->DS_PRODUTO_PRRC;?>
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
" alt="<?php echo $_smarty_tpl->getVariable('sale')->value->DS_PRODUTO_PRRC;?>
">
                                    </noscript>
                                </span>
                            <?php }?>

                        </a>
                        <p class="product-title">
                            <a href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp81=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('sale')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp82=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp83=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp81,"idproduto"=>$_tmp82),$_tmp83,true);?>
"><?php echo $_smarty_tpl->getVariable('sale')->value->DS_PRODUTO_PRRC;?>
</a>
                        </p>
                        <p class="product-price">
                            <?php if ($_smarty_tpl->getVariable('sale')->value->VL_PROMO_PRRC!=0){?>
                                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp84=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('sale')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp85=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp86=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp84,"idproduto"=>$_tmp85),$_tmp86,true);?>
">R$ <?php echo number_format($_smarty_tpl->getVariable('sale')->value->VL_PROMO_PRRC,2,",",".");?>
</a>
                            <?php }else{ ?>
                                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('slug')->value);?>
<?php $_tmp87=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('sale')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp88=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('acao')->value;?>
<?php $_tmp89=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("titulo"=>$_tmp87,"idproduto"=>$_tmp88),$_tmp89,true);?>
">R$ <?php echo number_format($_smarty_tpl->getVariable('sale')->value->VL_PRODUTO_PRRC,2,",",".");?>
</a>
                            <?php }?>
                        </p>
                    </li>
                <?php }} ?>
            </ul>
        </div>
    </div>

</div>


<div class="rvb-comment">
    <form action="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp90=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idproduto"=>$_tmp90),"comentarproduto",true);?>
" method="post">
        <?php if ($_smarty_tpl->getVariable('_logado')->value!=1){?>
            <p class="not-logado">
                Olá! Você precisa estar logado para comentar. <a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),"reverbme",true);?>
">Clique aqui </a> e faça um cadastro super rápido!
            </p>
        <?php }else{ ?>
            <div class="rvb-header-item">
                <span><?php echo $_smarty_tpl->getVariable('_nome_usuario')->value;?>
</span>
            </div>
            <textarea name="comentario" placeholder="Escreva seu comentário" id="comentario" cols="30" rows="10" class="message-box full-comment tynemce-on"></textarea>
            <input type="hidden" name="extensao" value="<?php echo $_smarty_tpl->getVariable('produto')->value->DS_EXT_PRRC;?>
"/>
            <div class="send-button">
                <button type="submit" class="btn">Enviar comentário</button>
            </div>
        <?php }?>

    </form>
</div>


<div class="about-this-post clearfix">
    <?php  $_smarty_tpl->tpl_vars['comentario'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('comentarios')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['comentario']->key => $_smarty_tpl->tpl_vars['comentario']->value){
?>
        <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->tpl_vars['comentario']->value['NR_SEQ_CADASTRO_CASO']), null, null);?>
        <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->tpl_vars['comentario']->value['DS_EXT_CACH']), null, null);?>
        <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
        <div class="comments-item">
            <ul class="status-post">
                <li class="status-item">
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('comentario')->value->NR_SEQ_PRODCOMENT_PCRC;?>
<?php $_tmp91=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcomentario"=>$_tmp91),'curtirprodutocoments',true);?>
" class="prodcurtiu" data-comentarioid="<?php echo $_smarty_tpl->getVariable('comentario')->value->NR_SEQ_PRODCOMENT_PCRC;?>
" title='Daniel&#10;Tony'>
                        <span class="likes">
                            + <?php echo $_smarty_tpl->getVariable('comentario')->value->NR_CURTIRAM_PCRC;?>
 Curtiram
                        </span>
                    </a>

                    </a>
                </li>
                <li class="status-item">
                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('comentario')->value->NR_SEQ_PRODCOMENT_PCRC;?>
<?php $_tmp92=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcomentario"=>$_tmp92),'naocurtirprodutocoments',true);?>
">
                        <span class="likes">
                            - <?php echo $_smarty_tpl->getVariable('comentario')->value->NR_NAOCURTIRAM_PCRC;?>
 Não Curtiram
                        </span>
                    </a>
                </li>
                <li class="status-item hide">
                    <span class="answers"><?php echo $_smarty_tpl->getVariable('comentario')->value->findDependentRowset('Default_Model_Produtoscoments')->count();?>
 Respostas</span>
                </li>
                <li class="status-item">
                    <span class="reply reply-comment-btn">Responder</span>
                </li>
                <li class="status-item hide">
                    <time class="timestamp" datetime="<?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('comentario')->value->DT_COMENT_PCRC,'%Y-%d-%m');?>
">
                        <?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('comentario')->value->DT_COMENT_PCRC,'%d/%m/%Y');?>
 ás <?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('comentario')->value->DT_COMENT_PCRC,"%H:%M");?>

                    </time>
                </li>
                <?php if ($_smarty_tpl->getVariable('_idperfil')->value==2||$_smarty_tpl->getVariable('_idperfil')->value==4162||$_smarty_tpl->getVariable('_idperfil')->value==22652){?>
                    <li class="status-item">
                        <a rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array('idcomentario'=>$_smarty_tpl->getVariable('comentario')->value->NR_SEQ_PRODCOMENT_PCRC),'apagarcomentario',true);?>
" class="remove">Remover este comentário</a>
                    </li>
                <?php }?>
            </ul>
            <div class="list-of-comments clearfix">
                <div class="comment-item">
                    <div class="comment-person">
                        <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->tpl_vars['comentario']->value['DS_NOME_CASO']);?>
<?php $_tmp93=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['comentario']->value['NR_SEQ_CADASTRO_CASO'];?>
<?php $_tmp94=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("nome"=>$_tmp93,"idperfil"=>$_tmp94),"perfil",true);?>
">
                            <?php if (file_exists("arquivos/uploads/reverbme/".($_smarty_tpl->getVariable('foto_completa')->value))){?>
                                <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"reverbme",'crop'=>1,'largura'=>50,'altura'=>62,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
" width="50" height="62" alt="<?php echo $_smarty_tpl->getVariable('comentario')->value->DS_NOME_CASO;?>
" />
                            <?php }else{ ?>
                                <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"error",'crop'=>1,'largura'=>50,'altura'=>62,'imagem'=>'not_found_bkp.jpg'),"imagem",true);?>
" width="50" height="62" alt="<?php echo $_smarty_tpl->getVariable('comentario')->value->DS_NOME_CASO;?>
" />
                            <?php }?>
                        </a>
                        <p class="comment-name">
                            <abbr title="<?php echo utf8_decode($_smarty_tpl->getVariable('comentario')->value->DS_NOME_CASO);?>
">
                                <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->tpl_vars['comentario']->value['DS_NOME_CASO']);?>
<?php $_tmp95=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['comentario']->value['NR_SEQ_CADASTRO_CASO'];?>
<?php $_tmp96=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("nome"=>$_tmp95,"idperfil"=>$_tmp96),"perfil",true);?>
">
                                    <?php echo $_smarty_tpl->getVariable('comentario')->value->DS_NOME_CASO;?>

                                </a>
                            </abbr>
                        </p>
                    </div>
                    <div class="comment-detail">
                        <p>
                            <?php echo $_smarty_tpl->getVariable('this')->value->utf8($_smarty_tpl->getVariable('comentario')->value->DS_COMENTARIO_PCRC);?>

                        </p>
                        <?php  $_smarty_tpl->tpl_vars['mensagem_filha'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('comentario')->value->findDependentRowset('Default_Model_Produtoscoments'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['mensagem_filha']->key => $_smarty_tpl->tpl_vars['mensagem_filha']->value){
?>
                            <div class="replied-item">
                                <p class="person-name">
                                    <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('this')->value->createslug($_smarty_tpl->getVariable('mensagem_filha')->value->DS_AUTOR_PCRC);?>
<?php $_tmp97=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('mensagem_filha')->value->NR_SEQ_CADASTRO_PCRC;?>
<?php $_tmp98=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("nome"=>$_tmp97,"idperfil"=>$_tmp98),"perfil",true);?>
">
                                        <?php echo $_smarty_tpl->getVariable('mensagem_filha')->value->DS_AUTOR_PCRC;?>

                                    </a>
                                </p>
                                <ul class="status-comment">
                                    <li class="status-item">
                                        <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('mensagem_filha')->value->NR_SEQ_PRODCOMENT_PCRC;?>
<?php $_tmp99=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcomentario"=>$_tmp99),'curtirprodutocoments',true);?>
">
                                            <span class="likes">
                                                + <?php echo $_smarty_tpl->getVariable('mensagem_filha')->value->NR_CURTIRAM_PCRC;?>
 curtiu
                                            </span>
                                        </a>
                                    </li>
                                    <li class="status-item">
                                        <a rel="nofollow" href="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('mensagem_filha')->value->NR_SEQ_PRODCOMENT_PCRC;?>
<?php $_tmp100=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idcomentario"=>$_tmp100),'naocurtirprodutocoments',true);?>
">
                                            <span class="likes">
                                                - <?php echo $_smarty_tpl->getVariable('mensagem_filha')->value->NR_NAOCURTIRAM_PCRC;?>
 não curtiram
                                            </span>
                                        </a>
                                    </li>
                                    <li class="status-item last">
                                        <time datetime="<?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('mensagem_filha')->value->DT_COMENT_PCRC,'%d/%m/%Y');?>
" class="timestamp">
                                            <?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('mensagem_filha')->value->DT_COMENT_PCRC,'%d/%m/%Y');?>
 ás <?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('mensagem_filha')->value->DT_COMENT_PCRC,"%H:%M");?>

                                        </time>
                                    </li>
                                </ul>
                                <p class="person-answer">
                                    <?php echo $_smarty_tpl->getVariable('this')->value->utf8($_smarty_tpl->getVariable('mensagem_filha')->value->DS_COMENTARIO_PCRC);?>

                                </p>
                            </div> <!-- replied-item -->
                        <?php }} ?>


                        <div class="user-reply-comment disabled">
                            <p class="person-name"><?php echo $_smarty_tpl->getVariable('_nome_usuario')->value;?>
</p>
                            <div class="clearfix"></div>
                            <form action="<?php ob_start();?><?php echo $_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC;?>
<?php $_tmp101=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idproduto"=>$_tmp101),'comentarproduto',true);?>
" method="post">
                                <input type="hidden" name="idmensagem" value="<?php echo $_smarty_tpl->getVariable('comentario')->value->NR_SEQ_PRODCOMENT_PCRC;?>
">
                                <textarea name="new-comment" class="reply-txt tynemce-on" placeholder="Escreva aqui seu comentário..."></textarea>
                                <div class="send-button">
                                    <button type="submit" class="btn">Responder comentário</button>
                                </div>
                            </form>
                        </div>
                    </div> <!-- comment-detail -->
                </div> <!-- comment-item -->
            </div> <!-- list-of-comments -->
        </div>
    <?php }} ?>
</div>
</div>
</div>

<div class="md-modal md-effect-1" id="medidas-lightbox">
    <div class="md-content">
        <p class="md-title">TABELA DE MEDIDAS DA REVERBCITY</p>
        <button class="md-close ir">Fechar</button>
        <div class="exter">

            <div id="medidas">

                <div class="camisetamaior">

                    <img id="img-preview" class="img" src="">

                </div>

            </div>

            <div class="infot">

                <div class="medidas-opcoes">
                    <h2>Escolha o tamanho para conferir as medidas:</h2>

                    <div id="desc">
                        <?php if (count($_smarty_tpl->getVariable('estoques_geral')->value)>0){?>
                            <h3>Tamanho Único:</h3>
                        <?php }elseif(count($_smarty_tpl->getVariable('estoques_masculino')->value)>0){?>
                            <h3>Masculino:</h3>
                        <?php }elseif(count($_smarty_tpl->getVariable('estoques_feminino')->value)>0){?>
                            <h3>Feminino:</h3>
                        <?php }?>



                        <ul id="sizes-list">

                            <!--  <?php if (count($_smarty_tpl->getVariable('estoques_masculino')->value)>0){?> -->

                            <!-- <?php }?> -->

                        </ul>
                    </div>
                </div>

                <div class="medidas-imagem">
                    <img class="img" id="tabela-medidas-img" src="">
                </div>

            </div>

        </div>
    </div>
</div>

<div class="md-modal md-effect-1" id="avise-lightbox">
    <div class="md-content">
        <p class="md-title">Avise-me</p>
        <button class="md-close ir">Fechar</button>
        <div class="exter">
            <p class="md-description">Caso você queira ser avisado da volta ao estoque de algum tamanho deste produto, preencha seus dados abaixo:</p>
            <form action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array('idproduto'=>$_smarty_tpl->getVariable('produto')->value->NR_SEQ_PRODUTO_PRRC),"avisemeproduto",true);?>
" id="avise-form" method="POST">
                <div class="md-bg">
                    <div class="col">
                        <?php if ($_smarty_tpl->getVariable('_logado')->value==1){?>

                            <input class="field field-left" id="avise-nome" type="text" name="NomeCompleto" placeholder="Nome completo" value="<?php echo $_smarty_tpl->getVariable('nome')->value;?>
" required>
                            <input class="field field-right phonemask" type="text" id="telefone" name="Telefone" placeholder="Telefone" value="(<?php echo $_smarty_tpl->getVariable('ddd')->value;?>
) - <?php echo $_smarty_tpl->getVariable('telefone')->value;?>
" required>
                            <input class="field field-left" id="avise-email" type="email" name="Email" placeholder="E-mail" value="<?php echo $_smarty_tpl->getVariable('email')->value;?>
" required>
                            <div class="field field-right" id="tamanho">
                                <span>Selecione o tamanho</span>
                                <select name="tamanho" required>
                                    <option value="">Selecione o tamanho</option>
                                    <?php  $_smarty_tpl->tpl_vars['tamanho'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('tamanhos')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['tamanho']->key => $_smarty_tpl->tpl_vars['tamanho']->value){
?>
                                        <option value="<?php echo $_smarty_tpl->getVariable('tamanho')->value->NR_SEQ_TAMANHO_TARC;?>
"><?php echo $_smarty_tpl->getVariable('tamanho')->value->DS_TAMANHO_TARC;?>
</option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <div class="field field-left" id="estado">
                                <span><?php echo $_smarty_tpl->getVariable('uf')->value;?>
</span>
                                <select id="avise-estado" name="estado" required value="<?php echo $_smarty_tpl->getVariable('uf')->value;?>
">
                                </select>
                            </div>
                            <div id="cidade" class="field field-right">
                                <span><?php echo $_smarty_tpl->getVariable('cidade')->value;?>
</span>
                                <select id="avise-cidade" name="cidade" required value="<?php echo $_smarty_tpl->getVariable('cidade')->value;?>
">
                                </select>
                            </div>

                        <?php }else{ ?>
                            <input class="field field-left" id="avise-nome" type="text" name="NomeCompleto" placeholder="Nome completo" required>
                            <input class="field field-right phonemask" type="text" id="telefone" name="Telefone" placeholder="Telefone" required>
                            <input class="field field-left" id="avise-email" type="email" name="Email" placeholder="E-mail" required>
                            <div class="field field-right" id="tamanho">
                                <span>Selecione o tamanho</span>
                                <select name="tamanho" required>
                                    <option value="">Selecione o tamanho</option>
                                    <?php  $_smarty_tpl->tpl_vars['tamanho'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('tamanhos')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['tamanho']->key => $_smarty_tpl->tpl_vars['tamanho']->value){
?>
                                        <option value="<?php echo $_smarty_tpl->getVariable('tamanho')->value->NR_SEQ_TAMANHO_TARC;?>
"><?php echo $_smarty_tpl->getVariable('tamanho')->value->DS_TAMANHO_TARC;?>
</option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <div class="field field-left" id="estado">
                                <span>Selecione o Estado</span>
                                <select id="avise-estado" name="estado" required></select>
                            </div>
                            <div id="cidade" class="field field-right">
                                <span>Selecione a cidade</span>
                                <select id="avise-cidade" name="cidade" required></select>
                            </div>
                        <?php }?>
                        <textarea placeholder="Comentários" name="observacoes"></textarea>
                    </div>
                </div>

                <div class="send-button">
                    <button class="btn" type="submit">Avise-me</button>
                </div>
            </form>

        </div>
    </div>
</div>
</div>

<?php $_template = new Smarty_Internal_Template("lightbox-indica-produto.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
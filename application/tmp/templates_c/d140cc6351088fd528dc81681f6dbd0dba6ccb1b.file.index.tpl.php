<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 17:22:08
         compiled from "/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/carrinho/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:334063370562d2be018e193-72967423%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd140cc6351088fd528dc81681f6dbd0dba6ccb1b' => 
    array (
      0 => '/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/carrinho/index.tpl',
      1 => 1445396239,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '334063370562d2be018e193-72967423',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<script type="text/javascript">
    document.cepEndereco = <?php echo $_smarty_tpl->getVariable('info')->value['DS_CEP_CASO'];?>
;
    document.basePath = '<?php echo $_smarty_tpl->getVariable('basePath')->value;?>
';</script>
<div class="my-cart-steps clearfix">
    <div class="steps step-1 current">Etapa 1 - Carrinho</div>
    <div class="steps step-2">Etapa 2 - Endereço / Pagamento</div>
    <div class="steps step-3">Etapa 3 - Confirmação</div>
</div>

<div class="carrinho-lista">

    <div class="mycart-buttons clearfix">
        <a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),"todos-produtos",true);?>
" class="mycart-button carrinho voltar">Comprar mais</a>
        <a href="#" class="mycart-button carrinho avancar">Avançar</a>
    </div>

    <div id="mycart-content-header">
        <p class="header-amount">Quantidade</p>
        <p class="header-value">Valor</p>
        <p class="header-value">Desconto</p>
        <p class="header-total">Total</p>
    </div>

    <ul id="mycart-content-list">
        <?php $_smarty_tpl->tpl_vars["quantidade_total"] = new Smarty_variable("0", null, null);?>
        <?php  $_smarty_tpl->tpl_vars['dadosProduto'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('carrinho')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dadosProduto']->key => $_smarty_tpl->tpl_vars['dadosProduto']->value){
?>
            <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->tpl_vars['dadosProduto']->value['codigo']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->tpl_vars['dadosProduto']->value['path']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>

            <?php $_smarty_tpl->tpl_vars["fotos"] = new Smarty_variable($_smarty_tpl->getVariable('this')->value->fotoproduto($_smarty_tpl->tpl_vars['dadosProduto']->value['codigo']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['NR_SEQ_FOTO_FORC']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["extensao_produto"] = new Smarty_variable(($_smarty_tpl->getVariable('fotos')->value[0]['DS_EXT_FORC']), null, null);?>
            <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto_produto')->value).".".($_smarty_tpl->getVariable('extensao_produto')->value), null, null);?>

            <?php $_smarty_tpl->tpl_vars["quantidade_total"] = new Smarty_variable((($_smarty_tpl->getVariable('quantidade_total')->value+$_smarty_tpl->tpl_vars['dadosProduto']->value['quantidade'])), null, null);?>

            <?php if ($_smarty_tpl->getVariable('valorCredito')->value&&$_smarty_tpl->getVariable('compra_niver')->value!=1){?>
                <?php if ($_smarty_tpl->getVariable('valorCredito')->value<=$_smarty_tpl->tpl_vars['dadosProduto']->value['total_produto']&&!isset($_smarty_tpl->getVariable('sobraCredito',null,true,false)->value)){?>
                    <?php $_smarty_tpl->tpl_vars['desconto'] = new Smarty_variable($_smarty_tpl->tpl_vars['dadosProduto']->value['total_produto']-$_smarty_tpl->tpl_vars['dadosProduto']->value['valor_total_desconto'], null, null);?>
                    <?php $_smarty_tpl->tpl_vars['sobraCredito'] = new Smarty_variable(0, null, null);?>
                <?php }else{ ?>
                    <?php if (!isset($_smarty_tpl->getVariable('sobraCredito',null,true,false)->value)){?>
                        <?php $_smarty_tpl->tpl_vars['desconto'] = new Smarty_variable($_smarty_tpl->tpl_vars['dadosProduto']->value['total_produto'], null, null);?>
                        <?php $_smarty_tpl->tpl_vars['sobraCredito'] = new Smarty_variable($_smarty_tpl->tpl_vars['dadosProduto']->value['total_produto']-$_smarty_tpl->getVariable('valorCredito')->value, null, null);?>
                    <?php }elseif($_smarty_tpl->getVariable('compra_niver')->value==1){?>
                        <?php $_smarty_tpl->tpl_vars['sobraCredito'] = new Smarty_variable(abs($_smarty_tpl->getVariable('sobraCredito')->value), null, null);?>
                        <?php if ($_smarty_tpl->getVariable('sobraCredito')->value<=$_smarty_tpl->tpl_vars['dadosProduto']->value['total_produto']){?>
                            <?php $_smarty_tpl->tpl_vars['desconto'] = new Smarty_variable($_smarty_tpl->getVariable('sobraCredito')->value, null, null);?>
                            <?php $_smarty_tpl->tpl_vars['sobraCredito'] = new Smarty_variable(0, null, null);?>
                        <?php }else{ ?>
                            <?php $_smarty_tpl->tpl_vars['sobraCredito'] = new Smarty_variable($_smarty_tpl->tpl_vars['dadosProduto']->value['total_produto']-$_smarty_tpl->getVariable('sobraCredito')->value, null, null);?>
                            <?php $_smarty_tpl->tpl_vars['desconto'] = new Smarty_variable($_smarty_tpl->tpl_vars['dadosProduto']->value['total_produto'], null, null);?>
                        <?php }?>
                    <?php }?>
                <?php }?>
            <?php }else{ ?>
                <?php $_smarty_tpl->tpl_vars['desconto'] = new Smarty_variable(0, null, null);?>
                <?php $_smarty_tpl->tpl_vars['sobraCredito'] = new Smarty_variable(0, null, null);?>
            <?php }?>

            <?php if ($_smarty_tpl->getVariable('desconto')->value){?>
                <?php $_smarty_tpl->tpl_vars['totalDesconto'] = new Smarty_variable($_smarty_tpl->getVariable('totalDesconto')->value+$_smarty_tpl->getVariable('desconto')->value, null, null);?>
            <?php }?>

            <!-- Verifica se valor do produto é promocional ou não -->
            <?php if ($_smarty_tpl->tpl_vars['dadosProduto']->value['vl_promo']==''||$_smarty_tpl->tpl_vars['dadosProduto']->value['vl_promo']==0){?>
                <?php $_smarty_tpl->tpl_vars["valor_produto"] = new Smarty_variable($_smarty_tpl->tpl_vars['dadosProduto']->value['valor'], null, null);?>
            <?php }else{ ?>
                <?php $_smarty_tpl->tpl_vars["valor_produto"] = new Smarty_variable($_smarty_tpl->tpl_vars['dadosProduto']->value['vl_promo'], null, null);?>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['dadosProduto']->value['tipo']!=9){?>
                <li class="mycart-content-item" data-idestoque="<?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['idestoque'];?>
" data-valorproduto="<?php echo $_smarty_tpl->getVariable('valor_produto')->value;?>
" data-desconto="<?php echo $_smarty_tpl->getVariable('desconto')->value;?>
">
                    <div class="mycart-content-img">
                        <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"fotosprodutos",'crop'=>1,'largura'=>82,'altura'=>90,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
">
                    </div>

                    <div class="mycart-content-description">
                        <p class="mycart-content-name">
                            <?php echo utf8_decode($_smarty_tpl->tpl_vars['dadosProduto']->value['nome']);?>
                                                        
                        </p>
                        <p class="mycart-content-info">
                            <?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['sigla'];?>
                            
                        </p>
                    </div>

                    <div class="mycart-content-amount">
                        <div class="select-item">
                            <span class="amount-selected"><?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['quantidade'];?>
</span>
                            <?php if ($_smarty_tpl->getVariable('valor_produto')->value==0){?>
                                <select name="amount" disabled>
                                <?php }else{ ?>
                                    <select name="amount" data-tipo="<?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['tipo'];?>
">
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['dadosProduto']->value['tipo']!=9){?>
                                        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['estoque'];?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['item']->step = 1;$_smarty_tpl->tpl_vars['item']->total = (int)min(ceil(($_smarty_tpl->tpl_vars['item']->step > 0 ? $_tmp1+1 - (1) : 1-($_tmp1)+1)/abs($_smarty_tpl->tpl_vars['item']->step)),10);
if ($_smarty_tpl->tpl_vars['item']->total > 0){
for ($_smarty_tpl->tpl_vars['item']->value = 1, $_smarty_tpl->tpl_vars['item']->iteration = 1;$_smarty_tpl->tpl_vars['item']->iteration <= $_smarty_tpl->tpl_vars['item']->total;$_smarty_tpl->tpl_vars['item']->value += $_smarty_tpl->tpl_vars['item']->step, $_smarty_tpl->tpl_vars['item']->iteration++){
$_smarty_tpl->tpl_vars['item']->first = $_smarty_tpl->tpl_vars['item']->iteration == 1;$_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration == $_smarty_tpl->tpl_vars['item']->total;?>
                                            <?php if ($_smarty_tpl->tpl_vars['dadosProduto']->value['quantidade']==$_smarty_tpl->tpl_vars['item']->value){?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
" selected><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
                                            <?php }else{ ?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
                                            <?php }?>
                                        <?php }} ?>
                                    <?php }else{ ?>
                                        <option value="1" selected>1</option>
                                    <?php }?>
                                </select>
                        </div>
                    </div>

                    <div class="mycart-content-value">
                        <p>
                            <?php if ($_smarty_tpl->getVariable('valor_produto')->value==0){?>
                                Grátis
                            <?php }else{ ?>
                                R$ <?php echo number_format($_smarty_tpl->tpl_vars['dadosProduto']->value['total_produto'],2,",",".");?>

                            <?php }?>
                        </p>
                    </div>

                    <div class="mycart-content-desconto">
                        <p>
                            R$ <?php echo number_format($_smarty_tpl->getVariable('desconto')->value,2,",",".");?>

                        </p>
                    </div>

                    <div class="mycart-content-total">
                        <p>
                            <?php if ($_smarty_tpl->getVariable('valor_produto')->value==0){?>
                                Grátis
                            <?php }else{ ?>
                                R$ <?php echo number_format($_smarty_tpl->tpl_vars['dadosProduto']->value['valor_total_desconto'],2,",",".");?>

                            <?php }?>
                        </p>
                    </div>

                    <div class="mycart-content-remove">
                        <a title="Remover produto" class="remove-product" href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['idestoque'];?>
<?php $_tmp2=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idestoque"=>$_tmp2),'removercarrinho',true);?>
">Remover Item</a>
                    </div>
                </li>
            <?php }else{ ?>
                <?php $_smarty_tpl->tpl_vars["foto"] = new Smarty_variable(($_smarty_tpl->tpl_vars['dadosProduto']->value['codigo']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["extensao"] = new Smarty_variable(($_smarty_tpl->tpl_vars['dadosProduto']->value['path']), null, null);?>
                <?php $_smarty_tpl->tpl_vars["foto_completa"] = new Smarty_variable(($_smarty_tpl->getVariable('foto')->value).".".($_smarty_tpl->getVariable('extensao')->value), null, null);?>
                <li class="mycart-content-item" data-idproduto="<?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['codigo'];?>
" data-valorproduto="<?php echo $_smarty_tpl->getVariable('valor_produto')->value;?>
" data-desconto="<?php echo $_smarty_tpl->getVariable('desconto')->value;?>
">
                    <div class="mycart-content-img">
                        <img src="<?php echo $_smarty_tpl->getVariable('this')->value->Url(array('tipo'=>"produtos",'crop'=>1,'largura'=>82,'altura'=>90,'imagem'=>$_smarty_tpl->getVariable('foto_completa')->value),"imagem",true);?>
">
                    </div>

                    <div class="mycart-content-description">
                        <p class="mycart-content-name"><?php echo utf8_decode($_smarty_tpl->tpl_vars['dadosProduto']->value['nome']);?>
</p>
                        <p class="mycart-content-info">
                            <?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['sigla'];?>

                            <input type="text" class="field" name="emailganhadoraux" id="emailganhadoraux" onchange="changeEmailGanhador()"  placeholder="Insira o email do ganhador" style="width: 70%; padding: 5px;   border: 1px solid; border-color: #6EC6A4;">
                        </p>
                    </div>

                    <div class="mycart-content-amount">
                        <div class="select-item">
                            <span class="amount-selected"><?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['quantidade'];?>
</span>
                            <?php if ($_smarty_tpl->getVariable('valor_produto')->value==0){?>
                                <select name="amount" disabled>
                                <?php }else{ ?>
                                    <select name="amount" data-tipo="<?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['tipo'];?>
">
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['dadosProduto']->value['tipo']!=9){?>
                                        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['estoque'];?>
<?php $_tmp3=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['item']->step = 1;$_smarty_tpl->tpl_vars['item']->total = (int)min(ceil(($_smarty_tpl->tpl_vars['item']->step > 0 ? $_tmp3+1 - (1) : 1-($_tmp3)+1)/abs($_smarty_tpl->tpl_vars['item']->step)),10);
if ($_smarty_tpl->tpl_vars['item']->total > 0){
for ($_smarty_tpl->tpl_vars['item']->value = 1, $_smarty_tpl->tpl_vars['item']->iteration = 1;$_smarty_tpl->tpl_vars['item']->iteration <= $_smarty_tpl->tpl_vars['item']->total;$_smarty_tpl->tpl_vars['item']->value += $_smarty_tpl->tpl_vars['item']->step, $_smarty_tpl->tpl_vars['item']->iteration++){
$_smarty_tpl->tpl_vars['item']->first = $_smarty_tpl->tpl_vars['item']->iteration == 1;$_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration == $_smarty_tpl->tpl_vars['item']->total;?>
                                            <?php if ($_smarty_tpl->tpl_vars['dadosProduto']->value['quantidade']==$_smarty_tpl->tpl_vars['item']->value){?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
" selected><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
                                            <?php }else{ ?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
                                            <?php }?>
                                        <?php }} ?>
                                    <?php }else{ ?>
                                        <option value="1" selected>1</option>
                                    <?php }?>
                                </select>
                        </div>
                    </div>

                    <div class="mycart-content-value">
                        <p>
                            <?php if ($_smarty_tpl->getVariable('valor_produto')->value==0){?>
                                Grátis
                            <?php }else{ ?>
                                R$ <?php echo number_format($_smarty_tpl->tpl_vars['dadosProduto']->value['total_produto'],2,",",".");?>

                            <?php }?>
                        </p>
                    </div>

                    <div class="mycart-content-desconto">
                        <p>
                            R$ 0
                        </p>
                    </div>

                    <div class="mycart-content-total">
                        <p>
                            R$ 0
                        </p>
                    </div>

                    <div class="mycart-content-remove">
                        <a title="Remover produto" class="remove-product" href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['codigo'];?>
<?php $_tmp4=ob_get_clean();?><?php echo $_smarty_tpl->getVariable('this')->value->url(array("idproduto"=>$_tmp4),'removercarrinho',true);?>
">Remover Item</a>
                    </div>
                </li>
            <?php }?>
        <?php }} ?>
    </ul>

    <div id="mycart-subtotal-carrinho" class="clearfix"  data-usuario="<?php echo $_smarty_tpl->getVariable('tipo_usuario')->value;?>
" data-quantidade="<?php echo $_smarty_tpl->getVariable('quantidade_total')->value;?>
" data-subtotal="<?php echo $_smarty_tpl->getVariable('subtotal')->value;?>
" data-cep="<?php echo $_smarty_tpl->getVariable('info')->value['DS_CEP_CASO'];?>
" data-frete="<?php echo $_smarty_tpl->getVariable('frete')->value;?>
" data-desconto="<?php echo $_smarty_tpl->getVariable('valor_desconto')->value;?>
" data-total="<?php echo $_smarty_tpl->getVariable('total')->value;?>
">
        <p>
            <span class="left total-itens">
                TOTAL DE ITENS
            </span>
            <span class="right total-itens">
                <?php echo $_smarty_tpl->getVariable('quantidade_total')->value;?>

            </span>
        </p> <br />
        <p>
            <span class="left">
                SUB TOTAL
            </span>
            <span class="right">
                R$ <?php echo number_format($_smarty_tpl->getVariable('subtotal')->value,2,",",".");?>

            </span>
        </p>
    </div>

    <div class="clearfix"></div>

    <div class="mycart-buttons clearfix">
        <a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),"todos-produtos",true);?>
" class="mycart-button carrinho voltar">Comprar mais</a>
        <a href="#" class="mycart-button carrinho avancar">Avançar</a>
    </div>
</div>
<div class="carrinho-pagamento" style="display: none;">
    <form id="mycart-payment" action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),"fazerpedido2",true);?>
" method="post">
        <input type="hidden" name="emailganhador" id="emailganhador" value=""/>
        <h2 class="rvb-title">Endereço de Envio</h2>
        <ul id="mycart-address-list">
            <!--
            Lista com elementos com endereços
            Elemento ativo precisa vir com:
            - checked="true" no input radio
            - Texto "Endereço selecionado" no span
            - class="active" no elemento de list (li)
            -->
            <li class="mycart-address-item active" data-cep="<?php echo $_smarty_tpl->getVariable('info')->value['DS_CEP_CASO'];?>
" data-endereco_id="0">
                <p class="mycart-address-text">
                    <strong><?php echo $_smarty_tpl->getVariable('info')->value['DS_NOME_CASO'];?>
</strong> <br>
                    <?php echo $_smarty_tpl->getVariable('this')->value->utf8($_smarty_tpl->getVariable('info')->value['DS_ENDERECO_CASO']);?>
, <?php echo $_smarty_tpl->getVariable('info')->value['DS_NUMERO_CASO'];?>
 <?php if ($_smarty_tpl->getVariable('info')->value['DS_COMPLEMENTO_CASO']){?> - <?php echo $_smarty_tpl->getVariable('info')->value['DS_COMPLEMENTO_CASO'];?>
<?php }?> <br>
                    <?php echo $_smarty_tpl->getVariable('info')->value['DS_BAIRRO_CASO'];?>
 <br>
                    <?php echo $_smarty_tpl->getVariable('info')->value['DS_CIDADE_CASO'];?>
 <?php echo $_smarty_tpl->getVariable('info')->value['DS_UF_CASO'];?>
 - <?php echo $_smarty_tpl->getVariable('info')->value['DS_CEP_CASO'];?>

                </p>
                <label class="mycart-use-address">
                    <span>Endereço selecionado</span>
                    <input type="hidden" name="usar_mesmo" value="1" />
                </label>
                <!-- <button class="mycart-edit-address"> Editar </button> -->
            </li>
            <?php  $_smarty_tpl->tpl_vars['endereco'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dadosEnderecos')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['endereco']->key => $_smarty_tpl->tpl_vars['endereco']->value){
?>
                <li class="mycart-address-item" data-cep="<?php echo $_smarty_tpl->getVariable('endereco')->value->DS_CEP_ENRC;?>
" data-endereco_id="<?php echo $_smarty_tpl->getVariable('endereco')->value->NR_SEQ_ENDERECO_ENRC;?>
">
                    <p class="mycart-address-text">
                        <strong><?php echo $_smarty_tpl->getVariable('endereco')->value->DS_DESTINATARIO_ENRC;?>
</strong> <br>
                        <?php echo $_smarty_tpl->getVariable('this')->value->utf8($_smarty_tpl->getVariable('endereco')->value->DS_ENDERECO_ENRC);?>
, <?php echo $_smarty_tpl->getVariable('endereco')->value->DS_NUMERO_ENRC;?>
 <?php if ($_smarty_tpl->getVariable('endereco')->value->DS_COMPLEMENTO_ENRC){?> - <?php echo $_smarty_tpl->getVariable('endereco')->value->DS_COMPLEMENTO_ENRC;?>
<?php }?> <br>
                        <?php echo $_smarty_tpl->getVariable('endereco')->value->DS_BAIRRO_ENRC;?>
 <br>
                        <?php echo $_smarty_tpl->getVariable('endereco')->value->DS_CIDADE_ENRC;?>
 <?php echo $_smarty_tpl->getVariable('endereco')->value->DS_UF_ENRC;?>
 - <?php echo $_smarty_tpl->getVariable('endereco')->value->DS_CEP_ENRC;?>

                    </p>
                    <label class="mycart-use-address">
                        <span>Usar esse endereço</span>
                    </label>
                    <button class="mycart-edit-address"> Editar </button>
                </li>
            <?php }} ?>
            <li class="mycart-address-item new-address">
                <a href="#" class="mycart-new-address md-trigger" data-modal="newaddress-lightbox"> + Outro Endereço </a>
            </li>
        </ul>


        <div class="md-modal md-effect-1" id="newaddress-lightbox">
            <div class="md-content">
                <p class="md-title">Endereço de entrega</p>
                <a href="#" class="md-close ir">Fechar</a>
                <div class="exter">
                    <div class="md-bg">
                        <div class="col">
                            <input type="hidden" name="endereco_id" />
                            <input class="field" type="text" id="newaddress-nome" name="endereco_nome" placeholder="Nome*">

                            <input class="field" type="text" id="newaddress-cep" name="endereco_cep" placeholder="CEP*">
                            <button type="button" id="newaddress-pesquisa">Pesquisar</button>

                            <input class="field" type="text" id="newaddress-endereco" name="endereco_endereco" placeholder="Endereço*">
                            <input class="field" type="text" id="newaddress-numero" name="endereco_numero" placeholder="Número*">

                            <input class="field" type="text" id="newaddress-complemento" name="endereco_complemento" placeholder="Complemento">
                            <input class="field" type="text" id="newaddress-bairro" name="endereco_bairro" placeholder="Bairro">

                            <div id="newaddress-estado" class="field fake-select">
                                <span>Estado*</span>
                                <select name="endereco_estado"></select>
                            </div>
                            <div id="newaddress-cidade" class="field fake-select">
                                <span>Cidade*</span>
                                <select name="endereco_cidade"></select>
                            </div>
                        </div>
                        <div class="send-button">
                            <button class="btn" id="btn-cadastrar-end" type="button">Cadastrar</button>
                        </div>
                    </div>
                    <p class="md-description">
                        Caso haja algum problema, entre em contato através do 
                        <a href="mailto:atendimento@reverbcity.com" target="_blank">atendimento@reverbcity.com</a>
                    </p>

                </div>
            </div>
        </div>
        <div class="md-overlay"></div> <!-- overlay para desbugar o modal -->

        <h2 class="rvb-title frete-title">Frete</h2>
        <div id="mycart-delivery-container">
            <div id="mycart-delivery-header">
                <span class="header-envio">Forma de envio</span>
                <span class="header-prazo">Prazo de entrega</span>
                <span class="header-valor">Valor do frete</span>
            </div>

            <ul id="mycart-delivery-list">
                <li class="mycart-delivery-item">
                    <div class="loader ir">Carregando</div>
                </li>

                <li class="mycart-delivery-item">
                    <label class="mycart-delivery-radio">
                        <input type="radio" name="forma_envio" value="5" />
                        <span class="radio-icon"></span>
                        <span class="label">Correios Registrado</span>
                    </label>

                    <p class="mycart-delivery-time">
                        --
                    </p>

                    <p class="mycart-delivery-value">
                        R$ --
                    </p>
                </li>

                <li class="mycart-delivery-item">
                    <label class="mycart-delivery-radio">
                        <input type="radio" name="forma_envio" value="3" />
                        <span class="radio-icon"></span>
                        <span class="label">E-Sedex</span>
                    </label>

                    <p class="mycart-delivery-time">
                        --
                    </p>

                    <p class="mycart-delivery-value">
                        R$ --
                    </p>
                </li>

                <li class="mycart-delivery-item">
                    <label class="mycart-delivery-radio">
                        <input type="radio" name="forma_envio" value="1" />
                        <span class="radio-icon"></span>
                        <span class="label">Pac</span>
                    </label>

                    <p class="mycart-delivery-time">
                        --
                    </p>

                    <p class="mycart-delivery-value">
                        R$ --
                    </p>
                </li>

                <li class="mycart-delivery-item">
                    <label class="mycart-delivery-radio">
                        <input type="radio" name="forma_envio" value="4" />
                        <span class="radio-icon"></span>
                        <span class="label">TAM</span>
                    </label>

                    <p class="mycart-delivery-time">
                        --
                    </p>

                    <p class="mycart-delivery-value">
                        R$ --
                    </p>
                </li>

                <li class="mycart-delivery-item">
                    <label class="mycart-delivery-radio">
                        <input type="radio" name="forma_envio" value="2" />
                        <span class="radio-icon"></span>
                        <span class="label">Sedex</span>
                    </label>

                    <p class="mycart-delivery-time">
                        --
                    </p>

                    <p class="mycart-delivery-value">
                        R$ --
                    </p>
                </li>

                <li class="mycart-delivery-item">
                    <label class="mycart-delivery-radio">
                        <input type="radio" name="forma_envio" value="" />
                        <span class="radio-icon"></span>
                        <span class="label">Grátis</span>
                    </label>

                    <p class="mycart-delivery-time">
                        --
                    </p>

                    <p class="mycart-delivery-value">
                        R$ 0,00
                    </p>
                </li>
            </ul>
        </div>

        <h2 class="rvb-title">Possui cupom de desconto?</h2>
        <div id="mycart-discount-container">
            <div id="mycart-discount-header">
                <span class="header-valor">
                    Valor do desconto
                </span>
            </div>

            <div id="mycart-discount">
                <div id="mycart-discount-fields">
                    <input name="cupom" id="cupomcode" type="text" placeholder="Insira o código" />
                    <button id="mycart-discount-button" type="button">Atualizar</button>
                </div>

                <div id="mycart-discount-value">
                    R$ 0,00
                </div>
            </div>
        </div>

        <h2 class="rvb-title pagamento-title">Pagamento</h2>
        <div id="mycart-payment-container">
            <ul id="mycart-payment-list">
                <li class="mycart-payment-item">
                    <label class="mycart-payment-radio">
                        <input type="radio" name="formapagto" value="boleto" />
                        <span class="radio-icon"></span>
                        <div class="mycart-payment-flags">
                            <img src="<?php echo $_smarty_tpl->getVariable('basePath')->value;?>
/arquivos/default/images/selos-pagamentos@2x/boleto.png" width="45" height="29" alt="Boleto">
                        </div>
                        <span class="label">Boleto bancário</span>
                    </label>
                </li>
                <li class="mycart-payment-item payment-card">
                    <label class="mycart-payment-radio">
                        <input type="radio" name="formapagto" value="" /><!-- Esse value deve mudar de acordo com a bandeira do cartao -->
                        <span class="radio-icon"></span>
                        <div class="mycart-payment-flags cards">
                            <img src="<?php echo $_smarty_tpl->getVariable('basePath')->value;?>
/arquivos/default/images/selos-pagamentos@2x/visa.png" data-cartao="visa" width="45" height="29" alt="Cartão de crédito - Visa">
                            <img src="<?php echo $_smarty_tpl->getVariable('basePath')->value;?>
/arquivos/default/images/selos-pagamentos@2x/master.png" data-cartao="mastercard" width="45" height="29" alt="Cartão de crédito - Mastercard">
                            <img src="<?php echo $_smarty_tpl->getVariable('basePath')->value;?>
/arquivos/default/images/selos-pagamentos@2x/american-express.png" data-cartao="amex" width="45" height="29" alt="Cartão de crédito - American Express">
                            <!-- <img src="<?php echo $_smarty_tpl->getVariable('basePath')->value;?>
/arquivos/default/images/selos-pagamentos@2x/diners.png" data-cartao="diners" width="45" height="29" alt="Cartão de crédito - Diners"> -->
                        </div>
                        <span class="label">Cartões de crédito</span>
                    </label>

                    <div class="mycart-payment-fields">
                        <div class="field-group">

                            <label for="numero_cartao">Número do cartão</label>
                            <input class="field" type="text" id="numero_cartao" onkeypress="return isNumberKey(event)" name="numero_cartao" maxlength="16" placeholder="0000-0000-0000-0000" autocomplete="off" />

                        </div>

                        <div class="clearfix"></div>

                        <div class="field-group">

                            <label for="nome_portador">Nome do portador</label>
                            <input class="field" type="text" id="nome_portador" name="nome_portador" placeholder="NOME DO PORTADOR" autocomplete="off" />

                        </div>

                        <div class="clearfix"></div>

                        <div class="field-group">
                            <label>Vencimento</label>
                            <div id="vencimento_mes" class="field fake-select">
                                <span>01</span>
                                <select id="select_mes" name="vencimento_mes">
                                    <option value="01" selected="selected">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div id="vencimento_ano" class="field fake-select">
                                <span>2015</span>
                                <select id="select_ano" name="vencimento_ano">
                                    <option value="2015" selected="selected">2015</option>
                                    <option value="2016">2016</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                </select>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="field-group">
                            <label for="cod_seguranca">Cód. segurança</label>
                            <input class="field" type="text" onkeypress="return isNumberKey(event)" id="cod_seguranca" name="cod_seguranca" maxlength="4" autocomplete="off" placeholder="000" />
                            <a href="#" class="question-icon md-trigger" data-modal="codigo-lightbox" title="O que é isso?">O que é</a>
                        </div>

                        <div class="clearfix"></div>

                        <div class="field-group">
                            <label>Parcelamento</label>
                            <div class="field fake-select">
                                <span>Escolha o frete antes</span>
                                <select name="parcelamento">
                                </select>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <p class="mycart-payment-description">
                            Nenhuma informação do seu cartão ficará salva no nosso banco de dados. <br />
                            Trabalhamos com um <a href="https://security.trustsign.com.br/?url=www.reverbcity.com" target="_blank">protocolo criptografado</a> que garante a segurança da informação. <br />
                            <br />
                            As compras podem passar por uma verificação de autenticidade do titular do cartão e <br />
                            a compra, passa a valer apenas após a confirmação dos dados pela operadora.
                        </p>

                    </div>
                </li>
            </ul>
        </div>

        <div id="mycart-subtotal" class="clearfix" data-usuario="<?php echo $_smarty_tpl->getVariable('tipo_usuario')->value;?>
" data-quantidade="<?php echo $_smarty_tpl->getVariable('quantidade_total')->value;?>
" data-subtotal="<?php echo $_smarty_tpl->getVariable('subtotal')->value;?>
" data-cep="<?php echo $_smarty_tpl->getVariable('info')->value['DS_CEP_CASO'];?>
" data-frete="<?php echo $_smarty_tpl->getVariable('frete')->value;?>
" data-desconto="<?php echo $_smarty_tpl->getVariable('valor_desconto')->value;?>
" data-total="<?php echo $_smarty_tpl->getVariable('total')->value;?>
">
            <p>
                <span class="left">
                    SUBTOTAL
                </span>
                <span class="right">
                    R$ <?php echo number_format($_smarty_tpl->getVariable('total')->value,2,",",".");?>

                </span>
            </p>
            <p>
                <span class="left">
                    FRETE
                </span>
                <span class="right">
                    + R$0,00
                </span>
            </p>
            <p>
                <span class="left">
                    DESCONTOS
                </span>
                <span class="right">
                    - R$0,00
                </span>
            </p>

            <hr>

            <p class="bold">
                <span class="left">
                    TOTAL
                </span>
                <span class="right">
                    R$ <?php echo number_format($_smarty_tpl->getVariable('dadosProduto')->value['total_produto'],2,",",".");?>

                </span>
            </p>
        </div>

        <div class="clearfix"></div>

        <div class="mycart-buttons clearfix">
            <a href="#" class="mycart-button pedido voltar">Voltar</a>
            <a href="#" class="mycart-button pedido avancar md-trigger" data-modal="carregando-lightbox">Avançar</a>
        </div>
    </form>
    <script type="text/javascript">
        function changeEmailGanhador() {
            var x = document.getElementById("emailganhadoraux").value;
            document.getElementById("emailganhador").value = x;
        }
    </script>
</div>

</div>

<div class="md-modal md-effect-1" id="codigo-lightbox">
    <div class="md-content">
        <p class="md-title">Código de segurança</p>
        <button class="md-close ir">Fechar</button>
        <div class="exter">
            <div class="md-bg">
                <p class="md-description">

                </p>

                <img src="<?php echo $_smarty_tpl->getVariable('basePath')->value;?>
/arquivos/default/images/icon@2x/codigo_cartao.jpg" width="188" height="122" alt="Cartão de crédito - Visa">
            </div>
            <p class="md-description">
                Caso haja algum problema, entre em contato através do 
                <a href="mailto:atendimento@reverbcity.com" target="_blank">atendimento@reverbcity.com</a>
            </p>
        </div>
    </div>
</div>

<div class="md-modal md-effect-1" id="carregando-lightbox">
    <div class="md-content">
        <p class="md-title">Aguarde..</p>
        <div class="exter">
            <div class="md-bg">
                <img src="<?php echo $_smarty_tpl->getVariable('basePath')->value;?>
/arquivos/default/images/loader.gif" width="32" height="32" alt="Carregando" style="margin-left: auto; margin-right: auto; width: 32px; display: block;">
                <p class="md-description">
                    Por favor, não atualize a página! <br />
                    Estamos processando sua compra. Esta operação pode demorar alguns segundos.
                    <br /><br/>
                    Em caso de dúvidas acesses <a href="https://www.reverbcity.com/minhas-compras">Minhas Compras</a> para ver seus pedidos.
                </p>
            </div>
            <p class="md-description">
                Caso haja algum problema, entre em contato através do
                <a href="mailto:atendimento@reverbcity.com" target="_blank">atendimento@reverbcity.com</a>
            </p>
        </div>
    </div>
</div>
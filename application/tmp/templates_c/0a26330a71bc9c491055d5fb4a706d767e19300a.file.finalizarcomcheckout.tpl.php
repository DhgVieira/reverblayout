<?php /* Smarty version Smarty-3.0.7, created on 2015-10-25 20:30:59
         compiled from "/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/checkout2/finalizarcomcheckout.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1530958735562d5823801ca0-15403149%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0a26330a71bc9c491055d5fb4a706d767e19300a' => 
    array (
      0 => '/users/design/reverbcity/site/reverbcity.com/application/modules/default/views/checkout2/finalizarcomcheckout.tpl',
      1 => 1445396240,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1530958735562d5823801ca0-15403149',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="my-cart-steps clearfix">
    <div class="steps step-1">Etapa 1 - Carrinho</div>
    <div class="steps step-2">Etapa 2 - Endereço / Pagamento</div>
    <div class="steps step-3 current">Etapa 3 - Confirmação</div>
</div>

<h2 class="rvb-title">
    <?php if ($_smarty_tpl->getVariable('compra')->value->DS_FORMAPGTO_COSO!='boleto'&&$_smarty_tpl->getVariable('compra')->value->ST_COMPRA_COSO!='P'&&$_smarty_tpl->getVariable('compra')->value->ST_COMPRA_COSO!='A'){?>
        Ops! Algo deu errado :(
    <?php }else{ ?>
        Obrigado pelo seu pedido!
    <?php }?>
</h2>

<hr class="mycart-border">

<div id="mycart-demand">
    <a href="https://www.reverbcity.com/minhas-compras">Pedido número: <strong><?php echo $_smarty_tpl->getVariable('pedido')->value;?>
</strong></a>
</div>

<?php if ($_smarty_tpl->getVariable('compra')->value->DS_FORMAPGTO_COSO!='boleto'&&$_smarty_tpl->getVariable('compra')->value->ST_COMPRA_COSO!='P'&&$_smarty_tpl->getVariable('compra')->value->ST_COMPRA_COSO!='A'){?>
    <a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'carrinho',true);?>
" class="mycart-button avancar" style="float: right; margin-top: 30px; width: 275px;">Escolher nova forma de pagamento</a>
<?php }?>
<div class="clearfix"></div>

<div id="mycart-text">
    <p>
        <?php if ($_smarty_tpl->getVariable('compra')->value->ST_COMPRA_COSO=='P'){?>
            <br /><br /><strong>Seu pedido foi aprovado!</strong> e já estamos separando sua compra aqui na Reverbcity!<br />
            Assim que seu pedido for enviado, você receberá no seu email o código de rastreamento e atualizações sobre o percurso do sua encomenda.
        <?php }elseif($_smarty_tpl->getVariable('compra')->value->ST_COMPRA_COSO=='C'){?>
            <?php if ($_smarty_tpl->getVariable('compra')->value->DS_FORMAPGTO_COSO!='boleto'){?>
                <br /><br />Sua compra não foi aprovada pela administradora do seu cartão de crédito e seu pedido ainda não foi finalizado.<br />
                Você pode <strong><a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'carrinho',true);?>
">Clicar Aqui</a></strong> e escolher outra forma de pagamento.
            <?php }?>
        <?php }else{ ?>
            <?php if ($_smarty_tpl->getVariable('compra')->value->DS_FORMAPGTO_COSO!='boleto'){?>
                <br /><br />Pedido Recebido na Reverbcity. <strong>Aguardando Confirmação de Pagamento.</strong><br/>
                A equipe da Reverbcity já está quase pronta para dar o play no seu pedido, mas antes da música começar <br/>
                precisamos fazer a confirmação do seu pagamento.
            <?php }?>
        <?php }?>

    </p>
    <br>
    <?php if ($_smarty_tpl->getVariable('compra')->value->DS_FORMAPGTO_COSO=='boleto'){?>
        <p>
            Este boleto pode ser pago em qualquer banco ou lotérica até o seu vencimento.
            Pagamentos efetuados em dias úteis são confirmados no dia seguinte e pagamentos efetuados durante os fins de semana e feriados serão confirmados em até dois dias úteis.

        </p>
    <?php }?>
</div>
<?php if ($_smarty_tpl->getVariable('compra')->value->DS_FORMAPGTO_COSO=='boleto'){?>
    <form id="form-finalizar" action="<?php echo $_smarty_tpl->getVariable('this')->value->boleto_url;?>
" method="get" name="pagamento">       
        <input type="submit" value="Imprimir Boleto" id="mycart-print" />
    </form>
<?php }?>
<hr class="mycart-border">

<?php if ($_smarty_tpl->getVariable('compra')->value->DS_FORMAPGTO_COSO=='boleto'||$_smarty_tpl->getVariable('compra')->value->ST_COMPRA_COSO=='P'){?>
    <div id="mycart-confirm-message">
        <a href="#" class="md-trigger" data-modal="indicar-lightbox">
            <img pagespeed_no_transform src="<?php echo $_smarty_tpl->getVariable('basePath')->value;?>
/arquivos/default/images/mycart_confirm_M.png">
        </a>
    </div>
    <div id="mycart-confirm-total">
        <p>
            <strong>Entrega</strong> <br>
            <?php echo $_smarty_tpl->getVariable('enderecoCompra')->value->nome;?>
 <br>
            <?php echo $_smarty_tpl->getVariable('enderecoCompra')->value->endereco;?>
, <?php echo $_smarty_tpl->getVariable('enderecoCompra')->value->numero;?>
 | <?php echo $_smarty_tpl->getVariable('enderecoCompra')->value->complemento;?>
 <br>
            <?php echo $_smarty_tpl->getVariable('enderecoCompra')->value->bairro;?>
 <br>
            <?php echo $_smarty_tpl->getVariable('enderecoCompra')->value->cidade;?>
 - <?php echo $_smarty_tpl->getVariable('enderecoCompra')->value->estado;?>
 <br>
            <?php echo $_smarty_tpl->getVariable('enderecoCompra')->value->cep;?>

        </p>

        <p>
            <strong>Resumo do pedido</strong> <br>
            <?php  $_smarty_tpl->tpl_vars['dadosProduto'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('carrinho')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dadosProduto']->key => $_smarty_tpl->tpl_vars['dadosProduto']->value){
?>
                <?php if ($_smarty_tpl->tpl_vars['dadosProduto']->value['valor_total_desconto']){?>
                    <?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['quantidade'];?>
 <?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['nome'];?>
 - <?php echo number_format($_smarty_tpl->tpl_vars['dadosProduto']->value['total_produto'],2,",",".");?>
<br>
                    <?php $_smarty_tpl->tpl_vars['totalProduto'] = new Smarty_variable($_smarty_tpl->getVariable('totalProduto')->value+$_smarty_tpl->tpl_vars['dadosProduto']->value['valor_total_desconto'], null, null);?>
                <?php }else{ ?>
                    <?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['quantidade'];?>
 <?php echo $_smarty_tpl->tpl_vars['dadosProduto']->value['nome'];?>
 - <?php echo number_format($_smarty_tpl->tpl_vars['dadosProduto']->value['total_produto'],2,",",".");?>
<br>
                    <?php $_smarty_tpl->tpl_vars['totalProduto'] = new Smarty_variable($_smarty_tpl->getVariable('totalProduto')->value+$_smarty_tpl->tpl_vars['dadosProduto']->value['total_produto'], null, null);?>
                <?php }?>

            <?php }} ?>
        </p>

        <p>
            <strong>Valores</strong> <br>
            Produtos: R$ <?php echo number_format($_smarty_tpl->getVariable('totalProduto')->value,2,",",".");?>
 <br>
            <?php if ($_smarty_tpl->getVariable('desconto_promo')->value){?>
                Descontos: R$ <?php echo number_format($_smarty_tpl->getVariable('desconto_promo')->value,2,",",".");?>
 <br>
            <?php }else{ ?>
                Descontos: R$ <?php echo number_format($_smarty_tpl->getVariable('compra')->value->VL_DESCONTO_COSO,2,",",".");?>
 <br>
            <?php }?>
            Frete: R$ <?php echo number_format($_smarty_tpl->getVariable('compra')->value->VL_FRETE_COSO,2,",",".");?>

        </p>

        <p>
            <strong>TOTAL: R$ <?php echo number_format($_smarty_tpl->getVariable('compra')->value->VL_TOTAL_COSO,2,",",".");?>
</strong>
        </p>

        <p>
            <strong>Forma de pagamento: </strong><?php echo ucfirst($_smarty_tpl->getVariable('compra')->value->DS_FORMAPGTO_COSO);?>
</strong> <br>
            <!-- Prazo de entrega: <strong>3 dias úteis após a confirmação do pagamento</strong> -->

            <?php if ($_smarty_tpl->getVariable('compra')->value->DS_FORMAPGTO_COSO!='boleto'){?>
                <?php if ($_smarty_tpl->getVariable('compra')->value->NR_PARCELAS_COSO==1){?>
                    <strong>Pagamento à vista</strong>: R$ <?php echo number_format($_smarty_tpl->getVariable('total_fim')->value,2,",",".");?>

                <?php }else{ ?>
                    <?php $_smarty_tpl->tpl_vars["valor_parcela"] = new Smarty_variable((($_smarty_tpl->getVariable('total_fim')->value/$_smarty_tpl->getVariable('compra')->value->NR_PARCELAS_COSO)), null, null);?>
                    <strong>Pagamento em <?php echo $_smarty_tpl->getVariable('compra')->value->NR_PARCELAS_COSO;?>
 vezes de :</strong> R$ <?php echo number_format($_smarty_tpl->getVariable('valor_parcela')->value,2,",",".");?>

                <?php }?>
            <?php }?>
        </p>
        <?php if ($_smarty_tpl->getVariable('compra')->value->DS_FORMAPGTO_COSO=='boleto'||($_smarty_tpl->getVariable('compra')->value->ST_COMPRA_COSO=='P'&&$_smarty_tpl->getVariable('compra')->value->ST_COMPRA_COSO=='C')){?>
            <a href="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),'todos-produtos',true);?>
" class="mycart-button avancar">Voltar para a loja</a>
        <?php }?>
    </div>
<?php }?>
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

<div class="md-modal md-effect-1" id="indique-lightbox">
    <div class="md-content">
        <p class="md-title">INDIQUE AMIGOS E GANHE DESCONTOS!</p>
        <button class="md-close ir">Fechar</button>
        <div class="exter">
            <form action="<?php echo $_smarty_tpl->getVariable('this')->value->url(array(),"avisemeproduto",true);?>
" method="POST">
                <div class="md-bg">
                    <p class="md-description">
                        Coisas boas a gente compartilha com os amigos! Que tal indicar a Reverbcity e ganhar descontos nas suas próximas compras?
                    </p>
                    <div class="col">
                        <input class="field" type="text" id="indique-nome" name="nome" placeholder="Seu Nome">
                        <input class="field" type="text" id="indique-email" name="nome" placeholder="Seu Email">

                        <input class="field" type="text" id="indique-nome-amigo" name="nome_amigo" placeholder="Nome do Amigo">
                        <input class="field" type="text" id="indique-email-amigo" name="nome_amigo" placeholder="Email do Amigo">

                        <textarea class="field" id="indique-mensagem" name="mensagem" placeholder="Mensagem" cols="30" rows="10"></textarea>
                    </div>
                    <div class="send-button">
                        <button class="btn" type="submit">Cadastrar</button>
                    </div>
                </div>
            </form>
            <p class="md-description">
                Caso haja algum problema, entre em contato através do
                <a href="mailto:atendimento@reverbcity.com" target="_blank">atendimento@reverbcity.com</a>
            </p>

        </div>
    </div>
</div>                                
<div id="container-modal-boleto-overlay"></div>
<div id="modal-boleto"></div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        alert('Teste');
    });
</script>
<!-- Google Code for Compra Conversion Page -->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 1047813471;
    var google_conversion_language = "pt";
    var google_conversion_format = "2";
    var google_conversion_color = "ffffff";
    var google_conversion_label = "BHLMCOn_2gQQ37rR8wM";
    var google_conversion_value = <?php echo number_format($_smarty_tpl->getVariable('total_fim')->value,0,'','');?>
;
    var google_conversion_currency = "BRL";
    var google_remarketing_only = false;
    /* ]]> */
</script>
<div style="display: none;">
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="Conversion" src="//www.googleadservices.com/pagead/conversion/1047813471/?value=<?php echo number_format($_smarty_tpl->getVariable('total_fim')->value,0,'','');?>
&amp;currency_code=BRL&amp;label=BHLMCOn_2gQQ37rR8wM&amp;guid=ON&amp;script=0"/>
    </div>
    </noscript>
</div>
{if $compra->DS_FORMAPGTO_COSO eq "boleto"}
<form id="form-finalizar" action="https://www16.bancodobrasil.com.br/site/mpag/" method="post" name="pagamento">
    <input type="hidden" name="idConv" value="303990" />
    <input type="hidden" name="refTran" value="{$refTran}" />
    <input type="hidden" name="valor" value="{$vlTran}" />
    <input type="hidden" name="dtVenc" value="{$t}"/>
    <input type="hidden" name="tpPagamento" value="2" />
    <input type="hidden" name="urlRetorno" value="/" />
    <input type="hidden" name="urlInforma" value="RecBol.aspx" />
    <input type="hidden" name="nome" value="{$nome}" />
    <input type="hidden" name="endereco" value="{$endereco}, {$numero}" />
    <input type="hidden" name="cidade" value="{$cidade}" />
    <input type="hidden" name="uf" value="{$estado}" />
    <input type="hidden" name="cep" value="{$cep}" />
    <input type="hidden" name="msgLoja" value="Voce fez uma reverb-compra" />
{elseif $compra->DS_FORMAPGTO_COSO eq "mastercard"}
<form id="form-finalizar" action="{$this->url([], 'registravisa', TRUE)}" method="post" name="pagamento">
    <input type="hidden" name="bin_cartao" value="{$cartao}" />
    <input type="hidden" name="valor" value="{$total}" />
    <input type="hidden" name="pedido" value="{$pedido}" />
    <input type="hidden" name="descricao" value="Pedido {$pedido} Reverbcity"/>
    <input type="hidden" name="bandeira" value="{$bandeira}" />
    <input type="hidden" name="forma_pagamento" value="{$formapg}" />
    <input type="hidden" name="parcelas" value="{$numero_parcelas}" />
    <!-- <a href="{$this->url(["idpedido"=>{$pedido}], "realizarpagamento", TRUE)}" class="footer-button next-step">Finalizar compra</a> -->
{elseif $compra->DS_FORMAPGTO_COSO eq "amex"}
<form id="form-finalizar" action="{$this->url([], 'registravisa', TRUE)}" method="post" name="pagamento">
    <input type="hidden" name="bin_cartao" value="{$cartao}" />
    <input type="hidden" name="valor" value="{$total}" />
    <input type="hidden" name="pedido" value="{$pedido}" />
    <input type="hidden" name="descricao" value="Pedido {$pedido} Reverbcity"/>
    <input type="hidden" name="bandeira" value="{$bandeira}" />
    <input type="hidden" name="forma_pagamento" value="{$formapg}" />
    <input type="hidden" name="parcelas" value="0{$numero_parcelas}" />
    <!-- <a href="{$this->url(["idpedido"=>{$pedido}], "realizarpagamento", TRUE)}" class="footer-button next-step">Finalizar compra</a> -->
{elseif $compra->DS_FORMAPGTO_COSO eq "visa"}
<form id="form-finalizar" action="{$this->url([], 'registravisa', TRUE)}" method="post" name="pagamento">
    <input type="hidden" name="bin_cartao" value="{$cartao}" />
    <input type="hidden" name="valor" value="{$total}" />
    <input type="hidden" name="pedido" value="{$pedido}" />
    <input type="hidden" name="descricao" value="Pedido {$pedido} Reverbcity"/>
    <input type="hidden" name="bandeira" value="{$bandeira}" />
    <input type="hidden" name="forma_pagamento" value="{$formapg}" />
    <input type="hidden" name="parcelas" value="{$numero_parcelas}" />
    <!-- <a href="{$this->url(["idpedido"=>{$pedido}], "realizarpagamento", TRUE)}" class="footer-button next-step">Finalizar compra</a> -->
{elseif $compra->DS_FORMAPGTO_COSO eq "diners"}
<!-- <form id="form-finalizar" action="https://comercio.locaweb.com.br/comercio.comp" method="post" name="redecar"> -->
<!--        <input type="hidden" name="bin_cartao" value="{$cartao}" />
    <input type="hidden" name="valor" value="{$total|number_format:2:"":"."}" />
    <input type="hidden" name="pedido" value="{$pedido}" />
    <input type="hidden" name="descricao" value="Pedido {$pedido} Reverbcity"/>
    <input type="hidden" name="bandeira" value="{$bandeira}" />
    <input type="hidden" name="forma_pagamento" value="{$formapg}" />
    <input type="hidden" name="parcelas" value="{$numero_parcelas}" /> -->
<form id="form-finalizar" action="{$this->url([], 'registravisa', TRUE)}" method="post" name="pagamento">
     <input type="hidden" name="bin_cartao" value="{$cartao}" />
    <input type="hidden" name="valor" value="{$total}" />
    <input type="hidden" name="pedido" value="{$pedido}" />
    <input type="hidden" name="descricao" value="Pedido {$pedido} Reverbcity"/>
    <input type="hidden" name="bandeira" value="{$bandeira}" />
    <input type="hidden" name="forma_pagamento" value="{$formapg}" />
    <input type="hidden" name="parcelas" value="{$numero_parcelas}" />
    <!-- <a href="{$this->url(["idpedido"=>{$pedido}], "realizarpagamento", TRUE)}" class="footer-button next-step">Finalizar compra</a> -->
{elseif $compra->DS_FORMAPGTO_COSO eq "elo"}
<form id="form-finalizar" action="{$this->url([], 'registravisa', TRUE)}" method="post" name="pagamento">
    <input type="hidden" name="bin_cartao" value="{$cartao}" />
    <input type="hidden" name="valor" value="{$total}" />
    <input type="hidden" name="pedido" value="{$pedido}" />
    <input type="hidden" name="descricao" value="Pedido {$pedido} Reverbcity"/>
    <input type="hidden" name="bandeira" value="{$bandeira}" />
    <input type="hidden" name="forma_pagamento" value="{$formapg}" />
    <input type="hidden" name="parcelas" value="{$numero_parcelas}" />
{/if}





<div class="banners-advertisement cycle-slideshow"
     data-cycle-fx="fadeout"
     data-cycle-timeout="5000"
     data-cycle-slides="> a"
     data-cycle-log="false"
     data-cycle-pause-on-hover="true">
    {foreach from=$banners_topo item=banner}
        {assign var="foto" value="{$banner['NR_SEQ_BANNER_BARC']}"}
        {assign var="extensao" value="{$banner['DS_EXT_BARC']}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
        <a href="{$banner['DS_LINK_BARC']}">
            {if file_exists("arquivos/uploads/banners/$foto_completa")}
              <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}"/>
            {else}
              <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}"/>
            {/if}
        </a>
    {/foreach}
</div>

<div class="my-cart-steps clearfix">
    <div class="steps step-1">Etapa 1 - Informações</div>
    <div class="steps step-2">Etapa 2 - Pagamento</div>
    <div class="steps step-3 current">Etapa 3 - Confirmação</div>
</div>

<h1 class="rvb-title">Carrinho de Compras</h1>

<div id="step-3">
    <div class="my-cart-payment-title clearfix">
        <p class="full-strip">Forma de Pagamento escolhida</p>
    </div>
    <div class="my-cart-payment-item current card">
        {if $compra->DS_FORMAPGTO_COSO eq 'boleto'}
            <img src="{$basePath}/arquivos/default/images/selos-pagamentos/boleto.png" alt="Boleto">
            <p class="payment-type">
                <strong>BOLETO BANCÁRIO</strong>
                {if $compra->NR_PARCELAS_COSO eq 1}
                    Pagamento à vista: R$ {$total_fim|number_format:2:",":"."}.
                {else}
                    Pagamento em {$compra->NR_PARCELAS_COSO} vezes de : R$ {$total_fim|number_format:2:",":"."}.
                {/if}

            </p>
        {/if}
        {if $compra->DS_FORMAPGTO_COSO eq 'visa'}
            <img src="{$basePath}/arquivos/default/images/selos-pagamentos/visa.png" alt="Cartão de crédito - Visa">
            <p class="payment-type">
                <strong>CARTÃO VISA</strong>
                {if $compra->NR_PARCELAS_COSO eq 1}
                    Pagamento à vista: R$ {$total_fim|number_format:2:",":"."}.
                {else}
                {assign var="valor_parcela" value="{$total_fim / $compra->NR_PARCELAS_COSO}"}
                    Pagamento em {$compra->NR_PARCELAS_COSO} X de : R$ {$valor_parcela|number_format:2:",":"."}.
                {/if}
            </p>
        {/if}
        {if $compra->DS_FORMAPGTO_COSO eq 'mastercard'}
            <img src="{$basePath}/arquivos/default/images/selos-pagamentos/master.png" alt="Cartão de crédito - Mastercard">
            <p class="payment-type">
                <strong>CARTÃO MASTERCARD</strong>
                {if $compra->NR_PARCELAS_COSO eq 1}
                    Pagamento à vista: R$ {$total_fim|number_format:2:",":"."}.
                {else}
                    {assign var="valor_parcela" value="{$total_fim / $compra->NR_PARCELAS_COSO}"}
                    Pagamento em {$compra->NR_PARCELAS_COSO} X de : R$ {$valor_parcela|number_format:2:",":"."}.
                {/if}
            </p>
        {/if}
        {if $compra->DS_FORMAPGTO_COSO eq 'amex'}
            <img src="{$basePath}/arquivos/default/images/selos-pagamentos/american-express.png" alt="Cartão de crédito - American Express">
            <p class="payment-type">
                <strong>CARTÃO AMERICAN EXPRESS</strong>
                {if $compra->NR_PARCELAS_COSO eq 1}
                    Pagamento à vista: R$ {$total_fim|number_format:2:",":"."}.
                {else}
                    {assign var="valor_parcela" value="{$total_fim / $compra->NR_PARCELAS_COSO}"}
                    Pagamento em {$compra->NR_PARCELAS_COSO} X de : R$ {$valor_parcela|number_format:2:",":"."}.
                {/if}
            </p>
        {/if}
        {if $compra->DS_FORMAPGTO_COSO eq 'diners'}
            <img src="{$basePath}/arquivos/default/images/selos-pagamentos/diners.png" alt="Cartão de crédito - Diners">
            <p class="payment-type">
              <strong>CARTÃO DINERS</strong>
              {if $compra->NR_PARCELAS_COSO eq 1}
                    Pagamento à vista: R$ {$total_fim|number_format:2:",":"."}.
                {else}
                    {assign var="valor_parcela" value="{$total_fim / $compra->NR_PARCELAS_COSO}"}
                    Pagamento em {$compra->NR_PARCELAS_COSO} X de : R$ {$valor_parcela|number_format:2:",":"."}.
                {/if}
            </p>
        {/if}
        {if $compra->DS_FORMAPGTO_COSO eq 'elo'}
            <img src="{$basePath}/arquivos/default/images/selos-pagamentos/elo.png" alt="Cartão de crédito - ELO">
            <p class="payment-type">
              <strong>CARTÃO ELO</strong>
              {if $compra->NR_PARCELAS_COSO eq 1}
                    Pagamento à vista: R$ {$total_fim|number_format:2:",":"."}.
                {else}
                    {assign var="valor_parcela" value="{$total_fim / $compra->NR_PARCELAS_COSO}"}
                    Pagamento em {$compra->NR_PARCELAS_COSO} X de : R$ {$valor_parcela|number_format:2:",":"."}.
                {/if}
            </p>
        {/if}

    </div>
    <div class="my-cart-order-number">
        Pedido número
        <strong>{$pedido}</strong>
    </div>
    <div class="my-cart-payment-title resume clearfix">
        <p class="full-strip">Resumo do Pedido</p>
    </div>
    <div class="my-cart-content-header">
        <p class="my-cart-header-item header-product">Produto</p>
        <p class="my-cart-header-item header-description">Descrição</p>
        <p class="my-cart-header-item header-price">Preço</p>
        <p class="my-cart-header-item header-amount">Quantidade</p>
        <p class="my-cart-header-item header-subtotal">Total</p>
    </div>
    <ul class="my-cart-content-wrapper">
        {foreach from=$carrinho item=dadosProduto}
            {assign var="foto" value="{$dadosProduto['codigo']}"}
            {assign var="extensao" value="{$dadosProduto['path']}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
            
            {assign var="fotos" value=$this->fotoproduto($dadosProduto['codigo'])}
            {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
            {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
            {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
            <li class="my-cart-content-item">
                <div class="content-item product-name">
                    {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                        <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$dadosProduto['titulo']}"/>
                    {else}
                        <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$dadosProduto['titulo']}"/>
                    {/if}
                    <a href="{$this->url(["titulo"=>{$this->createslug($dadosProduto['nome'])}, "idproduto"=>{$dadosProduto['codigo']}], 'produto', TRUE)}">{utf8_decode($dadosProduto['nome'])}</a>
                </div>
                <div class="content-item product-description">{utf8_decode($dadosProduto['descricao']|strip_tags|truncate:150:"...":TRUE)}</div>
                <div class="content-item product-price">
                     {if $dadosProduto['valor'] eq "" or $dadosProduto['valor'] eq 0}
                        R${$dadosProduto['vl_promo']|number_format:2:",":"."}
                    {else}
                        R${$dadosProduto['valor']|number_format:2:",":"."}
                    {/if}
                </div>
                <div class="content-item product-amount">{$dadosProduto['quantidade']}</div>
                <div class="content-item product-subtotal">
                    <span>R$ {$dadosProduto['total_produto']|number_format:2:",":"."}</span>
                </div>
            </li>
        {/foreach}
        <li class="clearfix"></li>
    </ul>
    <div class="my-cart-footer-buttons clearfix">
        <button type="submit" class="footer-button next-step">Finalizar compra</button>
    </div>
</div>

</form>

{include file="suggestion-products.tpl"}

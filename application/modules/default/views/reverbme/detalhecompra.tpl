

    <div class="banners-advertisement cycle-slideshow"
    data-cycle-fx="fadeout"
    data-cycle-timeout="5000"
    data-cycle-slides="> a"
    data-cycle-log="false"
    data-cycle-pause-on-hover="true">
        {foreach from=$banners item=banner}
        {assign var="foto" value="{$banner['NR_SEQ_BANNER_BARC']}"}
        {assign var="extensao" value="{$banner['DS_EXT_BARC']}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
            <a href="{$banner['DS_LINK_BARC']}">
                {if file_exists("arquivos/uploads/banners/$foto_completa")}
                    <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}" />
                {else}
                    <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}" />
                {/if}
            </a>
        {/foreach}
    </div>

    <header class="row-fluid">
        <h2 class="rvb-title"><strong>Minhas</strong>compras</h2>
    </header>

<div id="step-1">
    <div class="rvb-header-item">
        <p>
           <strong>DETALHE DO PEDIDO NUMERO {$detalhes->NR_SEQ_COMPRA_COSO} FEITO EM {$detalhes->DT_COMPRA_COSO|date_format:"%d/%m/%Y"} ás {$detalhes->DT_COMPRA_COSO|date_format:"%H:%m"}hs.</strong>
        </p>
    </div>
    <div class="my-cart-payment-item current card">
        {if $detalhes->DS_FORMAPGTO_COSO eq 'boleto'}
            <img src="{$basePath}/arquivos/default/images/selos-pagamentos/boleto.png" alt="Boleto">
            <p class="payment-type">
                FORMA DE PAGAMENTO: BOLETO BANCÁRIO <br>
                FORMA DE ENVIO: {$detalhes->DS_FORMAENVIO_COSO}<br/>
                {if $detalhes->NR_PARCELAS_COSO eq 1}
                    Pagamento à vista: R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}.
                {else}
                    Pagamento em {$detalhes->NR_PARCELAS_COSO} vezes de : R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}.
                {/if}
                <br>
                STATUS: <strong class="color">
                {if $detalhes->ST_COMPRA_COSO eq 'E'}
                    ENTREGUE
                {elseif $detalhes->ST_COMPRA_COSO eq 'V'}
                    ENVIADO
                {elseif $detalhes->ST_COMPRA_COSO eq 'C'}
                    CANCELADO
                {elseif $detalhes->ST_COMPRA_COSO eq 'A'}
                    ABERTO
                {elseif $detalhes->ST_COMPRA_COSO eq 'P'}
                    PAGO
                {/if}
            </strong>
            </p>
        {/if}
        {if $detalhes->DS_FORMAPGTO_COSO eq 'visa'}
            <img src="{$basePath}/arquivos/default/images/selos-pagamentos/visa.png" alt="Cartão de crédito - Visa">
            <p class="payment-type">
                FORMA DE PAGAMENTO: CARTÃO VISA <br>
                FORMA DE ENVIO: {$detalhes->DS_FORMAENVIO_COSO}<br/>
                {if $detalhes->NR_PARCELAS_COSO eq 1}
                    Pagamento à vista: R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}.
                {else}
                {assign var="valor_parcela" value="{$detalhes->VL_TOTAL_COSO / $detalhes->NR_PARCELAS_COSO}"}
                    Pagamento em {$detalhes->NR_PARCELAS_COSO} X de : R$ {$valor_parcela|number_format:2:",":"."}.
                {/if}
                <br>
                STATUS: <strong class="color">
                {if $detalhes->ST_COMPRA_COSO eq 'E'}
                    ENTREGUE
                {elseif $detalhes->ST_COMPRA_COSO eq 'V'}
                    ENVIADO
                {elseif $detalhes->ST_COMPRA_COSO eq 'C'}
                    CANCELADO
                {elseif $detalhes->ST_COMPRA_COSO eq 'A'}
                    ABERTO
                {elseif $detalhes->ST_COMPRA_COSO eq 'P'}
                    PAGO
                {/if}
            </strong>
            </p>
        {/if}
        {if $detalhes->DS_FORMAPGTO_COSO eq 'mastercard'}
            <img src="{$basePath}/arquivos/default/images/selos-pagamentos/master.png" alt="Cartão de crédito - Mastercard">
            <p class="payment-type">
                FORMA DE PAGAMENTO: CARTÃO MASTERCARD <br>
                FORMA DE ENVIO: {$detalhes->DS_FORMAENVIO_COSO}<br/>
                {if $detalhes->NR_PARCELAS_COSO eq 1}
                    Pagamento à vista: R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}.
                {else}
                    {assign var="valor_parcela" value="{$detalhes->VL_TOTAL_COSO / $detalhes->NR_PARCELAS_COSO}"}
                    Pagamento em {$detalhes->NR_PARCELAS_COSO} X de : R$ {$valor_parcela|number_format:2:",":"."}.
                {/if}
                <br>
                STATUS: <strong class="color">
                {if $detalhes->ST_COMPRA_COSO eq 'E'}
                    ENTREGUE
                {elseif $detalhes->ST_COMPRA_COSO eq 'V'}
                    ENVIADO
                {elseif $detalhes->ST_COMPRA_COSO eq 'C'}
                    CANCELADO
                {elseif $detalhes->ST_COMPRA_COSO eq 'A'}
                    ABERTO
                {elseif $detalhes->ST_COMPRA_COSO eq 'P'}
                    PAGO
                {/if}
            </strong>
            </p>
        {/if}
        {if $detalhes->DS_FORMAPGTO_COSO eq 'amex'}
            <img src="{$basePath}/arquivos/default/images/selos-pagamentos/american-express.png" alt="Cartão de crédito - American Express">
            <p class="payment-type">
                FORMA DE PAGAMENTO: CARTÃO AMERICAN EXPRESS <br>
                FORMA DE ENVIO: {$detalhes->DS_FORMAENVIO_COSO}<br/>
                {if $detalhes->NR_PARCELAS_COSO eq 1}
                    Pagamento à vista: R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}.
                {else}
                    {assign var="valor_parcela" value="{$detalhes->VL_TOTAL_COSO / $detalhes->NR_PARCELAS_COSO}"}
                    Pagamento em {$detalhes->NR_PARCELAS_COSO} X de : R$ {$valor_parcela|number_format:2:",":"."}.
                {/if}
                <br>
               STATUS: <strong class="color">
                {if $detalhes->ST_COMPRA_COSO eq 'E'}
                    ENTREGUE
                {elseif $detalhes->ST_COMPRA_COSO eq 'V'}
                    ENVIADO
                {elseif $detalhes->ST_COMPRA_COSO eq 'C'}
                    CANCELADO
                {elseif $detalhes->ST_COMPRA_COSO eq 'A'}
                    ABERTO
                {elseif $detalhes->ST_COMPRA_COSO eq 'P'}
                    PAGO
                {/if}
            </strong>
            </p>
        {/if}
        {if $detalhes->DS_FORMAPGTO_COSO eq 'diners'}
            <img src="{$basePath}/arquivos/default/images/selos-pagamentos/diners.png" alt="Cartão de crédito - Diners">
            <p class="payment-type">
              <strong>CARTÃO DINERS</strong> <br>
              {if $detalhes->NR_PARCELAS_COSO eq 1}
                    Pagamento à vista: R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}.
                {else}
                  {assign var="valor_parcela" value="{$detalhes->VL_TOTAL_COSO / $detalhes->NR_PARCELAS_COSO}"}
                    Pagamento em {$detalhes->NR_PARCELAS_COSO} X de : R$ {$valor_parcela|number_format:2:",":"."}.
                {/if}
                <br>
                STATUS: <strong class="color">
                {if $detalhes->ST_COMPRA_COSO eq 'E'}
                    ENTREGUE
                {elseif $detalhes->ST_COMPRA_COSO eq 'V'}
                    ENVIADO
                {elseif $detalhes->ST_COMPRA_COSO eq 'C'}
                    CANCELADO
                {elseif $detalhes->ST_COMPRA_COSO eq 'A'}
                    ABERTO
                {elseif $detalhes->ST_COMPRA_COSO eq 'P'}
                    PAGO
                {/if}
            </strong>
            </p>
        {/if}
    </div>
    <div class="my-cart-order-number">
        Pedido número <br>
        <strong>{$detalhes->NR_SEQ_COMPRA_COSO}</strong>
    </div>

    <div class="clearfix"></div>

    <div class="rvb-header-item">
        <p>
           <strong>RESUMO DO PEDIDO</strong>
        </p>
    </div>

    <div class="my-cart-content-header">
        <p class="my-cart-header-item header-product">Produto</p>
        <p class="my-cart-header-item header-description">Descrição</p>
        <p class="my-cart-header-item header-price">Preço</p>
        <p class="my-cart-header-item header-amount">Quantidade</p>
        <p class="my-cart-header-item header-subtotal">Subtotal</p>
    </div>
    <ul class="my-cart-content-wrapper">
        {foreach from=$produtos_compra item=produto}
            {assign var="codigo" value="{$produto->NR_SEQ_PRODUTO_PRRC}"}
            {assign var="extensao" value="{$produto->DS_EXT_PRRC}"}
            {assign var="foto" value="{$codigo}.{$extensao}"}
            
            {assign var="fotos" value=$this->fotoproduto($produto->NR_SEQ_PRODUTO_PRRC)}
            {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
            {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
            {assign var="foto" value="{$foto_produto}.{$extensao_produto}"}
            
            <!-- Verifica se valor do produto é promocional ou não -->
            {if $dadosProduto['vl_promo'] eq "" or $dadosProduto['vl_promo'] eq 0}
                {assign var="valor_produto" value=$dadosProduto['valor']}
            {else}
                {assign var="valor_produto" value=$dadosProduto['vl_promo']}
            {/if}

            {if $produto->NR_SEQ_TIPO_PRRC == 6}
                {assign var=preTitle value='camiseta '}
            {else}
                {assign var=preTitle value=''}
            {/if}

            {assign var=ds_produto_prrc value=' - '|explode:$produto->DS_PRODUTO_PRRC}
            {assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}

            {if $dadosProduto['tipo'] neq 9}
                <li class="my-cart-content-item" data-idestoque="{$dadosProduto['idestoque']}" data-valorproduto="{$valor_produto}">
                    <div class="content-item product-name">
                        {if file_exists("arquivos/uploads/fotosprodutos/$foto")}
                            <!-- Polyfill para imagens responsivas-->
                            <span data-picture data-alt="{$dadosProduto['titulo']}" data-title="{$dadosProduto['titulo']}">
                                <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>$foto], "imagem", TRUE)}"></span>
                                <!-- for hd displays -->
                                <span data-width="65" data-height="70" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>130, 'altura'=>140, 'imagem'=>$foto], "imagem", TRUE)}" data-media="(-webkit-min-device-pixel-ratio: 2.0)"></span>

                                <noscript>
                                    <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>$foto], "imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity">
                                </noscript>
                            </span>
                        {else}
                            <!-- Polyfill para imagens responsivas-->
                            <span data-picture data-alt="{$dadosProduto['titulo']}" data-title="{$dadosProduto['titulo']}">
                                <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}"></span>
                                <!-- for hd displays -->
                                <span data-width="65" data-height="70" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>130, 'altura'=>140, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" data-media="(-webkit-min-device-pixel-ratio: 2.0)"></span>

                                <noscript>
                                    <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity">
                                </noscript>
                            </span>
                        {/if}
                        <a href="{$this->url(["titulo"=>{$this->createslug($slug)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}"> {$produto->DS_PRODUTO_PRRC}</a>
                    </div>
                    <div class="content-item product-description"style="padding: 23px;">
                        {if $produto->DS_SIGLA_TARC eq "Comprar"}
                            Tamanho Único
                        {else}
                            {$produto->DS_SIGLA_TARC}
                        {/if}
                    </div>
                    <div class="content-item product-price">
                        {if $produto->VL_PRODUTO_CESO eq 0}
                            Grátis
                        {else}
                            R${$produto->VL_PRODUTO_CESO|number_format:2:",":"."}
                        {/if}
                    </div>
                    <div class="content-item product-amount">
                        {$produto->NR_QTDE_CESO}
                    </div>
                    <div class="content-item product-subtotal">
                        {assign var="total_produto" value={math equation="( x * y )" x=$produto->VL_PRODUTO_CESO y=$produto->NR_QTDE_CESO}}
                        <span>
                            {if $produto->VL_PRODUTO_CESO eq 0}
                                Grátis
                            {else}
                                R$ {$total_produto|number_format:2:",":"."}
                            {/if}
                        </span>
                    </div>
                </li>
            {else}
                <li class="my-cart-content-item" data-idproduto="{$dadosProduto['codigo']}" data-valorproduto="{$valor_produto}">
                    <div class="content-item product-name">
                        {if file_exists("arquivos/uploads/fotosprodutos/$foto")}
                            <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>$foto], "imagem", TRUE)}" alt="{$dadosProduto['titulo']}"/>
                        {else}
                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$dadosProduto['titulo']}"/>
                        {/if}
                        <a href="{$this->url(["titulo"=>{$this->createslug($dadosProduto['nome'])}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}"> {utf8_decode($dadosProduto['nome'])}</a>
                    </div>
                    <div class="content-item product-description">
                        {utf8_decode($dadosProduto['descricao']|strip_tags|truncate:150:"...":TRUE)}
                    </div>
                    <div class="content-item product-price">
                            R${$valor_produto|number_format:2:",":"."}
                    </div>
                    <div class="content-item product-amount">
                        <div class="select-item">
                            <span class="amount-selected">{$dadosProduto['quantidade']}</span>
                            <select name="amount">
                                {if $dadosProduto['tipo'] neq 9}
                                    {for $item=1 to {$dadosProduto['estoque']} max=10}
                                        {if $dadosProduto['quantidade'] == $item}
                                            <option value="{$item}" selected>{$item}</option>
                                        {else}
                                            <option value="{$item}">{$item}</option>
                                        {/if}
                                    {/for}
                                {else}
                                    <option value="1" selected>1</option>
                                {/if}
                            </select>
                        </div>
                    </div>
                    <div class="content-item product-subtotal">
                        <span>R$ {$dadosProduto['total_produto']|number_format:2:",":"."}</span>
                    </div>
                </li>
            {/if}
        {/foreach}
    </ul>

    <div class="clearfix"></div>

    <div class="rvb-column left" id="buyer-information">
        <div>
            <div class="rvb-header-item">
                <h2>Dados do comprador</h2>
            </div>
        </div>

        <div class="rvb-content-item">
            <p>

                <strong>
                    {$detalhes->DS_NOME_CASO} <br>
                    {if $dadosEndereco}
                        {$dadosEndereco->DS_ENDERECO_ENRC}, {$dadosEndereco->DS_NUMERO_ENRC} {$dadosEndereco->DS_COMPLEMENTO_ENRC} <br>
                        {$dadosEndereco->DS_CIDADE_ENRC}/{$dadosEndereco->DS_UF_ENRC} {$dadosEndereco->DS_PAIS_ENRC} - CEP <span id="buyer-cep">{$dadosEndereco->DS_CEP_ENRC}</span> - {$dadosEndereco->DS_BAIRRO_ENRC}
                    {else}
                        {$detalhes->DS_ENDERECO_CASO}, {$detalhes->DS_NUMERO_CASO} {$detalhes->DS_COMPLEMENTO_CASO} <br>
                        {$detalhes->DS_CIDADE_CASO}/{$detalhes->DS_UF_CASO} {$detalhes->DS_PAIS_CACH} - CEP <span id="buyer-cep">{$detalhes->DS_CEP_CASO}</span> - {$detalhes->DS_BAIRRO_CASO}
                    {/if}
                </strong>
            </p>
        </div>
    </div>
    {assign var="subtotal" value={math equation="( y - x )" x=$detalhes->VL_FRETE_COSO y=$detalhes->VL_TOTAL_COSO}}
    <div class="my-cart-footer-subtotal">
        <p class="legend subtotal">Subtotal       <span class="result">R$ {$subtotal|number_format:2:",":"."}</span></p>
        <p class="legend delivery">Frete          <span class="result">R$ {$detalhes->VL_FRETE_COSO|number_format:2:",":"."}</span></p>
        <p class="legend discount">Desconto       <span class="result">R$ {$detalhes->VL_DESCONTO_COSO|number_format:2:",":"."}</span></p>
        <p class="legend total">Total             <span class="result">R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}</span></p>
    </div>


    

</div>



<div class="row other-products">
    {include file="suggestion-products.tpl"}
</div>
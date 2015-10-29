

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
           <strong>DETALHE DO PEDIDO NUMERO {$detalhes->NR_SEQ_COMPRA_COSO} FEITO EM {$detalhes->DT_COMPRA_COSO|date_format:"%d/%m/%Y"} ás {$detalhes->DT_COMPRA_COSO|date_format:"%H:%M"}hs.</strong>
        </p>
    </div>
    <div class="my-cart-payment-item current card">
      
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
        <p class="my-cart-header-item header-description">Tamanho</p>
        <p class="my-cart-header-item header-price">Preço</p>
        <p class="my-cart-header-item header-amount">Quantidade</p>
        <p class="my-cart-header-item header-subtotal">Subtotal</p>
    </div>
    <ul class="my-cart-content-wrapper">
        {foreach from=$produtos_compra item=produto}
            {assign var="codigo" value="{$produto->NR_SEQ_PRODUTO_PRRC}"}
            {assign var="extensao" value="{$produto->DS_EXT_PRRC}"}
            {assign var="foto" value="{$codigo}.{$extensao}"}
            <!-- Verifica se valor do produto é promocional ou não -->
            {if $dadosProduto['vl_promo'] eq "" or $dadosProduto['vl_promo'] eq 0}
                {assign var="valor_produto" value=$produto->VL_PRODUTO_CESO}
            {else}
                {assign var="valor_produto" value=$produto->VL_PRODUTO_CESO}
            {/if}
            {if $produto->NR_SEQ_TIPO_PRRC neq 9}
                <li class="my-cart-content-item" data-valorproduto="{$valor_produto}">
                    <div class="content-item product-name">
                        {if file_exists("arquivos/uploads/produtos/$foto")}
                            <!-- Polyfill para imagens responsivas-->
                            <span data-picture data-alt="{$produto->DS_PRODUTO_PRRC}" data-title="{$produto->DS_PRODUTO_PRRC}">
                                <span data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>$foto], "imagem", TRUE)}"></span>
                                <!-- for hd displays -->
                                <span data-width="65" data-height="70" data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>130, 'altura'=>140, 'imagem'=>$foto], "imagem", TRUE)}" data-media="(-webkit-min-device-pixel-ratio: 2.0)"></span>

                                <noscript>
                                    <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>$foto], "imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity">
                                </noscript>
                            </span>
                        {else}
                            <!-- Polyfill para imagens responsivas-->
                            <span data-picture data-alt="{$produto->DS_PRODUTO_PRRC}" data-title="{$produto->DS_PRODUTO_PRRC}">
                                <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}"></span>
                                <!-- for hd displays -->
                                <span data-width="65" data-height="70" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>130, 'altura'=>140, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" data-media="(-webkit-min-device-pixel-ratio: 2.0)"></span>

                                <noscript>
                                    <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity">
                                </noscript>
                            </span>
                        {/if}
                        <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}"> {$produto->DS_PRODUTO_PRRC}</a>
                    </div>
                    <div class="content-item product-description">
                        {$produto->DS_INFORMACOES_PRRC|strip_tags|truncate:150:"...":TRUE}
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
                        <span>
                            {if $produto->VL_PRODUTO_CESO eq 0}
                                Grátis
                            {else}
                                R${$produto->VL_PRODUTO_CESO|number_format:2:",":"."}
                            {/if}
                        </span>
                    </div>
                </li>
            {else}
                <li class="my-cart-content-item" data-idproduto="{$produto->NR_SEQ_PRODUTO_PRRC}" data-valorproduto="{$produto->VL_PRODUTO_CESO}">
                    <div class="content-item product-name">
                        {if file_exists("arquivos/uploads/produtos/$foto")}
                            <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>$foto], "imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}"/>
                        {else}
                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}"/>
                        {/if}
                        <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}"> {utf8_decode($produto->DS_PRODUTO_PRRC)}</a>
                    </div>
                    <div class="content-item product-description">
                        {utf8_decode($produto->DS_SIGLA_TARC|strip_tags|truncate:150:"...":TRUE)}
                    </div>
                    <div class="content-item product-price">
                            R${$produto->VL_PRODUTO_CESO|number_format:2:",":"."}
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
                    {$detalhes->DS_ENDERECO_CASO}, {$detalhes->DS_NUMERO_CASO} {$detalhes->DS_COMPLEMENTO_CASO} <br>
                    {$detalhes->DS_CIDADE_CASO}/{$detalhes->DS_UF_CASO} {$detalhes->DS_PAIS_CACH} - CEP <span id="buyer-cep">{$detalhes->DS_CEP_CASO}</span> - {$detalhes->DS_BAIRRO_CASO}
                </strong>
            </p>
        </div>
    </div>
    {assign var="total" value={math equation="( y - x )" x=$detalhes->VL_FRETE_COSO y=$detalhes->VL_TOTAL_COSO}}
    <div class="my-cart-footer-subtotal">
        <p class="legend subtotal">Subtotal       <span class="result">R$ {$total|number_format:2:",":"."}</span></p>
        <p class="legend delivery">Frete          <span class="result">R$ {$detalhes->VL_FRETE_COSO|number_format:2:",":"."}</span></p>
        <p class="legend discount">Desconto       <span class="result">R$ {$detalhes->VL_DESCONTO_COSO|number_format:2:",":"."}</span></p>
        <p class="legend total">Total             <span class="result">R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}</span></p>
    </div>


    <div class="clearfix"></div>
    <div class="my-cart-footer-buttons clearfix">
        <a href="$basePath}/novo-me/page" class="footer-button buy-more-items">Voltar</a>
        <a href="#" class="footer-button next-step">Avançar</a>
    </div>

</div>

<div id="step-2" class="hidden">
    <form action="{$this->url(["idcompra"=>{$detalhes->NR_SEQ_COMPRA_COSO}], "atualizacompra", TRUE)}" method="post">

      <!--   <div class="hidden" id="dados-do-comprador">
            <input checked type="checkbox" name="usar_mesmo" id="usar_mesmo" value="1" />

            <input type="text" id="endereco_nome" name="endereco_nome" />
            <input type="text" id="endereco_cep" name="endereco_cep" />
            <input type="text" id="endereco_endereco" name="endereco_endereco" />
            <input type="text" id="endereco_numero" name="endereco_numero" />
            <input type="text" id="endereco_complemento" name="endereco_complemento" />
            <input type="text" id="endereco_bairro" name="endereco_bairro" />
            <input type="text" id="endereco_estado" name="endereco_estado" />
            <input type="text" id="endereco_cidade" name="endereco_cidade" />
            <input type="text" id="endereco_telefone" name="endereco_telefone" />
            <input type="text" id="endereco_celular" name="endereco_celular" />
        </div> -->

        <div class="my-cart-payment-title clearfix">
            <p class="full-strip">Selecione a forma de pagamento</p>
        </div>
        <ul class="my-cart-payment-types">

            <li class="my-cart-payment-item current">
                <div class="radio-icon active">
                    <input checked type="radio" name="formapagto" value="boleto">
                </div>
                <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/boleto.png" width="45" height="29" alt="Boleto">
                <p class="payment-type"><strong>BOLETO BANCÁRIO</strong>.  O vencimento do boleto será daqui a 3 dias. A liberação do seu pedido será feita após a confirmação do pagamento.</p>
            </li>
            <li class="my-cart-payment-item card">
                <div class="radio-icon">
                    <input type="radio" value="visa" name="formapagto">
                </div>
                <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/visa.png" width="45" height="29" alt="Cartão de crédito - Visa">
                <p class="payment-type">
                    <strong>CARTÃO VISA</strong>.
                    Para pagamentos por cartão de crédito Visa em até <span class="quantidade-parcelas">3x</span> sem juros.<br>
                    <span class="cash-payment">Pagamento à vista: <span class="final-price">R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}</span></span>
                </p>
                <div class="numbers-card-field">
                    <label for="visa">Digite os 6 (seis) primeiros dígitos do seu cartão:</label>
                    <input type="text" id="visa" name="visa" class="input-box right input-card-numbers" disabled maxlength="6">
                </div>
                <div class="options-of-instalments">
                    <label for="parcelas_visa" class="monthly-instalments">Escolha as parcelas:</label>
                    <div class="select-option">
                        <span>01x de R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}</span>
                        <select class="select-parcelas" name="parcelas_visa" id="parcelas_visa" disabled>
                            <option value="1">01x de R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}</option>
                            <option value="2">02x de R$ {$duas_parcelas|number_format:2:",":"."}</option>
                            <option value="3">03x de R$ {$tres_parcelas|number_format:2:",":"."}</option>
                            <option value="4">04x de R$ {$quatro_parcelas|number_format:2:",":"."}</option>
                        </select>
                    </div>
                </div>
            </li>
            <li class="my-cart-payment-item card">
                <div class="radio-icon">
                    <input type="radio" name="formapagto"  value="mastercard">
                </div>
                <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/master.png" width="45" height="29" alt="Cartão de crédito - Mastercard">
                <p class="payment-type">
                    <strong>CARTÃO MASTERCARD</strong>.
                    Para pagamentos por cartão de crédito MasterCard em até <span class="quantidade-parcelas">3x</span> sem juros.<br>
                    <span class="cash-payment">Pagamento à vista: <span class="final-price">R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}</span></span>
                </p>
                <div class="numbers-card-field">
                    <label for="mastercard">Digite os 6 (seis) primeiros dígitos do seu cartão:</label>
                    <input type="text" name="mastercard" id="mastercard" class="input-box right input-card-numbers" disabled maxlength="6">
                </div>
                <div class="options-of-instalments">
                    <label for="parcelas_mastercard" class="monthly-instalments">Escolha as parcelas:</label>
                    <div class="select-option">
                        <span>01x de R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}</span>
                        <select class="select-parcelas" name="parcelas_mastercard" id="parcelas_mastercard" disabled>
                            <option value="1">01x de R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}</option>
                            <option value="2">02x de R$ {$duas_parcelas|number_format:2:",":"."}</option>
                            <option value="3">03x de R$ {$tres_parcelas|number_format:2:",":"."}</option>
                            <option value="4">04x de R$ {$quatro_parcelas|number_format:2:",":"."}</option>
                        </select>
                    </div>
                </div>
            </li>
            <li class="my-cart-payment-item card">
                <div class="radio-icon">
                    <input type="radio" name="formapagto" value="amex">
                </div>
                <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/american-express.png" width="45" height="29" alt="Cartão de crédito - American Express">
                <p class="payment-type">
                    <strong>CARTÃO AMERICAN EXPRESS</strong>.
                    Para pagamentos por cartão de crédito Americna Express em até <span class="quantidade-parcelas">3x</span> sem juros.<br>
                    <span class="cash-payment">Pagamento à vista: <span class="final-price">R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}</span></span>  <br>
                </p>
                <div class="numbers-card-field">
                    <label for="americanexpress">Digite os 6 (seis) primeiros dígitos do seu cartão:</label>
                    <input type="text" name="americanexpress" id="americanexpress" class="input-box right input-card-numbers" disabled maxlength="6">
                </div>
                <div class="options-of-instalments">
                    <label for="parcelas_americanexpress" class="monthly-instalments">Escolha as parcelas:</label>
                    <div class="select-option">
                        <span>01x de R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}</span>
                        <select class="select-parcelas" name="parcelas_americanexpress" id="parcelas_americanexpress" disabled>
                            <option value="1">01x de R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}</option>
                            <option value="2">02x de R$ {$duas_parcelas|number_format:2:",":"."}</option>
                            <option value="3">03x de R$ {$tres_parcelas|number_format:2:",":"."}</option>
                            <option value="4">04x de R$ {$quatro_parcelas|number_format:2:",":"."}</option>
                        </select>
                    </div>
                </div>
            </li>
            <li class="my-cart-payment-item card">
                <div class="radio-icon">
                    <input type="radio" name="formapagto" value="diners">
                </div>
                <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/diners.png" width="45" height="29" alt="Cartão de crédito - Diners">
                <p class="payment-type">
                    <strong>CARTÃO DINERS</strong>.
                    Para pagamentos por cartão de crédito Diners em até <span class="quantidade-parcelas">3x</span> sem juros.<br>
                    <span class="cash-payment">Pagamento à vista: <span class="final-price">R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}</span></span>
                </p>
                <div class="numbers-card-field">
                    <label for="diners">Digite os 6 (seis) primeiros dígitos do seu cartão:</label>
                    <input type="text" name="diners" id="diners" class="input-box right input-card-numbers" disabled maxlength="6">
                </div>
                <div class="options-of-instalments">
                    <label for="parcelas_diners" class="monthly-instalments">Escolha as parcelas:</label>
                    <div class="select-option">
                        <span>01x de R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}</span>
                        <select class="select-parcelas" name="parcelas_diners" id="parcelas_diners" disabled>
                            <option value="1">01x de R$ {$detalhes->VL_TOTAL_COSO|number_format:2:",":"."}</option>
                            <option value="2">02x de R$ {$duas_parcelas|number_format:2:",":"."}</option>
                            <option value="3">03x de R$ {$tres_parcelas|number_format:2:",":"."}</option>
                            <option value="4">04x de R$ {$quatro_parcelas|number_format:2:",":"."}</option>
                        </select>
                    </div>
                </div>
            </li>
            <li class="my-cart-payment-item card">
                <div class="radio-icon">
                    <input type="radio" name="formapagto"  value="elo">
                </div>
                <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/elo.png" width="45" height="29" alt="Cartão de crédito - elo">
                <p class="payment-type">
                    <strong>CARTÃO ELO</strong>.
                    Para pagamentos por cartão de crédito elo em até <span class="quantidade-parcelas">3x</span> sem juros.<br>
                    <span class="cash-payment">Pagamento à vista: <span class="final-price">R$ {$total|number_format:2:",":"."}</span></span>
                </p>
                <div class="numbers-card-field">
                    <label for="elo">Digite os 6 (seis) primeiros dígitos do seu cartão:</label>
                    <input type="text" name="elo" id="elo" class="input-box right input-card-numbers" disabled maxlength="6">
                </div>
                <div class="options-of-instalments">
                    <label for="parcelas_elo" class="monthly-instalments">Escolha as parcelas:</label>
                    <div class="select-option">
                        <span>01x de R$ {$total|number_format:2:",":"."}</span>
                        <select class="select-parcelas" name="parcelas_elo" id="parcelas_elo" disabled>
                            <option value="1">01x de R$ {$total|number_format:2:",":"."}</option>
                            <option value="2">02x de R$ {$duas_parcelas|number_format:2:",":"."}</option>
                            <option value="3">03x de R$ {$tres_parcelas|number_format:2:",":"."}</option>
                            <option value="4">04x de R$ {$quatro_parcelas|number_format:2:",":"."}</option>
                        </select>
                    </div>
                </div>
            </li>
        </ul>
        <div class="clearfix"></div>
        <div class="my-cart-footer-buttons clearfix">
            <a href="#step-1" class="footer-button buy-more-items">Voltar</a>
            <button type="submit" class="footer-button next-step">Avançar</button>
        </div>
    </form>
</div>

<div class="row other-products">
    {include file="suggestion-products.tpl"}
</div>
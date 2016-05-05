<div class="banners-advertisement cycle-slideshow"
     data-cycle-fx="fadeout"
     data-cycle-timeout="5000"
     data-cycle-slides="> a"
     data-cycle-log="false"
     data-cycle-pause-on-hover="true">
    {foreach from=$banners_topo item=topo}
        {assign var="foto" value="{$topo->NR_SEQ_BANNER_BARC}"}
        {assign var="extensao" value="{$topo->DS_EXT_BARC}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}

        <a href="{$topo->DS_LINK_BARC}" class="cycle-slide cycle-sentinel">
            {if file_exists("arquivos/uploads/banners/$foto_completa")}
                <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}"  alt="{$topo->DS_DESCRICAO_BARC}">
            {else}
                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}"  alt="{$topo->DS_DESCRICAO_BARC}">
            {/if}
        </a>
    {/foreach}
</div>

<div class="my-cart-steps clearfix">
    <div class="steps step-1 current">Etapa 1 - Informações</div>
    <div class="steps step-2">Etapa 2 - Pagamento</div>
    <div class="steps step-3">Etapa 3 - Confirmação</div>
</div>
{if $msg_promo neq ""}
    <h2 style="background-color: #e85238; color: #FFF; padding: 10px 10px 10px 10px; font-size: 13px;">
    {if $primeira_compra eq 1 and $compra_niver eq 0}
        <img src="{$basePath}/arquivos/default/images/bag-icon.png"style="float: left;padding: 10px; padding-top:0px;">
    {/if}
    {if $compra_niver eq 1}
        <img src="{$basePath}/arquivos/default/images/gift-icon.png"style="float: left;padding-right: 10px;">
    {/if}
    {if $promo_sale eq 1}
        <img src="{$basePath}/arquivos/default/images/sale-icon.png"style="float: left;padding-right: 10px;">
    {/if}
        <b>{$msg_promo}</b>
    </h2>
{else}
    <h2 style="background-color: #e85238; color: #FFF; padding: 10px 10px 10px 10px; font-size: 13px;">

        {if $msg_promo eq ""}
            <img src="{$basePath}/arquivos/default/images/sale-icon.png"style="float: left;padding-right: 10px;">
            <b>Na compra de um produto a partir de  69,00  ganhe uma camiseta grátis que esteja em sale!</b>

        {elseif $uf_usuario eq 'PR'}
            <img src="{$basePath}/arquivos/default/images/rocket-icon.png"style="float: left;padding-right: 10px;">
            <b>Faça uma compra a partir de R$69 em qualquer item fora de promoção e ganhe o frete para qualquer lugar do PR. Promo não cumulativa com a de aniversário.</b>
        {elseif $uf_usuario eq 'SP'}
            <img src="{$basePath}/arquivos/default/images/rocket-icon.png"style="float: left;padding-right: 10px;">
            <b>Faça uma compra a partir de R$90 (com pelo menos uma camiseta de R$69 no carrinho) e ganhe o frete para todo estado de SP. Promo não cumulativa com a de aniversário e primeira compra.</b>
        {else}
            <img src="{$basePath}/arquivos/default/images/rocket-icon.png"style="float: left;padding-right: 10px;">
            <b>Faça uma compra a partir de R$260 (com pelo menos 1 item fora de promoção no carrinho) e ganhe o frete para qualquer lugar do Brasil. No mês do seu aniversário além do frete você  também ganha uma camiseta.</b>
        {/if}
    </h2>
{/if}
<h1 class="rvb-title">Carrinho de Compras</h1>

<div id="step-1">
    <div class="my-cart-content-header">
        <p class="my-cart-header-item header-product">Produto</p>
        <p class="my-cart-header-item header-description">Tamanho</p>
        <p class="my-cart-header-item header-price">Preço</p>
        <p class="my-cart-header-item header-amount">Quantidade</p>
        <p class="my-cart-header-item header-subtotal">Subtotal</p>
    </div>
    <ul class="my-cart-content-wrapper">
        {assign var="quantidade_total" value="0"}
        {foreach from=$carrinho item=dadosProduto}
            {assign var="foto" value="{$dadosProduto['codigo']}"}
            {assign var="extensao" value="{$dadosProduto['path']}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}

            {assign var="fotos" value=$this->fotoproduto($dadosProduto['codigo'])}
            {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
            {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
            {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}

            {assign var="quantidade_total" value="{$quantidade_total+$dadosProduto['quantidade']}"}
            <!-- Verifica se valor do produto é promocional ou não -->
            {if $dadosProduto['vl_promo'] eq "" or $dadosProduto['vl_promo'] eq 0}
                {assign var="valor_produto" value=$dadosProduto['valor']}
            {else}
                {assign var="valor_produto" value=$dadosProduto['vl_promo']}
            {/if}
            {if $dadosProduto['tipo'] neq 9}
            <li class="my-cart-content-item" data-idestoque="{$dadosProduto['idestoque']}" data-valorproduto="{$valor_produto}">
                <div class="content-item product-name">
                    {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="{$dadosProduto['titulo']}" data-title="{$dadosProduto['titulo']}">
                            <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>$foto_completa], "imagem", TRUE)}"></span>
                            <!-- for hd displays -->
                            <span data-width="65" data-height="70" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>130, 'altura'=>140, 'imagem'=>$foto_completa], "imagem", TRUE)}" data-media="(-webkit-min-device-pixel-ratio: 2.0)"></span>

                            <noscript>
                                <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity">
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
                    <a href="{$this->url(["titulo"=>{$this->createslug($dadosProduto['nome'])}, "idproduto"=>{$dadosProduto['codigo']}], 'produto', TRUE)}"> {utf8_decode($dadosProduto['nome'])}</a>
                </div>
                <div class="content-item product-description" style="padding: 23px;">
                    {utf8_decode($dadosProduto['sigla']|strip_tags|truncate:150:"...":TRUE)}
                </div>
                <div class="content-item product-price">
                        {if $valor_produto eq 0}
                            Grátis
                        {else}
                            R${$valor_produto|number_format:2:",":"."}
                        {/if}
                </div>
                <div class="content-item product-amount">
                    <div class="select-item">
                        <span class="amount-selected">{$dadosProduto['quantidade']}</span>
                        {if $valor_produto eq 0}
                            <select name="amount" disabled>
                        {else}
                            <select name="amount" data-tipo="{$dadosProduto['tipo']}">
                        {/if}
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
                    <span>
                        {if $valor_produto eq 0}
                            Grátis
                        {else}
                            R$ {$dadosProduto['total_produto']|number_format:2:",":"."}
                        {/if}
                    </span>
                        <a href="{$this->url(["idestoque"=>{$dadosProduto['idestoque']}], 'removercarrinho', TRUE)}" class="link-remove"><i class="md-close"></i></a>
                </div>
            </li>
        {else}
            <li class="my-cart-content-item" data-idproduto="{$dadosProduto['codigo']}" data-valorproduto="{$valor_produto}">
                <div class="content-item product-name">
                    {if file_exists("arquivos/uploads/produtos/$foto_completa")}
                        <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$dadosProduto['titulo']}"/>
                    {else}
                        <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>65, 'altura'=>70, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$dadosProduto['titulo']}"/>
                    {/if}
                    <a href="{$this->url(["titulo"=>{$this->createslug($dadosProduto['nome'])}, "idproduto"=>{$dadosProduto['codigo']}], 'produto', TRUE)}"> {utf8_decode($dadosProduto['nome'])}</a>
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
                        <select name="amount" data-tipo="{$dadosProduto['tipo']}">
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
                        <a href="{$this->url(["idproduto"=>{$dadosProduto['codigo']}], 'removercarrinho', TRUE)}" class="link-remove"><i class="md-close"></i></a>
                </div>
            </li>
        {/if}
        {/foreach}
    </ul>

    <div class="clearfix"></div>

    <div class="my-cart-footer-shipping">
        <form action="{$this->url([], 'correios', TRUE)}" method="post" id="delivery-calculate">
            <div class="my-cart-footer-item footer-delivery-calculate">
                <label class="legend" for="zipcode">Calcular o frete</label>
                {if $info['DS_CEP_CASO'] eq ""}
                    <input type="text" id="zipcode" class="cep" name="cep" value="{$info['DS_CEP_CASO']}" placeholder="INSIRA SEU CEP">
                {else}
                    <input type="text" id="zipcode" class="cep" name="cep" placeholder="{$info['DS_CEP_CASO']}" value="{$info['DS_CEP_CASO']}">
                {/if}
                <input type="hidden" value="2" name="quantidade" />
                <button class="footer-ui-button" type="submit" id="calcular-frete">Calcular</button>
                {if $tipo_usuario neq 'PJ'}
                    {if $info['DS_CIDADE_CASO'] eq 'Londrina' AND $subtotal ge 69}
                        <p id="free-delivery" class="hint text-success">
                             <strong>frete grátis</strong>!
                             Para Compras em Londrina
                       </p>
                    {else}
                        <p id="free-delivery" class="hint text-error">
                            Faltam <strong>R$ {$valor_frete_gratis|number_format:2:",":"."}</strong> para o <br/>
                            <strong>frete grátis</strong>!
                        </p>
                    {/if}

                {/if}
            </div>
            <div class="my-cart-footer-item footer-delivery-type">
                <div>
                    <p class="legend">Forma de envio</p>
                    <ul class="delivery-types">
                        {if $frete_gratis le 0}
                            <li>
                                <label class="footer-ui-button">PAC <input class="hidden type_delivery" type="radio" name="forma_envio" id="pac" value="1"></label>
                            </li>
                            <li>
                                <label class="footer-ui-button">Sedex <input class="hidden type_delivery" type="radio" name="forma_envio" id="sedex" value="2"></label>
                            </li>
                            <li>
                                <label class="footer-ui-button active">E-Sedex <input checked="true" class="hidden type_delivery" type="radio" name="forma_envio" id="sedex" value="3" ></label>
                            </li>
                            <li>
                                <label class="footer-ui-button">Tam <input class="hidden type_delivery" type="radio" name="forma_envio" id="tam" value="4"></label>
                            </li>
                        {else}
                            <li>
                                <label class="footer-ui-button active">PAC <input checked="true" class="hidden type_delivery" type="radio" name="forma_envio" id="pac" value="1"></label>
                            </li>
                            <li class="hidden">
                                <label class="footer-ui-button">Sedex <input class="hidden type_delivery" type="radio" name="forma_envio" id="sedex" value="2"></label>
                            </li>
                            <li class="hidden">
                                <label class="footer-ui-button">E-Sedex <input class="hidden type_delivery" type="radio" name="forma_envio" id="sedex" value="3" ></label>
                            </li>
                            <li class="hidden">
                                <label class="footer-ui-button">Tam <input class="hidden type_delivery" type="radio" name="forma_envio" id="tam" value="4"></label>
                            </li>
                        {/if}
                    </ul>
                </div>
                <p id="time-delivery" class="hint text-success">
                </p>
            </div>
        </form>
    </div>

    <div class="my-cart-footer-descont">
        <div class="my-cart-footer-item footer-discount-type">
            {if $valepresente eq ""}
                <form action="#" method="post" id="discount-calculate">
                    <label class="legend" for="cupomcode">Cupom de desconto / Vale-presente</label>
                    <input type="text" id="cupomcode" placeholder="INSIRA O CÓDIGO" name="cupom">
                    <button class="footer-ui-button" id="calcular-cupom" type="submit">Utilizar</button>
                </form>
            {else}
                <form action="#" method="post" id="discount-calculate">
                    <label class="legend" for="cupomcode">Cupom de desconto / Vale-presente</label>
                    <input type="text" id="cupomcode" placeholder="INSIRA O CÓDIGO" name="cupom" value="{$valepresente}">
                    <input type="hidden" name="bilhete" value="{$idvale_presente}" />
                    <input type="hidden" name="desativa" value="1">
                    <button class="footer-ui-button" type="submit">Desativar</button>
                </form>
            {/if}
        </div>
    </div>

    <div class="my-cart-footer-subtotal" id="my-cart-subtotal" data-usuario="{$tipo_usuario}" data-quantidade="{$quantidade_total}" data-subtotal="{$subtotal}" data-cep="{$cep}" data-frete="{$frete}" data-desconto="{$valor_desconto}" data-total="{$total}">
        <p class="legend quantidade">Total de itens       <span class="result">{$quantidade_total}</span></p>
        <p class="legend subtotal">Subtotal       <span class="result">R$ {$subtotal|number_format:2:",":"."}</span></p>
        <p class="legend delivery">Frete          <span class="result">R$ {$frete|number_format:2:",":"."}</span></p>
        <p class="legend discount">Desconto          <span class="result">R$ {$valor_desconto|number_format:2:",":"."}</span></p>
        <p class="legend total">Total             <span class="result">R$ {$total|number_format:2:",":"."}</span></p>
    </div>

    <div class="clearfix"></div>



    <div class="rvb-column left" id="delivery-address">
        <div class="rvb-header-item">
            <h2>Endereço de entrega</h2>
            <label class="label-checkbox active" for="use_the_same">
              <input checked type="checkbox" name="use_the_same" id="use_the_same" value="1">
              Usar o mesmo do cadastro
            </label>
        </div>
        <div class="rvb-content-item">
            <form class="" id="" action="" method="post">

                <div class="rvb-field disabled no-label">
                  <input placeholder="NOME" disabled id="fake_endereco_nome" name="fake_endereco_nome" type="text" class="input-txt full" required="">
                </div>

                <div class="rvb-field disabled no-label">
                  <input placeholder="CEP" disabled id="fake_endereco_cep" name="fake_endereco_cep" type="text" class="input-txt ralf cep" required="">
                  <button class="btn-buscar" id="fake_endereco_buscarCep" disabled type="button">Pesquisar</button>
                </div>

                <div class="rvb-field disabled no-label">
                  <input placeholder="ENDEREÇO" disabled id="fake_endereco_endereco" name="fake_endereco_endereco" type="text" class="input-txt ralf" required="">
                </div>

                <div class="rvb-field disabled no-label">
                  <input placeholder="NÚMERO" disabled id="fake_endereco_numero" name="fake_endereco_numero" type="text" class="input-txt ralf" required="">
                </div>

                <div class="rvb-field disabled no-label">
                  <input placeholder="COMPLEMENTO" disabled id="fake_endereco_complemento" name="fake_endereco_complemento" type="text" class="input-txt ralf">
                </div>

                <div class="rvb-field disabled no-label">
                  <input placeholder="BAIRRO" disabled id="fake_endereco_bairro" name="fake_endereco_bairro" type="text" class="input-txt ralf" required="">
                </div>


                <div class="rvb-field disabled clearleft">
                  <label for="fake_endereco_estado" class="arrowed">Estado</label>
                  <div class="select-form ralf">
                    <span>Selecione o estado</span>
                    <select disabled name="fake_endereco_estado" id="fake_endereco_estado" class="select-box"></select>
                  </div>
                </div>

                <div class="rvb-field disabled">
                  <label for="fake_endereco_cidade" class="arrowed">Cidade</label>
                  <div class="select-form ralf">
                    <span>Selecione</span>
                    <select disabled name="fake_endereco_cidade" id="fake_endereco_cidade" class="select-box"></select>
                  </div>
                </div>

                <div class="rvb-field disabled no-label">
                  <input placeholder="TELEFONE"  disabled id="fake_endereco_telefone" name="fake_endereco_telefone" type="text" class="input-txt ralf">
                </div>

                <div class="rvb-field disabled no-label">
                  <input placeholder="CELULAR" disabled id="fake_endereco_celular" name="fake_endereco_celular" type="text" class="input-txt ralf" required="">
                </div>
            </form>
        </div>
    </div>

    <div class="rvb-column right" id="buyer-information">

        <div>
            <div class="rvb-header-item">
                <h2>Dados do comprador</h2>
            </div>
        </div>

        <div class="rvb-content-item">
            <p>

                <strong>
                    {$info['DS_NOME_CASO']} <br>
                    {$info['DS_ENDERECO_CASO']}, {$info['DS_NUMERO_CASO']} {$info['DS_COMPLEMENTO_CASO']} <br>
                    {$info['DS_CIDADE_CASO']}/{$info['DS_UF_CASO']} {$info['DS_PAIS_CACH']} - CEP <span id="buyer-cep">{$info['DS_CEP_CASO']}</span> - {$info['DS_BAIRRO_CASO']}
                </strong>
            </p>

            <div class="send-button">
              <a class="btn" href="{$this->url([], "reverbme", TRUE)}">Alterar dados</a>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="clearfix"></div>

    <div class="clear"></div>
    {if $_isMobile eq 1}
    <div class="my-cart-footer-buttons clearfix">
        <a href="{$this->url([], "loja", TRUE)}" class="footer-button buy-more-items">Comprar mais</a>


        <a href="#" class="footer-button next-step">Avançar</a>
    {else}
        <div class="my-cart-footer-buttons clearfix" style=" margin-top: -165px; ">
        <a href="{$this->url([], "loja", TRUE)}" class="footer-button buy-more-items">Comprar mais</a>


        <a href="#" class="footer-button next-step">Avançar</a>

    {/if}



    </div>
</div>

<div id="step-2" class="hidden">
    <form action="{$this->url([], "fazerpedido", TRUE)}" method="post">

        <div class="hidden" id="dados-do-comprador">
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
        </div>

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
                    <span class="cash-payment">Pagamento à vista: <span class="final-price">R$ {$total|number_format:2:",":"."}</span></span>
                </p>
                <div class="numbers-card-field">
                    <label for="visa">Digite os 6 (seis) primeiros dígitos do seu cartão:</label>
                    <input type="text" id="visa" name="visa" class="input-box right input-card-numbers" disabled maxlength="6">
                </div>
                <div class="options-of-instalments">
                    <label for="parcelas_visa" class="monthly-instalments">Escolha as parcelas:</label>
                    <div class="select-option">
                        <span>01x de R$ {$total|number_format:2:",":"."}</span>
                        <select class="select-parcelas" name="parcelas_visa" id="parcelas_visa" disabled>
                            <option value="1">01x de R$ {$total|number_format:2:",":"."}</option>
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
                    <span class="cash-payment">Pagamento à vista: <span class="final-price">R$ {$total|number_format:2:",":"."}</span></span>
                </p>
                <div class="numbers-card-field">
                    <label for="mastercard">Digite os 6 (seis) primeiros dígitos do seu cartão:</label>
                    <input type="text" name="mastercard" id="mastercard" class="input-box right input-card-numbers" disabled maxlength="6">
                </div>
                <div class="options-of-instalments">
                    <label for="parcelas_mastercard" class="monthly-instalments">Escolha as parcelas:</label>
                    <div class="select-option">
                        <span>01x de R$ {$total|number_format:2:",":"."}</span>
                        <select class="select-parcelas" name="parcelas_mastercard" id="parcelas_mastercard" disabled>
                            <option value="1">01x de R$ {$total|number_format:2:",":"."}</option>
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
                    <span class="cash-payment">Pagamento à vista: <span class="final-price">R$ {$total|number_format:2:",":"."}</span></span>  <br>
                </p>
                <div class="numbers-card-field">
                    <label for="americanexpress">Digite os 6 (seis) primeiros dígitos do seu cartão:</label>
                    <input type="text" name="americanexpress" id="americanexpress" class="input-box right input-card-numbers" disabled maxlength="6">
                </div>
                <div class="options-of-instalments">
                    <label for="parcelas_americanexpress" class="monthly-instalments">Escolha as parcelas:</label>
                    <div class="select-option">
                        <span>01x de R$ {$total|number_format:2:",":"."}</span>
                        <select class="select-parcelas" name="parcelas_americanexpress" id="parcelas_americanexpress" disabled>
                            <option value="1">01x de R$ {$total|number_format:2:",":"."}</option>
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
                    <span class="cash-payment">Pagamento à vista: <span class="final-price">R$ {$total|number_format:2:",":"."}</span></span>
                </p>
                <div class="numbers-card-field">
                    <label for="diners">Digite os 6 (seis) primeiros dígitos do seu cartão:</label>
                    <input type="text" name="diners" id="diners" class="input-box right input-card-numbers" disabled maxlength="6">
                </div>
                <div class="options-of-instalments">
                    <label for="parcelas_diners" class="monthly-instalments">Escolha as parcelas:</label>
                    <div class="select-option">
                        <span>01x de R$ {$total|number_format:2:",":"."}</span>
                        <select class="select-parcelas" name="parcelas_diners" id="parcelas_diners" disabled>
                            <option value="1">01x de R$ {$total|number_format:2:",":"."}</option>
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
            <a href="#" class="footer-button buy-more-items pagamento voltar">Voltar</a>
            <button type="submit" class="footer-button next-step">Avançar</button>
        </div>
    </form>
</div>

{include file="suggestion-products.tpl"}

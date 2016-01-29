
<script type="text/javascript">
    document.cepEndereco = {$info['DS_CEP_CASO']};
    document.basePath = '{$basePath}';</script>
<div class="my-cart-steps clearfix">
    <div class="steps step-1 current">Etapa 1 - Carrinho</div>
    <div class="steps step-2">Etapa 2 - Endereço / Pagamento</div>
    <div class="steps step-3">Etapa 3 - Confirmação</div>
</div>

<div class="carrinho-lista">    

    {*<div class="mycart-buttons clearfix">
    <a href="{$this->url([], "loja", TRUE)}" class="mycart-button voltar">Comprar mais</a>
    <a href="#" class="mycart-button avancar">Avançar</a>
    </div>*}

    <div class="mycart-buttons clearfix">
        <a href="{$this->url([], $this->btn_comprar_mais, TRUE)}" class="mycart-button carrinho voltar">Comprar mais</a>
        <a href="#" class="mycart-button carrinho avancar">Avançar</a>
    </div>

    <div id="mycart-content-header">
        <p class="header-amount">Quantidade</p>
        <p class="header-value">Valor</p>
        <p class="header-value">Desconto</p>
        <p class="header-total">Total</p>
    </div>

    <ul id="mycart-content-list">
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

            {*if !$valorCredito and $compra_niver == 1 and $dadosProduto['valor_total_desconto']}
                {assign var=desconto value=$dadosProduto['total_produto'] - $dadosProduto['valor_total_desconto']}
            {*else}
                {assign var=desconto value=0}
            {*/if*}

            {if $valorCredito and $compra_niver != 1}
                {if $valorCredito <= $dadosProduto['total_produto'] and !isset($sobraCredito)}
                    {assign var=desconto value=$dadosProduto['total_produto'] - $dadosProduto['valor_total_desconto']}
                    {assign var=sobraCredito value=0}
                {else}
                    {if !isset($sobraCredito)}
                        {assign var=desconto value=$dadosProduto['total_produto']}
                        {assign var=sobraCredito value=$dadosProduto['total_produto'] - $valorCredito}
                    {elseif $compra_niver == 1}
                        {assign var=sobraCredito value=abs($sobraCredito)}
                        {if $sobraCredito <= $dadosProduto['total_produto']}
                            {assign var=desconto value=$sobraCredito}
                            {assign var=sobraCredito value=0}
                        {else}
                            {assign var=sobraCredito value=$dadosProduto['total_produto'] - $sobraCredito}
                            {assign var=desconto value=$dadosProduto['total_produto']}
                        {/if}
                    {/if}
                {/if}
            {else}
                {assign var=desconto value=0}
                {assign var=sobraCredito value=0}
            {/if}

            {if $desconto}
                {assign var=totalDesconto value=$totalDesconto + $desconto}
            {/if}

            <!-- Verifica se valor do produto é promocional ou não -->
            {if $dadosProduto['vl_promo'] eq "" or $dadosProduto['vl_promo'] eq 0}
                {assign var="valor_produto" value=$dadosProduto['valor']}
            {else}
                {assign var="valor_produto" value=$dadosProduto['vl_promo']}
            {/if}
            {if $dadosProduto['tipo'] neq 9}
                <li class="mycart-content-item" data-idestoque="{$dadosProduto['idestoque']}" data-valorproduto="{$valor_produto}" data-desconto="{$desconto}">
                    <div class="mycart-content-img">
                        <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>82, 'altura'=>90, 'imagem'=>$foto_completa], "imagem", TRUE)}">
                    </div>

                    <div class="mycart-content-description">
                        <p class="mycart-content-name">
                            {utf8_decode($dadosProduto['nome'])}                                                        
                        </p>
                        <p class="mycart-content-info">
                            {$dadosProduto['sigla']}                            
                        </p>
                    </div>

                    <div class="mycart-content-amount">
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

                    <div class="mycart-content-value">
                        <p>
                            {if $valor_produto eq 0}
                                Grátis
                            {else}
                                R$ {$dadosProduto['total_produto']|number_format:2:",":"."}
                            {/if}
                        </p>
                    </div>

                    <div class="mycart-content-desconto">
                        <p>
                            R$ {$desconto|number_format:2:",":"."}
                        </p>
                    </div>

                    <div class="mycart-content-total">
                        <p>
                            {if $valor_produto eq 0}
                                Grátis
                            {else}
                                R$ {$dadosProduto['valor_total_desconto']|number_format:2:",":"."}
                            {/if}
                        </p>
                    </div>

                    <div class="mycart-content-remove">
                        <a title="Remover produto" class="remove-product" href="{$this->url(["idestoque"=>{$dadosProduto['idestoque']}], 'removercarrinho', TRUE)}">Remover Item</a>
                    </div>
                </li>
            {else}
                {assign var="foto" value="{$dadosProduto['codigo']}"}
                {assign var="extensao" value="{$dadosProduto['path']}"}
                {assign var="foto_completa" value="{$foto}.{$extensao}"}
                <li class="mycart-content-item" data-idproduto="{$dadosProduto['codigo']}" data-valorproduto="{$valor_produto}" data-desconto="{$desconto}">
                    <div class="mycart-content-img">
                        <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>82, 'altura'=>90, 'imagem'=>$foto_completa], "imagem", TRUE)}">
                    </div>

                    <div class="mycart-content-description">
                        <p class="mycart-content-name">{utf8_decode($dadosProduto['nome'])}</p>
                        <p class="mycart-content-info">
                            {$dadosProduto['sigla']}
                            <input type="text" class="field" name="emailganhadoraux" id="emailganhadoraux" onchange="changeEmailGanhador()"  placeholder="Insira o email do ganhador" style="width: 70%; padding: 5px;   border: 1px solid; border-color: #6EC6A4;">
                        </p>
                    </div>

                    <div class="mycart-content-amount">
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

                    <div class="mycart-content-value">
                        <p>
                            {if $valor_produto eq 0}
                                Grátis
                            {else}
                                R$ {$dadosProduto['total_produto']|number_format:2:",":"."}
                            {/if}
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
                        <a title="Remover produto" class="remove-product" href="{$this->url(["idproduto"=>{$dadosProduto['codigo']}], 'removercarrinho', TRUE)}">Remover Item</a>
                    </div>
                </li>
            {/if}
        {/foreach}
    </ul>

    <div id="mycart-subtotal-carrinho" class="clearfix"  data-usuario="{$tipo_usuario}" data-quantidade="{$quantidade_total}" data-subtotal="{$subtotal}" data-cep="{$info['DS_CEP_CASO']}" data-frete="{$frete}" data-desconto="{$valor_desconto}" data-total="{$total}">
        <p>
            <span class="left total-itens">
                TOTAL DE ITENS
            </span>
            <span class="right total-itens">
                {$quantidade_total}
            </span>
        </p> <br />
        <p>
            <span class="left">
                SUB TOTAL
            </span>
            <span class="right">
                R$ {$subtotal|number_format:2:",":"."}
            </span>
        </p>
    </div>

    <div class="clearfix"></div>

    <div class="mycart-buttons clearfix">
        <a href="{$this->url([], $this->btn_comprar_mais, TRUE)}" class="mycart-button carrinho voltar">Comprar mais</a>
        <a href="#" class="mycart-button carrinho avancar">Avançar</a>
    </div>
</div>
<div class="carrinho-pagamento" style="display: none;">
    <form id="mycart-payment" action="{$this->url([], "fazerpedido2", TRUE)}" method="post">
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
            <li class="mycart-address-item active" data-cep="{$info['DS_CEP_CASO']}" data-endereco_id="0">
                <p class="mycart-address-text">
                    <strong>{$info['DS_NOME_CASO']}</strong> <br>
                    {$this->utf8($info['DS_ENDERECO_CASO'])}, {$info['DS_NUMERO_CASO']} {if $info['DS_COMPLEMENTO_CASO']} - {$info['DS_COMPLEMENTO_CASO']}{/if} <br>
                    {$info['DS_BAIRRO_CASO']} <br>
                    {$info['DS_CIDADE_CASO']} {$info['DS_UF_CASO']} - {$info['DS_CEP_CASO']}
                </p>
                <label class="mycart-use-address">
                    <span>Endereço selecionado</span>
                    <input type="hidden" name="usar_mesmo" value="1" />
                </label>
                <!-- <button class="mycart-edit-address"> Editar </button> -->
            </li>
            {foreach from=$dadosEnderecos item=endereco}
                <li class="mycart-address-item" data-cep="{$endereco->DS_CEP_ENRC}" data-endereco_id="{$endereco->NR_SEQ_ENDERECO_ENRC}">
                    <p class="mycart-address-text">
                        <strong>{$endereco->DS_DESTINATARIO_ENRC}</strong> <br>
                        {$this->utf8($endereco->DS_ENDERECO_ENRC)}, {$endereco->DS_NUMERO_ENRC} {if $endereco->DS_COMPLEMENTO_ENRC} - {$endereco->DS_COMPLEMENTO_ENRC}{/if} <br>
                        {$endereco->DS_BAIRRO_ENRC} <br>
                        {$endereco->DS_CIDADE_ENRC} {$endereco->DS_UF_ENRC} - {$endereco->DS_CEP_ENRC}
                    </p>
                    <label class="mycart-use-address">
                        <span>Usar esse endereço</span>
                    </label>
                    <button class="mycart-edit-address"> Editar </button>
                </li>
            {/foreach}
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
                <li class="mycart-payment-item boleto">
                    <label class="mycart-payment-radio">
                        <input type="radio" name="formapagto" value="boleto" />
                        <span class="radio-icon"></span>
                        <div class="mycart-payment-flags">
                            <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/boleto.png" width="45" height="29" alt="Boleto">
                        </div>
                        <span class="label">Boleto bancário</span>
                    </label>
                </li>
                <li class="mycart-payment-item payment-card">
                    <label class="mycart-payment-radio">
                        <input type="radio" name="formapagto" value="" /><!-- Esse value deve mudar de acordo com a bandeira do cartao -->
                        <span class="radio-icon"></span>
                        <div class="mycart-payment-flags cards">
                            <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/visa.png" data-cartao="visa" width="45" height="29" alt="Cartão de crédito - Visa">
                            <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/master.png" data-cartao="mastercard" width="45" height="29" alt="Cartão de crédito - Mastercard">
                            <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/american-express.png" data-cartao="amex" width="45" height="29" alt="Cartão de crédito - American Express">
                            <!-- <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/diners.png" data-cartao="diners" width="45" height="29" alt="Cartão de crédito - Diners"> -->
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

        <div id="mycart-subtotal" class="clearfix" data-usuario="{$tipo_usuario}" data-quantidade="{$quantidade_total}" data-subtotal="{$subtotal}" data-cep="{$info['DS_CEP_CASO']}" data-frete="{$frete}" data-desconto="{$valor_desconto}" data-total="{$total}">
            <p>
                <span class="left">
                    SUBTOTAL
                </span>
                <span class="right">
                    R$ {$total|number_format:2:",":"."}
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
                    R$ {$dadosProduto['total_produto']|number_format:2:",":"."}
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

                <img src="{$basePath}/arquivos/default/images/icon@2x/codigo_cartao.jpg" width="188" height="122" alt="Cartão de crédito - Visa">
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
                <img src="{$basePath}/arquivos/default/images/loader.gif" width="32" height="32" alt="Carregando" style="margin-left: auto; margin-right: auto; width: 32px; display: block;">
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
{*<script type="text/javascript">*}
{*var btnSubmit = document.getElementsByClassName('mycart-button pedido avancar')[0];*}
{*btnSubmit.onclick = function(){*}
{*window.btn_clicked = true;*}
{*};*}

{*window.onbeforeunload = function (e) {*}
{*if(!window.btn_clicked){*}

{*var xmlhttp;*}

{*if (window.XMLHttpRequest) {*}
{*// code for IE7+, Firefox, Chrome, Opera, Safari*}
{*xmlhttp = new XMLHttpRequest();*}
{*} else {*}
{*// code for IE6, IE5*}
{*xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");*}
{*}*}

{*xmlhttp.onreadystatechange = function() {*}
{*if (xmlhttp.readyState == 4 ) {*}

{*}*}
{*}*}

{*xmlhttp.open("GET", document.basePath + "/index/close-checkout", true);*}
{*xmlhttp.send();*}
{*}*}
{*};*}
{*</script>*}
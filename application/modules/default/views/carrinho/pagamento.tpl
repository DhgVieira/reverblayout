{assign var=basePath value="/reverbcity.com"}

    <form id="mycart-payment" action="">
        <h2 class="rvb-title">Endereço de Envio</h2>
        <ul id="mycart-address-list">
            <!--
            Lista com elementos com endereços
            Elemento ativo precisa vir com:
            - checked="true" no input radio
            - Texto "Endereço selecionado" no span
            - class="active" no elemento de list (li)
            -->
            <li class="mycart-address-item active">
                <p class="mycart-address-text">
                    <strong>Caio Arias</strong> <br>
                    Rua Alagoas, 618 | ap 404 <br>
                    Centro <br>
                    Londrina Paraná - 86010-520
                </p>
                <label class="mycart-use-address">
                    <span>Endereço selecionado</span>
                    <input type="radio" name="endereco" value="4" />
                </label>
                <button class="mycart-edit-address"> Editar </button>
            </li>
            <li class="mycart-address-item">
                <p class="mycart-address-text">
                    <strong>Caio Arias</strong> <br>
                    Rua Alagoas, 618 | ap 404 <br>
                    Centro <br>
                    Londrina Paraná - 86010-520
                </p>
                <label class="mycart-use-address">
                    <span>Usar esse endereço</span>
                    <input type="radio" name="endereco" value="5" />
                </label>
                <button class="mycart-edit-address"> Editar </button>
            </li>
            <li class="mycart-address-item new-address">
                <a href="#" class="mycart-new-address md-trigger" data-modal="newaddress-lightbox"> + Novo Endereço </a>
            </li>
        </ul>

        <h2 class="rvb-title">Frete</h2>
        <div id="mycart-delivery-container">
            <div id="mycart-delivery-header">
                <span class="header-envio">Forma de envio</span>
                <span class="header-prazo">Prazo de entrega</span>
                <span class="header-valor">Valor do frete</span>
            </div>

            <ul id="mycart-delivery-list">
                <li class="mycart-delivery-item active">
                    <label class="mycart-delivery-radio">
                        <input checked="true" type="radio" name="frete" value="1" />
                        <span class="radio-icon"></span>
                        <span class="label">Sedex</span>
                    </label>

                    <p class="mycart-delivery-time">
                        2 dias úteis
                    </p>

                    <p class="mycart-delivery-value">
                        R$ 11,00
                    </p>
                </li>

                <li class="mycart-delivery-item">
                    <label class="mycart-delivery-radio">
                        <input type="radio" name="frete" value="2" />
                        <span class="radio-icon"></span>
                        <span class="label">PAC</span>
                    </label>

                    <p class="mycart-delivery-time">
                        12 dias úteis
                    </p>

                    <p class="mycart-delivery-value">
                        R$ 1,00
                    </p>
                </li>

                <li class="mycart-delivery-item">
                    <label class="mycart-delivery-radio">
                        <input type="radio" name="frete" value="3" />
                        <span class="radio-icon"></span>
                        <span class="label">TAM</span>
                    </label>

                    <p class="mycart-delivery-time">
                        4 dias úteis
                    </p>

                    <p class="mycart-delivery-value">
                        R$ 13,00
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
                    <input name="cupom" type="text" placeholder="Insira o código" />
                    <button id="mycart-discount-button" type="button">Atualizar</button>
                </div>

                <div id="mycart-discount-value">
                    R$ 0,00
                </div>
            </div>
        </div>

        <h2 class="rvb-title">Pagamento</h2>
        <div id="mycart-payment-container">
            <ul id="mycart-payment-list">
                <li class="mycart-payment-item active">
                    <label class="mycart-payment-radio">
                        <input checked="true" type="radio" name="pagamento" value="1" />
                        <span class="radio-icon"></span>
                        <div class="mycart-payment-flags">
                            <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/boleto.png" width="45" height="29" alt="Boleto">
                        </div>
                        <span class="label">Boleto bancário</span>
                    </label>
                </li>
                <li class="mycart-payment-item payment-card">
                    <label class="mycart-payment-radio">
                        <input type="radio" name="pagamento" value="2" />
                        <span class="radio-icon"></span>
                        <div class="mycart-payment-flags">
                            <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/visa.png" width="45" height="29" alt="Cartão de crédito - Visa">
                            <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/master.png" width="45" height="29" alt="Cartão de crédito - Mastercard">
                            <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/american-express.png" width="45" height="29" alt="Cartão de crédito - American Express">
                            <img src="{$basePath}/arquivos/default/images/selos-pagamentos@2x/diners.png" width="45" height="29" alt="Cartão de crédito - Diners">
                        </div>
                        <span class="label">Cartões de crédito</span>
                    </label>

                    <div class="mycart-payment-fields">
                        <div class="field-group">
                            <label for="nome_portador">Nome do portador</label>
                            <input class="field" type="text" id="nome_portador" name="nome_portador" />
                        </div>

                        <div class="clearfix"></div>

                        <div class="field-group">
                            <label for="numero_cartao">Número do cartão</label>
                            <input class="field" type="text" id="numero_cartao" name="numero_cartao" />
                        </div>

                        <div class="clearfix"></div>

                        <div class="field-group">
                            <label>Vencimento</label>
                            <div id="vencimento_mes" class="field fake-select">
                                <span>01</span>
                                <select name="vencimento_mes">
                                    <option value="01">01</option>
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
                                <span>2011</span>
                                <select name="vencimento_ano">
                                    <option value="2011">2011</option>
                                    <option value="2012">2012</option>
                                    <option value="2013">2013</option>
                                    <option value="2014">2014</option>
                                    <option value="2015">2015</option>
                                    <option value="2016">2016</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                </select>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="field-group">
                            <label for="cod_seguranca">Cód. segurança</label>
                            <input class="field" type="text" id="cod_seguranca" name="cod_seguranca" />
{*                            <a href="#" class="question-icon md-trigger" data-modal="codigo-lightbox" title="O que é isso?">O que é</a>*}
                        </div>

                        <div class="clearfix"></div>

                        <div class="field-group">
                            <label>Parcelamento</label>
                            <div class="field fake-select">
                                <span>A Vista 145,00</span>
                                <select name="parcelamento">
                                    <option value="1">A Vista 145,00</option>
                                    <option value="2">2 x 72,50</option>
                                    <option value="3">3 x 48,34</option>
                                </select>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <p class="mycart-payment-description">
                            As compras podem passar por uma verificação de autenticidade do titular do cartão e
                            a compra, passa a valer apenas após a confirmação dos dados pela operadora.
                        </p>

                    </div>
                </li>
            </ul>
        </div>

        <div id="mycart-subtotal" class="clearfix">
            <p>
                <span class="left">
                    SUBTOTAL
                </span>
                <span class="right">
                    R$130,00
                </span>
            </p>
            <p>
                <span class="left">
                    FRETE (SEDEX 2 DIAS ÚTEIS)
                </span>
                <span class="right">
                    R$12,00
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
                    R$130,00
                </span>
            </p>
        </div>

        <div class="clearfix"></div>

        <div class="mycart-buttons clearfix">
            <a href="{$this->url([], "loja", TRUE)}" class="mycart-button voltar">Voltar</a>
            <a href="#" class="mycart-button avancar">Avançar</a>
        </div>
    </form>

</div>

<div class="md-modal md-effect-1" id="newaddress-lightbox">
    <div class="md-content">
        <p class="md-title">Endereço de entrega</p>
        <button class="md-close ir">Fechar</button>
        <div class="exter">
            <form action="{$this->url([], "avisemeproduto", TRUE)}" method="POST">
                <div class="md-bg">
                    <div class="col">
                        <input class="field" type="text" id="newaddress-nome" name="nome" placeholder="Nome">

                        <input class="field" type="text" id="newaddress-cep" name="cep" placeholder="CEP">
                        <button type="button" id="newaddress-pesquisa">Pesquisar</button>

                        <input class="field" type="text" id="newaddress-endereco" name="endereco" placeholder="Endereço">
                        <input class="field" type="text" id="newaddress-numero" name="numero" placeholder="Número">

                        <input class="field" type="text" id="newaddress-complemento" name="complemento" placeholder="Complemento">
                        <input class="field" type="text" id="newaddress-bairro" name="bairro" placeholder="Bairro">

                        <div id="newaddress-estado" class="field fake-select">
                            <span>Estado</span>
                            <select name="estado"></select>
                        </div>
                        <div id="newaddress-cidade" class="field fake-select">
                            <span>Cidade</span>
                            <select name="cidade"></select>
                        </div>
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


<div class="md-modal md-effect-1" id="codigo-lightbox">
    <div class="md-content">
        <p class="md-title">Código de segurança</p>
        <button class="md-close ir">Fechar</button>
        <div class="exter">
            <div class="md-bg">
                <p class="md-description">
                    Texto explicando onde fica o cógio et als. Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis.
                </p>

{*                <img src="{$basePath}/arquivos/default/images/icon@2x/codigo_cartao.jpg" width="188" height="122" alt="Cartão de crédito - Visa">*}
            </div>
            <p class="md-description">
                Caso haja algum problema, entre em contato através do 
                <a href="mailto:atendimento@reverbcity.com" target="_blank">atendimento@reverbcity.com</a>
            </p>
       </div>
    </div>
</div>

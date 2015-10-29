        <div class="modal-wraps" id="resumo-pedidos">
            <div class="modal-wraps-body" id="resumo-pedidos-body">
                <h3 class="fs22 resumo-pedidos-title">Resumo do pedido</h3>
                <ul class="posa header-helpers compras-modal-actions">
                    <li class="resumo-modal-action-items nl lt">
                        <a class="header-helpers-actions new-action" href="#"></a>
                    </li>
                    <li class="resumo-modal-action-items nl lt">
                        <a class="header-helpers-actions email-action" href="#"></a>
                    </li>
                    <li class="resumo-modal-action-items nl lt">
                        <a class="header-helpers-actions print-action" href="#"></a>
                    </li>
                    <li class="resumo-modal-action-items nl lt">
                        <a class="header-helpers-actions close-parent" href="#"></a>
                    </li>
                </ul>
                <div class="resumo-pedidos-content bs posr fw lt">
                    <div class="resumo-pedidos-top-blocks bs posr fw lt">
                        <a href="" class="resumo-pedidos-top-btns">Alterar</a>
                        <a href="" class="resumo-pedidos-top-btns">2º via Boleto</a>
                        <a href="" class="resumo-pedidos-top-btns">Observações</a>
                    </div>
                    <div class="resumo-pedidos-top-infos bs posr fw lt">
                        <strong>Compra No 77740 feita em 10/06/2014 as 17:28</strong>
                    </div>
                    <div class="modal-compras-tables posr fw lt">
                        <table class="fw lt posr compras-tables">
                            <thead class="modal-compras-thead">
                                <tr class="tmd fs13">
                                    <th class="compras-th th-img">IMAGEM</th>
                                    <th class="compras-th th-nome">PRODUTO</th>
                                    <th class="compras-th th-ref">REF</th>
                                    <th class="compras-th th-siz">SIZE</th>
                                    <th class="compras-th th-val">VALOR</th>
                                    <th class="compras-th th-pag">VALOR PAGO</th>
                                    <th class="compras-th th-qtd">QTD.</th>
                                </tr>
                            </thead>
                            <tbody class="compras-tbody">
                            {for $i = 1 to 2}
                                <tr class="tmd fs13">
                                    <td class="compras-td td-img"><img src="https://api.fnkr.net/testimg/55x62/00CED1/FFF/?text=img+placeholder"></td>
                                    <td class="compras-td td-nome">Julian Casablancas - Masc</td>
                                    <td class="compras-td td-ref">280</td>
                                    <td class="compras-td td-siz">P</td>
                                    <td class="compras-td td-val">R$ 69,00</td>
                                    <td class="compras-td td-pag">R$ 29,90</td>
                                    <td class="compras-td td-qtd">1</td>
                                </tr>
                                {/for}
                            </tbody>
                            <tfoot class="">
                                <tr class="compras-tfoots-rows tmd">
                                    <td class="compras-tf" colspan="4">&nbsp;</td>
                                    <td class="compras-tf">SUBTOTAL</td>
                                    <td class="compras-tf">145,90</td>
                                    <td class="compras-tf"></td>
                                </tr>
                                <tr class="compras-tfoot-tools tmd">
                                    <td colspan="4">
                                        <div class="posr fw lt fretes-boxes">
                                            <div class="lt fretes-pairs">
                                                <label class="frete-pairs-blocks" for="input-frete">Frete Real</label>
                                                <input class="frete-pairs-blocks compras-tiny-input" type="frete" id="input-frete" name="frete">
                                            </div>
                                            <div class="lt fretes-pairs">
                                                <button class="lt frete-pairs-blocks compras-tiny-buttons">Lançar</button>
                                                <div class="lt frete-pairs-blocks forma-envio">ENVIO: <strong>PACK</strong></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fs13">
                                        FRETE
                                    </td>
                                    <td class="fs13" align="center">
                                        <input class="compras-tiny-input" type="frete" id="input-frete" name="frete" value="12,98">
                                    </td>
                                    <td>
                                        <button class="compras-tiny-buttons" id="edit-compras-envio">Alterar</button>
                                    </td>
                                </tr>
                                <tr class="tmd compras-total-tfoots-rows">
                                    <td class="compras-tf compras-subtotal-tf" colspan="4">&nbsp;</td>
                                    <td class="compras-tf compras-subtotal-tf"><strong>SUBTOTAL</strong></td>
                                    <td class="compras-tf compras-subtotal-tf"><strong>145,90</strong></td>
                                    <td class="compras-tf compras-subtotal-tf"><strong>2</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        <ul class="compras-infos-lists nm np posr fw lt">
                            <li class="compras-infos-items nl bs posr">
                                <div class="lt">IP da Compra</div>
                                <div class="rt"><strong>123.656.32.989</strong></div>
                            </li>
                            <li class="compras-infos-items nl bs posr">
                                <div class="fw rt posr">
                                    <div class="compras-balls-2">
                                        <span class="compras-ball bs fs12">A</span>
                                    </div>
                                </div>
                            </li>
                            <li class="compras-infos-items nl bs posr">
                                <div class="lt">Forma de Pagamento</div>
                                <div class="rt"><img class="vmiddle" src="{$basePath}/arquivos/painel/images/master.png" alt=""></div>
                            </li>
                            <li class="compras-infos-items nl bs posr">
                                <div class="lt">Mudança de Status</div>
                                <div class="rt"><strong>10/01/2014</strong></div>
                            </li>
                            <li class="compras-infos-items nl bs posr">
                                <div class="lt">Parcelas</div>
                                <div class="rt"><strong>2</strong></div>
                            </li>
                            <li class="compras-infos-items nl bs posr">
                                <div class="lt">
                                    <label class="lt" for="rastreamento">Rastreamento</label>
                                    <input class="lt bs compras-infos-items-inputs rastreamento" id="rastreamento" type="text">
                                    <button class="compras-infos-items-button" id="rastreamento-btn">ALTERAR</button>
                                </div>
                            </li>
                            <li class="compras-infos-items nl bs posr">
                                <div class="lt">
                                    <label for="tid">TID</label>
                                    <input class="bs compras-infos-items-inputs tid" id="tid" type="text">
                                </div>
                                <div class="rt"><button id="tid-btn" class="compras-infos-items-button">ENVIAR</button></div>
                            </li>
                            <li class="compras-infos-items nl bs posr">
                                <div class="lt">
                                    <label for="etq">Etiqueta Posição</label>
                                </div>
                                <div class="rt">
                                    <input class="bs compras-infos-items-inputs etq" id="etq" type="text">
                                    <button id="etq-btn" class="compras-infos-items-button">GERAR</button>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-compras-addrs-infos posr fw lt">
                        <div class="addr-infos-titles posr bs">
                            ENDEREÇO E DADOS DO COMPRADOR
                            <button class="modal-addr-edit rt">EDITAR</button>
                        </div>
                        <div class="addr-infos-details fw lt bs">
                            <div class="addr-infos-details-items">Nome: Caio Arias</div>
                            <div class="addr-infos-details-items">Nascimento: 02/04/1985</div>
                            <div class="addr-infos-details-items">Endereço: Rua Alagoas, 618 - Ap 404</div>
                            <div class="addr-infos-details-items">Documento: 043.337.839-55</div>
                            <div class="addr-infos-details-items">Londrina/PR, Brasil</div>
                            <div class="addr-infos-details-items">E-mail: caioarias@outlook.com</div>
                            <div class="addr-infos-details-items">CEP 86010520 - Centro</div>
                            <div class="addr-infos-details-items">Fone: (43) 8441-7025 ou (43) 3354-7025</div>
                        </div>
                    </div>
                    <div class="modal-compras-last-shoppings">
                        <div class="posr fw lt bs last-shopping-titles">
                            ÚLTIMOS PEDIDOS DO CLIENTE
                        </div>
                        <div class="posr fw lt bs last-shopping-tables">
                            <table class="posr fw lt fs12 last-shopping-table">
                                <thead>
                                    <tr class="last-shopping-th-tr">
                                        <th class="last-shopping-th">NUMERO</th>
                                        <th class="last-shopping-th">DATA</th>
                                        <th class="last-shopping-th">QTDE.</th>
                                        <th class="last-shopping-th">PAGAMENTO</th>
                                        <th class="last-shopping-th">TOTAL</th>
                                        <th class="last-shopping-th">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {for $c = 0 to 2}
                                    <tr class="last-shopping-trs">
                                        <td class="last-shopping-tds">
                                            <div class="wrap-last-shopping">
                                                234578
                                            </div>
                                        </td>
                                        <td class="last-shopping-tds">
                                            <div class="wrap-last-shopping">
                                                10/06/2015 15:55
                                            </div>
                                        </td>
                                        <td class="last-shopping-tds">
                                            <div class="wrap-last-shopping">
                                                3
                                            </div>
                                        </td>
                                        <td class="last-shopping-tds">
                                            <div class="wrap-last-shopping">
                                                <img src="{$basePath}/arquivos/painel/images/boleto.png" alt="">
                                            </div>
                                        </td>
                                        <td class="last-shopping-tds">
                                            <div class="wrap-last-shopping">
                                                768.87
                                            </div>
                                        </td>
                                        <td class="last-shopping-tds">
                                            <div class="wrap-last-shopping">
                                                <div class="compras-balls-2">
                                                    <span class="compras-ball bs fs12">A</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    {/for}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="resumo-pedidos-bottom bs posr">
                    <hr class="resumo-pedidos-hr lt">
                    <div class="lt">
                        <a href="#" class="rt cancel-button type-2 reverb-btns-1"> Sair! Cancelar <span class="ico"></span> </a>
                    </div>
                    <div class="rt">
                        <label for="new-topic-step-2" class="fs13 cells nap bs grn-btn green-btn-1 min plus-check"> OK, Salvar! </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-wraps" id="nfe-block">
            <div class="modal-wraps-body bs" id="nfe-modal">
                <h3 class="fs22 resumo-pedidos-title fw lt" id="nfe-modal-title">NFE</h3>
                <ul class="posa header-helpers compras-modal-actions">
                    <li class="resumo-modal-action-items nl lt">
                        <a class="header-helpers-actions close-parent" href="#"></a>
                    </li>
                </ul>
                <div class="posr bs nfe-modal-body">
                    <label class="fs13 nfe-labels" for="nfe-modal-input">Selecione a pasta que deseja salvar a NFE</label>
                    <div class="reverb-input-1 select-1">
                        <select class="select bs" id="categoria" name="NR_SEQ_CATEGORIA_BLRC"></select>
                        <span class="select-value">Selecione</span>
                    </div>
                    <hr class="nfe-modal-hr lt">
                    <div class="lt">
                        <a href="#" class="rt cancel-button type-2 tmd reverb-btns-1"> Não! Cancelar <span class="ico"></span> </a>
                    </div>
                    <div class="rt">
                        <label for="new-topic-step-2" class="fs13 cells tmd nap bs grn-btn green-btn-1 min plus-check"> Sim, Salvar! </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-wraps" id="filtros-block">
            <div class="modal-wraps-body bs" id="compras-filtros-modal">
                <h3 class="fs22 resumo-pedidos-title fw lt" id="filtro-modal-title">Filtro</h3>
                <ul class="posa header-helpers compras-modal-actions">
                    <li class="resumo-modal-action-items nl lt">
                        <a class="header-helpers-actions close-parent" href="#"></a>
                    </li>
                </ul>
                <div class="posr bs filtro-modal-body">
                    <label class="fs13 nfe-labels" for="nfe-modal-input">Escolha uma ou mais opções para filtrar a lista de compras</label>
                    <div class="posr fw lt">
                        <div class="posr fw lt">
                            <div class="nfe-modal-elements nfe-modal-elements-1">
                                <div class="nfe-modal-element-wrap">
                                    <input type="text" class="bs nfe-modal-input-elements" name="nome_filtro">
                                </div>
                            </div>
                            <div class="nfe-modal-elements nfe-modal-elements-1">
                                <div class="nfe-modal-element-wrap">
                                    <input type="email" class="bs nfe-modal-input-elements" name="email_filtro">
                                </div>
                            </div>
                        </div>
                        <div class="posr fw lt">
                            <div class="nfe-modal-elements nfe-modal-elements-1">
                                <div class="nfe-modal-element-wrap">
                                    <input type="text" class="bs nfe-modal-input-elements" name="cpf_filtro">
                                </div>
                            </div>
                            <div class="nfe-modal-elements nfe-modal-elements-1">
                                <div class="nfe-modal-element-wrap">
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs" id="categoria" name="filtro_compras_aberto"></select>
                                        <span class="select-value">Compras em Aberto</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="posr fw lt">
                            <div class="nfe-modal-elements nfe-modal-elements-2">
                                <div class="reverb-input-1 select-1">
                                    <select class="select bs" id="uf" name="filtro_compras_uf"></select>
                                    <span class="select-value">Selecione</span>
                                </div>
                            </div>
                            <div class="nfe-modal-elements nfe-modal-elements-3">
                                <div class="reverb-input-1 select-1">
                                    <select class="select bs" id="cidade" name="filtro_compras_cidade"></select>
                                    <span class="select-value">Selecione</span>
                                </div>
                            </div>
                            <div class="nfe-modal-elements nfe-modal-elements-4">
                                <div class="nfe-modal-element-wrap">
                                    <input type="text" class="bs nfe-modal-input-elements" name="filtro_n_pedido" placeholder="Nº Pedido">
                                </div>
                            </div>
                        </div>
                        <hr class="filtros-modal-hr fw lt">
                        <div class="lt">
                            <a href="#" class="rt cancel-button type-2 tmd reverb-btns-1"> Não! Cancelar <span class="ico"></span> </a>
                        </div>
                        <div class="rt">
                            <label for="new-topic-step-2" class="fs13 cells tmd nap bs grn-btn green-btn-1 min plus-check"> Sim, Filtrar! </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site > Compras
                </div>
                <div id="header-section-name">
                    Compras
                    <div class="header-helpers">
                        <a href="#" class="header-helpers-actions" id="new-action"></a>
                        <a href="#" class="header-helpers-actions" id="email-action"></a>
                        <a href="#" class="header-helpers-actions" id="print-action"></a>
                    </div>
                </div>
            </header>
            <div class="lt bs posr container-contents" id="indicacoes-body">
                <div class="container">
                    <div class="row above-thead">
                        <div class="t-head-options bs fs11 select-2">
                            <select class="select bs" id="loteoptions" name="loteoptions">
                                <option value="" selected disabled>Selecione</option>
                                <option value="1">Opção 1</option>
                                <option value="1">Opção 2</option>
                            </select>
                            <span class="select-value">Opção </span>
                        </div>
                        <button class="head-cells fs13 cells nap bs grn-btn plus-check green-btn-auto posr">Aplicar</button>
                        <div class="tiny-block lt first">
                            <label class="tiny-head-labels lt" for="nfe">Gerar NFE:</label>
                            <input class="tiny-head-inputs lt" type="text" id="nfe" name="nfe" placeholder="999">
                            <button class="tiny-block-submit lt">GERAR!</button>
                        </div>
                        <div class="tiny-block lt last">
                            <label class="tiny-head-labels lt" for="nfe">Gerar NFE:</label>
                            <input class="tiny-head-inputs lt" type="text" id="nfe" name="nfe" placeholder="999">
                            <button class="tiny-block-submit lt">GERAR!</button>
                        </div>
                        <button class="gray-btn-1 gray-btn lt">
                            Filtros
                            <span class="ico-contextual"></span>
                        </button>

                        <form action="{$this->url(['module' => 'painel', 'controller' => 'compras', 'action' => 'busca'], null, true)}" method="post">
                            <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                            <input type="text" class="thead-search-field min rt bs" name="termo" value="{$busca}">
                        </form>
                    </div>
                    <table class="fw financeiro-tables" id="indicacao-table">
                        <thead class="table-heads indica-head">
                            <tr>
                                <th class="th-cells head-chck"></th>
                                <th class="th-cells head-numb">Nº</th>
                                <th class="th-cells head-date">DATA COMPRA</th>
                                <th class="th-cells head-name">NOME</th>
                                <th class="th-cells head-pgto">PAGAMENTO</th>
                                <th class="th-cells head-vals">VALOR TOTAL</th>
                                <th class="th-cells head-stat">STATUS</th>
                                <th class="th-cells th-options th-big-options">OPÇÕES</th>
                            </tr>
                        </thead>

                        <tbody class="tables-body banners-body financeiro-tbody">
                            {foreach from=$dadosCompras item=compra}
                                <tr class="green">
                                    <td class="tb-cells posr body-chck">
                                        <div class="wrap-checkbox wrap-reverb-checkbox-2">
                                            <input class="checkbox" type="checkbox" id="checkbox-{$i}" checked>
                                            <label class="styled-reverb-checkbox" for="checkbox-{$i}"></label>
                                        </div>
                                    </td>
                                    <td class="tb-cells posr body-numb"> <div>{$compra->NR_SEQ_COMPRA_COSO}</div> </td>
                                    <td class="tb-cells posr body-date"> <div>{$compra->DT_COMPRA_COSO|date_format:"%d/%m/%Y %H:%M:%S"}</div> </td>
                                    <td class="tb-cells posr body-name"> <div>{$compra->DS_NOME_CASO}</div> </td>
                                    <td class="tb-cells posr body-pgto">
                                        <div>
                                            {if $compra->DS_FORMAPGTO_COSO == 'boleto'}
                                                <img src="{$basePath}/arquivos/painel/images/boleto.png" alt="">
                                            {elseif $compra->DS_FORMAPGTO_COSO == 'visa'}
                                                <img src="{$basePath}/arquivos/painel/images/visa.png" alt="">
                                            {elseif $compra->DS_FORMAPGTO_COSO == 'mastercard'}
                                                <img src="{$basePath}/arquivos/painel/images/master.png" alt="">
                                            {/if}
                                        </div>
                                    </td>
                                    <td class="tb-cells posr body-vals"><div>R$ {$compra->VL_TOTAL_COSO|number_format:2:",":"."}</div></td>
                                    <td class="tb-cells posr body-stat">
                                        <div class="compras-balls">
                                            <span class="compras-ball bs fs12">{$compra->ST_COMPRA_COSO}</span>
                                        </div>
                                    </td>
                                    <td class="tb-cells posr posr body-action has-pop-over last-col tb-big-options">
                                        <ul class="indica-actions-5 lt =bs">
                                            <li class="indica-items-2">
                                                <a class="indica-icos compras-print" href="#"></a>
                                            </li>
                                            <li class="indica-items-2">
                                                <a class="indica-icos compras-eyes" href="#"></a>
                                            </li>
                                            <li class="indica-items-2"> 
                                                <a class="indica-icos compras-edit" href="#"></a>
                                            </li>
                                            <li class="indica-items-2">
                                                <a class="indica-icos compras-repeat" href="#"></a>
                                            </li>
                                            <li class="indica-items-2">
                                                <a class="indica-icos compras-nope" href="#"></a>
                                            </li>
                                            <li class="indica-items-2">
                                                <a class="indica-icos compras-email" href="#"></a>
                                            </li>
                                        </ul>
                                        <div class="pop-over rt">
                                            <span class="open-pop-over">Opções</span>
                                            <div class="content-popover popover-7">
                                                <ul class="nm np  fs13 pop-over-list-1">
                                                    <li class="nl bs posr popover-items popover-items-1">
                                                        <span class="ico dd-compras-print"></span>
                                                        Imprimir
                                                    </li>
                                                    <li class="nl bs posr popover-items popover-items-1">
                                                        <span class="ico ico-dd-vis"></span>
                                                        Visualizar
                                                    </li>
                                                    <li class="nl bs posr popover-items popover-items-1">
                                                        <span class="ico ico-dd-edi"></span>
                                                        Editar cadastro
                                                    </li>
                                                    <li class="nl bs posr popover-items popover-items-1">
                                                        <span class="ico dd-compras-repeat"></span>
                                                        Recriar compras
                                                    </li>
                                                    <li class="nl bs posr popover-items popover-items-1">
                                                        <span class="ico ico-dd-mail"></span>
                                                        Eniar e-mail
                                                    </li>
                                                    <li class="nl bs posr popover-items popover-items-1">
                                                        <span class="ico dd-compras-check"></span>
                                                        Confirmar Pagamento
                                                    </li>
                                                    <li class="nl bs posr popover-items popover-items-1">
                                                        <span class="ico dd-compras-track"></span>
                                                        Compra Enviada
                                                    </li>
                                                    <li class="nl bs posr popover-items popover-items-1">
                                                        <span class="ico dd-compras-carrinho"></span>
                                                        Compra entregue
                                                    </li>
                                                    <li class="nl bs posr popover-items popover-items-1">
                                                        <span class="ico dd-compras-cell"></span>
                                                        SMS
                                                    </li>
                                                    <li class="nl bs posr popover-items popover-items-1">
                                                        <span class="ico ico-dd-twitter"></span>
                                                        Twitter
                                                    </li>
                                                    <li class="nl bs posr popover-items popover-items-1">
                                                        <span class="ico ico-dd-facebook"></span>
                                                        Facebook
                                                    </li>
                                                    <li class="nl bs posr popover-items-1 popover-delete-1">
                                                        <span class="ico ico-dd-exc"></span>
                                                        Excluir
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </div>
                </div>
            </div>
        </div>
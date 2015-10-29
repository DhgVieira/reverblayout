<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12" id="dash-crumb">
            Usuário &gt; Home
        </div>
        <div id="header-section-name">
            HOME
        </div>
    </header>
    <div class="lt bs posr" id="dash-body">
        <div class="lt gw bs pedidos-graph posr graph-blocks">
            <div class="graph-titles">PEDIDOS</div>
            <div class="wrap-pedidos-graph-choise"></div>
            <div class="graph-body graph-type-1">
                <svg class="svg-graph-type-1" id="pedidos-graph">
                    <g class="grid x-grid" id="xGrid">
                    </g>
                </svg>
                <div class="graph-datas cvs">
                    <ul class="datas-list">
                        {foreach from=$dadosPedidos item=item key=key name=name}
                            <li class="datas-items nl">
                                <input class="graph-params" type="hidden" name="{$item['data']}" value="{$item['pedidos']}">
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
            <ul class="pedidos-infos nm np">
                <li class="pedidos-infos-items nl bs lt posr">
                    <div class="dash-graph-note-label-1">PEDIDOS</div>
                    <div class="dash-graph-note-value-1">{$dadosPedidosDetalhe['total']}</div>
                </li>
                <li class="pedidos-infos-items nl bs lt posr hbrd">
                    <div class="dash-graph-note-label-1">CONFIRMADOS</div>
                    <div class="dash-graph-note-value-1">{$dadosPedidosDetalhe['confirmados']}</div>
                </li>
                <li class="pedidos-infos-items nl bs lt posr hbrd">
                    <div class="dash-graph-note-label-1">CANCELADOS</div>
                    <div class="dash-graph-note-value-1">{$dadosPedidosDetalhe['cancelados']}</div>
                </li>
                <li class="pedidos-infos-items nl bs lt posr hbrd">
                    <div class="dash-graph-note-label-1">TICKET MÉDIO</div>
                    <div class="dash-graph-note-value-1">R$ {$dadosPedidosDetalhe['ticket_medio']|number_format:2:",":"."}</div>
                </li>
                <li class="pedidos-infos-items nl bs lt posr hbrd">
                    <div class="dash-graph-note-label-1">MÉDIAS ITENS</div>
                    <div class="dash-graph-note-value-1">{$dadosPedidosDetalhe['item_medio']|number_format:2}</div>
                </li>
            </ul>
        </div>

        <div class="rt lw bs cadastros-graph posr graph-blocks">
            <div class="graph-titles">CADASTROS</div>
            <div class="graph-body graph-type-2 posr">
                <div class="graph-datas blocks">
                    <ul class="datas-list">
                        {foreach from=$dadosCadastrados item=item key=key name=name}
                            <li class="datas-items nl">
                                <input class="graph-params" type="hidden" name="{$item['data']}" value="{$item['compras']}" data-second="{$item['cadastrados']}">
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
        </div>

        <div class="lt gw bs aniversariantes-graph posr graph-blocks">
            <div class="graph-titles">ANIVERSARIANTES DE {$nomeMes|upper}</div>
            <div class="aniversariantes-dados">
                <div class="aniversariantes-blocks first">
                    <div class="dash-graph-note-label-1"> TOTAL </div>
                    <div class="dash-graph-note-value-1"> {$dadosAniversariantes['total']} </div>
                </div>
                <div class="aniversariantes-blocks middle">
                    <div class="dash-graph-note-label-1"> COMPRAS</div>
                    <div class="dash-graph-note-value-1"> {$dadosAniversariantes['compras']} </div>
                </div>
                <div class="aniversariantes-blocks">
                    <div class="dash-graph-note-label-1"> TOTAL R$</div>
                    <div class="dash-graph-note-value-1"> {$dadosAniversariantes['compras_total']|number_format:2:",":"."} </div>
                </div>
            </div>
            <div class="graph-body graph-type-3">
                <div class="graph-datas">
                    <div class="cake-icon"></div>
                    <canvas class="cake-cvs" width="100" height="100"></canvas>
                    <span class="cake-cvs-title">{$dadosAniversariantes['porcentagem']}%</span>
                    <input type="hidden" class="cake-cvs-val" value="{$dadosAniversariantes['porcentagem']}">
                    <div class="cake-legend">
                        % ANIVERSARIANTES QUE COMPRARAM
                    </div>
                </div>
            </div>
        </div>

        <div class="rt lw bs vendas-graph posr graph-blocks">
            <div class="graph-titles">MAIS VENDIDAS</div>
            <ul class="vendas-infos-lists fw nm np posr lt">
                {foreach from=$dadosCestas item=cesta}
                    <li class="vendas-items-items fw lt">
                        <div class="vendas-item-nome bs lt">{$cesta['nome_produto']}</div>
                        <div class="vendas-item-qntd bs rt">{$cesta['total']}</div>
                    </li>
                {/foreach}
            </ul>
        </div>

        <div class="fw lt acessos-graph posr graph-blocks">
            <div class="graph-titles">ACESSOS</div>

            <div class="gw lt acesso-graphs">
                <svg class="svg-graph-type-2" id="access-1">
                    <g class="grid x-grid">
                    </g>
                </svg>
                <div class="graph-datas cvs">
                    <ul class="datas-list">
                        {foreach from=$dadosAcessos['desktop'] item=item key=key name=name}
                            {if $key != 'total'}
                            <li class="acesso-data-items nl data-desktop">
                                <input class="desktops-params" type="hidden" name="{$item['data']}" value="{$item['acessos']}">
                            </li>
                            {/if}
                        {/foreach}
                        {foreach from=$dadosAcessos['mobile'] item=item key=key name=name}
                            {if $key != 'total'}
                            <li class="acesso-data-items nl data-mobile">
                                <input class="mobiles-params" type="hidden" name="{$item['data']}" value="{$item['acessos']}">
                            </li>
                            {/if}
                        {/foreach}
                    </ul>
                </div>
            </div>

            <div class="lw rt hardware-graphs">

                <div id="hardware-phone" class="hardware-datas first posr">
                    <div class="access-icons acces-2-icons"></div>
                    <input type="hidden" class="mobiles-cvs-val" value="{$porMobile}">
                    <span class="cvs-title" style="color: #62c29c;">{$porMobile}%</span>
                    <canvas class="mobiles-cvs" width="100" height="100"></canvas>
                    <div class="access-legend">
                        ACESSOS MOBILE
                    </div>
                </div>

                <div id="hardware-desktop" class="hardware-datas posrs">
                    <div class="access-icons acces-3-icons"></div>
                    <input type="hidden" class="desktops-cvs-val" value="{$porPc}">
                    <span class="cvs-title" style="color: #F15626">{$porPc}%</span>
                    <canvas class="desktops-cvs" width="100" height="100"></canvas>
                    <div class="access-legend">
                        ACESSOS DESKTOP
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
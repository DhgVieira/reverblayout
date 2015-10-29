<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Marketing > Monitoramento
        </div>
        <div id="header-section-name">
            Monitoramento
        </div>
    </header>
    <div class="lt bs posr container-contents" id="indicacoes-body">
        <div class="container">
            <div class="row above-thead">
                <form action="" method="post">
                    <a href="#" class="head-cells fs13 cells nap bs grn-btn green-btn-3 plus-wh">Adicionar novo Monitoramento</a>
                    <input type="submit" class="grn-btn thead-search-button bs rt" value="Buscar">
                    <input type="text" class="thead-search-field rt bs">
                </form>
            </div>
            <table class="fw painel-tables" id="banners-table" cellpadding="0" border="0" align="center" cellspacing="0">
                <thead class="tables-heads banners-head">
                    <tr>
                        <th class="th-cells fs10 head-blank-6"></th>
                        <th class="th-cells fs10 head-chck"></th>
                        <th class="th-cells fs10 head-dates">NOME</th>
                        <th class="th-cells fs10 head-link">INVESTIMENTO</th>
                        <th class="th-cells fs10 head-acao">DATA INICIO E FIM</th>
                        <th class="th-cells fs10 head-cliques">PREV. VENDAS</th>
                        <th class="th-cells fs10 head-vendas">VENDAS EM R$</th>
                        <th class="th-cells fs10 head-vendas-rs">VENDAS UN.</th>
                        <th class="th-cells fs10 head-action min-1"> </th>
                    </tr>
                </thead>
                <tbody class="vendas-tables-body tables-body banners-body">
                    {foreach from=$dadosProdutomonitora item=monitora}
                        {assign var=mediaDia value=$monitora->NR_QTDE_MOPR/$monitora->dias}
                        {assign var=mediaDia value=$mediaDia|ceil}
                        {assign var=totalMedia value=0}
                        {assign var=estouroLimite value=0}
                        <tr class="vendas-label-row">
                            <td class="td-cells fs10 body-blank-6 {if $i%2 == 0}up {else}down {/if}"></td>
                            <td class="td-cells fs10 body-check">

                            </td>
                            <td class="td-cells fs10 head-dates">{$monitora->DS_PRODUTO_PRRC}</td>
                            <td class="td-cells fs10 head-link">R$ {$monitora->VL_INVESTIDO_MOPR|number_format:2:",":"."}</td>
                            <td class="td-cells fs10 head-acao">{$monitora->DT_INICIO_MOPR|date_format:'%d/%m/%Y'} a {$monitora->DT_FIM_MOPR|date_format:'%d/%m/%Y'}</td>
                            <td class="td-cells fs10 head-cliques">{$monitora->NR_QTDE_MOPR}</td>
                            <td class="td-cells fs10 head-vendas">+R$ {$monitora->vl_vendido|number_format:2:",":"."}</td>
                            <td class="td-cells fs10 head-vendas-rs">{$monitora->qtd_vendido}</td>
                            <td class="tb-cells posr body-action min-1 has-pop-over">
                                <div class="lt row-btns">
                                    <button class="row-btns-el btn-banner-edit"></button>
                                    <button class="row-btns-el btn-banner-prev"></button>
                                </div>
                            </td>
                        </tr>
                        <tr class="vendas-values-row">
                            <td class="vendas-values-body bs" colspan="9">
                                <table class="vendas-values-tables" style="table-layout:fixed;">
                                    <tbody>
                                        <tr class="meta-row">
                                            <td class="td-vendas-cells fs10 head-blank-6">VENDIDO</td>
                                            {for $v=0 to $monitora->dias}
                                                {assign var=dia value="{$monitora->DT_INICIO_MOPR} +{$v} days"}
                                                <td class="td-vendas-cells posr td-days{if $smarty.now|date_format:'%d/%m/%Y' == $dia|date_format:'%d/%m/%Y'} mid{/if}">
                                                <span class="posr">{$this->produtovendidodia($dia|date_format:'%Y-%m-%d', $monitora->NR_SEQ_PRODUTO_PRRC)}</span></td>
                                            {/for}
                                        </tr>
                                        <tr class="meta-row">
                                            <td class="td-vendas-cells fs10 head-blank-6 ">DIA</td>
                                            {for $v=0 to $monitora->dias}
                                                {assign var=dia value="{$monitora->DT_INICIO_MOPR} +{$v} days"}
                                                <td class="td-vendas-cells tmd posr days-middle-row td-days{if $smarty.now|date_format:'%d/%m/%Y' == $dia|date_format:'%d/%m/%Y'} mid{/if}">
                                                    <span class="posr td-index" title="{$dia|date_format:'%d/%m/%Y'}">{$dia|date_format:'%d'}</span>
                                                </td>
                                            {/for}
                                        </tr>
                                        <tr class="meta-row">
                                            <td class="td-vendas-cells fs10 head-blank-6">VENDER</td>
                                            {for $v=0 to $monitora->dias}
                                                {assign var=dia value="{$monitora->DT_INICIO_MOPR} +{$v} days"}
                                                <td class="td-vendas-cells posr td-days{if $smarty.now|date_format:'%d/%m/%Y' == $dia|date_format:'%d/%m/%Y'} mid{/if}">
                                                    {assign var=totalMedia value=$totalMedia + $mediaDia}
                                                    {if $totalMedia > $monitora->NR_QTDE_MOPR && $estouroLimite != 1}
                                                        {assign var=valorMedia value=$totalMedia-$monitora->NR_QTDE_MOPR-$mediaDia}
                                                        {assign var=estouroLimite value=1}
                                                    {elseif $estouroLimite == 1}
                                                        {assign var=valorMedia value=0}
                                                    {else}
                                                        {assign var=valorMedia value=$mediaDia}
                                                    {/if}
                                                    {math equation="abs(x)" x=$valorMedia assign="valorMedia"}
                                                    <span class="posr">{$valorMedia}</span>
                                                </td>
                                            {/for}
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </div>
        </div>
    </div>
</div>
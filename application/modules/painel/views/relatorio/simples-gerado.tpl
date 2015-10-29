<style>
    @import url('{$basePath}/arquivos/painel/styles/main.css') print;
    @media print {
        header {
            display: none;
        }

        .relatorio-th-blocks {
            line-height: 20px;
        }

        .relatorio-th {
            padding-bottom: 0px;
        }

        .wrap-relatorio-table {
            padding: 0px;
        }
    }
</style>
<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12" id="dash-crumb">
            Relatórios > Gerais
        </div>
        <div id="header-section-name">
            Relatórios Gerais
        </div>
    </header>
    <div class="grid_20" id="simples-relatorio">
        <div class="container row">
            <h2 class="relatorio-title">{$dadosRelatorio->DS_RELATORIO_RERC}</h2>
            <div class="fw lt fs13" id="relatorio-dates">
                <div class="lt">{$dadosRelatorio->DT_INI_RERC|date_format:"%d/%m/%Y"} a {$dadosRelatorio->DT_FIM_RERC|date_format:"%d/%m/%Y"}</div>
                <div class="rt">{$dadosRelatorio->DT_INI_RERC|date_format:"%d/%m/%Y"} a {$dadosRelatorio->DT_FIM_RERC|date_format:"%d/%m/%Y"}</div>
            </div>
            <div class="fw lt posr bs wrap-relatorio-table">
                <table class="fw lt posr" id="relatorio-table" cellpadding="0" cellspacing="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                    <thead class="relatorio-thead">
                        <tr class="tmd fs13">
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">DATA</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">COMPRA</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">VALOR TOTAL</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">VALOR FRETE</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">VALOR SEM FRETE</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">CUSTO FRETE</div></th>
                        </tr>
                    </thead>
                    <tbody class="relatorio-tbody">
                        {foreach from=$dadosCompras item=relatorio}
                            {assign var=vlSemFrete value=$relatorio->VL_TOTAL_COSO - $relatorio->VL_FRETE_COSO}
                            <tr class="tmd fs12">
                                <td class="relatorio-cells relatorio-td">{$relatorio->DT_COMPRA_COSO|date_format:"%d/%m/%Y"}</td>
                                <td class="relatorio-cells relatorio-td">{$relatorio->NR_SEQ_COMPRA_COSO}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$relatorio->VL_TOTAL_COSO|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$relatorio->VL_FRETE_COSO|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$vlSemFrete|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$relatorio->VL_FRETECUSTO_COSO|number_format:2:",":"."}</td>
                            </tr>
                            {assign var=totalTotal value=$totalTotal+$relatorio->VL_TOTAL_COSO}
                            {assign var=totalFrete value=$totalTotal+$relatorio->VL_FRETE_COSO}
                            {assign var=totalSemFrete value=$totalSemFrete+($relatorio->VL_TOTAL_COSO -$relatorio->VL_FRETE_COSO)}
                            {assign var=totalCustoFrete value=$totalCustoFrete+$relatorio->VL_FRETECUSTO_COSO}
                        {/foreach}
                    </tbody>
                    <tfoot class="relatorio-tfoot">
                        <tr class="tmd fs12">
                            <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                            <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                            <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">R$ {$totalTotal|number_format:2:",":"."}</div></td>
                            <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">R$ {$totalFrete|number_format:2:",":"."}</div></td>
                            <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">R$ {$totalSemFrete|number_format:2:",":"."}</div></td>
                            <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">R$ {$totalCustoFrete|number_format:2:",":"."}</div></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="fw lt posr fs12" id="simple-gerado-btm">
                <div class="lt">Reverbcity</div>
            </div>
        </div>
    </div>
</div>
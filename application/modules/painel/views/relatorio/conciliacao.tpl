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

        .relatorio-th-blocks {
            position: relative;
            width: 100%;
            display: inline-block;
            vertical-align: middle;
            background: #e9e9e9 !important;
            line-height: 40px;
            -webkit-print-color-adjust: exact;
        }

        .relatorio-tot-vals .relatorio-tf-blocks {
            background: #e9e9e9 !important;
            font-weight: bold;
            -webkit-print-color-adjust: exact;
        }

        .relatorio-tfoot .relatorio-tot-vals {
             padding-top: 0;
        }

        .logo-report {
            display: block !important;
            position: relative;
            width: 74px;
            height: 74px;
            float: left;
        }

        .relatorio-title {
            line-height: 74px;
            margin-left: 80px;
        }

        table { page-break-inside:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
    }
    .logo-report {
        display: none;
    }
</style>
<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12" id="dash-crumb">
            Relatórios
        </div>
        <div id="header-section-name">

        </div>
    </header>
    <div class="grid_20" id="simples-relatorio">
        <div class="container row">
            <img class="logo-report" src="/reverbcity.com/arquivos/painel/images/logo.png" alt="">
            <h2 class="relatorio-title">Relatórios de Conciliação - {$dia}/{$mes}/{$ano}</h2>
            <div class="fw lt posr bs wrap-relatorio-table">
                <table class="fw lt posr" id="relatorio-table" cellpadding="0" cellspacing="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                    <thead class="relatorio-thead">
                    <tr class="tmd fs13">
                        <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Data/Período</div></th>
                        <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Valor Bruto</div></th>
                        <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Valor Taxas</div></th>
                        <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Valor Líquido</div></th>
                    </tr>
                    </thead>
                    <tbody class="relatorio-tbody">
                        <tr class="tmd fs12">
                            <td class="relatorio-cells relatorio-td"><strong>{$dia}/{$mes}/{$ano}</strong></td>
                            <td class="relatorio-cells relatorio-td">R$ {$vlrBrutoHoje|number_format:2:",":"."}</td>
                            <td class="relatorio-cells relatorio-td">R$ {($vlrBrutoHoje-$vlrLiquidoHoje)|number_format:2:",":"."}</td>
                            <td class="relatorio-cells relatorio-td">R$ {$vlrLiquidoHoje|number_format:2:",":"."}</td>
                        </tr>
                        {assign var=totalBruto value=$vlrBrutoHoje}
                        {assign var=totalLiquido value=$vlrLiquidoHoje}
                        {assign var=totalTaxa value=$vlrBrutoHoje-$vlrLiquidoHoje}

                        {foreach from=$weeks item=week}
                            {assign var=brutoPeriodo value=$this->brutoperiodo($week[0], $week|@end)}
                            {assign var=liquidoPeriodo value=$this->liquidoperiodo($week[0], $week|@end)}
                            {assign var=taxa value=$brutoPeriodo-$liquidoPeriodo}

                            {assign var=totalBruto value=$totalBruto+$brutoPeriodo}
                            {assign var=totalLiquido value=$totalLiquido+$liquidoPeriodo}
                            {assign var=totalTaxa value=$totalTaxa+$taxa}


                            <tr class="tmd fs12">
                                <td class="relatorio-cells relatorio-td"><strong>{$week[0]|date_format:"%d/%m/%Y"} até {$week|@end|date_format:"%d/%m/%Y"}</strong></td>
                                <td class="relatorio-cells relatorio-td">R$ {$brutoPeriodo|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$taxa|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$liquidoPeriodo|number_format:2:",":"."}</td>
                            </tr>
                        {/foreach}
                        <tfoot class="relatorio-tfoot">
                            <tr class="tmd fs12">
                                <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">R$ {$totalBruto|number_format:2:",":"."}</div></td>
                                <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">R$ {$totalTaxa|number_format:2:",":"."}</div></td>
                                <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">R$ {$totalLiquido|number_format:2:",":"."}</div></td>
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
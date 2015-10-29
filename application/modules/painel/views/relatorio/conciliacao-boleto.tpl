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

        .red {
            background-color: #ffd5d5 !important;
            -webkit-print-color-adjust: exact;
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
            line-height: 30px;
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

        @page { margin: 0; }
        body { margin: 0; }
    }
    .red {
        background-color: #ffd5d5;
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
            <h2 class="relatorio-title">Relatórios de Conciliação de Boleto - {$mes}/{$ano}</h2>
            <div class="fw lt posr bs wrap-relatorio-table">
                <table class="fw lt posr" id="relatorio-table" cellpadding="0" cellspacing="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                    <thead class="relatorio-thead">
                    <tr class="tmd fs13">
                        <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Data</div></th>
                        <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Quantidade</div></th>
                        <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Valor Bruto</div></th>
                        <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Taxa</div></th>
                        <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Valor Líquido</div></th>
                    </tr>
                    </thead>
                    <tbody class="relatorio-tbody">
                        {assign var=footQtd value=0}
                        {assign var=footBruto value=0}
                        {assign var=footTaxa value=0}
                        {assign var=footLiquido value=0}

                        {foreach from=$dadosCompras key=key item=compra}
                            {assign var=diaSemana value=$compra['data']|date_format:"%u"}

                            {if $diaSemana == 5 and $key != 0}
                                <tr class="tmd fs12 red">
                                    <td class="relatorio-cells relatorio-td"><strong>{$compra['data']|date_format:"%d/%m/%Y"} - Transferência</strong></td>
                                    <td class="relatorio-cells relatorio-td">{$totalQtd}</td>
                                    <td class="relatorio-cells relatorio-td">R$ {$totalBruto|number_format:2:",":"."}</td>
                                    <td class="relatorio-cells relatorio-td">R$ {($totalTaxa + 3.67)|number_format:2:",":"."} (R$ {$totalTaxa|number_format:2:",":"."} + R$ 3,67)</td>
                                    <td class="relatorio-cells relatorio-td">R$ {($totalLiquido - 3.67)|number_format:2:",":"."}</td>
                                </tr>

                                {assign var=footQtd value=$footQtd+$totalQtd}
                                {assign var=footBruto value=$footBruto+$totalBruto}
                                {assign var=footTaxa value=$footTaxa+$totalTaxa}
                                {assign var=footLiquido value=$footLiquido+$totalLiquido}

                                {assign var=totalQtd value=0}
                                {assign var=totalBruto value=0}
                                {assign var=totalTaxa value=0}
                                {assign var=totalLiquido value=0}
                            {/if}

                            {assign var=taxa value=$compra['qtd'] * 2.50}
                            {assign var=vlrLiquido value=$compra['vlr'] - $taxa}

                            {assign var=totalQtd value=$totalQtd+$compra['qtd']}
                            {assign var=totalBruto value=$totalBruto+$compra['vlr']}
                            {assign var=totalTaxa value=$totalTaxa+$taxa}
                            {assign var=totalLiquido value=$totalLiquido+$vlrLiquido}

                            <tr class="tmd fs12">
                                <td class="relatorio-cells relatorio-td"><strong>{$compra['data']|date_format:"%d/%m/%Y"}</strong></td>
                                <td class="relatorio-cells relatorio-td">{$compra['qtd']}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$compra['vlr']|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$taxa|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$vlrLiquido|number_format:2:",":"."}</td>
                            </tr>
                        {/foreach}
                        <tfoot class="relatorio-tfoot">
                            <tr class="tmd fs12">
                                <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">{$footQtd}</div></td>
                                <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">R$ {$footBruto|number_format:2:",":"."}</div></td>
                                <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">R$ {$footTaxa|number_format:2:",":"."}</div></td>
                                <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">R$ {$footLiquido|number_format:2:",":"."}</div></td>
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
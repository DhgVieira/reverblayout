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

        td, th {
            font-size: 9px;
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
            <h2 class="relatorio-title">Relatórios de Vendas - {$mes}/{$ano}</h2>
            <div class="fw lt posr bs wrap-relatorio-table">
                <table class="fw lt posr" id="relatorio-table" cellpadding="0" cellspacing="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                    <thead class="relatorio-thead">
                        <tr class="tmd fs13">
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Dia/Mês</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Qtd Itens</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Qtd Camisetas</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Qtd Boleto</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Vlr Boleto</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Qtd Cartão</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Vlr Cartão</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Qtd Outros</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Vlr Outros</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Qtd Total</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Vlr Total</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Vlr Frete</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Vlr sem Frete</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Vlr Taxas</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Custo Frete</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Vlr Líquido</div></th>
                            <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">Ticket Médio</div></th>
                        </tr>
                    </thead>
                    <tbody class="relatorio-tbody">
                        {foreach from=$dadosCompra item=compra}
                            {assign var=total value=$compra['qtdBoleto'] + $compra['qtdCartao'] + $compra['qtdDinheiro']}
                            {assign var=totalSemFrete value=$compra['total'] - $compra['totalFreteCusto']}
                            {assign var=ticketMedio value=$compra['total']/$total}
                            {assign var=taxaDiaria value=$this->calculotaxa($compra['data']|replace:"/":"-"|date_format:"%Y-%m-%d")}
                            {assign var=valorLiquido value=$compra['total']-$compra['totalFreteCusto']-$taxaDiaria}
                            <tr class="tmd fs12">
                                <td class="relatorio-cells relatorio-td"><strong>{$compra['data']}</strong></td>
                                <td class="relatorio-cells relatorio-td">{$compra['qtdItens']}</td>
                                <td class="relatorio-cells relatorio-td">{$compra['qtdCamisetas']}</td>
                                <td class="relatorio-cells relatorio-td">{$compra['qtdBoleto']}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$compra['totalBoleto']|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">{$compra['qtdCartao']}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$compra['totalCartao']|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">{$compra['qtdDinheiro']}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$compra['totalDinheiro']|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">{$total}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$compra['total']|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$compra['totalFrete']|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$totalSemFrete|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$taxaDiaria|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$compra['totalFreteCusto']|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$valorLiquido|number_format:2:",":"."}</td>
                                <td class="relatorio-cells relatorio-td">R$ {$ticketMedio|number_format:2:",":"."}</td>
                            </tr>
                        {/foreach}
                </table>
            </div>
            <div class="fw lt posr fs12" id="simple-gerado-btm">
                <div class="lt">Reverbcity</div>
            </div>
        </div>
    </div>
</div>
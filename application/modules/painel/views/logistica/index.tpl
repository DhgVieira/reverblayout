        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site > Banners > Locais-
                </div>
                <div id="header-section-name">
                    Pacotes Cadastrados
                </div>
                <div id="header-section-name">
                    {$pageName}
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
                        <form action="">
                            <div class="t-head-options bs fs11 select-2">
                                <select class="select bs" id="loteoptions" name="loteoptions">
                                    <option value="" selected disabled>Selecione</option>
                                    <option value="1">LOCAL 1</option>
                                    <option value="2">LOCAL 2</option>
                                </select>
                                <span class="select-value">LOCAL 1</span>
                            </div>
                            <button class="head-cells fs13 cells nap bs grn-btn plus-check green-btn-auto posr" id="apply-items">Aplicar</button>
                            <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                            <input type="text" class="thead-search-field min rt bs">
                        </form>
                    </div>
                    <table class="fw" id="indicacao-table">
                        <thead class="table-heads indica-head">
                            <tr>
                                <th class="th-cells head-chck"></th>
                                <th class="th-cells head-numb">Nº</th>
                                <th class="th-cells head-data">DATA COMPRA</th>
                                <th class="th-cells last-col head-nome">NOME</th>
                                <th class="th-cells head-pgto">PAGAMENTO</th>
                                <th class="th-cells head-val">VALOR TOTAL</th>
                                <th class="th-cells head-type">TIPO DE PACOTE</th>
                                <th class="th-cells head-opt">OPÇÕES</th>
                            </tr>
                        </thead>
                        <tbody class="table-body indica-body">
                            {for $i=0 to 9}
                            <tr>
                                <td class="tb-cells posr body-chck">
                                    <div class="wrap-checkbox wrap-reverb-checkbox-2">
                                        <input class="checkbox" type="checkbox" id="checkbox-{$i}" checked>
                                        <label class="styled-reverb-checkbox" for="checkbox-{$i}"></label>
                                    </div>
                                </td>
                                <td class="tb-cells body-numb">1234567</td>
                                <td class="tb-cells body-data">10/06/2014 13:33</td>
                                <td class="tb-cells body-nome">Thaieny Dias de Oliveira Costa</td>
                                <td class="tb-cells body-pgto"><img src="{$basePath}/arquivos/painel/images/visa.png" alt=""></td>
                                <td class="tb-cells body-val">241,40</td>
                                <td class="tb-cells body-type">NOME DO PACOTE</td>
                                <td class="tb-cells posr body-opt">
                                    <a class="row-btns-el btn-banner-prev"></a>
                                </td>
                            </tr>
                            {/for}
                        </tbody>
                    </div>
                </div>
            </div>
        </div>
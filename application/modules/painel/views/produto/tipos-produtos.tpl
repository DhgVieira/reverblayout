        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site > Produto > Tipos
                </div>
                <div id="header-section-name">
                    Tipos de Produtos
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
                            <button class="head-cells fs13 cells nap bs grn-btn plus-check green-btn-auto posr" id="apply-items">Aplicar nos items selecionados</button>
                            <a href="#" class="head-cells fs13 cells nap bs grn-btn green-btn-4 plus-wh rt">Adicionar novo tipo de produto</a>
                            <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                            <input type="text" class="thead-search-field min rt bs">
                        </form>
                    </div>
                    <table class="fw" id="indicacao-table">
                        <thead class="table-heads indica-head">
                            <tr>
                                <th class="th-cells head-chck"></th>
                                <th class="th-cells head-type">TIPOS</th>
                                <th class="th-cells head-qtde">PRODUTOS DESTE TIPO</th>
                                <th class="th-cells head-opt">OPÇÕES</th>
                            </tr>
                        </thead>
                        <tbody class="table-body indica-body">
                            {for $i=0 to 9}
                            <tr class="color-check">
                                <td class="tb-cells posr body-chck">
                                    <div class="wrap-checkbox wrap-reverb-checkbox-2">
                                        <input class="checkbox" type="checkbox" id="checkbox-{$i}" checked>
                                        <label class="styled-reverb-checkbox" for="checkbox-{$i}"></label>
                                    </div>
                                </td>
                                <td class="tb-cells body-item">type</td>
                                <td class="tb-cells body-qtde">321321</td>
                                <td class="tb-cells posr body-action has-pop-over">
                                    <div class="pop-over lt">
                                        <span class="open-pop-over">Opções</span>
                                        <div class="content-popover popover-4">
                                            <ul class="nm np  fs13 pop-over-list-1">
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-edi"></span>
                                                    Editar
                                                </li>
                                                <li class="nl bs posr popover-items-1 popover-delete-1">
                                                    <span class="ico ico-dd-exc"></span>
                                                    Excluir
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <ul class="indica-actions bs">
                                        <li class="indica-items">
                                            <a class="indica-icos indica-edit" href="#"></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            {/for}
                        </tbody>
                    </div>
                </div>
            </div>
        </div>
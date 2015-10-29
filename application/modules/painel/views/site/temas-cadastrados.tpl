
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                <div class="fw lt" id="top-menu">
                    <button class="rt bs fs13 top-btns" id="logout-btn"></button>
                    <a href="#Logout" class="rt anchor fs13 top-btns"> Log Out</a>
                    <a href="#Logout" class="rt anchor fs13 top-btns"> Ir para o site</a>
                </div>
                <div class="fw lt fs12 right-crumb">
                    Clientes &gt; Histórico de indicações
                </div>
                <div id="header-section-name">
                    Tópicos Cadastrados
                </div>
            </header>
            <div class="lt bs posr container-contents" id="indicacoes-body">
                <div class="container">
                    <div class="row above-thead">
                        <form action="">
                            <div class="t-head-options bs fs11">
                                Opções em Lote
                            </div>
                            <button class="head-cells fs13 cells nap bs grn-btn green-btn-1 plus-check" id="apply-items">Aplicar nos items selecionados</button>

                            <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                            <input type="text" class="thead-search-field rt bs">
                        </form>
                    </div>
                    <table class="fw painel-tables" id="indicacao-table">
                        <thead class="table-heads tables-heads">
                            <tr>
                                <th class="th-cells head-chck"></th>
                                <th class="th-cells head-data">DATA</th>
                                <th class="th-cells head-name last-col">NOME</th>
                                <th class="th-cells head-action min-1">OPÇÕES</th>
                            </tr>
                        </thead>
                        <tbody class="tables-body indica-body">
                            <tr>
                            {for $i=0 to 9}
                                <td class="tb-cells posr body-chck">
                                    <div class="wrap-checkbox wrap-reverb-checkbox-2">
                                        <input class="checkbox" type="checkbox" id="checkbox-{$i}" checked>
                                        <label class="styled-reverb-checkbox" for="checkbox-{$i}"></label>
                                    </div>
                                </td>
                                <td class="tb-cells body-data">10/05/14 14:00 PM</td>
                                <td class="tb-cells body-name last-col">
                                    <div class="tbl-comments bs">
                                        Lorem ipsum dolor sit amet, consectetur
                                    </div>
                                </td>
                                <td class="tb-cells posr body-action min-1 has-pop-over">
                                    <div class="pop-over lt">
                                        <span class="open-pop-over">Opções</span>
                                        <div class="content-popover popover-4">
                                            <ul class="nm np  fs13 pop-over-list-1">
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-vis"></span>
                                                    Visualizar
                                                </li>
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
                                    <ul class="indica-actions indica-actions-2 bs">
                                        <li class="indica-items">
                                            <a class="indica-icos indica-eye" href="#"></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            {/for}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
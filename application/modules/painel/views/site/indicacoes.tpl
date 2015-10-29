
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
                    Indicações
                </div>
            </header>
            <div class="lt bs posr container-contents" id="indicacoes-body">
                <div class="container">
                    <div class="row above-thead">
                        <form action="">
                            <div class="t-head-options bs fs11">
                                Opções em Lote
                            </div>
                            <button class="head-cells fs13 cells nap bs grn-btn green-btn-1" id="apply-items">Aplicar nos items selecionados</button>
                            <button class="head-cells fs13 cells nap bs grn-btn green-btn-3">NOVO LANÇAMENTO</button>
                            <button class="head-cells fs13 cells nap bs gray-btn gray-btn-1">Filtros <span class="ico-contextual"></span> </button>
                            <input type="text" class="thead-search-field lt bs">
                            <input type="submit" class="lt grn-btn thead-search-button bs" value="Buscar">
                        </form>
                    </div>
                    <table class="fw" id="indicacao-table">
                        <thead class="table-heads indica-head">
                            <tr>
                                <th class="th-cells head-chck"></th>
                                <th class="th-cells head-name">NOME</th>
                                <th class="th-cells head-email">E-MAIL</th>
                                <th class="th-cells head-ratio">INDICAÇÕES/COMPRARAM</th>
                                <th class="th-cells head-credito">CRÉDITO DISPONÍVEL</th>
                                <th class="th-cells head-action last-col">OPÇÕES</th>
                            </tr>
                        </thead>
                        <tbody class="table-body indica-body">
                            <tr>
                            {for $i=0 to 9}
                                <td class="tb-cells posr body-chck">
                                    <div class="wrap-checkbox wrap-reverb-checkbox-2">
                                        <input class="checkbox" type="checkbox" id="checkbox-{$i}" checked>
                                        <label class="styled-reverb-checkbox" for="checkbox-{$i}"></label>
                                    </div>
                                </td>
                                <td class="tb-cells body-name">Abdon Antônio Caldeira Neto</td>
                                <td class="tb-cells body-email">abdoncaldeira@uol.com.br</td>
                                <td class="tb-cells body-ratio">15/9</td>
                                <td class="tb-cells body-credito">120,00</td>
                                <td class="tb-cells posr body-action has-pop-over last-col">
                                    <div class="pop-over lt">
                                        <span class="open-pop-over">Opções</span>
                                        <div class="content-popover popover-2">
                                            <ul class="nm np  fs13 pop-over-list-1">
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-dol"></span>
                                                    Créditos
                                                </li>
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-pow"></span>
                                                    Ativar este produto
                                                </li>
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-edi"></span>
                                                    Editar dados
                                                </li>
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-vis"></span>
                                                    Ver compras
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
                                            <a class="indica-icos indica-email" href="#"></a>
                                        </li>
                                        <li class="indica-items">
                                            <a class="indica-icos indica-sms" href="#"></a>
                                        </li>
                                        <li class="indica-items">
                                            <a class="indica-icos indica-facebook" href="#"></a>
                                        </li>
                                        <li class="indica-items">
                                            <a class="indica-icos indica-twitter" href="#"></a>
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
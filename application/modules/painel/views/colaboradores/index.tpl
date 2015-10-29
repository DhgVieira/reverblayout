        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site > Banners > Locais-
                </div>
                <div id="header-section-name">
                    Usuários Cadastrados
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
                            <a class="head-cells fs13 cells nap bs grn-btn plus-check green-btn-auto posr rt">Adicionar novo Colaborador</a>
                            <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                            <input type="text" class="thead-search-field min rt bs">
                        </form>
                    </div>
                    <table class="fw" id="indicacao-table">
                        <thead class="table-heads indica-head">
                            <tr>
                                <th class="th-cells head-chck"></th>
                                <th class="th-cells head-logi">LOGIN</th>
                                <th class="th-cells head-fone">FONE</th>
                                <th class="th-cells last-col head-nome">E-MAIL</th>
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
                                <td class="tb-cells body-logi">SDASD@AS</td>
                                <td class="tb-cells body-fone">(32) 3232-3213</td>
                                <td class="tb-cells body-nome">asdsad@asda.asd</td>
                                <td class="tb-cells posr body-action has-pop-over last-col">
                                    <div class="pop-over lt">
                                        <span class="open-pop-over">Opções</span>
                                        <div class="content-popover popover-6">
                                            <ul class="nm np  fs13 pop-over-list-1">
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-pow"></span>
                                                    Reativar
                                                </li>
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-edi"></span>
                                                    Editar dados
                                                </li>
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-bad"></span>
                                                    Permissões
                                                </li>
                                                <li class="nl bs posr popover-items-1 popover-delete-1">
                                                    <span class="ico ico-dd-exc"></span>
                                                    Excluir
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <ul class="indica-actions-3 bs">
                                        <li class="indica-items">
                                            <a class="indica-icos indica-power" href="#"></a>
                                        </li>
                                        <li class="indica-items">
                                            <a class="indica-icos indica-edit" href="#"></a>
                                        </li>
                                        <li class="indica-items">
                                            <a class="indica-icos indica-bad" href="#"></a>
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
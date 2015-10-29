        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site &gt; Fórum
                </div>
                <div id="header-section-name">
                    Clientes sem compras
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
                            <button class="head-cells fs13 cells nap bs grn-btn green-btn-1 plus-check" id="apply-items">Aplicar nos items selecionados</button>
                            <div class="t-head-options bs fs11 select-2">
                                <select class="select bs" id="localbanner" name="localbanner">
                                    <option value="" selected disabled>Selecione</option>
                                    <option value="1">FILTRO 1</option>
                                    <option value="2">FILTRO 2</option>
                                </select>
                                <span class="select-value">FILTRO 2</span>
                            </div>
                            <a href="#new-topic" class="head-cells fs13 cells nap bs grn-btn green-btn-4 plus-check">FILTRAR</a>
                            <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                            <input type="text" class="thead-search-field rt bs">
                        </form>
                    </div>
                    <table class="fw" id="indicacao-table">
                        <thead class="table-heads indica-head">
                            <tr>
                                <th class="th-cells head-chck"></th>
                                <th class="th-cells head-nome">NOME</th>
                                <th class="th-cells head-email">E-MAIL</th>
                                <th class="th-cells head-fone">FONE</th>
                                <th class="th-cells head-city">CIDADE/UF</th>
                                <th class="th-cells head-cep">CEP</th>
                                <th class="th-cells head-action last-col">OPÇÕES</th>
                            </tr>
                        </thead>
                        <tbody class="table-body indica-body">
                            {for $i=0 to 9}
                            <tr class="{if $i %2 == 0} green {else} orange{/if}">
                                <td class="tb-cells posr body-chck">
                                    <div class="wrap-checkbox wrap-reverb-checkbox-2">
                                        <input class="checkbox" type="checkbox" id="checkbox-{$i}" checked>
                                        <label class="styled-reverb-checkbox" for="checkbox-{$i}"></label>
                                    </div>
                                </td>
                                <td class="tb-cells body-nome">Abdon Antônio Caldeira Neto</td>
                                <td class="tb-cells body-email">abdoncaldeira@uol.com.br</td>
                                <td class="tb-cells body-fone">11 9987-9877</td>
                                <td class="tb-cells body-city">São Paulo - SP</td>
                                <td class="tb-cells body-cep">86020-111</td>
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
                                                    Ativar
                                                </li>
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-edi edit-topic"></span>
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
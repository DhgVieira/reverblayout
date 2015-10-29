
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site &gt; Blog
                </div>
                <div id="header-section-name">
                    Comentários
                </div>
            </header>
            <div class="lt bs posr container-contents" id="indicacoes-body">
                <div class="container">
                    <div class="row above-thead">
                        <form action="">
                            <div class="t-head-options bs fs11 select-2">
                                <select class="select bs" id="localbanner" name="localbanner">
                                    <option value="" selected disabled>Selecione</option>
                                    <option value="1">LOCAL 1</option>
                                    <option value="2">LOCAL 2</option>
                                </select>
                                <span class="select-value">LOCAL 1</span>
                            </div>
                            <button class="head-cells fs13 cells nap bs grn-btn green-btn-1 plus-check" id="apply-items">Aplicar nos items selecionados</button>
                            <div class="t-head-options bs fs11 select-2">
                                <select class="select bs" id="opt2" name="opt2">
                                    <option value="" selected disabled>Selecione</option>
                                    <option value="1">LOCAL 1</option>
                                    <option value="2">LOCAL 2</option>
                                </select>
                                <span class="select-value">LOCAL 1</span>
                            </div>
                            <button class="head-cells fs13 cells nap bs grn-btn green-btn-4 plus-wh min" id="create-items">CRIAR</button>

                            <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                            <input type="text" class="thead-search-field rt bs">
                        </form>
                    </div>
                    <table class="fw painel-tables" id="indicacao-table">
                        <thead class="table-heads tables-heads">
                            <tr>
                                <th class="th-cells head-chck"></th>
                                <th class="th-cells head-post-title">TÍTULO DO POST</th>
                                <th class="th-cells head-post-data">DATA</th>
                                <th class="th-cells head-post-comment last-col">COMENTÁRIO</th>
                                <th class="th-cells head-action min-1">OPÇÕES</th>
                            </tr>
                        </thead>
                        <tbody class="tables-body indica-body">
                            {for $i=0 to 9}
                            <tr class="{if $i %2 == 0} green {else} orange{/if}">
                                <td class="tb-cells posr body-chck">
                                    <div class="wrap-checkbox wrap-reverb-checkbox-2">
                                        <input class="checkbox" type="checkbox" id="checkbox-{$i}" checked>
                                        <label class="styled-reverb-checkbox" for="checkbox-{$i}"></label>
                                    </div>
                                </td>
                                <td class="tb-cells body-post-title ">Tharcisio Amorim</td>
                                <td class="tb-cells body-post-data">10/05/14 14:00 PM</td>
                                <td class="tb-cells body-post-comment">
                                    <div class="tbl-comments bs">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veniam omnis qui harum iusto quaerat et. Eius, cum esse nemo excepturi cumque beatae unde eos, sunt neque, voluptatibus ipsam itaque ullam!
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
<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12" id="dash-crumb">
            Produtos &gt; Categorias
        </div>
        <div id="header-section-name">
            Categorias

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
                <form action="" method="post">
                    <div class="t-head-options bs fs11 select-2">
                        <select class="select bs" id="localbanner" name="localbanner">
                            <option value="" selected disabled>Selecione</option>
                            <option value="1">Opções em Lote</option>
                            <option value="2">Opções em Lote2</option>
                        </select>
                        <span class="select-value">Opções em Lote</span>
                    </div>
                    <button class="head-cells fs13 cells nap bs grn-btn green-btn-1 plus-check" id="apply-items">Aplicar nos items selecionados</button>
                    <a href="{$this->url(['module' => 'painel', 'controller' => 'site', 'action' => 'cadastro-post'], null, true)}" class="head-cells fs13 cells nap bs grn-btn green-btn-4 plus-wh rt">Adicionar nova Categoria </a>
                    <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                    <input type="text" class="thead-search-field rt bs" name="termo" value="{$busca}">
                </form>
            </div>
            <table class="fw painel-tables" id="indicacao-table">
                <thead class="table-heads indica-head">
                    <tr>
                        <th class="th-cells head-chck"></th>
                        <th class="th-cells head-category">CATEGORIAS</th>
                        <th class="th-cells head-email ">PRODUTOS DESTA CATEGORIA</th>
                        <th class="blank-cell large-blank-cell">&nbsp;</th>
                        <th class="th-cells head-action rt last-col">OPÇÕES</th>
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
                        <td class="tb-cells body-category">Abdon Antônio Caldeira Neto</td>
                        <td class="tb-cells body-counts tmd ">10</td>
                        <td class="blank-cell large-blank-cell">&nbsp;</td>
                        <td class="tb-cells posr body-action has-pop-over last-col rt">
                            <div class="pop-over lt">
                                <span class="open-pop-over">Opções</span>
                                <div class="content-popover popover-4">
                                    <ul class="nm np  fs13 pop-over-list-1">
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-edi"></span>
                                            Editar dados
                                        </li>
                                        <li class="nl bs posr popover-items-1 popover-delete-1">
                                            <span class="ico ico-dd-exc"></span>
                                            Excluir
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <ul class="indica-actions-2 bs">
                                <li class="indica-items">
                                    <a class="indica-icos indica-edit" href="#"></a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    {/for}
                </tbody>
            </table>
            <div class="footer-bar">
                
            </div>
        </div>
    </div>
</div>
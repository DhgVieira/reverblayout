
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                    {include file="painel-tb-top.tpl"}
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
                            <a href="./site/novo-banner" class="head-cells fs13 cells nap bs grn-btn green-btn-4 plus-check">OK</a>
                            <a href="./site/novo-banner" class="head-cells fs13 cells nap bs grn-btn green-btn-3 plus-wh">Adicionar novo Banner</a>
                            <a href="./site/novo-local-banner" class="head-cells fs13 cells nap bs grn-btn green-btn-3 plus-wh">Adicionar novo Local</a>
                            <input type="submit" class="grn-btn thead-search-button bs rt" value="Buscar">
                            <input type="text" class="thead-search-field rt bs">
                        </form>
                    </div>
                    <table class="fw painel-tables" id="banners-table" cellpadding="0" border="0" align="center" cellspacing="0">
                        <thead class="tables-heads banners-head">
                            <tr>
                                <th class="th-cells fs10 head-chck"></th>
                                <th class="th-cells fs10 head-dates">DATA</th>
                                <th class="th-cells fs10 head-link">LINK</th>
                                <th class="th-cells fs10 head-acao">AÇÃO</th>
                                <th class="th-cells fs10 head-cliques">CLIQUES</th>
                                <th class="th-cells fs10 head-vendas">VENDAS</th>
                                <th class="th-cells fs10 head-vendas-rs">VENDAS EM R$</th>
                                <th class="th-cells fs10 head-vendas-lq">VENDAS LÍQUIDAS</th>
                                <th class="th-cells fs10 head-action">OPÇÕES</th>
                            </tr>
                        </thead>
                        <tbody class="tables-body banners-body">
                            {for $i=0 to 4}
                            <tr class="collapse-open open-collapse-{$i}">
                                <td colspan="10">
                                    <div class="collapse-block-title">
                                        block-title-{$i}
                                    </div>
                                </td>
                            </tr>
                            {for $j=0 to rand(1,3)}
                            <tr class="collapsed collapsed-{$i} {if $j == 0}orange{else if $j == 1}green{/if}">
                                <td class="tb-cells posr body-chck">
                                    <div class="wrap-checkbox wrap-reverb-checkbox-2">
                                        <input class="checkbox" type="checkbox" id="checkbox-{$i}" checked>
                                        <label class="styled-reverb-checkbox" for="checkbox-{$i}"></label>
                                    </div>
                                </td>
                                <td class="tb-cells body-dates">01/10/2014</td>
                                <td class="tb-cells body-link">
                                    <input type="text" class="tb-link-input">
                                </td>
                                <td class="tb-cells body-acao">FACEBOOK</td>
                                <td class="tb-cells body-cliques">212</td>
                                <td class="tb-cells body-vendas">90</td>
                                <td class="tb-cells body-vendas-rs">R$1,980,00</td>
                                <td class="tb-cells body-vendas-lq">R$1,980,00</td>
                                <td class="tb-cells posr body-action has-pop-over">
                                    <div class="pop-over lt">
                                        <span class="open-pop-over">Opções</span>
                                        <div class="content-popover popover-3">
                                            <ul class="nm np  fs13 pop-over-list-1">
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-edi"></span>
                                                    Editar Banner
                                                    <a class="f-anc" href="#"></a>
                                                </li>
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-vis"></span>
                                                    Ver Banner
                                                    <a class="f-anc" href="#"></a>
                                                </li>
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-pow"></span>
                                                    Ativar
                                                    <a class="f-anc" href="#"></a>
                                                </li>
                                                <li class="nl bs posr popover-items-1 popover-delete-1">
                                                    <span class="ico ico-dd-exc"></span>
                                                    Excluir
                                                    <a class="f-anc" href="#"></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="lt row-btns">
                                        <button class="row-btns-el btn-banner-edit"></button>
                                        <button class="row-btns-el btn-banner-prev"></button>
                                    </div>
                                </td>
                            </tr>
                            {/for}
                            {/for}
                        </tbody>
                    </div>
                </div>
            </div>
        </div>
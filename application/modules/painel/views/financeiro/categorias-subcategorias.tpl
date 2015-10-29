        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site > Banners > Locais-
                </div>
                <div id="header-section-name">
                    Categorias e Subcategorias
                    <div class="header-helpers">
                        <a href="#" class="header-helpers-actions" id="new-action"></a>
                        <a href="#" class="header-helpers-actions" id="email-action"></a>
                        <a href="#" class="header-helpers-actions" id="print-action"></a>
                    </div>
                </div>
            </header>
            <div class="lt bs posr container-contents" id="indicacoes-body">
                <div class="container">
                    <div class="hw lt">
                        <button class="head-cells fs13 cells nap bs grn-btn plus-check green-btn-auto posr" id="insert-items">Nova Categoria</button>
                        <ul class="nm np fw lt categorias-list">
                            {for $i = 0 to 5}
                            <li class="nl fw lt bs posr categorias-items">
                                <div class="fw lt bs categorias-items-names">
                                    <span class="indicator"></span>
                                    CATEGORIA
                                </div>
                                <button class="categoria-items-plus"></button>
                                <ul class="subcategorias-list fw lt nm np">
                                {for $j = 0 to 5}
                                    <li class="nl bs posr subcategorias-list-items fw lt">
                                        <div class="sub-categorias-items-names">
                                            SUB CATEGORIA
                                        </div>
                                    </li>
                                {/for}
                                <li class="nl bs posr subcategorias-list-items fw lt">
                                    <div class="sub-categorias-items-input bs posr">
                                        <input class="nova-subcategoria fw" type="text" name="subcat" placeholder="DIGITE O NOM DA SUBCATEGORIA">
                                        <button class="subcat-btns button-cancel-new-cat"></button>
                                        <button class="subcat-btns button-insert-new-cat"></button>
                                    </div>
                                </li>
                                </ul>
                            </li>
                            {/for}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
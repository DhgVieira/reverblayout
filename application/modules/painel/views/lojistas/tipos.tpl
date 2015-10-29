
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                    {include file="painel-tb-top.tpl"}
            </header>
            <div id="banner-form">
                <div class="container">
                    <div class="hw lt">
                        <div class="grid_20">
                            <p class="fs17">Tipos (selecione para liberar)</p>
                            <div class="fw lt tipos-list">
                                <ul class="nm np fw lt" id="tipos-lists">
                                    {for $i = 0 to 10}
                                    <li class="tipos-items posr bs fw lt nl">
                                        <div class="wrap-checkbox wrap-reverb-checkbox-2">
                                            <input class="checkbox" type="checkbox" id="checkbox-{$i}" checked>
                                            <label class="styled-reverb-checkbox" for="checkbox-{$i}"></label>
                                        </div>
                                        <label }}for="checkbox-{$i}">TIPO-ITEM-{$i}</label>
                                    </li>
                                    {/for}
                                </ul>
                            </div>
                            <div class="fw lt row btm-btns-blocks">
                                <button class="rt register-button reverb-btns-1"> Pronto, Salvar! <span class="ico"></span> </button>
                                <button class="rt cancel-button type-2 reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
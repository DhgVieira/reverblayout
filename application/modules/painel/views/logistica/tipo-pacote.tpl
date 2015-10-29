        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site > Banners > Locais-
                </div>
                <div id="header-section-name">
                    Tipo de Pacote
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
                    <div class="hw lt">
                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1 fs17" for="tipoPacote">Tipo de pacote</label>
                                <input  class="bs reverb-input-1" type="text" id="tipoPacote" name="tipoPacote">
                            </div>
                        </div>
                        <div class="tipo-items-block">
                            <div class="row posr fw lt">
                                <span class="reverb-label-1 fs17 wrap-tipo-titles">Itens que fazem parte do pacote (selecione para ativar)</span>
                            </div>
                            <div class="fw lt posr wrap-tipo-items-wrap">
                                <ul class="fw lt tipos-list np nm">
                                    {for $b = 0 to 10}
                                    <li class="tipos-items posr nl">
                                        <div class="wrap-checkbox wrap-reverb-checkbox-2">
                                            <input class="checkbox" type="checkbox" id="checkbox-{$b}" checked>
                                            <label class="styled-reverb-checkbox" for="checkbox-{$b}"></label>
                                        </div>
                                        <label for="checkbox-{$b}">ITEM {$b}</label>
                                    </li>
                                    {/for}
                                </ul>
                            </div>
                        </div>
                        <div class="posr fw lt form-buttons-block">
                            <button class="rt register-button reverb-btns-1"> Pronto, Cadastrar! <span class="ico"></span> </button>
                            <button class="rt cancel-button reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                            <button class="rt edit-button reverb-btns-1"> Editar  <span class="ico"></span> </button>
                        </div>

                    </div>
                    <div class="hw lt">
                        
                    </div>
                </div>
            </div>
        </div>
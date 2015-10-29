
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site &gt; Banners
                </div>
                <div id="header-section-name">
                    Cadastrar Novo Local de Banner
                </div>
            </header>
            <div id="banner-form">
                <div class="container">
                    <div class="hw lt">
                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="nome">Título do Banner</label>
                                <input  class="bs reverb-input-1" type="text" id="nome" name="nome">
                            </div>
                        </div>
                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="obs">Observações</label>
                                <textarea class="bs reverb-input-4 wbrd" id="obs" name="obs"></textarea>
                            </div>
                        </div>
                        <div class="posr fw lt form-buttons-block">
                            <button class="rt register-button reverb-btns-1"> Pronto, Cadastrar! <span class="ico"></span> </button>
                            <button class="rt cancel-button reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                            <button class="rt edit-button reverb-btns-1"> Editar  <span class="ico"></span> </button>
                        </div>
                    </div>
                    <div class="hw lt">
                        <div class="posr fw lt">
                            <div class="registered-banner-head fw lt">Locais cadastrados</div>
                            <div class="registered-banner-list fw lt">
                                <ul class="nm np fw lt registered-banner-colletions">
                                    {for $i=0 to 4}
                                    <li class="nl fw lt bs registered-banner-items">
                                        <div>
                                            <div class="registered-banner-label lt">
                                                Lorem ipsum dolor
                                            </div>
                                            <div class="pop-over bs rt registered-banner-pop-over lt">
                                                <span class="open-pop-over">Opções</span>
                                                <div class="content-popover popover-4">
                                                    <ul class="nm np  fs13 pop-over-list-1">
                                                        <li class="nl bs posr popover-items popover-items-1">
                                                            <span class="ico ico-dd-edi"></span>
                                                            Editar Local
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
                                        </div>
                                    </li>
                                    {/for}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
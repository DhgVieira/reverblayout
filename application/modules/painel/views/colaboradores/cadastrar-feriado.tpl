
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site > Banners > Locais-
                </div>
                <div id="header-section-name">
                    Cadastrar Feriado
                    <div class="header-helpers">
                        <a href="#" class="header-helpers-actions" id="new-action"></a>
                        <a href="#" class="header-helpers-actions" id="email-action"></a>
                        <a href="#" class="header-helpers-actions" id="print-action"></a>
                    </div>
                </div>
            </header>
            <div id="banner-form">
                <div class="container">
                    <div class="hw lt">
                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="nome">Nome Feriado</label>
                                <input  class="bs reverb-input-1" type="text" id="nome" name="nome">
                            </div>
                        </div>
                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-3">
                                <label class="reverb-label-1" for="data">Data</label>
                                <input  class="bs reverb-input-1" type="text" id="data" name="data">
                            </div>
                            <div class="reverb-fields reverb-field-8">
                                <label class="reverb-label-1">&nbsp;</label>
                                <button class="lt cancel-button reverb-btns-1" style="margin-right: 1em;"> Cancelar! <span class="ico"></span> </button>
                                <button class="lt register-button reverb-btns-1"> Pronto, Cadastrar! <span class="ico"></span> </button>
                            </div>
                        </div>
                    </div>
                    <div class="hw lt">
                        <div class="table-heads tables-heads posr fw lt">
                            <div class="th-cells head-category-title">Feriados Cadastrados</div>
                        </div>
                        <div class="table-scroll categoria-scroll">
                            <table class="fw painel-tables">
                                <thead class="table-heads tables-heads">
                                    <tr style="display:none;">
                                        <th class="th-cells head-category-title" colspan="3">Feriados Cadastrados</th>
                                    </tr>
                                </thead>
                                <tbody class="tables-body indica-body">
                                    <tr>
                                    {for $i=0 to 9}
                                        <td class="tb-cells body-feriados tlt huge-blank-cell">DIA NÃO SEI DO QUE</td>
                                        <td class="tb-cells body-feriados">10/10/2010</td>
                                        <td class="tb-cells body-act">
                                            <span class="icon icon-close"></span>
                                        </td>
                                    </tr>
                                    {/for}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
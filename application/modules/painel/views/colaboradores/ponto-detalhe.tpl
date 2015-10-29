
        <div class="reverb-modals" id="edit-ponto">
            <div class="modal-body modal-topic-body posr">
                <div class="fw lt modal-container">
                    <div class="reverb-modal-blocks modal-greeting">
                        Atenção, Caior Arias
                    </div>
                    <a href="#" class="close-modal-btns"></a>
                    <form action="" class="form-modal" id="ponto-modal-form">
                        <div id="ponto-modal-form-top">
                            <div class="wrap-pontos-inputs tmd posr first">
                                <label class="modal-pontos-labels" for="entrada-1">Entrada</label>
                                <input class="modal-pontos-inputs fw lt posr bs" type="text" name="entrada-1" id="entrada-1">
                            </div>
                            <div class="wrap-pontos-inputs tmd posr">
                                <label class="modal-pontos-labels" for="saida-1">Entrada</label>
                                <input class="modal-pontos-inputs fw lt posr bs" type="text" name="saida-1" id="saida-1">
                            </div>
                            <div class="wrap-pontos-inputs tmd posr">
                                <label class="modal-pontos-labels" for="entrada-2">Entrada</label>
                                <input class="modal-pontos-inputs fw lt posr bs" type="text" name="entrada-2" id="entrada-2">
                            </div>
                            <div class="wrap-pontos-inputs tmd posr">
                                <label class="modal-pontos-labels" for="saida-2">Saída</label>
                                <input class="modal-pontos-inputs fw lt posr bs" type="text" name="saida-2" id="saida-2">
                            </div>
                            <div class="wrap-pontos-jutify fw lt posr">
                                <label class="modal-pontos-labels" for="ponto-justificativa">Justificativa</label>
                                <textarea name="ponto-justificativa" id="ponto-justificativa"></textarea>
                            </div>
                        </div>
                        <div id="ponto-modal-form-bottom">
                            <div class="reverb-modal-blocks fs12 posr fw lt">
                                Você tem certeza que deseja editar os horários do dia 04/03/13? <br>
                                Essa ação não poderá ser desfeita.
                            </div>
                            <div class="reverb-modal-blocks-1 posr fw lt">
                                <div class="lt">
                                    <a href="#" class="rt cancel-button type-2 reverb-btns-1"> Não! Cancelar! <span class="ico"></span> </a>
                                </div>
                                <div class="rt">
                                    <label for="new-topic-step-2" class="fs13 cells nap bs grn-btn green-btn-1 min plus-check"> Sim, tenho certeza </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site > Banners > Locais-
                </div>
                <div id="header-section-name">
                    Ponto

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
                            <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                            <input type="text" class="thead-search-field min rt bs">
                        </form>
                    </div>
                    <div class="row ponto-detalhes">
                        <div class="colaborador-blocks bs fw lt">
                            <span class="fs13">Colaborador: <strong>Márcio Araújo</strong> </span>
                            <span class="fs13 rt">Março de 2013 </span>
                        </div>
                    </div>
                    <table class="fw" id="indicacao-table">
                        <thead class="table-heads indica-head">
                            <tr>
                                <th class="th-cells head-data">DATA</th>
                                <th class="th-cells head-ent1">ENTRADA</th>
                                <th class="th-cells head-sai1">SAÍDA</th>
                                <th class="th-cells head-ent2">ENTRADA</th>
                                <th class="th-cells head-sai2">SAÍDA</th>
                                <th class="th-cells head-tota">TOTAL</th>
                                <th class="th-cells head-carg">CARGA HR.</th>
                                <th class="th-cells head-deve">DEV /EXTRA</th>
                                <th class="th-cells head-atra">ATRASOS</th>
                                <th class="th-cells head-extr">EXTRAS</th>
                                <th class="th-cells head-calc">CÁLCULO</th>
                                <th class="th-cells head-ponto">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody class="table-body indica-body">
                            <tr style="border-bottom: 1px solid #ebebeb">
                                <td class="tb-cells td-pontos-cells body-data">
                                    <div class="wrap-ponto-cell">dd/mm</div>
                                </td>
                                <td colspan="10" class="tb-cells td-pontos-cells body-data ponto-gr">
                                    <div class="wrap-ponto-cell vacation-cell">Feriado Aleatório</div>
                                </td>
                                <td class="tb-cells td-pontos-cells body-data">
                                    &nbsp;
                                </td>
                            </tr>
                            {for $i=1 to 9}
                            <tr style="border-bottom: 1px solid #ebebeb">
                                <td class="tb-cells td-pontos-cells body-data">
                                    <div class="wrap-ponto-cell">{$i}/03</div>
                                </td>
                                <td class="tb-cells td-pontos-cells ponto-gr body-ent1">
                                    <div class="wrap-ponto-cell">08:00</div>
                                </td>
                                <td class="tb-cells td-pontos-cells ponto-gr body-sai1">
                                    <div class="wrap-ponto-cell">12:00</div>
                                </td>
                                <td class="tb-cells td-pontos-cells ponto-gr body-ent2">
                                    <div class="wrap-ponto-cell">13:15</div>
                                </td>
                                <td class="tb-cells td-pontos-cells ponto-gr body-sai2">
                                    <div class="wrap-ponto-cell">18:15</div>
                                </td>
                                <td class="tb-cells td-pontos-cells body-tota">
                                    <div class="wrap-ponto-cell"><strong>09:00</strong></div>
                                </td>
                                <td class="tb-cells td-pontos-cells body-carg">
                                    <div class="wrap-ponto-cell"><strong>09:00</strong></div>
                                </td>
                                <td class="tb-cells td-pontos-cells body-deve weak">
                                    <div class="wrap-ponto-cell">00:00:00</div>
                                </td>
                                <td class="tb-cells td-pontos-cells body-atra orange">
                                    <div class="wrap-ponto-cell">00:00:00</div>
                                </td>
                                <td class="tb-cells td-pontos-cells body-extr">
                                    <div class="wrap-ponto-cell">00:00:00</div>
                                </td>
                                <td class="tb-cells td-pontos-cells ponto-gr body-calc">
                                    <div class="wrap-ponto-cell">00:00:00</div>
                                </td>
                                <td class="tb-cells td-pontos-cells body-ponto">
                                    <div class="wrap-ponto-cell">
                                        <ul class="pontos-actions bs nm">
                                            <li class="actions-items nl lt">
                                                <a href="" class="ponto-actions edit-ponto"></a>
                                            </li>
                                            <li class="actions-items nl rt">
                                                <a href="" class="ponto-actions dele-ponto"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            {/for}

                            <tr style="border-bottom: 1px solid #ebebeb">
                                <td class="tb-cells td-pontos-cells body-data">
                                    <div class="wrap-ponto-cell">10/03</div>
                                </td>
                                <td class="tb-cells td-pontos-cells ponto-gr body-ent1">
                                    <div class="wrap-ponto-cell">08:00</div>
                                </td>
                                <td class="tb-cells td-pontos-cells ponto-gr body-sai1">
                                    <div class="wrap-ponto-cell">12:00</div>
                                </td>
                                <td class="tb-cells td-pontos-cells ponto-gr body-ent2">
                                    <div class="wrap-ponto-cell">13:15</div>
                                </td>
                                <td class="tb-cells td-pontos-cells ponto-gr body-sai2">
                                    <div class="wrap-ponto-cell">18:15</div>
                                </td>
                                <td class="tb-cells td-pontos-cells body-tota">
                                    <div class="wrap-ponto-cell"><strong>09:00</strong></div>
                                </td>
                                <td class="tb-cells td-pontos-cells body-carg">
                                    <div class="wrap-ponto-cell"><strong>09:00</strong></div>
                                </td>
                                <td class="tb-cells td-pontos-cells body-deve weak">
                                    <div class="wrap-ponto-cell">00:00:00</div>
                                </td>
                                <td class="tb-cells td-pontos-cells body-atra orange">
                                    <div class="wrap-ponto-cell">00:00:00</div>
                                </td>
                                <td class="tb-cells td-pontos-cells body-extr">
                                    <div class="wrap-ponto-cell">00:00:00</div>
                                </td>
                                <td class="tb-cells td-pontos-cells ponto-gr body-calc">
                                    <div class="wrap-ponto-cell">00:00:00</div>
                                </td>
                                <td class="tb-cells td-pontos-cells body-ponto">
                                    <div class="wrap-ponto-cell">
                                        <ul class="pontos-actions bs nm">
                                            <li class="actions-items nl lt">
                                                <a href="" class="ponto-actions edit-ponto"></a>
                                            </li>
                                            <li class="actions-items nl rt">
                                                <a href="" class="ponto-actions okay-ponto"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </div>
                </div>
            </div>
        </div>
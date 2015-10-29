
        <div class="reverb-modals" id="new-topic">
            <div class="modal-body modal-topic-body posr">
                <div class="fw lt modal-container">
                    <div class="reverb-modal-blocks modal-greeting" style="line-height: 3">
                        Olá, Caior Arias
                    </div>
                    <a href="#" class="close-modal-btns"></a>
                    <input type="checkbox" id="new-topic-step-2">
                    <form action="" class="form-modal">
                        <div class="reverb-modal-blocks modal-field-1 topic-step-1 posr fw lt">
                            <label class="fw lt modal-topic-label" for="topic">Nome do tópico</label>
                            <input class="fw lt modal-topic-input" type="text" id="topic" name="topic">
                        </div>
                        <div class="reverb-modal-blocks modal-warnings topic-step-1 fs13 posr fw lt">
                            Você tem certeza que deseja criar um tópico com este nome?
                        </div>
                        <div class="reverb-modal-blocks modal-footer posr fw lt topic-step-1">
                            <div class="lt">
                                <a href="#" class="rt cancel-button type-2 reverb-btns-1"> Não! Cancelar! <span class="ico"></span> </a>
                            </div>
                            <div class="rt">
                                <label for="new-topic-step-2" class="fs13 cells nap bs grn-btn green-btn-1 min plus-check"> Sim, tenho certeza </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="reverb-modals" id="new-message">
            <div class="modal-body modal-topic-body posr">
                <div class="fw lt modal-container">
                    <div class="reverb-modal-blocks modal-greeting" style="line-height: 3">
                        Olá, Caior Arias
                    </div>
                    <a href="#" class="close-modal-btns"></a>
                    <form action="" class="form-modal">
                        <div class="reverb-modal-blocks modal-field-1 topic-step-2 posr fw lt">
                            <label class="fw lt modal-topic-label" for="msg">Escreva sua mensagem</label>
                            <textarea class="fw lt modal-topic-txtarea" type="text" id="topic-msg" name="msg"></textarea>
                        </div>
                        <div class="reverb-modal-blocks modal-warnings topic-step-2 fs13 posr fw lt">
                            Você tem certeza que deseja enviar essa mensagem para todos os usuários do fórum? Veja se tá certinho hein... todo mundo vai ler... 
                        </div>
                        <div class="reverb-modal-blocks modal-footer posr fw lt topic-step-2">
                            <div class="lt">
                                <a href="#" class="rt cancel-button type-2 reverb-btns-1"> Não! Cancelar! <span class="ico"></span> </a>
                            </div>
                            <div class="rt">
                                <label for="new-topic-step-2" class="fs13 cells nap bs grn-btn green-btn-1 min plus-check"> Sim, tenho certeza </label>
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
                    Site &gt; Fórum
                </div>
                <div id="header-section-name">
                    Tópicos Cadastrados
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
                                    <option value="1">LOCAL 1</option>
                                    <option value="2">LOCAL 2</option>
                                </select>
                                <span class="select-value">LOCAL 1</span>
                            </div>
                            <a href="#new-topic" class="head-cells fs13 cells nap bs grn-btn green-btn-4 plus-check">CRIAR </a>
                            <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                            <input type="text" class="thead-search-field rt bs">
                        </form>
                    </div>
                    <table class="fw" id="indicacao-table">
                        <thead class="table-heads indica-head">
                            <tr>
                                <th class="th-cells head-chck"></th>
                                <th class="th-cells head-data">DATA</th>
                                <th class="th-cells head-topic">TÓPICO</th>
                                <th class="th-cells head-auth">AUTOR</th>
                                <th class="th-cells head-email">E-MAIL</th>
                                <th class="th-cells head-message">MENSAGENS</th>
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
                                <td class="tb-cells body-data">10/05/14 14:00 PM</td>
                                <td class="tb-cells body-topic">DSADSUADSA</td>
                                <td class="tb-cells body-auth">ACAPS LOCKER</td>
                                <td class="tb-cells body-email">asdsadas@asd.asd</td>
                                <td class="tb-cells body-message">1200</td>
                                <td class="tb-cells posr body-action has-pop-over last-col">
                                    <div class="pop-over lt">
                                        <span class="open-pop-over">Opções</span>
                                        <div class="content-popover popover-2">
                                            <ul class="nm np  fs13 pop-over-list-1">
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-pow"></span>
                                                    Ativar
                                                </li>
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-edi"></span>
                                                    Ver Mensagens
                                                </li>
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-edi edit-topic"></span>
                                                    Editar nome
                                                </li>
                                                <li class="nl bs posr popover-items popover-items-1">
                                                    <span class="ico ico-dd-vis"></span>
                                                    Ver tópico
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
                                            <a class="indica-icos indica-bubble" href="#"></a>
                                        </li>
                                        <li class="indica-items">
                                            <a class="indica-icos indica-edit" href="#"></a>
                                        </li>
                                        <li class="indica-items">
                                            <a class="indica-icos indica-eye" href="#"></a>
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
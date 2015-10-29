
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site &gt; Blog
                </div>
                <div id="header-section-name">
                    Criar nova Categoria
                </div>
            </header>
            <div id="banner-form">
                <div class="container">
                    <div class="hw lt">
                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="nome">Nome da categoria</label>
                                <input  class="bs reverb-input-1" type="text" id="nome" name="nome">
                            </div>
                        </div>
                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-4">
                                <label class="reverb-label-1" for="observacao">Observações</label>
                                <div class="wrap-field-4-body fw lt">
                                    <div class="wrap-textarea">
                                        <textarea  class="reverb-input-4" type="text" id="observacao" name="observacao"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="posr fw lt form-buttons-block">
                            <button class="rt register-button reverb-btns-1"> Pronto, Cadastrar! <span class="ico"></span> </button>
                            <button class="rt cancel-button reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                            <button class="rt edit-button reverb-btns-1"> Editar  <span class="ico"></span> </button>
                        </div>
                    </div>
                    <div class="hw lt">
                        <div class="table-heads tables-heads posr fw lt">
                            <div class="th-cells head-category-title" colspan="2">Categorias cadastradas</div>
                        </div>
                        <div class="table-scroll categoria-scroll">
                            <table class="fw painel-tables" id="indicacao-table">
                                <thead class="table-heads tables-heads">
                                    <tr style="display:none;">
                                        <th class="th-cells head-category-title" colspan="2">Categorias cadastradas</th>
                                    </tr>
                                </thead>
                                <tbody class="tables-body indica-body">
                                    <tr>
                                    {for $i=0 to 9}
                                        <td class="tb-cells body-category-title ">Tharcisio Amorim</td>
                                        <td class="tb-cells posr body-action min-2 has-pop-over">
                                            <div class="pop-over lt">
                                                <span class="open-pop-over">Opções</span>
                                                <div class="content-popover popover-4">
                                                    <ul class="nm np  fs13 pop-over-list-1">
                                                        <li class="nl bs posr popover-items popover-items-1">
                                                            <span class="ico ico-dd-edi"></span>
                                                            Editar
                                                        </li>
                                                        <li class="nl bs posr popover-items-1 popover-delete-1">
                                                            <span class="ico ico-dd-exc"></span>
                                                            Excluir
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
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
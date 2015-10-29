<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Site &gt; Cycle
        </div>
        <div id="header-section-name">
            Cadastrar novo Objeto
        </div>
    </header>
    <div class="lt bs posr container-contents" id="indicacoes-body">
        <div class="container">
            <div id="product-form">
                <div class="container">
                    <div class="hw lt">
                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="nome">Nome</label>
                                <input  class="bs reverb-input-1" type="text" id="nome" name="nome">
                            </div>
                        </div>
                        <div class="row posr fw lt">
                            <label class="reverb-label-1" for="categoria">Categoria</label>
                            <div class="reverb-input-1 select-1">
                                <select class="select bs" id="categoria" name="categoria">
                                    <option value="" selected disabled>Selecione</option>
                                    <option value="1">CATEGORIA 1</option>
                                    <option value="2">CATEGORIA 2</option>
                                </select>
                                <span class="select-value">Selecione</span>
                            </div>
                        </div>
                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="tags">Tags</label>
                                <input  class="bs reverb-input-1" type="text" id="tags" name="tags">
                            </div>
                        </div>
                        <div class="row posr fw lt">
                            <div class="reverb-fields fw">
                                <label class="reverb-label-1" for="f3">Cadastro de fotos</label>
                                <div class="hw lt">
                                    <div class="load-more-images posr image-uploader-1">
                                        Clique para adicionar imagens
                                        <span class="plus bs posa"> + </span>
                                        <input type="file" class="upload-images posa" id="upload-listener" multiple>
                                    </div>
                                </div>
                                <div class="hw lt">
                                    <div class="uploading-gage posr">
                                        <div class="loaded-indicator"></div>
                                    </div>
                                </div>
                                <div class="fw lt uploaded-product-previews">
                                    <table width="100%" class="preview-tables" id="preview-table">
                                        <tr>
                                            {* <td class="preview-items posr">
                                                <img class="preview-imgs" src="https://api.fnkr.net/testimg/78x88/00CED1/FFF/?text=preview">
                                                <button class="remove-preview"></button>
                                            </td> *}
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row posr fw lt">
                            <div class="reverb-fields reverb-field-4">
                                <label class="reverb-label-1" for="descricao">Descrição</label>
                                <div class="wrap-field-4-body fw lt">
                                    <div class="wrap-textarea">
                                        <textarea  class="reverb-input-4" type="text" id="descricao" name="descricao"></textarea>
                                    </div>
<!--                                     <div class="fw lt bs fw lt field-4-notes">
                                        [Cor da Malha: Azul Das Novinha ]
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="posr fw lt form-buttons-block">
                            <button class="edit-button reverb-btns-1"> Editar  <span class="ico"></span> </button>
                            <button class="preview-button reverb-btns-1"> Preview  <span class="ico"></span> </button>
                            <button class="cancel-button reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                            <button class="register-button reverb-btns-1"> Pronto, Cadastrar! <span class="ico"></span> </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
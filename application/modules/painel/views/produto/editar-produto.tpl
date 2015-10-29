<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Home > Editar produtos
        </div>
        <div id="header-section-name">
            Editar um produto
        </div>
    </header>
    <div class="lt bs posr container-contents" id="indicacoes-body">
        <div class="container">
            <div id="product-form">
                <form action="" method="post" class="form-produto">
                    <div class="container">
                        <div class="hw lt">
                            <div class="row posr fw lt">
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="nome">Nome no Admin</label>
                                    <input  class="bs reverb-input-1" type="text" id="nome" name="DS_PRODUTO2_PRRC" value="{$dadosProduto->DS_PRODUTO2_PRRC}">
                                </div>
                            </div>
                            <div class="row posr fw lt">
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="nome">Nome no Site</label>
                                    <input  class="bs reverb-input-1" type="text" id="nome" name="DS_PRODUTO_PRRC" value="{$dadosProduto->DS_PRODUTO_PRRC}">
                                </div>
                            </div>
                            <div class="row posr fw lt">
                                <div class="reverb-fields reverb-field-2">
                                    <label class="reverb-label-1" for="referencia">Referência</label>
                                    <input  class="bs reverb-input-1" type="text" id="referencia" name="DS_REFERENCIA_PRRC" value="{$dadosProduto->DS_REFERENCIA_PRRC}">
                                </div>
                                <div class="reverb-fields reverb-field-2">
                                    <label class="reverb-label-1" for="peso">Peso (em gramas) </label>
                                    <input  class="bs reverb-input-1" type="text" id="peso" name="NR_PESOGRAMAS_PRRC" value="{$dadosProduto->NR_PESOGRAMAS_PRRC}">
                                </div>
                            </div>
                            <div class="row posr fw lt">
                                <div class="reverb-complete-widgets reverb-fields reverb-field-5 lt">
                                    <label class="reverb-label-1" for="tipo">Tipo</label>
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs" id="tipo" name="NR_SEQ_TIPO_PRRC">
                                            <option value="" disabled>Selecione</option>
                                            {foreach from=$dadosProdutoTipo item=tipo}
                                                <option value="{$tipo->NR_SEQ_CATEGPRO_PTRC}" {if $dadosProduto->NR_SEQ_TIPO_PRRC == $tipo->NR_SEQ_CATEGPRO_PTRC}selected{/if}>{$tipo->DS_CATEGORIA_PTRC}</option>
                                            {/foreach}
                                        </select>
                                        <span class="select-value">Selecione</span>
                                    </div>
                                </div>
                                <div class="reverb-fields reverb-field-6 lt">
                                    <label class="reverb-label-1" for="tipo">Categoria</label>
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs" id="tipo" name="NR_SEQ_CATEGORIA_PRRC">
                                            <option value="" disabled>Selecione</option>
                                            {foreach from=$dadosProdutoCategoria item=categoria}
                                                <option value="{$categoria->NR_SEQ_CATEGPRO_PCRC}" {if $dadosProduto->NR_SEQ_CATEGORIA_PRRC == $categoria->NR_SEQ_CATEGPRO_PCRC}selected{/if}>{$categoria->DS_CATEGORIA_PCRC}</option>
                                            {/foreach}
                                        </select>
                                        <span class="select-value">Selecione</span>
                                    </div>
                                </div>
                                <div class="reverb-complete-widgets reverb-fields reverb-field-5 lt">
                                    <label class="reverb-label-1" for="tipo">Custo</label>
                                    <div class="reverb-input-1">
                                        <input  class="bs reverb-input-2 money" type="text" id="VL_PRODUTO2_PRRC" name="VL_PRODUTO2_PRRC" value="{$dadosProduto->VL_PRODUTO2_PRRC|string_format:"%.2f"}">
                                    </div>
                                </div>
                                {*<div class="reverb-complete-widgets reverb-fields reverb-field-7 lt">*}
                                    {*<label class="reverb-label-1" for="descricao">Tipo</label>*}
                                    {*<div class="reverb-input-1 select-1">*}
                                        {*<select class="select bs" id="colunista" name="colunista">*}
                                            {*<option value="" selected disabled>Selecione</option>*}
                                            {*<option value="1">COLUNISTA 1</option>*}
                                            {*<option value="2">COLUNISTA 2</option>*}
                                        {*</select>*}
                                        {*<span class="select-value">Tipo</span>*}
                                    {*</div>*}
                                {*</div>*}
                            </div>
                            <div class="row posr fw lt">
                                <div class="reverb-fields reverb-field-4">
                                    <label class="reverb-label-1" for="descricao">Descrição</label>
                                    <div class="wrap-field-4-body fw lt">
                                        <div class="wrap-textarea">
                                            <textarea  class="reverb-input-4" type="text" id="descricao" name="DS_INFORMACOES_PRRC">{$dadosProduto->DS_INFORMACOES_PRRC}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hw lt">
                            <div class="row posr fw lt">
                                <div class="reverb-complete-widgets reverb-fields reverb-field-2">
                                    <label class="reverb-label-1" for="destaque">Colocar destaque</label>
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs" id="destaque" name="TP_DESTAQUE_PRRC">
                                            <option {if $dadosProduto->TP_DESTAQUE_PRRC == 0}selected{/if} value="0">Não</option>
                                            <option {if $dadosProduto->TP_DESTAQUE_PRRC == 1}selected{/if} value="1">New</option>
                                            <option {if $dadosProduto->TP_DESTAQUE_PRRC == 2}selected{/if} value="2">Sale</option>
                                            <option {if $dadosProduto->TP_DESTAQUE_PRRC == 3}selected{/if} value="3">Reprint</option>
                                            <option {if $dadosProduto->TP_DESTAQUE_PRRC == 4}selected{/if} value="4">Pré-venda</option>
                                            <option {if $dadosProduto->TP_DESTAQUE_PRRC == 5}selected{/if} value="5">50% off</option>
                                            <option {if $dadosProduto->TP_DESTAQUE_PRRC == 6}selected{/if} value="6">Topo Loja</option>
                                        </select>
                                        <span class="select-value">Não</span>
                                    </div>
                                </div>
                                <div class="reverb-complete-widgets reverb-fields reverb-field-2">
                                    <label class="reverb-label-1" for="status">Status do produto </label>
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs" id="status" name="ST_PRODUTOS_PRRC">
                                            <option value="A" {if $dadosProduto->ST_PRODUTOS_PRRC == 'A'}selected{/if}>Ativo</option>
                                            <option value="I" {if $dadosProduto->ST_PRODUTOS_PRRC == 'I'}selected{/if}>Inativo</option>
                                        </select>
                                        <span class="select-value">Inativo</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row posr fw lt">
                                <div class="reverb-complete-widgets reverb-fields reverb-field-2">
                                    <label class="reverb-label-1" for="promocional">Valor</label>
                                    <input  class="bs reverb-input-2 money" type="text" id="VL_PRODUTO_PRRC" name="VL_PRODUTO_PRRC" value="{$dadosProduto->VL_PRODUTO_PRRC|string_format:"%.2f"}">
                                    <div id="complete-promocional" class="complete-widget-blocks" rel="VL_PRODUTO_PRRC">

                                    </div>
                                </div>
                                <div class="reverb-complete-widgets reverb-fields reverb-field-2">
                                    <label class="reverb-label-1" for="promocional">Valor promocional</label>
                                    <input  class="bs reverb-input-2 money" type="text" id="VL_PROMO_PRRC" name="VL_PROMO_PRRC" value="{$dadosProduto->VL_PROMO_PRRC|string_format:"%.2f"}">
                                    <div id="complete-promocional" class="complete-widget-blocks" rel="VL_PROMO_PRRC">

                                    </div>
                                </div>
                            </div>
                            <div class="row posr fw lt">
                                <div class="reverb-complete-widgets reverb-fields reverb-field-5 lt">
                                    <label class="reverb-label-1" for="genero">Gênero</label>
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs" id="genero" name="DS_GENERO_PRRC">
                                            <option value="M" {if $dadosProduto->DS_GENERO_PRRC == "M"}selected{/if}>Masculino</option>
                                            <option value="F" {if $dadosProduto->DS_GENERO_PRRC == "F"}selected{/if}>Feminino</option>
                                        </select>
                                        <span class="select-value">Masculino</span>
                                    </div>
                                </div>
                                <div class="reverb-fields reverb-field-6 lt">
                                    <label class="reverb-label-2" for="medidas">Tabela de medidas</label>
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs" id="medidas" name="NR_SEQ_MODELO_PRRC">
                                            <option value="" selected disabled>Selecione</option>
                                            {foreach from=$dadosModelo item=modelo}
                                                <option value="{$modelo->idmodelo}" {if $dadosProduto->NR_SEQ_MODELO_PRRC == $modelo->idmodelo}selected{/if}>{$modelo->descricao}</option>
                                            {/foreach}
                                        </select>
                                        <span class="select-value">Selecione</span>
                                    </div>
                                </div>
                                <div class="reverb-complete-widgets reverb-fields reverb-field-7 lt">
                                    <label class="reverb-label-1" for="descricao">Cor</label>
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs"  id="cor" name="NR_SEQ_COR_PRRC">
                                            <option value="" selected disabled>Selecione</option>
                                            {foreach from=$dadosCores item=cor}
                                                <option value="{$cor->idcor}" {if $dadosProduto->NR_SEQ_COR_PRRC == $cor->idcor}selected{/if}>{$cor->cor}</option>
                                            {/foreach}
                                        </select>
                                        <span class="select-value">Selecione</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row posr fw lt">
                                <div class="reverb-fields fw">
                                    <label class="reverb-label-1" for="f3">Cadastro de fotos</label>
                                    <div class="hw lt">
                                        <div class="load-more-images posr image-uploader-1">
                                            Clique para adicionar imagens
                                            <span class="plus bs posa"> + </span>
                                            <input type="file" class="upload-images posa ninja-uploader" multiple data-rel="#loader-1" data-prev="#ninja-prev" data-preto="/painel/site/images-collection">
                                        </div>
                                    </div>
                                    <div class="hw lt">
                                        <div class="uploading-gage posr ninja-uploader-loader" id="loader-1">
                                            <div class="loaded-indicator ninja-uploader-loaded" style="width: 0px;"></div>
                                        </div>
                                    </div>
                                    <div class="fw lt uploaded-product-previews">
                                        <table width="100%" class="preview-tables">
                                            <tr id="ninja-prev">

                                                {foreach from=$dadosFoto item=foto}
                                                    <td class="preview-items posr">
                                                        <img class="preview-imgs" src="/reverbcity.com/thumb/fotosprodutos/1/78/88/{$foto->NR_SEQ_FOTO_FORC}.{$foto->DS_EXT_FORC}">
                                                        <button data-type="teste" data-path="/reverbcity.com/thumb/fotosprodutos/1/78/88/{$foto->NR_SEQ_FOTO_FORC}.{$foto->DS_EXT_FORC}" class="remove-preview"></button>
                                                    </td>
                                                {/foreach}
                                                {*<td class="preview-items posr">*}
                                                    {*<img class="preview-imgs" src="https://api.fnkr.net/testimg/78x88/00CED1/FFF/?text=preview">*}
                                                    {*<button class="remove-preview"></button>*}
                                                {*</td>*}
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="posr fw lt form-buttons-block">
                            {*<button class="edit-button reverb-btns-1"> Editar  <span class="ico"></span> </button>*}
                            {*<button class="preview-button reverb-btns-1"> Preview  <span class="ico"></span> </button>*}
                            <button class="cancel-button reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                            <button class="register-button reverb-btns-1"> Pronto, Cadastrar! <span class="ico"></span> </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript" src="{$basePath}/arquivos/painel/scripts/ninja-produto.js"></script>
<script type="text/javascript" src="{$basePath}/arquivos/painel/libs/jquery-maskmoney/jquery.maskMoney.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('select').change();

        $('.money').maskMoney({
            prefix: 'R$ '
        }).maskMoney('mask');

        $('.register-button').on('click', function(e) {
            $('.form-produto').submit();
        });

        $('.cancel-button').on('click', function(e){
            e.preventDefault();
            window.location = document.basePath + '/painel/produto';
        });
//
//        $('.remove-preview').off().on('click', function(e){
//            e.preventDefault();
//            e.target.parentElement.remove();
//            var final = e.target.dataset.path.substr(e.target.dataset.path.lastIndexOf('/') + 1);
//            $.ajax(document.basePath + '/painel/produto/unlink-foto/path/' + final);
//        });
    });
    document.idProduto = {$dadosProduto->NR_SEQ_PRODUTO_PRRC};
</script>
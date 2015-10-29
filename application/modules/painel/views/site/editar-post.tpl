<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12" id="dash-crumb">
            Site &gt; Blog
        </div>
        <div id="header-section-name">
            Editar post
        </div>
    </header>
    <div id="banner-form">
        <div class="container">
            <div class="hw lt">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-2 wrap-datepick">
                            <label class="reverb-label-1" for="data">Data da Postagem</label>
                            <input  class="bs reverb-input-1 date-pick-1" type="text" id="data" name="DT_PUBLICACAO_BLRC" autocomplete="off" value="{$dadosBlog->DT_PUBLICACAO_BLRC|date_format:"%d/%m/%Y"}">
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="titulo">Título da Postagem</label>
                            <input  class="bs reverb-input-1" type="text" id="titulo" name="DS_TITULO_BLRC" value="{$dadosBlog->DS_TITULO_BLRC}">
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-3">
                            <label class="reverb-label-1" for="colunista">Colunista</label>
                            <div class="reverb-input-1 select-1">
                                <select class="select bs" id="colunista" name="NR_SEQ_COLUNISTA_BLRC">
                                    <option value="" selected disabled>Selecione</option>
                                    {foreach from=$dadosColunista item=colunista}
                                        <option value="{$colunista->NR_SEQ_COLUNISTA_CORC}" {if $colunista->NR_SEQ_COLUNISTA_CORC == $dadosBlog->NR_SEQ_COLUNISTA_BLRC}selected="selected" {/if}>{$colunista->DS_COLUNISTA_CORC}</option>
                                    {/foreach}
                                </select>
                                <span class="select-value">Selecione</span>
                            </div>
                        </div>
                        <div class="reverb-fields reverb-field-8">
                            <label class="reverb-label-1" for="categoria">Categoria</label>
                            <div class="reverb-input-1 select-1">
                                <select class="select bs" id="categoria" name="NR_SEQ_CATEGORIA_BLRC">
                                    <option value="" selected disabled>Selecione</option>
                                    {foreach from=$dadosBlogCategoria item=categoria}
                                        <option value="{$categoria->NR_SEQ_BLOGCAT_BCRC}" {if $categoria->NR_SEQ_BLOGCAT_BCRC == $dadosBlog->NR_SEQ_CATEGORIA_BLRC}selected="selected"{/if}>{$categoria->DS_CATEGORIA_BCRC}</option>
                                    {/foreach}
                                </select>
                                <span class="select-value">Selecione</span>
                            </div>
                        </div>
                    </div>
                    {if $dadosBlog->DS_EXT_BLRC}
                        <div class="row posr fw lt" style="margin-top: 10px;">
                            <div class="fw lt">
                                {assign var=fotoCompleta value="{$dadosBlog->NR_SEQ_BLOG_BLRC}.{$dadosBlog->DS_EXT_BLRC}"}
                                <img src="{$this->Url(['tipo'=>"blog", 'crop'=>1, 'largura'=>0, 'altura'=>0, 'imagem'=>$fotoCompleta],"imagem", TRUE)}" alt=""/>
                            </div>
                        </div>
                    {/if}
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="image-uploader">Imagem Principal</label>
                            <div class="load-more-images posr image-uploader-1">
                                Clique para adicionar imagens
                                <span class="plus bs posa"> + </span>
                                <input type="file" class="upload-images posa" accept="image/*" name="arquivo">
                            </div>
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-4">
                                <label class="reverb-label-1" for="conteudo">Conteúdo</label>
                            <div class="wrap-field-4-body fw lt">
                                <div class="wrap-textarea">
                                    {*{$oFCKeditor->Create('blogpost')}*}
                                    <textarea class="reverb-input-4 ckeditor" type="text" id="editor1" name="DS_TEXTO_BLRC">{$dadosBlog->DS_TEXTO_BLRC}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="posr fw lt form-buttons-block">
                        <button class="rt register-button reverb-btns-1"> Pronto, Salvar! <span class="ico"></span> </button>
                        <button class="rt cancel-button reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{$basePath}/arquivos/painel/libs/jquery-ui/themes/smoothness/jquery-ui.min.css">
<script type="text/javascript">
    $(document).ready(function(){
        $('.select').change();
        $('#data').datepicker({ dateFormat: 'dd/mm/yy'});
        $('.cancel-button').on('click', function(e) {
            e.preventDefault();
            window.location = document.basePath + '/painel/site/lista-posts';
            //history.go(-1);
        });
    });
</script>
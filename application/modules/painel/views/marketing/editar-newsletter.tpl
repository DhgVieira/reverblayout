<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Marketing > Newsletter
        </div>
        <div id="header-section-name">
            Editar Newsletter
        </div>
    </header>
    </header>
    <div id="banner-form">
        <div class="container">
            <div class="hw lt">
                <form action="" method="post">
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="titulo">Descrição</label>
                            <input  class="bs reverb-input-1" type="text" id="titulo" name="ds_descricao" value="{$dadosSpam->ds_descricao}">
                        </div>
                    </div>
                    <div class="row posr fw lt" style="margin-top: 10px;">
                        <div class="reverb-fields reverb-field-4">
                            <div class="wrap-textarea">
                                <textarea class="reverb-input-4 ckeditor" type="text" id="editor1" name="ds_conteudo">{$dadosSpam->ds_conteudo}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="posr fw lt form-buttons-block">
                        <button class="rt register-button reverb-btns-1"> Pronto, Cadastrar! <span class="ico"></span> </button>
                        <button class="rt cancel-button reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.cancel-button').on('click', function(e) {
            e.preventDefault();
            window.location = document.basePath + '/painel/marketing';
            //history.go(-1);
        });
    });
</script>
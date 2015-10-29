<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Marketing > Campanha
        </div>
        <div id="header-section-name">
            Cadastrar Campanha
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
                            <input  class="bs reverb-input-1" type="text" id="titulo" name="DS_CAMPANHA_CARC" value="{$dadosCampanha->DS_CAMPANHA_CARC}">
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
<script type="text/javascript">
    $(document).ready(function(){
        $('.cancel-button').on('click', function(e) {
            e.preventDefault();
            window.location = document.basePath + '/painel/marketing/lista-campanha';
            //history.go(-1);
        });
    });
</script>
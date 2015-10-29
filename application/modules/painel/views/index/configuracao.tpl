<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12" id="dash-crumb">
            Home &gt; Configuração
        </div>
        <div id="header-section-name">
            EDITAR MEUS DADOS
        </div>
    </header>
    <div id="banner-form">
        <div class="container">
            <form method="post">
                <div class="hw lt">

                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_LOGIN_USRC">Login</label>
                                <input style="cursor:not-allowed" class="bs reverb-input-1" type="text" id="DS_LOGIN_USRC" name="DS_LOGIN_USRC" disabled value="{$dadosUsuario->DS_LOGIN_USRC}">
                            </div>
                        </div>

                        <div class="reverb-fields reverb-field-9">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_SENHA_USRC">Senha</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_SENHA_USRC" name="DS_SENHA_USRC" value="{$dadosUsuario->DS_SENHA_USRC}">
                            </div>
                        </div>
                    </div>

                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-8">
                            <div class="reverb-fields reverb-field-1">
                                <label class="reverb-label-1" for="DS_EMAIL_USRC">Email</label>
                                <input  class="bs reverb-input-1" type="text" id="DS_EMAIL_USRC" name="DS_EMAIL_USRC" value="{$dadosUsuario->DS_EMAIL_USRC}">
                            </div>
                        </div>
                    </div>

                    <div class="posr fw lt form-buttons-block">
                        <button class="rt register-button reverb-btns-1"> Pronto, Salvar! <span class="ico"></span> </button>
                        <button class="rt cancel-button reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.cancel-button').on('click', function(e) {
            e.preventDefault();
            window.location = document.basePath + '/painel';
            //history.go(-1);
        });
    });
</script>

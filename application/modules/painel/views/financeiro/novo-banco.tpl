
<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Site > Financeiros > Bancos
        </div>
        <div id="header-section-name">
            Cadastrar Novo Banco
        </div>
    </header>
    <div class="lt bs posr container-contents" id="config-body">
        <form action="" method="post">
            <div class="container">
                <div class="hw lt">

                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="favorecido">Nome do Banco</label>
                            <input  class="bs reverb-input-1" type="text" id="favorecido" name="DS_BANCO_BARC">
                        </div>
                    </div>
                    <div class="posr fw lt form-buttons-block">
                        <button class="rt register-button reverb-btns-1"> Pronto, Salvar! <span class="ico"></span> </button>
                        <button class="rt cancel-button reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.fone').mask('(99)9999-9999?9');
        $('.cep').mask('99.999-999');
        $('.cancel-button').on('click', function(e) {
            e.preventDefault();
            window.location = document.basePath + '/painel/financeiro/bancos';
            //history.go(-1);
        });
    });
</script>
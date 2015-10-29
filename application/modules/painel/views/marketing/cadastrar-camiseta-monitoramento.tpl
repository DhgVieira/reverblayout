<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Marketing > Monitoramento
        </div>
        <div id="header-section-name">
            Cadastrar monitoramento
        </div>
    </header>
    <div id="banner-form">
        <div class="container">
            <div class="hw lt">
                <form method="post" action="">
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="source">Cole a URL do produto</label>
                            <input  class="bs reverb-input-1" type="text" id="source" name="NR_SEQ_PRODUTO_MOPR">
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="prazo">Inicio</label>
                            <input  class="bs reverb-input-1" type="text" id="data_inicio" name="DT_INICIO_MOPR" autocomplete="off">
                        </div>
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="prazo">Fim</label>
                            <input  class="bs reverb-input-1" type="text" id="data_fim" name="DT_FIM_MOPR" autocomplete="off">
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="investimento">Investimento total</label>
                            <input  class="bs reverb-input-1" type="text" id="investimento" name="VL_INVESTIDO_MOPR">
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="prazo">Quantidade a ser vendida</label>
                            <input  class="bs reverb-input-1" type="text" id="prazo" name="NR_QTDE_MOPR">
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
<link rel="stylesheet" href="{$basePath}/arquivos/painel/libs/jquery-ui/themes/smoothness/jquery-ui.min.css">
{literal}
<script type="text/javascript">
    $(document).ready(function(){
        $('#data_inicio').datepicker({
            dateFormat: 'dd/mm/yy',
            onSelect: function(dateStr){
                var min = $(this).datepicker('getDate');
                if(min){
                    min.setDate(min.getDate() + 1);
                }
                $('#data_fim').datepicker('option', {minDate: min});
            }
        });
        $('#data_fim').datepicker({
            dateFormat: 'dd/mm/yy'
        });
        $('.cancel-button').on('click', function(e) {
            e.preventDefault();
            window.location = document.basePath + '/painel/marketing/monitoramento-vendas';
            //history.go(-1);
        });
    });
</script>
{/literal}
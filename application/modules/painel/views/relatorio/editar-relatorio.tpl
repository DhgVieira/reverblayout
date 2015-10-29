<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12" id="dash-crumb">
            Relatórios > Gerais
        </div>
        <div id="header-section-name">
            Tela Relatórios Gerais
        </div>
    </header>
    <div id="banner-form">
        <div class="container row">
            <div class="hw lt">
                <div class="grid_20">
                    <form action="" method="post" class="form-gerar-relatorio">
                        <div class="relatorio-gerar-form relatorio-gerar-block fw lt bs">

                            <div class="row posr fw lt">
                                <h2 class="relatorio-form-title">Selecione para gerar Relatório</h2>
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="vendas">&nbsp;</label>
                                    <input type="text" name="titulo" class="bs reverb-input-1" placeholder="Título" required value="{$dadosRelatorio->DS_RELATORIO_RERC}" />
                                </div>
                            </div>

                            <div class="row posr fw lt">
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="vendas">&nbsp;</label>
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs" id="vendas" name="tipo">
                                            <option value="" disabled>Selecione</option>
                                            <option value="1" {if $dadosRelatorio->DS_TIPO_RERC == 1} selected {/if}>Vendas</option>
                                            {*<option value="2" {if $dadosRelatorio->DS_TIPO_RERC == 2} selected {/if}>Produtos</option>*}
                                        </select>
                                        <span class="select-value">{if $dadosRelatorio->DS_TIPO_RERC == 1}Vendas{else}Produtos{/if}</span>
                                    </div>
                                </div>
                            </div>
                            {*<div class="row posr fw lt">*}
                            {*<div class="reverb-fields reverb-field-1">*}
                            {*<label class="reverb-label-1" for="vendidos">&nbsp;</label>*}
                            {*<div class="reverb-input-1 select-1">*}
                            {*<select class="select bs" id="vendidos" name="vendidos">*}
                            {*<option value="" selected disabled>Selecione</option>*}
                            {*<option value="1">LOCAL 1</option>*}
                            {*<option value="2">LOCAL 2</option>*}
                            {*</select>*}
                            {*<span class="select-value">Produtos Vendidos</span>*}
                            {*</div>*}
                            {*</div>*}
                            {*</div>*}

                            <div class="row posr fw lt">
                                <div class="reverb-fields reverb-field-2">
                                    <label class="reverb-label-1"> &nbsp;</label>
                                    <div class="reverb-input-1">
                                        <input  class="bs reverb-input-1 date-pick-1" type="text" id="data_ini" name="data_ini" required value="{$dadosRelatorio->DT_INI_RERC|date_format:"%d/%m/%Y"}">
                                    </div>
                                </div>
                                <div class="reverb-fields reverb-field-2">
                                    <label class="reverb-label-1"> &nbsp;</label>
                                    <div class="reverb-input-1">
                                        <input  class="bs reverb-input-1 date-pick-1" type="text" id="data_fim" name="data_fim" required value="{$dadosRelatorio->DT_FIM_RERC|date_format:"%d/%m/%Y"}">
                                    </div>
                                </div>
                            </div>

                            <div class="row posr fw lt">
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="categoria">&nbsp;</label>
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs" id="categoria" name="tema">
                                            <option value="" {if $dadosRelatorio->NR_SEQ_PRODUTO_CATEGORIA_RERC == ""} selected {/if}>Todos</option>
                                            {foreach from=$dadosTemas item=tema}
                                                <option value="{$tema->NR_SEQ_CATEGPRO_PCRC}" {if $dadosRelatorio->NR_SEQ_PRODUTO_CATEGORIA_RERC == $tema->NR_SEQ_CATEGPRO_PCRC} selected {/if}>{$tema->DS_CATEGORIA_PCRC}</option>
                                            {/foreach}
                                        </select>
                                        <span class="select-value">Selecione o Tema</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row posr fw lt">
                                <div class="reverb-fields reverb-field-2">
                                    <label class="reverb-label-1" for="frete">&nbsp;</label>
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs" id="frete" name="genero">
                                            <option value="" {if $dadosRelatorio->NR_GENERO_RERC == ""} selected {/if}>Todos</option>
                                            <option value="1" {if $dadosRelatorio->NR_GENERO_RERC == 1} selected {/if}>Masculino</option>
                                            <option value="2" {if $dadosRelatorio->NR_GENERO_RERC == 2} selected {/if}>Feminino</option>
                                        </select>
                                        <span class="select-value"></span>
                                    </div>
                                </div>
                                <div class="reverb-fields reverb-field-2">
                                    <label class="reverb-label-1" for="tamanho">&nbsp;</label>
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs" id="tamanho" name="tamanho">
                                            <option value="" selected>Todos</option>
                                            {foreach from=$dadosTamanho item=tamanho}
                                                <option value="{$tamanho->NR_SEQ_TAMANHO_TARC}" {if $dadosRelatorio->NR_SEQ_TAMANHO_RERC == $tamanho->NR_SEQ_TAMANHO_TARC}selected{/if}>{$tamanho->DS_TAMANHO_TARC}</option>
                                            {/foreach}
                                        </select>
                                        <span class="select-value">Selecione o Tamanho</span>
                                    </div>
                                </div>
                            </div>
                            {*<div class="row posr fw lt">*}
                            {*<p class="nm warn-relatorio-form">*}
                            {*Descrição do relatório. Resumo de todas as vendas Líquidas de um dia específico. Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis.*}
                            {*</p>*}
                            {*</div>*}
                            <input type="submit" style="display: none;" class="btn-submit-relatorio" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container row">
            <div class="hw lt">
                <div class="posr fw lt gerar-relatorio-btm">
                    <button class="head-cells fs12 cells nap bs grn-btn green-btn-4 plus-check lt gerar-relatorio">Salvar Relatório</button>
                </div>
            </div>
            {*<div class="hw lt">*}
            {*<div class="posr fw lt gerar-relatorio-btm">*}
            {*<button class="head-cells fs12 cells nap bs grn-btn green-btn-4 plus-check lt">Comparar Relatórios Assinalados</button>*}
            {*<button class="head-cells fs12 cells nap bs grn-btn green-btn-4 plus-check rt">Gerar Relatórios Assinalados</button>*}
            {*</div>*}
            {*</div>*}
        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
        $(document).ready(function(){
            $('select').each(function() {
                $(this).next().html($(this).find('option:selected').text());
            });
            $('.gerar-relatorio').on('click', function() {
                $('.btn-submit-relatorio').click();
            });

            $("input[name='data_ini']").datepicker('destroy').datepicker({
                maxDate: '+0',
                onSelect: function(dateStr) {
                    var min = $(this).datepicker('getDate') || new Date(); // Selected date or today if none
                    $("input[name='data_fim']").datepicker('option', {minDate: min});
                }
            }).mask('99/99/9999');
            $("input[name='data_fim']").datepicker('destroy').datepicker({
                maxDate: '+0',
                onSelect: function(dateStr) {
                    dateNow = new Date;
                    var max = $(this).datepicker('getDate'); // Selected date or null if none
                    if(max > dateNow){
                        $("input[name='data_ini']").datepicker('option', {maxDate: '+0'});
                    }else{
                        $("input[name='data_ini']").datepicker('option', {maxDate: max});
                    }


                }
            }).mask('99/99/9999');
        });
    </script>
{/literal}
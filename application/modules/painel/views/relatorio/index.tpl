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
                    <form action="{$basePath}/painel/relatorio/cadastrar-relatorio" method="post" class="form-gerar-relatorio">
                        <div class="relatorio-gerar-form relatorio-gerar-block fw lt bs">

                            <div class="row posr fw lt">
                                <h2 class="relatorio-form-title">Selecione para gerar Relatório</h2>
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="vendas">&nbsp;</label>
                                    <input type="text" name="titulo" class="bs reverb-input-1" placeholder="Título" required />
                                </div>
                            </div>

                            <div class="row posr fw lt">
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="vendas">&nbsp;</label>
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs" id="vendas" name="tipo">
                                            <option value="" disabled>Selecione</option>
                                            <option value="1" selected>Vendas</option>
                                            {*<option value="2">Produtos</option>*}
                                        </select>
                                        <span class="select-value">Vendas</span>
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
                                        <input  class="bs reverb-input-1 date-pick-1" type="text" id="data_ini" name="data_ini" required>
                                    </div>
                                </div>
                                <div class="reverb-fields reverb-field-2">
                                    <label class="reverb-label-1"> &nbsp;</label>
                                    <div class="reverb-input-1">
                                        <input  class="bs reverb-input-1 date-pick-1" type="text" id="data_fim" name="data_fim" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row posr fw lt">
                                <div class="reverb-fields reverb-field-1">
                                    <label class="reverb-label-1" for="categoria">&nbsp;</label>
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs" id="categoria" name="tema">
                                            <option value="" selected>Todos</option>
                                            {foreach from=$dadosTemas item=tema}
                                                <option value="{$tema->NR_SEQ_CATEGPRO_PCRC}">{$tema->DS_CATEGORIA_PCRC}</option>
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
                                            <option value="" selected>Todos</option>
                                            <option value="1">Masculino</option>
                                            <option value="2">Feminino</option>
                                        </select>
                                        <span class="select-value">Selecione o Genero</span>
                                    </div>
                                </div>
                                <div class="reverb-fields reverb-field-2">
                                    <label class="reverb-label-1" for="tamanho">&nbsp;</label>
                                    <div class="reverb-input-1 select-1">
                                        <select class="select bs" id="tamanho" name="tamanho">
                                            <option value="" selected>Todos</option>
                                            {foreach from=$dadosTamanho item=tamanho}
                                                <option value="{$tamanho->NR_SEQ_TAMANHO_TARC}">{$tamanho->DS_TAMANHO_TARC}</option>
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
            <div class="hw lt">
                <div class="grid_20">
                    <div class="relatorio-gerar-block">
                        <div class="table-heads tables-heads bs posr fw lt">
                            <form action="">
                                <div class="th-cells head-category-title bs head-relatorio">
                                    <div id="relatorios-labels">Relatórios Salvos</div>
                                    <input class="rt" type="submit" id="busca-relatorios-submit" value="Buscar">
                                    <input class="rt" type="text" id="busca-relatorios">
                                </div>
                            </form>
                        </div>
                        <div class="table-scroll categoria-scroll relatorio-scroll">
                            <table class="fw painel-tables">
                                <thead class="table-heads tables-heads">
                                    <tr style="display:none;">
                                        <th class="th-cells head-category-title" colspan="3">Relatórios Salvos</th>
                                    </tr>
                                </thead>
                                <tbody class="tables-body indica-body">
                                    <tr>
                                    {foreach from=$dadosRelatorio item=relatorio}
                                        <td class="tb-cells tlt lg-cols">{$relatorio->DS_RELATORIO_RERC}</td>
                                        <td class="tb-cells posr body-action min-2 has-pop-over">
                                            <div class="pop-over lt">
                                                <span class="open-pop-over">Opções</span>
                                                <div class="content-popover popover-4">
                                                    <ul class="nm np  fs13 pop-over-list-1">
                                                        <li class="nl bs posr popover-items popover-items-1">
                                                            <span class="ico ico-dd-edi"></span>
                                                            <a href="{$this->url(['module' => 'painel', 'controller' => 'relatorio', 'action' => 'editar-relatorio', 'id' => $relatorio->NR_SEQ_RELATORIO_RERC], null, true)}">Editar</a>
                                                        </li>
                                                        <li class="nl bs posr popover-items-1 popover-delete-1">
                                                            <span class="ico ico-dd-exc"></span>
                                                            <a href="{$this->url(['module' => 'painel', 'controller' => 'relatorio', 'action' => 'excluir-relatorio', 'id' => $relatorio->NR_SEQ_RELATORIO_RERC], null, true)}">Excluir</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="td-cells posr atualiza">
                                            <a href="{$this->url(['module' => 'painel', 'controller' => 'relatorio', 'action' => 'simples-gerado', 'id' => $relatorio->NR_SEQ_RELATORIO_RERC], null, true)}" class="atualiza-btn"></a>
                                        </td>
                                    </tr>
                                    {/foreach}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container row">
            <div class="hw lt">
                <div class="posr fw lt gerar-relatorio-btm">
                    <button class="head-cells fs12 cells nap bs grn-btn green-btn-4 plus-check lt gerar-relatorio">Gerar Relatório</button>
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
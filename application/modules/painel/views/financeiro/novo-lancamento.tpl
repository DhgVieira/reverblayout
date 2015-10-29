<div class="container-body">
    <header class="fw lt bs" id="container-top">
        <div class="fw lt" id="top-menu">
            <button class="rt bs fs13 top-btns" id="logout-btn"></button>
            <a href="#Logout" class="rt anchor fs13 top-btns"> Log Out</a>
            <a href="#Logout" class="rt anchor fs13 top-btns"> Ir para o site</a>
        </div>
        <div class="fw lt fs12 right-crumb">
            Financeiro &gt; Lançamento
        </div>
        <div id="header-section-name">
            Cadastrar Novo Lançamento
        </div>
    </header>
    <div class="lt bs posr container-contents" id="config-body">
        <div class="container">
            <form action="" method="post" class="form-financeiro">
                <div class="hw lt">
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="fornecedor">Fornecedor</label>
                            <div class="reverb-input-1 select-1">
                                <select class="select bs" id="fornecedor" name="NR_FORNECEDOR_LARC">
                                    <option value="" selected disabled>Selecione</option>
                                    {foreach from=$dadosFornecedor item=fornecedor}
                                        <option value="{$fornecedor->NR_SEQ_FORNECEDOR_FORC}">{$fornecedor->DS_FANTASIA_FORC}</option>
                                    {/foreach}
                                </select>
                                <span class="select-value">Selecione</span>
                            </div>
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="tipo">Banco</label>
                            <div class="reverb-input-1 select-1">
                                <select class="select bs" id="tipo" name="NR_BANCO_LARC">
                                    <option value="" selected disabled>Selecione</option>
                                    {foreach from=$dadosBanco item=banco}
                                        <option value="{$banco->NR_SEQ_BANCO_BARC}">{$banco->DS_BANCO_BARC}</option>
                                    {/foreach}
                                </select>
                                <span class="select-value">Selecione</span>
                            </div>
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="categoria">Categoria</label>
                            <div class="reverb-input-1 select-1">
                                <select class="select bs" id="categoria" name="NR_CATEGORIA_LARC">
                                    <option value="" selected disabled>Selecione</option>
                                    <option value="1">Débito</option>
                                    <option value="2">Crédito</option>
                                </select>
                                <span class="select-value">Selecione</span>
                            </div>
                        </div>
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="subcategoria">Classificação</label>
                            <div class="reverb-input-1 select-1">
                                <select class="select bs" id="subcategoria" name="NR_CLASSIFICACAO_LARC">
                                    <option value="" selected disabled>Selecione</option>
                                    <option value="1">Classificação 1</option>
                                    <option value="2">Classificação 2</option>
                                </select>
                                <span class="select-value">Selecione</span>
                            </div>
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-9 wrap-datepick lt">
                            <label class="reverb-label-1" for="emissao">Data de Emissão</label>
                            <input  class="bs reverb-input-1 date-pick-1" type="text" id="emissao" name="DT_EMISSAO_LARC">
                        </div>
                        <div class="reverb-fields reverb-field-9 wrap-datepick lt">
                            <label class="reverb-label-1" for="vcto">1º Vencimento</label>
                            <input  class="bs reverb-input-1 date-pick-1" type="text" id="vcto" name="DT_VENCIMENTO_LARC">
                        </div>
                        <div class="reverb-fields reverb-field-3 lt">
                            <label class="reverb-label-1" for="parcelas">Parcelas</label>
                            <input  class="bs reverb-input-1" type="text" id="parcelas" name="NR_PARCELAS_LARC">
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-9">
                            <label class="reverb-label-1" for="periodicidade">Periodicidade</label>
                            <div class="reverb-input-1 select-1">
                                <select class="select bs" id="periodicidade" name="NR_PERIODO_LARC">
                                    <option value="" selected disabled>Selecione</option>
                                    <option value="1">Diário</option>
                                    <option value="2">Semanal</option>
                                    <option value="3">Quinzenal</option>
                                    <option value="4">Mensal</option>
                                    <option value="5">Semestral</option>
                                    <option value="6">Anual</option>
                                </select>
                                <span class="select-value">Selecione</span>
                            </div>
                        </div>
                        <div class="reverb-fields reverb-field-3 lt">
                            <label class="reverb-label-1" for="valor">Valor</label>
                            <input  class="bs reverb-input-1 money" type="text" id="valor" name="VL_VALOR_LARC">
                        </div>
                        <div class="reverb-fields reverb-field-9 lt posr">
                            <div class="wrap-checkbox wrap-reverb-checkbox-3">
                                <input class="checkbox" type="checkbox" id="checkbox-repeat" name="DS_REPETIR_LARC" value="1">
                                <label class="styled-reverb-checkbox" for="checkbox-repeat"></label>
                            </div>
                            <label class="reverb-label-3 bs" for="checkbox-repeat">
                                Repetir a mesma data nos <br>
                                demais vencimentos
                            </label>
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-1">
                            <label class="reverb-label-1" for="observacoes">Observações</label>
                            <div class="wrap-textarea">
                                <textarea  class="reverb-input-4" type="text" id="descricao" name="DS_OBS_LARC"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                {*<div class="hw rt">*}
                    {*<div class="table-heads tables-heads posr fw lt">*}
                        {*<div class="th-cells head-category-title">*}
                            {*Previsão de Vencimentos*}
                            {*<div class="posa previsao-total">*}
                                {*Valor total R$ <span id="valor-sub-total">67.987,99</span>*}
                            {*</div>*}
                        {*</div>*}
                    {*</div>*}
                    {*<div class="table-scroll categoria-scroll">*}
                        {*<table class="fw painel-tables">*}
                            {*<thead class="table-heads tables-heads">*}
                                {*<tr style="display:none;">*}
                                    {*<th class="th-cells head-category-title" colspan="3">Colunistas cadastradas</th>*}
                                {*</tr>*}
                            {*</thead>*}
                            {*<tbody class="tables-body indica-body">*}
                                {*<tr>*}
                                {*{for $i=1 to 20}*}
                                    {*<td class="tb-cells vcto-count"> {$i} de 20</td>*}
                                    {*<td class="tb-cells body-data last-col tmd">01/10/2013</td>*}
                                    {*<td class="tb-cells">*}
                                        {*R$ 300,00*}
                                    {*</td>*}
                                {*</tr>*}
                                {*{/for}*}
                            {*</tbody>*}
                        {*</table>*}
                    {*</div>*}
                {*</div>*}
                <div class="posr fw lt form-buttons-block">
                    <button class="lt cancel-button reverb-btns-1"> Cancelar! <span class="ico"></span> </button>
                    <button class="lt register-button reverb-btns-1"> Pronto, Cadastrar! <span class="ico"></span> </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="{$basePath}/arquivos/painel/libs/jquery-maskmoney/jquery.maskMoney.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.money').maskMoney({
            prefix: 'R$ '
        });

        $('.register-button').on('click', function(e) {
            $('.form-financeiro').submit();
        })

        $('.cancel-button').on('click', function(e){
            e.preventDefault();
            window.location = document.basePath + '/painel/financeiro';
        })
    });
</script>
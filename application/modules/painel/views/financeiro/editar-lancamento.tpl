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
            Editar Lançamento
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
                                    {foreach from=$dadosFornecedor item=fornecedor}
                                        <option {if $dadosLancamento->NR_FORNECEDOR_LARC == $fornecedor->NR_SEQ_FORNECEDOR_FORC}selected{/if} value="{$fornecedor->NR_SEQ_FORNECEDOR_FORC}">{$fornecedor->DS_FANTASIA_FORC}</option>
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
                                    {foreach from=$dadosBanco item=banco}
                                        <option {if $dadosLancamento->NR_BANCO_LARC == $banco->NR_SEQ_BANCO_BARC}selected{/if} value="{$banco->NR_SEQ_BANCO_BARC}">{$banco->DS_BANCO_BARC}</option>
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
                                    <option {if $dadosLancamento->NR_CATEGORIA_LARC == 1}selected{/if} value="1">Débito</option>
                                    <option {if $dadosLancamento->NR_CATEGORIA_LARC == 2}selected{/if} value="2">Crédito</option>
                                </select>
                                <span class="select-value">Selecione</span>
                            </div>
                        </div>
                        <div class="reverb-fields reverb-field-2">
                            <label class="reverb-label-1" for="subcategoria">Classificação</label>
                            <div class="reverb-input-1 select-1">
                                <select class="select bs" id="subcategoria" name="NR_CLASSIFICACAO_LARC">
                                    <option {if $dadosLancamento->NR_CLASSIFICACAO_LARC == 1}selected{/if} value="1">Classificação 1</option>
                                    <option {if $dadosLancamento->NR_CLASSIFICACAO_LARC == 2}selected{/if} value="2">Classificação 2</option>
                                </select>
                                <span class="select-value">Selecione</span>
                            </div>
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-9 wrap-datepick lt">
                            <label class="reverb-label-1" for="emissao">Data de Emissão</label>
                            <input  class="bs reverb-input-1 date-pick-1" type="text" id="emissao" name="DT_EMISSAO_LARC" value="{$dadosLancamento->DT_EMISSAO_LARC|date_format:'%d/%m/%Y'}">
                        </div>
                        <div class="reverb-fields reverb-field-9 wrap-datepick lt">
                            <label class="reverb-label-1" for="vcto">Vencimento</label>
                            <input  class="bs reverb-input-1 date-pick-1" type="text" id="vcto" name="DT_VENCIMENTO_LARC" value="{$dadosLancamento->DT_VENCIMENTO_LARC|date_format:'%d/%m/%Y'}">
                        </div>
                        <div class="reverb-fields reverb-field-3 lt">
                            <label class="reverb-label-1" for="parcelas">Parcelas</label>
                            <input  class="bs reverb-input-1" type="text" id="parcelas" name="NR_PARCELAS_LARC" value="{$dadosLancamento->NR_PARCELAS_LARC}">
                        </div>
                    </div>
                    <div class="row posr fw lt">
                        <div class="reverb-fields reverb-field-9">
                            <label class="reverb-label-1" for="periodicidade">Periodicidade</label>
                            <div class="reverb-input-1 select-1">
                                <select class="select bs" id="periodicidade" name="NR_PERIODO_LARC">
                                    <option {if $dadosLancamento->NR_PERIODO_LARC == 1}selected{/if} value="1">Diário</option>
                                    <option {if $dadosLancamento->NR_PERIODO_LARC == 2}selected{/if} value="2">Semanal</option>
                                    <option {if $dadosLancamento->NR_PERIODO_LARC == 3}selected{/if} value="3">Quinzenal</option>
                                    <option {if $dadosLancamento->NR_PERIODO_LARC == 4}selected{/if} value="4">Mensal</option>
                                    <option {if $dadosLancamento->NR_PERIODO_LARC == 5}selected{/if} value="5">Semestral</option>
                                    <option {if $dadosLancamento->NR_PERIODO_LARC == 6}selected{/if} value="6">Anual</option>
                                </select>
                                <span class="select-value">Selecione</span>
                            </div>
                        </div>
                        <div class="reverb-fields reverb-field-3 lt">
                            <label class="reverb-label-1" for="valor">Valor</label>
                            <input  class="bs reverb-input-1 money" type="text" id="valor" name="VL_VALOR_LARC" value="R$ {$dadosLancamento->VL_VALOR_LARC|number_format:2:".":","}">
                        </div>
                        <div class="reverb-fields reverb-field-9 lt posr">
                            <div class="wrap-checkbox wrap-reverb-checkbox-3">
                                <input class="checkbox" type="checkbox" id="checkbox-repeat" name="DS_REPETIR_LARC" {if $dadosLancamento->DS_REPETIR_LARC == 1}checked{/if} value="1">
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
                                <textarea  class="reverb-input-4" type="text" id="descricao" name="DS_OBS_LARC">{$dadosLancamento->DS_OBS_LARC}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                {if $dadosLancamentoFuturo|@count gt 0}
                <div class="hw rt">
                    <div class="table-heads tables-heads posr fw lt">
                        <div class="th-cells head-category-title">
                            Previsão de Vencimentos
                        </div>
                    </div>
                    <div class="table-scroll categoria-scroll">
                        <table class="fw painel-tables">
                            <tbody class="tables-body indica-body">
                                <tr>
                                {foreach from=$dadosLancamentoFuturo item=futuro}
                                    <td class="tb-cells vcto-count"> {$futuro->DS_NUMERO_PARCELA_LARC} de {$dadosLancamento->NR_PARCELAS_LARC}</td>
                                    <td class="tb-cells body-data last-col tmd">{$futuro->DT_VENCIMENTO_LARC|date_format:'%d/%m/%Y'}</td>
                                    <td class="tb-cells">
                                        R$ {$dadosLancamento->VL_VALOR_LARC|number_format:2:".":","}
                                    </td>
                                </tr>
                                {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
                {/if}
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
        $('select').change();
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
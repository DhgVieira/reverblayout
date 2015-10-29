        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Site > Financeiro
                </div>
                <div id="header-section-name">
                    Financeiro
                </div>
                <div id="header-section-name">
                    {$pageName}
                    {*<div class="header-helpers">*}
                        {*<a href="#" class="header-helpers-actions" id="new-action"></a>*}
                        {*<a href="#" class="header-helpers-actions" id="email-action"></a>*}
                        {*<a href="#" class="header-helpers-actions" id="print-action"></a>*}
                    {*</div>*}
                </div>
            </header>
            <div class="lt bs posr container-contents" id="indicacoes-body">
                <div class="container">
                    <div class="row above-thead">
                        <a class="head-cells fs13 cells nap bs grn-btn plus-check green-btn-auto posr" href="{$this->url(['module' => 'painel', 'controller' => 'financeiro', 'action' => 'novo-lancamento'], null, true)}">Adicionar novo lançamento</a>
                        {*<button class="lt calendar-button reverb-btns-1 f4 fs12"> Ir para a data <span class="ico"></span> </button>*}
                        {*<form action="">*}
                            {*<div class="t-head-options bs fs11 select-2">*}
                                {*<select class="select bs" id="loteoptions" name="loteoptions">*}
                                    {*<option value="" selected disabled>Selecione</option>*}
                                    {*<option value="1">LOCAL 1</option>*}
                                    {*<option value="2">LOCAL 2</option>*}
                                {*</select>*}
                                {*<span class="select-value">LOCAL 1</span>*}
                            {*</div>*}
                            {*<button class="head-cells fs13 cells nap bs grn-btn plus-check green-btn-auto posr">OK</button>*}
                            {*<input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">*}
                            {*<input type="text" class="thead-search-field min rt bs">*}
                        {*</form>*}
                    </div>
                    <table class="fw financeiro-tables" id="indicacao-table">
                        <thead class="table-heads indica-head">
                            <tr>
                                <th class="th-cells head-chck"></th>
                                <th class="th-cells head-numb">VENCIMENTO</th>
                                <th class="th-cells head-data">FORNECEDOR/CATEGORIA</th>
                                <th class="th-cells th-f-tipo head-tipo">TIPO</th>
                                <th class="th-cells head-vals">VALOR</th>
                                <th class="th-cells head-pago">VALOR PAGO</th>
                                <th class="th-cells head-dbnc">DATA/BANCO</th>
                                <th class="th-cells head-subc">CLASSIFICAÇÃO</th>
                                <th class="th-cells th-options">OPÇÕES</th>
                            </tr>
                        </thead>

                        <tbody class="tables-body banners-body financeiro-tbody">
                            {foreach from=$dadosLancamento key=i item=lancamento}
                                <tr class="gray-row-collapse collapse-open open-collapse-{$i}">
                                    <td class="tb-cells posr collapse-indicators">
                                        <span class="posr indicator"></span>
                                    </td>
                                    <td posr> {$lancamento['DT_VENCIMENTO_LARC']|date_format:'%d/%m/%Y'} </td>
                                    <td posr> &nbsp; </td>
                                    <td posr> &nbsp; </td>
                                    <td > R$ {$lancamento['VL_TOTAL']|number_format:2:".":","} </td>
                                    <td > R$ {$lancamento['VL_PAGO']|number_format:2:".":","} </td>
                                    <td posr> &nbsp; </td>
                                    <td posr> &nbsp; </td>
                                    <td posr>
                                            {*<div class="lt fw row-btns">*}
                                                {*<a href="{$this->url(['module' => 'painel', 'controller' => 'site', 'action' => 'editar-banner', 'id' => $banner->NR_SEQ_BANNER_BARC], null, true)}" class="row-btns-el btn-financ-config"></a>*}
                                            {*</div>*}
                                    </td>
                                </tr>
                                {foreach from=$lancamento['lancamentos'] key=j item=item}
                                    <tr class="collapsed collapsed-{$i}">
                                        <td class="tb-cells posr body-chck">
                                            {*<div class="wrap-checkbox wrap-reverb-checkbox-2">*}
                                                {*<input class="checkbox" type="checkbox" id="checkbox-{$j}" checked>*}
                                                {*<label class="styled-reverb-checkbox" for="checkbox-{$j}"></label>*}
                                            {*</div>*}
                                        </td>
                                        <td class="tb-cells posr body-chck">
                                            {$item['DT_VENCIMENTO_LARC']|date_format:'%d/%m/%Y'}
                                        </td>
                                        <td class="tb-cells brks body-name">
                                            <div><span class="f4">{$item['DS_FANTASIA_FORC']} </span><br></div>
                                            <div>{if $item['NR_CATEGORIA_LARC'] == 1}Débito{else}Crédito{/if}</div>
                                        </td>
                                        <td class="tb-cells tb-f-tipo posr financeiro-tipo">
                                            <div>
                                                <div class="financeiro-balls">
                                                    <span class="financeiro-ball bs fs12">A</span>
                                                </div>
                                                {if $j == 0}
                                                    <div class="financeiro-down"></div>
                                                {else}
                                                    <div class="financeiro-up"></div>
                                                {/if}
                                            </div>
                                        </td>
                                        {assign var=valorTotal value=$item['VL_VALOR_LARC'] * $item['NR_PARCELAS_LARC']}
                                        <td class="tb-cells body-valor"><span class="f4">{$valorTotal|number_format:2:".":","}</span></td>
                                        <td class="tb-cells body-pago"><span>{$item['VL_VALOR_LARC']|number_format:2:".":","}</span></td>
                                        <td class="tb-cells body-dbnc">
                                            <div>{$item['DT_VENCIMENTO_LARC']|date_format:'%d/%m/%Y'} <br></div>
                                            <div>{$item['DS_BANCO_BARC']}</div>
                                        </td>
                                        <td class="tb-cells body-subc">
                                            {if $item['NR_CLASSIFICACAO_LARC'] == 1}Classificação 1{/if}
                                            {if $item['NR_CLASSIFICACAO_LARC'] == 2}Classificação 2{/if}
                                        </td>
                                        <td class="tb-cells posr tb-options">
                                            <div class="lt fw row-btns">
                                                <a href="{$this->url(['module' => 'painel', 'controller' => 'financeiro', 'action' => 'editar-lancamento', 'id' => $item['NR_SEQ_LANCAMENTO_LARC']], null, true)}" class="row-btns-el btn-financ-config"></a>
                                            </div>
                                        </td>
                                    </tr>
                                {/foreach}
                            {/foreach}
                        </tbody>
                    </div>
                </div>
            </div>
        </div>
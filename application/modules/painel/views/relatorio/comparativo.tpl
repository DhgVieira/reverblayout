
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                {include file="painel-topmenu.tpl"}
                <div class="fw lt fs12" id="dash-crumb">
                    Relatórios > Gerais
                </div>
                <div id="header-section-name">
                    Relatórios Gerais
                </div>
            </header>
            <div class="grid_20" id="comparativo-relatorio">
                <div class="container row">
                    <h2 class="relatorio-title fs17">MODELO DE RELATÓRIO COMPARATIVO</h2>
                    <div class="fw lt fs13" id="relatorio-dates">
                        <div class="lt">16/05/2014 a 16/05/2014</div>
                        <div class="rt">Gerado em 17/05/2014</div>
                    </div>
                    <div class="fw lt posr bs wrap-relatorio-table">
                        <table class="fw lt posr relatorio-tables" cellpadding="0" cellspacing="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                            <thead class="relatorio-thead">
                                <tr class="tmd fs13">
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">DATA</div></th>
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">COMPRA</div></th>
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">VALOR TOTAL</div></th>
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">VALOR FRETE</div></th>
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">VALOR SEM FRETE</div></th>
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">TARIFAS</div></th>
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">CUSTO FRETE</div></th>
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">VALOR LÍQUIDO</div></th>
                                </tr>
                            </thead>
                            <tbody class="relatorio-tbody">
                                {for $i = 0 to 9}
                                <tr class="tmd fs12">
                                    <td class="relatorio-cells relatorio-td">16/05/2014</td>
                                    <td class="relatorio-cells relatorio-td">321782</td>
                                    <td class="relatorio-cells relatorio-td">2,855,19</td>
                                    <td class="relatorio-cells relatorio-td">81,57</td>
                                    <td class="relatorio-cells relatorio-td">2.773,34</td>
                                    <td class="relatorio-cells relatorio-td">1,90</td>
                                    <td class="relatorio-cells relatorio-td">123,30</td>
                                    <td class="relatorio-cells relatorio-td">2,763,24</td>
                                </tr>
                                {/for}
                            </tbody>
                            <tfoot class="relatorio-tfoot">
                                <tr class="tmd fs12">
                                    <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                    <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                    <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                    <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                    <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                    <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                    <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                    <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">2,763,24</div></td>
                                </tr>
                            </tfoot>
                        </table>

                        <table class="fw lt posr relatorio-tables" cellpadding="0" cellspacing="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                            <thead class="relatorio-thead">
                                <tr class="tmd fs13">
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">DATA</div></th>
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">COMPRA</div></th>
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">VALOR TOTAL</div></th>
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">VALOR FRETE</div></th>
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">VALOR SEM FRETE</div></th>
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">TARIFAS</div></th>
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">CUSTO FRETE</div></th>
                                    <th class="relatorio-cells relatorio-th"><div class="relatorio-th-blocks">VALOR LÍQUIDO</div></th>
                                </tr>
                            </thead>
                            <tbody class="relatorio-tbody">
                                {for $i = 0 to 9}
                                <tr class="tmd fs12">
                                    <td class="relatorio-cells relatorio-td">16/05/2014</td>
                                    <td class="relatorio-cells relatorio-td">321782</td>
                                    <td class="relatorio-cells relatorio-td">2,855,19</td>
                                    <td class="relatorio-cells relatorio-td">81,57</td>
                                    <td class="relatorio-cells relatorio-td">2.773,34</td>
                                    <td class="relatorio-cells relatorio-td">1,90</td>
                                    <td class="relatorio-cells relatorio-td">123,30</td>
                                    <td class="relatorio-cells relatorio-td">2,763,24</td>
                                </tr>
                                {/for}
                            </tbody>
                            <tfoot class="relatorio-tfoot">
                                <tr class="tmd fs12">
                                    <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                    <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                    <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                    <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                    <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                    <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                    <td class="relatorio-cells blank"><div class="relatorio-tf-blocks">&nbsp;</div></td>
                                    <td class="relatorio-cells relatorio-tot-vals"><div class="relatorio-tf-blocks">2,763,24</div></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="posr fw lt" id="relatorio-comparativo">
                        <div id="wrap-comparativo-svg-labels">
                            <div class="comparativo-svg-labels posa" style="top: {100 - intval(($vendas1[0]['vendas']/$max) * 80)}%">label 1</div>
                            <div class="comparativo-svg-labels posa" style="top: {100 - intval(($vendas2[0]['vendas']/$max) * 80)}%">label 2</div>                            
                            {for $b=0 to (count($vendas1) - 1)}
                                {if $b === (count($vendas1) - 1)}
                                <div class="comparativo-btm-month posa" style="left: {intval(($b/(count($vendas1) - 1)) * 98) + 1}%">{$monthArray[$vendas1[$b]['mon']]}</div>
                                {else if $b === 0}
                                <div class="comparativo-btm-month posa" style="left: {intval(($b/(count($vendas1) - 1)) * 98) + 1}%">{$monthArray[$vendas1[$b]['mon']]}</div>
                                {else}
                                <div class="comparativo-btm-month posa" style="left: {intval(($b/(count($vendas1) - 1)) * 98) + 1}%">{$monthArray[$vendas1[$b]['mon']]}</div>
                                {/if}
                            {/for}
                        </div>
                        <svg id="comparativo-svg">
                            <g class="graph-skeleton">
                                {for $a=0 to (count($vendas1) - 1)}
                                    <line x1="1%" x2="99%" y1="100%" y2="100%" class="comparativo-guide"></line>
                                    {if $a === (count($vendas1) - 1)}
                                    <line x1="{intval(($a/(count($vendas1) - 1)) * 98) + 1}%" x2="{intval(($a/(count($vendas1) - 1)) * 98) + 1}%" y1="0%" y2="100%" class="comparativo-guide"></line>
                                    {else if $a === 0}
                                    <line x1="{intval(($a/(count($vendas1) - 1)) * 98) + 1}%" x2="{intval(($a/(count($vendas1) - 1)) * 98) + 1}%" y1="0" y2="100%" class="comparativo-guide"></line>
                                    {else}
                                    <line x1="{intval(($a/(count($vendas1) - 1)) * 98) + 1}%" x2="{intval(($a/(count($vendas1) - 1)) * 98) + 1}%" y1="10%" y2="100%" class="comparativo-guide"></line>
                                    {/if}
                                {/for}
                            </g>
                            <g class="graph-first">
                                {foreach from=$vendas1 key=key item=vendas}
                                    {if $key === (count($vendas1) - 1)}
                                    <line stroke-dasharray="3, 3" x1="{intval((($key-1)/(count($vendas1) - 1)) * 98) + 1}%" x2="99%" y1="{100 - intval(($vendas1[$key-1]['vendas']/$max) * 80)}%" y2="{100 - intval(($vendas['vendas']/$max) * 80)}%" class="comparativo-dotted"></line>
                                    {else if $key === 0}
                                    <line stroke-dasharray="3, 3" x1="1%" x2="1%" y1="{100 - intval(($vendas['vendas']/$max) * 80)}%" y2="{100 - intval(($vendas['vendas']/$max) * 80)}%" class="comparativo-dotted"></line>
                                    {else}
                                    <line stroke-dasharray="3, 3" x1="{intval((($key-1)/(count($vendas1) - 1)) * 98) + 1}%" x2="{intval(($key/(count($vendas1) - 1)) * 98) + 1}%" y1="{100 - intval(($vendas1[$key-1]['vendas']/$max) * 80)}%" y2="{100 - intval(($vendas['vendas']/$max) * 80)}%" class="comparativo-dotted"></line>
                                    {/if}
                                {/foreach}
                                {foreach from=$vendas1 key=key item=vendas}
                                    <g data-a="{$vendas['vendas']}" data-b="{$max}" ></g>
                                    {if $key === (count($vendas1) - 1)}
                                    <circle class="first-graph-points" cx="99%" cy="{100 - intval(($vendas['vendas']/$max) * 80)}%" r="4"></circle>
                                    {else if $key === 0}
                                    <circle class="first-graph-points" cx="1%" cy="{100 - intval(($vendas['vendas']/$max) * 80)}%" r="4"></circle>
                                    {else}
                                    <circle class="first-graph-points" cx="{intval(($key/(count($vendas1) - 1)) * 98) + 1}%" cy="{100 - intval(($vendas['vendas']/$max) * 80)}%" r="4"></circle>
                                    {/if}
                                {/foreach}
                            </g>
                            <g class="graph-second">
                                {foreach from=$vendas2 key=key item=vendas}
                                    {if $key === (count($vendas2) - 1)}
                                    <line x1="{intval((($key-1)/(count($vendas2) - 1)) * 98) + 1}%" x2="99%" y1="{100 - intval(($vendas2[$key-1]['vendas']/$max) * 80)}%" y2="{100 - intval(($vendas['vendas']/$max) * 80)}%" class="comparativo-guide"></line>
                                    {else if $key === 0}
                                    <line x1="1%" x2="1%" y1="{100 - intval(($vendas['vendas']/$max) * 80)}%" y2="{100 - intval(($vendas['vendas']/$max) * 80)}%" class="comparativo-guide"></line>
                                    {else}
                                    <line x1="{intval((($key-1)/(count($vendas2) - 1)) * 98) + 1}%" x2="{intval(($key/(count($vendas2) - 1)) * 98) + 1}%" y1="{100 - intval(($vendas2[$key-1]['vendas']/$max) * 80)}%" y2="{100 - intval(($vendas['vendas']/$max) * 80)}%" class="comparativo-guide"></line>
                                    {/if}
                                {/foreach}

                                {foreach from=$vendas2 key=key item=vendas}
                                    {if $key === (count($vendas2) - 1)}
                                    <circle class="second-graph-points" cx="99%" cy="{100 - intval(($vendas['vendas']/$max) * 80)}%" r="5"></circle>
                                    {else if $key === 0}
                                    <circle class="second-graph-points" cx="1%" cy="{100 - intval(($vendas['vendas']/$max) * 80)}%" r="5"></circle>
                                    {else}
                                    <circle class="second-graph-points" cx="{intval(($key/(count($vendas2) - 1)) * 98) + 1}%" cy="{100 - intval(($vendas['vendas']/$max) * 80)}%" r="5"></circle>
                                    {/if}
                                {/foreach}
                            </g>
                        </svg>
                    </div>
                    <div class="fw lt posr fs12" id="simple-gerado-btm">
                        <div class="lt">Reverbcity</div>
                        <div class="rt">Página 1 de 1</div>
                    </div>
                </div>
            </div>
        </div>
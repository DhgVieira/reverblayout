<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Home > Produtos
        </div>
        <div id="header-section-name">
            Previsão de Produção
        </div>
    </header>
    <div class="lt bs posr container-contents fw" id="indicacoes-body">
        <div class="container">
            <div class="row above-thead">
                <form action="" method="post">
                    {*<input type="text" class="thead-insert-field lt bs" name="inserir" placeholder="Digite  o nome do produto para inserir">*}
                    {*<button class="head-cells fs13 cells nap bs grn-btn plus-check green-btn-auto posr" id="insert-items">INSERIR</button>*}
                    <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                    <input type="text" class="thead-search-field rt bs" name="busca" value="{$termo}">
                    {*<div class="wrap-filter-widget rt posr">*}
                        {*<div class="filter-widget bs fs12 posr">*}
                            {*<span class="filter-widget-top-label">*}
                                {*Filtrar por legenda*}
                            {*</span>*}
                            {*<ul class="filter-widget-list nm np">*}
                                {*<li class="filter-widget-items nl filter-widget-stock fw lt bs posr">*}
                                   {*<a class="anchor" href="#"><span class="filter-widget-ico"></span> Estoque suficiente</a>*}
                                {*</li>*}
                                {*<li class="filter-widget-items nl filter-widget-warn fw lt bs posr">*}
                                   {*<a class="anchor" href="#"><span class="filter-widget-ico"></span> Iniciar produção</a>*}
                                {*</li>*}
                                {*<li class="filter-widget-items nl filter-widget-lack fw lt bs posr">*}
                                   {*<a class="anchor" href="#"><span class="filter-widget-ico"></span> Falta produto</a>*}
                                {*</li>*}
                            {*</ul>*}
                        {*</div>*}
                    {*</div>*}
                    <a class="anchor filter-widget-lack" href="#" style="cursor:default;">Falta produto</a>
                    <a class="anchor filter-widget-warn" href="#" style="border-style: none; cursor:default;">Iniciar produção</a>
                    <a class="anchor filter-widget-stock" href="#" style="cursor:default;">Estoque suficiente</a>
                </form>
            </div>
            <div class="previsao-produtos-list">
                <ul class="nm np producao-list">
                    {foreach from=$dadosProduto item=produto}
                    <li class="producao-items posr fw lt nl">
                        <div class="producao-produto-lft bs lt">
                            <div class="producao-produto-img-block posr lt">
                                <h4 class="producao-produto-img-title fs13">{$produto['DS_PRODUTO2_PRRC']}</h4>

                                {assign var="fotos" value=$this->fotoproduto($produto['NR_SEQ_PRODUTO_PRRC'])}
                                {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                                {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                                {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}

                                <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>164, 'altura'=>188, 'imagem'=>$foto_completa],"imagem", TRUE)}" class="producao-produto-img">
                                {*<div class="img-options-popover">*}
                                    {*<div class="pop-over type2 lt">*}
                                        {*<div class="content-popover popover-">*}
                                            {*<ul class="nm np  fs13 pop-over-list-1">*}
                                                {*<li class="nl bs posr popover-items popover-items-1">*}
                                                    {*<span class="ico ico-dd-vis"></span>*}
                                                    {*Ver compras*}
                                                {*</li>*}
                                                {*<li class="nl bs posr popover-items popover-items-1">*}
                                                    {*<span class="ico ico-dd-edi"></span>*}
                                                    {*Editar dados*}
                                                {*</li>*}
                                                {*<li class="nl bs posr popover-items-1 popover-delete-1">*}
                                                    {*<span class="ico ico-dd-exc"></span>*}
                                                    {*Excluir*}
                                                {*</li>*}
                                            {*</ul>*}
                                        {*</div>*}
                                    {*</div>*}
                                {*</div>*}
                            </div>
                            {*<div class="producao-img-infos bs lt">*}
                                {*<div class="producao-img-info-top fw lt posr">*}
                                    {*<h5 class="producao-img-info-titles lt fs4 fs10">TEMPO P/ PRODUÇÃO</h5>*}
                                    {*<div class="reverb-select-3 fs10 posr posa producao-img-info-select-1">*}
                                        {*<select name="" id="" class="select">*}
                                            {*<option value="">30 DIAS</option>*}
                                            {*<option value="">31 DIAS</option>*}
                                        {*</select>*}
                                        {*<span class="select-value">*}
                                            {*30 DIAS*}
                                        {*</span>*}
                                    {*</div>*}
                                {*</div>*}
                                {*<div class="producao-img-info-bottom bs fw lt posr">*}
                                    {*<h5 class="producao-img-info-titles lt fs4 fs10">VENDAS POR TAMANHO</h5>*}
                                    {*<div class="reverb-select-3 fs10 posr posa producao-img-info-select-1">*}
                                        {*<select name="" id="" class="select">*}
                                            {*<option value="">12 MESES</option>*}
                                            {*<option value="">13 MESES</option>*}
                                        {*</select>*}
                                        {*<span class="select-value">*}
                                            {*12 MESES*}
                                        {*</span>*}
                                    {*</div>*}
                                {*</div>*}
                                {*<div class="wrap-vertical-tamanhos fw lt">*}
                                    {*<ul class="vertical-tamanhos-list nm np fw lt">*}
                                        {*<li class="vertical-tamanhos-items posr nl">*}
                                            {*<div class="vertical-tamanho-block">*}
                                                {*<span class="vertical-tamanho-labels fs12">PP</span>*}
                                                {*<input type="hidden" value={rand(10,100)}>*}
                                            {*</div>*}
                                        {*</li>*}
                                        {*<li class="vertical-tamanhos-items posr nl">*}
                                            {*<div class="vertical-tamanho-block">*}
                                                {*<span class="vertical-tamanho-labels fs12">P</span>*}
                                                {*<input type="hidden" value={rand(10,100)}>*}
                                            {*</div>*}
                                        {*</li>*}
                                        {*<li class="vertical-tamanhos-items posr nl">*}
                                            {*<div class="vertical-tamanho-block">*}
                                                {*<span class="vertical-tamanho-labels fs12">M</span>*}
                                                {*<input type="hidden" value={rand(10,100)}>*}
                                            {*</div>*}
                                        {*</li>*}
                                        {*<li class="vertical-tamanhos-items posr nl">*}
                                            {*<div class="vertical-tamanho-block">*}
                                                {*<span class="vertical-tamanho-labels fs12">G</span>*}
                                                {*<input type="hidden" value={rand(10,100)}>*}
                                            {*</div>*}
                                        {*</li>*}
                                        {*<li class="vertical-tamanhos-items posr nl">*}
                                            {*<div class="vertical-tamanho-block">*}
                                                {*<span class="vertical-tamanho-labels fs12">GG</span>*}
                                                {*<input type="hidden" value={rand(10,100)}>*}
                                            {*</div>*}
                                        {*</li>*}
                                        {*<li class="vertical-tamanhos-items posr nl">*}
                                            {*<div class="vertical-tamanho-block">*}
                                                {*<span class="vertical-tamanho-labels fs12">XGG</span>*}
                                                {*<input type="hidden" value={rand(10,100)}>*}
                                            {*</div>*}
                                        {*</li>*}
                                    {*</ul>*}
                                {*</div>*}
                            {*</div>*}
                        </div>
                        <div class="producao-details-infos bs posr lt">
                            <table class="producao-tamamhos-tables tmd lt type-1">
                                <thead class="fs9 f4">
                                    <th>&nbsp;</th>
                                    <th>VENDAS</th>
                                    <th>MÉDIA</th>
                                    <th>SALDO</th>
                                </thead>
                                <tbody class="fs11">
                                    {assign var=totalTotal value=0}
                                    {assign var=totalMedia value=0}
                                    {assign var=totalSaldo value=0}
                                    {foreach from=$produto['cesta'] item=cesta}
                                        <tr class="type-1 type-1-rows fs11 size-rows">
                                            <td>{$cesta['DS_TAMANHO_TARC']}</td>
                                            <td>{$cesta['total']}</td>
                                            <td>{$cesta['media_mes']|number_format:3:",":"."}</td>
                                            <td>{$cesta['saldo_atual']}</td>
                                        </tr>
                                        {assign var=totalTotal value=$totalTotal+$cesta['total']}
                                        {assign var=totalMedia value=$totalMedia+$cesta['media_mes']}
                                        {assign var=totalSaldo value=$totalSaldo+$cesta['saldo_atual']}
                                    {/foreach}
                                    <tr class="separate-row">
                                        <td colspan="4" class="separate-cells"></td>
                                    </tr>
                                    <tr class="result-row">
                                        <td>&nbsp;</td>
                                        <td>{$totalTotal}</td>
                                        <td>{$totalMedia|number_format:3:",":"."}</td>
                                        <td>{$totalSaldo}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="producao-tamamhos-tables tmd rt type-2">
                                <thead class="fs9 f4">
                                {foreach from=$produto['cesta'][0]['previsao'] item=previsa key=mes}
                                    <th>MÊS {$mes}</th>
                                {/foreach}
                                </thead>
                                <tbody>
                                    {foreach from=$produto['cesta'] item=cesta}
                                        <tr class="type-2 type-2-rows fs11 tmd type-2-sizes">
                                            {foreach from=$cesta['previsao'] key=key item=previsao}
                                                <td><div class="wrap-type2-cells {$previsao['colorClass']}">{$previsao['qtd']|number_format:3:",":"."}</div></td>
                                            {/foreach}
                                        </tr>
                                    {/foreach}
                                    {*<tr class="type-2 type-2-rows fs11 tmd type-2-sizes">*}
                                        {*<td><div class="wrap-type2-cells gray">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells gray">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells gray">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells gray">{rand(-100, 100)}</div></td>*}
                                    {*</tr>*}
                                    {*<tr class="type-2 type-2-rows fs11 tmd type-2-sizes">*}
                                        {*<td><div class="wrap-type2-cells yellow">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells yellow">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells yellow">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells yellow">{rand(-100, 100)}</div></td>*}
                                    {*</tr>*}
                                    {*<tr class="type-2 type-2-rows fs11 tmd type-2-sizes">*}
                                        {*<td><div class="wrap-type2-cells yellow">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells yellow">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells yellow">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells yellow">{rand(-100, 100)}</div></td>*}
                                    {*</tr>*}
                                    {*<tr class="type-2 type-2-rows fs11 tmd type-2-sizes">*}
                                        {*<td><div class="wrap-type2-cells red">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells red">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells red">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells red">{rand(-100, 100)}</div></td>*}
                                    {*</tr>*}
                                    {*<tr class="type-2 type-2-rows fs11 tmd type-2-sizes">*}
                                        {*<td><div class="wrap-type2-cells yellow">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells yellow">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells yellow">{rand(-100, 100)}</div></td>*}
                                        {*<td><div class="wrap-type2-cells yellow">{rand(-100, 100)}</div></td>*}
                                    {*</tr>*}
                                    <tr class="separate-row">
                                        <td colspan="4" class="separate-cells"></td>
                                    </tr>
                                    <tr class="type-2 type-2-rows fs11 tmd type-2-result">
                                        {foreach from=$produto['saldoPrevisao'] item=saldoPrevisao}
                                            <td><div class="wrap-type2-cells">{$saldoPrevisao|number_format:3:",":"."}</div></td>
                                        {/foreach}
                                        {*<td><div class="wrap-type2-cells">{$totalPrev1|number_format:3:",":"."}</div></td>*}
                                        {*<td><div class="wrap-type2-cells">{$totalPrev2|number_format:3:",":"."}</div></td>*}
                                        {*<td><div class="wrap-type2-cells">{$totalPrev3|number_format:3:",":"."}</div></td>*}
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </li>
                    {/foreach}
                </ul>
            </div>
        </div>
    </div>
</div>
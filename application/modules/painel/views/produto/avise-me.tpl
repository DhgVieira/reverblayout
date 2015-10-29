<div class="modal-wraps" id="sms-compras">

</div>
<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Home &gt; Produtos
        </div>
        <div id="header-section-name">
            Avise-me
        </div>
    </header>
    <div class="lt bs posr container-contents" id="indicacoes-body">
        <div class="container">
            <div class="row above-thead">
                <form action="" method="post">
                    <a href="#" class="head-cells fs13 cells nap bs grn-btn green-btn-4 plus-wh lt">ENVIAR TODOS</a>
                    <a href="#" class="head-cells fs13 cells nap bs grn-btn green-btn-4 plus-wh lt">ENVIAR TODOS(SMS)</a>
                    {*<div class="t-head-options bs fs11 select-2 lt">*}
                        {*<select class="select bs" id="localbanner" name="localbanner">*}
                            {*<option value="" selected disabled>Selecione</option>*}
                            {*<option value="1">Opções em Lote</option>*}
                            {*<option value="2">Opções em Lote2</option>*}
                        {*</select>*}
                        {*<span class="select-value">Opções em Lote</span>*}
                    {*</div>*}
                    {*<button class="head-cells fs13 cells nap bs grn-btn green-btn-1 plus-check" id="apply-items">Aplicar nos items selecionados</button>*}
                    <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                    <input type="text" class="thead-search-field rt bs" name="termo" value="{$busca}">
                </form>
            </div>
            <table class="fw" id="indicacao-table">
                <thead class="table-heads indica-head">
                    <tr>
                        <th class="th-cells head-chck"></th>
                        <th class="th-cells head-thumb">IMAGEM</th>
                        <th class="th-cells head-desc">DESCRIÇÃO</th>
                        <th class="th-cells head-esto">ESTOQUE</th>
                        <th class="th-cells head-tipo">TIPO</th>
                        <th class="th-cells head-valor">VALOR</th>
                        <th class="th-cells head-tamanho">TAMANHO</th>
                        <th class="th-cells head-count">Pessoas</th>
                    </tr>
                </thead>
                <tbody class="table-body indica-body">
                    {foreach from=$dadosProdutos key=i item=produto}
                        {assign var="fotos" value=$this->fotoproduto($produto['NR_SEQ_PRODUTO_PRRC'])}
                        {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                        {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                        {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}

                        <tr class="avise-produto-row">
                            <td class="tb-cells posr body-chck">
                                {*<div class="wrap-checkbox wrap-reverb-checkbox-2">*}
                                    {*<input class="checkbox" type="checkbox" id="checkbox-{$i}" checked>*}
                                    {*<label class="styled-reverb-checkbox" for="checkbox-{$i}"></label>*}
                                {*</div>*}
                            </td>
                            <td class="tb-cells body-thumb"> <img class="tb-img" src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>29, 'altura'=>33, 'imagem'=>$foto_completa],"imagem", TRUE)}"> </td>
                            <td class="tb-cells body-desc"><strong>{$produto['DS_PRODUTO2_PRRC']}</strong></td>
                            <td class="tb-cells body-esto">{$produto['NR_QTDE_ESRC']}</td>
                            <td class="tb-cells body-tipo">{$produto['DS_CATEGORIA_PTRC']}</td>
                            <td class="tb-cells body-valor">R$ {$produto['VL_PRODUTO_PRRC']|string_format:"%.2f"}</td>
                            <td class="tb-cells body-tamanho">{$produto['DS_TAMANHO_TARC']}</td>
                            <td class="tb-cells posr body-count">
                                {$produto['qtd']}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8">
                                <div class="posr fw lt produto-wrap-seguidores">
                                    <table class="fw lt nm np">
                                        <tbody>
                                            {foreach from=$produto['clientes'] item=cliente}
                                                <tr class="avise-produto green">
                                                    <td class="tb-cells posr body-chck">
                                                        <div class="wrap-checkbox wrap-reverb-checkbox-2">
                                                            <input class="checkbox" type="checkbox" id="checkbox-{$i}" checked>
                                                            <label class="styled-reverb-checkbox" for="checkbox-{$i}"></label>
                                                        </div>
                                                    </td>
                                                    <td class="tb-cells body-name">{$cliente['DS_NOME_AVRC']}</td>
                                                    <td class="tb-cells body-cida">{$cliente['DS_CIDADE_AVRC']} - {$cliente['DS_UF_AVRC']}</td>
                                                    <td class="tb-cells body-esto">Em: {$cliente['DT_SOLICITACAO_AVRC']|date_format:'%d/%m/%Y'}</td>
                                                    <td class="tb-cells body-tipo">{$cliente['DS_EMAIL_AVRC']}</td>
                                                    <td class="tb-cells body-valor">{$cliente['DS_TELEFONE_AVRC']}</td>
                                                    <td class="blank-cell md-blank-cell">&nbsp;</td>
                                                    <td class="tb-cells posr body-action has-pop-over">
                                                        <ul class="indica-actions-3 bs">
                                                            {*<li class="indica-items">*}
                                                                {*<a class="indica-icos indica-bubble2" href="#"></a>*}
                                                            {*</li>*}
                                                            <li class="indica-items">
                                                                <a class="indica-icos indica-sms2 enviar-sms" data-celular="{$cliente['DS_TELEFONE_AVRC']}" data-nome="{$cliente['DS_NOME_AVRC']}" data-nomeproduto="{$produto['DS_PRODUTO2_PRRC']}" href="#"></a>
                                                            </li>
                                                            {*<li class="indica-items">*}
                                                                {*<a class="indica-icos indica-email2" href="#"></a>*}
                                                            {*</li>*}
                                                        </ul>
                                                    </td>
                                                </tr>
                                            {/foreach}
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </div>
        </div>
    </div>
</div>
{literal}
<script>
    $(document).ready(function(){
        $('.enviar-sms').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'GET',
                url: document.basePath + '/painel/produto/enviar-sms',
                data: { nome: $(this).data('nome'), celular: $(this).data('celular'), nomeproduto: $(this).data('nomeproduto')}
            }).done(function(response) {
                $('#sms-compras').html(response);
                $('#sms-compras').show();

                $('.close-parent, .cancel-button').off().on('click', function(e) {
                    e.preventDefault();
                    $('#sms-compras').hide();
                })
            });
        });
    });
</script>
{/literal}
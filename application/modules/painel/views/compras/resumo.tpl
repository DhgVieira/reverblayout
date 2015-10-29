<div class="modal-wraps-body" id="resumo-pedidos-body">
    <h3 class="fs22 resumo-pedidos-title">Resumo do pedido</h3>
    <ul class="posa header-helpers compras-modal-actions">
        {*<li class="resumo-modal-action-items nl lt">*}
            {*<a class="header-helpers-actions new-action" href="#"></a>*}
        {*</li>*}
        {*<li class="resumo-modal-action-items nl lt">*}
            {*<a class="header-helpers-actions email-action" href="#"></a>*}
        {*</li>*}
        {*<li class="resumo-modal-action-items nl lt">*}
            {*<a class="header-helpers-actions print-action" href="#"></a>*}
        {*</li>*}
        <li class="resumo-modal-action-items nl lt">
            <a class="header-helpers-actions close-parent" href="#"></a>
        </li>
    </ul>
    <div class="resumo-pedidos-content bs posr fw lt">
        <div class="resumo-pedidos-top-blocks bs posr fw lt">
            <a href="#" class="resumo-pedidos-top-btns segundo-boleto">2º via boleto</a>
            <a href="#" class="resumo-pedidos-top-btns gerar-boleto">Gerar boleto</a>
        </div>
        <div class="resumo-pedidos-top-infos bs posr fw lt">
            <strong>Compra No {$dadosCompra->NR_SEQ_COMPRA_COSO} feita em {$dadosCompra->DT_COMPRA_COSO|date_format:"%d/%m/%Y"} ás {$dadosCompra->DT_COMPRA_COSO|date_format:"%H:%m"}</strong>
        </div>
        <div class="modal-compras-tables posr fw lt">
            <table class="fw lt posr compras-tables">
                <thead class="modal-compras-thead">
                <tr class="tmd fs13">
                    <th class="compras-th th-img">IMAGEM</th>
                    <th class="compras-th th-nome">PRODUTO</th>
                    <th class="compras-th th-ref">REF</th>
                    <th class="compras-th th-siz">SIZE</th>
                    <th class="compras-th th-val">VALOR</th>
                    <th class="compras-th th-qtd">QTD.</th>
                </tr>
                </thead>
                <tbody class="compras-tbody">
                {foreach from=$dadosCesta item=cesta}
                    {assign var=qtdTotal value=$qtdTotal + $cesta->NR_QTDE_CESO}
                    {if $cesta->VL_COM_DESCONTO}
                        {assign var=subTotal value=$subTotal + $cesta->VL_COM_DESCONTO}
                    {else}
                        {assign var=subTotal value=$subTotal + $cesta->VL_PRODUTO_CESO}
                    {/if}

                    {assign var="fotos" value=$this->fotoproduto($cesta->NR_SEQ_PRODUTO_PRRC)}
                    {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                    {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                    {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}

                    <tr class="tmd fs13">
                        <td class="compras-td td-img"><img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>55, 'altura'=>62, 'imagem'=>$foto_completa],"imagem", TRUE)}"></td>
                        <td class="compras-td td-nome">{$cesta->DS_PRODUTO2_PRRC}</td>
                        <td class="compras-td td-ref">{$cesta->DS_REFERENCIA_PRRC}</td>
                        <td class="compras-td td-siz">{$cesta->DS_TAMANHO_TARC}</td>
                        <td class="compras-td td-pag">R$ {if $cesta->VL_COM_DESCONTO}{$cesta->VL_COM_DESCONTO|number_format:2:",":"."}{else}{$cesta->VL_PRODUTO_CESO|number_format:2:",":"."}{/if}</td>
                        <td class="compras-td td-qtd">{$cesta->NR_QTDE_CESO}</td>
                    </tr>
                {/foreach}
                </tbody>
                <tfoot class="">
                <tr class="compras-tfoots-rows tmd">
                    <td class="compras-tf" colspan="3">&nbsp;</td>
                    <td class="compras-tf">SUBTOTAL</td>
                    <td class="compras-tf">R$ {$subTotal|number_format:2:",":"."}</td>
                    <td class="compras-tf">{$qtdTotal}</td>
                </tr>
                <tr class="compras-tfoot-tools tmd">
                    {*<td colspan="4">*}
                        {*<div class="posr fw lt fretes-boxes">*}
                            {*<div class="lt fretes-pairs">*}
                                {*<label class="frete-pairs-blocks" for="input-frete">Frete Real</label>*}
                                {*<input class="frete-pairs-blocks compras-tiny-input" type="frete" id="input-frete" name="frete">*}
                            {*</div>*}
                            {*<div class="lt fretes-pairs">*}
                                {*<button class="lt frete-pairs-blocks compras-tiny-buttons">Lançar</button>*}
                                {*<div class="lt frete-pairs-blocks forma-envio">ENVIO: <strong>PACK</strong></div>*}
                            {*</div>*}
                        {*</div>*}
                    {*</td>*}
                    <td class="fs13" colspan="4" align="right">
                        FRETE
                    </td>
                    <td class="fs13" align="center">
                        <input class="compras-tiny-input" type="frete" id="input-frete" name="frete" value="{$dadosCompra->VL_FRETE_COSO|number_format:2:",":"."}">
                    </td>
                    <td>
                        <button class="compras-tiny-buttons" id="edit-compras-envio">Alterar</button>
                    </td>
                </tr>
                <tr class="tmd compras-total-tfoots-rows">
                    <td class="compras-tf compras-subtotal-tf" colspan="4">&nbsp;</td>
                    <td class="compras-tf compras-subtotal-tf"><strong>TOTAL</strong></td>
                    <td class="compras-tf compras-subtotal-tf"><strong>R$ {$dadosCompra->VL_TOTAL_COSO|number_format:2:",":"."}</strong></td>
                </tr>
                </tfoot>
            </table>
            <ul class="compras-infos-lists nm np posr fw lt">
                <li class="compras-infos-items nl bs posr">
                    <div class="lt">IP da Compra</div>
                    <div class="rt"><strong>{$dadosCompra->DS_IP_COSO}</strong></div>
                </li>
                <li class="compras-infos-items nl bs posr">
                    <div class="fw rt posr">
                        <div class="compras-balls-2">
                            <span class="compras-ball bs fs12">{$dadosCompra->ST_COMPRA_COSO}</span>
                        </div>
                    </div>
                </li>
                <li class="compras-infos-items nl bs posr">
                    <div class="lt">Forma de Pagamento</div>
                    <div class="rt">
                        {if $dadosCompra->DS_FORMAPGTO_COSO == 'master'}
                            <img class="vmiddle" src="{$basePath}/arquivos/painel/images/master.png" alt="">
                        {elseif $dadosCompra->DS_FORMAPGTO_COSO == 'visa'}
                            <img class="vmiddle" src="{$basePath}/arquivos/painel/images/visa.png" alt="">
                        {elseif $dadosCompra->DS_FORMAPGTO_COSO == 'amex'}
                            <img class="vmiddle" src="{$basePath}/arquivos/painel/images/american-express.png" alt="">
                        {elseif $dadosCompra->DS_FORMAPGTO_COSO == 'boleto'}
                            <img class="vmiddle" src="{$basePath}/arquivos/painel/images/boleto.png" alt="">
                        {/if}
                    </div>
                </li>
                <li class="compras-infos-items nl bs posr">
                    <div class="lt">Mudança de Status</div>
                    <div class="rt"><strong>{$dadosCompra->DT_STATUS_COSO|date_format:"%d/%m/%Y"}</strong></div>
                </li>
                <li class="compras-infos-items nl bs posr">
                    <div class="lt">Parcelas</div>
                    <div class="rt"><strong>{$dadosCompra->NR_PARCELAS_COSO}</strong></div>
                </li>
                <li class="compras-infos-items nl bs posr">
                    <div class="lt">
                        <label class="lt" for="rastreamento">Rastreamento</label>
                        <input class="lt bs compras-infos-items-inputs rastreamento" id="rastreamento" type="text" value="{$dadosCompra->DS_RASTREAMENTO_COSO}">
                        <button class="compras-infos-items-button" id="rastreamento-btn">ALTERAR</button>
                    </div>
                </li>
                <li class="compras-infos-items nl bs posr">
                    <div class="lt">
                        <label for="tid">TID</label>
                    </div>
                    <div class="rt"><strong>{$dadosCompra->DS_TID_COSO}</strong></div>
                </li>
                <li class="compras-infos-items nl bs posr">
                    <div class="lt">
                        <label for="etq">Etiqueta Posição</label>
                    </div>
                    <div class="rt">
                        <input class="bs compras-infos-items-inputs etq" id="etq" type="text">
                        <button id="etq-btn" class="compras-infos-items-button">GERAR</button>
                    </div>
                </li>
            </ul>
        </div>
        <div class="modal-compras-addrs-infos posr fw lt">
            <div class="addr-infos-titles posr bs">
                ENDEREÇO E DADOS DO COMPRADOR
                <a href="{$this->url(['module' => 'painel', 'controller' => 'cliente', 'action' => 'form', 'id' => $dadosCompra->NR_SEQ_CADASTRO_CASO], null, true)}" target="_blank" class="modal-addr-edit rt">EDITAR</a>
            </div>
            <div class="addr-infos-details fw lt bs">
                <div class="addr-infos-details-items">Nome: {$dadosCompra->DS_NOME_CASO}</div>
                <div class="addr-infos-details-items">Nascimento: {$dadosCompra->DT_NASCIMENTO_CASO|date_format:"%d/%m/%Y"}</div>
                <div class="addr-infos-details-items">Endereço: {$dadosCompra->DS_ENDERECO_CASO}, {$dadosCompra->DS_NUMERO_CASO} - {$dadosCompra->DS_COMPLEMENTO_CASO}</div>
                <div class="addr-infos-details-items">Documento: {$dadosCompra->DS_CPFCNPJ_CASO}</div>
                <div class="addr-infos-details-items">Londrina/PR, Brasil</div>
                <div class="addr-infos-details-items">E-mail: {$dadosCompra->DS_EMAIL_CASO}</div>
                <div class="addr-infos-details-items">CEP 86010520 - Centro</div>
                <div class="addr-infos-details-items">Fone: ({$dadosCompra->DS_DDDFONE_CASO}) {$dadosCompra->DS_FONE_CASO}</div>
            </div>
        </div>
        <div class="modal-compras-last-shoppings">
            <div class="posr fw lt bs last-shopping-titles">
                ÚLTIMOS PEDIDOS DO CLIENTE
            </div>
            <div class="posr fw lt bs last-shopping-tables">
                <table class="posr fw lt fs12 last-shopping-table">
                    <thead>
                    <tr class="last-shopping-th-tr">
                        <th class="last-shopping-th">NUMERO</th>
                        <th class="last-shopping-th">DATA</th>
                        <th class="last-shopping-th">QTDE.</th>
                        <th class="last-shopping-th">PAGAMENTO</th>
                        <th class="last-shopping-th">TOTAL</th>
                        <th class="last-shopping-th">STATUS</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$dadosUltimasCompras item=compra}
                        <tr class="last-shopping-trs">
                            <td class="last-shopping-tds">
                                <div class="wrap-last-shopping">
                                    {$compra->NR_SEQ_COMPRA_COSO}
                                </div>
                            </td>
                            <td class="last-shopping-tds">
                                <div class="wrap-last-shopping">
                                    {$compra->DT_COMPRA_COSO|date_format:"%d/%m/%Y %H:%m"}
                                </div>
                            </td>
                            <td class="last-shopping-tds">
                                <div class="wrap-last-shopping">
                                    {$compra->total_item}
                                </div>
                            </td>
                            <td class="last-shopping-tds">
                                <div class="wrap-last-shopping">
                                    {if $dadosCompra->DS_FORMAPGTO_COSO == 'master'}
                                        <img class="vmiddle" src="{$basePath}/arquivos/painel/images/master.png" alt="">
                                    {elseif $dadosCompra->DS_FORMAPGTO_COSO == 'visa'}
                                        <img class="vmiddle" src="{$basePath}/arquivos/painel/images/visa.png" alt="">
                                    {elseif $dadosCompra->DS_FORMAPGTO_COSO == 'amex'}
                                        <img class="vmiddle" src="{$basePath}/arquivos/painel/images/american-express.png" alt="">
                                    {elseif $dadosCompra->DS_FORMAPGTO_COSO == 'boleto'}
                                        <img class="vmiddle" src="{$basePath}/arquivos/painel/images/boleto.png" alt="">
                                    {/if}
                                </div>
                            </td>
                            <td class="last-shopping-tds">
                                <div class="wrap-last-shopping">
                                    R$ {$compra->VL_TOTAL_COSO|number_format:2:",":"."}
                                </div>
                            </td>
                            <td class="last-shopping-tds">
                                <div class="wrap-last-shopping">
                                    <div class="compras-balls-2">
                                        <span class="compras-ball bs fs12">{$compra->ST_COMPRA_COSO}</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="resumo-pedidos-bottom bs posr">
        <hr class="resumo-pedidos-hr lt">
        <div class="lt">
            <a href="#" class="rt cancel-button type-2 reverb-btns-1"> Sair! Cancelar <span class="ico"></span> </a>
        </div>
        <div class="rt">
            <label for="new-topic-step-2" class="fs13 cells nap bs grn-btn green-btn-1 min plus-check"> OK, Salvar! </label>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#edit-compras-envio').on('click', function(e){
        e.preventDefault();
        var valFrete = $('#input-frete').val();
        $('#input-frete').val('...');
        $.ajax({
            type: 'POST',
            url: document.basePath + '/painel/compras/valor-frete',
            data: { id: {$dadosCompra->NR_SEQ_COMPRA_COSO}, valor: valFrete}
        })
        .done(function(response) {
            $('#input-frete').val(response);
        });
    });

    $('#rastreamento-btn').on('click', function(e){
        e.preventDefault();
        var codigo = $('#rastreamento').val();
        $('#rastreamento').val('...');
        $.ajax({
            type: 'POST',
            url: document.basePath + '/painel/compras/codigo-rastreamento',
            data: { id: {$dadosCompra->NR_SEQ_COMPRA_COSO}, codigo: codigo}
        })
        .done(function(response) {
            $('#rastreamento').val(response);
        });
    });

    $('.gerar-boleto').on('click', function(e){
        e.preventDefault();
        $(this).text('Aguarde...');
        $.ajax({
            type: 'POST',
            url: document.basePath + '/painel/compras/gerar-boleto',
            data: { id: {$dadosCompra->NR_SEQ_COMPRA_COSO}}
        })
        .done(function(url) {
            $('.gerar-boleto').text('Ver boleto');
            $('.gerar-boleto').attr('href', url);
            $('.gerar-boleto').attr('target', '_blank');
            $('.gerar-boleto').off();
            $('.gerar-boleto').removeClass('gerar-boleto');
        });
    });

    $('.segundo-boleto').on('click', function(e){
        e.preventDefault();
        $(this).text('Aguarde...');
        $.ajax({
            type: 'POST',
            url: document.basePath + '/painel/compras/segunda-via-boleto',
            data: { id: {$dadosCompra->NR_SEQ_COMPRA_COSO}}
        })
        .done(function(url) {
            $('.segundo-boleto').text('Ver boleto');
            $('.segundo-boleto').attr('href', url);
            $('.segundo-boleto').attr('target', '_blank');
            $('.segundo-boleto').off();
            $('.segundo-boleto').removeClass('segundo-boleto');
        });
    });
</script>
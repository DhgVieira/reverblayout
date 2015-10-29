<div class="modal-wraps" id="resumo-pedidos">

</div>
<div class="modal-wraps" id="sms-compras">

</div>
<div class="modal-wraps" id="nfe-block">
    <div class="modal-wraps-body bs" id="nfe-modal">
        <h3 class="fs22 resumo-pedidos-title fw lt" id="nfe-modal-title">NFE</h3>
        <ul class="posa header-helpers compras-modal-actions">
            <li class="resumo-modal-action-items nl lt">
                <a class="header-helpers-actions close-parent" href="#"></a>
            </li>
        </ul>
        <div class="posr bs nfe-modal-body">
            <label class="fs13 nfe-labels" for="nfe-modal-input">Selecione a pasta que deseja salvar a NFE</label>
            <div class="reverb-input-1 select-1">
                <select class="select bs" id="categoria" name="NR_SEQ_CATEGORIA_BLRC"></select>
                <span class="select-value">Selecione</span>
            </div>
            <hr class="nfe-modal-hr lt">
            <div class="lt">
                <a href="#" class="rt cancel-button type-2 tmd reverb-btns-1"> Não! Cancelar <span class="ico"></span> </a>
            </div>
            <div class="rt">
                <label for="new-topic-step-2" class="fs13 cells tmd nap bs grn-btn green-btn-1 min plus-check"> Sim, Salvar! </label>
            </div>
        </div>
    </div>
</div>
<div class="modal-wraps" id="filtros-block">
    <div class="modal-wraps-body bs" id="compras-filtros-modal">
        <h3 class="fs22 resumo-pedidos-title fw lt" id="filtro-modal-title">Filtro</h3>
        <ul class="posa header-helpers compras-modal-actions">
            <li class="resumo-modal-action-items nl lt">
                <a class="header-helpers-actions close-parent" href="#"></a>
            </li>
        </ul>
        <div class="posr bs filtro-modal-body">
            <label class="fs13 nfe-labels" for="nfe-modal-input">Escolha uma ou mais opções para filtrar a lista de compras</label>
            <div class="posr fw lt">
                <div class="posr fw lt">
                    <div class="nfe-modal-elements nfe-modal-elements-1">
                        <div class="nfe-modal-element-wrap">
                            <input type="text" class="bs nfe-modal-input-elements" name="nome_filtro">
                        </div>
                    </div>
                    <div class="nfe-modal-elements nfe-modal-elements-1">
                        <div class="nfe-modal-element-wrap">
                            <input type="email" class="bs nfe-modal-input-elements" name="email_filtro">
                        </div>
                    </div>
                </div>
                <div class="posr fw lt">
                    <div class="nfe-modal-elements nfe-modal-elements-1">
                        <div class="nfe-modal-element-wrap">
                            <input type="text" class="bs nfe-modal-input-elements" name="cpf_filtro">
                        </div>
                    </div>
                    <div class="nfe-modal-elements nfe-modal-elements-1">
                        <div class="nfe-modal-element-wrap">
                            <div class="reverb-input-1 select-1">
                                <select class="select bs" id="categoria" name="filtro_compras_aberto"></select>
                                <span class="select-value">Compras em Aberto</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="posr fw lt">
                    <div class="nfe-modal-elements nfe-modal-elements-2">
                        <div class="reverb-input-1 select-1">
                            <select class="select bs" id="uf" name="filtro_compras_uf"></select>
                            <span class="select-value">Selecione</span>
                        </div>
                    </div>
                    <div class="nfe-modal-elements nfe-modal-elements-3">
                        <div class="reverb-input-1 select-1">
                            <select class="select bs" id="cidade" name="filtro_compras_cidade"></select>
                            <span class="select-value">Selecione</span>
                        </div>
                    </div>
                    <div class="nfe-modal-elements nfe-modal-elements-4">
                        <div class="nfe-modal-element-wrap">
                            <input type="text" class="bs nfe-modal-input-elements" name="filtro_n_pedido" placeholder="Nº Pedido">
                        </div>
                    </div>
                </div>
                <hr class="filtros-modal-hr fw lt">
                <div class="lt">
                    <a href="#" class="rt cancel-button type-2 tmd reverb-btns-1"> Não! Cancelar <span class="ico"></span> </a>
                </div>
                <div class="rt">
                    <label for="new-topic-step-2" class="fs13 cells tmd nap bs grn-btn green-btn-1 min plus-check"> Sim, Filtrar! </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12" id="dash-crumb">
            Site > Compras
        </div>
        <div id="header-section-name">
            Compras Canceladas
        </div>
    </header>
    <div class="lt bs posr container-contents" id="indicacoes-body">
        <div class="container">
            <div class="row above-thead">
                {*<div class="t-head-options bs fs11 select-2">*}
                    {*<select class="select bs" id="loteoptions" name="loteoptions">*}
                        {*<option value="" selected disabled>Selecione</option>*}
                        {*<option value="1">Opção 1</option>*}
                        {*<option value="1">Opção 2</option>*}
                    {*</select>*}
                    {*<span class="select-value">Opção </span>*}
                {*</div>*}
                {*<button class="head-cells fs13 cells nap bs grn-btn plus-check green-btn-auto posr">Aplicar</button>*}
                {*<div class="tiny-block lt first">*}
                    {*<label class="tiny-head-labels lt" for="nfe">Gerar NFE:</label>*}
                    {*<input class="tiny-head-inputs lt" type="text" id="nfe" name="nfe" placeholder="999">*}
                    {*<button class="tiny-block-submit lt">GERAR!</button>*}
                {*</div>*}
                {*<div class="tiny-block lt last">*}
                    {*<label class="tiny-head-labels lt" for="nfe">Gerar NFE:</label>*}
                    {*<input class="tiny-head-inputs lt" type="text" id="nfe" name="nfe" placeholder="999">*}
                    {*<button class="tiny-block-submit lt">GERAR!</button>*}
                {*</div>*}
                {*<button class="gray-btn-1 gray-btn lt">*}
                    {*Filtros*}
                    {*<span class="ico-contextual"></span>*}
                {*</button>*}
                <form action="{$this->url(['module' => 'painel', 'controller' => 'compras', 'action' => 'busca'], null, true)}" method="post">
                    <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                    <input type="text" class="thead-search-field min rt bs">
                </form>
            </div>
            <table class="fw financeiro-tables" id="indicacao-table">
                <thead class="table-heads indica-head">
                    <tr>
                        <th class="th-cells head-chck"></th>
                        <th class="th-cells head-numb">Nº</th>
                        <th class="th-cells head-date">DATA COMPRA</th>
                        <th class="th-cells head-name">NOME</th>
                        <th class="th-cells head-pgto">PAGAMENTO</th>
                        <th class="th-cells head-vals">VALOR TOTAL</th>
                        <th class="th-cells head-stat">STATUS</th>
                        <th class="th-cells th-options th-big-options-2">OPÇÕES</th>
                    </tr>
                </thead>

                <tbody class="tables-body banners-body financeiro-tbody">
                    {foreach from=$dadosCompras key=i item=compra}
                        <tr class="green">
                            <td class="tb-cells posr body-chck">
                                <div class="wrap-checkbox wrap-reverb-checkbox-2">
                                    <input class="checkbox" type="checkbox" id="checkbox-{$i}" value="{$compra->NR_SEQ_COMPRA_COSO}">
                                    <label class="styled-reverb-checkbox" for="checkbox-{$i}"></label>
                                </div>
                            </td>
                            <td class="tb-cells posr body-numb"> <div>{$compra->NR_SEQ_COMPRA_COSO}</div> </td>
                            <td class="tb-cells posr body-date"> <div>{$compra->DT_COMPRA_COSO|date_format:"%d/%m/%Y %H:%M"}</div> </td>
                            <td class="tb-cells posr body-name"> <div>{$compra->DS_NOME_CASO}</div> </td>
                            <td class="tb-cells posr body-pgto">
                                <div>
                                    {if $compra->DS_FORMAPGTO_COSO == 'boleto'}
                                        <img src="{$basePath}/arquivos/painel/images/boleto.png" alt="">
                                    {elseif $compra->DS_FORMAPGTO_COSO == 'visa'}
                                        <img src="{$basePath}/arquivos/painel/images/visa.png" alt="">
                                    {elseif $compra->DS_FORMAPGTO_COSO == 'mastercard'}
                                        <img src="{$basePath}/arquivos/painel/images/master.png" alt="">
                                    {/if}
                                </div>
                            </td>
                            <td class="tb-cells posr body-vals"><div>R$ {$compra->VL_TOTAL_COSO|number_format:2:",":"."}</div></td>
                            <td class="tb-cells posr body-stat">
                                <div class="compras-balls">
                                    <span class="compras-ball bs fs12">{$compra->ST_COMPRA_COSO}</span>
                                </div>
                            </td>
                            <td class="tb-cells posr posr body-action has-pop-over last-col tb-big-options-2">
                                <ul class="indica-actions-6 lt =bs" style="width: 200px;">
                                    <li class="indica-items-2">
                                        <a class="indica-icos compras-print" href="#" atitle="Imprimir" onclick="printpage('{$this->url(['module' => 'painel', 'controller' => 'compras', 'action' => 'print', 'id' => $compra->NR_SEQ_COMPRA_COSO], null, true)}')"></a>
                                    </li>
                                    <li class="indica-items-2">
                                        <a class="indica-icos compras-eyes btn-resumo-pedido" href="#resumo-pedidos" atitle="Visualizar" data-idpedido="{$compra->NR_SEQ_COMPRA_COSO}"></a>
                                    </li>
                                    <li class="indica-items-2">
                                        <a class="indica-icos compras-edit" href="{$this->url(['module' => 'painel', 'controller' => 'cliente', 'action' => 'form', 'id' => $compra->NR_SEQ_CADASTRO_CASO], null, true)}" atitle="Editar Cliente"></a>
                                    </li>
                                    {if !empty($compra->DS_DDDCEL_CASO) and !empty($compra->DS_CELULAR_CASO)}
                                        <li class="indica-items-2">
                                            <a href="#" atitle="Enviar SMS" class="ico dd-compras-cell" data-idpedido="{$compra->NR_SEQ_COMPRA_COSO}" style="background-position: 0px -413px;"></a>
                                        </li>
                                    {/if}
                                </ul>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
            <div class="footer-bar">
                {$this->paginationControl($dadosCompras, NULL, 'paginator.tpl')}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function printpage(url)
    {
        child = window.open(url, 'Print', 'left=400, top=200, width=1, height=1, toolbar=0, resizable=0');  //Open the child in a tiny window.
        window.focus();  //Hide the child as soon as it is opened.
        child.addEventListener('load', function(){
            child.print();
            child.close();
        }, true);
    }

    $(document).ready(function(){
        $('.cancelar-compra').on('click', function() {
            if(confirm('Deseja realmenta cancelar o pedido ' + $(this).data('idpedido') + ' ?')){
                return true;
            }else{
                return false;
            }
        });

        $('.confirmar-compra').on('click', function() {
            if(confirm('Deseja realmenta confirmar o pedido ' + $(this).data('idpedido') + ' ?')){
                return true;
            }else{
                return false;
            }
        });

        $('.dd-compras-cell').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'GET',
                url: document.basePath + '/painel/compras/enviar-sms',
                data: { id: $(this).data('idpedido')}
            })
                    .done(function(response) {
                        $('#sms-compras').html(response);
                        $('#sms-compras').show();

                        $('.close-parent, .cancel-button').off().on('click', function(e) {
                            e.preventDefault();
                            $('#sms-compras').hide();
                        })
                    });
        });

        $('.btn-resumo-pedido').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: document.basePath + '/painel/compras/resumo',
                data: { id: $(this).data('idpedido')}
            })
                    .done(function(response) {
                        $('#resumo-pedidos').html(response);
                        $('#resumo-pedidos').show();

                        $('.close-parent, .cancel-button').off().on('click', function(e) {
                            e.preventDefault();
                            console.log('close');
                            $('#resumo-pedidos').hide();
                        })
                    });
        });

        $('.checkbox').on('change', function() {
            $(".form-etiqueta input[type='hidden']").remove();
            $(".form-nfe input[type='hidden']").remove();

            $(".checkbox:checked").each(function() {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'compras[]',
                    value: $(this).val()}).appendTo('.form-etiqueta');

                $('<input>').attr({
                    type: 'hidden',
                    name: 'compras[]',
                    value: $(this).val()}).appendTo('.form-nfe');
            });
        });
    });
</script>
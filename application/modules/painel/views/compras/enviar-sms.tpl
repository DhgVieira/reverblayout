<div class="modal-wraps-body bs" id="nfe-modal">
    <h3 class="fs22 resumo-pedidos-title fw lt" id="nfe-modal-title">Enviar SMS</h3>
    <ul class="posa header-helpers compras-modal-actions">
        <li class="resumo-modal-action-items nl lt">
            <a class="header-helpers-actions close-parent" href="#"></a>
        </li>
    </ul>
    <div class="posr bs nfe-modal-body">
        <label class="fs13 nfe-labels" for="nfe-modal-input">Enviar SMS para {$dadosCompra->DS_NOME_CASO} - ({$dadosCompra->DS_DDDCEL_CASO|replace:")":""|replace:"(":""}) {$dadosCompra->DS_CELULAR_CASO}</label>
        <form method="post" action="{$basePath}/painel/compras/enviar-sms" id="form-sms">
            <input type="hidden" name="celular" value="{$dadosCompra->DS_DDDCEL_CASO|replace:")":""|replace:"(":""}{$dadosCompra->DS_CELULAR_CASO|replace:"-":""|replace:"_":""|replace:" ":""}">
            <div class="reverb-input-1">
                <textarea cols="70" rows="5" name="mensagem"></textarea>
            </div>
        </form>

        <hr class="nfe-modal-hr lt">
        <div class="lt">
            <a href="#" class="rt cancel-button type-2 tmd reverb-btns-1"> Não! Cancelar <span class="ico"></span> </a>
        </div>
        <div class="rt submit-sms">
            <label for="new-topic-step-2" class="fs13 cells tmd nap bs grn-btn green-btn-1 min plus-check"> Sim, Enviar! </label>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.submit-sms').on('click', function(){
        $('#form-sms').submit();
    });
</script>
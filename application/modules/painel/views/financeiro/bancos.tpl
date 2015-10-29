<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Financeiro
        </div>
        <div id="header-section-name">
            Lista Bancos
        </div>
    </header>
    <div class="lt bs posr container-contents" id="indicacoes-body">
        <div class="container">
            <div class="row above-thead">
                <a class="head-cells fs13 cells nap bs grn-btn plus-check green-btn-auto posr" href="{$this->url(['module' => 'painel', 'controller' => 'financeiro', 'action' => 'novo-banco'], null, true)}">Adicionar novo banco</a>
                <form action="" method="post">
                    <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                    <input type="text" class="thead-search-field rt bs" name="busca" value="{$busca}">
                </form>
            </div>
            <table class="fw" id="indicacao-table">
                <thead class="table-heads indica-head">
                <tr>
                    {*<th class="th-cells head-chck"></th>*}
                    <th class="th-cells head-name">NOME</th>
                    <th class="th-cells head-action last-col">OPÇÕES</th>
                </tr>
                </thead>
                <tbody class="table-body indica-body">
                {foreach from=$dadosBanco item=banco}
                    <tr>
                        {*<td class="tb-cells posr body-chck">*}
                        {*<div class="wrap-checkbox wrap-reverb-checkbox-2">*}
                        {*<input class="checkbox" type="checkbox" id="checkbox-{$cliente->NR_SEQ_CADASTRO_CASO}">*}
                        {*<label class="styled-reverb-checkbox" for="checkbox-{$cliente->NR_SEQ_CADASTRO_CASO}"></label>*}
                        {*</div>*}
                        {*</td>*}
                        <td class="tb-cells body-name">{$banco->DS_BANCO_BARC}</td>
                        <td class="tb-cells posr body-action has-pop-over last-col" align="center">
                            <div class="pop-over">
                                <span class="open-pop-over">Opções</span>
                                <div class="content-popover popover-4">
                                    <ul class="nm np  fs13 pop-over-list-1">
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-edi"></span>
                                            <a href="{$this->url(['module' => 'painel', 'controller' => 'financeiro', 'action' => 'editar-banco', 'id' => $banco->NR_SEQ_BANCO_BARC], null, true)}">Editar dados</a>
                                        </li>
                                        <li class="nl bs posr popover-items-1 popover-delete-1">
                                            <span class="ico ico-dd-exc"></span>
                                            <a href="{$this->url(['module' => 'painel', 'controller' => 'financeiro', 'action' => 'remover-banco', 'id' => $banco->NR_SEQ_BANCO_BARC], null, true)}">Excluir</a>
                                        </li>
                                    </ul>
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
<script type="text/javascript">
    $(document).ready(function(){
        $('.popover-delete-1').on('click', function(e) {
            if(confirm('Deseja realmente excluir o banco?')){
                return true;
            }else{
                return false;
            }
        })
    });
</script>
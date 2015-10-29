<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Colaboradores
        </div>
        <div id="header-section-name">
            Lista Colaboradores
        </div>
    </header>
    <div class="lt bs posr container-contents" id="indicacoes-body">
        <div class="container">
            <div class="row above-thead">
                <form action="" method="post">
                    <input type="text" class="thead-search-field lt bs" name="termo" value="{$busca}">
                    <input type="submit" class="lt grn-btn thead-search-button bs" value="Buscar">
                </form>
            </div>
            <table class="fw" id="indicacao-table">
                <thead class="table-heads indica-head">
                <tr>
                    {*<th class="th-cells head-chck"></th>*}
                    <th class="th-cells head-name">LOGIN</th>
                    <th class="th-cells head-email">E-MAIL</th>
                    <th class="th-cells head-action last-col">OPÇÕES</th>
                </tr>
                </thead>
                <tbody class="table-body indica-body">
                {foreach from=$dadosUsuarios item=usuario}
                    <tr>
                        {*<td class="tb-cells posr body-chck">*}
                        {*<div class="wrap-checkbox wrap-reverb-checkbox-2">*}
                        {*<input class="checkbox" type="checkbox" id="checkbox-{$cliente->NR_SEQ_CADASTRO_CASO}">*}
                        {*<label class="styled-reverb-checkbox" for="checkbox-{$cliente->NR_SEQ_CADASTRO_CASO}"></label>*}
                        {*</div>*}
                        {*</td>*}
                        <td class="tb-cells body-name">{$usuario->DS_LOGIN_USRC}</td>
                        <td class="tb-cells body-email">{$usuario->DS_EMAIL_USRC}</td>
                        <td class="tb-cells posr body-action has-pop-over last-col" align="center">
                            <div class="pop-over">
                                <span class="open-pop-over">Opções</span>
                                <div class="content-popover popover-3">
                                    <ul class="nm np  fs13 pop-over-list-1">
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-pow"></span>
                                            {if $usuario->ST_STATUS_USRC == 'A'}
                                                <a href="{$this->url(['module' => 'painel', 'controller' => 'colaborador', 'action' => 'desativar', 'id' => $usuario->NR_SEQ_USUARIO_USRC], null, true)}">Desativar</a>
                                            {else}
                                                <a href="{$this->url(['module' => 'painel', 'controller' => 'colaborador', 'action' => 'ativar', 'id' => $usuario->NR_SEQ_USUARIO_USRC], null, true)}">Reativar</a>
                                            {/if}
                                        </li>
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-edi"></span>
                                            <a href="{$this->url(['module' => 'painel', 'controller' => 'cliente', 'action' => 'form', 'id' => $usuario->NR_SEQ_USUARIO_USRC], null, true)}">Editar dados</a>
                                        </li>
                                        <li class="nl bs posr popover-items-1 popover-delete-1">
                                            <span class="ico ico-dd-exc"></span>
                                            <a href="">Excluir</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>

            <div class="footer-bar">
                {$this->paginationControl($dadosUsuarios, NULL, 'paginator.tpl')}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.popover-delete-1').on('click', function(e) {
            if(confirm('Deseja realmente excluir o usuário?')){
                return true;
            }else{
                return false;
            }
        })
    });
</script>
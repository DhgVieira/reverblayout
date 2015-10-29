<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Clientes
        </div>
        <div id="header-section-name">
            Lista Clientes
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
                        <th class="th-cells head-name">NOME</th>
                        <th class="th-cells head-email">E-MAIL</th>
                        <th class="th-cells head-ratio">FONE</th>
                        <th class="th-cells head-credito">CIDADE/UF</th>
                        <th class="th-cells head-credito">CEP</th>
                        <th class="th-cells head-action last-col">OPÇÕES</th>
                    </tr>
                </thead>
                <tbody class="table-body indica-body">
                    {foreach from=$dadosCliente item=cliente}
                        <tr>
                            {*<td class="tb-cells posr body-chck">*}
                                {*<div class="wrap-checkbox wrap-reverb-checkbox-2">*}
                                    {*<input class="checkbox" type="checkbox" id="checkbox-{$cliente->NR_SEQ_CADASTRO_CASO}">*}
                                    {*<label class="styled-reverb-checkbox" for="checkbox-{$cliente->NR_SEQ_CADASTRO_CASO}"></label>*}
                                {*</div>*}
                            {*</td>*}
                            <td class="tb-cells body-name">{$cliente->DS_NOME_CASO}</td>
                            <td class="tb-cells body-email">{$cliente->DS_EMAIL_CASO}</td>
                            <td class="tb-cells body-ratio">({$cliente->DS_DDDFONE_CASO}){$cliente->DS_FONE_CASO}</td>
                            <td class="tb-cells body-credito">{$cliente->DS_CIDADE_CASO}/{$cliente->DS_UF_CASO}</td>
                            <td class="tb-cells body-credito">{$cliente->DS_CEP_CASO}</td>
                            <td class="tb-cells posr body-action has-pop-over last-col">
                                <div class="pop-over lt">
                                    <span class="open-pop-over">Opções</span>
                                    <div class="content-popover popover-3">
                                        <ul class="nm np  fs13 pop-over-list-1">
                                            <li class="nl bs posr popover-items popover-items-1">
                                                <span class="ico ico-dd-dol"></span>
                                                <a href="">Créditos</a>
                                            </li>
                                            <li class="nl bs posr popover-items popover-items-1">
                                                <span class="ico ico-dd-pow"></span>
                                                {if $cliente->ST_CADASTRO_CASO == 'A'}
                                                    <a href="{$this->url(['module' => 'painel', 'controller' => 'cliente', 'action' => 'desativar', 'id' => $cliente->NR_SEQ_CADASTRO_CASO], null, true)}">Desativar</a>
                                                {else}
                                                    <a href="{$this->url(['module' => 'painel', 'controller' => 'cliente', 'action' => 'ativar', 'id' => $cliente->NR_SEQ_CADASTRO_CASO], null, true)}">Reativar</a>
                                                {/if}
                                            </li>
                                            <li class="nl bs posr popover-items popover-items-1">
                                                <span class="ico ico-dd-edi"></span>
                                                <a href="{$this->url(['module' => 'painel', 'controller' => 'cliente', 'action' => 'form', 'id' => $cliente->NR_SEQ_CADASTRO_CASO], null, true)}">Editar dados</a>
                                            </li>
                                            <li class="nl bs posr popover-items popover-items-1">
                                                <span class="ico ico-dd-vis"></span>
                                                <a href="">Ver compras</a>
                                            </li>
                                            {*<li class="nl bs posr popover-items-1 popover-delete-1">*}
                                                {*<span class="ico ico-dd-exc"></span>*}
                                                {*<a href="">Excluir</a>*}
                                            {*</li>*}
                                        </ul>
                                    </div>
                                </div>
                                <ul class="indica-actions bs">
                                    <li class="indica-items">
                                        <a class="indica-icos indica-email" href="#"></a>
                                    </li>
                                    <li class="indica-items">
                                        <a class="indica-icos indica-sms" href="#"></a>
                                    </li>
                                    <li class="indica-items">
                                        <a class="indica-icos indica-facebook" href="#"></a>
                                    </li>
                                    <li class="indica-items">
                                        <a class="indica-icos indica-twitter" href="#"></a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
            <div class="footer-bar">
                {$this->paginationControl($dadosCliente, NULL, 'paginator.tpl')}
            </div>
        </div>

    </div>

</div>
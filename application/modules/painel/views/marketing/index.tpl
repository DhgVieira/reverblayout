
<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Marketing > Newsletter
        </div>
        <div id="header-section-name">
            Newsletter
        </div>
    </header>
    <div class="lt bs posr container-contents" id="indicacoes-body">
        <div class="container">
            <div class="row above-thead">
                <form action="" method="post">
                    <a href="{$this->url(['module' => 'painel', 'controller' => 'marketing', 'action' => 'cadastrar-newsletter'], null, true)}" class="head-cells fs13 cells nap bs grn-btn green-btn-3">NOVA NEWSLETTER</a>
                    <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                    <input type="text" class="thead-search-field rt bs" name="termo" value="{$busca}">
                </form>
            </div>
            <table class="fw" id="indicacao-table">
                <thead class="table-heads indica-head">
                    <tr>
                        <th class="th-cells head-chck"></th>
                        <th class="th-cells head-newsletter last-col tlt">NEWSLETTER</th>
                        <th class="th-cells head-action">OPÇÕES</th>
                    </tr>
                </thead>
                <tbody class="table-body indica-body">
                    <tr>
                    {foreach from=$dadosSpam item=spam}
                        <td class="tb-cells posr body-chck">

                        </td>
                        <td class="tb-cells body-newsletter last-col tlt">{$spam->ds_descricao}</td>
                        <td class="tb-cells posr body-action has-pop-over ">
                            <ul class="indica-actions bs">
                                <li class="indica-items">
                                    <a class="indica-icos indica-edit" href="{$this->url(['module' => 'painel', 'controller' => 'marketing', 'action' => 'editar-newsletter', 'id' => $spam->id_spam], null, true)}"></a>
                                </li>
                                <li class="indica-items">
                                    <a class="indica-icos indica-eye" href="{$this->url(['module' => 'painel', 'controller' => 'marketing', 'action' => 'ver-newsletter', 'id' => $spam->id_spam], null, true)}" target="_blank"></a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            <div class="footer-bar">
                {$this->paginationControl($dadosSpam, NULL, 'paginator.tpl')}
            </div>
        </div>
    </div>
</div>
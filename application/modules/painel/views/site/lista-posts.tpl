<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12" id="dash-crumb">
            Site &gt; Blog
        </div>
        <div id="header-section-name">
            Posts Cadastrados
        </div>
    </header>
    <div class="lt bs posr container-contents" id="indicacoes-body">
        <div class="container">
            <div class="row above-thead">
                <form action="" method="post">
                    <a href="{$this->url(['module' => 'painel', 'controller' => 'site', 'action' => 'cadastro-post'], null, true)}" class="head-cells fs13 cells nap bs grn-btn green-btn-4 plus-check">CRIAR </a>
                    <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                    <input type="text" class="thead-search-field rt bs" name="termo" value="{$busca}">
                </form>
            </div>
            <table class="fw painel-tables" id="indicacao-table">
                <thead class="table-heads tables-heads">
                    <tr>
                        <th class="th-cells head-post-data">DATA</th>
                        <th class="th-cells head-post-title last-col">TÍTULO DO POST</th>
                        <th class="th-cells head-action">OPÇÕES</th>
                    </tr>
                </thead>
                <tbody class="tables-body indica-body">
                    {foreach from=$dadosBlog item=post}
                        <tr class="{if $post->DS_STATUS_BLRC == 'A'}green{else}orange{/if}">
                            <td class="tb-cells body-post-data">{$post->DT_PUBLICACAO_BLRC|date_format:"%d/%m/%Y"}</td>
                            <td class="tb-cells body-post-title last-col">{$post->DS_TITULO_BLRC}</td>
                            <td class="tb-cells posr body-action has-pop-over">
                                <ul class="indica-actions bs">
                                    <li class="indica-items">
                                        {if $post->DS_STATUS_BLRC == 'A'}
                                            <a class="indica-icos indica-power" href="{$this->url(['module' => 'painel', 'controller' => 'site', 'action' => 'desativar-post', 'id' => $post->NR_SEQ_BLOG_BLRC], null, true)}" title="Desativar"></a>
                                        {else}
                                            <a class="indica-icos indica-power" href="{$this->url(['module' => 'painel', 'controller' => 'site', 'action' => 'ativar-post', 'id' => $post->NR_SEQ_BLOG_BLRC], null, true)}" title="Ativar"></a>
                                        {/if}
                                    </li>
                                    <li class="indica-items">
                                        <a class="indica-icos indica-edit" href="{$this->url(['module' => 'painel', 'controller' => 'site', 'action' => 'editar-post', 'id' => $post->NR_SEQ_BLOG_BLRC], null, true)}" title="Editar"></a>
                                    </li>
                                    <li class="indica-items">
                                        <a class="indica-icos indica-eye" href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}" title="Visualizar" target="_blank"></a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
            <div class="footer-bar">
                {$this->paginationControl($dadosBlog, NULL, 'paginator.tpl')}
            </div>
        </div>
    </div>
</div>
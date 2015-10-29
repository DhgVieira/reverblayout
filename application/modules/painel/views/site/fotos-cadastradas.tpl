
<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Site &gt; People
        </div>
        <div id="header-section-name">
            Fotos cadastradas
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
                        <th class="th-cells head-thumb">THUMB</th>
                        <th class="th-cells head-data">DATA CADASTRO</th>
                        <th class="th-cells head-name">NOME</th>
                        <th class="th-cells head-action min-1">OPÇÕES</th>
                    </tr>
                </thead>
                <tbody class="table-body indica-body">
                    <tr>
                    {foreach from=$dadosPeople item=people}
                        {assign var="foto_me" value="{$people->NR_SEQ_FOTO_FORC}"}
                        {assign var="extensao" value="{$people->DS_EXT_FORC}"}
                        {assign var="foto_completa" value="{$foto_me}.{$extensao}"}

                        <td class="tb-cells body-thumb">
                            <img src="{$this->Url(['tipo'=>"people", 'crop'=>1, 'largura'=>58, 'altura'=>58, 'imagem'=>$foto_completa], "imagem", TRUE)}" width="58" height="58" alt="{$people->DS_NOME_CASO}" />
                        </td>
                        <td class="tb-cells body-data">{$people->DT_CADASTRO_FORC|date_format:"%d/%m/%Y %H:%M"}</td>
                        <td class="tb-cells body-name">{$people->DS_NOME_CASO}</td>
                        <td class="tb-cells posr body-action min-1 has-pop-over">
                            <div class="pop-over lt">
                                <span class="open-pop-over">Opções</span>
                                <div class="content-popover popover-2">
                                    <ul class="nm np  fs13 pop-over-list-1">
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-edi"></span>
                                            Ver Mensagens
                                        </li>
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-spe"></span>
                                            Comentários
                                        </li>
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-edi edit-topic"></span>
                                            Editar objeto
                                        </li>
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-ati"></span>
                                            Ativar este produto
                                        </li>
                                        <li class="nl bs posr popover-items-1 popover-delete-1">
                                            <span class="ico ico-dd-exc"></span>
                                            Excluir
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <ul class="indica-actions-2 bs">
                                <li class="indica-items">
                                    <a class="indica-icos indica-eye" target="_blank" href="{$this->url(["nome"=>{$this->createslug($people->DS_NOME_CASO)}, "idfoto"=>{$people->NR_SEQ_FOTO_FORC}], 'peopledetalhe', TRUE)}"></a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            <div class="footer-bar">
                {$this->paginationControl($dadosPeople, NULL, 'paginator.tpl')}
            </div>
        </div>
    </div>
</div>
{literal}
<script>

</script>
{/literal}
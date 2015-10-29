<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12" id="dash-crumb">
            Site &gt; Cycle
        </div>
        <div id="header-section-name">
            Objetos cadastrados
        </div>
    </header>
    <div class="lt bs posr container-contents" id="indicacoes-body">
        <div class="container">
            <div class="row above-thead">
                <form action="" method="post">
                    <input type="text" name="termo" class="thead-search-field lt bs" value="{$busca}">
                    <input type="submit" class="lt grn-btn thead-search-button bs" value="Buscar">
                </form>
            </div>
            <table class="fw" id="indicacao-table">
                <thead class="table-heads indica-head">
                    <tr>
                        <th class="th-cells head-thumb">THUMB</th>
                        <th class="th-cells head-data">DATA CADASTRO</th>
                        <th class="th-cells head-auth">AUTOR</th>
                        <th class="th-cells head-categoria">CATEGORIA</th>
                        <th class="th-cells head-action min-1">OPÇÕES</th>
                    </tr>
                </thead>
                <tbody class="table-body indica-body">
                    <tr>
                    {foreach from=$dadosCycle item=cycle}
                        {assign var="foto" value="{$cycle->NR_SEQ_REVERBCYCLE_RCRC}"}
                        {assign var="extensao" value="{$cycle->DS_EXT_RCRC}"}
                        {assign var="foto_completa" value="{$foto}.{$extensao}"}

                        <td class="tb-cells body-thumb">
                            {if file_exists("arquivos/uploads/reverbcycle/$foto_completa")}
                                <img src="{$this->Url(['tipo'=>"reverbcycle", 'crop'=>1, 'largura'=>58, 'altura'=>58, 'imagem'=>$foto_completa], "imagem", TRUE)}" width="58" height="58" />
                            {else}
                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>58, 'altura'=>58, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" width="58" height="58" />
                            {/if}
                        </td>
                        <td class="tb-cells body-data">{$cycle->DT_CADASTRO_RCRC|date_format:"%d/%m/%Y"}</td>
                        <td class="tb-cells body-auth">{$cycle->DS_NOME_CASO}</td>
                        <td class="tb-cells body-categoria">{$cycle->DS_CATEGORIA_RVRC}</td>
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
                                    <a class="indica-icos indica-eye" target="_blank" href="{$this->url(["idcycle"=>{$cycle->NR_SEQ_REVERBCYCLE_RCRC}], 'cycledetalhe', TRUE)}"></a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            <div class="footer-bar">
                {$this->paginationControl($dadosCycle, NULL, 'paginator.tpl')}
            </div>
        </div>
    </div>
</div>
{literal}
<script>

</script>
{/literal}
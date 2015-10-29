<div class="container-body">
    <header class="fw lt bs" id="container-top">
        {include file="painel-topmenu.tpl"}
        <div class="fw lt fs12 right-crumb">
            Home > Produtos
        </div>
        <div id="header-section-name">
            CLASSICS
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
                    <th class="th-cells head-chck"></th>
                    <th class="th-cells head-name">IMAGEM</th>
                    <th class="th-cells head-email">DATA CADASTRO</th>
                    <th class="th-cells head-ratio">TIPO</th>
                    <th class="th-cells head-credito">CATEGORIA</th>
                    <th class="th-cells head-credito">REFERÊNCIA</th>
                    <th class="th-cells head-descricao">DESCRIÇÃO</th>
                    <th class="th-cells head-credito">VALOR</th>
                    <th class="th-cells head-credito">QUANTIDADE</th>
                    <th class="th-cells head-action min-1">OPÇÕES</th>
                </tr>
                </thead>
                <tbody class="table-body indica-body">
                {foreach from=$dadosProduto item=produto}
                    {assign var="fotos" value=$this->fotoproduto($produto->NR_SEQ_PRODUTO_PRRC)}
                    {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                    {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                    {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
                    <tr class="{if $produto->ST_PRODUTOS_PRRC == 'A'}green{else}orange{/if}">
                        <td class="tb-cells body-name">{$produto->NR_SEQ_PRODUTO_PRRC}</td>
                        <td class="tb-cells body-email"><img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>25, 'altura'=>25, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt=""/></td>
                        <td class="tb-cells body-ratio">{$produto->DT_CADASTRO_PRRC|date_format:"%d/%m/%Y"}</td>
                        <td class="tb-cells body-credito">{$produto->DS_CATEGORIA_PTRC}</td>
                        <td class="tb-cells body-credito">{$produto->DS_CATEGORIA_PCRC}</td>
                        <td class="tb-cells body-credito">{$produto->DS_REFERENCIA_PRRC}</td>
                        <td class="tb-cells body-descricao">{$produto->DS_PRODUTO_PRRC}</td>
                        <td class="tb-cells body-credito">R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</td>
                        <td class="tb-cells body-credito">{$produto->estoque} unidades</td>
                        <td class="tb-cells posr body-action min-1 has-pop-over">
                            <div class="pop-over lt">
                                <span class="open-pop-over">Opções</span>
                                <div class="content-popover popover-5">
                                    <ul class="nm np  fs13 pop-over-list-1">
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-vis"></span>
                                            <a class="anchor" href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}" target="_blank">Visualizar</a>
                                        </li>
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-spe"></span>
                                            <a class="anchor" href="">Comentários</a>
                                        </li>
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-com"></span>
                                            <a class="anchor" href="">Compradores</a>
                                        </li>
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-ima"></span>
                                            <a class="anchor" href="">Imagens do produto</a>
                                        </li>

                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-edi"></span>
                                            <a class="anchor" href="">Editar produto</a>
                                        </li>
                                        <li class="nl bs posr popover-items-1 popover-remove-1">
                                            <span class="ico ico-dd-rmv"></span>
                                            <a class="anchor" href="{$this->url(['module' => 'painel', 'controller' => 'produto', 'action' => 'mover-produto', 'id' => $produto->NR_SEQ_PRODUTO_PRRC], null, true)}">Retirar do Classics</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="lt row-btns">
                                <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}" target="_blank" class="row-btns-el btn-banner-prev"></a>
                            </div>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
            <div class="footer-bar">
                {$this->paginationControl($dadosProduto, NULL, 'paginator.tpl')}
            </div>
        </div>

    </div>

</div>
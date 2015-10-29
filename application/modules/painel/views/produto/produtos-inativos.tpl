<div class="container-body">
    <header class="fw lt bs" id="container-top">
    <div class="fw lt" id="top-menu">
        <a href="{$this->url(['module'=>"painel", 'controller'=>"usuarios", 'action'=>"logout"], "default", TRUE)}" class="rt bs fs13 top-btns" id="logout-btn"></a>
        <a href="{$this->url(['module'=>"painel", 'controller'=>"usuarios", 'action'=>"logout"], "default", TRUE)}" class="rt anchor fs13 top-btns"> Log Out</a>
        <a href="https://www.reverbcity.com" target="_blank" class="rt anchor fs13 top-btns"> Ir para o site</a>
    </div>
        <div class="fw lt fs12 right-crumb">
            Home > Produtos
        </div>
        <div id="header-section-name">
            Produtos Inativos

            <div class="header-helpers">
                <a href="#" class="header-helpers-actions" id="new-action"></a>
                <a href="#" class="header-helpers-actions" id="email-action"></a>
                <a href="#" class="header-helpers-actions" id="print-action"></a>
            </div>
        </div>
    </header>
    <div class="lt bs posr container-contents" id="indicacoes-body">
        <div class="container">
            <div class="row above-thead">
                <form action="" method="post">
                    <div class="t-head-options bs fs11 select-2">
                        <select class="select bs" id="localbanner" name="localbanner">
                            <option value="" selected disabled>Selecione</option>
                            <option value="1">Opções em Lote</option>
                            <option value="2">Opções em Lote2</option>
                        </select>
                        <span class="select-value">Opções em Lote</span>
                    </div>
                    <button class="head-cells fs13 cells nap bs grn-btn green-btn-1 plus-check" id="apply-items">Aplicar nos items selecionados</button>
                    <input type="submit" class="rt grn-btn thead-search-button bs" value="Buscar">
                    <input type="text" class="thead-search-field rt bs" name="termo" value="{$busca}">
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
                                <div class="content-popover popover-1">
                                    <ul class="nm np  fs13 pop-over-list-1">
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-dol"></span>
                                            <a class="anchor" href="">Alterar estoque</a>
                                        </li>
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-ima"></span>
                                            <a class="anchor" href="">Imagem do produto</a>
                                        </li>
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-com"></span>
                                            <a class="anchor" href="">Compradores</a>
                                        </li>
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-mov"></span>
                                            <a class="anchor" href="{$this->url(['module' => 'painel', 'controller' => 'produto', 'action' => 'mover-classic', 'id' => $produto->NR_SEQ_PRODUTO_PRRC], null, true)}">Mover para classics</a>
                                        </li>
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-vis"></span>
                                            <a class="anchor" href="{$this->url(['module' => 'painel', 'controller' => 'produto', 'action' => 'mover-classic', 'id' => $produto->NR_SEQ_PRODUTO_PRRC], null, true)}">Visualizar</a>
                                        </li>
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-edi"></span>
                                            <a class="anchor" href="">Editar produto</a>
                                        </li>
                                        <li class="nl bs posr popover-items popover-items-1">
                                            <span class="ico ico-dd-ati"></span>
                                            {if $produto->ST_PRODUTOS_PRRC == 'A'}
                                                <a class="anchor" href="{$this->url(['module' => 'painel', 'controller' => 'produto', 'action' => 'desativar', 'id' => $produto->NR_SEQ_PRODUTO_PRRC], null, true)}">Desativar este produto</a>
                                            {else}
                                                <a class="anchor" href="{$this->url(['module' => 'painel', 'controller' => 'produto', 'action' => 'ativar', 'id' => $produto->NR_SEQ_PRODUTO_PRRC], null, true)}">Ativar este produto</a>
                                            {/if}
                                        </li>
                                        <li class="nl bs posr popover-items-1 popover-delete-1">
                                            <span class="ico ico-dd-exc"></span>
                                            Excluir
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
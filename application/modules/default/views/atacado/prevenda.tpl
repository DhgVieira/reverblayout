<h1 class="rvb-title">Reverb <span>Pre-Venda</span></h1>

<div class="left-column-content">
    <ul class="list-of-products">
        {foreach from=$contadores item=produto}
            {assign var="foto" value="{$produto->NR_SEQ_PRODUTO_PRRC}"}
            {assign var="extensao" value="{$produto->DS_EXT_PRRC}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
            {assign var="vl_lojista" value="{math equation="x / y" x=$produto->VL_PRODUTO_PRRC y=2}"}
        <form action="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'adicionarcarrinho', TRUE)}" >
            <li class="product-item">
                <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produtoprevenda', TRUE)}" class="product-thumb">
                    {if file_exists("arquivos/uploads/produtos/$foto_completa")}
                        <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>160, 'altura'=>185, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}" title="{$produto->DS_PRODUTO_PRRC}" width="160" height="185"/>
                    {else}
                         <img class="profile" src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>160,'altura'=>185,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}" width="160" height="185">
                    {/if}
                </a>
                <h2 class="product-title">
                    <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produtoprevenda', TRUE)}">
                        {utf8_decode($produto->DS_PRODUTO_PRRC|truncate:38:"...":TRUE)}
                    </a>
                </h2>
                <div class="prices">
                    <p class="retail">Varejo: R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</p>
                    <p class="wholesale">Pre-Venda: <strong>R$ {$vl_lojista|number_format:2:",":"."} </strong></p>
                </div>
                <div class="ui-buttons">
                    <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produtoprevenda', TRUE)}" class="ui-button add">Adicionar</a>
                </div>
            </li>
        </form>
        {/foreach}
    </ul>

    <ul class="pagination">
            {if $pages.previous}
                <li class="item">
                    <a title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"atacado", "action"=>"index", "page"=>{$pages.previous}], "atacado", TRUE)}">◄</a>
                </li>
            {/if}
            {section name=page_loop start=$this->contadores->current_page-1 loop=$this->contadores->current_page+3 step=1}
                {if $smarty.section.page_loop.index+1 == $this->contadores->current_page}
                    <li class="item">
                        <a href="{$this->url(["module"=>"default","controller"=>"atacado",  "action"=>"index", "page"=>$smarty.section.page_loop.index+1], "atacado", TRUE)}" class="active">
                            {$smarty.section.page_loop.index+1}
                        </a>
                    </li>
                {else}
                    <li class="item">
                        <a href="{$this->url(["module"=>"default","controller"=>"atacado",  "action"=>"index", "page"=>$smarty.section.page_loop.index+1], "atacado", TRUE)}">
                            {$smarty.section.page_loop.index+1}
                        </a>
                    </li>
                {/if}
            {/section}
            {if $pages.next}
                <li class="item">
                    <a title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"atacado", "action"=>"index", "page"=>{$pages.next}], "atacado", TRUE)}">►</a>
                </li>
            {/if}
        </ul>
</div>


<div class="sidebar-ui sidebar-filters right-aligned">
    {include file="sidebar-filters.tpl"}
</div>




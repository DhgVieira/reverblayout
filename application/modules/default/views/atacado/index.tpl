<h1 class="rvb-title">Reverb <span>Atacado</span></h1>

<div class="left-column-content">
    <ul class="list-of-products">
        {foreach from=$contadores item=produto}
            {assign var="foto" value="{$produto->NR_SEQ_PRODUTO_PRRC}"}
            {assign var="extensao" value="{$produto->DS_EXT_PRRC}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
            
            {assign var="fotos" value=$this->fotoproduto($produto->NR_SEQ_PRODUTO_PRRC)}
            {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
            {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
            {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
            
            {assign var="vl_lojista" value="{$produto->VL_PRODUTO_PRRC}"}

            {assign var="vl_lojista_tmp" value="{math equation="x * y" x=$produto->VL_PRODUTO_PRRC y=0.6}"}
            
            {if $produto->VL_PROMO_PRRC > 0 and $vl_lojista_tmp > $produto->VL_PROMO_PRRC}
                {assign var="vl_lojista" value="{$produto->VL_PROMO_PRRC}"}
            {else}
                {assign var="vl_lojista" value=$vl_lojista_tmp}
            {/if}
            
            {*{if $produto->NR_SEQ_TIPO_PRRC eq 6}
                <!-- {assign var="vl_lojista" value="{math equation="x / y" x=$produto->VL_PRODUTO_PRRC y=2}"} -->
                {if $produto->TP_DESTAQUE_PRRC eq 2}
                    {assign var="vl_lojista" value="{math equation="x * y" x=$produto->VL_PRODUTO_PRRC y=0.4}"}
                {else}
                    {assign var="vl_lojista" value="{math equation="x * y" x=$produto->VL_PRODUTO_PRRC y=0.5}"}
                {/if}
            {/if}
            {if $produto->NR_SEQ_CATEGORIA_PRRC eq 173}
                 {assign var="vl_lojista" value="{math equation="x - (x * y)" x=$produto->VL_PRODUTO_PRRC y=0.3}"}
            {/if}
            {if $produto->NR_SEQ_TIPO_PRRC eq 142 or $produto->NR_SEQ_TIPO_PRRC eq 143}
                 {assign var="vl_lojista" value="{math equation="x - (x * y)" x=$produto->VL_PRODUTO_PRRC y=0.5}"}
            {/if}*}
           
        <form action="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'adicionarcarrinho', TRUE)}" >
            <li class="product-item">
                <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produtolojista', TRUE)}" class="product-thumb">
                    {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                        <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>160, 'altura'=>185, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}" title="{$produto->DS_PRODUTO_PRRC}" width="160" height="185"/>
                    {else}
                         <img class="profile" src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>160,'altura'=>185,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}" width="160" height="185">
                    {/if}
                </a>
                <h2 class="product-title">
                    <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produtolojista', TRUE)}">
                        {utf8_decode($produto->DS_PRODUTO_PRRC|truncate:38:"...":TRUE)}
                    </a>
                </h2>
                <div class="prices">
                    <p class="retail">Varejo: R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</p>
                    <p class="wholesale">Atacado: <strong>R$ {$vl_lojista|number_format:2:",":"."} </strong></p>
                </div>
                <div class="ui-buttons">
                    <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produtolojista', TRUE)}" class="ui-button add">Adicionar</a>
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




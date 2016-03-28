    {assign var="acaoAtual" value="{$currentAction}"}

    {if $acaoAtual eq "index"}
        {assign var="acaoAtual" value="loja"}
    {/if}
<div class="banners-advertisement cycle-slideshow"
    data-cycle-fx="fadeout"
    data-cycle-timeout="5000"
    data-cycle-slides="> a"
    data-cycle-log="false"
    data-cycle-pause-on-hover="true" style="margin-bottom:10px;">
        {foreach from=$banners_topo item=banner}
        {assign var="foto" value="{$banner->NR_SEQ_BANNER_BARC}"}
        {assign var="extensao" value="{$banner->DS_EXT_BARC}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
            <a rel="nofollow" href="{$banner->DS_LINK_BARC}">
                {if file_exists("arquivos/uploads/banners/$foto_completa")}
                    <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}" />
                {else}
                    <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}" />
                {/if}
            </a>
        {/foreach}
    </div>
<section class="products">
    <h1 class="rvb-title">Reverb <span>Casa</span></h1>
    <span class="breadcrumb">
        <div style="float: left;" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a itemprop="url" href="https://www.reverbcity.com/inicio">
                <span itemprop="title">Reverbcity</span>
            </a> >
            <div style="display: inline-block;" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                <a itemprop="url" itemprop="title" href="https://www.reverbcity.com/loja">
                    <span itemprop="title">Loja</span>
                </a> >
                <div style="display: inline-block;" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                    <a itemprop="url" itemprop="title" href="https://www.reverbcity.com/casa">
                        <span itemprop="title"><b>Casa</b></span>
                    </a>
                </div>
            </div>
        </div>
    </span>
{if $contadores|count > 0}
<div class="rvb-column left">
        <ul class="rvb-collection-of-products">
            {foreach from=$contadores item=produto name=produtosForEach}
                {assign var="foto" value="{$produto->NR_SEQ_PRODUTO_PRRC}"}
                {assign var="extensao" value="{$produto->DS_EXT_PRRC}"}
                {assign var="foto_completa" value="{$foto}.{$extensao}"}
                
                {assign var="fotos" value=$this->fotoproduto($produto->NR_SEQ_PRODUTO_PRRC)}
                {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
                
            <li class="rvb-product-item">
                <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}" class="product-photo">
                    {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                        {*{assign var="foto_completa" value="{$this->createslug($produto->DS_PRODUTO_PRRC)}-{$foto_produto}.{$extensao_produto}"}*}
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="{$produto->DS_PRODUTO_PRRC}" data-title="{$produto->DS_PRODUTO_PRRC}">
                            <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>160, 'altura'=>185, 'imagem'=>$foto_completa],"imagem", TRUE)}"></span>
                            <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>140, 'altura'=>160, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                            <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>130, 'altura'=>150, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                            <!-- for hd displays -->
                            <span data-width="140" data-height="160" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>280, 'altura'=>320, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            <span data-width="130" data-height="150" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>260, 'altura'=>300, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>

                            <noscript>
                                <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>160, 'altura'=>185, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}">
                            </noscript>
                        </span>
                    {else}
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="{$produto->DS_PRODUTO_PRRC}" data-title="{$produto->DS_PRODUTO_PRRC}">
                            <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>160, 'altura'=>185, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"></span>
                            <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>140, 'altura'=>160, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                            <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>130, 'altura'=>150, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                            <!-- for hd displays -->
                            <span data-width="140" data-height="160" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>280, 'altura'=>320, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            <span data-width="130" data-height="150" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>260, 'altura'=>300, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>

                            <noscript>
                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>160, 'altura'=>185, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity">
                            </noscript>
                        </span>
                    {/if}

                    {if $produto->DS_FRETEGRATIS_PRRC == 'S'}
                        <span class="rvb-tag sale-frete"></span>
                    {elseif $produto->TP_DESTAQUE_PRRC == 1}
                        <span class="rvb-tag new"></span>
                    {elseif $produto->TP_DESTAQUE_PRRC == 3}
                        <span class="rvb-tag reprint"></span>
                    {elseif $produto->TP_DESTAQUE_PRRC == 2}
                        <span class="rvb-tag sale"></span>
                    {elseif $produto->TP_DESTAQUE_PRRC == 4}
                        <span class="rvb-tag sale-frete"></span>
                    {else}
                         <span class="rvb-tag"></span>
                    {/if}
                </a>
                <h2 class="product-name product-name2">
                    {*{utf8_decode($produto->DS_PRODUTO_PRRC|truncate:18:"...":TRUE)}*}
                    <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}">
                        {$produto->DS_PRODUTO_PRRC}
                    </a>
                </h2>
                {assign var=totalChar value=$produto->DS_PRODUTO_PRRC|count_characters:true}
                {if $totalChar >= 22}
                    <span class="extends">...</span>
                {/if}
                <p class="price">
                    <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}">
                    {if $produto->VL_PROMO_PRRC > 0}
                        <del>R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</del>
                        Por R$ {$produto->VL_PROMO_PRRC|number_format:2:",":"."}
                    {else}
                         R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."} 
                    {/if}
                    </a>
                </p>
            </li>
            {/foreach}
        </ul>

       {if $contadores|count > 16}
            <ul class="pagination">
                {*{if $pages.previous}*}
                    {*<li class="item">*}
                        {*<a title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"loja", "action"=>"{$acaoAtual}", "page"=>{$pages.previous}, "categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}">◄</a>*}
                    {*</li>*}
                {*{/if}*}

                     {*{section name=page_loop start=0 loop=$this->contadores->total_pages step=1}*}
                            {*<li class="item">*}
                                {*<a href="{$this->url(["module"=>"default","controller"=>"loja",  "action"=>"{$acaoAtual}", "page"=>$smarty.section.page_loop.index+1, "categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}"  {if $smarty.section.page_loop.index+1 == $this->contadores->current_page} class="active" {/if}>*}
                                   {*{if $this->contadores->total_pages > 1} *}
                                    {*{$smarty.section.page_loop.index+1} *}
                                    {*{else}*}
                                        {*{$smarty.section.page_loop.index}*}
                                    {*{/if}*}
                                {*</a>*}
                            {*</li>*}
                    {*{/section}*}
              {**}
                {*{if $pages.next}*}
                    {*<li class="item">*}
                        {*<a title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"loja", "action"=>"{$acaoAtual}", "page"=>{$pages.next}, "categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}">►</a>*}
                    {*</li>*}
                {*{/if}*}
                {$this->paginationControl($contadores, NULL, 'paginator_loja.tpl')}
            </ul>
        {/if}
    </div>

    {else}
        <div id="empty-result" style="display: block;width: 100%;">

            <img src="{$basePath}/arquivos/default/images/empty-result2.png" alt="Página não encontrada" style="max-width: 100%;height: auto;display: block;margin: 0 auto;" />

            <p class="visuallyhidden">
                Hey, não encontramos
                nada relacionado com a
                busca que você digitou... :(
                Tente novamente e tenha
                certeza que digitou
                tudo certo.. 
            </p>
        </div>
    {/if}
    {if $contadores|count > 0}
        <div class="rvb-column right">
            {include file="sidebar-filters.tpl"}
        </div>
    {/if}
</section>
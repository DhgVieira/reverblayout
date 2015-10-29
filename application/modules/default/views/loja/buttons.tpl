<section class="products">
    <h1 class="rvb-title">Reverb <span>Buttons</span></h1>

    <div class="rvb-column left">
        <ul class="rvb-collection-of-products">
            {foreach from=$contadores item=produto name=produtosForEach}
                {assign var="foto" value="{$produto->NR_SEQ_PRODUTO_PRRC}"}
                {assign var="extensao" value="{$produto->DS_EXT_PRRC}"}
                {assign var="foto_completa" value="{$foto}.{$extensao}"}
            <li class="rvb-product-item">
                <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}" class="product-photo">
                    {if file_exists("arquivos/uploads/produtos/$foto_completa")}
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="{$produto->DS_PRODUTO_PRRC}" data-title="{$produto->DS_PRODUTO_PRRC}">
                            <span data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>160, 'altura'=>185, 'imagem'=>$foto_completa],"imagem", TRUE)}"></span>
                            <span data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>140, 'altura'=>160, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                            <span data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>130, 'altura'=>150, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                            <!-- for hd displays -->
                            <span data-width="140" data-height="160" data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>280, 'altura'=>320, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            <span data-width="130" data-height="150" data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>260, 'altura'=>300, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>

                            <noscript>
                                <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>160, 'altura'=>185, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity">
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
                    {if $produto->TP_DESTAQUE_PRRC == 1}
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
                <h2 class="product-name">{utf8_decode($produto->DS_PRODUTO_PRRC|truncate:19:"...":TRUE)}</h2>
                <p class="price">
                    {if $produto->VL_PROMO_PRRC > 0}
                        <del>R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</del>
                        Por R$ {$produto->VL_PROMO_PRRC|number_format:2:",":"."}
                    {else}
                         R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."} 
                    {/if}
                </p>
            </li>
            {/foreach}
        </ul>

        <ul class="pagination">
            {if $pages.previous}
                <li class="item">
                    <a title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"loja", "action"=>"buttons", "page"=>{$pages.previous}], "buttons", TRUE)}">◄</a>
                </li>
            {/if}
            {section name=page_loop start=$this->contadores->current_page-1 loop=$this->contadores->current_page+3 step=1}
                {if $smarty.section.page_loop.index+1 == $this->contadores->current_page}
                    <li class="item">
                        <a href="{$this->url(["module"=>"default","controller"=>"loja",  "action"=>"buttons", "page"=>$smarty.section.page_loop.index+1], 'buttons', TRUE)}" class="active">
                            {$smarty.section.page_loop.index+1}
                        </a>
                    </li>
                {else}
                    <li class="item">
                        <a href="{$this->url(["module"=>"default","controller"=>"loja",  "action"=>"buttons", "page"=>$smarty.section.page_loop.index+1], 'buttons', TRUE)}">
                            {$smarty.section.page_loop.index+1}
                        </a>
                    </li>
                {/if}
            {/section}
            {if $pages.next}
                <li class="item">
                    <a title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"loja", "action"=>"buttons", "page"=>{$pages.next}], "buttons", TRUE)}">►</a>
                </li>
            {/if}
        </ul>
    </div>

    <div class="rvb-column right">
        {include file="sidebar-filters.tpl"}
    </div>
</section>

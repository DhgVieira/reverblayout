    {assign var="acaoAtual" value="{$currentAction}"}

    {if $acaoAtual eq "index"}
        {assign var="acaoAtual" value="loja"}
    {/if}
<section class="products">
    <h1 class="rvb-title">Reverb <span>Acessórios</span></h1>
 {if $contadores|count > 0}
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

        {if $contadores|count > 16}
            <ul class="pagination">
                {if $pages.previous}
                    <li class="item">
                        <a title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"loja", "action"=>"{$acaoAtual}", "page"=>{$pages.previous}, "categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}">◄</a>
                    </li>
                {/if}

                     {section name=page_loop start=0 loop=$this->contadores->total_pages step=1}
                            <li class="item">
                                <a href="{$this->url(["module"=>"default","controller"=>"loja",  "action"=>"{$acaoAtual}", "page"=>$smarty.section.page_loop.index+1, "categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}"  {if $smarty.section.page_loop.index+1 == $this->contadores->current_page} class="active" {/if}>
                                   {if $this->contadores->total_pages > 1} 
                                    {$smarty.section.page_loop.index+1} 
                                    {else}
                                        {$smarty.section.page_loop.index}
                                    {/if}
                                </a>
                            </li>
                    {/section}
              
                {if $pages.next}
                    <li class="item">
                        <a title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"loja", "action"=>"{$acaoAtual}", "page"=>{$pages.next}, "categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}">►</a>
                    </li>
                {/if}
            </ul>
        {/if}
    </div>

    {else}
        <div class="rvb-column left">
            <p class="empty-search">
                Hey, não encontramos nada relacionado com a  busca que você digitou... :( <br>
                Tente novamente e tenha certeza que digitou tudo certo..
            </p>
        </div>

    {/if}

    <div class="rvb-column right">
        {include file="sidebar-filters.tpl"}
    </div>
</section>
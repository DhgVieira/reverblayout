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
            <a href="{$banner->DS_LINK_BARC}">
                {if file_exists("arquivos/uploads/banners/$foto_completa")}
                    <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}" />
                {else}
                    <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}" />
                {/if}
            </a>
        {/foreach}
    </div>
<section class="products">
    <h1 class="rvb-title">Coleções <span>Antigas</span></h1>

    <div class="top-details">
        <div class="top-details-text">
            <p>
              Tudo aquilo que já fizemos está aqui na nossa galeria de clássicos.
              Estes itens já saíram de linha e não estão mais a venda, mas os que ainda tem chances de voltar estão na seção “avise-me”.
            </p>
        </div>
    </div>

 <div class="rvb-column left">
        <ul class="rvb-collection-of-products">
            {foreach from=$contadores item=produto name=produtosForEach}
                {assign var="foto" value="{$produto->NR_SEQ_PRODUTO_PRRC}"}
                {assign var="extensao" value="{$produto->DS_EXT_PRRC}"}
                {assign var="foto_completa" value="{$foto}.{$extensao}"}
                
                {*{assign var="fotos" value=$this->fotoproduto($produto->NR_SEQ_PRODUTO_PRRC)}
                {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}*}
            <li class="rvb-product-item">
                <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'classic', TRUE)}" class="product-photo">
                    {if file_exists("arquivos/uploads/produtos/$foto_completa")}
                        {*{assign var="foto_completa" value="{$this->createslug($produto->DS_PRODUTO_PRRC)}-{$foto}.{$extensao}"}*}
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="{$produto->DS_PRODUTO_PRRC}" data-title="{$produto->DS_PRODUTO_PRRC}">
                            <span data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>160, 'altura'=>185, 'imagem'=>$foto_completa],"imagem", TRUE)}"></span>
                            <span data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>140, 'altura'=>160, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                            <span data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>130, 'altura'=>150, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                            <!-- for hd displays -->
                            <span data-width="140" data-height="160" data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>280, 'altura'=>320, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            <span data-width="130" data-height="150" data-src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>260, 'altura'=>300, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>

                            <noscript>
                                <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>160, 'altura'=>185, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}">
                            </noscript>
                        </span>
                    {else}
                        {assign var="fotos" value=$this->fotoproduto($produto->NR_SEQ_PRODUTO_PRRC)}
                        {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                        {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                        {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
                        
                        {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                            {assign var="foto_completa" value="{$this->createslug($produto->DS_PRODUTO_PRRC)}-{$foto_produto}.{$extensao_produto}"}
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
                    {/if}
                </a>
                <h2 class="product-name product-name2">
                    {*{utf8_decode($produto->DS_PRODUTO_PRRC|truncate:18:"...":TRUE)}*}
                    {$produto->DS_PRODUTO_PRRC}
                </h2>
                {assign var=totalChar value=$produto->DS_PRODUTO_PRRC|count_characters:true}
                {if $totalChar >= 22}
                    <span class="extends">...</span>
                {/if}

            </li>
            {/foreach}
        </ul>

         <ul class="pagination">
                {if $pages.previous}
                    <li class="item">
                        <a title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"loja", "action"=>"{$acaoAtual}", "page"=>{$pages.previous}, "categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}">◄</a>
                    </li>
                {/if}

                    {section name=page_loop start=$this->contadores->current_page-1 loop=$this->contadores->current_page+3 step=1}
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
    </div>

    <div class="rvb-column right">
        {include file="sidebar-default.tpl"}
    </div>
</section>

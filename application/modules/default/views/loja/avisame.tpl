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
    <h1 class="rvb-title">Reverb <span>Avise-me</span></h1>
    {if $contadores|count > 0}
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
                                <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>160, 'altura'=>185, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity">
                            </noscript>
                        </span>
                    {else}
                        {assign var="fotos" value=$this->fotoproduto($produto->NR_SEQ_PRODUTO_PRRC)}
                        {assign var="foto_produto" value="{$fotos[1]['NR_SEQ_FOTO_FORC']}"}
                        {assign var="extensao_produto" value="{$fotos[1]['DS_EXT_FORC']}"}
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
		                    </span>
                        {/if}
                    {/if}
            {/foreach}
    {/if}
    </div>

    {if $contadores|count > 0}
        {*<div class="rvb-column center">*}
        <div class="row">
            <div id="grid">
                {*<ul class="rvb-collection-of-products">*}
                <div class="grid-sizer"></div>
                <div class="gutter-sizer"></div>
                {foreach from=$contadores item=produto name=produtosForEach}
                    {assign var="foto" value="{$produto->NR_SEQ_PRODUTO_PRRC}"}
                    {assign var="extensao" value="{$produto->DS_EXT_PRRC}"}
                    {assign var="foto_completa" value="{$foto}.{$extensao}"}
                    <div class="grid-item">
                        <div class="flip-container">
                            <div class="flipper">
                                <div class="front">
                                    <div id="home-front2">
                                        <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'classic', TRUE)}" class="product-photo">
                                            {if file_exists("arquivos/uploads/produtos/$foto_completa")}
                                                <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="produto" />
                                            {else}
                                                {assign var="fotos" value=$this->fotoproduto($produto->NR_SEQ_PRODUTO_PRRC)}
                                                {assign var="foto_produto" value="{$fotos[1]['NR_SEQ_FOTO_FORC']}"}
                                                {assign var="extensao_produto" value="{$fotos[1]['DS_EXT_FORC']}"}
                                                {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
                                                {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                                                    <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$produto['DS_PRODUTO_PRRC']}" />
                                                {else}
                                                    <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity">
                                                {/if}
                                            {/if}
                                        </a>
                                    </div>
                                </div>
                                <div class="back">
                                    <div id="home-back2">
                                        {if file_exists("arquivos/uploads/produtos/$foto_completa")}
                                            <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'imagem'=>$foto_completa], "imagem", TRUE)}" alt="{$produto['DS_PRODUTO_PRRC']}" />
                                        {else}
                                            {assign var="fotos" value=$this->fotoproduto($produto->NR_SEQ_PRODUTO_PRRC)}
                                            {assign var="foto_produto" value="{$fotos[1]['NR_SEQ_FOTO_FORC']}"}
                                            {assign var="extensao_produto" value="{$fotos[1]['DS_EXT_FORC']}"}
                                            {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
                                            {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                                                <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$produto['DS_PRODUTO_PRRC']}" />
                                            {else}
                                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity">
                                            {/if}
                                        {/if}
                                        <div class="image_over">
                                            <div class="image_hover_text">
                                                {*<a href="{$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)}" class="title">*}

                                                {*<br/>*}
                                                {*<a href="{$this->url(["titulo"=>{$this->createslug($cycle['DS_OBJETO_RCRC'])}, "idcycle"=>{$cycle['NR_SEQ_REVERBCYCLE_RCRC']}], 'cycledetalhe', TRUE)}" class="title text_bold">*}
                                                {*Eu quero!*}
                                                {*</a>*}
                                                <span>{$produto->DS_PRODUTO_PRRC}</span>
                                                <br/>
                                                <br/>
                                                <a href="{$this->url(["titulo"=>{$this->createslug($produto->DS_PRODUTO_PRRC)}, "idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'classic', TRUE)}" class="title text_bold">
                                                    <button class="reprint-button">Pedir Reprint</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
        <div class="row">
            <div id="more-nav">
                {*<a href="/people/?page={$page + 1}">*}
                <button id="more">CARREGAR MAIS</button>
                {*</a>*}
            </div>
        </div>

    {else}
        <div class="rvb-column left">
            <p class="empty-search">
                Hey, não encontramos nada relacionado com a  busca que você digitou... :( <br>
                Tente novamente e tenha certeza que digitou tudo certo..
            </p>
        </div>

    {/if}
</section>

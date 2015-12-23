{include file="banner.tpl"}
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
<section class="products">
    <div class="rvb-column center">
        <ul class="rvb-collection-of-products">
            {assign var="foto" value="{$_produto_dia->NR_SEQ_PRODUTO_PRRC}"}
            {assign var="extensao" value="{$_produto_dia->DS_EXT_PRRC}"}
            {assign var="foto_completa_dia" value="{$foto}.{$extensao}"}
            
            {assign var="fotos" value=$this->fotoproduto($_produto_dia->NR_SEQ_PRODUTO_PRRC)}
            {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
            {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
            {assign var="foto_completa_dia" value="{$foto_produto}.{$extensao_produto}"}

            {if !file_exists("arquivos/uploads/fotosprodutos/$foto_completa_dia")}
                {$foto_completa_dia}
                {assign var="foto_produto" value="{$fotos[1]['NR_SEQ_FOTO_FORC']}"}
                {assign var="extensao_produto" value="{$fotos[1]['DS_EXT_FORC']}"}
                {assign var="foto_completa_dia" value="{$foto_produto}.{$extensao_produto}"}
            {/if}
            
            <li class="rvb-product-item highlight" style="height: auto;">
                {if $_produto_dia->NR_SEQ_TIPO_PRRC == 6}
                    {assign var=preTitle value='camiseta '}
                {else}
                    {assign var=preTitle value=''}
                {/if}

                {assign var=ds_produto_prrc value=' - '|explode:$_produto_dia->DS_PRODUTO_PRRC}
                {assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}

                <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}" class="product-photo">
                    {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa_dia")}
                        {*{assign var="foto_completa_dia" value="{$this->createslug($_produto_dia->DS_PRODUTO_PRRC)}-{$foto_produto}.{$extensao_produto}"}*}
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="{utf8_decode($_produto_dia->DS_PRODUTO_PRRC)}">
                            {if $_isMobile neq 1}
                                <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>460, 'altura'=>512, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}"></span>
                            {else}
                                <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>220, 'altura'=>250, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>280, 'altura'=>315, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                                <!-- for hd displays -->
                                <span data-width="220" data-height="250" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>440, 'altura'=>500, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                                <span data-width="280" data-height="315" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>560, 'altura'=>630, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            {/if}

                            <noscript>
                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>340,'altura'=>380,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$_produto_dia->DS_PRODUTO_PRRC}">
                            </noscript>
                        </span>
                    {else}
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="Produto Destaque">
                            {if $_isMobile neq 1}
                                <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>460,'altura'=>512,'imagem'=>'not_found.jpg'],'imagem', TRUE)}"></span>
                            {else}
                                <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>220,'altura'=>250,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" data-media="(max-width: 767px)"></span>
                                <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>280,'altura'=>315,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" data-media="(max-width: 479px)"></span>
                                <!-- for hd displays -->
                                <span data-width="220" data-height="250" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>440, 'altura'=>500, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                                <span data-width="280" data-height="315" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>560, 'altura'=>630, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            {/if}

                            <noscript>
                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>460,'altura'=>512,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="Imagem não encontrada - Reverbcity">
                            </noscript>
                        </span>
                    {/if}
                    {*<span class="rvb-tag new productday"></span>*}
                </a>
                <div class="product-details">
                    <div class="circle" style="background-color: #5fbf98">
                        <a>NEW</a>
                    </div>
                    <h2 class="product-name">
                        <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}">
                            {$_produto_dia->DS_PRODUTO_PRRC|truncate:29:"...":TRUE}
                            {if $_produto_dia->DS_FRETEGRATIS_PRRC == 'S'}
                                - Frete Grátis
                            {/if}
                        </a>
                    </h2>
                    <p class="price">
                        {if $destaque->VL_PROMO_PRRC neq 0}
                            <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$destaque->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}">
                                <span class="old-price">R$ {$destaque->VL_PRODUTO_PRRC|number_format:2:",":"."}</span>
                                por R$ {$destaque->VL_PROMO_PRRC|number_format:2:",":"."}
                            </a>
                        {else}
                            <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$destaque->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}">
                                R$ {$destaque->VL_PRODUTO_PRRC|number_format:2:",":"."}
                            </a>
                        {/if}
                    </p>
                </div>
            </li>
            {assign var="foto" value="{$destaque->NR_SEQ_PRODUTO_PRRC}"}
            {assign var="extensao" value="{$destaque->DS_EXT_PRRC}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
            
            {assign var="fotos" value=$this->fotoproduto($destaque->NR_SEQ_PRODUTO_PRRC)}
            {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
            {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
            {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}

            <li class="rvb-product-item highlight" style="height: auto;">
            {if $destaque->NR_SEQ_TIPO_PRRC == 6}
                {assign var=preTitle value='camiseta '}
            {else}
                {assign var=preTitle value=''}
            {/if}

            {assign var=ds_produto_prrc value=' - '|explode:$destaque->DS_PRODUTO_PRRC}
            {assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}

              <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$destaque->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}" class="product-photo">
            {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                    {*{assign var="foto_completa" value="{$this->createslug($destaque->DS_PRODUTO_PRRC)}-{$foto_produto}.{$extensao_produto}"}*}
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="{$destaque->DS_PRODUTO_PRRC}" title="{$destaque->DS_PRODUTO_PRRC}">
                        {if $_isMobile neq 1}
                            <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>460, 'altura'=>512, 'imagem'=>$foto_completa],"imagem", TRUE)}"></span>
                        {else}
                            <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>220, 'altura'=>250, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                            <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>280, 'altura'=>315, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                            <!-- for hd displays -->
                            <span data-width="220" data-height="250" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>440, 'altura'=>500, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            <span data-width="280" data-height="315" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>560, 'altura'=>630, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                        {/if}

                        <noscript>
                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>460,'altura'=>512,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="Imagem não encontrada - Reverbcity">
                        </noscript>
                    </span>
            {else}
                    <!-- Polyfill para imagens responsivas-->
                    <span data-picture data-alt="Produto Destaque">
                        {if $_isMobile neq 1}
                            <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>460,'altura'=>512,'imagem'=>'not_found.jpg'],'imagem', TRUE)}"></span>
                        {else}
                            <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>220,'altura'=>250,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" data-media="(max-width: 767px)"></span>
                            <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>280,'altura'=>315,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" data-media="(max-width: 479px)"></span>
                            <!-- for hd displays -->
                            <span data-width="220" data-height="250" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>440, 'altura'=>500, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            <span data-width="280" data-height="315" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>560, 'altura'=>630, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                        {/if}
                        <noscript>
                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>460,'altura'=>512,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="Imagem não encontrada - Reverbcity">
                        </noscript>
                    </span>
            {/if}
                    {*<span class="rvb-tag new big"></span>*}
                </a>
                <div class="product-details">
                    <div class="circle" style="background-color: #fc6902">
                        <a>OFF</a>
                    </div>
                    <h2 class="product-name">
                        <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$destaque->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}">
                            {utf8_decode($destaque->DS_PRODUTO_PRRC)}
                            {if $destaque->DS_FRETEGRATIS_PRRC == 'S'}
                                    - Frete Grátis
                            {/if}
                        </a>
                    </h2>
                    <p class="price">
                        <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], 'produto', TRUE)}">
                            <span class="old-price">R$ {$_produto_dia->VL_PRODUTO_PRRC|number_format:2:",":"."}</span>
                            por R$ {$_produto_dia->VL_PROMO_PRRC|number_format:2:",":"."}
                        </a>
                    </p>
                </div>
            </li>
            {foreach from=$contadores item=produto name=produtosForEach}
                {assign var="foto" value="{$produto['NR_SEQ_PRODUTO_PRRC']}"}
                {assign var="extensao" value="{$produto['DS_EXT_PRRC']}"}
                {assign var="foto_completa" value="{$foto}.{$extensao}"}
                
                {assign var="fotos" value=$this->fotoproduto($produto['NR_SEQ_PRODUTO_PRRC'])}
                {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
            <li class="rvb-product-item">
                {if $produto['NR_SEQ_TIPO_PRRC'] == 6}
                    {assign var=preTitle value='camiseta '}
                {else}
                    {assign var=preTitle value=''}
                {/if}

                {assign var=ds_produto_prrc value=' - '|explode:$produto['DS_PRODUTO_PRRC']}
                {assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}

                <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)}, "idproduto"=>{$produto['NR_SEQ_PRODUTO_PRRC']}], 'produto', TRUE)}" class="product-photo">
                    {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                        {*{assign var="foto_completa" value="{$this->createslug($produto['DS_PRODUTO_PRRC'])}-{$foto_produto}.{$extensao_produto}"}*}
                        <!-- Polyfill para imagens responsivas-->
                        <span data-picture data-alt="{$produto['DS_PRODUTO_PRRC']}" data-title="{$produto['DS_PRODUTO_PRRC']}">
                            {if $_isMobile neq 1}
                                <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, ' largura'=>220, 'altura'=>242,'imagem'=>$foto_completa],"imagem", TRUE)}"></span>
                            {else}
                                <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>140, 'altura'=>160, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>130, 'altura'=>150, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                                <!-- for hd displays -->
                                <span data-width="140" data-height="160" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>280, 'altura'=>320, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                                <span data-width="130" data-height="150" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>260, 'altura'=>300, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            {/if}

                            <noscript>
                                <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>160, 'altura'=>185, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$produto['DS_PRODUTO_PRRC']}" width="160" height="185">
                            </noscript>
                        </span>
                    {else}
                        <!-- Polyfill para imagens responsivas-->

                        <span data-picture data-alt="{$produto['DS_PRODUTO_PRRC']}" data-title="{$produto['DS_PRODUTO_PRRC']}">
                            {if $_isMobile neq 1}
                                <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>220, 'altura'=>242, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"></span>
                            {else}
                                <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>220, 'altura'=>242, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>130, 'altura'=>150, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                                <!-- for hd displays -->
                                <span data-width="140" data-height="160" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>280, 'altura'=>320, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                                <span data-width="130" data-height="150" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>260, 'altura'=>300, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px) and (-webkit-min-device-pixel-ratio: 2.0)"></span>
                            {/if}

                            <noscript>
                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>220, 'altura'=>242, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="Imagem não encontrada - Reverbcity" width="160" height="185">
                            </noscript>
                        </span>
                    {/if}

                {*{if $produto['DS_FRETEGRATIS_PRRC'] == 'S'}*}
                    {*<span class="rvb-tag sale-frete"></span>*}
                {*{elseif $produto['TP_DESTAQUE_PRRC'] == 1 and $produto['DS_FRETEGRATIS_PRRC'] == 'N'}*}
                    {*<span class="rvb-tag new"></span>*}
                {*{elseif $produto['TP_DESTAQUE_PRRC'] == 3}*}
                    {*<span class="rvb-tag reprint"></span>*}
                {*{elseif $produto['TP_DESTAQUE_PRRC'] == 2}*}
                    {*<span class="rvb-tag sale"></span>*}
                {*{else}*}
                {*{/if}*}
                </a>
                {*<h2 class="product-name">*}
                    {*{utf8_decode($produto->DS_PRODUTO_PRRC|truncate:18:"...":TRUE)}*}
                    {*<a href="{$this->url(["titulo"=>{$this->createslug($slug)}, "idproduto"=>{$produto['NR_SEQ_PRODUTO_PRRC']}], 'produto', TRUE)}">*}
                        {*{if $produto['NR_SEQ_TIPO_PRRC'] == 6}camiseta {/if}{$produto['DS_PRODUTO_PRRC']}*}
                    {*</a>*}
                {*</h2>*}
                {*{assign var=totalChar value=$produto['DS_PRODUTO_PRRC']|count_characters:true}*}
                {*{if $totalChar >= 22}*}
                    {*<span class="extends">...</span>*}
                {*{/if}*}
               {*<p class="price">*}
                   {*<a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)}, "idproduto"=>{$produto['NR_SEQ_PRODUTO_PRRC']}], 'produto', TRUE)}">*}
                    {*{if $produto['VL_PROMO_PRRC'] > 0}*}
                        {*<del>R$ {$produto['VL_PRODUTO_PRRC']|number_format:2:",":"."}</del>*}
                        {*Por R$ {$produto['VL_PROMO_PRRC']|number_format:2:",":"."}*}
                    {*{else}*}
                         {*R$ {$produto['VL_PRODUTO_PRRC']|number_format:2:",":"."} *}
                    {*{/if}*}
                   {*</a>*}
                {*</p>*}
                <div id="product-hidden">
                    <div class="list-product-details">
                        <h2 class="product-div-op">
                            <a href="{$this->url(["titulo"=>{$this->createslug($slug)}, "idproduto"=>{$produto['NR_SEQ_PRODUTO_PRRC']}], 'produto', TRUE)}">
                                {$produto['DS_PRODUTO_PRRC']|truncate:15:"...":TRUE}
                            </a>
                            <span class="preco">
                                    {if $produto['VL_PROMO_PRRC'] > 0}
                                        <del>R$ {$produto['VL_PRODUTO_PRRC']}  Por</del>
                                        R$ {$produto['VL_PROMO_PRRC']}
                                    {else}
                                        R$ {$produto['VL_PRODUTO_PRRC']}
                                    {/if}
                                        </span>
                        </h2>

                    </div>
                </div>

            </li>
            {/foreach}
            <li class="product-item">
                <div class="sex" style="">
                    <span><a rel="nofollow"  href="{$this->url([], 'masculino', TRUE)}">MASCULINO</a></span>
                </div>
            </li>
            <li class=" product-item">
                <div class="sex">
                    <span><a rel="nofollow"  href="{$this->url([], 'feminino', TRUE)}">FEMININO</a></span>
                </div>
            </li>
        </ul>

        {*<ul class="pagination">*}
             {*<ul class="pagination">*}
            {*{if $categoria_produto neq ""}*}

                {*{if $pages.previous}*}
                    {*<li class="item">*}
                        {*<a rel="nofollow" title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"index", "action"=>"inicio", "page"=>{$pages.previous}, "idcategoria"=>{$categoria_produto}], "inicio", TRUE)}">◄</a>*}
                    {*</li>*}
                {*{/if}*}
                {*{section name=page_loop start=$this->contadores->current_page-1 loop=$this->contadores->current_page+3 step=1}*}
                    {*{if $smarty.section.page_loop.index+1 == $this->contadores->current_page}*}
                        {*<li class="item">*}
                            {*<a rel="nofollow" href="{$this->url(["module"=>"default","controller"=>"index",  "action"=>"inicio", "page"=>$smarty.section.page_loop.index+1, "idcategoria"=>{$categoria_produto}], 'inicio', TRUE)}" class="active">*}
                                {*{$smarty.section.page_loop.index+1}*}
                            {*</a>*}
                        {*</li>*}
                    {*{else}*}
                        {*<li class="item">*}
                            {*<a rel="nofollow" href="{$this->url(["module"=>"default","controller"=>"index",  "action"=>"inicio", "page"=>$smarty.section.page_loop.index+1, "idcategoria"=>{$categoria_produto}], 'inicio', TRUE)}">*}
                                {*{$smarty.section.page_loop.index+1}*}
                            {*</a>*}
                        {*</li>*}
                    {*{/if}*}
                {*{/section}*}
                {*{if $pages.next}*}
                    {*<li class="item">*}
                        {*<a rel="nofollow" title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"index", "action"=>"inicio", "page"=>{$pages.next}, "idcategoria"=>{$categoria_produto}], "inicio", TRUE)}">►</a>*}
                    {*</li>*}
                {*{/if}*}

            {*{else}*}

                {*{if $pages.previous}*}
                    {*<li class="item">*}
                        {*<a rel="nofollow" title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"index", "action"=>"inicio", "page"=>{$pages.previous}], "inicio", TRUE)}">◄</a>*}
                    {*</li>*}
                {*{/if}*}
                {*{section name=page_loop start=$this->contadores->current_page-1 loop=$this->contadores->current_page+3 step=1}*}
                    {*{if $smarty.section.page_loop.index+1 == $this->contadores->current_page}*}
                        {*<li class="item">*}
                            {*<a rel="nofollow" href="{$this->url(["module"=>"default","controller"=>"index",  "action"=>"inicio", "page"=>$smarty.section.page_loop.index+1], 'inicio', TRUE)}" class="active">*}
                                {*{$smarty.section.page_loop.index+1}*}
                            {*</a>*}
                        {*</li>*}
                    {*{else}*}
                        {*{if $pages.next && $pages.last >= $smarty.section.page_loop.index+1}*}
                        {*<li class="item">*}
                            {*<a rel="nofollow" href="{$this->url(["module"=>"default","controller"=>"index",  "action"=>"inicio", "page"=>$smarty.section.page_loop.index+1], 'inicio', TRUE)}">*}
                                {*{$smarty.section.page_loop.index+1}*}
                            {*</a>*}
                        {*</li>*}
                        {*{/if}*}
                    {*{/if}*}
                {*{/section}*}
                {*{if $pages.next}*}
                    {*<li class="item">*}
                        {*<a rel="nofollow" title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"index", "action"=>"inicio", "page"=>{$pages.next}], "inicio", TRUE)}">►</a>*}
                    {*</li>*}
                {*{/if}*}

            {*{/if}*}
        {*</ul>*}
    </div>

    {*<div class="rvb-column right">*}
      {*{include file="sidebar-default.tpl"}*}
    {*</div>*}
</section>

<div class="banners-advertisement cycle-slideshow"
     data-cycle-fx="fadeout"
     data-cycle-timeout="5000"
     data-cycle-slides="> a"
     data-cycle-log="false"
     data-cycle-pause-on-hover="true">
    {foreach from=$banners item=banner}
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

{if $produto->NR_SEQ_TIPO_PRRC == 6}
    {assign var=preTitle value='Camiseta '}
{else}
    {assign var=preTitle value=''}
{/if}
{assign var=ds_produto_prrc value=' - '|explode:$produto->DS_PRODUTO_PRRC}

<div id="wrap-produtos">

    <div id="prod-detalhe">
        <header class="row-fluid">
            <h2 class="rvb-title">Reverb<strong>loja</strong></h2>

            <span class="breadcrumb">
                <div style="float: left;" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="{$this->url(["tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}], 'todos-produtos', TRUE)}"><h2 itemprop="title" class="item-breadcumb">{$tipo['DS_CATEGORIA_PTRC']}</h2></a> ></div>
                <div style="float: left;" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" itemprop="title" href="{$this->url(["tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}, "categoria"=>{$categoria['NR_SEQ_CATEGPRO_PCRC']}], 'todos-produtos', TRUE)}"><h2 itemprop="title" class="item-breadcumb">{$categoria['DS_CATEGORIA_PCRC']}</h2></a> > </div>
                        {if $genero_produto eq 'M'}
                    <div style="float: left;" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" itemprop="title" href="{$this->url(["tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}, "categoria"=>{$categoria['NR_SEQ_CATEGPRO_PCRC']}, "genero"=>"masculino"], 'todos-produtos', TRUE)}"><h2 itemprop="title" class="item-breadcumb">Masculinas</h2></a> > </div>
                    <div style="float: left;" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a rel="nofollow" itemprop="url" itemprop="title" href="{$this->url(["tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}, "categoria"=>{$categoria['NR_SEQ_CATEGPRO_PCRC']}, "genero"=>"masculino", "cor"=>{$cor['idcor']}], 'todos-produtos', TRUE)}"><h2 itemprop="title" class="item-breadcumb">{$cor['cor']}</h2></a> ></div>
                        {elseif $genero_produto eq "F"}
                    <div style="float: left;" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" itemprop="title" href="{$this->url(["tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}, "categoria"=>{$categoria['NR_SEQ_CATEGPRO_PCRC']}, "genero"=>"feminino"], 'todos-produtos', TRUE)}"><h2 itemprop="title" class="item-breadcumb">Femininas</h2></a> > </div>
                    <div style="float: left;" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a rel="nofollow" itemprop="url" itemprop="title" href="{$this->url(["tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}, "categoria"=>{$categoria['NR_SEQ_CATEGPRO_PCRC']}, "genero"=>"feminino", "cor"=>{$cor['idcor']}], 'todos-produtos', TRUE)}"><h2 itemprop="title" class="item-breadcumb">{$cor['cor']}</h2></a> ></div>
                        {/if}

                <b>{$preTitle}{$produto->DS_PRODUTO_PRRC}
                    {if $produto->DS_FRETEGRATIS_PRRC == 'S'}
                        - Frete Grátis 
                    {/if}
                </b>
            </span>
        </header>

        <section class="row-fluid" id="detalhe-produto">

            <div class="span9 images">
                {assign var="foto" value="{$produto->NR_SEQ_PRODUTO_PRRC}"}
                {assign var="extensao" value="{$produto->DS_EXT_PRRC}"}
                {assign var="foto_completa" value="{$foto}.{$extensao}"}

                {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}

                {if !file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                    {assign var="foto_produto" value="{$fotos[1]['NR_SEQ_FOTO_FORC']}"}
                    {assign var="extensao_produto" value="{$fotos[1]['DS_EXT_FORC']}"}
                    {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
                {/if}

                <div class="image span13">
                    {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                        <img itemprop="image"  src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>443, 'altura'=>494, 'imagem'=>$foto_completa],"imagem", TRUE)}" id="zoom_01" data-zoom-image="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>886, 'altura'=>988, 'imagem'=>$foto_completa],"imagem", TRUE)}" title="{$preTitle}{$produto->DS_PRODUTO_PRRC}" alt="{$preTitle}{$produto->DS_PRODUTO_PRRC}" max-height="100%"/>
                    {else}
                        <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>443, 'altura'=>494, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" id="zoom_01" data-zoom-image="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>886, 'altura'=>988, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}" max-height="100%"/>
                    {/if}
                </div>

                <div id="thumbnails-carousel" class="span3">

                    <a title="mostrar imagens anteriores" class="shifted-in ctrl-thumb-carousel" id="moveprev" rel="nofollow">
                        Exibir as imagens anteriores
                    </a>

                    <div id="hide-thumbnails" class="carousel">

                        <ul class="thumbnails" id="prod-thumbnails-list">


                            {foreach from=$fotos item=foto}
                                {assign var="foto_produto" value="{$foto['NR_SEQ_FOTO_FORC']}"}
                                {assign var="extensao_produto" value="{$foto['DS_EXT_FORC']}"}
                                {assign var="foto_completa_produto" value="{$foto_produto}.{$extensao_produto}"}
                                <li class="prod-thumbnails-items">
                                    {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa_produto")}
                                        {assign var="foto_completa_produto" value="{$this->createslug($produto->DS_PRODUTO_PRRC)}-{$foto_produto}.{$extensao_produto}"}
                                        <a href="#" data-image="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>443, 'altura'=>494, 'imagem'=>$foto_completa_produto], "imagem", TRUE)}" data-zoom-image="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>886, 'altura'=>988, 'imagem'=>$foto_completa_produto], "imagem", TRUE)}" title="{$produto->DS_PRODUTO_PRRC}" >
                                            <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>60, 'altura'=>70, 'imagem'=>$foto_completa_produto], "imagem", TRUE)}" alt="{$preTitle}{$produto->DS_PRODUTO_PRRC}" title="{$preTitle}{$produto->DS_PRODUTO_PRRC}"/>
                                        </a>
                                    {else}
                                        <a href="#" rel="nofollow" data-image="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>443, 'altura'=>494, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" data-zoom-image="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>886, 'altura'=>988, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" title="{$produto->DS_PRODUTO_PRRC}" >
                                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>60, 'altura'=>70, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}" title="{$produto->DS_PRODUTO_PRRC}"/>
                                        </a>
                                    {/if}
                                </li>
                            {/foreach}
                        </ul>
                    </div>

                    <a title="mostrar as proximas imagens" class="shifted-in ctrl-thumb-carousel" id="movenext" rel="nofollow">
                        Exibir as proximas imagens
                    </a>
                </div>

                <div class="btn-group btn-store show-768 shifted-out">
                    <!-- <button class="btn btn-large dropdown-toggle" data-toggle="dropdown">Reverb<span>loja</span></button>

                    <button class="btn btn-large dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>

                    <ul class="dropdown-menu">
                    {for $dropitem=0 to 15}
                    <li>
                        <a href="#rotaParaCategoria{$dropitem}">Lorem ipsum dolor - {$dropitem} </a>
                    </li>
                    {/for}
                </ul> -->
                </div>
            </div>

            <div class="span5 description"  itemscope itemtype="http://schema.org/Product">
                <meta itemprop="image" content="https://www.reverbcity.com{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>443, 'altura'=>494, 'imagem'=>$foto_completa],"imagem", TRUE)}" >

                <form action="#actionPraComprar" method="">

                    <div id="heading-details-product" class="heading-details-products">
                        <h1 itemprop="name">{$preTitle} {$produto->DS_PRODUTO_PRRC}</h1>
                        <img itemprop="image" style="display:none;" src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>443, 'altura'=>494, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}"/>
                        <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" style="display: none;">
                            Rated <span itemprop="ratingValue">{if $nota['soma_notas'] >= 1}{$nota['soma_notas']}{else}5{/if}</span>/{$nota['total_voto'] + 23} based on <span itemprop="ratingCount">{$nota['total_voto'] + 23}</span> reviews
                        </div>
                        {if $_logado neq 1}
                            <div id="score" data-logado="false" data-score="{$nota['soma_notas']}"></div>
                        {else}
                            <div id="score" data-logado="true" data-idproduto="{$produto->NR_SEQ_PRODUTO_PRRC}" data-score="{$nota['soma_notas']}"></div>
                        {/if}


                        {*<script>*}
                        {*(function(d, s, id) {*}
                        {*var js, fjs = d.getElementsByTagName(s)[0];*}
                        {*if (d.getElementById(id)) return;*}
                        {*js = d.createElement(s); js.id = id;*}
                        {*js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=237745386316222";*}
                        {*fjs.parentNode.insertBefore(js, fjs);*}
                        {*}(document, 'script', 'facebook-jssdk'));*}
                        {*</script>*}


                        {*<div class="share-buttons">*}
                        {*<ul>*}
                        {*<li class="fb-like-count-box">*}
                        {*<div class="fb-like" data-href="{$_pagina_atual}" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>*}
                        {*</li>*}

                        {*<li class="fb-share-count-box">*}
                        {*<div class="fb-share-button" data-href="{$_pagina_atual}" data-type="button"></div>*}
                        {*</li>*}

                        {*<li class="pinit-box">*}
                        {*<a href="//pinterest.com/pin/create/button/" data-pin-do="buttonBookmark">*}
                        {*</a>*}
                        {*</li>*}

                        {*<li class="tweet-button">*}
                        {*<a href="https://twitter.com/share" data-lang="en" class="twitter-share-button"></a>*}
                        {*</li>*}

                        {*<li class="g-button">*}
                        {*<div class="g-plusone" data-size="medium" data-annotation="none"></div>*}
                        {*</li>*}

                        {*<li class="email-indique">*}
                        {*<a href="#" data-modal="indique-lightbox" class="md-trigger">*}
                        {*</a>*}
                        {*</li>*}

                        {*</ul>*}
                        {*</div>*}
                        {*<script async src="https://assets.pinterest.com/js/pinit.js"></script>*}
                        {*<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>*}



                        {*<div class="share-buttons">
                        <div id="share-social">
                        <label for="share-checkbox" class="label entypo-export">Compartilhar</label>
                        <div class="social">
                        <ul>
                        <li class="entypo-facebook">
                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http://www.google.com"></a>
                        </li>
                        <li class="entypo-twitter">
                        <a target="_blank" href="http://twitter.com/home?status=Olha%20essa%20camisa%20da%20@Reverbcity"></a>
                        </li>
                        <li class="entypo-gplus">
                        <a target="_blank" href="https://plus.google.com/share?url=http://www.google.com"></a>
                        </li>
                        <li class="entypo-pinterest">
                        <a target="_blank" href="#"></a>
                        </li>
                        <li class="entypo-email">
                        <a target="_blank" href="#" data-modal="indique-lightbox" class="md-trigger"></a>
                        </li>
                        </ul>
                        </div>
                        </div>

                        <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button" data-action="like" data-show-faces="false" data-share="false" data-width="47"></div>
                        </div>*}

                        <div class="details-product-heading">
                            <p>{utf8_decode($produto->DS_INFORMACOES_PRRC|strip_tags)}</p>
                        </div>

                        <label id="trigger-detail" for="opendetail" title="clique para vizualizar o texto completo da descrição ">
                            [ + info sobre {$preTitle|lower}{$ds_produto_prrc[0]|lower} ]
                        </label>
                    </div>

                    <div class="sizes">

                        <div class="content">
                            <span class="escolha-tamanho">CLIQUE NO TAMANHO PARA COMPRAR</span>
                            {if $estoques_geral|count > 0}
                                <div class="both">
                                    <div class="title" itemscope itemprop="offers" itemtype="http://data-vocabulary.org/Offer">
                                        {*Tamanho Único*}
                                        <span class="price heavy" style="font-size: 15px;">

                                            {if $produto->VL_PROMO_PRRC > 0}
                                                <del>R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</del>
                                                Por R$ <span itemprop="price">{$produto->VL_PROMO_PRRC|number_format:2:",":"."}</span>
                                            {else}
                                                R$ <span itemprop="price">{$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</span>
                                            {/if}
                                        </span>

                                        <span style="font-size: 11px;">
                                            {if $produto->VL_PROMO_PRRC > 0}
                                                {if $produto->VL_PROMO_PRRC >= 50 AND $produto->VL_PROMO_PRRC < 100}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/2}
                                                    <br/>Ou 2x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {elseif $produto->VL_PROMO_PRRC >= 100 and $produto->VL_PROMO_PRRC < 150}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/3}
                                                    <br/>Ou 3x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {elseif $produto->VL_PROMO_PRRC >= 150}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/4}
                                                    <br/>Ou 4x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {/if}
                                            {else}
                                                {if $produto->VL_PRODUTO_PRRC >= 50 AND $produto->VL_PRODUTO_PRRC <= 100}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/2}
                                                    Ou 2x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {elseif $produto->VL_PRODUTO_PRRC >= 100 and $produto->VL_PRODUTO_PRRC < 150}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/3}
                                                    Ou 3x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {elseif $produto->VL_PRODUTO_PRRC >= 150}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/4}
                                                    Ou 4x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {/if}
                                            {/if}
                                        </span>

                                        <meta itemprop="priceCurrency" content="BRL" />

                                    </div>
                                    <ul class="size-list unisex">
                                        {foreach from=$estoques_geral item=estoque}
                                            {assign var=tamanho value="-"|explode:$estoque->DS_SIGLA_TARC}

                                            {if $estoque->NR_SEQ_TAMANHO_TARC eq 11}
                                                <li class="one-size">
                                                    {if $estoque->NR_QTDE_ESRC eq 1}
                                                        <a rel="nofollow" href="{$this->url(["idproduto"=>{$estoque->NR_SEQ_PRODUTO_ESRC}, "idestoque"=>{$estoque->NR_SEQ_ESTOQUE_ESRC},"tamanho"=>{$estoque->NR_SEQ_TAMANHO_ESRC}, "genero"=>"u"], 'adicionarcarrinho', TRUE)}" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                            {$tamanho[0]} {$tamanho[1]}
                                                            <span class="resta">resta 1</span>
                                                        </a>

                                                    {elseif $estoque->NR_QTDE_ESRC eq 0}
                                                        <a rel="nofollow" href="#" title="Tamanho {$estoque->DS_SIGLA_TARC}" data-modal="avise-lightbox" class="btn inactive md-trigger" data-idtamanho="{$estoque->NR_SEQ_TAMANHO_ESRC}">
                                                            {$tamanho[0]} {$tamanho[1]}
                                                            <span class="resta" >avise-me</span>
                                                        </a>
                                                    {else}
                                                        <a rel="nofollow" href="{$this->url(["idproduto"=>{$estoque->NR_SEQ_PRODUTO_ESRC}, "idestoque"=>{$estoque->NR_SEQ_ESTOQUE_ESRC}, "tamanho"=>{$estoque->NR_SEQ_TAMANHO_ESRC}, "genero"=>"u"], 'adicionarcarrinho', TRUE)}" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                            {$tamanho[0]} {$tamanho[1]}
                                                        </a>
                                                    {/if}
                                                </li>
                                            {else}
                                                <li>
                                                    {if $estoque->NR_QTDE_ESRC eq 1}
                                                        <a rel="nofollow" href="{$this->url(["idproduto"=>{$estoque->NR_SEQ_PRODUTO_ESRC}, "idestoque"=>{$estoque->NR_SEQ_ESTOQUE_ESRC},"tamanho"=>{$estoque->NR_SEQ_TAMANHO_ESRC}, "genero"=>"u"], 'adicionarcarrinho', TRUE)}" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                            {$tamanho[0]} {$tamanho[1]}
                                                            <span class="resta">resta 1</span>
                                                        </a>

                                                    {elseif $estoque->NR_QTDE_ESRC le 0}
                                                        <a rel="nofollow" href="#" title="Tamanho {$estoque->DS_SIGLA_TARC}" data-modal="avise-lightbox" class="btn inactive md-trigger" data-idtamanho="{$estoque->NR_SEQ_TAMANHO_ESRC}">
                                                            {$tamanho[0]} {$tamanho[1]}
                                                            <span class="resta" >avise-me</span>
                                                        </a>
                                                    {else}
                                                        <a rel="nofollow" href="{$this->url(["idproduto"=>{$estoque->NR_SEQ_PRODUTO_ESRC}, "idestoque"=>{$estoque->NR_SEQ_ESTOQUE_ESRC}, "tamanho"=>{$estoque->NR_SEQ_TAMANHO_ESRC}, "genero"=>"u"], 'adicionarcarrinho', TRUE)}" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                            {$tamanho[0]} {$tamanho[1]}
                                                            {if $produto->VL_PROMO_M_PRRC > 0 AND ($estoque->NR_SEQ_TAMANHO_ESRC == 3 or $estoque->NR_SEQ_TAMANHO_ESRC == 8)}
                                                                <span class="resta" >R$ {$produto->VL_PROMO_M_PRRC|number_format:2:",":"."}</span>
                                                            {/if}

                                                            {if $produto->VL_PROMO_XGL_PRRC > 0 AND ($estoque->NR_SEQ_TAMANHO_ESRC == 33 or $estoque->NR_SEQ_TAMANHO_ESRC == 47)}
                                                                <span class="resta" >R$ {$produto->VL_PROMO_XGL_PRRC|number_format:2:",":"."}</span>
                                                            {/if}
                                                        </a>
                                                    {/if}
                                                </li>
                                            {/if}
                                        {/foreach}
                                    </ul>
                                </div>
                            {/if}
                            {if $estoques_masculino|count > 0}
                                <div class="both" >
                                    <div class="title" itemscope itemprop="offers" itemtype="http://schema.org/Offer">
                                        {*Masculino*}
                                        <span class="price heavy" style="font-size:  15px;">
                                            {if $produto->VL_PROMO_PRRC > 0}
                                                <del>R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</del>
                                                Por R$ <span itemprop="price">{$produto->VL_PROMO_PRRC|number_format:2:",":"."}</span>
                                            {else}
                                                R$ <span itemprop="price">{$produto->VL_PRODUTO_PRRC|number_format:2:",":"."} </span>
                                            {/if}</span>

                                        <span style="font-size: 11px;">
                                            {if $produto->VL_PROMO_PRRC > 0}
                                                {if $produto->VL_PROMO_PRRC >= 50 AND $produto->VL_PROMO_PRRC < 100}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/2}
                                                    <br/>Ou 2x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {elseif $produto->VL_PROMO_PRRC >= 100 and $produto->VL_PROMO_PRRC < 150}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/3}
                                                    <br/>Ou 3x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {elseif $produto->VL_PROMO_PRRC >= 150}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/4}
                                                    <br/>Ou 4x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {/if}
                                            {else}
                                                {if $produto->VL_PRODUTO_PRRC >= 50 AND $produto->VL_PRODUTO_PRRC <= 100}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/2}
                                                    Ou 2x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {elseif $produto->VL_PRODUTO_PRRC >= 100 and $produto->VL_PRODUTO_PRRC < 150}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/3}
                                                    Ou 3x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {elseif $produto->VL_PRODUTO_PRRC >= 150}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/4}
                                                    Ou 4x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {/if}
                                            {/if}
                                        </span>

                                        <meta itemprop="priceCurrency" content="BRL" />
                                    </div>

                                    <span class="icon male"></span>

                                    <ul class="size-list">
                                        {foreach from=$estoques_masculino item=estoque}
                                            <li>
                                                {if $estoque->NR_QTDE_ESRC eq 1}
                                                    <a rel="nofollow" href="{$this->url(["idproduto"=>{$estoque->NR_SEQ_PRODUTO_ESRC}, "idestoque"=>{$estoque->NR_SEQ_ESTOQUE_ESRC}, "tamanho"=>{$estoque->NR_SEQ_TAMANHO_ESRC}, "genero"=>"m"], 'adicionarcarrinho', TRUE)}" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                        {$estoque->DS_SIGLA_TARC}
                                                        <span class="resta">resta 1</span>
                                                    </a>
                                                {elseif $estoque->NR_QTDE_ESRC le 0}
                                                    <a rel="nofollow" href="#" class="btn inactive md-trigger" data-modal="avise-lightbox" title="Tamanho {$estoque->DS_SIGLA_TARC}" data-idtamanho="{$estoque->NR_SEQ_TAMANHO_ESRC}">
                                                        {$estoque->DS_SIGLA_TARC}
                                                        <span class="resta" >avise-me</span>
                                                    </a>
                                                {else}
                                                    <a rel="nofollow" href="{$this->url(["idproduto"=>{$estoque->NR_SEQ_PRODUTO_ESRC}, "idestoque"=>{$estoque->NR_SEQ_ESTOQUE_ESRC}, "tamanho"=>{$estoque->NR_SEQ_TAMANHO_ESRC}, "genero"=>"m"], 'adicionarcarrinho', TRUE)}" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                        {$estoque->DS_SIGLA_TARC}
                                                        {if $produto->VL_PROMO_M_PRRC > 0 AND ($estoque->NR_SEQ_TAMANHO_ESRC == 3 or $estoque->NR_SEQ_TAMANHO_ESRC == 8)}
                                                            <span class="resta" >R$ {$produto->VL_PROMO_M_PRRC|number_format:2:",":"."}</span>
                                                        {/if}

                                                        {if $produto->VL_PROMO_XGL_PRRC > 0 AND ($estoque->NR_SEQ_TAMANHO_ESRC == 33 or $estoque->NR_SEQ_TAMANHO_ESRC == 47)}
                                                            <span class="resta" >R$ {$produto->VL_PROMO_XGL_PRRC|number_format:2:",":"."}</span>
                                                        {/if}
                                                    </a>
                                                {/if}

                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                            {/if}
                            {if $estoques_feminino|count > 0}
                                <div class="both">
                                    <div class="title" itemscope="" itemprop="offers" itemtype="http://schema.org/Offer">
                                        {*Feminino *}
                                        <span class="price heavy" style="font-size: 15px;">
                                            {if $produto->VL_PROMO_PRRC > 0}
                                                <del>R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</del>
                                                Por R$ <span itemprop="price">{$produto->VL_PROMO_PRRC|number_format:2:",":"."}</span>
                                            {else}
                                                R$ <span itemprop="price">{$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</span>
                                            {/if}</span>

                                        <span style="font-size: 11px;">
                                            {if $produto->VL_PROMO_PRRC > 0}
                                                {if $produto->VL_PROMO_PRRC >= 50 AND $produto->VL_PROMO_PRRC < 100}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/2}
                                                    <br />Ou 2x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {elseif $produto->VL_PROMO_PRRC >= 100 and $produto->VL_PROMO_PRRC < 150}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/3}
                                                    <br />Ou 3x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {elseif $produto->VL_PROMO_PRRC >= 150}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/4}
                                                    <br />Ou 4x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {/if}
                                            {else}
                                                {if $produto->VL_PRODUTO_PRRC >= 50 AND $produto->VL_PRODUTO_PRRC <= 100}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/2}
                                                    Ou 2x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {elseif $produto->VL_PRODUTO_PRRC >= 100 and $produto->VL_PRODUTO_PRRC < 150}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/3}
                                                    Ou 3x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {elseif $produto->VL_PRODUTO_PRRC >= 150}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/4}
                                                    Ou 4x de <span class="heavy">R$ {$parcela|number_format:2:",":"."}</span>
                                                {/if}
                                            {/if}
                                        </span>

                                        <meta itemprop="priceCurrency" content="BRL" />
                                    </div>

                                    <span class="icon female"></span>

                                    <ul class="size-list">
                                        {foreach from=$estoques_feminino item=estoque}

                                            <li>
                                                {if $estoque->NR_QTDE_ESRC eq 1}
                                                    <a rel="nofollow" href="{$this->url(["idproduto"=>{$estoque->NR_SEQ_PRODUTO_ESRC},  "idestoque"=>{$estoque->NR_SEQ_ESTOQUE_ESRC},"tamanho"=>{$estoque->NR_SEQ_TAMANHO_ESRC}, "genero"=>"f"], 'adicionarcarrinho', TRUE)}" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                        {$estoque->DS_SIGLA_TARC}
                                                        <span class="resta">resta 1</span>
                                                    </a>

                                                {elseif $estoque->NR_QTDE_ESRC le 0}
                                                    <a rel="nofollow" href="#" class="btn inactive md-trigger" data-modal="avise-lightbox" title="Tamanho {$estoque->DS_SIGLA_TARC}" data-idtamanho="{$estoque->NR_SEQ_TAMANHO_ESRC}">
                                                        {$estoque->DS_SIGLA_TARC}
                                                        <span class="resta">avise-me</span>
                                                    </a>
                                                {else}
                                                    <a rel="nofollow" href="{$this->url(["idproduto"=>{$estoque->NR_SEQ_PRODUTO_ESRC},  "idestoque"=>{$estoque->NR_SEQ_ESTOQUE_ESRC},"tamanho"=>{$estoque->NR_SEQ_TAMANHO_ESRC}, "genero"=>"f"], 'adicionarcarrinho', TRUE)}" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                        {$estoque->DS_SIGLA_TARC}
                                                        {if $produto->VL_PROMO_M_PRRC > 0 AND ($estoque->NR_SEQ_TAMANHO_ESRC == 3 or $estoque->NR_SEQ_TAMANHO_ESRC == 8)}
                                                            <span class="resta" >R$ {$produto->VL_PROMO_M_PRRC|number_format:2:",":"."}</span>
                                                        {/if}

                                                        {if $produto->VL_PROMO_XGL_PRRC > 0 AND ($estoque->NR_SEQ_TAMANHO_ESRC == 33 or $estoque->NR_SEQ_TAMANHO_ESRC == 47)}
                                                            <span class="resta" >R$ {$produto->VL_PROMO_XGL_PRRC|number_format:2:",":"."}</span>
                                                        {/if}
                                                    </a>
                                                {/if}
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                            {/if}
                        </div>
                    </div>

                    <div class="btns">
                        <div class="left">
                            {if $_logado eq 1}
                                <a rel="nofollow" href="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], "calculaindividual", TRUE)}" data-logado="true" class="btn btn-block calcula-frete">{if $frete eq ""}Calcule o frete{else}{$frete}{/if}</a>

                                <a rel="nofollow" href="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], "calculaindividual", TRUE)}" data-logado="true" class="btn btn-block calcula-prazo">Prazo de entrega</a>
                            {else}
                                <a rel="nofollow" href="#" data-logado="false" class="btn btn-block calcula-frete">Calcule o frete</a>

                                <a rel="nofollow" href="#" data-logado="false" class="btn btn-block calcula-prazo">Prazo de entrega</a>
                            {/if}

                            <a rel="nofollow" href="#" id="troca-btn" class="btn btn-block">Trocas</a>

                            <div class="troca">

                                <p>

                                    A Reverbcity garante a troca de qualquer um de seus produtos, sem ônus para o cliente, caso seja constatado defeito na peça. Se o cliente quiser trocar uma peça (sem uso) por qualquer outro motivo, ele deverá cobrir despesas de frete.

                                </p>
                                <br>
                                <a rel="nofollow" href="{$this->url([], "contato", TRUE)}" id="fale-conosco"><strong>Clique aqui</strong></a> em fale conosco.

                            </div>

                        </div>

                        <div class="right">
                            <a rel="nofollow" href="#" id="show-sizes" data-idproduto="{$produto->NR_SEQ_PRODUTO_PRRC}" data-modal="medidas-lightbox" class="md-trigger btn btn-primary btn-block btn-sizes"><!-- <span class="icon sizes"></span> -->
                                <span class="content">Tabela de Medidas</span>
                            </a>

                            <a rel="nofollow" href="{$this->url(["produto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'adicionawishlist', TRUE)}" class="btn btn-red btn-block btn-list"><!-- <span class="icon ok"></span>  --><span class="content">Adicionar a <br> lista de desejos</span></a>

                            <a rel="nofollow" href="" class="btn btn-block md-trigger" data-modal="avise-lightbox">AVISE-ME</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <div class="row other-products">
        {assign var="max_visitados" value="{$_visitados|count}"}
        {if $max_visitados le 0}
            {assign var="max" value="4"}
            {assign var="visitado" value="0"}
        {/if}

        {if $max_visitados eq 1}
            {assign var="max" value="3"}
            {assign var="visitado" value="1"}
        {/if}

        {if $max_visitados ge 2}
            {assign var="max" value="2"}
            {assign var="visitado" value="2"}
        {/if}

        {if $currentAction eq "produtolojista"}
            {assign var="acao" value="produtolojista"}
        {else}
            {assign var="acao" value="produto"}
        {/if}

        <div class="sidebar-bottom clearfix">
            <!-- Sugestoes -->
            {if $sugestoes|count > 0}
                <div class="category-item suggestions items-{$max}">
                    <p class="title-category">Sugestões</p>
                    <ul class="list-of-products">
                        {foreach from=$sugestoes item=sugestao}
                            {assign var="foto" value="{$sugestao['NR_SEQ_PRODUTO_PRRC']}"}
                            {assign var="extensao" value="{$sugestao['DS_EXT_PRRC']}"}
                            {assign var="foto_completa" value="{$foto}.{$extensao}"}

                            {assign var="fotos" value=$this->fotoproduto($sugestao->NR_SEQ_PRODUTO_PRRC)}
                            {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                            {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                            {assign var="foto_completa_dia" value="{$foto_produto}.{$extensao_produto}"}

                            {if !file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                                {assign var="foto_produto" value="{$fotos[1]['NR_SEQ_FOTO_FORC']}"}
                                {assign var="extensao_produto" value="{$fotos[1]['DS_EXT_FORC']}"}
                                {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
                            {/if}

                            {if $sugestao->NR_SEQ_TIPO_PRRC == 6}
                                {assign var=preTitle value='Camiseta '}
                            {else}
                                {assign var=preTitle value=''}
                            {/if}
                            {assign var=ds_produto_prrc value=' - '|explode:$sugestao->DS_PRODUTO_PRRC}
                            {assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}

                            {if $sugestao@iteration > $max}
                                {break}
                            {/if}
                            <li class="product-item">
                                <a rel="nofollow" class="thumb" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$sugestao->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">
                                    {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                                        <!-- Polyfill para imagens responsivas-->
                                        <span data-picture data-alt="{$sugestao->DS_PRODUTO_PRRC}">
                                            <!--imagem padrão-->
                                            <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}"></span>
                                            <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                                            <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                            <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                                            <!-- for hd displays -->
                                            <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                            <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                                            <noscript>
                                            <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$sugestao->DS_PRODUTO_PRRC}">
                                            </noscript>
                                        </span>
                                    {else}
                                        <!-- Polyfill para imagens responsivas-->
                                        <span data-picture data-alt="{$sugestao->DS_PRODUTO_PRRC}">
                                            <!--imagem padrão-->
                                            <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"></span>
                                            <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                                            <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                            <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                                            <!-- for hd displays -->
                                            <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                            <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                                            <noscript>
                                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{$sugestao->DS_PRODUTO_PRRC}">
                                            </noscript>
                                        </span>
                                    {/if}

                                </a>
                                <p class="product-title">
                                    <a href="{$this->url(["titulo"=>{$this->createslug($slug)}, "idproduto"=>{$sugestao->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">{$sugestao->DS_PRODUTO_PRRC}</a>
                                </p>
                                <p class="product-price">
                                    {if $sugestao->VL_PROMO_PRRC != 0}
                                        <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)}, "idproduto"=>{$sugestao->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">R$ {$sugestao->VL_PROMO_PRRC|number_format:2:",":"."}</a>
                                    {else}
                                        <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)}, "idproduto"=>{$sugestao->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">R$ {$sugestao->VL_PRODUTO_PRRC|number_format:2:",":"."}</a>
                                    {/if}
                                </p>
                            </li>
                        {/foreach}
                    </ul>

                </div>
            {/if}
            {if $_visitados|count > 0}
                <div class="category-item visited items-{$visitado}">
                    <p class="title-category">Produtos vistos</p>
                    <ul class="list-of-products">
                    {capture}{$_visitados|@shuffle}{/capture}

                    {foreach from=$_visitados item=visitado}

                        {assign var="foto" value="{$visitado['codigo']}"}
                        {assign var="extensao" value="{$visitado['path']}"}
                        {assign var="foto_completa" value="{$foto}.{$extensao}"}
                        {assign var="max" value="2"}

                        {assign var="fotos" value=$this->fotoproduto($visitado['codigo'])}
                        {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                        {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                        {assign var="foto_completa_dia" value="{$foto_produto}.{$extensao_produto}"}

                        {if !file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                            {assign var="foto_produto" value="{$fotos[1]['NR_SEQ_FOTO_FORC']}"}
                            {assign var="extensao_produto" value="{$fotos[1]['DS_EXT_FORC']}"}
                            {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
                        {/if}

                        {if $visitado['tipo'] == 6}
                            {assign var=preTitle value='Camiseta '}
                        {else}
                            {assign var=preTitle value=''}
                        {/if}
                        {assign var=ds_produto_prrc value=' - '|explode:$visitado['nome']}
                        {assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}

                        {if $visitado@iteration > $max}
                            {break}
                        {/if}
                        <li class="product-item">
                            <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$visitado['codigo']}], {$acao}, TRUE)}" class="thumb">
                                {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                                    <!-- Polyfill para imagens responsivas-->
                                    <span data-picture data-alt="{$visitado['nome']}">
                                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}"></span>
                                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                        <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                                        <!-- for hd displays -->
                                        <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                        <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                                        <noscript>
                                        <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$visitado['nome']}">
                                        </noscript>
                                    </span>
                                {else}
                                    <!-- Polyfill para imagens responsivas-->
                                    <span data-picture data-alt="{$visitado['nome']}">
                                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"></span>
                                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                        <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                                        <!-- for hd displays -->
                                        <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                        <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                                        <noscript>
                                        <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{$visitado['nome']}">
                                        </noscript>
                                    </span>
                                {/if}
                            </a>
                            <p class="product-title">
                                <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$visitado['codigo']}], {$acao}, TRUE)}">{utf8_decode($visitado['nome'])}</a>
                            </p>
                            <p class="product-price">
                                {if $visitado['promo'] != 0}
                                    <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$visitado['codigo']}], {$acao}, TRUE)}">R$ {$visitado['promo']|number_format:2:",":"."}</a>
                                {else}
                                    <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$visitado['codigo']}], {$acao}, TRUE)}">R$ {$visitado['valor']|number_format:2:",":"."}</a>
                                {/if}
                            </p>
                        </li>
                    {/foreach}
                </ul>
            </div>
        {/if}

        <div class="category-item day">
            <p class="title-category black">Produto do dia</p>
            <ul class="list-of-products">
                {assign var="foto" value="{$_produto_dia->NR_SEQ_PRODUTO_PRRC}"}
                {assign var="extensao" value="{$_produto_dia->DS_EXT_PRRC}"}
                {assign var="foto_completa_dia" value="{$foto}.{$extensao}"}

                {assign var="fotos" value=$this->fotoproduto($_produto_dia->NR_SEQ_PRODUTO_PRRC)}
                {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                {assign var="foto_completa_dia" value="{$foto_produto}.{$extensao_produto}"}

                {if !file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                    {assign var="foto_produto" value="{$fotos[1]['NR_SEQ_FOTO_FORC']}"}
                    {assign var="extensao_produto" value="{$fotos[1]['DS_EXT_FORC']}"}
                    {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
                {/if}

                {if $_produto_dia->NR_SEQ_TIPO_PRRC == 6}
                    {assign var=preTitle value='Camiseta '}
                {else}
                    {assign var=preTitle value=''}
                {/if}
                {assign var=ds_produto_prrc value=' - '|explode:$_produto_dia->DS_PRODUTO_PRRC}
                {assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}

                <li class="product-item last">
                    <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}" class="thumb">
                        {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa_dia")}
                            <!-- Polyfill para imagens responsivas-->
                            <span data-picture data-alt="{utf8_decode($_produto_dia->DS_PRODUTO_PRRC)}">
                                <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}"></span>
                                <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>164, 'altura'=>182, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                                <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                                <!-- for hd displays -->
                                <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                                <noscript>
                                <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa_dia],"imagem", TRUE)}" alt="{utf8_decode($_produto_dia->DS_PRODUTO_PRRC)}">
                                </noscript>
                            </span>
                        {else}
                            <!-- Polyfill para imagens responsivas-->
                            <span data-picture data-alt="{utf8_decode($_produto_dia->DS_PRODUTO_PRRC)}">
                                <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"></span>
                                <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>164, 'altura'=>182, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                                <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                                <!-- for hd displays -->
                                <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                                <noscript>
                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{utf8_decode($_produto_dia->DS_PRODUTO_PRRC)}">
                                </noscript>
                            </span>
                        {/if}
                    </a>
                    <p class="product-title">
                        <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">{utf8_decode($_produto_dia->DS_PRODUTO_PRRC)}</a>
                    </p>
                    <p class="product-price">
                        {if $_produto_dia->VL_PROMO_PRRC != 0}
                            <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">R$ {$_produto_dia->VL_PROMO_PRRC|number_format:2:",":"."}</a>
                        {else}
                            <a  rel="nofollow"href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$_produto_dia->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">R$ {$_produto_dia->VL_PRODUTO_PRRC|number_format:2:",":"."}</a>
                        {/if}
                    </p>
                </li>
            </ul>
        </div>
        <!-- SALE APPLCIATIVA -->
        <div class="category-item ">
            <p class="title-category">Produtos sale</p>
            <ul class="list-of-products">
                {foreach from=$sales item=sale}
                    {assign var="foto" value="{$sale['NR_SEQ_PRODUTO_PRRC']}"}
                    {assign var="extensao" value="{$sale['DS_EXT_PRRC']}"}
                    {assign var="foto_completa" value="{$foto}.{$extensao}"}

                    {assign var="fotos" value=$this->fotoproduto($sale->NR_SEQ_PRODUTO_PRRC)}
                    {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                    {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                    {assign var="foto_completa_dia" value="{$foto_produto}.{$extensao_produto}"}

                    {if !file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                        {assign var="foto_produto" value="{$fotos[1]['NR_SEQ_FOTO_FORC']}"}
                        {assign var="extensao_produto" value="{$fotos[1]['DS_EXT_FORC']}"}
                        {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
                    {/if}

                    {if $sale->NR_SEQ_TIPO_PRRC == 6}
                        {assign var=preTitle value='Camiseta '}
                    {else}
                        {assign var=preTitle value=''}
                    {/if}
                    {assign var=ds_produto_prrc value=' - '|explode:$sale->DS_PRODUTO_PRRC}
                    {assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}

                    {if $sale@iteration > $max}
                        {break}
                    {/if}
                    <li class="product-item">
                        <a rel="nofollow" class="thumb" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$sale->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">
                            {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                                <!-- Polyfill para imagens responsivas-->
                                <span data-picture data-alt="{$sale->DS_PRODUTO_PRRC}">
                                    <!--imagem padrão-->
                                    <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}"></span>
                                    <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                                    <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                    <span data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                                    <!-- for hd displays -->
                                    <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                    <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>$foto_completa],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                                    <noscript>
                                    <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$sale->DS_PRODUTO_PRRC}">
                                    </noscript>
                                </span>
                            {else}
                                <!-- Polyfill para imagens responsivas-->
                                <span data-picture data-alt="{$sale->DS_PRODUTO_PRRC}">
                                    <!--imagem padrão-->
                                    <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}"></span>
                                    <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>164, 'altura'=>181, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 979px)"></span>
                                    <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                    <span data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>138, 'altura'=>154, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 479px)"></span>
                                    <!-- for hd displays -->
                                    <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>
                                    <span data-width="138" data-height="154" data-src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>276, 'altura'=>308, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-media="(max-width: 767px)"></span>

                                    <noscript>
                                    <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>171, 'altura'=>190, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{$sale->DS_PRODUTO_PRRC}">
                                    </noscript>
                                </span>
                            {/if}

                        </a>
                        <p class="product-title">
                            <a href="{$this->url(["titulo"=>{$this->createslug($slug)}, "idproduto"=>{$sale->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">{$sale->DS_PRODUTO_PRRC}</a>
                        </p>
                        <p class="product-price">
                            {if $sale->VL_PROMO_PRRC != 0}
                                <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)}, "idproduto"=>{$sale->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">R$ {$sale->VL_PROMO_PRRC|number_format:2:",":"."}</a>
                            {else}
                                <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)}, "idproduto"=>{$sale->NR_SEQ_PRODUTO_PRRC}], {$acao}, TRUE)}">R$ {$sale->VL_PRODUTO_PRRC|number_format:2:",":"."}</a>
                            {/if}
                        </p>
                    </li>
                {/foreach}
            </ul>
        </div>
    </div>

</div>


<div class="rvb-comment">
    <form action="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], "comentarproduto", TRUE)}" method="post">
        {if $_logado neq 1}
            <p class="not-logado">
                Olá! Você precisa estar logado para comentar. <a href="{$this->url([], "reverbme", TRUE)}">Clique aqui </a> e faça um cadastro super rápido!
            </p>
        {else}
            <div class="rvb-header-item">
                <span>{$_nome_usuario}</span>
            </div>
            <textarea name="comentario" placeholder="Escreva seu comentário" id="comentario" cols="30" rows="10" class="message-box full-comment tynemce-on"></textarea>
            <input type="hidden" name="extensao" value="{$produto->DS_EXT_PRRC}"/>
            <div class="send-button">
                <button type="submit" class="btn">Enviar comentário</button>
            </div>
        {/if}

    </form>
</div>


<div class="about-this-post clearfix">
    {foreach from=$comentarios item=comentario}
        {assign var="foto" value="{$comentario['NR_SEQ_CADASTRO_CASO']}"}
        {assign var="extensao" value="{$comentario['DS_EXT_CACH']}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
        <div class="comments-item">
            <ul class="status-post">
                <li class="status-item">
                    <a rel="nofollow" href="{$this->url(["idcomentario"=>{$comentario->NR_SEQ_PRODCOMENT_PCRC}], 'curtirprodutocoments', TRUE)}" class="prodcurtiu" data-comentarioid="{$comentario->NR_SEQ_PRODCOMENT_PCRC}" title='Daniel&#10;Tony'>
                        <span class="likes">
                            + {$comentario->NR_CURTIRAM_PCRC} Curtiram
                        </span>
                    </a>

                    </a>
                </li>
                <li class="status-item">
                    <a rel="nofollow" href="{$this->url(["idcomentario"=>{$comentario->NR_SEQ_PRODCOMENT_PCRC}], 'naocurtirprodutocoments', TRUE)}">
                        <span class="likes">
                            - {$comentario->NR_NAOCURTIRAM_PCRC} Não Curtiram
                        </span>
                    </a>
                </li>
                <li class="status-item hide">
                    <span class="answers">{$comentario->findDependentRowset('Default_Model_Produtoscoments')->count()} Respostas</span>
                </li>
                <li class="status-item">
                    <span class="reply reply-comment-btn">Responder</span>
                </li>
                <li class="status-item hide">
                    <time class="timestamp" datetime="{$comentario->DT_COMENT_PCRC|date_format:'%Y-%d-%m'}">
                        {$comentario->DT_COMENT_PCRC|date_format:'%d/%m/%Y'} ás {$comentario->DT_COMENT_PCRC|date_format:"%H:%M"}
                    </time>
                </li>
                {if $_idperfil == 2 || $_idperfil == 4162 || $_idperfil == 22652}
                    <li class="status-item">
                        <a rel="nofollow" href="{$this->url(['idcomentario' => $comentario->NR_SEQ_PRODCOMENT_PCRC], 'apagarcomentario', true)}" class="remove">Remover este comentário</a>
                    </li>
                {/if}
            </ul>
            <div class="list-of-comments clearfix">
                <div class="comment-item">
                    <div class="comment-person">
                        <a rel="nofollow" href="{$this->url(["nome"=>{$this->createslug($comentario['DS_NOME_CASO'])}, "idperfil"=>{$comentario['NR_SEQ_CADASTRO_CASO']}], "perfil", TRUE)}">
                            {if file_exists("arquivos/uploads/reverbme/$foto_completa")}
                                <img src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>50, 'altura'=>62, 'imagem'=>$foto_completa],"imagem", TRUE)}" width="50" height="62" alt="{$comentario->DS_NOME_CASO}" />
                            {else}
                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>50, 'altura'=>62, 'imagem'=>'not_found_bkp.jpg'],"imagem", TRUE)}" width="50" height="62" alt="{$comentario->DS_NOME_CASO}" />
                            {/if}
                        </a>
                        <p class="comment-name">
                            <abbr title="{utf8_decode($comentario->DS_NOME_CASO)}">
                                <a rel="nofollow" href="{$this->url(["nome"=>{$this->createslug($comentario['DS_NOME_CASO'])}, "idperfil"=>{$comentario['NR_SEQ_CADASTRO_CASO']}], "perfil", TRUE)}">
                                    {$comentario->DS_NOME_CASO}
                                </a>
                            </abbr>
                        </p>
                    </div>
                    <div class="comment-detail">
                        <p>
                            {$this->utf8($comentario->DS_COMENTARIO_PCRC)}
                        </p>
                        {foreach from=$comentario->findDependentRowset('Default_Model_Produtoscoments') item=mensagem_filha}
                            <div class="replied-item">
                                <p class="person-name">
                                    <a rel="nofollow" href="{$this->url(["nome"=>{$this->createslug($mensagem_filha->DS_AUTOR_PCRC)}, "idperfil"=>{$mensagem_filha->NR_SEQ_CADASTRO_PCRC}], "perfil", TRUE)}">
                                        {$mensagem_filha->DS_AUTOR_PCRC}
                                    </a>
                                </p>
                                <ul class="status-comment">
                                    <li class="status-item">
                                        <a rel="nofollow" href="{$this->url(["idcomentario"=>{$mensagem_filha->NR_SEQ_PRODCOMENT_PCRC}], 'curtirprodutocoments', TRUE)}">
                                            <span class="likes">
                                                + {$mensagem_filha->NR_CURTIRAM_PCRC} curtiu
                                            </span>
                                        </a>
                                    </li>
                                    <li class="status-item">
                                        <a rel="nofollow" href="{$this->url(["idcomentario"=>{$mensagem_filha->NR_SEQ_PRODCOMENT_PCRC}], 'naocurtirprodutocoments', TRUE)}">
                                            <span class="likes">
                                                - {$mensagem_filha->NR_NAOCURTIRAM_PCRC} não curtiram
                                            </span>
                                        </a>
                                    </li>
                                    <li class="status-item last">
                                        <time datetime="{$mensagem_filha->DT_COMENT_PCRC|date_format:'%d/%m/%Y'}" class="timestamp">
                                            {$mensagem_filha->DT_COMENT_PCRC|date_format:'%d/%m/%Y'} ás {$mensagem_filha->DT_COMENT_PCRC|date_format:"%H:%M"}
                                        </time>
                                    </li>
                                </ul>
                                <p class="person-answer">
                                    {$this->utf8($mensagem_filha->DS_COMENTARIO_PCRC)}
                                </p>
                            </div> <!-- replied-item -->
                        {/foreach}


                        <div class="user-reply-comment disabled">
                            <p class="person-name">{$_nome_usuario}</p>
                            <div class="clearfix"></div>
                            <form action="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'comentarproduto', TRUE)}" method="post">
                                <input type="hidden" name="idmensagem" value="{$comentario->NR_SEQ_PRODCOMENT_PCRC}">
                                <textarea name="new-comment" class="reply-txt tynemce-on" placeholder="Escreva aqui seu comentário..."></textarea>
                                <div class="send-button">
                                    <button type="submit" class="btn">Responder comentário</button>
                                </div>
                            </form>
                        </div>
                    </div> <!-- comment-detail -->
                </div> <!-- comment-item -->
            </div> <!-- list-of-comments -->
        </div>
    {/foreach}
</div>
</div>
</div>

<div class="md-modal md-effect-1" id="medidas-lightbox">
    <div class="md-content">
        <p class="md-title">TABELA DE MEDIDAS DA REVERBCITY</p>
        <button class="md-close ir">Fechar</button>
        <div class="exter">

            <div id="medidas">

                <div class="camisetamaior">

                    <img id="img-preview" class="img" src="">

                </div>

            </div>

            <div class="infot">

                <div class="medidas-opcoes">
                    <h2>Escolha o tamanho para conferir as medidas:</h2>

                    <div id="desc">
                        {if $estoques_geral|count > 0}
                            <h3>Tamanho Único:</h3>
                        {elseif $estoques_masculino|count > 0}
                            <h3>Masculino:</h3>
                        {elseif $estoques_feminino|count > 0}
                            <h3>Feminino:</h3>
                        {/if}



                        <ul id="sizes-list">

                            {*<li class="active" data-size="0">
                            <span>pp</span>
                            </li>

                            <li class="active" data-size="1">
                            <span>p</span>
                            </li>

                            <li data-size="2">
                            <span>m</span>
                            </li>

                            <li data-size="3">
                            <span>g</span>
                            </li>
                            <li data-size="4">
                            <span>gg</span>
                            </li>
                            <li data-size="5">
                            <span>xgg</span>
                            </li>*}

                            <!--  {if $estoques_masculino|count > 0} -->

                            <!-- {/if} -->

                        </ul>
                    </div>
                </div>

                <div class="medidas-imagem">
                    <img class="img" id="tabela-medidas-img" src="">
                </div>

            </div>

        </div>
    </div>
</div>

<div class="md-modal md-effect-1" id="avise-lightbox">
    <div class="md-content">
        <p class="md-title">Avise-me</p>
        <button class="md-close ir">Fechar</button>
        <div class="exter">
            <p class="md-description">Caso você queira ser avisado da volta ao estoque de algum tamanho deste produto, preencha seus dados abaixo:</p>
            <form action="{$this->url(['idproduto' => $produto->NR_SEQ_PRODUTO_PRRC], "avisemeproduto", TRUE)}" id="avise-form" method="POST">
                <div class="md-bg">
                    <div class="col">
                        {if $_logado eq 1}

                            <input class="field field-left" id="avise-nome" type="text" name="NomeCompleto" placeholder="Nome completo" value="{$nome}" required>
                            <input class="field field-right phonemask" type="text" id="telefone" name="Telefone" placeholder="Telefone" value="({$ddd}) - {$telefone}" required>
                            <input class="field field-left" id="avise-email" type="email" name="Email" placeholder="E-mail" value="{$email}" required>
                            <div class="field field-right" id="tamanho">
                                <span>Selecione o tamanho</span>
                                <select name="tamanho" required>
                                    <option value="">Selecione o tamanho</option>
                                    {foreach from=$tamanhos item=tamanho}
                                        <option value="{$tamanho->NR_SEQ_TAMANHO_TARC}">{$tamanho->DS_TAMANHO_TARC}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="field field-left" id="estado">
                                <span>{$uf}</span>
                                <select id="avise-estado" name="estado" required value="{$uf}">
                                </select>
                            </div>
                            <div id="cidade" class="field field-right">
                                <span>{$cidade}</span>
                                <select id="avise-cidade" name="cidade" required value="{$cidade}">
                                </select>
                            </div>

                        {else}
                            <input class="field field-left" id="avise-nome" type="text" name="NomeCompleto" placeholder="Nome completo" required>
                            <input class="field field-right phonemask" type="text" id="telefone" name="Telefone" placeholder="Telefone" required>
                            <input class="field field-left" id="avise-email" type="email" name="Email" placeholder="E-mail" required>
                            <div class="field field-right" id="tamanho">
                                <span>Selecione o tamanho</span>
                                <select name="tamanho" required>
                                    <option value="">Selecione o tamanho</option>
                                    {foreach from=$tamanhos item=tamanho}
                                        <option value="{$tamanho->NR_SEQ_TAMANHO_TARC}">{$tamanho->DS_TAMANHO_TARC}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="field field-left" id="estado">
                                <span>Selecione o Estado</span>
                                <select id="avise-estado" name="estado" required></select>
                            </div>
                            <div id="cidade" class="field field-right">
                                <span>Selecione a cidade</span>
                                <select id="avise-cidade" name="cidade" required></select>
                            </div>
                        {/if}
                        <textarea placeholder="Comentários" name="observacoes"></textarea>
                    </div>
                </div>

                <div class="send-button">
                    <button class="btn" type="submit">Avise-me</button>
                </div>
            </form>

        </div>
    </div>
</div>
</div>

{include file="lightbox-indica-produto.tpl"}
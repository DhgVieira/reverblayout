{$this->headScript()->appendFile('/arquivos/default/js/produto.js')}
{$this->headScript()->appendFile('/arquivos/default/slick/slick.min.js')}

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
    {*{var_dump($produto)}*}

    <div id="prod-detalhe">
        <header class="row-fluid">
            <h2 class="rvb-title">Reverb<strong>loja</strong></h2>

            <span class="breadcrumb">
                <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="{$this->url(["tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}], 'todos-produtos', TRUE)}"><h2 itemprop="title" class="item-breadcumb">{$tipo['DS_CATEGORIA_PTRC']}</h2></a> ></div>
                <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" itemprop="title" href="{$this->url(["tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}, "categoria"=>{$categoria['NR_SEQ_CATEGPRO_PCRC']}], 'todos-produtos', TRUE)}"><h2 itemprop="title" class="item-breadcumb">{$categoria['DS_CATEGORIA_PCRC']}</h2></a> > </div>
                        {if $genero_produto eq 'M'}
                    <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" itemprop="title" href="{$this->url(["tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}, "categoria"=>{$categoria['NR_SEQ_CATEGPRO_PCRC']}, "genero"=>"masculino"], 'todos-produtos', TRUE)}"><h2 itemprop="title" class="item-breadcumb">Masculinas</h2></a> > </div>
                    <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a rel="nofollow" itemprop="url" itemprop="title" href="{$this->url(["tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}, "categoria"=>{$categoria['NR_SEQ_CATEGPRO_PCRC']}, "genero"=>"masculino", "cor"=>{$cor['idcor']}], 'todos-produtos', TRUE)}"><h2 itemprop="title" class="item-breadcumb">{$cor['cor']}</h2></a> ></div>
                        {elseif $genero_produto eq "F"}
                    <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" itemprop="title" href="{$this->url(["tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}, "categoria"=>{$categoria['NR_SEQ_CATEGPRO_PCRC']}, "genero"=>"feminino"], 'todos-produtos', TRUE)}"><h2 itemprop="title" class="item-breadcumb">Femininas</h2></a> > </div>
                    <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a rel="nofollow" itemprop="url" itemprop="title" href="{$this->url(["tipo"=>{$tipo['NR_SEQ_CATEGPRO_PTRC']}, "categoria"=>{$categoria['NR_SEQ_CATEGPRO_PCRC']}, "genero"=>"feminino", "cor"=>{$cor['idcor']}], 'todos-produtos', TRUE)}"><h2 itemprop="title" class="item-breadcumb">{$cor['cor']}</h2></a> ></div>
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



                <div id="hide-thumbnails">

                     <ul class="thumbnails" id="">
                        {foreach from=$fotos item=foto}
                            {assign var="foto_produto" value="{$foto['NR_SEQ_FOTO_FORC']}"}
                            {assign var="extensao_produto" value="{$foto['DS_EXT_FORC']}"}
                            {assign var="foto_completa_produto" value="{$foto_produto}.{$extensao_produto}"}
                            <li class="prod-thumbnails-items">
                                <div class="image">
                                    {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa_produto")}
                                        {*{assign var="foto_completa_produto" value="{$this->createslug($produto->DS_PRODUTO_PRRC)}-{$foto_produto}.{$extensao_produto}"}*}
                                        <img itemprop="image"  src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>517, 'altura'=>494, 'imagem'=>$foto_completa_produto],"imagem", TRUE)}" data-zoom-image="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>886, 'altura'=>988, 'imagem'=>$foto_completa_produto],"imagem", TRUE)}" title="{$preTitle}{$produto->DS_PRODUTO_PRRC}" alt="{$preTitle}{$produto->DS_PRODUTO_PRRC}" max-height="100%"/>

                                    {else}
                                        <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>517, 'altura'=>494, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" data-zoom-image="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>886, 'altura'=>988, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}" max-height="100%"/>
                                    {/if}
                                </div>
                            </li>
                        {/foreach}
                    </ul>
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
                        <h1 class="myriad" itemprop="name">{$preTitle} {$produto->DS_PRODUTO_PRRC}</h1>
                        <img itemprop="image" style="display:none;" src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>443, 'altura'=>494, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}"/>
                        <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" style="display: none;">
                            Rated <span itemprop="ratingValue">{if $nota['soma_notas'] >= 1}{$nota['soma_notas']}{else}5{/if}</span>/{$nota['total_voto'] + 23} based on <span itemprop="ratingCount">{$nota['total_voto'] + 23}</span> reviews
                        </div>

                        <div class="details-product-heading myriad">
                            <p>{utf8_decode($produto->DS_INFORMACOES_PRRC|strip_tags)}</p>
                        </div>
                    </div>

                    <div class="sizes">

                        <div class="content">
                            {if $estoques_geral|count > 0}
                                <div class="both">
                                    <div class="price-box myriad" itemscope itemprop="offers" itemtype="http://data-vocabulary.org/Offer">
                                        {*Tamanho Único*}
                                        <span class="price">

                                            {if $produto->VL_PROMO_PRRC > 0}
                                                <del>de R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</del>
                                                por R$ <span itemprop="price">{$produto->VL_PROMO_PRRC|number_format:2:",":"."}</span>
                                            {else}
                                                R$ <span itemprop="price">{$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</span>
                                            {/if}
                                        </span>
                                        <br/>
                                        <span class="price-promo">
                                            {if $produto->VL_PROMO_PRRC > 0}
                                                {if $produto->VL_PROMO_PRRC >= 50 AND $produto->VL_PROMO_PRRC < 100}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/2}
                                                    ou 2x DE R$ {$parcela|number_format:2:",":"."}
                                                {elseif $produto->VL_PROMO_PRRC >= 100 and $produto->VL_PROMO_PRRC < 150}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/3}
                                                    ou 3x DE R$ {$parcela|number_format:2:",":"."}
                                                {elseif $produto->VL_PROMO_PRRC >= 150}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/4}
                                                    ou 4x DE R$ {$parcela|number_format:2:",":"."}
                                                {/if}
                                            {else}
                                                {if $produto->VL_PRODUTO_PRRC >= 50 AND $produto->VL_PRODUTO_PRRC <= 100}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/2}
                                                    ou 2x DE R$ {$parcela|number_format:2:",":"."}
                                                {elseif $produto->VL_PRODUTO_PRRC >= 100 and $produto->VL_PRODUTO_PRRC < 150}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/3}
                                                    ou 3x DE R$ {$parcela|number_format:2:",":"."}
                                                {elseif $produto->VL_PRODUTO_PRRC >= 150}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/4}
                                                    ou 4x DE R$ {$parcela|number_format:2:",":"."}
                                                {/if}
                                            {/if}
                                        </span>

                                        <meta itemprop="priceCurrency" content="BRL" />
                                        <span class="escolha-tamanho">SELECIONE O TAMANHO PARA COMPRAR</span>

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
                                    <div class="price-box myriad" itemscope itemprop="offers" itemtype="http://schema.org/Offer">
                                        {*Masculino*}
                                        <span class="price">
                                            {if $produto->VL_PROMO_PRRC > 0}
                                                <del>de R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</del>
                                                por R$ <span itemprop="price">{$produto->VL_PROMO_PRRC|number_format:2:",":"."}</span>
                                            {else}
                                                R$ <span itemprop="price">{$produto->VL_PRODUTO_PRRC|number_format:2:",":"."} </span>
                                            {/if}</span>
                                        <br/>
                                        <span class="price-promo">
                                            {if $produto->VL_PROMO_PRRC > 0}
                                                {if $produto->VL_PROMO_PRRC >= 50 AND $produto->VL_PROMO_PRRC < 100}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/2}
                                                    ou 2x DE R$ {$parcela|number_format:2:",":"."}
                                                {elseif $produto->VL_PROMO_PRRC >= 100 and $produto->VL_PROMO_PRRC < 150}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/3}
                                                    ou 3x DE R$ {$parcela|number_format:2:",":"."}
                                                {elseif $produto->VL_PROMO_PRRC >= 150}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/4}
                                                    ou 4x DE R$ {$parcela|number_format:2:",":"."}
                                                {/if}
                                            {else}
                                                {if $produto->VL_PRODUTO_PRRC >= 50 AND $produto->VL_PRODUTO_PRRC <= 100}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/2}
                                                    ou 2x DE R$ {$parcela|number_format:2:",":"."}
                                                {elseif $produto->VL_PRODUTO_PRRC >= 100 and $produto->VL_PRODUTO_PRRC < 150}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/3}
                                                    ou 3x DE R$ {$parcela|number_format:2:",":"."}
                                                {elseif $produto->VL_PRODUTO_PRRC >= 150}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/4}
                                                    ou 4x DE R$ {$parcela|number_format:2:",":"."}
                                                {/if}
                                            {/if}
                                        </span>

                                        <meta itemprop="priceCurrency" content="BRL" />
                                        <span class="escolha-tamanho">SELECIONE O TAMANHO PARA COMPRAR</span>
                                    </div>

                                    <ul class="size-list">
                                        {foreach from=$estoques_masculino item=estoque}
                                            <li>
                                                {if $estoque->NR_QTDE_ESRC eq 1}
                                                    <a rel="nofollow" href="{$this->url(["idproduto"=>{$estoque->NR_SEQ_PRODUTO_ESRC}, "idestoque"=>{$estoque->NR_SEQ_ESTOQUE_ESRC}, "tamanho"=>{$estoque->NR_SEQ_TAMANHO_ESRC}, "genero"=>"m"], 'adicionarcarrinho', TRUE)}" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                        {$estoque->DS_SIGLA_TARC}
                                                        <span class="resta">RESTA 1</span>
                                                    </a>
                                                {elseif $estoque->NR_QTDE_ESRC le 0}
                                                    <a rel="nofollow" href="#" class="btn inactive md-trigger" data-modal="avise-lightbox" title="Tamanho {$estoque->DS_SIGLA_TARC}" data-idtamanho="{$estoque->NR_SEQ_TAMANHO_ESRC}">
                                                        {$estoque->DS_SIGLA_TARC}
                                                        <span class="resta" >PEDIR <br/>REPRINT</span>
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
                                    <div class="price-box myriad" itemscope="" itemprop="offers" itemtype="http://schema.org/Offer">
                                        {*Feminino *}
                                        <span class="price">
                                            {if $produto->VL_PROMO_PRRC > 0}
                                                <del>de R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</del>
                                                por R$ <span itemprop="price">{$produto->VL_PROMO_PRRC|number_format:2:",":"."}</span>
                                            {else}
                                                R$ <span itemprop="price">{$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}</span>
                                            {/if}</span>
                                        <br/>
                                        <span class="price-promo">
                                            {if $produto->VL_PROMO_PRRC > 0}
                                                {if $produto->VL_PROMO_PRRC >= 50 AND $produto->VL_PROMO_PRRC < 100}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/2}
                                                    ou 2x DE R$ {$parcela|number_format:2:",":"."}
                                                {elseif $produto->VL_PROMO_PRRC >= 100 and $produto->VL_PROMO_PRRC < 150}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/3}
                                                    ou 3x DE R$ {$parcela|number_format:2:",":"."}
                                                {elseif $produto->VL_PROMO_PRRC >= 150}
                                                    {assign var=parcela value=$produto->VL_PROMO_PRRC/4}
                                                    ou 4x DE R$ {$parcela|number_format:2:",":"."}
                                                {/if}
                                            {else}
                                                {if $produto->VL_PRODUTO_PRRC >= 50 AND $produto->VL_PRODUTO_PRRC <= 100}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/2}
                                                    ou 2x DE R$ {$parcela|number_format:2:",":"."}
                                                {elseif $produto->VL_PRODUTO_PRRC >= 100 and $produto->VL_PRODUTO_PRRC < 150}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/3}
                                                    ou 3x DE R$ {$parcela|number_format:2:",":"."}
                                                {elseif $produto->VL_PRODUTO_PRRC >= 150}
                                                    {assign var=parcela value=$produto->VL_PRODUTO_PRRC/4}
                                                    ou 4x DE R$ {$parcela|number_format:2:",":"."}
                                                {/if}
                                            {/if}
                                        </span>

                                        <meta itemprop="priceCurrency" content="BRL" />
                                        <span class="escolha-tamanho">SELECIONE O TAMANHO PARA COMPRAR</span>
                                    </div>

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
                        <div class="">
                            <a rel="nofollow" href="#" id="show-sizes" data-idproduto="{$produto->NR_SEQ_PRODUTO_PRRC}" data-modal="medidas-lightbox" class="md-trigger btn-sizes"><!-- <span class="icon sizes"></span> -->
                                <span class="content">Tabela de Medidas</span>
                            </a>

                            {if $_logado eq 1}
                                <a rel="nofollow" href="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], "calculaindividual", TRUE)}" data-logado="true" class="calcula-frete">{if $frete eq ""}Calcule o frete{else}{$frete}{/if}</a>
                            {else}
                                <a rel="nofollow" href="#" data-logado="false" class="calcula-frete">Calcule o frete</a>
                            {/if}

                            <a rel="nofollow" href="#" id="share" class="md-trigger btn-share"><!-- <span class="icon sizes"></span> -->
                                <span class="content">Compartilhe</span>
                            </a>

                            <a rel="nofollow" href="{$this->url(["produto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'adicionawishlist', TRUE)}" class="btn-list"><!-- <span class="icon ok"></span>  --><span class="content">Adicione a Wishlist</span></a>

                        </div>
                    </div>
                </form>

                <div class="trustedcompany-widget" style="margin-top: 45px; float: left; width: 100%">
                    <iframe id="trustedcompany-widget" width="100%" height="114" frameborder="0" scrolling="no"></iframe>
                    <a href="http://trustedcompany.com/br/reverbcity.com-opiniões" target="_blank" title="Avaliações da Reverbcity"></a>
                    <script>
                        (function(){
                            document.getElementById('trustedcompany-widget').src='//trustedcompany.com/embed/widget/v2?domain=reverbcity.com&type=d&review=1&text=a';
                        })();
                    </script>
                </div>

            </div>

            <!-- End Description -->

        </section>
    </div>
    <div class="about-this-post clearfix">
        <p class="title-category">Comentários</p>
        {assign var="count" value="1"}
        {foreach from=$comentarios item=comentario}
            {assign var="foto" value="{$comentario['NR_SEQ_CADASTRO_CASO']}"}
            {assign var="extensao" value="{$comentario['DS_EXT_CACH']}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
            <div class="comments-item {if $count > 4}hide{/if}">
                <div class="list-of-comments clearfix">
                    <div class="comment-item">
                        <div class="comment-person">
                            <a rel="nofollow" href="{$this->url(["nome"=>{$this->createslug($comentario['DS_NOME_CASO'])}, "idperfil"=>{$comentario['NR_SEQ_CADASTRO_CASO']}], "perfil", TRUE)}">
                                {if file_exists("arquivos/uploads/reverbme/$foto_completa")}
                                    <img src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>62, 'altura'=>62, 'imagem'=>$foto_completa],"imagem", TRUE)}" width="62" height="62" alt="{$comentario->DS_NOME_CASO}" />
                                {else}
                                    <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>62, 'altura'=>62, 'imagem'=>'not_found_bkp.jpg'],"imagem", TRUE)}" width="62" height="62" alt="{$comentario->DS_NOME_CASO}" />
                                {/if}
                            </a>
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
                        <div class="comment-rodape">
                            <div class="comment-border"></div>
                            <div class="comment-dots">...</div>
                        </div>
                    </div> <!-- comment-item -->
                </div> <!-- list-of-comments -->
            </div>
            {assign var="count" value="{$count + 1}"}
        {/foreach}
    </div>
    <div class="send-button  btn-vermais">
        <button class="btn">VER MAIS</button>
    </div>

    <div class="rvb-comment">
        <form action="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], "comentarproduto", TRUE)}" method="post">
            {if $_logado neq 1}
                <p class="not-logado">
                    Olá! Você precisa estar logado para comentar. <a href="{$this->url([], "reverbme", TRUE)}">Clique aqui </a> e faça um cadastro super rápido!
                </p>
            {else}
                <textarea name="comentario" placeholder="Escreva seu comentário" cols="30" rows="10" class="message-box full-comment tynemce-on"></textarea>
                <input type="hidden" name="extensao" value="{$produto->DS_EXT_PRRC}"/>
                <div class="send-button">
                    <button type="submit" class="btn">COMENTAR</button>
                </div>
            {/if}

        </form>
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
            {if $_visitados|count > 0}
                <div class="category-item visited items-{$visitado}">
                    <p class="title-category">Você também vai gostar de</p>
                    <ul class="list-of-products">
                    {capture}{$_visitados|@shuffle}{/capture}

                    {foreach from=$_visitados item=visitado}

                        {assign var="foto" value="{$visitado['codigo']}"}
                        {assign var="extensao" value="{$visitado['path']}"}
                        {assign var="foto_completa" value="{$foto}.{$extensao}"}
                        {assign var="max" value="4"}

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
                            <div class="product-box">
                                <div class="product-image">
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
                                </div>
                                <div class="product-price-box">
                                    <p class="product-title">
                                        <a href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$visitado['codigo']}], {$acao}, TRUE)}">{utf8_decode($visitado['nome']|truncate:15:"...":TRUE)}</a>
                                        <span class="product-price">
                                            {if $visitado['promo'] != 0}
                                                <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$visitado['codigo']}], {$acao}, TRUE)}">R$ {$visitado['promo']|number_format:2:",":"."}</a>
                                            {else}
                                                <a rel="nofollow" href="{$this->url(["titulo"=>{$this->createslug($slug)},"idproduto"=>{$visitado['codigo']}], {$acao}, TRUE)}">R$ {$visitado['valor']|number_format:2:",":"."}</a>
                                            {/if}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </li>
                    {/foreach}
                </ul>
            </div>
        {/if}
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
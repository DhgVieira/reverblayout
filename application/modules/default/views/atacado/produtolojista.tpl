    <div class="banners-advertisement cycle-slideshow"
    data-cycle-fx="fadeout"
    data-cycle-timeout="5000"
    data-cycle-slides="> a"
    data-cycle-log="false"
    data-cycle-pause-on-hover="true">
        {foreach from=$banners item=banner}
        {assign var="foto" value="{$banner['NR_SEQ_BANNER_BARC']}"}
        {assign var="extensao" value="{$banner['DS_EXT_BARC']}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
        <a href="{$banner['DS_LINK_BARC']}">
            {if file_exists("arquivos/uploads/banners/$foto_completa")}
              <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}"/>
            {else}
              <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}"/>
            {/if}
        </a>
    {/foreach}
    </div>

    <div id="wrap-produtos">

        <div id="prod-detalhe">
            <header class="row-fluid">
                <h2 class="rvb-title">Reverb<strong>loja</strong></h2>
            </header>
            <section class="row-fluid">

                <div class="span2 store">

                    <div class="content">
                        <ul class="nav nav-pills nav-stacked">
                            {foreach from=$categorias item=categoria}
                            <li class="nav-pills-item">
                                <a href="{$this->url(["idcategoria"=>{$categoria['NR_SEQ_CATEGPRO_PCRC']}], 'inicio', TRUE)}">{$categoria['DS_CATEGORIA_PCRC']}</a>
                                <ul class="nav-pills-sub">
                                    <li class="nav-pills-sub-item">
                                        <a href="/work/reverb/trunk/loja/page/1/categoria/182/tamanho//genero//cor" class="sub-menu-link">Buttons</a>
                                    </li>
                                    <li class="nav-pills-sub-item">
                                        <a href="/work/reverb/trunk/loja/page/1/categoria/182/tamanho//genero//cor" class="sub-menu-link">Camisetas/T-shirts</a>
                                    </li>
                                    <li class="nav-pills-sub-item">
                                        <a href="/work/reverb/trunk/loja/page/1/categoria/182/tamanho//genero//cor" class="sub-menu-link">Casa/Home</a>
                                    </li>
                                    <li class="nav-pills-sub-item">
                                        <a href="/work/reverb/trunk/loja/page/1/categoria/182/tamanho//genero//cor" class="sub-menu-link">Chinelos/Flipflops</a>
                                    </li>
                                    <li class="nav-pills-sub-item">
                                        <a href="/work/reverb/trunk/loja/page/1/categoria/182/tamanho//genero//cor" class="sub-menu-link">Converse All Star</a>
                                    </li>
                                    <li class="nav-pills-sub-item">
                                        <a href="/work/reverb/trunk/loja/page/1/categoria/182/tamanho//genero//cor" class="sub-menu-link">EcoBags</a>
                                    </li>
                                </ul>
                            </li>
                            {/foreach}
                        </ul>
                    </div>
                </div>

                <div class="span9 images">
                    {assign var="foto" value="{$produto->NR_SEQ_PRODUTO_PRRC}"}
                    {assign var="extensao" value="{$produto->DS_EXT_PRRC}"}
                    {assign var="foto_completa" value="{$foto}.{$extensao}"}
                    
                    {assign var="foto_produto" value="{$fotos[0]['NR_SEQ_FOTO_FORC']}"}
                    {assign var="extensao_produto" value="{$fotos[0]['DS_EXT_FORC']}"}
                    {assign var="foto_completa" value="{$foto_produto}.{$extensao_produto}"}
                    <div class="image span13">
                        {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa")}
                            <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>443, 'altura'=>494, 'imagem'=>$foto_completa],"imagem", TRUE)}" id="zoom_01" data-zoom-image="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>886, 'altura'=>988, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}" max-height="100%"/>
                        {else}
                            <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>443, 'altura'=>494, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" id="zoom_01" data-zoom-image="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>886, 'altura'=>988, 'imagem'=>$foto_completa],"imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}" max-height="100%"/>
                        {/if}
                    </div>

                    <div id="thumbnails-carousel" class="span3">

                        <a title="mostrar imagens anteriores" class="shifted-in ctrl-thumb-carousel" id="moveprev">
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
                                            <a href="#" data-image="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>443, 'altura'=>494, 'imagem'=>$foto_completa_produto], "imagem", TRUE)}" data-zoom-image="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>886, 'altura'=>988, 'imagem'=>$foto_completa_produto], "imagem", TRUE)}" title="{$produto->DS_PRODUTO_PRRC}" >
                                                <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>60, 'altura'=>70, 'imagem'=>$foto_completa_produto], "imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}" title="{$produto->DS_PRODUTO_PRRC}"/>
                                            </a>
                                        {else}
                                            <a href="#" data-image="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>443, 'altura'=>494, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" data-zoom-image="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>886, 'altura'=>988, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" title="{$produto->DS_PRODUTO_PRRC}" >
                                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>60, 'altura'=>70, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}" title="{$produto->DS_PRODUTO_PRRC}"/>
                                            </a>
                                        {/if}
                                    </li>
                                {/foreach}
                                {foreach from=$fotos item=foto}
                                {assign var="foto_produto" value="{$foto['NR_SEQ_FOTO_FORC']}"}
                                {assign var="extensao_produto" value="{$foto['DS_EXT_FORC']}"}
                                {assign var="foto_completa_produto" value="{$foto_produto}.{$extensao_produto}"}
                                    <li class="prod-thumbnails-items">
                                        {if file_exists("arquivos/uploads/fotosprodutos/$foto_completa_produto")}
                                            <a href="#" data-image="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>443, 'altura'=>494, 'imagem'=>$foto_completa_produto], "imagem", TRUE)}" data-zoom-image="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>886, 'altura'=>988, 'imagem'=>$foto_completa_produto], "imagem", TRUE)}" title="{$produto->DS_PRODUTO_PRRC}" >
                                                <img src="{$this->Url(['tipo'=>"fotosprodutos", 'crop'=>1, 'largura'=>60, 'altura'=>70, 'imagem'=>$foto_completa_produto], "imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}" title="{$produto->DS_PRODUTO_PRRC}"/>
                                            </a>
                                        {else}
                                            <a href="#" data-image="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>443, 'altura'=>494, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" data-zoom-image="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>886, 'altura'=>988, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" title="{$produto->DS_PRODUTO_PRRC}" >
                                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>60, 'altura'=>70, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}" alt="{$produto->DS_PRODUTO_PRRC}" title="{$produto->DS_PRODUTO_PRRC}"/>
                                            </a>
                                        {/if}
                                    </li>
                                {/foreach}
                            </ul>
                        </div>

                        <a title="mostrar as proximas imagens" class="shifted-in ctrl-thumb-carousel" id="movenext">
                            Exibir as proximas imagens
                        </a>
                    </div>
                </div>

                <div class="span5 description">

                    <div id="heading-details-product" class="heading-details-products">
                        <h2>{utf8_decode($produto->DS_PRODUTO_PRRC)}</h2>

                        {if $_logado neq 1}
                            <div id="score" data-logado="false" data-score="{$nota['soma_notas']}"></div>
                        {else}
                            <div id="score" data-logado="true" data-idproduto="{$produto->NR_SEQ_PRODUTO_PRRC}" data-score="{$nota['soma_notas']}"></div>
                        {/if}

                        {include file="share-buttons.tpl"}

                        <div class="details-product-heading">
                            <p>{utf8_decode($produto->DS_INFORMACOES_PRRC|strip_tags)}</p>
                        </div>

                        <label id="trigger-detail" for="opendetail" title="clique para vizualizar o texto completo da descrição ">
                            [+ info]
                        </label>
                    </div>

                    <!-- <span class="escolha-tamanho">CLIQUE NO TAMANHO PARA COMPRAR</span> -->

                    <div class="sizes">

                        <div class="content">

                            {assign var="vl_lojista" value="{$produto->VL_PRODUTO_PRRC}"}

                            {assign var="vl_lojista_tmp" value="{math equation="x * y" x=$produto->VL_PRODUTO_PRRC y=0.6}"}

                            {if $produto->VL_PROMO_PRRC > 0 and $vl_lojista_tmp > $produto->VL_PROMO_PRRC}
                                {assign var="vl_lojista" value="{$produto->VL_PROMO_PRRC}"}
                            {else}
                                {assign var="vl_lojista" value=$vl_lojista_tmp}
                            {/if}

                            <form action="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], "adicionarcarrinhoatacadista", TRUE)}" method="POST">
                                {if $estoques_geral|count > 0}

                                <div class="both">
                                    <div class="price-container">
                                        <div class="varejo">
                                            varejo
                                            <span class="price heavy">
                                                R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}
                                            </span>
                                        </div>

                                        <div class="atacado">
                                            atacado
                                            <span class="price heavy">
                                                R$ {$vl_lojista|number_format:2:",":"."}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="sizes-label-container">
                                        <span class="icon female"></span>
                                        <abbr class="sizes-label-text" title="Quantidade">Qtde.</abbr>
                                    </div>

                                    <ul class="size-list">
                                        {foreach from=$estoques_geral item=estoque}
                                        {assign var=tamanho value="-"|explode:$estoque->DS_SIGLA_TARC}
                                        <li data-quantidade="{$estoque->NR_QTDE_ESRC}">
                                            {if $estoque->NR_QTDE_ESRC eq 1}
                                                <a href="#" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                    <span class="text">
                                                        {$tamanho[0]} {$tamanho[1]}
                                                        <span class="small">resta 1</span>
                                                    </span>
                                                </a>
                                            {elseif $estoque->NR_QTDE_ESRC le 0}
                                                <a href="#" data-modal="avise-lightbox" class="btn inactive md-trigger" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                    <span class="text">
                                                        {$tamanho[0]} {$tamanho[1]}
                                                        <span class="small" >avise-me</span>
                                                    </span>
                                                </a>
                                            {else}
                                                <a href="#" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                    <span class="text">
                                                        {$tamanho[0]} {$tamanho[1]}
                                                    </span>
                                                </a>
                                            {/if}


                                            <input type="text" class="input-size" placeholder="0" name="quantidade[]"/>
                                            <input type="hidden" name="idestoque[]" value="{$estoque->NR_SEQ_ESTOQUE_ESRC}"/>
                                            <input type="hidden" name="tamanho[]" value="{$estoque->NR_SEQ_TAMANHO_TARC}"/>
                                        </li>

                                        {/foreach}
                                    </ul>

                                    </div>
                                    {/if}
                                    {if $estoques_masculino|count > 0}
                                    <div class="both">
                                        <div class="price-container">
                                            <div class="varejo">
                                                varejo
                                                <span class="price heavy">
                                                    R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}
                                                </span>
                                            </div>

                                            <div class="atacado">
                                                atacado
                                                <span class="price heavy">
                                                    R$ {$vl_lojista|number_format:2:",":"."}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>


                                        <div class="sizes-label-container">
                                            <span class="icon male"></span>
                                            <abbr class="sizes-label-text" title="Quantidade">Qtde.</abbr>
                                        </div>

                                        <ul class="size-list">
                                            {foreach from=$estoques_masculino item=estoque}
                                            <li data-quantidade="{$estoque->NR_QTDE_ESRC}">
                                                {if $estoque->NR_QTDE_ESRC eq 1}
                                                    <a href="#" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                        <span class="text">
                                                            {$estoque->DS_SIGLA_TARC}
                                                            <span class="small">resta 1</span>
                                                        </span>
                                                    </a>
                                                {elseif $estoque->NR_QTDE_ESRC le 0}
                                                    <a href="#" data-modal="avise-lightbox" class="btn inactive md-trigger" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                        <span class="text">
                                                            {$estoque->DS_SIGLA_TARC}
                                                            <span class="small" >avise-me</span>
                                                        </span>
                                                    </a>
                                                {else}
                                                    <a href="#" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                        <span class="text">
                                                            {$estoque->DS_SIGLA_TARC}
                                                        </span>
                                                    </a>
                                                {/if}
                                                <input type="text" class="input-size" placeholder="0" name="quantidade[]"/>
                                                <input type="hidden" name="idestoque[]" value="{$estoque->NR_SEQ_ESTOQUE_ESRC}"/>
                                                <input type="hidden" name="tamanho[]" value="{$estoque->NR_SEQ_TAMANHO_TARC}"/>
                                            </li>
                                            {/foreach}
                                        </ul>

                                        <!-- <div class="fields-container">
                                            <abbr class="fields-label" title="Quantidade">QTDE</abbr>
                                            <input class="fields-input" placeholder="0" type="text" name="P">
                                            <input class="fields-input" placeholder="0" type="text" name="M">
                                            <input class="fields-input" placeholder="0" type="text" name="G">
                                            <input class="fields-input" placeholder="0" type="text" name="GG">
                                            <input class="fields-input" placeholder="0" type="text" name="XGG">
                                        </div> -->
                                </div>
                                {/if}
                                {if $estoques_feminino|count > 0}
                                <div class="both">
                                    <div class="price-container">
                                        <div class="varejo">
                                            varejo
                                            <span class="price heavy">
                                                R$ {$produto->VL_PRODUTO_PRRC|number_format:2:",":"."}
                                            </span>
                                        </div>

                                        <div class="atacado">
                                            atacado
                                            <span class="price heavy">
                                                R$ {$vl_lojista|number_format:2:",":"."}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>


                                    <div class="sizes-label-container">
                                        <span class="icon female"></span>
                                        <abbr class="sizes-label-text" title="Quantidade">Qtde.</abbr>
                                    </div>

                                    <ul class="size-list">
                                        {foreach from=$estoques_feminino item=estoque}
                                        <li data-quantidade="{$estoque->NR_QTDE_ESRC}">
                                            {if $estoque->NR_QTDE_ESRC eq 1}
                                                    <a href="#" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                        <span class="text">
                                                            {$estoque->DS_SIGLA_TARC}
                                                            <span class="small">resta 1</span>
                                                        </span>
                                                    </a>
                                                {elseif $estoque->NR_QTDE_ESRC le 0}
                                                    <a href="#" data-modal="avise-lightbox" class="btn inactive md-trigger" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                        <span class="text">
                                                            {$estoque->DS_SIGLA_TARC}
                                                            <span class="small" >avise-me</span>
                                                        </span>
                                                    </a>
                                                {else}
                                                    <a href="#" class="btn" title="Tamanho {$estoque->DS_SIGLA_TARC}">
                                                        <span class="text">
                                                            {$estoque->DS_SIGLA_TARC}
                                                        </span>
                                                    </a>
                                                {/if}
                                            <input type="text" class="input-size" placeholder="0" name="quantidade[]"/>
                                            <input type="hidden" name="idestoque[]" value="{$estoque->NR_SEQ_ESTOQUE_ESRC}"/>
                                            <input type="hidden" name="tamanho[]" value="{$estoque->NR_SEQ_TAMANHO_TARC}"/>
                                        </li>
                                        {/foreach}
                                    </ul>

                                    <!-- <div class="fields-container">
                                        <abbr class="fields-label" title="Quantidade">QTDE</abbr>
                                        <input class="fields-input" placeholder="0" type="text" name="P">
                                        <input class="fields-input" placeholder="0" type="text" name="M">
                                        <input class="fields-input" placeholder="0" type="text" name="G">
                                        <input class="fields-input" placeholder="0" type="text" name="GG">
                                    </div> -->
                                </div>
                                {/if}
                                <button type="reset" class="produto-lojista-btn reset">Zerar Campos</button>
                                <button type="submit" class="produto-lojista-btn send">Adicionar ao carrinho</button>
                            </form>
                        </div>
                    </div>

                    <div class="btns">
                        <div class="left">
                            {if $_logado eq 1}
                                <a href="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], "calculaindividual", TRUE)}" data-logado="true" class="btn btn-block calcula-frete">{if $frete eq ""}Calcule o frete{else}{$frete}{/if}</a>

                                <a href="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], "calculaindividual", TRUE)}" data-logado="true" class="btn btn-block calcula-prazo">Prazo de entrega</a>
                            {else}
                                <a href="#" data-logado="false" class="btn btn-block calcula-frete">Calcule o frete</a>

                                <a href="#" data-logado="false" class="btn btn-block calcula-prazo">Prazo de entrega</a>
                            {/if}

                            <a href="#" id="troca-btn" class="btn btn-block">Trocas</a>

                            <div class="troca">

                                <p>

                                    A Reverbcity garante a troca de qualquer um de seus produtos, sem ônus para o cliente, caso seja constatado defeito na peça. Se o cliente quiser trocar uma peça (sem uso) por qualquer outro motivo, ele deverá cobrir despesas de frete.

                                </p>
                                <br>
                                <a href="{$this->url([], "contato", TRUE)}" id="fale-conosco"><strong>Clique aqui</strong></a> em fale conosco.

                            </div>

                        </div>

                        <div class="right">
                            <a href="#" id="show-sizes" data-idproduto="{$produto->NR_SEQ_PRODUTO_PRRC}" data-modal="medidas-lightbox" class="md-trigger btn btn-primary btn-block btn-sizes"><!-- <span class="icon sizes"></span> -->
                                <span class="content">Tabela de Medidas</span>
                            </a>

                            <a href="{$this->url(["produto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], 'adicionawishlist', TRUE)}" class="btn btn-red btn-block btn-list"><!-- <span class="icon ok"></span>  --><span class="content">Adicionar a <br> lista de desejos</span></a>

                            <a href="" class="btn btn-block md-trigger" data-modal="avise-lightbox">AVISE-ME</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="row other-products">
            {include file="suggestion-products.tpl"}
        </div>


        <div class="rvb-comment">
            <form action="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], "comentarproduto", TRUE)}" method="post">
            {if $_logado neq 1}
                <div class="row-fluid control-group h30">

                    <div class="control-label span2">
                        <label for="new-comment-name">
                            NOME
                        </label>
                        <input type="text" id="new-comment-name" class="field" name="comentario_nome" required />
                    </div>

                </div>

                <div class="row-fluid control-group h30">
                    <div class="control-label span2 ">
                        <label for="new-comment-email">
                            E-MAIL
                        </label>

                        <input type="email" id="new-comment-email" class="field"  name="comentario_email" required />

                    </div>
                </div>
            {else}
                <div class="rvb-header-item">
                    <span>{$_nome_usuario}</span>
                </div>
            {/if}
                <textarea name="comentario" placeholder="Escreva seu comentário" id="comentario" cols="30" rows="10" class="message-box full-comment tynemce-on"></textarea>
                <div class="send-button">
                       <button type="submit" class="btn">Enviar comentário</button>
                </div>
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
                            <a href="{$this->url(["idcomentario"=>{$comentario->NR_SEQ_PRODCOMENT_PCRC}], 'curtirprodutocoments', TRUE)}">
                                <span class="likes">
                                    + {$comentario->NR_CURTIRAM_PCRC} Curtiram
                                </span>
                            </a>
                        </li>
                        <li class="status-item">
                            <a href="{$this->url(["idcomentario"=>{$comentario->NR_SEQ_PRODCOMENT_PCRC}], 'naocurtirprodutocoments', TRUE)}">
                                <span class="likes">
                                    - {$comentario->NR_NAOCURTIRAM_PCRC} Não Curtiram
                                </span>
                            </a>
                        </li>
                        <li class="status-item hide">
                            <span class="answers">99 Respostas</span>
                        </li>
                        <li class="status-item">
                            <span class="reply reply-comment-btn">Responder</span>
                        </li>
                        <li class="status-item hide">
                            <time class="timestamp" datetime="{$comentario->DT_COMENT_PCRC|date_format:'%Y-%d-%m'}">
                              {$comentario->DT_COMENT_PCRC|date_format:'%d/%m/%Y'} ás {$comentario->DT_COMENT_PCRC|date_format:"%H:%M"}
                            </time>
                        </li>
                    </ul>
                    <div class="list-of-comments clearfix">
                        <div class="comment-item">
                            <div class="comment-person">
                                <a href="#">
                                    {if file_exists("arquivos/uploads/reverbme/$foto_completa")}
                                        <img src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>50, 'altura'=>62, 'imagem'=>$foto_completa],"imagem", TRUE)}" width="50" height="62" alt="{$comentario->DS_NOME_CASO}" />
                                    {else}
                                        <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>50, 'altura'=>62, 'imagem'=>'not_found_bkp.jpg'],"imagem", TRUE)}" width="50" height="62" alt="{$comentario->DS_NOME_CASO}" />
                                    {/if}
                                </a>
                                <p class="comment-name">
                                  <abbr title="{utf8_decode($comentario->DS_NOME_CASO)}">
                                    {$comentario->DS_NOME_CASO}
                                  </abbr>
                                </p>
                            </div>
                            <div class="comment-detail">
                                <p>
                                  {utf8_decode($comentario->DS_COMENTARIO_PCRC)}
                                </p>
                                {foreach from=$comentario->findDependentRowset('Default_Model_Produtoscoments') item=mensagem_filha}
                                <div class="replied-item">
                                    <p class="person-name">Teste</p>
                                    <ul class="status-comment">
                                        <li class="status-item">
                                            <a href="{$this->url(["idcomentario"=>{$mensagem_filha->NR_SEQ_PRODCOMENT_PCRC}], 'curtirprodutocoments', TRUE)}">
                                              <span class="likes">
                                              + {$mensagem_filha->NR_CURTIRAM_PCRC} curtiu
                                              </span>
                                            </a>
                                        </li>
                                        <li class="status-item">
                                           <a href="{$this->url(["idcomentario"=>{$mensagem_filha->NR_SEQ_PRODCOMENT_PCRC}], 'naocurtirprodutocoments', TRUE)}">
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
                                      {utf8_decode($mensagem_filha->DS_COMENTARIO_PCRC)}
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
                            <h3>Unisex:</h3>
                        {elseif $estoques_masculino|count > 0}
                            <h3>Masculino:</h3>
                        {elseif $estoques_feminino|count > 0}
                            <h3>Feminino:</h3>
                        {/if}



                        <ul id="sizes-list">

                            <li class="active" data-size="0">
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

                            {if $estoques_masculino|count > 0}
                            <li data-size="5">
                                <span>xgg</span>
                            </li>
                            {/if}

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
            <form action="{$this->url([], "avisemeproduto", TRUE)}" id="avise-form" method="POST">
                <div class="md-bg">
                    <div class="col">
                        <input class="field field-left" id="avise-nome" type="text" name="NomeCompleto" placeholder="Nome completo">
                        <input class="field field-right" type="text" id="telefone" name="Telefone" placeholder="Telefone">
                        <input class="field field-left" id="avise-email" type="text" name="Email" placeholder="E-mail">
                        <div class="field field-right" id="tamanho">
                            <span>Selecione o tamanho</span>
                            <select name="tamanho">
                                <option value="PP">PP</option>
                                <option value="P">P</option>
                                <option value="M">M</option>
                                <option value="G">G</option>
                                <option value="GG">GG</option>
                                <option value="XGG">XGG</option>
                            </select>
                        </div>
                        <div class="field field-left" id="estado">
                            <span>Selecione o Estado</span>
                            <select id="avise-estado" name="estado"></select>
                        </div>
                        <div id="cidade" class="field field-right">
                            <span>Selecione a cidade</span>
                            <select id="avise-cidade" name="cidade"></select>
                        </div>
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

{include file="lightbox-indique.tpl"}
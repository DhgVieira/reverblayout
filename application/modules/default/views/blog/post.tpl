    <div class="banners-advertisement cycle-slideshow"
    data-cycle-fx="fadeout"
    data-cycle-timeout="5000"
    data-cycle-slides="> a"
    data-cycle-log="false"
    data-cycle-pause-on-hover="true">
     {foreach from=$banners_topo item=banner}
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

    <h1 class="rvb-title">Reverb <span>Blog</span></h1>

    <form action="" id="search-blog-form" method="post">
        <div class="input-text">
            <input placeholder="Data - DD/MM/AAAA" type="search" name="search-date">
            <input placeholder="Título" type="search" name="search-text" class="search-input">
        </div>
        <div class="send-button search-icon">
            <button class="search-icon ir" type="submit">Pesquisar</button>
        </div>
    </form>

    <div class="rvb-column left">
        {assign var="foto" value="{$blog->NR_SEQ_BLOG_BLRC}"}
        {assign var="extensao" value="{$blog->DS_EXT_BLRC}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
        <div class="rvb-blog-post">
            <h2 class="post-title">{$blog->DS_TITULO_BLRC}</h2>
            <p class="author">Por <strong>{$blog->DS_COLUNISTA_CORC}</strong> | {$blog->total_comentarios} comments</p>
            <figure class="post-image">
                {if file_exists("arquivos/uploads/blog/$foto_completa")}
                  {if $blog->DS_LINKIMAGEM_BLRC neq ""}
                    <a href="{$blog->DS_LINKIMAGEM_BLRC}">
                        <img alt="{utf8_decode($blog->DS_TITULO_BLRC)}" src="../../arquivos/uploads/blog/{$foto_completa}"/>
                    </a>
                  {else}
                        <img alt="{utf8_decode($blog->DS_TITULO_BLRC)}" src="../../arquivos/uploads/blog/{$foto_completa}"/>
                   {/if}
                {else}
                  <img alt="{utf8_decode($blog->DS_TITULO_BLRC)}" src="{$this->Url(['tipo'=>"error", 'crop'=>2,'largura'=>700,'altura'=>307,'imagem'=>'not_found.jpg'],'imagem', TRUE)}"/>
                {/if}

            </figure>
            <p>{$blog->DS_TEXTO_BLRC}</p>

            <p class="author">Por <strong>{$blog->DS_COLUNISTA_CORC}</strong> | {$blog->total_comentarios} comments</p>

            {include file="share-buttons.tpl"}
        </div>
        <div class="plugin-facebook"> 
            <div class="fb-comments" data-href="{$_pagina_atual}" data-numposts="5"  data-width="665" data-colorscheme="light"></div>
        </div>


        <div class="rvb-comment">
            <form action="{$this->url(["idpost"=>{$blog->NR_SEQ_BLOG_BLRC}], "comentar", TRUE)}" method="post">
            {if $_logado neq 1}
                <p class="not-logado">
                    Olá! Você precisa estar logado para comentar. <a href="{$this->url([], "reverbme", TRUE)}">Clique aqui </a> e faça um cadastro super rápido!
                </p>
            {else}
                <div class="rvb-header-item">
                    <span>{$_nome_usuario}</span>
                </div>

                <textarea name="comentario" placeholder="Escreva seu comentário" id="comentario" cols="30" rows="10" class="message-box full-comment tynemce-on"></textarea>
                <div class="send-button">
                       <button type="submit" class="btn">Enviar comentário</button>
                </div>
            {/if}
            </form>
        </div>


        <div class="about-this-post clearfix with-aside">
            {foreach from=$comentarios item=comentario}
                {assign var="foto" value="{$comentario['NR_SEQ_CADASTRO_CASO']}"}
                {assign var="extensao" value="{$comentario['DS_EXT_CACH']}"}
                {assign var="foto_completa" value="{$foto}.{$extensao}"}
                <div class="comments-item">
                     <!-- {if $codigo_usuario eq $comentario['NR_SEQ_CADASTRO_CASO']}
                        <a href="{$this->url(["idcomentario"=>{$comentario['NR_SEQ_COMENTARIO_CBRC']}], "deletarcomentarioblog", TRUE)}" class="md-close">Excluir</a>
                    {/if} -->
                    <ul class="status-post">
                        <li class="status-item">
                            <a href="{$this->url(["idpost"=>{$comentario['NR_SEQ_COMENTARIO_CBRC']}], 'curtirpost', TRUE)}">
                                <span class="likes">
                                    + {$comentario->NR_CURTIRAM_CBRC} Curtiram
                                </span>
                            </a>
                        </li>
                        <li class="status-item">
                            <a href="{$this->url(["idpost"=>{$comentario['NR_SEQ_COMENTARIO_CBRC']}], 'naocurtirpost', TRUE)}">
                                <span class="notlikes">
                                    - {$comentario->NR_NAOCURTIRAM_CBRC} Não Curtiram
                                </span>
                            </a>
                        </li>
                        <li class="status-item">
                            <span class="answers">0 Respostas</span>
                        </li>
                        <li class="status-item">
                            <span class="reply reply-comment-btn">Responder</span>
                        </li>
                        <li class="status-item">
                            <time class="timestamp" datetime="{$comentario->DT_CADASTRO_CBRC|date_format:'%Y-%d-%m'}">
                              {$comentario->DT_CADASTRO_CBRC|date_format:'%d/%m/%Y'} ás {$comentario->DT_CADASTRO_CBRC|date_format:"%H:%M"}
                            </time>
                        </li>
                        <!-- <li class="status-item last">
                            <a href="#" class="ir remove">Remover este comentário</a>
                        </li> -->
                    </ul>
                    <div class="list-of-comments clearfix">
                        <div class="comment-item">
                            <div class="comment-person">
                                 <a href="{$this->url(["nome"=>{$this->createslug($comentario['DS_NOME_CASO'])}, "idperfil"=>{$comentario['NR_SEQ_CADASTRO_CASO']}], "perfil", TRUE)}">
                                    {if file_exists("arquivos/uploads/reverbme/$foto_completa")}
                                        <img src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>50, 'altura'=>62, 'imagem'=>$foto_completa],"imagem", TRUE)}" width="50" height="62" alt="{$comentario['DS_NOME_CASO']}" />
                                    {else}
                                        <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>50, 'altura'=>62, 'imagem'=>'not_found_bkp.jpg'],"imagem", TRUE)}" width="50" height="62" alt="{$comentario['DS_NOME_CASO']}" />
                                    {/if}
                                </a>
                                <p class="comment-name">
                                  <abbr title="{utf8_decode($comentario['DS_NOME_CASO'])}">
                                    <a href="{$this->url(["nome"=>{$this->createslug($comentario['DS_NOME_CASO'])}, "idperfil"=>{$comentario['NR_SEQ_CADASTRO_CASO']}], "perfil", TRUE)}">
                                    {$comentario['DS_NOME_CASO']}
                                    </a>
                                  </abbr>
                                </p>
                            </div>
                            <div class="comment-detail">
                                <p>
                                  {$comentario['DS_TEXTO_CBRC']}
                                </p>
                                
                               {foreach from=$comentario->findDependentRowset('Default_Model_Comentariosblog') item=mensagem_filhas}
                                    <div class="replied-item">
                                        <p class="person-name">{$mensagem_filhas->findParentRow('Default_Model_Reverbme')->DS_NOME_CASO}</p>
                                        <ul class="status-comment">
                                            <li class="status-item">
                                                <a href="{$this->url(["idpost"=>{$mensagem_filhas->NR_SEQ_COMENTARIO_CBRC}], 'curtirpost', TRUE)}">
                                                  <span class="likes">
                                                  {$mensagem_filhas->NR_CURTIRAM_CBRC} curtiu
                                                  </span>
                                                </a>
                                            </li>
                                            <li class="status-item">
                                               <a href="{$this->url(["idpost"=>{$mensagem_filhas->NR_SEQ_COMENTARIO_CBRC}], 'naocurtirpost', TRUE)}">
                                                <span class="notlikes">
                                                  {$mensagem_filhas->NR_NAOCURTIRAM_CBRC} não curtiram
                                                </span>
                                              </a>
                                            </li>
                                            <li class="status-item last">
                                                <time datetime="{$mensagem_filhas->DT_CADASTRO_CBRC|date_format:'%d/%m/%Y'}" class="timestamp">
                                                  {$mensagem_filhas->DT_CADASTRO_CBRC|date_format:'%d/%m/%Y'} ás {$mensagem_filhas->DT_CADASTRO_CBRC|date_format:"%H:%M"}
                                                </time>
                                            </li>
                                        </ul>
                                        <p class="person-answer">
                                          {$mensagem_filhas->DS_TEXTO_CBRC|regex_replace:"/(<p>|<p [^>]*>|<\\/p>)/":""}
                                        </p>
                                    </div> <!-- replied-item -->
                                {/foreach}
                               


                                <div class="user-reply-comment disabled">
                                    {if $_logado eq 1}
                                        <p class="person-name">{$_nome_usuario}</p>
                                    {else}
                                          <p class="person-name">Você precisa estar logado para comentar.</p>
                                    {/if}
                                    <div class="clearfix"></div>
                                    <form action="{$this->url(["idpost"=>{$blog->NR_SEQ_BLOG_BLRC}], "comentar", TRUE)}" method="post">
                                        <input type="hidden" name="idmensagem" value="{$comentario['NR_SEQ_COMENTARIO_CBRC']}">
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
    <div class="rvb-column right">
        {include file="sidebar-blog.tpl"}
    </div>
</div>
    {if $blog->NR_SEQ_BLOG_BLRC == '3791'}
        <img id="poketoy" src="https://www.reverbcity.com/arquivos/default/images/poketoy.png" style="position: fixed;bottom: -65px;left: 0;-moz-transform: rotate(45deg);-webkit-transform: rotate(45deg);-o-transform: rotate(45deg);-ms-transform: rotate(45deg);">
    {/if}
{include file="lightbox-indique.tpl"}

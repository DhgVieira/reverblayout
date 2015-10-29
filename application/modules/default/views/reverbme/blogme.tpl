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

    <h1 class="rvb-title">Blog <span>me</span></h1>

    <div class="rvb-column left">
            {assign var="foto_completa" value="{$post->imagem_path}"}
        <div class="rvb-blog-post">
            <h2 class="post-title">{utf8_decode($post->titulo)}</h2>
            <p class="author">Por <strong>{utf8_decode($post->DS_NOME_CASO)}</strong> | 0 comments</p>
            <figure class="post-image">
                {if file_exists("arquivos/uploads/blogme/$foto_completa")}
                  <img alt="{utf8_decode($post->titulo)}" src="{$this->Url(['tipo'=>"blogme", 'crop'=>2,'largura'=>700,'altura'=>307,'imagem'=>$foto_completa],'imagem', TRUE)}"/>
                {else}
                  <img alt="{utf8_decode($post->titulo)}" src="{$this->Url(['tipo'=>"error", 'crop'=>2,'largura'=>700,'altura'=>307,'imagem'=>'not_found.jpg'],'imagem', TRUE)}"/>
                {/if}

           
            </figure>
            <p>{utf8_decode($post->post)}</p>

            <p class="author">Por <strong>{utf8_decode($post->DS_NOME_CASO)}</strong> | 0 comments</p>

            <div class="share-buttons">
                <ul>

                    <li class="fb-like-count-box">
                        <div class="fb-like" data-href="{$smarty.server.PHP_SELF}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                    </li>

                    <li class="pinit-box">
                        <a href="//pinterest.com/pin/create/button/" data-pin-do="buttonBookmark">
                            <img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" width="40" height="20" alt="Pin it" />
                        </a>
                    </li>

                    <li class="tweet-button">
                        <a href="https://twitter.com/share" data-lang="en" class="twitter-share-button">Tweet</a>
                        {literal}
                        <script>
                        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
                        </script>
                        {/literal}
                    </li>

                    <li class="email-indique">
                        <a href="#" data-modal="indique-lightbox" class="md-trigger">
                        </a>
                    </li>

                </ul>
            </div>

        </div>
        <div class="plugin-facebook">
            <div class="fb-comments" data-href="{$smarty.server.PHP_SELF} " data-width="665" data-numposts="3" data-colorscheme="light"></div>
        </div>

        <div class="rvb-comment">
            <form action="{$this->url(["idpost"=>{$post->idme_blog}], "comentarme", TRUE)}" method="post">
            {if $_logado neq 1}
                <div class="row-fluid control-group h30">

                    <div class="control-label span2">
                        <label for="new-comment-name">
                            NOME
                        </label>
                        <input type="text" id="new-comment-name" class="field" name="nome" required />
                    </div>

                </div>

                <div class="row-fluid control-group h30">
                    <div class="control-label span2 ">
                        <label for="new-comment-email">
                            E-MAIL
                        </label>

                        <input type="email" id="new-comment-email" class="field"  name="email" required />

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
                {assign var="foto" value="{$comentario->NR_SEQ_CADASTRO_CASO}"}
                {assign var="extensao" value="{$comentario->DS_EXT_CACH}"}
                {assign var="foto_completa" value="{$foto}.{$extensao}"}
                <div class="comments-item">
                    <ul class="status-post">
                        <li class="status-item">
                            <a href="{$this->url(["idpost"=>{$comentario->idme_blog_coment}], 'curtircomentariome', TRUE)}">
                                <span class="likes">
                                    + {$comentario->total_curtidas} Curtiram
                                </span>
                            </a>
                        </li>
                        <li class="status-item">
                            <a href="{$this->url(["idpost"=>{$comentario->idme_blog_coment}], 'naocurtircomentariome', TRUE)}">
                                <span class="likes">
                                    - {$comentario->total_nao_curtidas} Não Curtiram
                                </span>
                            </a>
                        </li>
                        <li class="status-item">
                            <span class="answers">{$comentario->total_nao_curtidas} Respostas</span>
                        </li>
                        <li class="status-item">
                            <span class="reply reply-comment-btn">Responder</span>
                        </li>
                        <li class="status-item">
                            <time class="timestamp" datetime="{$comentario->data_comentario|date_format:'%Y-%d-%m'}">
                              {$comentario->data_comentario|date_format:'%d/%m/%Y'} ás {$comentario->data_comentario|date_format:"%H:%M"}
                            </time>
                        </li>
                        <!-- <li class="status-item last">
                            <a href="#" class="ir remove">Remover este comentário</a>
                        </li> -->
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
                                  {utf8_decode($comentario->comentario)}
                                </p>
                                {foreach from=$comentario->findDependentRowset('Default_Model_Reverbmeblogcoments') item=mensagem_filha}
                                <div class="replied-item">
                                    <p class="person-name">Teste</p>
                                    <ul class="status-comment">
                                        <li class="status-item">
                                            <a href="{$this->url(["idpost"=>{$mensagem_filha->idme_blog_coment}], 'curtircomentariome', TRUE)}">
                                              <span class="likes">
                                              + {$mensagem_filha->total_curtidas} curtiu
                                              </span>
                                            </a>
                                        </li>
                                        <li class="status-item">
                                           <a href="{$this->url(["idpost"=>{$mensagem_filha->idme_blog_coment}], 'naocurtircomentariome', TRUE)}">
                                            <span class="likes">
                                              - {$mensagem_filha->total_nao_curtidas} não curtiram
                                            </span>
                                          </a>
                                        </li>
                                        <li class="status-item last">
                                            <time datetime="{$mensagem_filha->data_comentario|date_format:'%d/%m/%Y'}" class="timestamp">
                                              {$mensagem_filha->data_comentario|date_format:'%d/%m/%Y'} ás {$mensagem_filha->data_comentario|date_format:"%H:%M"}
                                            </time>
                                        </li>
                                    </ul>
                                    <p class="person-answer">
                                      {utf8_decode($mensagem_filha->comentario)}
                                    </p>
                                </div> <!-- replied-item -->
                                {/foreach}


                                <div class="user-reply-comment disabled">
                                    <p class="person-name">{$_nome_usuario}</p>
                                    <div class="clearfix"></div>
                                    <form action="{$this->url(["idpost"=>{$post->idme_blog}], "comentarme", TRUE)}" method="post">
                                        <input type="hidden" name="idmensagem_pai" value="{$comentario->idme_blog_coment}">
                                        <textarea name="comentario" class="reply-txt tynemce-on" placeholder="Escreva aqui seu comentário..."></textarea>
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

{include file="lightbox-indique.tpl"}
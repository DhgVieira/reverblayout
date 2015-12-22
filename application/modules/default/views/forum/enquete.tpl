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
<h1 class="rvb-title">Reverb <span>Enquete</span></h1>
<div class="full-title">
    <h2 class="subtitle">{$enquete->titulo_enquete}</h2>
    <a href="#" class="rvb-forum-button report md-trigger" data-modal="irregularidades-lightbox">Denunciar irregularidades</a>
</div>

<div class="full-title">
    <a href="{$this->url([], 'enquetelista', TRUE)}" class="rvb-forum-button back">
        <img src="{$basePath}/arquivos/default/images/icon/btn_voltar.png"/>
    </a>

    <h2 class="subtitle">{$enquete->titulo_enquete}</h2>

    <p>
        Post by
        <a href="{$this->url(["nome"=>{$this->createslug($enquete->DS_NOME_CASO)}, "idperfil"=>{$enquete->NR_SEQ_CADASTRO_CASO}], "perfil", TRUE)}">
            {$enquete->DS_NOME_CASO}
        </a>
    </p>
</div>

<div class="rvb-forum-details topics clearfix">
    <a href="{$this->url([], "forum", TRUE)}" class="rvb-forum-button back">Voltar as enquetes</a>
    <form action="{$this->url([], "forum", TRUE)}" id="form-pesquisar-post" class="clearfix">
        <input type="text" class="search-input" name="busca_enquete">
        <div class="send-button search-icon">
            <button class="ir search-icon btn" type="submit">Buscar</button>
        </div>
    </form>
</div>
{* Aqui o cara ainda nao votou *}
{if $javotou eq 0}
    {if $enquete->data_fim|date_format:"%d/%m/%Y" lte $smarty.now|date_format:"%d/%m/%Y"}
             <div class="rvb-forum-details no-bg clearfix">
            <p>{$enquete->descricao}</p>
            </div>
            <ul class="list-of-polls">
                {foreach from=$resultado_fim item=alternativa}
                    {assign var="porcentagem" value={math equation="(( x / y ) * z )" x=$alternativa->quantidade_votos y=$alternativa->total_votos z=100}}

                    <li class="poll-item">
                        {if $alternativa->imagem_path neq ""}
                            {if file_exists("arquivos/uploads/enquete/$alternativa->imagem_path")}
                                <img class="poll-item-thumb" src="{$this->Url(['tipo'=>"enquete", 'crop'=>1,'largura'=>67,'altura'=>67,'imagem'=>$alternativa->imagem_path],'imagem', TRUE)}" alt="{$alternativa->opcao}">
                            {else}
                                <img class="poll-item-thumb" src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>67,'altura'=>67,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$alternativa->opcao}">
                            {/if}
                        {/if}
                        <span class="poll-item-text">{$alternativa->opcao}</span>

                        <div class="result-bar">
                            <div class="result-text current-value">{$porcentagem|truncate:4:"":TRUE}%</div>
                            <div class="loading-bar">
                                <div class="progress" data-value="{$porcentagem}%"></div>
                            </div>
                            <div class="result-text">{$alternativa->quantidade_votos} Votos</div>
                        </div>
                    </li>
                {/foreach}
            </ul>
        {else}

         <div class="rvb-forum-details clearfix">
         <p>{$enquete->descricao}</p>
        </div>
        <form action="{$this->url(["idenquete"=>{$enquete->idenquete}], "votarenquete", TRUE)}" method="post" class="form-polls">
            <ul class="list-of-polls">
                {foreach from=$alternativas item=alternativa}
                {{assign var="foto_completa" value="{$alternativa->imagem_path}"}}

                <li class="poll-item">
                    {if $alternativa->imagem_path neq ""}

                        {if file_exists("arquivos/uploads/enquete/$foto_completa")}
                            <img class="poll-item-thumb" src="{$this->Url(['tipo'=>"enquete", 'crop'=>1,'largura'=>67,'altura'=>67,'imagem'=>$alternativa->imagem_path],'imagem', TRUE)}" alt="{$alternativa->opcao}">
                        {else}
                            <img class="poll-item-thumb" src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>67,'altura'=>67,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$alternativa->opcao}">
                        {/if}
                    {/if}
                    <span class="poll-item-text">{$alternativa->opcao}</span>
                    <div class="poll-item-check">
                        {if $enquete->permite_multipla eq 0}
                            <input type="radio" name="idopcao[]" value="{$alternativa->idenquete_opcao}"/>
                        {else}
                            <input type="checkbox" name="idopcao[]" value="{$alternativa->idenquete_opcao}"/>
                        {/if}
                    </div>
                </li>
                {/foreach}
            </ul>
        <div class="send-button">
            <button type="submit" class="btn">Votar</button>
        </div>
        </form>
    {/if}
{* Aqui o cara ja votou *}
{else}
    {* Aqui mostra caso exibe reusltado seja igual a 0 :( *}
    {if $enquete->exibe_resultado eq 0}
    {* aqui verifica se a enquete esta vencida se nao nao mostra porque? *}
        {if $enquete->data_fim|date_format:"%d/%m/%Y" >= $smarty.now|date_format:"%d/%m/%Y"}
             <div class="rvb-forum-details no-bg clearfix">
            <p>{$enquete->descricao}</p>
            </div>
            <ul class="list-of-polls">
                {counter start=0 print=false}
                {foreach from=$resultado item=alternativa}
                    {assign var="porcentagem" value={math equation="(( x / y ) * z )" x=$alternativa->quantidade_votos y=$alternativa->total_votos z=100}}
                    {{assign var="foto_completa" value="{$alternativa->imagem_path}"}}

                    <li class="poll-item">
                        {if $alternativa->imagem_path neq ""}
                            {if file_exists("arquivos/uploads/enquete/$foto_completa")}
                                <img class="poll-item-thumb" src="{$this->Url(['tipo'=>"enquete", 'crop'=>1,'largura'=>67,'altura'=>67,'imagem'=>$alternativa->imagem_path],'imagem', TRUE)}" alt="{$alternativa->opcao}">
                            {else}
                                <img class="poll-item-thumb" src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>67,'altura'=>67,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$alternativa->opcao}">
                            {/if}
                        {/if}
                        <span class="poll-item-text">{$alternativa->opcao}</span>

                        <div class="result-bar">
                            <div class="resultado" id="resultado-{counter}" data-dimension="56" data-text="{$porcentagem|truncate:4:"":TRUE}%"  data-width="30" data-fontsize="10" data-percent="{$porcentagem|truncate:4:"":TRUE}" data-fgcolor="#61c099" data-bgcolor="#fff"></div>
                            <div class="result-text current-value">{$porcentagem|truncate:4:"":TRUE}%</div>
                            <div class="result-text votes">{$alternativa->quantidade_votos} Votos</div>
                            <div class="loading-bar">
                                <div class="progress" data-value="{$porcentagem}%"></div>
                            </div>
                        </div>

                    </li>
                {/foreach}
            </ul>
        {/if}

    {else}

        <div class="rvb-forum-details no-bg clearfix">
            <p>{$enquete->descricao}</p>
        </div>
        <ul class="list-of-polls">
            {foreach from=$resultado item=alternativa}
            {assign var="porcentagem" value={math equation="(( x / y ) * z )" x=$alternativa->quantidade_votos y=$alternativa->total_votos z=100}}

            <li class="poll-item">
                {if $alternativa->imagem_path neq ""}
                <img class="poll-item-thumb" src="{$this->Url(['tipo'=>"enquete", 'crop'=>1,'largura'=>67,'altura'=>67,'imagem'=>$alternativa->imagem_path],'imagem', TRUE)}"
                  alt="{$alternativa->opcao}">
                {/if}
                <span class="poll-item-text">{$alternativa->opcao}</span>

                <div class="result-bar">
                    <div class="result-text current-value">{$porcentagem}%</div>
                    <div class="loading-bar">
                        <div class="progress" data-value="{$porcentagem}%"></div>
                    </div>
                    <div class="result-text">{$alternativa->quantidade_votos} Votos</div>
                </div>
            </li>
            {/foreach}
        </ul>
    {/if}

{/if}
<div class="rvb-comment">
    <div class="rvb-header-item">
        <span>{$_nome_usuario}</span>
    </div>
    <div class="rvb-content-item clearfix">
        <form action="{$this->url(["idenquete"=>{$enquete->idenquete}], "comentarenquete", TRUE)}" method="post">
          <textarea name="comentario" placeholder="Escreva seu comentário" id="comentario" cols="30" rows="10" class="message-box full-comment tynemce-on"></textarea>
            <div class="send-button">
                   <button type="submit" class="btn">Enviar comentário</button>
            </div>
        </form>
    </div>
</div>


<div class="about-this-post clearfix">
{foreach from=$comentarios item=comentario}
    {{assign var="foto" value="{$comentario->NR_SEQ_CADASTRO_CASO}"}}
    {{assign var="extensao" value="{$comentario->DS_EXT_CACH}"}}
    {{assign var="foto_completa" value="{$foto}.{$extensao}"}}
    <div class="comments-item">
        <ul class="status-post">
            <li class="status-item">
                <a href="{$this->url(["idcomentario"=>$comentario->idenquete_comentario], "curtircomentarioenquete", TRUE)}"><span class="likes">+ {$comentario->numero_curtiu} curtiram</span></a>
            </li>
            <li class="status-item">
               <a href="{$this->url(["idcomentario"=>$comentario->idenquete_comentario], "naocurtircomentarioenquete", TRUE)}"><span class="notlikes">- {$comentario->numero_nao_curtiu} não curtiram</span></a>
            </li>
            <li class="status-item">
                <span class="answers">{$comentario->total_comentarios} respostas</span>
            </li>
            <li class="status-item">
                <span class="reply reply-comment-btn">Responder</span>
            </li>
            <li class="status-item">
                <span class="timestamp">{$comentario->data_comentario|date_format:"%d/%m/%Y"} {$comentario->data_comentario|date_format:"%H:%M"}</span>
            </li>
            <!-- <li class="status-item last">
                <a href="#" class="ir remove">Remover este comentário</a>
            </li> -->
        </ul>
        <div class="list-of-comments clearfix">
            <div class="comment-item">
                <div class="comment-person">
                    <a href="#" class="image">
                        <img src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1,'largura'=>50,'altura'=>62,'imagem'=>$foto_completa],'imagem', TRUE)}" width="50" height="60" alt="tony strauss"/>
                    </a>
                        <p class="comment-name">{$comentario->DS_NOME_CASO}</p>
                </div>
                <div class="comment-detail">
                    <p>{$comentario->comentario} </p>
                    {foreach from=$comentario->findDependentRowset('Default_Model_Enquetecomentarios') item=mensagem_filha}
                    <div class="replied-item">
                        <p class="person-name">{$mensagem_filha->findParentRow('Default_Model_Reverbme')->DS_NOME_CASO}</p>
                        <ul class="status-comment">
                            <li class="status-item">
                                <a href="{$this->url(["idcomentario"=>$mensagem_filha->idenquete_comentario], "curtircomentarioenquete", TRUE)}"><span class="likes">+ {$mensagem_filha->numero_curtiu} curtiu</span></a>
                            </li>
                            <li class="status-item">
                               <a href="{$this->url(["idcomentario"=>$mensagem_filha->idenquete_comentario], "naocurtircomentarioenquete", TRUE)}"> <span class="notlikes">- {$mensagem_filha->numero_nao_curtiu} não curtiram</span></a>
                            </li>
                            <li class="status-item last">
                                <span class="timestamp">{$mensagem_filha->data_comentario|date_format:"%d/%m/%Y"} {$mensagem_filha->data_comentario|date_format:"%H:%M"}</span>
                            </li>
                        </ul>
                        <p class="person-answer">
                            {$mensagem_filha->comentario}
                        </p>
                    </div> <!-- replied-item -->
                    {/foreach}


                    <div class="user-reply-comment disabled">
                        <p class="person-name">{$_nome_usuario}</p>
                        <div class="clearfix"></div>
                        <form action="{$this->url(["idenquete"=>{$enquete->idenquete}], "comentarenquete", TRUE)}" method="post">
                            <input type="hidden" name="idmensagem_pai" value="{$comentario->idenquete_comentario}">
                            <textarea name="comentario" class="reply-txt" placeholder="Escreva aqui seu comentário..."></textarea>
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

<!-- lightbox para denunciar irregularidades -->
<div class="md-modal md-effect-1" id="irregularidades-lightbox">
    <div class="md-content">
        <p class="md-title">Denunciar Irregularidades</p>
        <div class="mg-bg">
            <button class="md-close ir">Fechar</button>
            <p>Preencha seus dados, sua denúncia e clique em enviar.</p>
            <form action="#" method="post" id="form-irregularidades">
                <div class="input-text left">
                    <input type="text" name="irregularidadenome" id="irregularidadenome" placeholder="Nome" required>
                </div>
                <div class="input-text right">
                    <input type="email" name="irregularidademail" id="irregularidademail" placeholder="E-mail" required>
                </div>
                <div class="text-box">
                    <textarea name="irregularidadetxt" id="irregularidadetxt" placeholder="Coloque aqui o mimimi..." required></textarea>
                </div>
                <div class="insert-captcha">
                    <label for="captcha-code">
                         <img src="http://dummyimage.com/115x45/a1e01a/fff.gif" alt="captcha" heigth="45" width="115">
                         <input name="captcha[input]" type="text" class="input-box" maxlength="3" title="Digite os caracteres da imagem" id="contato-captcha-code">
                         <input id="captcha" name="captcha[id]" value="{$this->idCaptcha}" type="hidden">
                    </label>
                </div>
                <div class="send-button">
                    <button type="submit" class="btn">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="md-overlay"></div>

<div id="paginacao" class="posreflole">
    <ul class="pagination">
        {if $pages.previous}
            <li class="item">
                <a class="linkpagination" title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"forum", "action"=>"enquete", "page"=>{$pages.next}, "idenquete"=>{$enquete->idenquete}], "enquete", TRUE)}"><</a>
            </li>
        {/if}
        {section name=page_loop start=$this->comentarios->current_page-1 loop=$this->comentarios->current_page+3 step=1}
            <li class="item">
                <a class="linkpagination" href="{$this->url(["module"=>"default", "controller"=>"forum", "action"=>"enquete", "page"=>$smarty.section.page_loop.index+1, "idenquete"=>{$enquete->idenquete}], "enquete", TRUE)}">
                    {$smarty.section.page_loop.index+1}
                </a>
            </li>
        {/section}
        {if $pages.next}
            <li class="item">
                <a class="linkpagination" title="Próxima Página" href="{$this->url(["module"=>"default", "controller"=>"forum", "action"=>"enquete", "page"=>{$pages.next}, "idenquete"=>{$enquete->idenquete}], "enquete", TRUE)}">></a>
            </li>
        {/if}
    </ul>
</div>


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

<h1 class="rvb-title">Reverb <span>Forum</span></h1>

<div class="full-title">
    <h2 class="subtitle">{$topico->DS_TOPICO_TOSO}</h2>
    <a href="{$this->url(["topico"=>{$this->createslug($topico->DS_TOPICO_TOSO)}, "idforum"=>{$topico->NR_SEQ_TOPICO_TOSO}], "denunciarforum", TRUE)}" class="rvb-forum-button report">Denunciar irregularidades</a>
</div>

<div class="rvb-forum-details clearfix">
    <a href="{$this->url([], 'forum', TRUE)}" class="rvb-forum-button back">Voltar aos tópicos</a>

    <form action="{$this->url([], "forum", TRUE)}" id="form-pesquisar-post" class="clearfix">
        <input type="text" class="search-input" name="busca">
        <div class="send-button search-icon">
            <button class="ir search-icon btn" type="submit">Buscar</button>
        </div>
    </form>
</div>

<div class="rvb-forum-details clearfix">
    {if $_logado neq 1}
        <p class="not-logado">
            Olá! Você precisa estar logado para comentar. <a href="{$this->url([], "reverbme", TRUE)}">Clique aqui </a> e faça um cadastro super rápido!
        </p>
    {else}
        <p class="user-login-name">{$_nome_usuario}</p>
        <form action="{$this->url(["idforum"=>{$topico->NR_SEQ_TOPICO_TOSO}], "comentarforum", TRUE)}" method="post" id="form-inserir-comentario">
            <textarea class="message-box" name="comentario" placeholder="Escreva aqui seu comentário..."></textarea>
            <div class="send-button clearfix">
                <button class="rvb-white-button" type="submit">Enviar</button>
            </div>
        </form>
    {/if}
</div>
<div id="detalheforum-comments">
    {foreach from=$mensagens item=msg}
                {assign var="foto" value="{$msg['NR_SEQ_CADASTRO_CASO']}"}
                {assign var="extensao" value="{$msg['DS_EXT_CACH']}"}
                {assign var="foto_completa" value="{$foto}.{$extensao}"}
    <div class="about-this-post clearfix">
        {if $codigo_usuario eq $msg['NR_SEQ_CADASTRO_CASO'] or $codigo_usuario == 2}
            <a href="{$this->url(["idcomentario"=>{$msg['NR_SEQ_MSG_MESO']}], "deletarcomentarioforum", TRUE)}" class="md-close">Excluir</a>
        {/if}
        <ul class="status-post">
            <li class="status-item">
                    <a href="{$this->url(["idmsg"=>{$msg['NR_SEQ_MSG_MESO']}], 'curtirmsg', TRUE)}">
                        <span class="likes">
                    {$msg['NR_CURTIRAM_MESO']} curtiram
                            </span>
                    </a>
                    {assign var=listacurtiram value=$this->listacurtiram($msg['NR_SEQ_MSG_MESO'])}
                    {if $listacurtiram->count()}
                    <span class="likes-tooltip">
                        {foreach from=$listacurtiram item=curtiram}
                            {assign var=nome value=" "|explode:$curtiram->nome}
                            <a href="{$this->url(["nome"=>$this->createslug($curtiram->nome), "idperfil"=>$curtiram->id], "perfil", TRUE)}">{$nome[0]}</a><br />
                        {/foreach}
                    </span>
                    {/if}
            </li>
            <li class="status-item">
                <a href="{$this->url(["idmsg"=>{$msg['NR_SEQ_MSG_MESO']}], 'naocurtirmsg', TRUE)}"><span class="notlikes"> {$msg['NR_NAOCURTIRAM_MESO']} não curtiram</span></a>
            </li>
            <li class="status-item hide">
                <span class="answers">{$msg->findDependentRowset('Default_Model_Mensagens')->count()} respostas</span>
            </li>
            <li class="status-item">
                <span class="reply reply-comment-btn">Responder</span>
            </li>
            <li class="status-item hide">
                <span class="timestamp">{$msg['DT_CADASTRO_MESO']|date_format:"%d/%m/%Y"} ás {$msg['DT_CADASTRO_MESO']|date_format:"%H:%M"}</span>
            </li>
        </ul>

        <div class="list-of-comments clearfix">

                <div class="comment-item">

                    <div class="comment-person">
                         <a href="{$this->url(["nome"=>{$this->createslug($msg['DS_NOME_CASO'])}, "idperfil"=>{$msg['NR_SEQ_CADASTRO_CASO']}], "perfil", TRUE)}" class="image">
                            {if file_exists("arquivos/uploads/reverbme/$foto_completa")}
                                <img src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>50, 'altura'=>61, 'imagem'=>$foto_completa],"imagem", TRUE)}" width="50" height="61" alt="{$msg['DS_NOME_CASO']}" />
                            {else}
                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>50, 'altura'=>61, 'imagem'=>'not_found_bkp.jpg'],"imagem", TRUE)}" width="50" height="61" alt="{$msg['DS_NOME_CASO']}" />
                            {/if}
                        </a>
                            <p class="comment-name">
                                <a href="{$this->url(["nome"=>{$this->createslug($msg['DS_NOME_CASO'])}, "idperfil"=>$msg['NR_SEQ_CADASTRO_CASO']], "perfil", TRUE)}" class="image">{$msg['DS_NOME_CASO']}</a>
                            </p>
                    </div>

                    <div class="comment-detail">
                        {*|replace:"http://":"https://"*}
                        <p>
                            {if $msg['DS_MSG_MESO']|strstr:"youtube"}
                                {$msg['DS_MSG_MESO']|replace:"http://":"https://"}
                            {else}
                                {$msg['DS_MSG_MESO']}
                            {/if}
                        </p>
                        {foreach from=$msg->findDependentRowset('Default_Model_Mensagens') item=mensagem_filhas}
                        <div class="replied-item">
                            {if $codigo_usuario eq $mensagem_filhas->NR_SEQ_CADASTRO_CASO or $codigo_usuario == 2}
                                <a href="{$this->url(["idcomentario"=>{$mensagem_filhas->NR_SEQ_MSG_MESO}], "deletarcomentarioforum", TRUE)}" class="md-close">Excluir</a>
                            {/if}
                            <p class="person-name">{$mensagem_filhas->findParentRow('Default_Model_Reverbme')->DS_NOME_CASO}</p>
                            <ul class="status-comment">
                                <li class="status-item">

                                        {*<span class="likes-tooltip">*}
                                            {*<a href="">Daniel</a><br/>*}
                                            {*<a href="">Tony</a><br/>*}
                                            {*<a href="">Miriã</a><br/>*}
                                        {*</span>*}
                                        <a href="{$this->url(["idmsg"=>{$mensagem_filhas->NR_SEQ_MSG_MESO}], 'curtirmsg', TRUE)}">
                                            <span class="likes">
                                        {$mensagem_filhas->NR_CURTIRAM_MESO} curtiu
                                                </span>
                                        </a>
                                </li>
                                <li class="status-item">
                                   <a href="{$this->url(["idmsg"=>{$mensagem_filhas->NR_SEQ_MSG_MESO}], 'naocurtirmsg', TRUE)}"> <span class="notlikes"> {$mensagem_filhas->NR_NAOCURTIRAM_MESO}  não curtiram</span></a>
                                </li>
                                <li class="status-item">
                                    <span class="timestamp">{$mensagem_filhas->DT_CADASTRO_MESO|date_format:"%d/%m/%Y"} ás {$mensagem_filhas->DT_CADASTRO_MESO|date_format:"%H:%M"}</span>
                                </li>
                            </ul>
                            <p class="person-answer">{$mensagem_filhas->DS_MSG_MESO|regex_replace:"/(<p>|<p [^>]*>|<\\/p>)/":""}</p>
                        </div> <!-- replied-item -->
                       {/foreach}

                        <div class="user-reply-comment disabled">
                            <p class="person-name">{$_nome_usuario}</p>
                            <div class="clearfix"></div>
                            <form action="{$this->url(["idforum"=>{$topico->NR_SEQ_TOPICO_TOSO}], "comentarforum", TRUE)}" method="post">
                                <input type="hidden" name="idmensagem_pai" value="{$msg['NR_SEQ_MSG_MESO']}">
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

    <div id="paginacao" class="posreflole">
        <ul class="pagination">
            {if $pages.previous}
                <li class="item"> 
                        <a class="linkpagination" title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"forum", "action"=>"detalheforum", "titulo"=>{$this->createslug($topico->DS_TOPICO_TOSO)}, "idforum"=>{$topico->NR_SEQ_TOPICO_TOSO}, "page"=>{$pages.next}], "detalheforum", TRUE)}"><</a>
                </li>
            {/if}
            {section name=page_loop start=$this->mensagens->current_page-1 loop=$this->mensagens->current_page+3 step=1}
                <li class="item">
                    <a class="linkpagination" href="{$this->url(["module"=>"default", "controller"=>"forum", "action"=>"detalheforum", "titulo"=>{$this->createslug($topico->DS_TOPICO_TOSO)}, "idforum"=>{$topico->NR_SEQ_TOPICO_TOSO},"page"=>$smarty.section.page_loop.index+1], "detalheforum", TRUE)}">
                        {$smarty.section.page_loop.index+1}
                    </a>
                </li>
            {/section}
            {if $pages.next}
                <li class="item">
                    <a class="linkpagination" title="Próxima Página" href="{$this->url(["module"=>"default", "controller"=>"forum", "action"=>"detalheforum", "titulo"=>{$this->createslug($topico->DS_TOPICO_TOSO)}, "idforum"=>{$topico->NR_SEQ_TOPICO_TOSO}, "page"=>{$pages.next}], "detalheforum", TRUE)}">></a>
                </li>
            {/if}
        </ul>
    </div>
</div>
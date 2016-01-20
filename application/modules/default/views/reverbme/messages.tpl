{*{foreach from=$recados item=recado}*}
    {*<div class="rvb-comment-box">*}
        {*<!-- <a href="{$this->url(["idrecado"=>{$recado->NR_SEQ_SCRAP_SBRC}], "deletarrecado", TRUE)}" data-message-id="{$recado->NR_SEQ_SCRAP_SBRC}" class="md-close ir" title="Remover mensagem">Excluir</a> -->*}
        {*<p class="rvb-comment-author-name">*}
            {*<a href="{$this->url(["nome"=>{$this->createslug($recado->DS_NOME_CASO)}, "idperfil"=>{$recado->NR_SEQ_CADASTRO_CASO}], "perfil", TRUE)}">*}
                {*{$recado->DS_NOME_CASO}*}
            {*</a>*}
        {*</p>*}
        {*<p class="rvb-comment-date">*}
            {*{assign var="datarecado" value=$recado->DT_POST_SBRC|cat:" -3 hour"}*}
            {*{$datarecado|date_format:"%Y-%m-%d %H:%M:%S"}*}
        {*</p>*}
        {*<div class="rvb-comment-message">*}
            {*{$recado->DS_POST_SBRC}*}
        {*</div>*}
        {*<div class="rvb-comment-buttons">*}
            {*<a href="{$this->url(["nome"=>{$this->createslug($recado->DS_NOME_CASO)}, "idperfil"=>{$recado->NR_SEQ_CADASTRO_CASO}], "perfil", TRUE)}" class="button">Responder |</a>*}
            {*<a href="{$this->url(["idrecado"=>{$recado->NR_SEQ_SCRAP_SBRC}], "deletarrecado", TRUE)}" class="button">Excluir</a>*}
        {*</div>*}
    {*</div>*}
{*{/foreach}*}


<div class="about-this-post clearfix">
    <p class="title-category">Comentários</p>
    {assign var="count" value="1"}
    {foreach from=$recados item=comentario}
        {assign var="foto" value="{$comentario->NR_SEQ_CADASTRO_CASO}"}
        {assign var="extensao" value="{$comentario->DS_EXT_CACH}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
        <div class="comments-item {if $count > 4}hide{/if}">
            <div class="list-of-comments clearfix">
                <div class="comment-item">
                    <div class="comment-person">
                        <a rel="nofollow" href="{$this->url(["nome"=>{$this->createslug($comentario->DS_NOME_CASO)}, "idperfil"=>{$comentario->NR_SEQ_CADASTRO_CASO}], "perfil", TRUE)}">
                            {if file_exists("arquivos/uploads/reverbme/$foto_completa")}
                                <img src="{$this->Url(['tipo'=>"reverbme", 'crop'=>1, 'largura'=>61, 'altura'=>65, 'imagem'=>$foto_completa],"imagem", TRUE)}" width="61" height="65" alt="{$comentario->DS_NOME_CASO}" />
                            {else}
                                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>61, 'altura'=>65, 'imagem'=>'not_found_bkp.jpg'],"imagem", TRUE)}" width="61" height="65" alt="{$comentario->DS_NOME_CASO}" />
                            {/if}
                        </a>
                    </div>
                    <div class="comment-detail">
                        <p>
                            {$this->utf8($comentario->DS_POST_SBRC)}
                        </p>
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

{*<div class="rvb-comment">*}
    {*<form action="{$this->url(["idproduto"=>{$produto->NR_SEQ_PRODUTO_PRRC}], "comentarproduto", TRUE)}" method="post">*}
        {*{if $_logado neq 1}*}
            {*<p class="not-logado">*}
                {*Olá! Você precisa estar logado para comentar. <a href="{$this->url([], "reverbme", TRUE)}">Clique aqui </a> e faça um cadastro super rápido!*}
            {*</p>*}
        {*{else}*}
            {*<textarea name="comentario" placeholder="Escreva seu comentário" cols="30" rows="10" class="message-box full-comment tynemce-on"></textarea>*}
            {*<input type="hidden" name="extensao" value="{$produto->DS_EXT_PRRC}"/>*}
            {*<div class="send-button">*}
                {*<button type="submit" class="btn">COMENTAR</button>*}
            {*</div>*}
        {*{/if}*}

    {*</form>*}
{*</div>*}
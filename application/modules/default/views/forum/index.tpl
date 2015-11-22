    <div
        class="banners-advertisement cycle-slideshow"
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
    <div class="rvb-social-infos">
        <span class="label-tips">
            <span class="label-tips-circle new ir">Círculos verdes:</span>
            <span class="label-tips-text">Tópico ou enquetes novos</span>
        </span>
        <span class="label-tips">
            <span class="label-tips-circle hot ir">Círculos laranjas:</span>
            <span class="label-tips-text">Tópico / enquetes hot!</span>
        </span>
        <span class="label-tips">
            <span class="label-tips-circle ir">Círculos cinzas:</span>
            <span class="label-tips-text">Tópico / enquetes geral / lidos</span>
        </span>

        {include file="share-buttons.tpl"}
    </div>

    <div id="texto-reverbme">
        <p>Que tal passar um tempo conversando com uma galera que tem o mesmo gosto que você? No facebook tem aquela tia, tio, sobrinho chatos, mas aqui no nosso fórum não tem nada disso! Apenas quem realmente curte música boa participa desta comunidade.

    </p>
    </div>

    <div class="clearfix"></div>

    <div id="header">
        <ul class="abas">
            <li> <div class="aba"> <span>Tab 1</span> </div> </li>
            <li> <div class="aba"> <span>Tab 2</span> </div> </li>
        </ul>
    </div>

    {*<div class="rvb-column left">*}
    <div>
    {*<!-- ultimos posts -->*}
      {*{foreach from=$topicos_destaque item=destaque}*}
        {*<div class="rvb-forum-latest-posts">*}
            {*<a href="{$this->url(["titulo"=>{$this->createslug($destaque->DS_TOPICO_TOSO)}, "idforum"=>{$destaque->NR_SEQ_TOPICO_TOSO}], 'detalheforum', TRUE)}">*}
                {*<div class="rvb-forum-latest-item title">{$destaque->DS_TOPICO_TOSO|truncate:17:"...":TRUE}</div>*}
            {*</a>*}
            {*<a href="{$this->url(["nome"=>{$this->createslug($destaque->DS_NOME_CASO)}, "idperfil"=>{$destaque->NR_SEQ_CADASTRO_CASO}], "perfil", TRUE)}">*}
                {*<div class="rvb-forum-latest-item author">{$destaque->DS_NOME_CASO|truncate:10:"...":TRUE}</div>*}
            {*</a>*}
            {*<div class="rvb-forum-latest-item total-posts">{$destaque->NR_MSGS_TOSO} posts</div>*}
        {*</div>*}
      {*{/foreach}*}
        <!-- Busca -->
        <div class="rvb-forum-form clearfix">
            <form action="{$this->url([], "forum", TRUE)}" method="post" id="search-post">
                <div class="input-txt">
                    <input type="text" class="input-box" placeholder="Procurar post" name="busca">
                </div>
                <div class="search-icon">
                    <button type="submit" class="search-icon">Procurar</button>
                </div>
            </form>
        </div>
        <!-- end busca -->
        {if $idusuario eq 2 or $idusuario eq 6605 or $idusuario eq 4162 or $idusuario eq 32609}
          <div class="rvb-forum-search-post small">Fórum</div>
          <div class="rvb-new-item md-trigger small" data-modal="enviar-todos-lightbox">Enviar para todos</div>
          <div class="rvb-new-item md-trigger small" data-modal="criar-topico-lightbox">Criar tópico</div>
        {else}
          <div class="rvb-forum-search-post">Fórum</div>
          <div class="rvb-new-item md-trigger right" data-modal="criar-topico-lightbox">Criar tópico</div>
        {/if}


        <table class="rvb-table-list-of-posts" id="topics-table">
            <thead>
                <tr class="row-header">
                    <th class="rvb-table-lists-item header topic">Tópico</th>
                    <th class="rvb-table-lists-item header">Autor</th>
                    <th class="rvb-table-lists-item header">Posts</th>
                    <th class="rvb-table-lists-item header">Last Post</th>
                </tr>
            </thead>
            <tbody>
                <tr class="row-content">
                    <td class="rvb-table-lists-item content topic"><a class="post hot" href="{$this->url(["titulo"=>{$this->createslug($hot_topico->DS_TOPICO_TOSO)}, "idforum"=>{$hot_topico->NR_SEQ_TOPICO_TOSO}], 'detalheforum', TRUE)}">{$hot_topico->DS_TOPICO_TOSO}</a></td>
                    <!-- Usar class="post hot" para destaque, usar  class="post new" para novo, usar class="post" para comum-->
                    <td class="rvb-table-lists-item content author"><a href="{$this->url(["nome"=>{$this->createslug($hot_topico->DS_NOME_CASO)}, "idperfil"=>{$hot_topico->NR_SEQ_CADASTRO_CASO}], "perfil", TRUE)}">{$hot_topico->DS_NOME_CASO}</a></td>
                    <td class="rvb-table-lists-item content">{$hot_topico->NR_MSGS_TOSO}</td>
                    <td class="rvb-table-lists-item content">{$hot_topico->DT_ULTIMOPOST_TOSO|date_format:"%d/%m/%Y"}</td>
                </tr>
                <tr class="row-content">
                    <td class="rvb-table-lists-item content topic"><a class="post new" href="{$this->url(["titulo"=>{$this->createslug($ultimo_topico->DS_TOPICO_TOSO)}, "idforum"=>{$ultimo_topico->NR_SEQ_TOPICO_TOSO}], 'detalheforum', TRUE)}">{$ultimo_topico->DS_TOPICO_TOSO}</a></td>
                    <!-- Usar class="post hot" para destaque, usar  class="post new" para novo, usar class="post" para comum-->
                    <td class="rvb-table-lists-item content author"><a href="{$this->url(["nome"=>{$this->createslug($ultimo_topico->DS_NOME_CASO)}, "idperfil"=>{$ultimo_topico->NR_SEQ_CADASTRO_CASO}], "perfil", TRUE)}">{$ultimo_topico->DS_NOME_CASO}</a></td>
                    <td class="rvb-table-lists-item content">{$ultimo_topico->NR_MSGS_TOSO}</td>
                    <td class="rvb-table-lists-item content">{$ultimo_topico->DT_ULTIMOPOST_TOSO|date_format:"%d/%m/%Y"}</td>
                </tr>
              {foreach from=$topicos item=topico}
                <tr class="row-content">
                    <td class="rvb-table-lists-item content topic"><a class="post" href="{$this->url(["titulo"=>{$this->createslug($topico->DS_TOPICO_TOSO)}, "idforum"=>{$topico->NR_SEQ_TOPICO_TOSO}], 'detalheforum', TRUE)}">{$topico->DS_TOPICO_TOSO}</a></td>
                    <!-- Usar class="post hot" para destaque, usar  class="post new" para novo, usar class="post" para comum-->
                    <td class="rvb-table-lists-item content author"><a href="{$this->url(["nome"=>{$this->createslug($topico->DS_NOME_CASO)}, "idperfil"=>{$topico->NR_SEQ_CADASTRO_CASO}], "perfil", TRUE)}">{$topico->DS_NOME_CASO}</a></td>
                    <td class="rvb-table-lists-item content">{$topico->NR_MSGS_TOSO}</td>
                    <td class="rvb-table-lists-item content">{$topico->DT_ULTIMOPOST_TOSO|date_format:"%d/%m/%Y"}</td>
                </tr>
              {/foreach}
            </tbody>
        </table>
        <div>
            <button class="show-more" id="show-more-topics" type="button">Clique para carregar mais</button>
            <div class="forum-loder">Carregando</div>
        </div>
    </div>
    <div class="rvb-column right">
        <!-- ultimas enquetes -->
      {foreach from=$enquetes_hot item=hot}
        <div class="rvb-poll-latest-polls">
            <div class="rvb-poll-latest-item title">{$hot->titulo_enquete|truncate:20:"...":TRUE}</div>
            <div class="rvb-poll-latest-item author">{$hot->DS_NOME_CASO|truncate:20:"...":TRUE}</div>
            <div class="rvb-poll-latest-item total-votes">{$hot->total_votos} votos</div>
        </div>
      {/foreach}
        <div class="rvb-poll-search-poll">Enquete</div>
        <div class="rvb-new-item md-trigger" data-modal="new-poll-lightbox">Criar enquete</div>
        <div class="rvb-poll-form clearfix">
            <form action="#" method="post" id="search-poll">
                <div class="input-txt">
                    <input type="text" class="input-box" placeholder="Procurar enquete" name="busca_enquete">
                </div>
                <div class="search-icon">
                    <button type="submit" class="search-icon">Procurar</button>
                </div>
            </form>
        </div>
        <table class="rvb-table-list-of-posts" id="polls-table">
            <thead>
                <tr class="row-header">
                    <th class="rvb-table-lists-item header topic">Enquete</th>
                    <th class="rvb-table-lists-item header">Autor</th>
                    <th class="rvb-table-lists-item header">Votos</th>
                    <th class="rvb-table-lists-item header">Aberto</th>
                </tr>
            </thead>
            <tbody>
                <tr class="row-content">
                    <td class="rvb-table-lists-item content topic">
                        <a class="post hot" href="{$this->url(["idenquete"=>{$hot_enquete->idenquete}], "enquete", TRUE)}">{utf8_decode($hot_enquete->titulo_enquete)}</a>
                    </td>
                    <td class="rvb-table-lists-item content"><a href="{$this->url(["nome"=>{$this->createslug($hot_enquete->DS_NOME_CASO)}, "idperfil"=>{$hot_enquete->NR_SEQ_CADASTRO_CASO}], 'perfil', TRUE)}">{$hot_enquete->DS_NOME_CASO}</a></td>
                    <td class="rvb-table-lists-item content">{$hot_enquete->total_votos}</td>
                    <td class="rvb-table-lists-item content">{$hot_enquete->data_inicio|date_format:"%d/%m/%y"}</td>
                </tr>
                <tr class="row-content">
                    <td class="rvb-table-lists-item content topic">
                        <a class="post new" href="{$this->url(["idenquete"=>{$nova_enquete->idenquete}], "enquete", TRUE)}">{utf8_decode($nova_enquete->titulo_enquete)}</a>
                    </td>
                    <td class="rvb-table-lists-item content"><a href="{$this->url(["nome"=>{$this->createslug($nova_enquete->DS_NOME_CASO)}, "idperfil"=>{$nova_enquete->NR_SEQ_CADASTRO_CASO}], 'perfil', TRUE)}">{$nova_enquete->DS_NOME_CASO}</a></td>
                    <td class="rvb-table-lists-item content">{$nova_enquete->total_votos}</td>
                    <td class="rvb-table-lists-item content">{$nova_enquete->data_inicio|date_format:"%d/%m/%y"}</td>
                </tr>
                {foreach from=$enquetes item=enquete}
                <tr class="row-content">
                    <td class="rvb-table-lists-item content topic">
                        <a class="post" href="{$this->url(["idenquete"=>{$enquete->idenquete}], "enquete", TRUE)}">{utf8_decode($enquete->titulo_enquete)}</a>
                    </td>
                    <td class="rvb-table-lists-item content"><a href="{$this->url(["nome"=>{$this->createslug($enquete->DS_NOME_CASO)}, "idperfil"=>{$enquete->NR_SEQ_CADASTRO_CASO}], 'perfil', TRUE)}">{$enquete->DS_NOME_CASO}</a></td>
                    <td class="rvb-table-lists-item content">{$enquete->total_votos}</td>
                    <td class="rvb-table-lists-item content">{$enquete->data_inicio|date_format:"%d/%m/%y"}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        <div>
            <button class="show-more" id="show-more-polls" type="button">Clique para carregar mais</button>
            <div class="forum-loder">Carregando</div>
        </div>
    </div>
    {include file="suggestion-products.tpl"}
</div>

<!-- lightbox de nova enquete -->
<div class="md-modal md-effect-1" id="new-poll-lightbox">
    <div class="md-content">
        <p class="md-title">Cadastre a nova enquete</p>
        <div>
            <button class="md-close ir">Fechar</button>
            <form id="form-cadastro-nova-enquete" action="{$this->url([], "criarenquete", TRUE)}" method="POST" enctype="multipart/form-data">
                <div id="textos">
                    <label for="assunto" class="posreflole">ASSUNTO</label>
                    <input type="text" id="assunto" name="assunto" class="posreflole" required>
                    <label for="descricao" class="posreflole">DESCRIÇÃO</label>
                    <textarea name="descricao" id="descricao" class="posreflole" required placeholder="Descreva sua enquete..."></textarea>
                    <div class="clearfix"></div>
                </div>
                <div id="selects">
                    <div id="pme" class="posreflole">
                        <span class="posreflole">Permitir múltipla escolha?</span>
                        <input type="radio" name="radiog_dark" id="sim" class="css-checkbox" checked="checked" value="1">
                        <label for="sim" class="css-label">SIM</label>
                        <input type="radio" name="radiog_dark" id="nao" class="css-checkbox" value="0">
                        <label for="nao" class="css-label">NÃO</label>
                    </div>
                    <div id="qev" class="posreflole">
                        <span class="posreflole">Quando encerra a votação?</span>
                        <div id="data-enquete">
                            <span>Selecione uma data</span>
                            <input type="text" id="dataselecionada" name="dataselecionada" class="datepicker">
                        </div>
                    </div>
                    <div id="ajeita-checks" class="posreflole">
                        <input type="checkbox" name="resultado" id="resultado" class="css-checkbox" checked="checked"/>
                        <label for="resultado" class="css-label">EXIBIR RESULTADO</label>
                        <input type="checkbox" name="datadefinalizacao" id="datadefinalizacao" class="css-checkbox"/>
                        <label for="datadefinalizacao" class="css-label">SEM DATA DE FINALIZAÇÃO</label>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="title-full">Cadastre as opções</div>
                <div id="cad-novaopc">
                    <label for="opcao" id="lop" class="posreflole">OPÇÃO:</label>
                    <input type="text" id="opcao" name="opcao" class="posreflole">
                    <a href="#" id="cadastrarop">ADICIONAR</a>
                </div>
                <ul id="listadeopcoes" class="posreflole"></ul>
                <span id="texto-footer" class="posreflole">Tá curioso para saber quantas pessoas apoiam sua ideia? Abra um enquete e veja quem mais pensa como você ou fique triste sabendo que você está sozinho com sua opinião.</span>
                <div class="send-button">
                    <button type="submit" class="btn" id="aceitarecriar">Aceitar e criar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- lightbox criar tópico -->
<div class="md-modal md-effect-1" id="criar-topico-lightbox">
    <div class="md-content">
        <p class="md-title">Criar Tópico</p>
        <button class="md-close ir">Fechar</button>
        <form action="{$this->url([], "criarforum", TRUE)}" method="post" id="frm-create-topic">
            <div class="md-bg">
                <div class="frm-field">
                    <label for="forum-titulo">Título</label>
                    <input id="forum-titulo" name="titulo" type="text" required>
                </div>
                <div class="frm-field">
                    <label for="forum-post">Mensagem</label>
                    <textarea name="mensagem" id="forum-post" placeholder="Escreva uma mensagem..." required></textarea>
                </div>
            </div>
            <p>Você vai criar um tópico pedindo a camiseta de alguma banda? Tem certeza? Olha que já temos um tópico especifico só pra isso, não precisa ser egoísta! Antes de “Aceitar e Criar” tenha certeza que não está ofendendo nenhum amiguinho e também cuidado com o português, por aqui não temos opção de editar.</p>
            <div class="send-button">
                <button class="btn" type="submit">Aceitar e criar</button>
            </div>
        </form>
    </div>
</div>

<!-- lightbox enviar para todos -->
<div class="md-modal md-effect-1" id="enviar-todos-lightbox">
    <div class="md-content">
        <p class="md-title">Enviar para todos</p>
        <button class="md-close ir">Fechar</button>
        <form action="{$this->url([], "escrevertodos")}" method="post" id="frm-enviar-todos">
            <div class="md-bg">
                <div class="frm-field">
                    <label for="forum-msg">Mensagem</label>
                    <textarea name="mensagem" class="tinymce-on" id="forum-msg" placeholder="Escreva uma mensagem..."></textarea>
                </div>
            </div>
            <div class="send-button">
                <button class="btn" type="submit">Aceitar e criar</button>
            </div>
        </form>
    </div>
</div>


{include file="lightbox-indique.tpl"}

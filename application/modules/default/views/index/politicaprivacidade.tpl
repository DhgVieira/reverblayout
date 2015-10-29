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


<h1 class="rvb-title">Política de Privacidade </h1>
<div class="left-column-content">
<ul id="lista-help" class="posreflole">
    <li>
        <a href="#" id="li1">1. POLITICA DE PRIVACIDADE REVERBCITY</a>
        <div class="conteudo-li1">
            <span class="titulo">A REVERBCITY  (“http://www.reverbcity.com”) </span>
            Garante a máxima privacidade e proteção dos dados de caráter pessoal (os "Dados Pessoais") que os usuários ("Usuários") do Site na Internet de sua propriedade, localizado no endereço eletrônico www.reverbcity.com ("Site") inserem no Site a fim de utilizar seus serviços. Assim, a Reverbcity.com garante a devida reserva das informações confidenciais no momento da contratação dos serviços oferecidos no Site e pelo uso do Site.  <br>

            O propósito desta Política é informá-lo sobre os tipos de informação que coletamos sobre você durante sua visita ao nosso website, como podemos utilizar essas informações e como as divulgamos a terceiros.  Se tiver dúvidas sobre esta política, pedimos nos contatar por e-mail, em atendimento@reverbcity.com . <br>
 
            <span class="titulo">QUEM É O RESPONSAVEL PELAS INFORMAÇÕES PESSOAS OBTIDAS?</span>
            A Reverbcity.com controla os dados pessoais obtidos nesse site.<br><br>

            <span class="titulo">OBTENÇÃO E USO DE DADOS PESSOAIS:</span>
                A Reverbcity.com solicita seus dados pessoais (incluindo nome, endereço, telefone e e-mail) para:<br>

                Responder a perguntas ou pedidos feitos por você<br>
                Processar pedidos ou solicitações feitas por você<br>
                Administrar ou conduzir nossas obrigações em relação a qualquer contrato que você tenha conosco<br>
                Antecipar e resolver problemas com quaisquer produtos fornecidos ou serviços prestados a você.<br><br>

            <span class="titulo">USO DO SITE</span>
               O uso do site é uma decisão pessoal do usuário. A Reverbcity se exime de qualquer garantia relativa aos resultados do uso do site. Em nenhuma hipótese, a Reverbcity será responsável por danos ocasionados no site ou a partir do site, seja por motivo de ofensas, de informações equivocadas, ou qualquer outro.<br><br>

            <span class="titulo">USUÁRIOS SEM REGISTRO</span>
               Para aproveitar as várias funções de personalização da Reverbcity, sugerimos que você faça seu registro conosco. Se você não quiser se registrar, no entanto, poderá aproveitar as funções do Site que não exigem registro. Se preferir não se registrar, as informações obtidas por nós serão mais limitadas. Obteremos, por exemplo, o seu endereço de IP para ajudar a diagnosticar problemas com nosso servidor, administrar o Site e rastrear estatísticas de utilização.<br><br>

             <span class="titulo">USUÁRIOS REGISTRADOS NA REVERBCITY</span>
               Ao receber o seu registro, coletamos informações pessoais suas, além das informações não-pessoais. Essas informações pessoais podem incluir dados digitados manualmente por você em nossos formulários, como por exemplo, seu nome, endereço de email, endereço para entrega. Podemos armazenar todas ou algumas dessas informações em um arquivo cookie no seu disco rígido, para que o nosso sistema reconheça você a cada visita sua ao nosso Site. Dessa maneira, podemos salvar as suas preferências a cada visita e assim apresentar a você um Site customizado, sem obrigá-lo a fazer o login cada vez que visita o nosso Site. <br><br>

            <span class="titulo">COMPRA SEGURA</span>
               Os dados fornecidos durante o seu processo de compra podem ser compartilhados com algumas empresas parceiras da Reverbcity, como a operadora de cartão de crédito, bancos e com os Correios, com o único objetivo de efetuar todos os processos dos serviços contratados. No caso das compras por meio do cartão de crédito, a Reverbcity usa o seu número de cartão apenas para o processamento da compra, e logo após a sua confirmação por meio da administradora ele é eliminado e de nenhuma forma fica registrado em nossos bancos de dados.<br><br>

            <span class="titulo">OBTENÇÃO DE INFORMAÇÕES DE CONHECIMENTO PÚBLICO</span>
               Poderemos coletar automaticamente informações de conhecimento público sobre você, tais como o tipo de navegador de internet que você usa ou o site a partir do qual você se conectou ao nosso site. Também poderemos agregar detalhes de conhecimento público que você forneceu a esse site (por exemplo, sua idade e a cidade onde vive). Você não poderá ser identificado a partir desses dados, que serão usados somente para nos ajudar a prestar um serviço eficiente nesse site.<br>  

                Se você chegar ao nosso Site clicando em algum link ou anúncio em outro site, também coletamos essa informação. Isso nos ajuda a maximizar nossa exposição na Internet e entender os interesses dos nossos usuários. Todas essas informações são coletadas e usadas apenas de forma geral; isso quer dizer que elas entram em nossa base de dados, onde podemos usá-las para gerar relatórios gerais sobre nossos visitantes, mas não relatórios sobre visitantes individuais.<br><br>

            <span class="titulo">FORUM, BLOG, ATENDIMENTO ONLINE, REVERBPEOPLE, FESTAS, REVERBME E REVERBCYCLE</span>
               
                Poderemos coletar os dados que você divulgar através do FORUM, BLOG, ATENDIMENTO ONLINE, REVERBPEOPLE, FESTAS, REVERBME E REVERBCYCLE. Tais dados  serão usados de acordo com essa política de privacidade. Observe que não poderemos nos responsabilizar pelo uso que terceiros fizerem dos dados pessoais que você divulgar através de qualquer um destes meios. Tome cuidado com a informação pessoal que você prestar dessa maneira.<br><br>

        </div>
    </li>
    <li>
        <a href="#" id="li2">2. COMO USAMOS AS SUAS INFORMAÇÕES</a>
        <div class="conteudo-li2">
            <span class="titulo">SEGURANÇA DAS SUAS INFORMAÇÕES</span>
                Este website toma todos os cuidados para proteger as informações de nossos usuários. Quando os usuários fornecem informações confidenciais por meio do website, suas informações são protegidas on-line e off-line. Quando nosso formulário de inscrição/pedido solicita que os usuários digitem informações confidenciais na finalização da compra (como o número do cartão de crédito), essas informações são criptografadas e protegidas com o melhor software de criptografia do mercado, o SSL (Secure Sockets Layer), através do gateway fornecido pela locaweb. <br><br>

            <span class="titulo">SERVIÇOS</span>
                Utilizamos suas informações pessoais para fornecer quaisquer serviços que você solicitar ou exigir, para nos comunicarmos com você e permitir que você faça compras. Utilizamos as informações não pessoais que coletamos para analisar como nossos websites estão sendo utilizados e aprimorar o conteúdo de nossos websites, ofertas de produtos on-line e iniciativas promocionais.<br>

                INFORMATIVOS POR EMAIL
                Se você nos enviar um e-mail com perguntas ou comentários, poderemos usar suas informações pessoais para responder as suas perguntas ou comentários, e poderemos salvar suas perguntas ou comentários para consulta no futuro.  Quando você permitir ou assinar a nosso boletim informativo eletrônico (newsletter), iremos enviar  informações sobre nosso site para seu e-mail, como promoções, lançamentos, sorteios, entre outros. Contudo, forneceremos a opção de alterar suas preferências e optar por não receber mais essas comunicações.<br><br>
    </li>

    <li>
        <a href="#" id="li2">3. ATUALIZAÇÕES DESTA POLÍTICA DE PRIVACIDADE</a>
        <div class="conteudo-li2">
            <span class="titulo">ATUALIZAÇÕES DESTA POLÍTICA DE PRIVACIDADE</span>
               
            A Reverbcity reserva-se o direito de alterar esta Política de Privacidade.  Qualquer alteração será publicada nesta página sem aviso prévio, portando aconselha-se a visitar periodicamente estes termos.<br>

            REVERBCITY | Música que Veste.<br>
            ANTONIO M. DIAS CONFECÇÕES |  CNPJ 08.345.875/0001-37 <br>
            Londrina | Rua Ibiporã, 995 - Jardim Aurora, PR 86060-510 – Fone: (43)3322-8852<br><br>

        </div>
    </li>

</ul>
</div>
<div class="sidebar-ui">
    <div class="chat">
        <a href="#" class="chat-button ir">Atendimento Lojista On-Line</a>
    </div>

    <ul class="socials-network-dark">
        <li><a href="https://www.facebook.com/Reverbcity" target="_blank" class="icon facebook ir">Facebook</a></li>
        <li><a href="https://twitter.com/reverbcity" target="_blank" class="icon twitter ir">Twitter</a></li>
        <li><a href="http://reverbcity.tumblr.com/" target="_blank" class="icon tumblr ir">Tumblr</a></li>
        <li><a href="http://instagram.com/reverbcity" target="_blank" class="icon instagram ir">Instagram</a></li>
        <li><a href="http://pinterest.com/reverbcity/" target="_blank" class="icon pinterest ir">Pinterest</a></li>
        <li class="last"><a href="http://reverbcity.com/rss/rss.php" class="icon rss ir">RSS</a></li>
    </ul>

    <div class="fundo-verde">
        <form id="form-login-reverbme" method="post" action="{$this->url([], 'login', TRUE)}">
            <p class="legend">Reverbme</p>
            <div class="input-txt">
                <input class="input-box" type="text"     name="email" placeholder="E-mail" required>
            </div>
            <div class="input-txt">
                <input class="input-box" type="password" name="senha" placeholder="Senha" required>
            </div>
            <div class="send-button">
                <button type="submit" class="btn">Login</button>
                <a class="btn" href="{$this->url([], 'reverbme', TRUE)}">Cadastre-se</a>
                <label for="staylogged">
                    <input id="staylogged" type="checkbox"> Permanecer logado
                </label>
            </div>
        </form>

        <ul class="reverb-people">
            {foreach from=$fotos item=foto}
                {assign var="foto_people" value="{$foto['NR_SEQ_FOTO_FORC']}"}
                {assign var="extensao" value="{$foto['DS_EXT_FORC']}"}
                {assign var="foto_completa" value="{$foto_people}.{$extensao}"}
                <li><img src="{$this->Url(['tipo'=>"people", 'crop'=>1, 'largura'=>45, 'altura'=>45, 'imagem'=>$foto_completa],
                                        "imagem", TRUE)}"  alt="{$foto->DS_NOME_FORC}" width="45" height="45" /></li>
            {/foreach}
        </ul>
    </div>

    <div class="blog-post clearfix">
        {assign var="foto_blog" value="{$post['NR_SEQ_BLOG_BLRC']}"}
        {assign var="extensao_blog" value="{$post['DS_EXT_BLRC']}"}
        {assign var="foto_completa_blog" value="{$foto_people}.{$extensao}"}
        <p class="cover-title ir">Blog</p>
        <a class="blog-image" href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}">
            <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>220, 'altura'=>110, 'imagem'=>$foto_completa_blog],"imagem", TRUE)}" alt="{utf8_decode($post->DS_TITULO_BLRC)}"/>
        </a>
        <p class="blog-title">
            <a href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}">{utf8_decode($post->DS_TITULO_BLRC|strip_tags)}</a>
        </p>
        <p class="authoring">
          <span class="period">{$post->DT_PUBLICACAO_BLRC|date_format:'%Y/%m/%d'} ás {$post->DT_PUBLICACAO_BLRC|date_format:"%H:%M"}h</span>
          Por: <strong>Reverbcity</strong>
        </p>
        <p class="tiny-post">{utf8_decode($post->DS_TEXTO_BLRC|strip_tags|truncate:130:"...":true)}</p>
        <div class="full-post clearfix">
            <a href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}">Ler post completo</a>
        </div>
    </div>

    <p class="full-strip forum">Fórum</p>
    <ul class="collection-posts">
        {foreach from=$foruns item=forum}
            <li class="post-item">
                <a href="{$this->url(["titulo"=>{$this->createslug($forum->DS_TOPICO_TOSO)}, "idforum"=>{$forum->NR_SEQ_TOPICO_TOSO}], 'detalheforum', TRUE)}" class="post-link">
                    <span class="period">{$forum->DT_CADASTRO_TOSO|date_format:'%d/%m'} | </span>
                    <span class="title">{utf8_decode($forum->DS_TOPICO_TOSO|truncate:25:"...":TRUE)}</span>
                </a>
            </li>
        {/foreach}
    </ul>

    <div class="banners-sidebar cycle-slideshow"
         data-cycle-fx="fadeout"
         data-cycle-timeout="5000"
         data-cycle-slides="> a"
         data-cycle-log="false"
         data-cycle-pause-on-hover="true">
            {foreach from=$banners item=banner}
            {assign var="foto" value="{$banner->NR_SEQ_BANNER_BARC}"}
            {assign var="extensao" value="{$banner->DS_EXT_BARC}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
              <a href="{$banner->DS_LINK_BARC}">
                {if file_exists("arquivos/uploads/banners/$foto_completa")}
                  <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}"
                  />
                {else}
                  <img class="profile" src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="Avatar Padrão Rerverbcity">
                {/if}
              </a>
          {/foreach}
    </div>
</div>

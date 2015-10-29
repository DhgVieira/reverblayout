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
        <a href="#" id="li1">TERMOS DE USO</a>
        <div class="conteudo-li1">
            <span class="titulo">A REVERBCITY  (“http://www.reverbcity.com”) </span>
                Os TERMOS DE USO descritos à seguir regulamentam o uso do SITE www.reverbcity.com  e de seus conteúdos, que Reverbcity, disponibiliza aos usuários de Internet que o utilizam.<br>

                A utilização do SITE, por qualquer USUÁRIO, implicará em adesão e expressa aceitação quanto aos termos e condições dos TERMOS DE USO vigente na data de sua utilização. Recomendamos aos USUÁRIOS, que previamente à utilização dos serviços disponíveis realizem a leitura do TERMO DE USO vigente.<br>

                Integram os presentes TERMOS DE USO todos os avisos, regulamentos de uso e instruções levados ao conhecimento do USUÁRIO pela REVERBCITY.<br>

                Os usuários menores de 18 anos de idade somente poderão efetuar o registro ou cadastro neste site desde que devidamente representados ou assistidos, conforme previsto nos arts. 1.634 e 1.690 do código civil, por seus representantes ou assistentes legais, devendo esses ser responsáveis na esfera cível por todo e qualquer ato praticado pelos menores quando da utilização do site. Os representantes legais serão responsáveis, por todo e qualquer ato ilícito praticado pelos menores quando da utilização do site.<br>

                 A “REVERBCITY” será responsável em efetivar as vendas dos produtos para todo Brasil de acordo com as leis vigentes em nosso território.<br> 

                Através do SITE, a Reverbcity disponibiliza o acesso aos USUÁRIOS de diversos conteúdos. A Reverbcity se reserva o direito de modificar unilateralmente, a qualquer momento e sem prévio aviso, a apresentação e configuração do SITE, assim como o de eliminar ou modificar, os CONTEÚDOS, os TERMOS DE USO, assim como todos os avisos, regulamentos e instruções de uso.<br>

                Após o cadastro no website “www.reverbcity.com”, o Usuário poderá realizar as aquisições dos produtos e efetuar o pagamento durante o PERÍODO DE PUBLICAÇÃO.<br>

                Todas as informações fornecidas pelo Usuário devem ser exatas, precisas e verdadeiras, e devidamente atualizadas, caso ocorra qualquer alteração, reconhecendo o Usuário, ainda, que a “REVERBCITY” não tem a obrigação de verificar a precisão dos dados transmitidos pelo Usuário ou qualquer outra pessoa. Diante disso, a “REVERBCITY” não se responsabilizará pela correção de dados pessoais inseridos pelo Usuário, sendo certo que o Usuário – ou seus pais ou representantes legais, quando for o caso – garante e responde, em qualquer caso, pela veracidade, precisão e autenticidade dos dados pessoais cadastrados.<br>

                Fica ressalvado o direito do Usuário em retificar quaisquer dados enviados à “REVERBCITY”. Entretanto, o direito de retificação do Usuário não obstará ou substituirá o direito da “REVERBCITY” em pleitear as indenizações cabíveis, no caso de informações errôneas ensejarem quaisquer danos e/ou prejuízos à “REVERBCITY” ou a terceiros, no período anterior à sua retificação pelo Usuário; entendendo-se como tal o momento do efetivo recebimento de tal retificação pela “REVERBCITY”.<br>

                O produto devidamente comprado é irrevogável, nos ternos dos Artigos 427 e 429 do Código Civil de 2002, ressalvados as circunstâncias excepcionais.<br>

                Ao adquirir o produto e efetuar o pagamento através do Website “www.reverbcity.com”, o Usuário declara estar ciente de todos os Termos, condições de recebimento e todas as informações atinentes ao produto adquirido, de acordo com o disposto.<br>

                A “REVERBCITY” não será responsável pelas despesas com o frete, salvos nos casos de troca onde o laudo técnico confirme que o produto esteja com defeito de fábrica.<br>

                O cliente tem um prazo de 30 dias para entrar em contato explicando o motivo da troca do produto. Só serão aceitas trocas de peças sem uso e sem terem sido lavadas.<br>

                Os produtos para troca deverão ser encaminhados para a “Reverbcity” com o frete de envio pago.<br>

                A “REVERBCITY” não pode garantir de forma nenhuma que os serviços prestados pela empresa responsável pela gestão de pagamentos funcionará livres de erros, interrupções, mal-funcionamento, atrasos ou outras imperfeições. Ressalte-se que não será responsável pela disponibilidade ou não dos Serviços prestados pela empresa responsável pela gestão de pagamentos ou pela impossibilidade do uso do Serviço.<br>

                A “REVERBCITY” tomará todas as medidas possíveis para manter a confidencialidade, segurança e sigilo atinentes às informações dos Usuários, porém não responderá por prejuízo que possa ser derivado da violação dessas medidas por parte de terceiros que utilizem as redes públicas ou a internet, subvertendo os sistemas de segurança para acessar as informações de Usuários.<br>

                A “REVERBCITY” não será responsável por qualquer dano, prejuízo ou perda no equipamento do Usuário causado por falhas no sistema, no servidor ou na internet decorrentes de condutas de terceiros, ressalvado que eventualmente, o sistema poderá não estar disponível por motivos técnicos ou falhas da internet, ou por qualquer outro evento fortuito ou de força maior alheio ao seu controle.<br>

                Sem prejuízo de outras medidas, a “REVERBCITY” poderá advertir, cancelar, suspender, temporária ou definitivamente, a conta do Usuário a qualquer tempo, e iniciar as ações cabíveis, se o Usuário não cumprir qualquer dispositivo deste Termo de Utilização, se descumprir com seus deveres de Usuário, se não puder ser confirmada e verificada a identidade do Usuário ou se qualquer informação fornecida por ele esteja incorreta ou se verificar que os anúncios ou qualquer atitude do Usuário tenha causado algum dano a terceiros ou à própria “REVERBCITY” ou tenham a potencialidade de assim o fazer.<br>

                Caso o Usuário tenha seu cadastro inabilitado, todas as Aquisições de Produtos adquiridos serão automaticamente cancelados. Para dirimir qualquer dúvida, a “REVERBCITY” poderá, a qualquer tempo, a seu exclusivo critério, solicitar o envio de documentação pessoal do Usuário.<br>

                "Phishing" é uma forma de fraude eletrônica projetada para roubar informações pessoais. Se você receber um e-mail que parece ter sido enviado por nós, pedindo suas informações pessoais, não responda. A Reverbcity nunca irá solicitar sua senha, nome do usuário, informações de cartão de crédito ou outras informações pessoais através de e-mail.<br>

                A Reverbcity exime-se de responsabilidade pelos danos, prejuízos e/ou lucros cessantes de qualquer natureza que possam advir dos serviços prestados por terceiros através do SITE (REVERBCYCLE) e, em particular, pelos danos, prejuízos e/ou lucros cessantes que possam decorrer destes.<br>

                A REVERBCITY reserva-se o direito de recusar ou retirar o acesso ao SITE e/ou aos seus CONTEÚDOS, a qualquer momento e sem necessidade de prévio aviso, por iniciativa própria ou por exigência de um terceiro, daqueles USUÁRIOS que descumpram este TERMO DE USO ou que, de alguma forma, executem ações que resultem ou possam resultar em atividades ilegais.<br>

                A “REVERBCITY” se compromete a não ceder ou comercializar, sob nenhuma forma, informações individuais do Usuário cadastrado sem a sua expressa autorização.<br> 

                Conforme legislação protetiva do Código de Defesa do Consumidor é assegurado ao Usuário o direito de arrependimento, desde que este ocorra no prazo de 07 (sete) dias, contados da assinatura do contrato, ressalvados os casos em que o produto apresente vício, o que autoriza ao Usuário a desfazer o negócio com a “REVERBCITY”. Na hipótese de insatisfação, os custos com frete relativos à devolução dos itens adquiridos por meio do Site ficariam a cargo do Usuário.<br>

                Todos os itens deste Termo de Uso são regidos pela legislação brasileira vigente.<br>

                A Reverbcity reserva-se o direito de alterar estes Termos de Uso.  Qualquer alteração será publicada nesta página sem aviso prévio, portando aconselha-se a visitar periodicamente estes termos.<br><br>


                REVERBCITY | Música que Veste.
                ANTONIO M. DIAS CONFECÇÕES |  CNPJ 08.345.875/0001-37 
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
                <li>
                    {if file_exists("arquivos/uploads/people/$foto_completa")}
                        <img src="{$this->Url(['tipo'=>"people", 'crop'=>1, 'largura'=>45, 'altura'=>45, 'imagem'=>$foto_completa], "imagem", TRUE)}"  alt="{$foto->DS_NOME_FORC}" width="45" height="45" />
                    {else}
                        <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>45, 'altura'=>45, 'imagem'=>'not_found.jpg'], "imagem", TRUE)}"  alt="{$foto->DS_NOME_FORC}" width="45" height="45" />
                    {/if}
                </li>
            {/foreach}
        </ul>
    </div>

    <div class="blog-post clearfix">
        {assign var="foto_blog" value="{$post['NR_SEQ_BLOG_BLRC']}"}
        {assign var="extensao_blog" value="{$post['DS_EXT_BLRC']}"}
        {assign var="foto_completa_blog" value="{$foto_people}.{$extensao}"}
        <p class="cover-title ir">Blog</p>
        <a class="blog-image" href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}">
            {if file_exists("arquivos/uploads/produtos/$foto_completa_blog")}
                <img src="{$this->Url(['tipo'=>"produtos", 'crop'=>1, 'largura'=>220, 'altura'=>110, 'imagem'=>$foto_completa_blog],"imagem", TRUE)}" alt="{utf8_decode($post->DS_TITULO_BLRC)}"/>
            {else}
                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1, 'largura'=>220, 'altura'=>110, 'imagem'=>'not_found.jpg'],"imagem", TRUE)}" alt="{utf8_decode($post->DS_TITULO_BLRC)}"/>
            {/if}
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
                        <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>220,'altura'=>280,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}">
                    {else}
                        <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>220,'altura'=>280,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}">
                    {/if}
                </a>
            {/foreach}
    </div>
</div>

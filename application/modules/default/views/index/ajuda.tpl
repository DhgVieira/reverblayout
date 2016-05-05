<div class="banners-advertisement cycle-slideshow"
     data-cycle-fx="fadeout"
     data-cycle-timeout="5000"
     data-cycle-slides="> a"
     data-cycle-log="true"
     data-cycle-pause-on-hover="true" style="margin-bottom:10px;">
    {foreach from=$banners_topo item=banner}
        {assign var="foto" value="{$banner->NR_SEQ_BANNER_BARC}"}
        {assign var="extensao" value="{$banner->DS_EXT_BARC}"}
        {assign var="foto_completa" value="{$foto}.{$extensao}"}
        <a href="{$banner->DS_LINK_BARC}">
            {if file_exists("arquivos/uploads/banners/$foto_completa")}
                <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}" />
            {else}
                <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner->DS_DESCRICAO_BARC}" />
            {/if}
        </a>
    {/foreach}
</div>


<h1 class="rvb-title">Help </h1>
<div class="left-column-content">
<ul id="lista-help" class="posreflole">
    <li>
        <a href="#" class="open-help">1. Como Comprar?</a>
        <div class="conteudo-help">
            <span class="titulo">COMO COMPRAR?</span>

                Comprar na Reverbcity é uma experiência melhor do que frequentar um grande festival, porque não tem nenhuma fila e nada de lotação, aquu você aproveita o máximo da sua banda preferida. 

                Os produtos são facilmente encontrados no nosso menu na parte superior do site e você também pode encontram um item especifico no nosso campo de busca.


                Quando você encontrar o produto que deseja, basta clicar nele e verá todas as informações do item. O valor, preço do frete, a composição do tecido, a descrição do produto, a tabela de medidas e o prazo de entrega para sua região.<br><br>

                Nesta pagina você tem as principais informações do produto desejado, por isso preste bastante atenção nela. 

                Quando você decidir o que deseja comprar, clique no tamanho desejado e em comprar e então você será levado para página do seu pedido. Lá você pode escolher continuar comprando ou já ir para a parte final da sua compra.

                Ao confirmar que é realmente este objeto que você deseja, coloque seu frete para ser calculado o valor, escolha a forma de envio e vá em concluir compra.

                Caso você não esteja logado ou não tenha cadastro no site, será aberta a janela de login e cadastro.<br><br>

                É rapidinho e a gente promete proteger não deixar o Obama espionar seus dados.

                Depois você precisa conferir se é mesmo o endereço que você deseja que seja entregue ou seu gostaria de colocar outro local.

                Em seguida você escolhe a forma de pagamento, que pode ser por boleto ou cartão, e assim que selecionar será levado para um ambiente protegido para passar os dados e a gente poder confirmá-los com a operadora. Se você escolher pagar através do boleto, pode levar até 3 dias para o pagamento ser confirmado.


                Depois é só esperar, assim que sua compra for aprovada, a gente te manda um email avisando. Depois de enviarmos o seu pedido, mandaremos um email a cada movimentação dele feita pelos correios.<br><br>

                Qualquer dúvida, basta chamar!
 
                De segunda-sexta de 9:00-12:00 e 14:00-18:00
                (43) 3322-8852  
                 
                Estamos a sua disposição para esclarecer dúvidas, sugestões ou reclamações nesse horário. Ou se preferir, envie-nos um email para  <a href="mailto:atendimento@reverbcity.com" class="bg-soft">atendimento@reverbcity.com</a>.
 
        </div>
    </li>
    <li>
        <a href="#" class="open-help">2. Atendimento</a>
        <div class="conteudo-help">
            <span class="titulo">O QUE EU FAÇO CASO QUERIA ENTRAR EM CONTATO COM O ATENDIMENTO?</span>
            As solicitações devem ser direcionadas ao SAC Reverbcity pelo email  <a href="mailto:atendimento@reverbcity.com" class="bg-soft">atendimento@reverbcity.com</a> ou pelo telefone 43 3322-8852 de segunda a sexta das 8:30 as 17:30.<br><br>
        </div>
    </li>
    <li>
        <a href="#" class="open-help">3. Formas de Pagamento</a>
        <div class="conteudo-help">

            <span class="titulo">QUAIS AS FORMAS DE PAGAMENTOS DISPONÍVEIS NA REVERBCITY?</span>
                Boleto Bancário (para pagamento a vista)<br>
                Cartões de Crédito Visa - parcelamento em até 4x s/ juros <br>
                Cartões de Crédito Mastercard - parcelamento em até 4x s/ juros <br>
                <!-- Cartões de Crédito Diners -  parcelamento em até 4x s/ juros <br> --><br>

            <span class="titulo">PARCELAMENTOS NO CARTÃO</span>
                A partir de 50,00  - 2x sem juros<br>
                A partir de 100,00 - 3x sem juros<br>
                A partir de 150,00 - 4x sem juros<br><br>

            <span class="titulo">PAGAMENTOS COM BOLETO BANCÁRIO</span>
                Pagamentos com Boleto Bancário deverão ser pagos em bancos, caixas automáticos, casas lotéricas e apenas são aceitos pagamentos em dinheiro. Não é possível parcelar o Boleto Bancário. Pedidos não pagos até a data do boleto bancário serão cancelados automaticamente após a data de vencimento e, reabertos novamente somente gerando um novo boleto. O prazo de confirmação do boleto é de até 3 dias úteis.<br><br>

        </div>
    </li>
    <li>
        <a href="#" class="open-help">4. Entrega de Produtos</a>
        <div class="conteudo-help">
            <span class="titulo">QUAL A EMPRESA RESPONSÁVEL PELO ENVIO DOS PRODUTOS?</span>
                As empresas responsáveis pelo envio dos produtos da Reverbcity são os Correios (PAC e ESEDEX) e a TAM. A escolha da transportadora será feita no momento da compra.<br><br>

            <span class="titulo">COMO FUNCIONAM AS ENTREGAS?</span>
            O prazo de entrega começa a contar a partir da postagem do pedido nos correios, quando você recebe o código de rastreamento e prazos variam de acordo com a região.<br>
                1 a 2 dias úteis para as Capitais PR SC SP RJ MG<br>
                3 a 7 dias úteis para demais cidades do interior e todo o estado RS DF ES GO MS AL BA MT SE TO<br>
                7 a 12 dias úteis para todo o estado e capital do AM AC AP CE MA PA PB PE PI RN RO RR <br><br>

            <span class="titulo">QUAL O VALOR DE FRETE?</span>
               O cálculo do frete varia de acordo com a sua região e o peso do pedido. O valor é calculado automaticamente pelo nosso sistema no fechamento de sua compra, usando a tabela dos Correios e da TAM, empresas responsáveis pelas nossas entregas. <br><br>

            <span class="titulo">PRAZO DE ENTREGA?</span>
              
                Para verificar o prazo de entrega do seu CEP consulte "Prazo de Entrega" no nosso site. O prazo de entrega será contado após confirmação dos seus dados cadastrais e confirmação do pagamento, sendo que a análise de dados cadastrais poderá levar até um dia útil em pagamentos feitos com cartão e até 3 dias para pagamentos no boleto. <br><br>
            <span class="titulo">COMO FAÇO PARA ACOMPANHAR O MEU PEDIDO?</span>
              
                Para acompanhar o andamento de seu pedido junto ao transportador basta ir em “Minha Conta” no topo da página. Em seguida clique em "rastreamento de pedidos e colocar o código dos Correios que enviamos para o email cadastrado. Também enviamos no seu email cada passo do processo de entrega.  <br>

            <span class="titulo">AINDA NÃO RECEBI MINHA COMPRA :( </span>
              
                Caso o prazo de entrega informado na compra esteja expirado, por favor, entre em contato pelo  <a href="mailto:atendimento@reverbcity.com" class="bg-soft">atendimento@reverbcity.com</a>. Verificaremos junto ao nosso transportador, por qual motivo seu prazo foi comprometido, e retornaremos seu contato.  <br><br>
        </div>
    </li>

    <li>
        <a href="#" class="open-help">5. Politíca de Troca</a>
        <div class="conteudo-help">
            <span class="titulo">QUAL A POLÍTICA DE TROCAS DA REVERBCITY?</span>
                As trocas podem ser efetuadas em até 30 dias após recebimento, desde que o produto esteja em perfeito estado acompanhado da nota fiscal.
                Envie um e-mail para <a href="mailto:atendimento@reverbcity.com" class="post-link" >atendimento@reverbcity.com</a> informando a escolha para a troca, preencha o formulário de troca disponível <a href="{$basePath}/arquivos/download/Formulario_de_Troca.pdf" class="post-link" target="_blank">aqui</a> e envie para o endereço indicado.
            <br />
            <span class="titulo">PRODUTOS COM DEFEITO</span>
               Você possui até 30 dias corridos, após o recebimento do produto, para solicitar a troca ou devolução, desde que o mesmo não tenha sido usado.<br>

            <span class="titulo">FORMULÁRIO DE TROCA</span>
                <a href="{$basePath}/arquivos/download/Formulario_de_Troca.pdf" class="post-link" target="_blank">Baixe aqui!</a> <br />

            <span class="titulo">QUAIS AS FORMAS DE RESTITUIÇÃO DO PAGAMENTO?</span>
               Formas de restituição em caso de produtos com defeito ou desistência da compra.<br>
                Cupom de troca: Você poderá optar por um cupom de troca para comprar um item do mesmo valor (validade do cupom: 3 meses)<br>

                Estorno em cartão: Exclusivo para pedidos pagos em cartão de crédito. O prazo do estorno seguirá as regras da administradora do cartão. Poderá demorar o prazo de  uma  fatura para constar o crédito, dependendo da data de vencimento de sua fatura.<br>

                Reembolso em conta corrente: Para pedidos pagos em boleto, o valor da compra poderá ser reembolsado em uma conta corrente, de mesma titularidade do responsável pelo pedido (CPF idêntico).   <br />

        </div>
    </li>


    <li>
        <a href="#" class="open-help">6. Produtos fora de estoque</a>
        <div class="conteudo-help">
            <span class="titulo">QUERIA UMA CAMISA, MAS ELA ACABOU E AGORA?</span>
                Basta você entrar na estampa desejada, através do "avise-me" e deixar seu email no produto desejado, caso haja um número mínimo de interessados, a Reverbcity poderá fazer uma reposição deste estoque.<br><br>
        </div>
    </li>

    <li>
        <a href="#" class="open-help">7. Produtos em promoção e comprados no dia a dia</a>
        <div class="conteudo-help">
            <span class="titulo">PRODUTOS COMPRADOS DURANTE PROMOÇÕES E PRODUTO DO DIA</span>
            Para produtos adquiridos em promoção, caso seja necessária a troca e/ou devolução, o valor considerado será o pago pelo produto e não o seu valor original.<br>

            REVERBCITY | Música que Veste.<br>
            ANTONIO M. DIAS CONFECÇÕES |  CNPJ 08.345.875/0001-37 <br>
            Londrina | Rua Ibiporã, 995 - Jardim Aurora, PR 86060-510 – Fone: (43)3322-8852<br><br>
        </div>
    </li>

    <li>
        <a href="#" class="open-help">9. Frete grátis</a>
        <div class="conteudo-help">
            <span class="titulo">COMO ME ENCAIXO NO FRETE GRÁTIS?</span>
            Compras a partir de R$ 150,00 - inclusive em itens com desconto - ganham o frete para qualquer cidade do Brasil!
            <br />
        A Reverbcity se reserva ao direito de alterar/cancelar esta promoção conforme achar necessário e sem aviso prévio.
        </div>
    </li>

    <li>
        <a href="#" class="open-help">10. Como funciona a promoção de primeira compra?</a>
        <div class="conteudo-help">
            <span class="titulo">PROMOÇÃO DE PRIMEIRA COMPRA</span>
            Como presente de boas vindas na Reverbcity você ganha 15% de desconto ao finalizar o seu primeiro pedido, em até 30 dias após ter feito o cadastro. Caso a compra seja em um valor a partir de R$ 150,00 você também ganha o frete para qualquer cidade do Brasil.
            <br />
            A Reverbcity se reserva ao direito de alterar/cancelar esta promoção conforme achar necessário e sem aviso prévio.
        </div>
    </li>

    <li>
        <a href="#" class="open-help">11. Promoção de aniversário</a>
        <div class="conteudo-help">
            <span class="titulo">PROMOÇÃO DE ANIVERSÁRIO</span>
            Na primeira compra efetuada dentro mês do seu aniversário você ganha 15% de desconto ao finalizar o pedido. Caso ultrapasse os R$ 150,00 você também ganha o frete para todo Brasil.
            <br />
            A Reverbcity se reserva ao direito de alterar/cancelar esta promoção conforme achar necessário e sem aviso prévio.
        </div>
    </li> 

    <li>
        <a href="#" class="open-help">12. Alteração de dados cadastrais</a>
        <div class="conteudo-help">
            <span class="titulo">QUER ALTERAR OS SEUS DADOS?</span>
            1. Faça o login no site com seu email e senha (na parte superior da tela) <br />
            2. Vá na opção ao lado, onde está seu nome + Meu Perfil <br />
            3. Embaixo da imagem do seu profile tem a opção “Dados Cadastrais” <br />
            4. Altere seus dados e se vista de música! <br />
        </div>
    </li>

    <li>
        <a href="#" class="open-help">13. Frete grátis para Londrina</a>
        <div class="conteudo-help">
            <span class="titulo">FRETE GRÁTIS PARA LONDRINA?</span>
            Para você que é aqui de Londrina, em qualquer compra a partir de R$ 59,00, a gente entrega na sua casa sem custo nenhum.
            <br />
            <p>Caso queria vir buscar pessoalmente aqui, basta selecionar a opção “Retirar na Reverbcity” e efetuar o pagamento. Não será cobrado o frete e o seu pedido ficará reservado aqui na Reverbcity (Rua Ibiporã, 995 Jardim Aurora - Londrina, PR)</p>
            A Reverbcity se reserva ao direito de alterar/cancelar esta promoção conforme achar necessário e sem aviso prévio.
        </div>
    </li>
</ul>
</div>
<div class="sidebar-ui">
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
        {assign var="foto_blog" value="{$post->NR_SEQ_BLOG_BLRC}"}
        {assign var="extensao_blog" value="{$post->DS_EXT_BLRC}"}
        {assign var="foto_completa_blog" value="{$foto_blog}.{$extensao_blog}"}
        <p class="cover-title ir">Blog</p>
        <a class="blog-image" href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}">
            {if file_exists("arquivos/uploads/blog/$foto_completa_blog")}
                <img src="{$this->Url(['tipo'=>"blog", 'crop'=>1, 'largura'=>220, 'altura'=>110, 'imagem'=>$foto_completa_blog],"imagem", TRUE)}" alt="{$post->DS_TITULO_BLRC}"/>
            {else}
                <img src="..\arquivos\default\images\sem_foto_blog.jpg" alt="{$post->DS_TITULO_BLRC}" title="{$post->DS_TITULO_BLRC}" width="220" height="110"/>
            {/if}
        </a>
        <p class="blog-title">
            <a href="{$this->url(["titulo"=>{$this->createslug($post->DS_TITULO_BLRC)}, "idpost"=>{$post->NR_SEQ_BLOG_BLRC}], 'post', TRUE)}">{$post->DS_TITULO_BLRC|strip_tags}</a>
        </p>
        <p class="authoring">
          <span class="period">{$post->DT_PUBLICACAO_BLRC|date_format:'%Y/%m/%d'} ás {$post->DT_PUBLICACAO_BLRC|date_format:"%H:%M"}h</span>
          Por: <strong>Reverbcity</strong>
        </p>
        <p class="tiny-post">{$post->DS_TEXTO_BLRC|strip_tags|truncate:130:"...":true}</p>
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
                    <span class="title">{$forum->DS_TOPICO_TOSO|truncate:25:"...":TRUE}</span>
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
            {assign var="foto" value="{$banner['NR_SEQ_BANNER_BARC']}"}
            {assign var="extensao" value="{$banner['DS_EXT_BARC']}"}
            {assign var="foto_completa" value="{$foto}.{$extensao}"}
                <a href="{$banner['DS_LINK_BARC']}">
                    {if file_exists("arquivos/uploads/banners/$foto_completa")}
                        <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>220,'altura'=>280,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}">
                    {else}
                        <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>220,'altura'=>280,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}">
                    {/if}
                </a>
            {/foreach}
    </div>
</div>

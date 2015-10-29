<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset='utf-8'>
    <title>Camiseta de bandas de rock - Reverbcity.com</title>
    <meta name='description' content='Reverbcity é especializada em camisetas de bandas rock, camisetas de filmes, camisetas de series.'>
    <meta name='keywords' content='camisetas de bandas de rock, camisetas rock, camisetas personalizadas, camisetas indie'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="target-densitydpi=device-dpi, initial-scale=1.0, user-scalable=no" />
    <meta name="google-site-verification" content="b7mG7efOz0mZWg5oufxeOy5Fo9rn5Eeo2xz9YND4_RE" />
    <link rel="alternate" href="http://descontos.reverbcity.com" hreflang="pt-br"/>

    <!-- <script type="text/javascript" src="js/modernizr.js"></script> -->
    <script type="text/javascript" src="https://www.reverbcity.com/arquivos/landing/descontos/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://www.reverbcity.com/arquivos/landing/descontos/js/pace.js"></script>
    <script type="text/javascript" src="https://www.reverbcity.com/arquivos/landing/descontos/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="https://www.reverbcity.com/arquivos/landing/descontos/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="https://www.reverbcity.com/arquivos/landing/descontos/js/waypoints.min.js"></script>
    <script type="text/javascript" src="https://www.reverbcity.com/arquivos/landing/descontos/js/reverbcity.js"></script>

    <link rel="canonical" href="http://descontos.reverbcity.com" />

    <!--[if lt IE 9]>
    <script async src='http://html5shim.googlecode.com/svn/trunk/html5.js'></script>
    <![endif]-->

    <!-- Favicon and Apple Icons -->
    <link rel='icon' href='https://www.reverbcity.com/arquivos/landing/descontos/img/favicon.ico'>

</head>

<body>

<div class="site-content">

    <section class="top">
        <div>
            <h1 class="logo-top">
                <a href="https://www.reverbcity.com/inicio" title="Reverbcity">
                    Descontos ReverbCity
                </a>
            </h1>
            <div class="quotes animate">

                <div class="quote active" data-position="1">
                    <blockquote>
                        <p>
                            Reverbcity: especializada em <strong><a href="https://www.reverbcity.com/todos-produtos//7">camisetas de bandas rock</a></strong>, <strong><a href="https://www.reverbcity.com/todos-produtos//11">camisetas de filmes</a></strong> e <strong><a href="https://www.reverbcity.com/todos-produtos//178">camisetas de series</a></strong>.
                        </p>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>

    <section class="products">
        <div class="products-content">
            <div class="product">
                <div class="product-photos">
                    <img id="man-photo-1" class="active" src="https://www.reverbcity.com/arquivos/landing/descontos/images/produto_do_dia.png">
                </div>

                <div class="product-info">
                    <div class="price-label">
                        <span class="sym">R$</span>
                        <span class="price">{$_produto_dia->VL_PROMO_PRRC|number_format:2:",":"."}</span>
                    </div>
                </div>
                <div class="product-description">
                    <h2>Produto do dia</h2>
                    <div class="about">
                        <p>Todos os dias um item surpresa com um desconto imperdível aqui na <a href="https://www.reverbcity.com/inicio">Reverbcity</a>!</p>
                    </div>
                    {if $_produto_dia->NR_SEQ_TIPO_PRRC == 6}
                        {assign var=preTitle value='camiseta '}
                    {else}
                        {assign var=preTitle value=''}
                    {/if}

                    {assign var=ds_produto_prrc value=' - '|explode:$_produto_dia->DS_PRODUTO_PRRC}
                    {assign var=slug value="{$preTitle}{$ds_produto_prrc[0]}"}
                    <a rel="nofollow" href="https://www.reverbcity.com/produto/{$this->createslug($slug)}/{$_produto_dia->NR_SEQ_PRODUTO_PRRC}" data-message-id="message-order" class="button order-product">comprar</a>
                </div>
            </div>

            <div class="product">
                <div class="product-photos">
                    <img id="woman-photo-1" class="active" src="https://www.reverbcity.com/arquivos/landing/descontos/images/camiseta-v-de-vinganca.png">
                </div>
                <div class="product-info">
                    <div class="gender male"><i class="icon-male"></i><span>homem</span></div>
                    <div class="price-label">
                        <span class="sym">R$</span>
                        <span class="price">39</span>
                    </div>

                </div>

                <div class="product-description">
                    <h2>
                        <a href="https://www.reverbcity.com/produto/camiseta-v-de-vinganca/5258">
                            Camiseta V de Vingança
                        </a>
                    </h2>

                    <div class="about">
                        <div class="label">
                            Sobre
                            <a href="https://www.reverbcity.com/produto/camiseta-v-de-vinganca/5258">
                                Camiseta V de Vingança
                            </a>
                        </div>
                        <p>"V for Vendetta" é uma das obras primordiais dos quadrinhos escrita pelo bruxo Alan Moore, que acabou ganhando uma grande adaptação para as telonas. Guy Fawkes e sua explosão de subversão daquilo que o cinema entende por cultura pop acaba de ganhar esta camiseta da Reverbcity.</p>
                    </div>

                    <a rel="nofollow" href="https://www.reverbcity.com/produto/camiseta-v-de-vinganca/5258" data-message-id="message-order" class="button order-product">comprar</a>
                </div>
            </div>


            <div class="product">
                <div class="product-photos">
                    <img id="man-photo-3" class="active" src="https://www.reverbcity.com/arquivos/landing/descontos/images/camiseta-the-kooks.png">
                </div>

                <div class="product-info">
                    <div class="gender female"><i class="icon-female"></i><span>mulher</span></div>
                    <div class="price-label">
                        <span class="sym">R$</span>
                        <span class="price">39</span>
                    </div>
                </div>
                <div class="product-description">
                    <h2>
                        <a href="https://www.reverbcity.com/produto/camiseta-the-kooks/5688">
                            Camiseta The Kooks
                        </a>
                    </h2>
                    <div class="about">
                        <div class="label">
                            Sobre
                            <a href="https://www.reverbcity.com/produto/camiseta-the-kooks/5688">
                                Camiseta The Kooks
                            </a>
                        </div>
                        <p>The Kooks é energético e viciante, com um otimismo juvenil que conseguiu mesclar o rock inglês dos anos 60 com o britpop dos 90. As músicas atrativas e aparentemente despretensiosas, não são nada "inocentes", pois mostram uma banda madura e preparada para os grandes hits. </p>
                    </div>
                    <a rel="nofollow" href="https://www.reverbcity.com/produto/camiseta-the-kooks/5688" data-message-id="message-order" class="button order-product">comprar</a>
                </div>
            </div>




            <div class="product">
                <div class="product-photos">
                    <img id="man-photo-4" class="active" src="https://www.reverbcity.com/arquivos/landing/descontos/images/camiseta-u2.png">
                </div>

                <div class="product-info">
                    <div class="gender male"><i class="icon-male"></i><span>homem</span></div>
                    <div class="price-label">
                        <span class="sym">R$</span>
                        <span class="price">34,50</span>
                    </div>
                </div>
                <div class="product-description">
                    <h2>
                        <a href="https://www.reverbcity.com/produto/camiseta-u2/5677">
                            Camiseta U2
                        </a>
                    </h2>
                    <div class="about">
                        <div class="label">
                            Sobre
                            <a href="https://www.reverbcity.com/produto/camiseta-u2/5677">
                                Camiseta U2
                            </a>
                        </div>
                        <p>O U2 conseguiu transformar as tragédias do cotidiano em canções de protesto, que não nos deixam fechar os olhos e fingir que nada aconteceu, além de empolgar o U2 nos faz pensar. Mostre de que lado você está, vista a camiseta do U2 e erga a cabeça.</p>
                    </div>
                    <a rel="nofollow" href="https://www.reverbcity.com/produto/camiseta-u2/5677" data-message-id="message-order" class="button order-product">comprar</a>
                </div>
            </div>


            <div class="product">
                <div class="product-photos">
                    <img id="man-photo-4" class="active" src="https://www.reverbcity.com/arquivos/landing/descontos/images/camiseta-muse.png">
                </div>

                <div class="product-info">
                    <div class="gender female"><i class="icon-female"></i><span>mulher</span></div>
                    <div class="price-label">
                        <span class="sym">R$</span>
                        <span class="price">39</span>
                    </div>
                </div>
                <div class="product-description">
                    <h2>
                        <a href="https://www.reverbcity.com/produto/camiseta-muse/5645">
                            Camiseta Muse
                        </a>
                    </h2>
                    <div class="about">
                        <div class="label">
                            Sobre
                            <a href="https://www.reverbcity.com/produto/camiseta-muse/5645">
                                Camiseta Muse
                            </a>
                        </div>
                        <p>Estampa com cara de protesto, assim como é o single Uprising, como a própria banda disse à Revista Mojo em Julho de 2009: "Tem coro de futebol, com todos nós cantando ‘oi’ junto com o som da caixa de bateria. Era para ser estilo coro de hooligans em protesto às situações dos bancários."</p>
                    </div>
                    <a rel="nofollow" href="https://www.reverbcity.com/produto/camiseta-muse/5645" data-message-id="message-order" class="button order-product">comprar</a>
                </div>
            </div>

            <div class="product">
                <div class="product-photos">
                    <img id="man-photo-4" class="active" src="https://www.reverbcity.com/arquivos/landing/descontos/images/camiseta-madmen.png">
                </div>

                <div class="product-info">
                    <div class="gender female"><i class="icon-female"></i><span>mulher</span></div>
                    <div class="price-label">
                        <span class="sym">R$</span>
                        <span class="price">19,90</span>
                    </div>
                </div>
                <div class="product-description">
                    <h2>
                        <a href="https://www.reverbcity.com/produto/camiseta-mad-men/5603">
                            Camiseta Madmen
                        </a>
                    </h2>
                    <div class="about">
                        <div class="label">Sobre
                            <a href="https://www.reverbcity.com/produto/camiseta-mad-men/5603">
                                Camiseta Madmen
                            </a>
                        </div>
                        <p>Sexo casual, incorreção política e principalmente muitos drinks e cigarros fazem parte do universo de Mad Men. Não importa o que você é ou o que quer, mas sim como você se vende. A série se passa na agência Sterling Cooper, que fica na Madison Avenue, em Nova York. Em uma época em que a  proibição do fumo e as políticas contra o assédio sexual eram impensáveis, restava apreciar drinks e vestir a camiseta.</p>
                    </div>
                    <a rel="nofollow" href="https://www.reverbcity.com/produto/camiseta-mad-men/5603" data-message-id="message-order" class="button order-product">comprar</a>
                </div>
            </div>

        </div>
    </section>

    <section class="newsletter">
        <div>
            <a rel="nofollow" href="https://www.reverbcity.com/inicio" class="button">ver mais</a>
            <img src="https://www.reverbcity.com/arquivos/landing/descontos/img/seta.png" />
        </div>
    </section>

    <footer>
        <div>
            <div class="text">
                <img class="logo-bottom" src="https://www.reverbcity.com/arquivos/landing/descontos/img/logo.png">
                <p>© 2015, Reverbcity. All rights reserved.</p>
            </div>
        </div>
    </footer>

</div>
{literal}
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-38700671-1', 'auto');
        ga('require', 'displayfeatures');
        ga('require', 'ecommerce');
        ga('require', 'linkid', 'linkid.js');
        ga('send', 'pageview');

    </script>
{/literal}
</body>
</html>
<link href='https://www.reverbcity.com/arquivos/landing/descontos/css/pace.css' rel='stylesheet' >
<link href='https://www.reverbcity.com/arquivos/landing/descontos/css/styles.css' rel='stylesheet' >
<link href='https://www.reverbcity.com/arquivos/landing/descontos/css/jquery.mCustomScrollbar.css' rel='stylesheet' >
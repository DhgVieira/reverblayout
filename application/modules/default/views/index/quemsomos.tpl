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

<h1 class="rvb-title">Quem <span>Somos</span></h1>
<div class="rvb-fundoverde">
    <p id="quemsomos-frase-bonitinha">
        <strong>A gente deseja fazer parte das boas coisas que você vive e escuta, por isso estamos sempre criando modelos e silks originais que tenham a ver com sua atitude, sua playlist e sua banda favorita!</strong>
    </p>
    <p id="quemsomos-enderecos">
        Loja on-line @ www.reverbcity.com  <br>
        Matriz Londrina @ Rua Ibiporã, 995 (Londrina, PR)
    </p>
    <ul id="rvb-staff">
        <li id="staff-tony">
            <div class="flip-container">
                <div class="flipper">
                    {*<div class="front">*}
                        {*<img src="{$basePath}/arquivos/default/images/quem-somos/tony.png" alt="Foto de Tony - Boss da Reverbcity">*}
                    {*</div>*}
                    <div class="front">
                        <h2 class="who"><a href="{$basePath}/perfil/tony-strauss/2" target="_blank">Tony</a></h2>
                        <p class="overview">Depois de 6 anos vivendo no <br>
                        Japão, Tony Strauss voltou para <br>
                        o Brasil trazendo na bagagem o<br>
                        sonho de criar um selo independente <br>
                        e as 154 camisetas dos shows que<br>
                        havia assistido por lá. O destino se<br>
                        encarregou de mostrar-lhe um outro<br>
                        caminho. Em 2004, o indie de <br>
                        Londrina que nasceu apaixonado por<br>
                        boa música, concebeu a Reverbcity.<br>
                        A marca, como seu criador, tam-<br>
                        bém veio ao mundo com <br>
                        um mote musical.</p>
                    </div>
                </div>
            </div>
        </li>
        <li id="staff-gabi">
            <div class="flip-container">
                <div class="flipper">
                    {*<<div class="front">*}
                        {*<img src="{$basePath}/arquivos/default/images/quem-somos/marcio.png" alt="Foto de Marcio - Mídias sociais da Reverbcity">*}
                    {*</div>*}
                    <div class="front">
                        <h2 class="who"><a href="{$basePath}/perfil/marcio-araujo/4162" target="_blank">Marcio</a></h2>
                        <p class="overview">Nasceu em Rolândia e <br>
                            passou a infância rolando em <br>
                            pneu de trator. Bebe além da <br>
                            conta, escuta Belle and Sebastian, <br>
                            mas não beija rapazes por isso. Até <br>
                            hoje adora dizer que não sabe ao <br>
                            certo como definir sua função na <br>
                            Reverb e a gente deixa ele <br>
                            achar que cuida somente <br>
                            das mídias da empresa.</p>
                    </div>
                </div>
            </div>
        </li>
        {*<li id="staff-jana">*}
            {*<div class="flip-container">*}
                {*<div class="flipper">*}
                    {*<div class="front">*}
                        {*<img src="{$basePath}/arquivos/default/images/quem-somos/jana.png" alt="Foto de Janaína - Logística da Reverbcity">*}
                    {*</div>*}
                    {*<div class="back">*}
                        {*<h2 class="who"><a href="{$basePath}/perfil/janaina-dias/10470" target="_blank">Jana</a></h2>*}
                        {*<p class="overview">O seu pedido está demorando?<br>*}
                        {*A balinha de brinde não foi?<br>*}
                        {*A culpa é dela: JANAINA.<br>*}
                        {*Responsável pela distribuição global<br>*}
                        {*das lindezas produzidas pela<br>*}
                        {*Reverbcity, ela é quem embala seu<br>*}
                        {*pedido com todo carinho do<br>*}
                        {*mundo e faz com que ela<br>*}
                        {*chegue rapidinho até você.</p>*}
                    {*</div>*}
                {*</div>*}
            {*</div>*}
        {*</li>*}

        {*<li id="staff-miria">*}
            {*<div class="flip-container">*}
                {*<div class="flipper">*}
                    {*<div class="front">*}
                        {*<img src="{$basePath}/arquivos/default/images/quem-somos/toy-menina.png" alt="Foto de Reverbtoy - Mascote Reverbcity">*}
                    {*</div>*}
                    {*<div class="back">*}
                        {*<h2 class="who"><a href="#">Toy</a></h2>*}
                        {*<p class="overview">*}
                            {*Todas as letras das boas músicas escritas <br />*}
                            {*até hoje se juntaram em milhões de folhas <br />*}
                            {*de papeis e se condensaram no nosso Reverbtoy. Ele leva a boa música para todos os lugares, garantido que ela nunca acabe.*}
                        {*</p>*}
                    {*</div>*}
                {*</div>*}
            {*</div>*}
        {*</li>*}
        {*<li id="staff-rose">*}
            {*<div class="flip-container">*}
                {*<div class="flipper">*}
                    {*<div class="front">*}
                        {*<img src="{$basePath}/arquivos/default/images/quem-somos/rose.png" alt="Foto de Rose - Administrativo da Reverbcity">*}
                    {*</div>*}
                    {*<div class="back">*}
                        {*<h2 class="who"><a href="{$basePath}/perfil/rosilene-cardoso/26087" target="blank">Rose</a></h2>*}
                        {*<p class="overview">Essa chocólatra é só<br>*}
                        {*"um pouquinho" distraída e <br>*}
                        {*nossa cozinha sofre quando ela se <br>*}
                        {*arrisca a se aventurar a fazer café.<br>*}
                        {*Mas quando o assunto é a parte <br>*}
                        {*administrativa da Reverb, ela não <br>*}
                        {*vacila nadinha. Entre planilhas do <br>*}
                        {*excel e ligações pro contador, ela <br>*}
                        {*dá um jeito de colocar tudo <br>*}
                        {*nos trilhos!</p>*}
                    {*</div>*}
                {*</div>*}
            {*</div>*}
        {*</li>*}
        {*<li id="staff-gustavo">*}
            {*<div class="flip-container">*}
                {*<div class="flipper">*}
                    {*<div class="front">*}
                        {*<img src="{$basePath}/arquivos/default/images/quem-somos/jana.png" alt="Foto de Janaína - Logística da Reverbcity">*}
                    {*</div>*}
                    {*<div class="back">*}
                        {*<h2 class="who"><a href="{$basePath}/perfil/janaina-dias/10470" target="_blank">Jana</a></h2>*}
                        {*<p class="overview">O seu pedido está demorando?<br>*}
                            {*A balinha de brinde não foi?<br>*}
                            {*A culpa é dela: JANAINA.<br>*}
                            {*Responsável pela distribuição global<br>*}
                            {*das lindezas produzidas pela<br>*}
                            {*Reverbcity, ela é quem embala seu<br>*}
                            {*pedido com todo carinho do<br>*}
                            {*mundo e faz com que ela<br>*}
                            {*chegue rapidinho até você.</p>*}
                    {*</div>*}
                {*</div>*}
            {*</div>*}
        {*</li>*}
        <li id="staff-caio">
            <div class="flip-container">
                <div class="flipper">
                    {*<div class="front">*}
                        {*<img src="{$basePath}/arquivos/default/images/quem-somos/rose.png" alt="Foto de Rose - Administrativo da Reverbcity">*}
                    {*</div>*}
                    <div class="front">
                        <h2 class="who"><a href="{$basePath}/perfil/rosilene-cardoso/26087" target="blank">ANNAI</a></h2>
                        <p class="overview">Essa chocólatra é só<br>
                            "um pouquinho" distraída e <br>
                            nossa cozinha sofre quando ela se <br>
                            arrisca a se aventurar a fazer café.<br>
                            Mas quando o assunto é a parte <br>
                            administrativa da Reverb, ela não <br>
                            vacila nadinha. Entre planilhas do <br>
                            excel e ligações pro contador, ela <br>
                            dá um jeito de colocar tudo <br>
                            nos trilhos!</p>
                    </div>
                </div>
            </div>
        </li>
        <li id="staff-diego">
            <div class="flip-container">
                <div class="flipper">
                    {*<div class="front">*}
                        {*<img src="{$basePath}/arquivos/default/images/quem-somos/miria.png" alt="Foto de Miriã - SAC da Reverbcity">*}
                    {*</div>*}
                    <div class="front">
                        <h2 class="who"><a href="{$basePath}/perfil/miria-atendimento-reverbcity/22652" target="_blank">mimi</a></h2>
                        <p class="overview">Um bom atendimento de SAC vai <br>
                            muito além de ser bem-educado, é <br>
                            uma busca por surpreender o <br>
                            nossos cliente todos os dias. Isso se <br>
                            resume o trabalho da Miriã no <br>
                            office da Reverb em Londrina.</p>
                    </div>
                </div>
            </div>
        </li>
        <li id="staff-marcio">
            <div class="flip-container">
                <div class="flipper">
                    {*<div class="front">*}
                        {*<img src="{$basePath}/arquivos/default/images/quem-somos/jonatas.png" alt="Foto de Jonatas - Moda na Reverbcity">*}
                    {*</div>*}
                    <div class="front">
                        <h2 class="who"><a href="{$basePath}perfil/jonatas-g--itiyama/356432" target="_blank">Jonatas</a></h2></br>
                        <p class="overview">Elvis - Morrissey - Depeche mode<br>
                            Moda e comportamento - Fotografia <br>
                            Não necessariamente nesta ordem. </p>
                    </div>
                </div>
            </div>
        </li>
        <li id="staff-lorem">
            <div class="flip-container">
                <div class="flipper">
                    {*<div class="front">*}
                        {*<img src="{$basePath}/arquivos/default/images/quem-somos/jana.png" alt="Foto de Janaína - Logística da Reverbcity">*}
                    {*</div>*}
                    <div class="front">
                        <h2 class="who"><a href="{$basePath}/perfil/janaina-dias/10470" target="_blank">Jana</a></h2>
                        <p class="overview">O seu pedido está demorando?<br>
                            A balinha de brinde não foi?<br>
                            A culpa é dela: JANAINA.<br>
                            Responsável pela distribuição global<br>
                            das lindezas produzidas pela<br>
                            Reverbcity, ela é quem embala seu<br>
                            pedido com todo carinho do<br>
                            mundo e faz com que ela<br>
                            chegue rapidinho até você.</p>
                    </div>
                </div>
            </div>
        </li>
        <li id="staff-ipsum">
            <div class="flip-container">
                <div class="flipper">
                    {*<div class="front">*}
                        {*<img src="{$basePath}/arquivos/default/images/quem-somos/toy-menina.png" alt="Foto de Reverbtoy - Mascote Reverbcity">*}
                    {*</div>*}
                    <div class="front">
                        <h2 class="who"><a href="#">Toy</a></h2>
                        <p class="overview">
                            Todas as letras das boas músicas escritas <br />
                            até hoje se juntaram em milhões de folhas <br />
                            de papeis e se condensaram no nosso Reverbtoy. Ele leva a boa música para todos os lugares, garantido que ela nunca acabe.
                        </p>
                    </div>
                </div>
            </div>
        </li>
        {*<li id="staff-chloe">*}
            {*<div class="flip-container">*}
                {*<div class="flipper">*}
                    {*<div class="front">*}
                        {*<img src="{$basePath}/arquivos/default/images/quem-somos/toy-menina.png" alt="Foto de Reverbtoy - Mascote Reverbcity">*}
                    {*</div>*}
                    {*<div class="back">*}
                        {*<h2 class="who"><a href="#">Toy</a></h2>*}
                        {*<p class="overview">*}
                            {*Todas as letras das boas músicas escritas <br />*}
                            {*até hoje se juntaram em milhões de folhas <br />*}
                            {*de papeis e se condensaram no nosso Reverbtoy. Ele leva a boa música para todos os lugares, garantido que ela nunca acabe.*}
                        {*</p>*}
                    {*</div>*}
                {*</div>*}
            {*</div>*}
        {*</li>*}
    </ul>
</div>

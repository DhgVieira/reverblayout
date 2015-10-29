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
        <a rel="nofollow" href="{$banner['DS_LINK_BARC']}">
            {if file_exists("arquivos/uploads/banners/$foto_completa")}
              <img src="{$this->Url(['tipo'=>"banners", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>$foto_completa],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}"/>
            {else}
              <img src="{$this->Url(['tipo'=>"error", 'crop'=>1,'largura'=>940,'altura'=>40,'imagem'=>'not_found.jpg'],'imagem', TRUE)}" alt="{$banner['DS_DESCRICAO_BARC']}"/>
            {/if}
        </a>
    {/foreach}
</div>

<h1 class="rvb-title">Reverb <span>Contato</span></h1>

<div class="left-col">
    <p class="full-strip">Fale Conosco</p>
    <form action="{$this->url([], 'contato', TRUE)}" id="form-contato" method="post">
        <p class="legend">Sugestões, críticas, elogios e perguntas... Seja lá o que for, mande seu recado por aqui.</p>
         {if $_logado eq 1}
            <div class="input-text margin">
                <input type="text" name="nome" id="nome-contato" placeholder="Nome completo" value="{$nome}" required>
            </div>
            <div class="input-text">
                <input type="email" name="email" id="email-contato" placeholder="E-mail"  value="{$email}" required>
            </div>
            <div class="select-item estado margin">
                <span>Estado</span>
                <select class="select-field" name="estado" id="estado">
                    <option  value="{$uf}" selected>{$uf}</option>
                </select>
            </div>
            <div class="select-item cidade">
                <span>Cidade</span>
                <select class="select-field" name="cidade" id="cidade">
                    <option  value="{$cidade}" selected>{$cidade}</option>
                </select>
            </div>
        {else}
            <div class="input-text margin">
                <input type="text" name="nome" id="nome-contato" placeholder="Nome completo" required>
            </div>
            <div class="input-text">
                <input type="email" name="email" id="email-contato" placeholder="E-mail" required>
            </div>
            <div class="select-item estado margin">
                <span>Estado</span>
                <select class="select-field" name="estado" id="estado"></select>
            </div>
            <div class="select-item cidade">
                <span>Cidade</span>
                <select class="select-field" name="cidade" id="cidade"></select>
            </div>
        {/if}
        <div class="text-box">
            <textarea name="content-message" id="mensagem" cols="1" rows="5" placeholder="Aqui vai o comentário" required></textarea>
        </div>
        <div class="insert-captcha">
            <label for="contato-captcha-code">
                <img src="{$basePath}/arquivos/uploads/captcha/{$this->idCaptcha}.png" alt="captcha" heigth="45" width="115">
               <!--  <input class="input-box" type="text" id="contato-captcha-code" name="captcha"> -->
                <input name="captcha[input]" type="text" class="input-box" maxlength="3" title="Digite os caracteres da imagem" id="contato-captcha-code">
                  <input id="captcha" name="captcha[id]" value="{$this->idCaptcha}" type="hidden">
            </label>

        </div>
        <div class="send-button">
            <button type="submit" class="btn">Enviar</button>
        </div>

        <div class="clearfix"></div>
    </form>
</div>

<div class="right-col">
    <p class="full-strip">SAC</p>
    <a rel="nofollow" href="mailto:atendimento@reverbcity.com" class="bg-soft">atendimento@reverbcity.com</a>

    <p class="full-strip">Atacado</p>
    <a rel="nofollow" href="mailto:atendimento@reverbcity.com" class="bg-soft">atendimento@reverbcity.com</a>

    <p class="full-strip">Imprensa</p>
    <a rel="nofollow" href="mailto:marcio@reverbcity.com" class="bg-soft">marcio@reverbcity.com</a>

    <p class="full-strip">Social</p>
    <ul class="socials-network-dark">
    <li><a rel="nofollow" href="https://www.facebook.com/Reverbcity" target="_blank" class="icon facebook ir">Facebook</a></li>
    <li><a rel="nofollow" href="https://twitter.com/reverbcity" target="_blank" class="icon twitter ir">Twitter</a></li>
    <li><a rel="nofollow" href="http://reverbcity.tumblr.com/" target="_blank" class="icon tumblr ir">Tumblr</a></li>
    <li><a rel="nofollow" href="http://instagram.com/reverbcity" target="_blank" class="icon instagram ir">Instagram</a></li>
    <li><a rel="nofollow" href="http://pinterest.com/reverbcity/" target="_blank" class="icon pinterest ir">Pinterest</a></li>
    <li class="last"><a rel="nofollow" href="https://plus.google.com/+reverbcity/posts" target="_blank" class="icon rss ir">Google Plus</a></li>
    </ul>
</div>

<div class="full-strip">
    <p><strong>Londrina</strong> | Rua Ibiporã, 995 - Jd Aurora, PR 86060-510 – Fone: <a href="tel:4333228852">(43) 3322-8852</a> - Combine a retirada no office pelo chat e ganhe o frete grátis</p>
</div>

<div id="reverb-londrina" class="contato-gallery">
    <div class="left-col">
        <div class="current-photo">
            <img class="contato-thumb" src="{$basePath}/arquivos/default/images/contato/exemplo1.jpg" alt="Foto da Loja da Reverbcity">
        </div>
    </div>

    <div class="right-col">
        <a rel="nofollow" href="{$basePath}/arquivos/default/images/contato/exemplo1.jpg" class="contato-thumb left-thumb">
            <img src="{$basePath}/arquivos/default/images/contato/exemplo1-thumb.jpg" alt="Foto da Loja da Reverbcity">
        </a>
        <a rel="nofollow" href="{$basePath}/arquivos/default/images/contato/exemplo2.jpg" class="contato-thumb">
            <img src="{$basePath}/arquivos/default/images/contato/exemplo2-thumb.jpg" alt="Foto da Loja da Reverbcity">
        </a>
        <a rel="nofollow" href="{$basePath}/arquivos/default/images/contato/exemplo3.jpg" class="contato-thumb left-thumb nomargin-bottom">
            <img src="{$basePath}/arquivos/default/images/contato/exemplo3-thumb.jpg" alt="Foto da Loja da Reverbcity">
        </a>
        <a rel="nofollow" href="{$basePath}/arquivos/default/images/contato/exemplo4.jpg" class="contato-thumb">
            <img src="{$basePath}/arquivos/default/images/contato/exemplo4-thumb.jpg" alt="Foto da Loja da Reverbcity">
        </a>
    </div>
</div>



<!-- <div class="full-strip">
    <p><strong>São Paulo</strong> | Pocket Store - Rua Augusta, 2690 loja 114 (Galeria Ouro Fino) – Fone: <a href="tel:11 30613218">(11) 3061-3218</a> - CEP 01413-000 - Seg/Sáb 10h as 19h</p>
</div> -->

<!-- <div id="reverb-pocketstore" class="contato-gallery">
    <div class="left-col">
        <div class="current-photo">
            <img class="contato-thumb" src="{$basePath}/arquivos/default/images/contato/exemplo1.jpg" alt="Foto da Loja da Reverbcity">
        </div>
    </div>

    <div class="right-col">
        <a href="{$basePath}/arquivos/default/images/contato/exemplo1.jpg" class="contato-thumb left-thumb">
            <img src="{$basePath}/arquivos/default/images/contato/exemplo1-thumb.jpg" alt="Foto da Loja da Reverbcity">
        </a>
        <a href="{$basePath}/arquivos/default/images/contato/exemplo2.jpg" class="contato-thumb">
            <img src="{$basePath}/arquivos/default/images/contato/exemplo2-thumb.jpg" alt="Foto da Loja da Reverbcity">
        </a>
        <a href="{$basePath}/arquivos/default/images/contato/exemplo3.jpg" class="contato-thumb left-thumb nomargin-bottom">
            <img src="{$basePath}/arquivos/default/images/contato/exemplo3-thumb.jpg" alt="Foto da Loja da Reverbcity">
        </a>
        <a href="{$basePath}/arquivos/default/images/contato/exemplo4.jpg" class="contato-thumb">
            <img src="{$basePath}/arquivos/default/images/contato/exemplo4-thumb.jpg" alt="Foto da Loja da Reverbcity">
        </a>
    </div>
</div> -->
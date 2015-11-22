{if $_logado eq 1}
<div class="ja-logado">
   <a rel="nofollow" href="{$this->url([], 'reverbmedetalhe')}">Você já está logado!</br> Ir para o seu perfil.</a>
</div>
{else}
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
                <input id="staylogged" type="checkbox" name="manter_logado" value="1"> Permanecer logado
            </label>
        </div>
    </form>
{/if}
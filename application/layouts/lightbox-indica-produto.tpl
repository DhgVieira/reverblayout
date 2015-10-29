<div class="md-modal md-effect-1" id="indique-lightbox">
    <div class="md-content">
        <p class="md-title">INDIQUE PARA UM AMIGO</p>
        <button class="md-close ir">Fechar</button>
        <div>
            <div id="in">

                <p>
                    Coisas boas a gente compartilha com os amigos! Que tal indicar essa peça para aquele seu melhor amigo poder ter também?
                </p>

                <form action="{$this->url([],"indiqueproduto", TRUE)}" id="indique-form" method="POST">

                    <div class="md-bg">

                        <input class="field field-left" type="text" name="Nome" placeholder="Seu nome">

                        <input class="field field-right" type="text" name="Email" placeholder="Seu e-mail">

                        <input class="field field-left" type="text" name="NomeAmigo" placeholder="Nome do seu amigo">

                        <input class="field field-right" type="text" name="EmailAmigo" placeholder="E-mail do seu amigo">

                        <input type="hidden" name="idproduto" value="{$produto->NR_SEQ_PRODUTO_PRRC}" />

                        <input type="hidden" name="extensao" value="{$produto->DS_EXT_PRRC}" />

                        <input  type="hidden" name="nome_produto" value="{$produto->DS_PRODUTO_PRRC}" />

                        <textarea placeholder="Envie uma mensagem personalizada..." name="mensagem"></textarea>

                    </div>

                    <div class="send-button">
                        <button class="btn" type="submit">Enviar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

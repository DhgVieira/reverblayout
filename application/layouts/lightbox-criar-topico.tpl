<!-- lightbox criar tópico -->
<div class="md-modal md-effect-1" id="criar-topico-lightbox">
    <div class="md-content">
        <p class="md-title">Criar Tópico</p>
        <button class="md-close ir">Fechar</button>
        <form action="{$this->url([], "criarforum", TRUE)}" method="post" id="frm-create-topic">
            <div class="frm-bg">
                <div class="frm-field">
                    <label for="forum-titulo">Título</label>
                    <input id="forum-titulo" name="titulo" type="text" required>
                </div>
                <div class="frm-field">
                    <label for="forum-post">Mensagem</label>
                    <textarea name="mensagem" id="forum-post" placeholder="Escreva uma mensagem..." required></textarea>
                </div>
            </div>
            <div class="frm-text">
                <p>Você vai criar um tópico pedindo a camiseta de alguma banda? Tem certeza? Olha que já temos um tópico especifico só pra isso, não precisa ser egoísta! Antes de “Aceitar e Criar” tenha certeza que não está ofendendo nenhum amiguinho e também cuidado com o português, por aqui não temos opção de editar.</p>
            </div>
            <div class="send-button">
                <button class="btn" type="submit">Aceitar e criar</button>
            </div>
        </form>
    </div>
</div>
<div class="md-overlay"></div>

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

    <section>
        <h1>Reverb<span>Forum</span></h1>

        <div class="data-title red"><span>Musica do dia</span></div>

        <div class="data-content">
            <a href="" class="btn back">Voltar aos tópicos</a>
        </div>

        <div class="data-content">
            <form>
                <label for="title">Título</label>

                <input type="text" name="titulo" id="title" class="field" />

                <textarea name="topico" placeholder="Escreva aqui seu texto e/ou seus vídeos, fotos, url, etc..." class="field"></textarea>

                <div class="btns">
                    <button type="submit" class="btn btn-make">Criar</button>
                </div>
            </form>
        </div>

        <div class="data-content post-scope">
            <div class="user">
                <a href="" class="image"><img src="http://dummyimage.com/80x100/aaa/fff" width="80" height="100" alt="Lorem ipsum" /></a>

                <div class="name">Lorem</div>

                <div class="description">Lorem ipsum dolor sit amet.</div>
            </div>

            <div class="post">
                <div class="controls">
                    <a href="" class="btn"><span class="icon audio"></span> +3 Reverberou</a> | <a href="" class="btn"><span class="icon audio"></span> -</a> | <a href="" class="btn btn-commentary"><span class="icon active-commentary"></span></a> <span class="time"><span class="separator">|</span> <time datetime="2013-03-27 13:15">27/03/2013 13:15</time></span>
                </div>

                <div class="content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi, qui, beatae praesentium numquam ipsa deserunt dolorum nisi eveniet illum voluptate porro necessitatibus facere distinctio hic omnis mollitia impedit odio magnam reprehenderit saepe tempora dolore officia ut iure repellendus dolores ipsum rem a quae inventore. Iste labore asperiores porro provident deleniti.</div>

                <ul class="commentaries">
                    <li>
                        <div class="commentary-name">Lorem ipsum</div>

                        <div class="controls">
                            <a href="" class="btn"><span class="icon audio"></span> +3 Reverberou</a> | <a href="" class="btn"><span class="icon audio"></span> -</a> | <a href="" class="btn btn-commentary"><span class="icon active-commentary"></span></a> <span class="time"><span class="separator">|</span> <time datetime="2013-03-27 13:15">27/03/2013 13:15</time></span>
                        </div>

                        <div class="commentary">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, vero id sed dolores quos est error quo minus reprehenderit voluptatibus.</div>
                    </li>

                    <li>
                        <div class="commentary-name">Lorem ipsum</div>

                        <div class="controls">
                            <a href="" class="btn"><span class="icon audio"></span> +3 Reverberou</a> | <a href="" class="btn"><span class="icon audio"></span> -</a> | <a href="" class="btn btn-commentary"><span class="icon active-commentary"></span></a> <span class="time"><span class="separator">|</span> <time datetime="2013-03-27 13:15">27/03/2013 13:15</time></span>
                        </div>

                        <div class="commentary">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, vero id sed dolores quos est error quo minus reprehenderit voluptatibus.</div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="data-content post-scope">
            <div class="user">
                <a href="" class="image"><img src="http://dummyimage.com/80x100/aaa/fff" width="80" height="100" alt="Lorem ipsum" /></a>

                <div class="name">Lorem</div>

                <div class="description">Lorem ipsum dolor sit amet.</div>
            </div>

            <div class="post">
                <div class="controls">
                    <a href="" class="btn"><span class="icon audio"></span> +3 Reverberou</a> | <a href="" class="btn"><span class="icon audio"></span> -</a> | <a href="" class="btn btn-commentary"><span class="icon active-commentary"></span></a> <span class="time"><span class="separator">|</span> <time datetime="2013-03-27 13:15">27/03/2013 13:15</time></span>
                </div>

                <div class="content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi, qui, beatae praesentium numquam ipsa deserunt dolorum nisi eveniet illum voluptate porro necessitatibus facere distinctio hic omnis mollitia impedit odio magnam reprehenderit saepe tempora dolore officia ut iure repellendus dolores ipsum rem a quae inventore. Iste labore asperiores porro provident deleniti.</div>

                <ul class="commentaries">
                    <li>
                        <div class="commentary-name">Lorem ipsum</div>

                        <div class="controls">
                            <a href="" class="btn"><span class="icon audio"></span> +3 Reverberou</a> | <a href="" class="btn"><span class="icon audio"></span> -</a> | <a href="" class="btn btn-commentary"><span class="icon active-commentary"></span></a> <span class="time"><span class="separator">|</span> <time datetime="2013-03-27 13:15">27/03/2013 13:15</time></span>
                        </div>

                        <div class="commentary">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, vero id sed dolores quos est error quo minus reprehenderit voluptatibus.</div>
                    </li>

                    <li>
                        <div class="commentary-name">Lorem ipsum</div>

                        <div class="controls">
                            <a href="" class="btn"><span class="icon audio"></span> +3 Reverberou</a> | <a href="" class="btn"><span class="icon audio"></span> -</a> | <a href="" class="btn btn-commentary"><span class="icon active-commentary"></span></a> <span class="time"><span class="separator">|</span> <time datetime="2013-03-27 13:15">27/03/2013 13:15</time></span>
                        </div>

                        <div class="commentary">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, vero id sed dolores quos est error quo minus reprehenderit voluptatibus.</div>
                    </li>

                    <li>
                        <div class="commentary-name">Lorem ipsum</div>

                        <div class="controls">
                            <a href="" class="btn"><span class="icon audio"></span> +3 Reverberou</a> | <a href="" class="btn"><span class="icon audio"></span> -</a> | <a href="" class="btn btn-commentary"><span class="icon active-commentary"></span></a> <span class="time"><span class="separator">|</span> <time datetime="2013-03-27 13:15">27/03/2013 13:15</time></span>
                        </div>

                        <div class="commentary">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, vero id sed dolores quos est error quo minus reprehenderit voluptatibus.</div>
                    </li>
                </ul>

                <div class="comment">
                    <form>
                        <textarea name="comentario" class="field" placeholder="escreva aqui seu comentário"></textarea>

                        <div class="btns">
                            <button class="btn btn-make">Comente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="pagination">
            <ul>
                <li class="active"><a href="">1</a></li>

                <li><a href="">2</a></li>

                <li><a href="">3</a></li>
            </ul>
        </div>
    </section>

    <div class="row other-products">
        <div class="row-section sujestions">
            <h2><span>Sugestões</span></h2>

            <ul class="thumbnails">
                <li>
                    <div class="thumbnail">
                        <a href=""><img src="http://dummyimage.com/171x190/aaa/fff" width="171" height="190" alt="Lorem ipsum" /></a>

                        <div class="caption">
                            <h3>Lorem ipsum dolor</h3>

                            <p>R$ 99,99</p>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="thumbnail">
                        <a href=""><img src="http://dummyimage.com/171x190/aaa/fff" width="171" height="190" alt="Lorem ipsum" /></a>

                        <div class="caption">
                            <h3>Lorem ipsum dolor</h3>

                            <p>R$ 99,99</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="row-section products-viewed">
            <h2><span>Produtos vistos</span></h2>

            <ul class="thumbnails">
                <li>
                    <div class="thumbnail">
                        <a href=""><img src="http://dummyimage.com/171x190/aaa/fff" width="171" height="190" alt="Lorem ipsum" /></a>

                        <div class="caption">
                            <h3>Lorem ipsum dolor</h3>

                            <p>R$ 99,99</p>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="thumbnail">
                        <a href=""><img src="http://dummyimage.com/171x190/aaa/fff" width="171" height="190" alt="Lorem ipsum" /></a>

                        <div class="caption">
                            <h3>Lorem ipsum dolor</h3>

                            <p>R$ 99,99</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="row-section featured-product">
            <h2><span>Produto do dia</span></h2>

            <ul class="thumbnails">
                <li>
                    <div class="thumbnail">
                        <a href=""><img src="http://dummyimage.com/171x190/aaa/fff" width="171" height="190" alt="Lorem ipsum" /></a>

                        <div class="caption">
                            <h3>Lorem ipsum dolor</h3>

                            <p>R$ 99,99</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

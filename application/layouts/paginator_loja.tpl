{if $previous}
    <li class="item">
        <a rel="nofollow" title="Página Anterior" href="{$this->url(["module"=>"default", 'slug' => $this->createslug($categoria_nome), "controller"=>"loja", "action"=>"{$acaoAtual}", "page"=>{$previous}, "categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}">◄</a>
    </li>
{/if}
        
    {foreach from=$pagesInRange item=page}
        <li class="item">
            <a rel="nofollow" href="{$this->url(["module"=>"default","controller"=>"loja", 'slug' => $this->createslug($categoria_nome),  "action"=>"{$acaoAtual}", "page"=>$page, "categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}"  {if $page == $this->current} class="active" {/if}>
               
                {$page}
            </a>
        </li>
    {/foreach}
{if $next}
    <li class="item">
        <a rel="nofollow" title="Página Anterior" href="{$this->url(["module"=>"default", 'slug' => $this->createslug($categoria_nome), "controller"=>"loja", "action"=>"{$acaoAtual}", "page"=>{$next}, "categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}">►</a>
    </li>
{/if}
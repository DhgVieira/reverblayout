{if $previous}
    <link rel="prev" href="https://www.reverbcity.com{$this->url(["module"=>"default", 'slug' => $this->createslug($categoria_nome), "controller"=>"loja", "action"=>"{$acaoAtual}", "page"=>{$previous}, "categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}"/>
{/if}
{if $next}
    <link rel="next" href="https://www.reverbcity.com{$this->url(["module"=>"default", 'slug' => $this->createslug($categoria_nome), "controller"=>"loja", "action"=>"{$acaoAtual}", "page"=>{$next}, "categoria"=>{$cat_url}, "tamanho"=>{$tamanho_url}, "genero"=>{$genero}, "cor"=>{$cor_url}, "tipo"=>{$tipo_url}, "valor"=>{$valor_url}], "{$acaoAtual}", TRUE)}"/>
{/if}

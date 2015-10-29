{if $previous}
    <li class="item">
        <a title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"reverbcycle", "action"=>"index", "page"=>{$previous}, "idcategoria" => {$idcategoria}], "reverbcycle", TRUE)}">◄</a>
    </li>
{/if}
        
    {foreach from=$pagesInRange item=page}
        <li class="item">
            <a href="{$this->url(["module"=>"default","controller"=>"reverbcycle",  "action"=>"index", "page"=>$page, "idcategoria"=>{$idcategoria}], 'reverbcycle', TRUE)}"  {if $page == $this->current} class="atual" {/if}>
               
                {$page}
            </a>
        </li>
    {/foreach}
{if $next}
    <li class="item">
        <a title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"reverbcycle", "action"=>"index", "page"=>{$next}, "idcategoria"=>{$idcategoria}], "reverbcycle", TRUE)}">►</a>
    </li>
{/if}
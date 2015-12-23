{if $previous}
    <li class="item">
        <a title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"people", "action"=>"index", "page"=>{$previous}], "people", TRUE)}">◄</a>
    </li>
{/if}
        
    {foreach from=$pagesInRange item=page}
        <li class="item">
            <a href="{$this->url(["module"=>"default","controller"=>"people",  "action"=>"index", "page"=>$page], 'people', TRUE)}"  {if $page == $this->current} class="atual" {/if}>
               
                {$page}
            </a>
        </li>
    {/foreach}
{if $next}
    <li class="item">
        <a title="Página Anterior" href="{$this->url(["module"=>"default", "controller"=>"people", "action"=>"index", "page"=>{$next}], "people", TRUE)}" class="next">►</a>
    </li>
{/if}